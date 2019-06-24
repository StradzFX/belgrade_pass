<?php

class BirthdayReservationsModule{
	public static function get_list($selected_date,$filters,$company=null){
		global $broker;

		$day_of_week = date('N',strtotime($selected_date));

		$company_birthday_data_all = new company_birthday_data();
		$company_birthday_data_all->set_condition('checker','!=','');
		$company_birthday_data_all->add_condition('recordStatus','=','O');


		if($filters['location'] != ''){
			$filter_location = explode(',', $filters['location']);
			if(sizeof($filter_location) == 1){
				$company_birthday_data_all->add_condition('ts_location','IN',"(SELECT id FROM ts_location WHERE city = '".$filter_location[0]."')");
			}

			if(sizeof($filter_location) == 2){
				$company_birthday_data_all->add_condition('ts_location','IN',"(SELECT id FROM ts_location WHERE city = '".$filter_location[0]."' AND part_of_city = '".$filter_location[1]."')");
			}
			
		}

		if($filters['number_of_kids'] != ''){
			$company_birthday_data_all->add_condition('max_kids','>',$filters['number_of_kids']);
		}

		if($filters['number_of_adults'] != ''){
			$company_birthday_data_all->add_condition('max_adults','>',$filters['number_of_adults']);
		}

		if($filters['garden'] == 1){
			$company_birthday_data_all->add_condition('garden','=',1);
		}

		if($filters['catering'] == 1){
			$company_birthday_data_all->add_condition('catering','=',1);
		}

		if($filters['animators'] == 1){
			$company_birthday_data_all->add_condition('animators','=',1);
		}

		if($filters['smoking'] == 1){
			$company_birthday_data_all->add_condition('smoking','=',1);
		}

		if($filters['watching_kids'] == 1){
			$company_birthday_data_all->add_condition('watching_kids','=',1);
		}

		$company_birthday_data_all->set_order_by('training_school','ASC');
		$company_birthday_data_all->add_order_by('ts_location','ASC');
		$company_birthday_data_all = $broker->get_all_data_condition($company_birthday_data_all);

		$company_list = array();

		for ($i=0; $i < sizeof($company_birthday_data_all); $i++) { 

			$company_birthday_data_all[$i]->training_school = $broker->get_data(new training_school($company_birthday_data_all[$i]->training_school));
			$company_birthday_data_all[$i]->ts_location = $broker->get_data(new ts_location($company_birthday_data_all[$i]->ts_location));
			$company_birthday_data_all[$i]->name = $company_birthday_data_all[$i]->name != '' ? ' - '.$company_birthday_data_all[$i]->name : $company_birthday_data_all[$i]->name;
			$location_name = $company_birthday_data_all[$i]->training_school->name . ' / ' . $company_birthday_data_all[$i]->ts_location->street .$company_birthday_data_all[$i]->name;

			$company = array();
			$location = array(
				'max_kids' => $company_birthday_data_all[$i]->max_kids,
				'max_adults' => $company_birthday_data_all[$i]->max_adults,
				'garden' => $company_birthday_data_all[$i]->garden,
				'smoking' => $company_birthday_data_all[$i]->smoking,
				'catering' => $company_birthday_data_all[$i]->catering,
				'animators' => $company_birthday_data_all[$i]->animators,
				'watching_kids' => $company_birthday_data_all[$i]->watching_kids
			);
			$company['data'] = array(
				'id' => $company_birthday_data_all[$i]->id,
				'location_name' =>  $location_name,
				'location' => $location
			);

			$ce = new company_events();
			$ce->set_condition('checker','!=','');
			$ce->add_condition('recordStatus','=','O');
			$ce->add_condition('ts_location','=',$company_birthday_data_all[$i]->ts_location->id);
			$ce->add_condition('event_type','!=','opened_event');
			$ce->add_condition('event_date','=',$selected_date);
			$ce->set_order_by('pozicija','DESC');
			$ce = $broker->get_all_data_condition($ce);

			for ($z=0; $z < sizeof($ce); $z++) { 
				$ce[$z]->time_from = $ce[$z]->event_horus_from * 60 + $ce[$z]->event_minutes_from;
				$ce[$z]->time_to = $ce[$z]->event_hours_to * 60 + $ce[$z]->event_minutes_to;
			}



			$company_location_birthday_slots_all = new company_location_birthday_slots();
			$company_location_birthday_slots_all->set_condition('checker','!=','');
			$company_location_birthday_slots_all->add_condition('recordStatus','=','O');
			$company_location_birthday_slots_all->add_condition('day_of_week','=',$day_of_week);
			$company_location_birthday_slots_all->add_condition('company_birthday_data','=',$company_birthday_data_all[$i]->id);
			$company_location_birthday_slots_all->set_order_by('hours_from','ASC');
			$company_location_birthday_slots_all = $broker->get_all_data_condition($company_location_birthday_slots_all);



			if(sizeof($company_location_birthday_slots_all) > 0){

				$slots = array();

				for ($j=0; $j < sizeof($company_location_birthday_slots_all); $j++) { 
					$slot = array();

					$slot['id'] = $company_location_birthday_slots_all[$j]->id;
					$slot['price'] = $company_location_birthday_slots_all[$j]->price;
					$slot['hours_from'] = $company_location_birthday_slots_all[$j]->hours_from;
					$slot['minutes_from'] = $company_location_birthday_slots_all[$j]->minutes_from;

					$slot['time_from'] = $slot['hours_from'] * 60 + $slot['minutes_from'];

					$slot['hours_to'] = $company_location_birthday_slots_all[$j]->hours_to;
					$slot['minutes_to'] = $company_location_birthday_slots_all[$j]->minutes_to;

					$slot['time_to'] = $slot['hours_to'] * 60 + $slot['minutes_to'];


					$slot['hours_from'] = $slot['hours_from'] < 10 ? '0'.$slot['hours_from'] : $slot['hours_from'];
					$slot['minutes_from'] = $slot['minutes_from'] < 10 ? '0'.$slot['minutes_from'] : $slot['minutes_from'];
					$slot['hours_to'] = $slot['hours_to'] < 10 ? '0'.$slot['hours_to'] : $slot['hours_to'];
					$slot['minutes_to'] = $slot['minutes_to'] < 10 ? '0'.$slot['minutes_to'] : $slot['minutes_to'];

					$slot['time'] = $slot['hours_from'].':'.$slot['minutes_from'].' - '.$slot['hours_to'].':'.$slot['minutes_to'];

					$slot['price'] = number_format($slot['price'],'0',',','.');



					$valid_slot = true;

					for ($z=0; $z < sizeof($ce); $z++) { 
						if($slot['time_to'] > $ce[$z]->time_from){
							if($slot['time_from'] < $ce[$z]->time_to){
								$valid_slot = false;
							}
						}else{
							if($slot['time_from'] < $ce[$z]->time_to){
								if($slot['time_to'] > $ce[$z]->time_from){
									$valid_slot = false;
								}
							}
						}
					}

					if($valid_slot){
						$slots[] = $slot;
					}
				}

				if(sizeof($slots) > 0){
					$company['slots'] = $slots;
					$company_list[] = $company;
				}
			}
		}

		return $company_list;
	}
}
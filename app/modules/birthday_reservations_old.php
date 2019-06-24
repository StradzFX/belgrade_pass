<?php

class BirthdayReservationsOldModule{

	public static $date_range_shift = array(
		'-3 days',
		'-2 days',
		'-1 day',
		'',
		'+1 day',
		'+2 days',
		'+3 days',
	);

	public static $date_range_shift_small = array(
		''
	);

	public static $week_days = array(
		'1' => 'Ponedeljak',
		'2' => 'Utorak',
		'3' => 'Sreda',
		'4' => 'Četvrtak',
		'5' => 'Petak',
		'6' => 'Subota',
		'7' => 'Nedelja',
	);

	public static function get_date_ranges($selected_date,$company=null){
		global $broker;


		$date_range = array();
		if($company){
			$date_range_shift_sample = self::$date_range_shift;
		}else{
			$date_range_shift_sample = self::$date_range_shift_small;
		}
		

		for ($i=0; $i < sizeof($date_range_shift_sample); $i++) { 
			$date = array();
			$date['shift'] = $date_range_shift_sample[$i];
			if($date['shift']){
				$date['date'] = date('Y-m-d',strtotime($date['shift'],strtotime($selected_date)));
			}else{
				$date['date'] = $selected_date;
			}
			$date['display_date'] = date('d.m.Y.',strtotime($date['date']));
			$date['date_name'] = self::$week_days[date('N',strtotime($date['date']))];
			$date_range[] = $date;
		}

		return $date_range;
	}

	public static function get_time_table($selected_date,$company=null,$exclude_company=null){
		global $broker;

		return self::get_locations($selected_date,$company,$exclude_company);
	}

	private static function get_locations($selected_date,$company=null,$exclude_company=null){
		global $broker;

		$locations = array();

		$ts_location_all = new company_birthday_data();
		$ts_location_all->set_condition('checker','!=','');
		$ts_location_all->add_condition('recordStatus','=','O');
		$ts_location_all->add_condition('training_school','IN',"(SELECT id FROM training_school WHERE recordStatus = 'O' AND checker != '' AND birthday_options = 1)");
		if($exclude_company){
			$ts_location_all->add_condition('training_school','!=',$exclude_company);
		}

		if($company){
			$ts_location_all->add_condition('training_school','=',$company);
		}

		$ts_location_all->set_order_by('training_school','DESC');
		$ts_location_all->add_order_by('pozicija','DESC');
		$ts_location_all = $broker->get_all_data_condition($ts_location_all);

		for($j=0;$j<sizeof($ts_location_all);$j++){

			$location = array();

			$location['location_id'] = $ts_location_all[$j]->ts_location;
			$ts_location_all[$j]->ts_location = $broker->get_data(new ts_location($ts_location_all[$j]->ts_location));
			$location['location_name'] = $ts_location_all[$j]->ts_location->street;

			$location['company_id'] = $ts_location_all[$j]->training_school;
			$ts_location_all[$j]->training_school = $broker->get_data(new training_school($ts_location_all[$j]->training_school));
			$location['company_name'] = $ts_location_all[$j]->training_school->name;

			$location['min_time'] = 23;
			$location['max_time'] = 0;

			$location['date_ranges'] = self::get_date_ranges($selected_date,$company);

			for ($i=0; $i < sizeof($location['date_ranges']); $i++) { 
				$location['date_ranges'][$i]['working_time'] = self::get_location_working_time($ts_location_all[$j]->ts_location->id,$location['date_ranges'][$i]['date']);
				
				if(!$location['date_ranges'][$i]['working_time']){
					$location['date_ranges'][$i]['working_time'] = self::get_default_working_time();
				}

				if($location['min_time'] > $location['date_ranges'][$i]['working_time']['start_hours']){
					$location['min_time'] = $location['date_ranges'][$i]['working_time']['start_hours'];
				}

				if($location['max_time'] < $location['date_ranges'][$i]['working_time']['end_hours']){
					$location['max_time'] = $location['date_ranges'][$i]['working_time']['end_hours'];
				}
			}

			if($location['min_time'] > 0){
				$location['min_time']--;
			}

			if($location['max_time'] < 24){
				$location['max_time']++;
			}

			for ($i=0; $i < sizeof($location['date_ranges']); $i++) { 
				$busy_times = self::get_busy_times($ts_location_all[$j]->ts_location->id,$location['date_ranges'][$i]['date']);

				$number_of_free_slots = 0;
				$date_blocks = array();
				$block_step = 30;
				for ($b_hi=$location['min_time']; $b_hi < $location['max_time']; $b_hi++) { 
					for ($b_mi=0; $b_mi < 60; $b_mi+=$block_step) { 
						$block = array();
						$block['start_time'] = $b_hi * 60 + $b_mi;
						$block['end_time'] = $b_hi * 60 + $b_mi + $block_step;
						$block['end_time_reservation'] = $block['end_time'] + 2 * 60;
						$block['hours'] = $b_hi;
						$block['minutes'] = $b_mi;
						$block['hours_display'] = $block['hours'] < 10 ? '0'.$block['hours'] : $block['hours'];
						$block['minutes_display'] = $block['minutes'] < 10 ? '0'.$block['minutes'] : $block['minutes'];
						$block['time_display'] = $block['hours_display'].':'.$block['minutes_display'];

						$block['status_class'] = '';

						if($block['start_time'] < $location['date_ranges'][$i]['working_time']['end_time']){
							if($block['end_time'] > $location['date_ranges'][$i]['working_time']['start_time']){
								$block['status_class'] = 'working';

								foreach ($busy_times as $busy_time) {
									if($block['start_time'] >= $busy_time['from'] && $block['start_time'] <= $busy_time['to']){
										$block['status_class'] = 'busy';
									}else{
										if($block['start_time'] + 5*30 >= $location['date_ranges'][$i]['working_time']['end_time']){
											$block['status_class'] = 'no_reservation';
										}
									}

									if($block['start_time'] >= $busy_time['no_reservation_from'] && $block['start_time'] <= $busy_time['no_reservation_to']){
										$block['status_class'] = 'no_reservation';
									}

									
								}
							}
						}

						if($block['status_class'] == 'working'){
							$block['action'] = "onclick=\"set_reservation_time('".$ts_location_all[$j]->ts_location->id."','".$location['date_ranges'][$i]['date']."','".$block['hours']."','".$block['minutes']."');\"";
						}
						


						$date_blocks[] = $block;
					}
				}

				$location['blocks'] = $date_blocks;
			}
			$locations[] = $location;
		}


		return $locations;
	}

	private static function get_busy_times($location_id,$selected_date){
		global $broker;

		$company_events_all = new company_events();
		$company_events_all->set_condition('checker','!=','');
		$company_events_all->add_condition('recordStatus','=','O');
		$company_events_all->add_condition('event_type','!=','opened_event');
		$company_events_all->add_condition('ts_location','=',$location_id);
		$company_events_all->add_condition('event_date','=',$selected_date);
		$company_events_all->set_order_by('pozicija','DESC');
		$company_events_all = $broker->get_all_data_condition($company_events_all);

		$event_blocks = array();

		for($i=0;$i<sizeof($company_events_all);$i++){
			$event_from = $company_events_all[$i]->event_horus_from * 60 + $company_events_all[$i]->event_minutes_from;
			$event_to = $company_events_all[$i]->event_hours_to * 60 + $company_events_all[$i]->event_minutes_to;
			$event = array(
				'from' => $event_from,
				'to' => $event_to,
				'no_reservation_from' => $event_from - 3 * 30,
				'no_reservation_to' => $event_from
			);
			$event_blocks[] = $event;
		}

		return $event_blocks;
	}

	private static function get_location_working_time($location_id,$selected_date){

		global $broker;

		$day_of_week = date('N',strtotime($selected_date));
		$working_times_all = new working_times();
		$working_times_all->set_condition('checker','!=','');
		$working_times_all->add_condition('recordStatus','=','O');
		$working_times_all->add_condition('ts_location','=',$location_id);
		$working_times_all->add_condition('day_of_week','=',$day_of_week);
		$working_times_all->set_order_by('pozicija','DESC');
		$working_times_all = $broker->get_all_data_condition($working_times_all);


		if(sizeof($working_times_all) > 0){
			$working_times = $working_times_all[0];
			$wt = array();
			$wt['not_working'] = $working_times->not_working == 1;
			$wt['start_hours'] = $working_times->working_from_hours;
			$wt['start_minutes'] = $working_times->working_from_minutes;
			$wt['end_hours'] = $working_times->working_to_hours;
			$wt['end_minutes'] = $working_times->working_to_minutes;
			$wt['start_time'] = $wt['start_hours'] * 60 + $wt['start_minutes'];
			$wt['end_time'] = $wt['end_hours'] * 60 + $wt['end_minutes'];
			return $wt;
		}else{
			return null;
		}
	}

	private static function get_default_working_time(){
		$wt = array();
		$wt['not_working'] = true;
		$wt['start_hours'] = 9;
		$wt['start_minutes'] = 0;
		$wt['end_hours'] = 21;
		$wt['end_minutes'] = 0;
		$wt['start_time'] = $wt['start_hours'] * 60 + $wt['start_minutes'];
		$wt['end_time'] = $wt['end_hours'] * 60 + $wt['end_minutes'];
		return $wt;
	}
}
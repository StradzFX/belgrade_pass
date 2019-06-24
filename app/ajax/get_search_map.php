<?php
global $broker;
$post_data = $_POST;
$filters = $post_data['filters'];

$list = SchoolLocationModule::list_map($filters);

for ($i=0; $i < sizeof($list); $i++) {
	$sport_category_all = new sport_category();
	$sport_category_all->set_condition('checker','!=','');
	$sport_category_all->add_condition('recordStatus','=','O');
	$sport_category_all->add_condition('id','IN',"(SELECT DISTINCT category FROM company_category WHERE company = ".$list[$i]->school->id." AND recordStatus = 'O')");
	$sport_category_all->set_order_by('pozicija','DESC');
	$list[$i]->categories =  $broker->get_all_data_condition($sport_category_all);

}

$marker_list = array();

$current_time = date('H')*60+date('m');
$current_day_of_week = date('N');

for ($i=0; $i < sizeof($list); $i++) { 

	$working_day_marker = $base_url.'public/images/working_times/100.png';

	$working_times_all = new working_times();
	$working_times_all->set_condition('checker','!=','');
	$working_times_all->add_condition('recordStatus','=','O');
	$working_times_all->add_condition('day_of_week','=',$current_day_of_week);
	$working_times_all->add_condition('ts_location','=',$list[$i]->id);
	$working_times_all->set_order_by('pozicija','DESC');
	$working_times_all = $broker->get_all_data_condition($working_times_all);

	if(sizeof($working_times_all) > 0){
		$working_time = $working_times_all[0];
		$working_time_from = $working_time->working_from_hours*60 + $working_time->working_from_minutes;
		$working_time_to = $working_time->working_to_hours*60 + $working_time->working_to_minutes;

		if($current_time > $working_time_from){
			$working_time_from = $current_time;
		}

		$available_working_time = $working_time_to - $working_time_from;

		$company_events_all = new company_events();
		$company_events_all->set_condition('checker','!=','');
		$company_events_all->add_condition('recordStatus','=','O');
		$company_events_all->add_condition('ts_location','=',$list[$i]->id);
		$company_events_all->add_condition('event_date','=',date('Y-m-d'));
		$company_events_all->add_condition('event_type','!=','opened_event');
		$company_events_all->set_order_by('pozicija','DESC');
		$company_events_all = $broker->get_all_data_condition($company_events_all);

		$busy_company_time = 0;
		for($j=0;$j<sizeof($company_events_all);$j++){
			$busy_time_from = $company_events_all[$j]->event_horus_from*60 + $company_events_all[$j]->event_minutes_from;
			$busy_time_to = $company_events_all[$j]->event_hours_to*60 + $company_events_all[$j]->event_minutes_to;

			if($current_time > $busy_time_from){
				$busy_time_from = $current_time;
			}

			$busy_time = $busy_time_to - $busy_time_from;
			$busy_company_time += $busy_time;
		}

		$available_percentage = 100 - ceil(($busy_company_time/$available_working_time)*100);

		if($available_percentage > 95){
			$working_day_marker = $base_url.'public/images/working_times/100.png';
		}else{
			if($available_percentage > 60){
				$working_day_marker = $base_url.'public/images/working_times/75.png';
			}else{
				if($available_percentage > 40){
					$working_day_marker = $base_url.'public/images/working_times/50.png';
				}else{
					if($available_percentage > 10){
						$working_day_marker = $base_url.'public/images/working_times/25.png';
					}else{
						$working_day_marker = $base_url.'public/images/working_times/0.png';
					}
				}
			}
		}
	}

	$marker_list[] = array(
		$list[$i]->latitude,
		$list[$i]->longitude,
		$working_day_marker,
		$list[$i]->school->name,
		$list[$i]->school->short_description,
		$list[$i]->school->link,
		file_get_contents('public/images/icons/'.$list[$i]->categories[0]->logo),
		file_get_contents('public/images/blanko_pin.svg'),
		file_get_contents('public/images/cluster_icon.svg'),
		$list[$i]->school->thumb,
		$list[$i]->street,
		
	);
}



echo json_encode(array('marker_list'=>$marker_list));
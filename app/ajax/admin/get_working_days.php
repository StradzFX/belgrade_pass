<?php
$id = $post_data['data']['id'];

global $broker;

$success = false;
$message = 'Function for save is not implemented.';

$working_times_all = new working_times();
$working_times_all->set_condition('checker','!=','');
$working_times_all->add_condition('recordStatus','=','O');
$working_times_all->add_condition('ts_location','=',$id);
$working_times_all->set_order_by('pozicija','DESC');
$working_times_all = $broker->get_all_data_condition($working_times_all);

$working_days = array();

for($i=0;$i<sizeof($working_times_all);$i++){
	$working_day = array();

	$working_day['day_of_week'] = (int)$working_times_all[$i]->day_of_week;
	$working_day['not_working'] = (bool)($working_times_all[$i]->not_working == 1);
	$working_day['working_from_hours'] = $working_times_all[$i]->working_from_hours;
	$working_day['working_from_minutes'] = $working_times_all[$i]->working_from_minutes;
	$working_day['working_to_hours'] = $working_times_all[$i]->working_to_hours;
	$working_day['working_to_minutes'] = $working_times_all[$i]->working_to_minutes;

	$working_days[] = $working_day;
}


echo json_encode(array("working_days"=>$working_days));
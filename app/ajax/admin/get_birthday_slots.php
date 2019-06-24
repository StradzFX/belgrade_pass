<?php
global $broker;
$data = $post_data['data'];

$success = false;
$message = 'Post was made';
$error_message = null;

$SQL = "SELECT DISTINCT day_of_week FROM company_location_birthday_slots WHERE company_birthday_data = ".$data['id'];
$week_days_db = $broker->execute_sql_get_array($SQL);

$week_days = array();
for ($i=0; $i < sizeof($week_days_db); $i++) { 
	$week_day = array();
	$week_day['id'] = $week_days_db[$i]['day_of_week'];

	$clbs = new company_location_birthday_slots();
	$clbs->set_condition('checker','!=','');
	$clbs->add_condition('recordStatus','=','O');
	$clbs->add_condition('day_of_week','=',$week_day['id']);
	$clbs->add_condition('company_birthday_data','=',$data['id']);
	$clbs->set_order_by('pozicija','DESC');
	$clbs = $broker->get_all_data_condition($clbs);

	$slots = array();

	for($j=0;$j<sizeof($clbs);$j++){
		$slot = array(
			'price' => $clbs[$j]->price,
			'hours_from' => $clbs[$j]->hours_from,
			'minutes_from' => $clbs[$j]->minutes_from,
			'hours_to' => $clbs[$j]->hours_to,
			'minutes_to' => $clbs[$j]->minutes_to
		);

		$slots[] = $slot;
	}

	$week_day['slots'] = $slots;
	$week_days[] = $week_day;

}





echo json_encode(array("success"=>$success,"slots"=>$week_days));
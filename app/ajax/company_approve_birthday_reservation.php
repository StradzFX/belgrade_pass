<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$data = $post_data['data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}

if($validation_message == ""){

	$cbr = $broker->get_data(new company_birthday_reservation($data['id']));
	$cbd = $broker->get_data(new company_birthday_data($cbr->company_birthday_data));

	$SQL = "UPDATE company_birthday_reservation SET status = 'approved' WHERE id = ".$cbr->id;
	$broker->execute_query($SQL);

	$company_events = new company_events();
    $company_events->training_school = $cbr->training_school;
    $company_events->event_date = $cbr->birthday_date;
    $company_events->event_time_from = time();
    $company_events->event_time_to = time();
    $company_events->event_type = 'closed_event';
    $company_events->event_name = 'Rođendan';
    $company_events->event_horus_from = $cbr->birthday_from_hours;
    $company_events->event_hours_to = $cbr->birthday_to_hours;
    $company_events->event_minutes_from = $cbr->birthday_from_minutes;
    $company_events->event_minutes_to = $cbr->birthday_to_minutes;
    $company_events->ts_location = $cbr->ts_location;
    $company_events->company_birthday_data = $cbd->id;
    $company_events->company_location_birthday_slots = $cbr->company_location_birthday_slots;
    $company_events->event_global_type = 'birthday';
    $company_events->maker = 'system';
    $company_events->makerDate = date('c');
    $company_events->checker = 'system';
    $company_events->checkerDate = date('c');
    $company_events->jezik = 'rs';
    $company_events->recordStatus = 'O';
    
    $company_events = $broker->insert($company_events);
	

	$success = true;
	$message = 'All ok';
}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
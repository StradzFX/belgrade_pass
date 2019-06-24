<?php

$success = false;
$message = "POST was made";
global $broker;

$event_data = $_POST['event_data'];


if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$company = $broker->get_session('company');

$validation_message = "";
if(!$company){$validation_message = "Niste ulogovani";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}

if($event_data["event_global_type"] == 'birthday'){
    if($event_data["event_name"] == ""){$validation_message = "Molimo Vas da unesete naziv termina.";}
    if($event_data["event_type"] == ""){$validation_message = "Molimo Vas da odaberete tip događaja.";}
    if($event_data["event_b_slot"] == ""){$validation_message = "Molimo Vas da odaberete vreme događaja.";}

    $clbs = $broker->get_data(new company_location_birthday_slots($event_data["event_b_slot"]));
    $event_data["event_horus_from"] = $clbs->hours_from;
    $event_data["event_minutes_from"] = $clbs->minutes_from;
    $event_data["event_hours_to"] = $clbs->hours_to;
    $event_data["event_minutes_to"] = $clbs->minutes_to;
}

if($event_data["event_global_type"] == 'free'){
    if($event_data["event_name"] == ""){$validation_message = "Molimo Vas da unesete naziv termina.";}
    if($event_data["event_type"] == ""){$validation_message = "Molimo Vas da odaberete tip događaja.";}
    if($event_data["event_horus_from"] == ""){$validation_message = "Not valid event_horus_from";}
    if($event_data["event_minutes_from"] == ""){$validation_message = "Not valid event_minutes_from";}
    if($event_data["event_hours_to"] == ""){$validation_message = "Not valid event_hours_to";}
    if($event_data["event_minutes_to"] == ""){$validation_message = "Not valid event_minutes_to";}

    $event_data["event_b_slot"] = 0;
}



$event_data['event_time_from'] = time();
$event_data['event_time_to'] = time();

if($validation_message == ""){
	$success = true;
	$message = "All OK";
    if($event_data['event_id'] == 0){
        $company_events = new company_events();
        $company_events->maker = 'system';
        $company_events->makerDate = date('c');
    }else{
        $company_events = $broker->get_data(new company_events($event_data['event_id']));
    }
	
    $company_events->training_school = $company->id;
    $company_events->ts_location = $company->location->id;
    $company_events->event_date = $event_data['event_date'];
    $company_events->event_time_from = $event_data['event_time_from'];
    $company_events->event_time_to = $event_data['event_time_to'];
    $company_events->event_type = $event_data['event_type'];
    $company_events->event_name = $event_data['event_name'];
    $company_events->event_horus_from = $event_data['event_horus_from'];
    $company_events->event_hours_to = $event_data['event_hours_to'];
    $company_events->event_minutes_from = $event_data['event_minutes_from'];
    $company_events->event_minutes_to = $event_data['event_minutes_to'];

    $company_events->event_global_type = $event_data['event_global_type'];
    $company_events->company_birthday_data = $event_data['event_b_data'];
    $company_events->company_location_birthday_slots = $event_data['event_b_slot'];

    $company_events->checker = 'system';
    $company_events->checkerDate = date('c');
    $company_events->jezik = 'rs';
    $company_events->recordStatus = 'O';
    
    

    if($event_data['event_id'] == 0){
        $company_events = $broker->insert($company_events);
    }else{
        $broker->update($company_events);
    }
}else{
	$message = $validation_message;
} 



echo json_encode(array("success"=>$success,"message"=>$message));
die();
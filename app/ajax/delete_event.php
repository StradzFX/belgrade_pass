<?php

$success = false;
$message = "POST was made";
global $broker;

$event_data = $_POST['data'];


if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$company = $broker->get_session('company');

$company_events = $broker->get_data(new company_events($event_data['id']));
$broker->delete($company_events);
$success = true;
$message = "All OK";

echo json_encode(array("success"=>$success,"message"=>$message));
die();
<?php

$success = false;
$message = 'Location not removed.';

$data = $post_data['data'];


SchoolLocationModule::remove($data['id']);
$item = SchoolLocationModule::get_admin_data($data['id']);
if(!$item){
	$success = true;
	$message = 'Location removed.';
}


echo json_encode(array("success"=>$success,"message"=>$message));
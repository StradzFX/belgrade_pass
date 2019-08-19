<?php

$success = false;
$message = 'Location not removed.';

$data = $post_data['data'];


CompanyLocationModule::remove($data['id']);
$item = CompanyLocationModule::get_admin_data($data['id']);
if(!$item){
	$success = true;
	$message = 'Location removed.';
}


echo json_encode(array("success"=>$success,"message"=>$message));
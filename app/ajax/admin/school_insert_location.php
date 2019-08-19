<?php

$success = false;
$message = 'Location not inserted.';

$data = $post_data['save_data'];

$error_message = null;
if($data['city'] == ''){$error_message = 'Please insert city.';}
if($data['part_of_city'] == ''){$error_message = 'Please insert part of city.';}
if($data['street'] == ''){$error_message = 'Please insert address.';}

if(!$error_message){
	$item = CompanyLocationModule::insert($data);
	if($item){
		$success = true;
		$message = 'Location saved.';
	}
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
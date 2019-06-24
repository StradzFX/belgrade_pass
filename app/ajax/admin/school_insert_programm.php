<?php

$success = false;
$message = 'Programm not inserted.';

$data = $post_data['save_data'];

$error_message = null;
if($data['name'] == ''){$error_message = 'Please insert name.';}

if(!$error_message){
	$item = SchoolProgrammModule::insert($data);
	if($item){
		$success = true;
		$message = 'Programm saved.';
	}
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
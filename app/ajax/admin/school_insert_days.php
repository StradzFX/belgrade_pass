<?php

$success = false;
$message = 'Days not inserted.';

$data = $post_data['save_data'];

$item = SchoolProgrammModule::save_days($data);
if($item){
	$success = true;
	$message = 'Programm saved.';
}

echo json_encode(array("success"=>$success,"message"=>$message));
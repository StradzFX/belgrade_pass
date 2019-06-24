<?php

$success = false;
$message = 'Programm not removed.';

$data = $post_data['data'];


SchoolProgrammModule::remove($data['id']);
$item = SchoolProgrammModule::get_admin_data($data['id']);
if(!$item){
	$success = true;
	$message = 'Programm removed.';
}


echo json_encode(array("success"=>$success,"message"=>$message));
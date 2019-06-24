<?php

$success = false;
$message = 'Coach not removed.';

$data = $post_data['data'];


CoachModule::remove_school_coach($data['id'],$data['trainer']);
$item = CoachModule::has_school_coach($data['id'],$data['trainer']);
if(!$item){
	$success = true;
	$message = 'Coach removed.';
}


echo json_encode(array("success"=>$success,"message"=>$message));
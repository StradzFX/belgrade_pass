<?php

$success = false;
$message = 'Coach not inserted.';

$data = $post_data['save_data'];

$error_message = null;
if($data['trainer'] == ''){$error_message = 'Please select coach.';}

if(!$error_message){
	if(!CoachModule::has_school_coach($data['id'],$data['trainer'])){
		$item = CoachModule::insert_school_coach($data);
		if($item){
			$success = true;
			$message = 'Coach saved.';
		}
	}else{
		$message = 'You already have this coach in a list';
	}
	
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
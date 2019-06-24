<?php

$success = false;
$message = 'Image not inserted.';

$data = $post_data['save_data'];

$error_message = null;
if($data['image'] == ''){$error_message = 'Please upload an image.';}

if(!$error_message){
	$image = SchoolPictureModule::insert($data);
	if($image){
		$success = true;
		$message = 'Image saved.';
	}
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
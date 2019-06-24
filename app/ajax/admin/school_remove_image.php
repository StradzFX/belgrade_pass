<?php

$success = false;
$message = 'Image not removed.';

$data = $post_data['data'];


SchoolPictureModule::remove($data['id']);
$item = SchoolPictureModule::get_admin_data($data['id']);
if(!$item){
	$success = true;
	$message = 'Image removed.';
}


echo json_encode(array("success"=>$success,"message"=>$message));
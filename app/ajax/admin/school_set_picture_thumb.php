<?php

$success = false;
$message = 'Days not inserted.';

$data = $post_data['save_data'];

$school_id = $data['id'];
$picture_id = $data['picture_id'];

$item = SchoolPictureModule::set_thumb($school_id,$picture_id);
if($item){
	$success = true;
	$message = 'Programm saved.';
}

echo json_encode(array("success"=>$success,"message"=>$message));
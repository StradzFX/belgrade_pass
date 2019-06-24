<?php

$success = false;
$message = 'Password was not set.';

$data = $post_data['data'];



list($success,$message) = SchoolModule::update_username($data);


echo json_encode(array("success"=>$success,"message"=>$message));
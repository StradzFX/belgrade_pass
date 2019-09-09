<?php

$data = $post_data['data'];

if($data['retail_user'] != ''){
	$user = $broker->get_data(new user($data['retail_user']));
	$broker->set_session('user',$user);

	$success = true;
	$message = 'You are logged in';

}else{
	$message = 'Please select Owner or Location profile';
	$success = false;
}


echo json_encode(array('success'=>$success,'message'=>$message));
die();
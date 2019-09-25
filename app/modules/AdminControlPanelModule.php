<?php

class AdminControlPanelModule{

	public static function get_testing_cards(){
		global $broker;

		$user_card_all = new user_card();

		if($_SESSION['user']){
			$user = $broker->get_session('user');
			$user_card_all->set_condition('checker','!=','');
			$user_card_all->set_condition('user','=',$user->id);
		}else{
			$user_card_all->set_condition('checker','=','test');
		}

		
		$user_card_all->add_condition('recordStatus','=','O');
		$user_card_all->set_order_by('pozicija','DESC');
		$user_card_all = $broker->get_all_data_condition($user_card_all);

		for ($i=0; $i < sizeof($user_card_all); $i++) { 
			$user_card_all[$i]->total_credits = 0;

			$SQL = "SELECT SUM(price) AS total FROM purchase WHERE user_card = ".$user_card_all[$i]->id." AND checker != ''";
			$purchase_total = $broker->execute_sql_get_array($SQL);
			$purchase_total = $purchase_total[0]['total'];

			$SQL = "SELECT SUM(taken_passes) AS total FROM accepted_passes WHERE user_card = ".$user_card_all[$i]->id." AND checker != ''";
			$accepted_passes_total = $broker->execute_sql_get_array($SQL);
			$accepted_passes_total = $accepted_passes_total[0]['total'];

			$user_card_all[$i]->total_credits = $purchase_total - $accepted_passes_total;
		}

		return $user_card_all;
	}

	public static function get_random_legal_user_registration_data(){
		$user = array();
		$random_number = time();
		$user['company_name'] = 'company_'.$random_number;
		$user['company_address'] = 'street_'.$random_number;
		$user['company_pib'] = 'pib_'.$random_number;
		$user['company_maticni'] = 'maticni_'.$random_number;
		$user['company_email'] = 'company_'.$random_number.'@gmail.com';
		$user['password'] = '123456';

		return $user;
	}

	public static function get_random_user_registration_data(){
		$user = array();
		$random_number = time();
		$user['first_name'] = 'name_'.$random_number;
		$user['last_name'] = 'last_'.$random_number;
		$user['email'] = 'random_'.$random_number.'@gmail.com';
		$user['password'] = '123456';

		return $user;
	}

	public static function get_retail_users_list(){
		global $broker;

		$list = new user();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		//$list->add_condition('user_type','=','fizicko');
		$list->set_order_by('id','DESC');
		$list->set_limit(100);
		$list = $broker->get_all_data_condition_limited($list);



		return $list;
	}

}
<?php

class CardModule{
	public static function list_companies_admin(){
		global $broker;

		$SQL = "SELECT company_card, COUNT(*) AS total FROM card_numbers WHERE company_card != 0 GROUP BY company_card";
		$list = $broker->execute_sql_get_array($SQL);

		for ($i=0; $i < sizeof($list); $i++) { 
			$list[$i]['company'] = $broker->get_data(new training_school($list[$i]['company_card']));
		}
		return $list;
	}

	public static function list_created_internal_reservation_cards(){
		global $broker;

		$user_card_all = new user_card();
		$user_card_all->set_condition('checker','!=','');
		$user_card_all->add_condition('recordStatus','=','O');
		$user_card_all->add_condition('','',"card_number IN (SELECT card_number FROM card_numbers WHERE internal_reservation = 1)");
		
		$user_card_all->set_order_by('pozicija','DESC');
		$list = $broker->get_all_data_condition($user_card_all);

		for ($i=0; $i < sizeof($list); $i++) { 
			$list[$i]->user = $broker->get_data(new user($list[$i]->user));
		}

		return $list;
	}
	
	public static function total(){
		global $broker;

		$list = new user_card();
		$list->add_condition('recordStatus','=','O');
		return $broker->get_count_condition($list);
	}

	public static function get_card_usage_total($company_id){
		global $broker;

		$list = new accepted_passes();
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('training_school','=',$company_id);
		return $broker->get_count_condition($list);
	}

	public static function create_card($first_name,$last_name,$email,$user_id){
		global $broker;

		$available_card = self::get_available_card();

		if($available_card){
			$user_card = new user_card();
		    $user_card->card_number = $available_card->card_number;
		    $user_card->card_password = $available_card->card_password;
		    
		    $user_card->parent_first_name = $first_name;
		    $user_card->parent_last_name = $last_name;
		    $user_card->number_of_kids = 0;
		    $user_card->child_birthdate = '';
		    $user_card->city = '';
		    $user_card->phone = '';
		    $user_card->email = $email;

		    $user_card->delivery_method = 'postal';

		    $user_card->post_street = '';
		    $user_card->post_city = '';
		    $user_card->post_postal = '';

		    $user_card->partner_id = 0;
		    $user_card->customer_received = 0;
		    
		    $user_card->user = $user_id;
		    $user_card->maker = 'system';
		    $user_card->makerDate = date('c');
		    $user_card->checker = 'system';
		    $user_card->checkerDate = date('c');
		    $user_card->jezik = 'rs';
		    $user_card->recordStatus = 'O';
		    
		    $user_card = $broker->insert($user_card);

		    $available_card->card_taken = 1;
		    $broker->update($available_card);

		    //self::send_new_card_email($email);
		   return $user_card;
		}else{
			return null;
		}
	}

	public static function get_available_card(){
		global $broker;

		$card_numbers_all = new card_numbers();
		$card_numbers_all->set_condition('checker','!=','');
		$card_numbers_all->add_condition('recordStatus','=','O');
		$card_numbers_all->add_condition('card_taken','=','0');
		$card_numbers_all->add_condition('internal_reservation','=','0');
		$card_numbers_all->add_condition('company_card','=','0');
		$card_numbers_all->add_condition('card_reserved','=','0');
		$card_numbers_all->set_order_by('id','ASC');
		$card_numbers_all->set_limit(1);
		$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

		return sizeof($card_numbers_all) > 0 ? $card_numbers_all[0] : null;

	}


	public static function send_new_card_email($email){
		require_once "vendor/phpmailer/mail_config.php";
		require_once "vendor/phpmailer/wl_mailer.class.php";

		$mail_html = file_get_contents('app/mailer/html/general_template.html');
		$mail_html_content = file_get_contents('app/mailer/html/content_new_card.html');
		$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

		$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
		$wl_mailer->set_subject('Nova kartica KidCard.rs');

		$mail_html = str_replace('{user_email}', $user_card->email, $mail_html);
		$mail_html = str_replace('{card_number}', $user_card->card_number, $mail_html);
		$mail_html = str_replace('{card_password}', $user_card->card_password, $mail_html);
		
		if($user_card->email != ''){
			$wl_mailer->add_address($user_card->email,'');
			$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			$wl_mailer->add_image("files/qr_codes/".$user_card->card_number.".png", "qr_code", "company_logo.png");
		}

		$wl_mailer->set_email_content($mail_html);
		$wl_mailer->send_email();
	}


	public static function get_card($card_number){
		global $broker;

		$last_card = new user_card();
		$last_card->set_condition('checker','!=','');
		$last_card->add_condition('recordStatus','=','O');
		$last_card->add_condition('card_number','=',$card_number);
		$last_card->set_order_by('pozicija','DESC');
		$last_card->set_limit(1);
		$last_card->set_order_by('id','DESC');
		$last_card = $broker->get_all_data_condition_limited($last_card);

		return sizeof($last_card) > 0 ? $last_card[0] : null;
	}

	public static function get_card_for_personal_user($user_id){
		global $broker;

		$last_card = new user_card();
		$last_card->set_condition('checker','!=','');
		$last_card->add_condition('recordStatus','=','O');
		$last_card->add_condition('user','=',$user_id);
		$last_card->set_order_by('pozicija','DESC');
		$last_card->set_limit(1);
		$last_card->set_order_by('id','DESC');
		$last_card = $broker->get_all_data_condition_limited($last_card);

		return sizeof($last_card) > 0 ? $last_card[0] : null;
	}

	public static function validate_card_password($card,$card_password){
		return $card->card_password == $card_password ? $card : null;
	}

	public static function get_card_credits($card){
		global $broker;

		$total_credits = 0;
		$total_used_credits = 0;

		$can_make_transaction = false;
		$need_more_passes = 0;
		$collect_from_packages = array();

		$purchase_all = new purchase();
		$purchase_all->set_condition('checker','!=','');
		$purchase_all->add_condition('recordStatus','=','O');
		$purchase_all->add_condition('end_date','>=',date('Y-m-d'));
		$purchase_all->add_condition('user_card','=',$card->id);
		$purchase_all->set_order_by('id','ASC');
		$purchase_all = $broker->get_all_data_condition($purchase_all);

		foreach ($purchase_all as $purchase) {
			$total_credits += $purchase->number_of_passes;

			$accepted_passes_all = new accepted_passes();
			$accepted_passes_all->set_condition('checker','!=','');
			$accepted_passes_all->add_condition('recordStatus','=','O');
			$accepted_passes_all->add_condition('purchase','=',$purchase->id);
			$accepted_passes_all->set_order_by('pozicija','DESC');
			$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

			foreach ($accepted_passes_all as $accepted_pass) {
				$total_used_credits += $accepted_pass->taken_passes;
			}
		}

		return $total_credits - $total_used_credits;
	}

	public static function get_last_package_date($card){
		global $broker;

		$total_credits = 0;
		$total_used_credits = 0;

		$can_make_transaction = false;
		$need_more_passes = 0;
		$collect_from_packages = array();

		$purchase_all = new purchase();
		$purchase_all->set_condition('checker','!=','');
		$purchase_all->add_condition('recordStatus','=','O');
		$purchase_all->add_condition('user_card','=',$card->id);
		$purchase_all->set_order_by('id','ASC');
		$purchase_all = $broker->get_all_data_condition($purchase_all);

		return sizeof($purchase_all) > 0 ? date('d.m.Y.',strtotime($purchase_all[0]->end_date)) : 'Nema aktivnih uplata';
	}


	

	public static function save_passes($card,$total_credits,$company){
		global $broker;

		$user = $broker->get_data(new user($card->user));

		$can_make_transaction = false;
		$need_more_passes = 0;
		$pass_per_kid = 1;
		$collect_from_packages = array();
		$total_passes_to_collect = $total_credits;

		$purchase_all = new purchase();
		$purchase_all->set_condition('checker','!=','');
		$purchase_all->add_condition('recordStatus','=','O');
		$purchase_all->add_condition('end_date','>=',date('Y-m-d'));
		$purchase_all->add_condition('user_card','=',$card->id);
		$purchase_all->set_order_by('id','ASC');
		$purchase_all = $broker->get_all_data_condition($purchase_all);

		foreach ($purchase_all as $purchase) {
			$total_passes = $purchase->number_of_passes;

			$accepted_passes_all = new accepted_passes();
			$accepted_passes_all->set_condition('checker','!=','');
			$accepted_passes_all->add_condition('recordStatus','=','O');
			$accepted_passes_all->add_condition('purchase','=',$purchase->id);
			$accepted_passes_all->set_order_by('pozicija','DESC');
			$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

			$number_of_used_passes = 0;
			foreach ($accepted_passes_all as $accepted_pass) {
				$number_of_used_passes += $accepted_pass->taken_passes;
			}

			$available_passes = $total_passes - $number_of_used_passes;

			if($total_passes_to_collect <= $available_passes){
				$collect_from_packages[] = array(
					'package' => $purchase,
					'take_passes' => $total_passes_to_collect,
					'number_of_kids' => $total_passes_to_collect / $pass_per_kid
				);
				$total_passes_to_collect = 0;
				$can_make_transaction = true;
				break;
			}else{
				if($available_passes > 0){
					$collect_from_packages[] = array(
						'package' => $purchase,
						'take_passes' => $available_passes,
						'number_of_kids' => $available_passes / $pass_per_kid
					);

					$total_passes_to_collect -= $available_passes;
				}
			}
		}

		if($can_make_transaction){
			foreach ($collect_from_packages as $collect) {
				$accepted_passes = new accepted_passes();
			    $accepted_passes->user_card = $card->id;
			    $accepted_passes->purchase = $collect['package']->id;
			    $accepted_passes->taken_passes = $collect['take_passes'];
			    $accepted_passes->training_school = $company->id;
			    $accepted_passes->number_of_kids = $collect['number_of_kids'];
			    $accepted_passes->user = $user->id == '' ? 'NULL' : $user->id;
			    //$accepted_passes->pay_to_company = ($collect['package']->to_company/$collect['package']->number_of_passes)*$collect['take_passes'];
			    

			    $pay_to_us = $collect['take_passes'];
			    //$pay_to_us = ($pay_to_us * 100) / (100-$company->pass_customer_percentage);
			    $pay_to_us = $pay_to_us * (($company->pass_company_percentage) / 100);

			    $pay_to_company = $collect['take_passes'] - $pay_to_us;
			    $accepted_passes->pay_to_company = $pay_to_company;

			    $accepted_passes->pay_to_us = $pay_to_us;
			    $accepted_passes->company_location = $company->location->id;
			    $accepted_passes->pass_type = 'regular';
			    $accepted_passes->reservation_id = 0;
			    $accepted_passes->maker = 'system';
			    $accepted_passes->makerDate = date('c');
			    $accepted_passes->checker = 'system';
			    $accepted_passes->checkerDate = date('c');
			    $accepted_passes->jezik = 'rs';
			    $accepted_passes->recordStatus = 'O';
			    $accepted_passes = $broker->insert($accepted_passes);
			}

			self::send_email($user,$company,$card_data,$total_credits);

			$success = true;
			$message = 'Hvala!';
			
		}else{
			$pass_verb = $total_passes_to_collect > 1 ? 'prolaza' : 'prolaz';
			$message = 'Nemate dovoljno prolaza na kartici. Fali Vam još '.$total_passes_to_collect.' '.$pass_verb;
		}
	}


	public static function send_email($user,$company,$card_data,$total_passes){
		global $broker;
		require_once "vendor/phpmailer/mail_config.php";
		require_once "vendor/phpmailer/wl_mailer.class.php";

		$original_company = $broker->get_data(new training_school($company->id));

		//====================== SEND EMAILS ==============================
		$mail_html = file_get_contents('app/mailer/html/general_template.html');
		$mail_html_content = file_get_contents('app/mailer/html/content_taken_pass_customer.html');
		$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

		$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
		$wl_mailer->set_subject('BelgradePASS račun');

		$mail_html = str_replace('{transaction_date}', date('d.m.Y.'), $mail_html);
		$mail_html = str_replace('{transaction_time}', date('H:i'), $mail_html);

		$total_bill = round(($total_passes * 100) / (100 - $original_company->pass_customer_percentage),2);
		$total_saved = round($total_bill - $total_passes,2);

		$mail_html = str_replace('{total_bill}', $total_bill, $mail_html);
		$mail_html = str_replace('{total_saved}', $total_saved, $mail_html);

		$mail_html = str_replace('{user_email}', $user->email, $mail_html);
		$mail_html = str_replace('{user_card_number}', $last_card->card_number, $mail_html);
		$mail_html = str_replace('{company_name}', $original_company->name, $mail_html);
		$mail_html = str_replace('{company_location_address}', $company->location->street, $mail_html);
		$mail_html = str_replace('{passes_number_of_kids}', $card_data["number_of_kids"], $mail_html);
		$mail_html = str_replace('{passes_per_kid}', 1, $mail_html);
		$mail_html = str_replace('{passes_total_to_collect}', number_format($total_passes,2,'.',','), $mail_html);
		$mail_html = str_replace('{passes_time}', date('d.m.Y. H:i:s'), $mail_html);
		
		if($user->email != ''){
			$wl_mailer->add_address($user->email,'');
			$wl_mailer->add_address('office@weblab.co.rs','');
			$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
		}

		$wl_mailer->set_email_content($mail_html);
		$wl_mailer->send_email();
		
		if($company->location->email != ''){
			//====================== SEND EMAILS ==============================
			$mail_html = file_get_contents('app/mailer/html/general_template.html');
			$mail_html_content = file_get_contents('app/mailer/html/content_taken_pass_partner.html');
			$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

			$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
			$wl_mailer->set_subject('BelgradePASS račun');

			$mail_html = str_replace('{user_email}', $user->email, $mail_html);
			$mail_html = str_replace('{user_card_number}', $last_card->card_number, $mail_html);
			$mail_html = str_replace('{company_name}', $company->name, $mail_html);
			$mail_html = str_replace('{company_location_address}', $company->location->street, $mail_html);
			$mail_html = str_replace('{passes_number_of_kids}', $card_data["number_of_kids"], $mail_html);
			$mail_html = str_replace('{passes_per_kid}', 1, $mail_html);
			$mail_html = str_replace('{passes_total_to_collect}', $total_passes, $mail_html);
			$mail_html = str_replace('{passes_time}', date('d.m.Y. H:i:s'), $mail_html);
			
			if($user->email != ''){
				$wl_mailer->add_address($company->location->email,'');
				$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			}

			//$wl_mailer->set_email_content($mail_html);
			//$wl_mailer->send_email();
		}
	}
}
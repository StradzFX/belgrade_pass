<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$last_card = null;

$company = $broker->get_session('company');

$validation_message = "";
if(!$company){$validation_message = "Niste ulogovani";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}
if($card_data["card_number"] == ""){$validation_message = "Unesite broj kartice";}
if($card_data["card_password"] == ""){$validation_message = "Unesite sigurnosni kod";}
if($card_data["number_of_kids"] == ""){$validation_message = "Odaberite broj dece";}

if($validation_message == ""){

	$card_number = HelperModule::translate_card_number_format($card_data["card_number"]);
	

	$last_card = new user_card();
	$last_card->set_condition('checker','!=','');
	$last_card->add_condition('recordStatus','=','O');
	$last_card->add_condition('card_number','=',$card_number);
	$last_card->set_order_by('pozicija','DESC');
	$last_card->set_limit(1);
	$last_card->set_order_by('id','DESC');
	$last_card = $broker->get_all_data_condition_limited($last_card);

	if(sizeof($last_card) > 0){
		$last_card = $last_card[0];

		$user = $broker->get_data(new user($last_card->user));

		if($last_card->card_password == $card_data["card_password"]){
			
			$pass_per_kid = 1;
			$location_rules = null;
			$company_location_pass_rules_all = new company_location_pass_rules();
			$company_location_pass_rules_all->set_condition('checker','!=','');
			$company_location_pass_rules_all->add_condition('recordStatus','=','O');
			$sql_from = "(hours_from*60 + minutes_from < ".(date('H')*60+date('m')).")";
			$company_location_pass_rules_all->add_condition('','',$sql_from);
			$sql_to = "(hours_to*60 + minutes_to >= ".(date('H')*60+date('m')).")";
			$company_location_pass_rules_all->add_condition('','',$sql_to);
			$company_location_pass_rules_all->add_condition('ts_location','=',$company->location->id);
			$company_location_pass_rules_all->set_order_by('pozicija','DESC');
			$location_rules_all = $broker->get_all_data_condition($company_location_pass_rules_all);

			if(sizeof($location_rules_all) > 0){
				$location_rules = $location_rules_all[0];
				$pass_per_kid = $location_rules->pass_per_kid;
			}


			$can_make_transaction = false;
			$need_more_passes = 0;
			$collect_from_packages = array();
			$total_passes_to_collect = $pass_per_kid * $card_data["number_of_kids"];
			$total_passes_to_collect_email = $pass_per_kid * $card_data["number_of_kids"];

			$purchase_all = new purchase();
			$purchase_all->set_condition('checker','!=','');
			$purchase_all->add_condition('recordStatus','=','O');
			$purchase_all->add_condition('end_date','>=',date('Y-m-d'));
			$purchase_all->add_condition('user_card','=',$last_card->id);
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
				    $accepted_passes->user_card = $last_card->id;
				    $accepted_passes->purchase = $collect['package']->id;
				    $accepted_passes->taken_passes = $collect['take_passes'];
				    $accepted_passes->training_school = $company->id;
				    $accepted_passes->number_of_kids = $collect['number_of_kids'];
				    $accepted_passes->user = $user->id == '' ? 'NULL' : $user->id;
				    //$accepted_passes->pay_to_company = ($collect['package']->to_company/$collect['package']->number_of_passes)*$collect['take_passes'];
				    $accepted_passes->pay_to_company = 200*$collect['take_passes'];
				    $accepted_passes->pay_to_us = ($collect['package']->to_us/$collect['package']->number_of_passes)*$collect['take_passes'];
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

				$success = true;
				$message = 'Hvala!';

				require_once "vendor/phpmailer/mail_config.php";
				require_once "vendor/phpmailer/wl_mailer.class.php";

				if($user->id != ''){
					//====================== SEND EMAILS ==============================
					$mail_html = file_get_contents('app/mailer/html/general_template.html');
					$mail_html_content = file_get_contents('app/mailer/html/content_taken_pass_customer.html');
					$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

					$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
					$wl_mailer->set_subject('BelgradePASS račun');

					$mail_html = str_replace('{user_email}', $user->email, $mail_html);
					$mail_html = str_replace('{user_card_number}', $last_card->card_number, $mail_html);
					$mail_html = str_replace('{company_name}', $company->name, $mail_html);
					$mail_html = str_replace('{company_location_address}', $company->location->street, $mail_html);
					$mail_html = str_replace('{passes_number_of_kids}', $card_data["number_of_kids"], $mail_html);
					$mail_html = str_replace('{passes_per_kid}', $pass_per_kid, $mail_html);
					$mail_html = str_replace('{passes_total_to_collect}', $total_passes_to_collect_email, $mail_html);
					$mail_html = str_replace('{passes_time}', date('d.m.Y. H:i:s'), $mail_html);
					
					if($user->email != ''){
						$wl_mailer->add_address($user->email,'');
						$wl_mailer->add_address('office@weblab.co.rs','');
						$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
					}

					$wl_mailer->set_email_content($mail_html);
					$wl_mailer->send_email();
				}

				
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
					$mail_html = str_replace('{passes_per_kid}', $pass_per_kid, $mail_html);
					$mail_html = str_replace('{passes_total_to_collect}', $total_passes_to_collect_email, $mail_html);
					$mail_html = str_replace('{passes_time}', date('d.m.Y. H:i:s'), $mail_html);
					
					if($user->email != ''){
						$wl_mailer->add_address($company->location->email,'');
						$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
					}

					$wl_mailer->set_email_content($mail_html);
					$wl_mailer->send_email();
				}

				
			}else{
				$pass_verb = $total_passes_to_collect > 1 ? 'prolaza' : 'prolaz';
				$message = 'Nemate dovoljno prolaza na kartici. Fali Vam još '.$total_passes_to_collect.' '.$pass_verb;
			}

			
		}else{
			$message = 'Sigurnosni kod nije ispravan.';
		}
	}else{
		$message = 'Kartica sa ovim brojem ne postoji.';
	}

}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
die();
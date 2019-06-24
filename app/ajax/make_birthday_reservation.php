<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$data = $post_data['data'];

$last_card = null;
$id = 0;

$validation_message = "";
if($data["user_card"] == ""){$validation_message = "Odaberite karticu";}
if($data["slot_id"] == ""){$validation_message = "Termin nije odabran, pokusajte ponovo celu rezervaciju";}

if($validation_message == ""){

	$last_card = new user_card();
	$last_card->set_condition('checker','!=','');
	$last_card->add_condition('recordStatus','=','O');
	$last_card->add_condition('id','=',$data['user_card']);
	$last_card->set_order_by('pozicija','DESC');
	$last_card->set_limit(1);
	$last_card->set_order_by('id','DESC');
	$last_card = $broker->get_all_data_condition_limited($last_card);

	if(sizeof($last_card) > 0){
		$last_card = $last_card[0];

		$user = $broker->get_data(new user($last_card->user));

		$pass_per_kid = 1;
		$number_of_kids = 1;

		$can_make_transaction = false;
		$need_more_passes = 0;
		$collect_from_packages = array();
		$total_passes_to_collect = $pass_per_kid * $number_of_kids;
		$total_passes_to_collect_email = $pass_per_kid * $number_of_kids;

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

			$clbs = $broker->get_data(new company_location_birthday_slots($data['slot_id']));
			$company_birthday_data = $broker->get_data(new company_birthday_data($clbs->company_birthday_data));


			$cbr = new company_birthday_reservation();
		    $cbr->user = $user->id;
		    $cbr->user_card = $last_card->id;

		    $cbr->training_school = $company_birthday_data->training_school;
		    $cbr->company_birthday_data = $company_birthday_data->id;
		    $cbr->ts_location = $company_birthday_data->ts_location;

		    $cbr->birthday_date = $data['selected_date'];
		    $cbr->birthday_from_hours = $clbs->hours_from;
		    $cbr->birthday_from_minutes = $clbs->minutes_from;
		    $cbr->birthday_to_hours = $clbs->hours_to;
		    $cbr->birthday_to_minutes = $clbs->minutes_to;
		    $cbr->company_location_birthday_slots = $data["slot_id"];

		    $cbr->status = 'unconfirmed';
		    $cbr->comment = $data['comments'];
		    $cbr->number_of_kids = $data['number_of_kids'];
		    $cbr->number_of_adults = $data['number_of_adults'];
		    $cbr->maker = 'system';
		    $cbr->makerDate = date('c');
		    $cbr->checker = 'system';
		    $cbr->checkerDate = date('c');
		    $cbr->jezik = 'rs';
		    $cbr->recordStatus = 'O';
		    
		    $cbr = $broker->insert($cbr);
		    $id = $cbr->id;

			foreach ($collect_from_packages as $collect) {
				$accepted_passes = new accepted_passes();
			    $accepted_passes->user_card = $last_card->id;
			    $accepted_passes->purchase = $collect['package']->id;
			    $accepted_passes->taken_passes = $collect['take_passes'];
			    $accepted_passes->training_school = $company_birthday_data->training_school;
			    $accepted_passes->number_of_kids = $collect['number_of_kids'];
			    $accepted_passes->user = $user->id == '' ? 'NULL' : $user->id;
			    $accepted_passes->pay_to_company = 200*$collect['take_passes'];
			    $accepted_passes->pay_to_us = ($collect['package']->to_us/$collect['package']->number_of_passes)*$collect['take_passes'];
			    $accepted_passes->company_location = $company_birthday_data->ts_location;
			    $accepted_passes->pass_type = 'birthday';
				$accepted_passes->reservation_id = $cbr->id;
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

			$birthday_day = date('d.m.Y.',strtotime($cbr->birthday_date)).' od '.$cbr->birthday_from_hours.':'.$cbr->birthday_from_minutes.' do '.$cbr->birthday_to_hours.':'.$cbr->birthday_to_minutes;
			$cbr->training_school = $broker->get_data(new training_school($cbr->training_school));
			$cbr->ts_location = $broker->get_data(new ts_location($cbr->ts_location));
			$cbr->clbs = $broker->get_data(new company_location_birthday_slots($cbr->company_location_birthday_slots));
			$birthday_location = $cbr->training_school->name.', '.$cbr->ts_location->city.', '.$cbr->ts_location->street.', '.$cbr->clbs->name;


			if($user->id != ''){
				//====================== SEND EMAILS ==============================
				$mail_html = file_get_contents('app/mailer/html/general_system_white_template.html');
				$mail_html_content = file_get_contents('app/mailer/html/content_birthday_reservation_customer.html');
				$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

				$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
				$wl_mailer->set_subject('Rezervisan rođendan na dan '.date('d.m.Y. H:i:s'));


				$mail_html = str_replace('{user_email}', $user->email, $mail_html);
				$mail_html = str_replace('{birthday_day}', $birthday_day, $mail_html);
				$mail_html = str_replace('{birthday_location}', $birthday_location, $mail_html);
				$mail_html = str_replace('{user_card_number}', $last_card->card_number, $mail_html);
				$mail_html = str_replace('{birthday_reservation_time}', date('d.m.Y.',strtotime($cbr->makerDate)), $mail_html);
				$mail_html = str_replace('{birthday_price}', $cbr->clbs->price, $mail_html);
				$mail_html = str_replace('{birthday_number_of_kids}', $cbr->number_of_kids, $mail_html);
				$mail_html = str_replace('{birthday_number_of_adults}', $cbr->number_of_adults, $mail_html);
				$mail_html = str_replace('{birthday_comments}', $cbr->comment, $mail_html);

				
				if($user->email != ''){
					$wl_mailer->add_address($user->email,'');
					$wl_mailer->add_image("public/images/mailer/company_logo_purple.png", "company_logo", "company_logo_purple.png");
				}

				$wl_mailer->set_email_content($mail_html);
				$wl_mailer->send_email();
			}

			
			if($company->location->email != ''){
				//====================== SEND EMAILS ==============================
				$mail_html = file_get_contents('app/mailer/html/general_system_white_template.html');
				$mail_html_content = file_get_contents('app/mailer/html/content_birthday_reservation_company.html');
				$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

				$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
				$wl_mailer->set_subject('Rezervisan rođendan za dan '.$birthday_day);

				$mail_html = str_replace('{user_email}', $user->email, $mail_html);
				$mail_html = str_replace('{birthday_day}', $birthday_day, $mail_html);
				$mail_html = str_replace('{birthday_location}', $birthday_location, $mail_html);
				$mail_html = str_replace('{user_card_number}', $last_card->card_number, $mail_html);
				$mail_html = str_replace('{birthday_reservation_time}', date('d.m.Y.',strtotime($cbr->makerDate)), $mail_html);
				$mail_html = str_replace('{birthday_price}', $cbr->clbs->price, $mail_html);
				$mail_html = str_replace('{birthday_number_of_kids}', $cbr->number_of_kids, $mail_html);
				$mail_html = str_replace('{birthday_number_of_adults}', $cbr->number_of_adults, $mail_html);
				$mail_html = str_replace('{birthday_comments}', $cbr->comment, $mail_html);
				
				if($company->location->email != ''){
					$wl_mailer->add_address($company->location->email,'');
					$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
				}

				$wl_mailer->set_email_content($mail_html);
				$wl_mailer->send_email();
			}

			
		}else{
			$pass_verb = $total_passes_to_collect > 1 ? 'prolaza' : 'prolaz';
			$message = 'Nemate dovoljno prolaza na kartici. Fali Vam '.$total_passes_to_collect.' '.$pass_verb;
		}
	}else{
		$message = 'Kartica sa ovim brojem ne postoji.';
	}

}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
die();
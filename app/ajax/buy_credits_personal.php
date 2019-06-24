<?php

	$success = false;
	$message = "POST was made";
	$post_data = $_POST;
	$user_data = $post_data["user_data"];

	$validation_message = "";
	$id = 0;

	if(!$_SESSION['user']){
		header('Location:'.$base_url.'registracija/');
		die();
	}


	


	if($validation_message == ""){
		$user = $broker->get_session('user');
		$card = CardModule::get_card_for_personal_user($user->id);
		$transaction = PaymentModule::create_post_office_payment($card->id,$user_data['selected_amount'],$user->id);
		if($transaction){
			$id = $transaction->id;
			$success = true;
			$message = 'Uspešno ste rezervisali kredite';


			//============= PURCHASE EMAIL ===============
			require_once "vendor/phpmailer/mail_config.php";
			require_once "vendor/phpmailer/wl_mailer.class.php";

			$mail_html = file_get_contents('app/mailer/html/general_template.html');
			$mail_html_content = file_get_contents('app/mailer/html/content_buy_credits_fizicko.html');
			$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

			$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
			$wl_mailer->set_subject('BelgradePASS rezervacija sredstava (kredita)/ instrukcije za plaćanje');

			$mail_html = str_replace('{user_email}', $user->email, $mail_html);
			$mail_html = str_replace('{user_password}', $user_data["password"], $mail_html);
			$mail_html = str_replace('{card_number}', $card->card_number, $mail_html);
			$mail_html = str_replace('{card_credits}', $user_data['selected_amount'], $mail_html);
			$mail_html = str_replace('{purchase_date}', date('d.m.Y.'), $mail_html);
			$mail_html = str_replace('{purchase_time}', date('H:i'), $mail_html);
			$mail_html = str_replace('{purchase_id}', $transaction->id, $mail_html);
			
			
			if($user->email != ''){
				$wl_mailer->add_address($user->email,'');
				$wl_mailer->add_address('office@weblab.co.rs','');
				$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			}

			$wl_mailer->set_email_content($mail_html);
			$wl_mailer->send_email();


		}else{
			$id = 0;
		}

	}else{
		$message = $validation_message;
	} 

	echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
	die();
<?php

class EmailMoodule{
	public static function send_retail_user_registration($user,$card){

		require_once "vendor/phpmailer/mail_config.php";
		require_once "vendor/phpmailer/wl_mailer.class.php";

		//============= REG EMAIL ===============
		$mail_html = file_get_contents('app/mailer/html/general_template.html');
		$mail_html_content = file_get_contents('app/mailer/html/content_registration_fizicko.html');
		$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

		$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
		$wl_mailer->set_subject('Registracija na BelgradePass-u');

		$mail_html = str_replace('{user_email}', $user->email, $mail_html);
		$mail_html = str_replace('{card_number}', $card->card_number, $mail_html);
		$mail_html = str_replace('{card_password}', $card->card_password, $mail_html);
		$mail_html = str_replace('{purchase_date}', date('d.m.Y.'), $mail_html);
		$mail_html = str_replace('{purchase_time}', date('H:i'), $mail_html);
		
		if($user->email != ''){
			$wl_mailer->add_address($user->email,'');
			$wl_mailer->add_address('office@weblab.co.rs','');
			$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");

			$wl_mailer->add_image("files/qr_codes/".$card->card_number.".png", "qr_code", "company_logo.png");
		}

		$wl_mailer->set_email_content($mail_html);
		$wl_mailer->send_email();
	}

	public static function send_company_user_new_card($user_email,$card,$company){

		require_once "vendor/phpmailer/mail_config.php";
		require_once "vendor/phpmailer/wl_mailer.class.php";

		//============= REG EMAIL ===============
		$mail_html = file_get_contents('app/mailer/html/general_template.html');
		$mail_html_content = file_get_contents('app/mailer/html/content_company_new_card.html');
		$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

		$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
		$wl_mailer->set_subject('Kartica na BelgradePass-u');

		$mail_html = str_replace('{user_email}', $user_email, $mail_html);
		$mail_html = str_replace('{card_number}', $card->card_number, $mail_html);
		$mail_html = str_replace('{card_password}', $card->card_password, $mail_html);
		$mail_html = str_replace('{purchase_date}', date('d.m.Y.'), $mail_html);
		$mail_html = str_replace('{purchase_time}', date('H:i'), $mail_html);
		$mail_html = str_replace('{company_name}', $company->naziv, $mail_html);
		
		
		if($user_email!= ''){
			$wl_mailer->add_address($user_email,'');
			$wl_mailer->add_address('office@weblab.co.rs','');
			$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			$wl_mailer->add_image("files/qr_codes/".$card->card_number.".png", "qr_code", "company_logo.png");
		}

		$wl_mailer->set_email_content($mail_html);
		$wl_mailer->send_email();
	}
}
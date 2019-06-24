<?php

	$success = false;
	$message = "POST was made";
	$post_data = $_POST;
	$user_data = $post_data["user_data"];

	$validation_message = "";
	$user = null;
	
	
	if(!filter_var($user_data["email"], FILTER_VALIDATE_EMAIL)){$validation_message = "Molimo Vas da unesete validan email.";}
	if($user_data["prezime"] == ""){$validation_message = "Molimo Vas da unesete prezime.";}
	if($user_data["ime"] == ""){$validation_message = "Molimo Vas da unesete ime.";}

	if($validation_message == ""){
		$user_insert_validation = new user();
		$user_insert_validation->set_condition('recordStatus','=','O');
		$user_insert_validation->add_condition('checker','!=','');
		$user_insert_validation->add_condition('email','=',$user_data["email"]);
		$user_insert_validation->set_order_by('id','DESC');
		$user_insert_validation = $broker->get_all_data_condition($user_insert_validation);

		if(sizeof($user_insert_validation) == 0){
			$user_data["password"] = rand(11111,99999);      
		    $user = new user();
		    $user->email = $user_data["email"];
		    $user->password = md5($user_data["password"]);
		    $user->fb_id = '';
		    $user->first_name = $user_data["ime"];
		    $user->last_name = $user_data["prezime"];
		    $user->avatar = '';
		    $user->maker = 'system';
		    $user->makerDate = date('c');
		    $user->checker = 'system';
		    $user->checkerDate = date('c');
		    $user->jezik = 'rs';
		    $user->recordStatus = 'O';
		    
		    $user = $broker->insert($user);
		    $success = true;
		    $message = "Kreirali ste nalog.";
		    $broker->set_session('user',$user);

		    require_once "vendor/phpmailer/mail_config.php";
			require_once "vendor/phpmailer/wl_mailer.class.php";

			$mail_html = file_get_contents('app/mailer/html/general_template.html');
			$mail_html_content = file_get_contents('app/mailer/html/content_registration.html');
			$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

			$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
			$wl_mailer->set_subject('Registracija na KidCard.rs');

			$mail_html = str_replace('{user_email}', $user->email, $mail_html);
			$mail_html = str_replace('{user_password}', $user_data["password"].' (automatski dodeljen broj)', $mail_html);
			
			if($user->email != ''){
				$wl_mailer->add_address($user->email,'');
				$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			}

			$wl_mailer->set_email_content($mail_html);
			$wl_mailer->send_email();
		}else{
		    $success = false;
		    $message = "Email koji ste uneli već postoji u bazi podataka.";
		}

	}else{
		$message = $validation_message;
	} 

	echo json_encode(array("success"=>$success,"message"=>$message,"user"=>$user));
	die();
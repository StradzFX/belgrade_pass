<?php
global $broker;
$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$validation_message = "";
$user_card = null;

if($card_data["card_number"] == ""){$validation_message = "Please select card number";}
if(sizeof($card_data["birthdays"]) == 0){$validation_message = "Please select at least one kid";}
if(!is_numeric($card_data["number_of_kids"])){$validation_message = "Number of kids must be numeric value.";}
if($card_data["number_of_kids"] == ""){$validation_message = "Enter number of kids.";}
if($card_data["email"] == ""){$validation_message = "Enter email.";}

if($validation_message == ""){
	$card_number = $broker->get_data(new card_numbers($card_data["card_number"]));

	if($card_number){
		$available_card = $card_number;

		require_once "vendor/phpmailer/mail_config.php";
		require_once "vendor/phpmailer/wl_mailer.class.php";

		$user_insert_validation = new user();
		$user_insert_validation->set_condition('checker','!=','');
		$user_insert_validation->add_condition('recordStatus','=','O');
		$user_insert_validation->add_condition('email','=',$card_data['email']);
		$user_insert_validation->set_order_by('pozicija','DESC');
		$user_insert_validation = $broker->get_all_data_condition($user_insert_validation);

		if(sizeof($user_insert_validation) == 0){  

			$card_data["password"] = rand(11111,99999);

		    $user = new user();
		    $user->email = $card_data['email'];
		    $user->password = md5($card_data['password']);
		    $user->fb_id = '';
		    $user->first_name = $card_data['parent_first_name'];
		    $user->last_name = $card_data['parent_last_name'];
		    $user->avatar = '';
		    $user->maker = 'system';
		    $user->makerDate = date('c');
		    $user->checker = 'system';
		    $user->checkerDate = date('c');
		    $user->jezik = 'rs';
		    $user->recordStatus = 'O';
		    
		    $user = $broker->insert($user);

		    $mail_html = file_get_contents('app/mailer/html/general_template.html');
			$mail_html_content = file_get_contents('app/mailer/html/content_registration.html');
			$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

			$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
			$wl_mailer->set_subject('Registracija na KidCard.rs');

			$mail_html = str_replace('{user_email}', $user->email, $mail_html);
			$mail_html = str_replace('{user_password}', $card_data["password"].' (automatski dodeljen broj)', $mail_html);
			
			if($user->email != ''){
				$wl_mailer->add_address($user->email,'');
				$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
			}

			$wl_mailer->set_email_content($mail_html);
			$wl_mailer->send_email();

		}else{
		   	$user = $user_insert_validation[0];
		}

		


		$user_card = new user_card();
	    $user_card->card_number = $available_card->card_number;
	    $user_card->card_password = $available_card->card_password;
	    
	    $user_card->parent_first_name = $card_data['parent_first_name'];
	    $user_card->parent_last_name = $card_data['parent_last_name'];
	    $user_card->number_of_kids = $card_data['number_of_kids'];
	    $user_card->child_birthdate = $card_data['child_birthdate'];
	    $user_card->city = $card_data['city'];
	    $user_card->phone = $card_data['phone'];
	    $user_card->email = $card_data['email'];

	    $user_card->delivery_method = 'post';

	    $user_card->post_street = '';
	    $user_card->post_city = '';
	    $user_card->post_postal = '';

	    $user_card->partner_id = 0;
	    $user_card->customer_received = 0;
	    
	    $user_card->user = $user->id;
	    $user_card->maker = 'system';
	    $user_card->makerDate = date('c');
	    $user_card->checker = 'system';
	    $user_card->checkerDate = date('c');
	    $user_card->jezik = 'rs';
	    $user_card->recordStatus = 'O';
	    
	    $user_card = $broker->insert($user_card);

	    $available_card->card_taken = 1;
	    $broker->update($available_card);


	    for ($i=0; $i < sizeof($card_data["birthdays"]); $i++) { 
	    	
	    	$user_kids_data = $card_data["birthdays"][$i];

	    	$user_kids = new user_kids();
		    $user_kids->user = $user->id;
		    $user_kids->name = $user_kids_data['name'];
		    $user_kids->date_of_birth = $user_kids_data['date_of_birth'];
		    $user_kids->user_card = $user_card->id;
		    $user_kids->maker = 'system';
		    $user_kids->makerDate = date('c');
		    $user_kids->checker = 'system';
		    $user_kids->checkerDate = date('c');
		    $user_kids->jezik = 'rs';
		    $user_kids->recordStatus = 'O';
		    
		    $user_kids = $broker->insert($user_kids);
	    }

	    

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

	    $success = true;
	    $message = "Odobrena Vam je kartica.";
	}else{
		$message = 'Trenutno nema dospunih kartica. Molimo Vas da kontaktirate administratore sajta';
	}

}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$reg_user = $broker->get_session('user');

$validation_message = "";
$user_card = null;

if(!$reg_user){$validation_message = "Niste ulogovani";}
if($card_data["child_birthdate"] == ""){$validation_message = "Popunite detetov rođendan";}
/*if($card_data["child_name"] == ""){$validation_message = "Popunite ime deteta.";}
if($card_data["parent_name"] == ""){$validation_message = "Popunite ime roditelja.";}*/
if($card_data["delivery_method"] == ""){$validation_message = "Odaberite metod preuzimanja.";}
if(!is_numeric($card_data["number_of_kids"])){$validation_message = "Broj dece mora biti numericka vrednost.";}
if($card_data["number_of_kids"] == ""){$validation_message = "Unesite broj dece.";}
if($card_data["email"] == ""){$validation_message = "Unesite email.";}

if($card_data["delivery_method"] == "post"){
	if($card_data["post_street"] == ""){$validation_message = "Popunite ulicu.";}
	if($card_data["post_city"] == ""){$validation_message = "Popunite grad.";}
	if($card_data["post_postal"] == ""){$validation_message = "Popunite poštanski broj.";}
}

if($card_data["delivery_method"] == "partner"){
	if($card_data["partner_id"] == ""){$validation_message = "Odaberite partnera.";}
}

if($validation_message == ""){

	

	$card_numbers_all = new card_numbers();
	$card_numbers_all->set_condition('checker','!=','');
	$card_numbers_all->add_condition('recordStatus','=','O');
	$card_numbers_all->add_condition('card_taken','=','0');
	$card_numbers_all->add_condition('internal_reservation','=','0');
	

	if($card_data["delivery_method"] == "partner"){
		$card_numbers_all->add_condition('company_card','=',$card_data["partner_id"]);
		$card_numbers_all->set_order_by('id','DESC');
	}else{
		$card_numbers_all->add_condition('company_card','=','0');
		$card_numbers_all->add_condition('card_reserved','=','0');
		$card_numbers_all->set_order_by('id','ASC');
	}

	$card_numbers_all->set_limit(1);
	$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

	if(sizeof($card_numbers_all) > 0){
		$available_card = $card_numbers_all[0];

		$user_card_insert_validation = new user_card();
		$user_card_insert_validation->set_condition('checker','!=','');
		$user_card_insert_validation->add_condition('recordStatus','=','O');
		$user_card_insert_validation->set_order_by('pozicija','DESC');
		$user_card_insert_validation = $broker->get_all_data_condition($user_card_insert_validation);

		//if(sizeof($user_card_insert_validation) == 0){
		if(true){      
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

		    $user_card->delivery_method = $card_data['delivery_method'];

		    $user_card->post_street = $card_data['post_street'];
		    $user_card->post_city = $card_data['post_city'];
		    $user_card->post_postal = $card_data['post_postal'];

		    $user_card->partner_id = $card_data['partner_id'];
		    $user_card->customer_received = 0;
		    
		    $user_card->user = $reg_user->id;
		    $user_card->maker = 'system';
		    $user_card->makerDate = date('c');
		    $user_card->checker = 'system';
		    $user_card->checkerDate = date('c');
		    $user_card->jezik = 'rs';
		    $user_card->recordStatus = 'O';
		    
		    $user_card = $broker->insert($user_card);

		    $available_card->card_taken = 1;
		    $broker->update($available_card);

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

		    $success = true;
		    $message = "Odobrena Vam je kartica.";
		}else{
		    $success = false;
		    $message = "Kartica sa ovim imenon deteta već postoji u sistemu.";
		}
	}else{
		$message = 'Trenutno nema dospunih kartica. Molimo Vas da kontaktirate administratore sajta';
	}

}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
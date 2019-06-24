<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$data = $post_data['data'];

$user = null;

$user_all = new user();
$user_all->set_condition('checker','!=','');
$user_all->add_condition('recordStatus','=','O');
$user_all->add_condition('email','=',$data['email']);
$user_all->set_order_by('id','DESC');
$user_all = $broker->get_all_data_condition($user_all);

if(sizeof($user_all) > 0){
	$user = $user_all[0];

	require_once "vendor/phpmailer/mail_config.php";
	require_once "vendor/phpmailer/wl_mailer.class.php";

	$mail_html = file_get_contents('app/mailer/html/general_template.html');
	$mail_html_content = file_get_contents('app/mailer/html/content_forget_password.html');
	$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

	$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
	$wl_mailer->set_subject('Resetovanje lozinke na KidCard.rs');

	$mail_html = str_replace('{user_email}', $user->email, $mail_html);
	$mail_html = str_replace('{reset_link}', $base_url.'zameni_lozinku/'.md5($user->id).'/', $mail_html);
	
	if($user->email != ''){
		$wl_mailer->add_address($user->email,'');
		$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");

		
	}

	$wl_mailer->set_email_content($mail_html);
	$wl_mailer->send_email();

	$success = true;
	$message = 'Poslali smo Vam zahtev na email.';
}else{
	$message = 'Email koji ste uneli ne postoji u našem sistemu.';
}



echo json_encode(array("success"=>$success,"message"=>$message,"user"=>$user));
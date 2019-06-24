<?php

require_once "vendor/phpmailer/mail_config.php";
require_once "vendor/phpmailer/wl_mailer.class.php";

$test_send = false;
if($test_send){
	$limit = 1;
}else{
	$limit = 25;
}
$old_status = 2;
$new_status = 3;


$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->add_condition('modNumber','=',$old_status);
$user_card_all->set_order_by('pozicija','DESC');
$user_card_all->set_limit($limit);
$user_card_all = $broker->get_all_data_condition_limited($user_card_all);

echo 'Emails to send: '.sizeof($user_card_all).'<br/>';

for($i=0;$i<sizeof($user_card_all);$i++){

	//====================== SEND EMAILS ==============================
	$mail_html = file_get_contents('app/mailer/html/general_white_template.html');
	$mail_html_content = file_get_contents('app/mailer/html/content_nova_pozorista_3.html');
	$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

	$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
	$wl_mailer->set_subject('Spisak predstava za decu u pozorištima Puž i Pinokio za korisnike Belgrade Pass-a ovog vikenda');

	if($test_send){
		$user_card_all[$i]->email = 'strahinja.krstic@gmail.com';
	}
	
	echo 'Sending to: '.$user_card_all[$i]->email.'<br/>';
	if($user_card_all[$i]->email != ''){
		$wl_mailer->add_address($user_card_all[$i]->email,'');
		$wl_mailer->add_image("public/images/mailer/company_logo_purple.png", "company_logo", "company_logo.png");
	}

	$wl_mailer->set_email_content($mail_html);
	$wl_mailer->send_email();

	if(!$test_send){
		$SQL = "UPDATE user_card SET modNumber = $new_status WHERE id = ".$user_card_all[$i]->id;
		$broker->execute_query($SQL);
	}
}

$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->add_condition('modNumber','=',$old_status);
$user_card_all->set_order_by('pozicija','DESC');
$user_card_all = $broker->get_count_condition($user_card_all);

echo 'Left to send '.$user_card_all.'<br/>';

die();
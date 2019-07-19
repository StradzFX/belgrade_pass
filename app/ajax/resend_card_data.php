<?php

require_once "vendor/phpmailer/mail_config.php";
require_once "vendor/phpmailer/wl_mailer.class.php";


$reg_user = $broker->get_session('user');

$card_list = new user_card();
$card_list->set_condition('checker','!=','');
$card_list->add_condition('recordStatus','=','O');
$card_list->add_condition('user','=',$reg_user->id);
$card_list->set_order_by('pozicija','DESC');
$card_list->set_order_by('id','DESC');
$card_list = $broker->get_all_data_condition($card_list);
if(sizeof($card_list) > 0){
	$card = $card_list[0];
}

//============= REG EMAIL ===============
$mail_html = file_get_contents('app/mailer/html/general_template.html');
$mail_html_content = file_get_contents('app/mailer/html/content_registration_fizicko_card.html');
$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
$wl_mailer->set_subject('Podaci o kartici');

$mail_html = str_replace('{user_email}', $reg_user->email, $mail_html);
$mail_html = str_replace('{card_number}', $card->card_number, $mail_html);
$mail_html = str_replace('{card_password}', $card->card_password, $mail_html);

if($reg_user->email != ''){
	$wl_mailer->add_address($reg_user->email,'');
	$wl_mailer->add_address('office@weblab.co.rs','');
	$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
	$wl_mailer->add_image("files/qr_codes/".$card->card_number.".png", "qr_code", "company_logo.png");
}

$wl_mailer->set_email_content($mail_html);
$wl_mailer->send_email();

$success = true;
$message = 'Uspešno smo Vam poslali email sa podacima o kartici.';


echo json_encode(array("success"=>$success,"message"=>$message));
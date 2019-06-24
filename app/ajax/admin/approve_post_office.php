<?php
global $broker;
$data = $post_data['data'];

$success = false;
$message = 'Post was made';

$id = $data['id'];
if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new purchase($id))){
  include_once 'template/header.php';
  include_once 'error_pages/error404.php';
  include_once 'template/footer.php';
  die();
}
$purchase = $broker->get_data(new purchase($id));
  if($purchase->user != ''){$purchase->user = $broker->get_data(new user($purchase->user));}
  if($purchase->card_package != ''){$purchase->card_package = $broker->get_data(new card_package($purchase->card_package));}
  if($purchase->user_card != ''){$purchase->user_card = $broker->get_data(new user_card($purchase->user_card));}

 $SQL = "UPDATE purchase SET checker = 'admin_post_office' WHERE id = ".$id;
 $broker->execute_query($SQL);

 $success = true;


require_once "vendor/phpmailer/mail_config.php";
require_once "vendor/phpmailer/wl_mailer.class.php";

$mail_html = file_get_contents('app/mailer/html/general_template.html');
$mail_html_content = file_get_contents('app/mailer/html/content_approved_post_office.html');
$mail_html = str_replace('{content}', $mail_html_content, $mail_html);
$card_credits = CardModule::get_card_credits($purchase->user_card);

$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
$wl_mailer->set_subject('BelgradePASS dopuna');

$mail_html = str_replace('{user_email}', $purchase->user_card->email, $mail_html);
$mail_html = str_replace('{card_number}', $purchase->user_card->card_number, $mail_html);
$mail_html = str_replace('{purchase_id}', $purchase->id, $mail_html);
$mail_html = str_replace('{purchase_current_state}', number_format($card_credits,2,',','.'), $mail_html);
$mail_html = str_replace('{purchase_price}', number_format($purchase->price,2,',','.'), $mail_html);

$mail_html = str_replace('{purchase_package_name}', $purchase->card_package->name, $mail_html);
$mail_html = str_replace('{purchase_package_number_of_passes}', $purchase->number_of_passes, $mail_html);
$mail_html = str_replace('{purchase_package_use_to}', date('d.m.Y.',strtotime($purchase->end_date)), $mail_html);


if($purchase->user_card->email != ''){
	$wl_mailer->add_address($purchase->user_card->email,'');
	$wl_mailer->add_address('office@weblab.co.rs','');
	$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
}

$wl_mailer->set_email_content($mail_html);
$wl_mailer->send_email();


echo json_encode(array("success"=>$success,"message"=>$message));
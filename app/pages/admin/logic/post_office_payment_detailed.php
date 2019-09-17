<?php

global $broker;

$id = $url_params[0];
if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new user_card($id))){
  include_once 'template/header.php';
  include_once 'error_pages/error404.php';
  include_once 'template/footer.php';
  die();
}
$user_card = $broker->get_data(new user_card($id));

$user_credits = "SELECT SUM(price) AS total FROM purchase WHERE user = ".$user_card->user." AND checker != ''";
$user_credits = $broker->execute_sql_get_array($user_credits);
$user_credits = $user_credits[0]['total'];

$user_debits = "SELECT SUM(taken_passes) AS total FROM accepted_passes WHERE user = ".$user_card->user." AND checker != ''";
$user_debits = $broker->execute_sql_get_array($user_debits);
$user_debits = $user_debits[0]['total'];

$user_balance = $user_credits - $user_debits;

$user = $broker->get_data(new user($user_card->user));

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->add_condition('card_number','=',$user_card->card_number);
$card_numbers_all->set_order_by('pozicija','DESC');
$card_numbers_all = $broker->get_all_data_condition($card_numbers_all);

if(sizeof($card_numbers_all) > 0){
	$card_number = $card_numbers_all[0];
}

$card_type = 'Regular card';
if($card_number->internal_reservation == 1){
	$card_type = 'Internal card';
}
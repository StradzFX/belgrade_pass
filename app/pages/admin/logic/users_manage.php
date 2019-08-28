<?php

global $broker;

$id = $url_params[0];
if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new user($id))){
  include_once 'template/header.php';
  include_once 'error_pages/error404.php';
  include_once 'template/footer.php';
  die();
}
$user = $broker->get_data(new user($id));


$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->add_condition('user','=',$user->id);
$user_card_all->set_order_by('pozicija','DESC');
$user_card_all = $broker->get_all_data_condition($user_card_all);

$user_card = $user_card_all[0];


$user_credits = "SELECT SUM(price) AS total FROM purchase WHERE user = ".$user->id." AND checker != ''";
$user_credits = $broker->execute_sql_get_array($user_credits);
$user_credits = $user_credits[0]['total'];

$user_debits = "SELECT SUM(taken_passes) AS total FROM accepted_passes WHERE user = ".$user->id." AND checker != ''";
$user_debits = $broker->execute_sql_get_array($user_debits);
$user_debits = $user_debits[0]['total'];

$user_balance = $user_credits - $user_debits;
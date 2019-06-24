<?php

global $broker;

$id = $url_params[0];
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


$user = $broker->get_session('user');
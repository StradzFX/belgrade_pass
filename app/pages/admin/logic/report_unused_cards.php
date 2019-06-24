<?php

$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->add_condition('','',"id NOT IN (SELECT DISTINCT user_card FROM accepted_passes)");
$user_card_all->add_condition('','',"id IN (SELECT DISTINCT user_card FROM purchase WHERE end_date >= '".date('Y-m-d')."' AND recordStatus = 'O' AND checker != '')");
$user_card_all->set_order_by('card_number','ASC');
$user_card_all = $broker->get_all_data_condition($user_card_all);

for($i=0;$i<sizeof($user_card_all);$i++){
  if($user_card_all[$i]->user != ''){$user_card_all[$i]->user = $broker->get_data(new user($user_card_all[$i]->user));}else{
    $user_card_all[$i]->user = new user();
    $user_card_all[$i]->user->email = 'N/A';
    $user_card_all[$i]->user->first_name = 'N/A';
  }

  $user_card_all[$i]->active_packages = PaymentModule::get_total_active_packages($user_card_all[$i]->id);
}

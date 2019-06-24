<?php

$card_package_all = new card_package();
$card_package_all->set_condition('checker','!=','');
$card_package_all->add_condition('recordStatus','=','O');
$card_package_all->set_order_by('pozicija','DESC');
$card_package_all = $broker->get_all_data_condition($card_package_all);

for($i=0;$i<sizeof($card_package_all);$i++){
}


$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->set_order_by('card_number','ASC');
$user_card_all = $broker->get_all_data_condition($user_card_all);

for($i=0;$i<sizeof($user_card_all);$i++){
	if($user_card_all[$i]->user != ''){$user_card_all[$i]->user = $broker->get_data(new user($user_card_all[$i]->user));}
}


$preselected_card = '';
if($_GET['preselected_card']){
	$preselected_card = $_GET['preselected_card'];
}
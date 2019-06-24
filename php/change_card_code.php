<?php

$broker->start_debugger();

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->set_order_by('id','ASC');
$card_numbers_all->set_limit(11000);
$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

for ($i=0; $i < sizeof($card_numbers_all); $i++) { 
	$card_numbers_all[$i]->card_password = rand(1111,9999);
	$broker->update($card_numbers_all[$i]);
}


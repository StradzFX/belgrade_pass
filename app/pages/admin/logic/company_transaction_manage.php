<?php

$url_params[0] = $url_params[0] == '' ? 0 : $url_params[0];

if($url_params[0] != 0){
	$item = $broker->get_data(new company_transactions($url_params[0]));
	$item->transaction_date = date('d.m.Y',strtotime($item->transaction_date));
}else{
	$item = new company_transactions();
}

$system_message = isset($_GET['message']) ? 'Transaction saved successfully.' : '';

$training_school_all = new training_school();
$training_school_all->set_condition('checker','!=','');
$training_school_all->add_condition('recordStatus','=','O');
$training_school_all->set_order_by('pozicija','DESC');
$training_school_all = $broker->get_all_data_condition($training_school_all);

for($i=0;$i<sizeof($training_school_all);$i++){
if($training_school_all[$i]->sport_category != ''){$training_school_all[$i]->sport_category = $broker->get_data(new sport_category($training_school_all[$i]->sport_category));}
}

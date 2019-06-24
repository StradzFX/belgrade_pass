<?php
$data = $post_data['validate_data'];

global $broker;

$success = false;
$message = 'Function for save is not implemented.';

if($data['cards_from'] > $data['cards_to']){
	$a = $data['cards_to'];
	$data['cards_to'] = $data['cards_from'];
	$data['cards_from'] = $a;
}

$card_numbers_all = new card_numbers();
$card_numbers_all->set_condition('checker','!=','');
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->add_condition('','',"(card_taken = 1 OR card_reserved = 1)");
$card_numbers_all->add_condition('card_number_int','>=',$data['cards_from']);
$card_numbers_all->add_condition('card_number_int','<=',$data['cards_to']);
$card_numbers_all->add_condition('recordStatus','=','O');
$card_numbers_all->set_order_by('pozicija','ASC');
$card_numbers_all = $broker->get_all_data_condition($card_numbers_all);

if(sizeof($card_numbers_all) == 0){
	$success = true;
	$message = 'All ok';
}else{
	$taken_numbers = array();
	foreach ($card_numbers_all as $key => $value) {
		$taken_numbers[] = $value->card_number_int;
	}

	$message = implode($taken_numbers, ', ');
}


echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
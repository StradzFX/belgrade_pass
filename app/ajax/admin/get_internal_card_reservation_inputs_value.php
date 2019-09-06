<?php
global $broker;
$data = $post_data['data'];
$success = false;
$message = "Kartice su zauzete";

$validation_message = "";

if($data["card_number_from"] == ""){$validation_message = 'Choose value for field card from';}
if($data["card_number_to"] == ""){$validation_message = 'Choose value for field card to';}

if($validation_message == ""){
	$list_of_available_card_numbers = new card_numbers();
	$list_of_available_card_numbers->set_condition('checker', '!=', '');
	$list_of_available_card_numbers->add_condition('', '', "(card_taken = 1 OR internal_reservation = 1)");
	$list_of_available_card_numbers->add_condition('card_number_int', '>=', $data["card_number_from"]);
	$list_of_available_card_numbers->add_condition('card_number_int', '<=', $data["card_number_to"]);

	$list_of_available_card_numbers = $broker->get_all_data_condition($list_of_available_card_numbers);
	
if(sizeof($list_of_available_card_numbers) == 0){
	$success = true;
	$message = "Thank you you have reserved selected cards";

	$SQL = "UPDATE card_numbers SET internal_reservation = 1 WHERE card_number_int >= ".$data["card_number_from"]." AND card_number_int <= ".$data["card_number_to"];
	$broker->execute_query($SQL); 
}else{
	$taken_cards = array();
	for($i=0; $i < sizeof($list_of_available_card_numbers); $i++){
		$taken_cards[] = $list_of_available_card_numbers[$i]->card_number;
	}
	$taken_cards = implode(', ' ,$taken_cards);
	$success = false;
	$message = 'Sorry, but these cards are taken: ' .$taken_cards;
}
}
else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));
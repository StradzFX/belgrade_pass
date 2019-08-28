<?php
global $broker;

$data = $post_data['data'];
$success = false;
$message = 'Morate odabrati broj';
//var_dump($data);

$validation_message = "";

if($data["card_number"] == ""){$validation_message = "Odaberite broj kartice";}

if($validation_message == ""){

	$card_number = $broker->get_data(new card_numbers($data["card_number"]));
	$user = $broker->get_data(new user($data["id"]));

	$user_card_all = new user_card();
	$user_card_all->set_condition('checker','!=','');
	$user_card_all->add_condition('recordStatus','=','O');
	$user_card_all->add_condition('user','=',$user->id);
	$user_card_all->set_order_by('pozicija','DESC');
	$user_card_all = $broker->get_all_data_condition($user_card_all);

	if(sizeof($user_card_all) > 0){
		$user_card = $user_card_all[0];
		$user_card->card_number = $card_number->card_number;
		$user_card->card_password = $card_number->card_password;
		$user_card->customer_received = 0;

		$user_card_new = $broker->insert($user_card);

		$SQL = "UPDATE accepted_passes SET user_card = ".$user_card_new->id." WHERE user_card = ".$user_card->id;
		$broker->execute_query($SQL);

		$SQL = "UPDATE purchase SET user_card = ".$user_card_new->id." WHERE user_card = ".$user_card->id;
		$broker->execute_query($SQL);

		$SQL = "UPDATE user_card SET recordStatus = 'A' WHERE id = ".$user_card->id;
		$broker->execute_query($SQL);

		$SQL = "UPDATE card_numbers SET card_taken = '1' WHERE id = ".$data["card_number"];
		$broker->execute_query($SQL);
	}

	$success = true;
	$message = "Uspešno ste promenili broj kartice";
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));
<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
/*if($card_data["child_birthdate"] == ""){$validation_message = "Popunite detetov rođendan";}
if($card_data["child_name"] == ""){$validation_message = "Popunite ime deteta.";}
if($card_data["parent_name"] == ""){$validation_message = "Popunite ime roditelja.";}
*/
if($card_data["card_number"] == ""){$validation_message = "Odaberite broj kartice.";}

if($validation_message == ""){

	$card_numbers_all = new user_card();
	$card_numbers_all->set_condition('checker','!=','');
	$card_numbers_all->add_condition('recordStatus','=','O');
	$card_numbers_all->add_condition('card_number','=',$card_data["card_number"]);
	$card_numbers_all->set_limit(1);
	$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

	if(sizeof($card_numbers_all) > 0){
		$user_card = $card_numbers_all[0];
	  
	    $user_card->parent_first_name = $card_data['parent_first_name'];
	    $user_card->parent_last_name = $card_data['parent_last_name'];
	    $user_card->number_of_kids = $card_data['number_of_kids'];
	    $user_card->child_birthdate = $card_data['child_birthdate'];
	    $user_card->city = $card_data['city'];
	    $user_card->phone = $card_data['phone'];
	    $user_card->email = $card_data['email'];

	    if($user_card->user == ''){
	    	$user_card->user = "NULL";
	    }

	    $broker->update($user_card);

	    $success = true;
	    $message = "Sačuvali ste podatke za karticu.";
	}else{
		$message = 'Kartica sa ovim brojem ne postoji.';
	}

}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
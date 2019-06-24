<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
if($card_data["card_id"] == ""){$validation_message = "Popunite broj kartice";}

if($validation_message == ""){
	$card = $broker->get_data(new user_card($card_data["card_id"]));
	$card->customer_received = 1;
	$broker->update($card);

	$success = true;
	$message = "Kartica je predata.";
}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
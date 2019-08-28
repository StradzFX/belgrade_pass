<?php
$data = $post_data['data'];
$success = false;
$message = 'BLA';

global $broker;

//var_dump($post_data);

//OVDE PISEMO CELOKUPNU LOGIKU ZA OVU STRANICU

$validation_message = "";
if($data["name"] == ""){$validation_message = "Upisite ime";}
if($data["surname"] == ""){$validation_message = "Upišite prezime";}
if($data["mail"] == ""){$validation_message = "Upišite e-mail";}


if($validation_message == ""){
	$SQL = "UPDATE user_card SET parent_first_name = '".$data["name"]."', parent_last_name = '".$data["surname"]."', email = '".$data["mail"]."' WHERE id = ".$data["id"];
	$broker->execute_query($SQL);
	$success = true;
	$message = "Podaci ažurirani";
}else{
	$message = $validation_message;
} 

echo json_encode(array("success"=>$success,"message"=>$message));
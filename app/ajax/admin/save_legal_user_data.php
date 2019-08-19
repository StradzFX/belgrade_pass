<?php

$data = $post_data['data'];
$success = false;
$message = "Nista se nije desilo";

$validation_message = "";
if($data["ime"] == ""){$validation_message = "Upišite naziv firme";}
if($data["adresa"] == ""){$validation_message = "Upišite adresu";}
if($data["pib"] == ""){$validation_message = "Upišite pib";}
if($data["maticni_broj"] == ""){$validation_message = "Upišite matični broj";}
if($data["mejl"] == ""){$validation_message = "Upišite mejl";}

if($validation_message == ""){
	$success = true;
	$message = "Sve je u redu";
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));

?>
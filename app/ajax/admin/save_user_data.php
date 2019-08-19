<?php
$data = $post_data['data'];
$success = false;
$message = 'Nothing happened :(';

//var_dump($post_data);

//OVDE PISEMO CELOKUPNU LOGIKU ZA OVU STRANICU

$validation_message = "";
if($data["name"] == ""){$validation_message = "Upisite ime";}
if($data["surname"] == ""){$validation_message = "Not valid surname";}
if($data["mail"] == ""){$validation_message = "Not valid mail";}

/*
Uz parametre koji se validiraju postoje jos i 
$data['password_1']
$data['password_2']
*/ 

if($validation_message == ""){
	$success = true;
	$message = "Podaci uspešno ažurirani";
}else{
	$message = $validation_message;
} 

echo json_encode(array("success"=>$success,"message"=>$message));
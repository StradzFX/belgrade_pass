<?php
$data = $post_data['data'];
$success = false;
$message = 'Morate odabrati iznos';
//var_dump($data);

$validation_message = "";

if($data["card_deposit_save"] == ""){$validation_message = "Odaberite iznos";}

if($validation_message == ""){
	$success = true;
	$message = "Uspesno ste izvršili prenos iznosa";
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));
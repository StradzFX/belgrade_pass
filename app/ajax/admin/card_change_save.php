<?php
$data = $post_data['data'];
$success = false;
$message = 'Morate odabrati broj';
//var_dump($data);

$validation_message = "";

if($data["card_number"] == ""){$validation_message = "Odaberite broj kartice";}

if($validation_message == ""){
	$success = true;
	$message = "Uspesno ste promenili broj kartice";
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));
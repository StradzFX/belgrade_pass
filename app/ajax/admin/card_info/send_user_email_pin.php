<?php
$data = $post_data['data'];
$success = false;
$message = 'Morate uneti e-mail adresu';

$validation_message = "";
if($data["text"] == ""){$validation_message = "Upišite e-mail adresu";}

if ($validation_message =="") {
	$success = true;
	$message = "Uspešno ste poslali e-mail sa pinom";
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));

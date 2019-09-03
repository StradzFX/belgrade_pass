<?php

global $broker;

$data = $post_data['data'];
$success = false;
$validation_message = "";

if($validation_message == ""){
	$SQL = "UPDATE company_transactions SET recordStatus = 'C' WHERE id = ".$data['id'];
	$broker->execute_query($SQL);
	$success = true;
	$message = "Uspešno ste obrisali uplatu";
}

echo json_encode(array("success"=>$success , "message"=>$message ));
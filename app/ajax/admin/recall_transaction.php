<?php
$data = $post_data['data'];
$success = false;
$validation_message = "";

if($validation_message ==""){
	$success=true;
	$message="Uspešno ste opozvali prenos kredita";
}else{
	$message="";
}

echo json_encode(array("success"=>$success, "message"=>$message));
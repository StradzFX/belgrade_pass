<?php
$data = $post_data['data'];
$success = false;
$validation_message = "";

if($validation_message == ""){
	$success = true;
	$message = "Štampanje poslato wajerlesom na stampac";
}

echo json_encode(array("success"=>$success , "message"=>$message ));
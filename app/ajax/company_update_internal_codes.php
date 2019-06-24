<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$data = $post_data['data'];
$stat_items = $data['stat_items'];
$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

$broker->execute_query("DELETE FROM internal_codes WHERE training_school = ".$company->id);

foreach ($stat_items as $key => $value) {
	$internal_codes = new internal_codes();
    $internal_codes->code_name = $value['name'];
    $internal_codes->training_school = $company->id;
    $internal_codes->code_value = $value['value'];
    $internal_codes->maker = 'system';
    $internal_codes->makerDate = date('c');
    $internal_codes->checker = 'system';
    $internal_codes->checkerDate = date('c');
    $internal_codes->jezik = 'rs';
    $internal_codes->recordStatus = 'O';
    
    $internal_codes = $broker->insert($internal_codes);

    $success = true;
    $message = 'Uspešno ste izmenili vredosti';
}

echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
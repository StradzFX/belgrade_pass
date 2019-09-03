<?php
global $broker;

$data = $post_data['data'];
$success = false;
$message = "Nista se nije desilo";

$validation_message = "";

if($data["cdr_id"] == ""){$validation_message = "Ne postoji company rule ID";}

if($validation_message == ""){
	$success = true;
	
	$company_discount_rules = $broker->get_data(new company_discount_rules($data["cdr_id"]));
    $company_discount_rules->recordStatus = 'C';
    $broker->update($company_discount_rules);

    $message = 'You have deleted discount rule';

} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));

?>
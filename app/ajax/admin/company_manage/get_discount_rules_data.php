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

} else {
	$message = $validation_message;
}

echo json_encode(array(
	"success"=>$success, 
	"message"=>$message, 
	"day_from"=>$company_discount_rules->day_from, 
	"day_to"=>$company_discount_rules->day_to, 
	"hours_from"=>$company_discount_rules->hours_from, 
	"hours_to"=>$company_discount_rules->hours_to, 
	"discount"=>$company_discount_rules->discount)
);

?>
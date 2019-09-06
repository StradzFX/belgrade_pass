<?php
global $broker;

$data = $post_data['data'];
$success = false;
$message = "Nista se nije desilo";

$validation_message = "";
if($data["company_id"] == ""){$validation_message = "Ne postoji company ID";}
if($data["cdr_id"] == ""){$validation_message = "Ne postoji company rule ID";}
if($data["cdr_day_from"]  > $data["cdr_day_to"]){$validation_message = "Day from must be lower than day to";}
if($data["cdr_day_from"] == ""){$validation_message = "Please insert day from";}
if($data["cdr_day_to"] == ""){$validation_message = "Please insert day to";}
if($data["cdr_hours_from"] == ""){$validation_message = "Please insert time from";}
if($data["cdr_hours_to"] == ""){$validation_message = "Please insert time to";}
if($data["cdr_discount"] < 0 || $data["cdr_discount"] > 100){$validation_message = "Discount must be between 0 and 100%";}
if(!is_numeric($data["cdr_discount"])){$validation_message = "Discount must be a number";}
if($data["cdr_discount"] == ""){$validation_message = "Please insert discount";}


if($validation_message == ""){
	$success = true;
	
	if($data["cdr_id"] == 0){
		//INsert u bazu
		$company_discount_rules = new company_discount_rules();
	    $company_discount_rules->training_school = $data['company_id'];
	    $company_discount_rules->day_from = $data['cdr_day_from'];
	    $company_discount_rules->day_to = $data['cdr_day_to'];
	    $company_discount_rules->hours_from = $data['cdr_hours_from'];
	    $company_discount_rules->hours_to = $data['cdr_hours_to'];
	    $company_discount_rules->discount = $data['cdr_discount'];
	    $company_discount_rules->maker = 'system';
	    $company_discount_rules->makerDate = date('c');
	    $company_discount_rules->checker = 'system';
	    $company_discount_rules->checkerDate = date('c');
	    $company_discount_rules->jezik = 'rs';
	    $company_discount_rules->recordStatus = 'O';
	    
	    $company_discount_rules = $broker->insert($company_discount_rules);
	    $message = "You have created new discount rule.";
	}else{
		$company_discount_rules = $broker->get_data(new company_discount_rules($data["cdr_id"]));

	    $company_discount_rules->day_from = $data['cdr_day_from'];
	    $company_discount_rules->day_to = $data['cdr_day_to'];
	    $company_discount_rules->hours_from = $data['cdr_hours_from'];
	    $company_discount_rules->hours_to = $data['cdr_hours_to'];
	    $company_discount_rules->discount = $data['cdr_discount'];

	    $broker->update($company_discount_rules);

	    $message = "You have updated discount rule.";
	}

} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));

?>
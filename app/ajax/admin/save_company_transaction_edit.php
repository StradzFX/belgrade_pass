<?php

$data = $post_data['data'];
$success = false;
$message = 'No changes were commited';

global $broker;

$validation_message = "";

if($data["edit_transaction_type"] == ""){$validation_message = "Morate odabrati tip transakcije";}
if($data["edit_transaction_value"] == ""){$validation_message = "Morate odabrati vrednost transakcije";}
if($data["edit_transaction_date"] == ""){$validation_message = "Morate odabrati datum transakcije";}


if($validation_message == ""){
	$success = true;
	$message = "Podatci uspešno ažurirani";
	$company_transactions = new company_transactions($data["edit_transaction_id"]);
	$company_transactions = $broker->get_data($company_transactions);
	$company_transactions->transaction_type = $data["edit_transaction_type"];
	$company_transactions->transaction_value = $data["edit_transaction_value"];
	$company_transactions->transaction_date = $data["edit_transaction_date"];

	$broker->update($company_transactions);

}else{
	$message = $validation_message;
}


echo json_encode(array("success"=>$success, "message"=>$message));
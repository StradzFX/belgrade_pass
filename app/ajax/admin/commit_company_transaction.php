<?php
global $broker;

$data = $post_data['data'];
$succes = false;
$message = 'Morate popuniti sva polja';

$validation_message = "";

if($data["transaction_type"] == ""){$validation_message = "Morate odabrati tip transakcije";}
if($data["transaction_value"] == ""){$validation_message = "Morate odabarati vrednost transakcije";}
if($data["transaction_date"] == ""){$validation_message = "Morate odabrati datum";}

if($validation_message == ""){
	$company_transaction = new company_transactions();
	$company_transaction->training_school = $data['id'];
	$company_transaction->transaction_type = $data['transaction_type'];
	$company_transaction->transaction_value = $data['transaction_value'];
	$company_transaction->transaction_date = $data['transaction_date'];
	$company_transaction->maker = 'app';
	$company_transaction->makerDate = date('c');
	$company_transaction->checker = 'app';
	$company_transaction->checkerDate = date('c');
	$company_transaction->pozicija = '0';
	$company_transaction->jezik = 'rs';
	$company_transaction->recordStatus = 'O';
	$company_transaction->modNumber = 0;
	$company_transaction->multilang_id = 0;

	$company_transaction = $broker->insert($company_transaction);
	//
	$success = true;
	$message = 'All ok';
} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message));
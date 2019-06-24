<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$data = $post_data['data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}

if($validation_message == ""){

	$cbr = $broker->get_data(new company_birthday_reservation($data['id']));
	$cbd = $broker->get_data(new company_birthday_data($cbr->company_birthday_data));

	$SQL = "UPDATE company_birthday_reservation SET status = 'rejected' WHERE id = ".$cbr->id;
	$broker->execute_query($SQL);

	$success = true;
	$message = 'All ok';
}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
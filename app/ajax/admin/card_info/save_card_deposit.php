<?php
$data = $post_data['data'];
$success = false;
$message = 'Morate odabrati iznos';
$id = null;
//var_dump($data);

$validation_message = "";

if($data["card_deposit_save"] == ""){$validation_message = "Odaberite iznos";}

if($validation_message == ""){
	$success = true;
	$message = "Uspesno ste izvršili prenos iznosa";
	global $broker;


	$data['card_number'] = $data['id'];
	$data['package'] = $data['card_deposit_save'];
	$card_package = $broker->get_data(new card_package($data['package']));
	$data['price'] = $card_package->price;

	list($success,$message,$id) = PaymentModule::save_admin_payment($data);


	$user_credits = "SELECT SUM(price) AS total FROM purchase WHERE user_card = ".$data['id']." AND checker != ''";
	$user_credits = $broker->execute_sql_get_array($user_credits);
	$user_credits = $user_credits[0]['total'];

	$user_debits = "SELECT SUM(taken_passes) AS total FROM accepted_passes WHERE user_card = ".$data['id']." AND checker != ''";
	$user_debits = $broker->execute_sql_get_array($user_debits);
	$user_debits = $user_debits[0]['total'];

	$user_balance = $user_credits - $user_debits;







} else {
	$message = $validation_message;
}

echo json_encode(array("success"=>$success, "message"=>$message, "id"=>$id, "user_balance" => $user_balance));
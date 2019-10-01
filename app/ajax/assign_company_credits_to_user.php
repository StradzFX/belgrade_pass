<?php
global $_CORE;

$success = false;
$message = "POST was made";
$post_data = $_POST;
$card_data = $post_data['card_data'];

$reg_user = $broker->get_session('user');
$id = null;
$payment_url = null;

$validation_message = "";
if(!$reg_user){$validation_message = "Niste ulogovani.";}
if($card_data["card_id"] == ""){$validation_message = "Molimo Vas odaberite karticu";}
if($card_data["selected_amount"] <= 0){$validation_message = "Molimo Vas odaberite iznos koji je veci od 0";}
if($card_data["selected_amount"] == ""){$validation_message = "Molimo Vas odaberite iznos";}

if($validation_message == ""){

    $card = $broker->get_data(new user_card($card_data["card_id"]));
    $user = $broker->get_data(new user($card->user));
    $duration_days = 365;

    $reg_user->card = CardModule::get_company_mster_card($reg_user->id);

	$purchase = new purchase();
    $purchase->user = $reg_user->id;
    $purchase->price = '-'.$card_data["selected_amount"];
    $purchase->to_company = '-'.$card_data["selected_amount"];
    $purchase->to_us = 0;
    $purchase->duration_days = $duration_days;
    $purchase->number_of_passes = '-'.$card_data["selected_amount"];
    $purchase->start_date = date('Y-m-d');
    $purchase->end_date = date('Y-m-d',strtotime('+'.$duration_days.' days'));
    $purchase->purchase_type = 'company_credits';
    $purchase->company_flag = '0';
    $purchase->po_name = '';
    $purchase->po_address = '';
    $purchase->po_city = '';
    $purchase->po_postal = '';
    $purchase->card_package = 'NULL';
    $purchase->user_card = $reg_user->card->id;
    $purchase->maker = 'system';
    $purchase->makerDate = date('c');
    $purchase->checker = 'system';
    $purchase->checkerDate = date('c');
    $purchase->jezik = 'rs';
    $purchase->recordStatus = 'O';

    $purchase = $broker->insert($purchase);

    $purchase = new purchase();
    $purchase->user = $user->id;
    $purchase->price = $card_data["selected_amount"];
    $purchase->to_company = $card_data["selected_amount"];
    $purchase->to_us = 0;
    $purchase->duration_days = $duration_days;
    $purchase->number_of_passes = $card_data["selected_amount"];
    $purchase->start_date = date('Y-m-d');
    $purchase->end_date = date('Y-m-d',strtotime('+'.$duration_days.' days'));
    $purchase->purchase_type = 'company_credits';
    $purchase->company_flag = '0';
    $purchase->po_name = '';
    $purchase->po_address = '';
    $purchase->po_city = '';
    $purchase->po_postal = '';
    $purchase->card_package = 'NULL';
    $purchase->user_card = $card_data['card_id'];
    $purchase->maker = 'system';
    $purchase->makerDate = date('c');
    $purchase->checker = 'system';
    $purchase->checkerDate = date('c');
    $purchase->jezik = 'rs';
    $purchase->recordStatus = 'O';

    $purchase = $broker->insert($purchase);

    $transactions = new transactions();
    $transactions->transaction_type = 'company_credits';
    $transactions->tranaction_id = $purchase->id;
    $transactions->user = $user->id;
    $transactions->maker = 'system';
    $transactions->makerDate = date('c');
    $transactions->checker = 'system';
    $transactions->checkerDate = date('c');
    $transactions->jezik = 'rs';
    $transactions->recordStatus = 'O';
    
    $transactions = $broker->insert($transactions);

    $success = true;
    $message = 'Dodelili ste kredite';

    $id = $purchase->id;
}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
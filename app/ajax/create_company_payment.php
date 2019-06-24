<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$payment_data = $post_data['payment_data'];

$company = $broker->get_session('company');
$id = null;

$validation_message = "";
if(!$company){$validation_message = "Niste ulogovani.";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}
if($payment_data["card_number"] == ""){$validation_message = "Molimo Vas da upišete broj kartice";}
if($payment_data["selected_package"] == ""){$validation_message = "Molimo Vas da odaberete paket";}

if($validation_message == ""){

	$id = $payment_data["selected_package"];
	if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new card_package($id))){
	  include_once 'template/header.php';
	  include_once 'error_pages/error404.php';
	  include_once 'template/footer.php';
	  die();
	}
	$card_package = $broker->get_data(new card_package($id));

    $card_number = HelperModule::translate_card_number_format($payment_data["card_number"]);

    $user_card_all = new user_card();
    $user_card_all->set_condition('checker','!=','');
    $user_card_all->add_condition('recordStatus','=','O');
    $user_card_all->add_condition('card_number','=',$card_number);
    $user_card_all->set_order_by('pozicija','DESC');
    $user_card_all = $broker->get_all_data_condition($user_card_all);

    if(sizeof($user_card_all) > 0){
        $user_card = $user_card_all[0];
        $user_card->user = $broker->get_data(new user($user_card->user));
    }else{
        $user_card = null;
    }

    if($user_card){
        $purchase = new purchase();
        $purchase->user = $user_card->user->id == '' ? 'NULL' : $user_card->user->id;
        $purchase->price = $card_package->price;
        $purchase->to_company = $card_package->to_company;
        $purchase->to_us = $card_package->to_us;
        $purchase->duration_days = $card_package->duration_days;
        $purchase->number_of_passes = $card_package->number_of_passes;
        $purchase->start_date = date('Y-m-d');
        $purchase->end_date = date('Y-m-d',strtotime('+'.$card_package->duration_days.' days'));
        $purchase->purchase_type = 'company';
        $purchase->company_flag = $company->id;
        $purchase->company_location = $company->location->id;
        $purchase->po_name = '';
        $purchase->po_address = '';
        $purchase->po_city = '';
        $purchase->po_postal = '';
        $purchase->card_package = $card_package->id;
        $purchase->user_card = $user_card->id;
        $purchase->maker = 'company';
        $purchase->makerDate = date('c');
        $purchase->checker = 'company';
        $purchase->checkerDate = date('c');
        $purchase->jezik = 'rs';
        $purchase->recordStatus = 'O';
        $purchase = $broker->insert($purchase);

        $transactions = new transactions();
        $transactions->transaction_type = 'purchase_company';
        $transactions->tranaction_id = $purchase->id;
        $transactions->user = $user_card->user->id == '' ? 'NULL' : $user_card->user->id;
        $transactions->maker = 'company';
        $transactions->makerDate = date('c');
        $transactions->checker = 'company';
        $transactions->checkerDate = date('c');
        $transactions->jezik = 'rs';
        $transactions->recordStatus = 'O';
        
        $transactions = $broker->insert($transactions);

        $id = $purchase->id;

        $success = true;
        $message = "All OK";
    }else{
        $message = 'Kartica koju ste uneli ne postoji u sistemu.';
    }

	
}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
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
if($card_data["user_card"] == ""){$validation_message = "Molimo Vas odaberite karticu";}
if($card_data["package"] == ""){$validation_message = "Molimo Vas odaberite paket";}

if($validation_message == ""){

	$id = $card_data["package"];
	if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new card_package($id))){
	  include_once 'template/header.php';
	  include_once 'error_pages/error404.php';
	  include_once 'template/footer.php';
	  die();
	}
	$card_package = $broker->get_data(new card_package($id));


	$purchase = new purchase();
    $purchase->user = $reg_user->id;
    $purchase->price = $card_package->price;
    $purchase->to_company = $card_package->price;
    $purchase->to_us = $card_package->to_us;
    $purchase->duration_days = $card_package->duration_days;
    $purchase->number_of_passes = $card_package->number_of_passes;
    $purchase->start_date = date('Y-m-d');
    $purchase->end_date = date('Y-m-d',strtotime('+'.$card_package->duration_days.' days'));
    $purchase->purchase_type = 'credit_card';
    $purchase->company_flag = '0';
    $purchase->po_name = '';
    $purchase->po_address = '';
    $purchase->po_city = '';
    $purchase->po_postal = '';
    $purchase->card_package = $card_package->id;
    $purchase->user_card = $card_data['user_card'];
    $purchase->maker = 'system';
    $purchase->makerDate = date('c');
    $purchase->checkerDate = date('c');
    $purchase->jezik = 'rs';
    $purchase->recordStatus = 'O';

    $purchase = $broker->insert($purchase);

    $post_tran_variables = array(
     'ACTION' => 'SESSIONTOKEN',
     'SESSIONTYPE' => 'PAYMENTSESSION',
     'MERCHANTUSER' => $_CORE['asseco']['MERCHANTUSER'],
     'MERCHANTPASSWORD' => $_CORE['asseco']['MERCHANTPASSWORD'],
     'MERCHANT' => $_CORE['asseco']['MERCHANT'],
     'CUSTOMER' => $reg_user->id,
     'CUSTOMEREMAIL' => $reg_user->email,
     'CUSTOMERNAME' => $reg_user->first_name.' '.$reg_user->last_name,
     'CUSTOMERPHONE' => 'n/a',
     
     'MERCHANTPAYMENTID' => 'kp_'.date('Ymd').'_'.$purchase->id,
     'AMOUNT' => $purchase->price,
     'CURRENCY' => 'RSD',
     
     'RETURNURL' => $base_url.'payment_card_feedback/',
     );

    $ch = curl_init($_CORE['asseco']['API_PATH']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_tran_variables);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

    if(curl_error($ch) == ''){
        $response = json_decode($response,true);
        $card_active_token = $response['sessionToken'];
        $purchase->card_active_token = $card_active_token;
        $broker->update($purchase);
        $success = true;
        $message = 'Purchase reserved.';

        $payment_url = $_CORE['asseco']['PAYMENT_PAGE'].$card_active_token;
    }else{
        $message = 'Greska u komunikaciji sa platnim karticama. Kontaktirajte sajt.';
    }

    $transactions = new transactions();
    $transactions->transaction_type = 'purchase_card';
    $transactions->tranaction_id = $purchase->id;
    $transactions->user = $reg_user->id;
    $transactions->maker = 'system';
    $transactions->makerDate = date('c');
    $transactions->checker = 'system';
    $transactions->checkerDate = date('c');
    $transactions->jezik = 'rs';
    $transactions->recordStatus = 'O';
    
    $transactions = $broker->insert($transactions);

    $id = $purchase->id;
}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message,"payment_url"=>$payment_url));
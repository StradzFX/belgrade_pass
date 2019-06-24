<?php

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Plaćanje platnom karticom";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================


if(isset($_POST['merchantPaymentId'])){
	
}

if($_POST['merchantPaymentId'] != ''){

	$ems_response = new ems_response();
    $ems_response->whole_response = json_encode($_POST);;
    $ems_response->response_date = date('Y-m-d');
    $ems_response->maker = 'system';
    $ems_response->makerDate = date('c');
    $ems_response->checker = 'system';
    $ems_response->checkerDate = date('c');
    $ems_response->jezik = 'rs';
    $ems_response->recordStatus = 'O';
    
    $ems_response = $broker->insert($ems_response);


	$_POST['merchantPaymentId'] = explode('_', $_POST['merchantPaymentId']);
	$_POST['merchantPaymentId'] = $_POST['merchantPaymentId'][sizeof($_POST['merchantPaymentId'])-1];

	$id = $_POST['merchantPaymentId'];
	if($id < 0 || !is_numeric($id) || !$broker->does_key_exists(new purchase($id))){
	  include_once 'template/header.php';
	  include_once 'error_pages/error404.php';
	  include_once 'template/footer.php';
	  die();
	}
	$purchase = $broker->get_data(new purchase($id));

	foreach ($_POST as $key => $value) {
		$purchase->$key = addslashes($value);
	}

	if($_POST['responseCode'] == '00'){
		$purchase->checker = 'card_pay';
		
	}

	$package = $broker->get_data(new card_package($purchase->card_package));

	$broker->update($purchase);

	require_once "vendor/phpmailer/mail_config.php";
	require_once "vendor/phpmailer/wl_mailer.class.php";

	$mail_html = file_get_contents('app/mailer/html/general_template.html');
	$mail_html_content = file_get_contents('app/mailer/html/content_payment_card.html');
	$mail_html = str_replace('{content}', $mail_html_content, $mail_html);

	$wl_mailer = new wl_mailer($host_email,$host_password,array($sender_email,$sender_name),array($replier_email,$replier_name),$host,$port); 
	$wl_mailer->set_subject('Plaćanje platnom karticom - Status transakcije');
	

	$user = $broker->get_data(new user($purchase->user));
	if($user->email != ''){
		$wl_mailer->add_address($user->email,'');
		$wl_mailer->add_image("public/images/mailer/company_logo.png", "company_logo", "company_logo.png");
		/*
		
		for($i=0;$i<sizeof($kuponi_slike_array);$i++){
			$wl_mailer->add_image($kuponi_slike_array[$i], "kupon_".$i, $kuponi_slike_array_naziv[$i]);
		}*/
	}

	$email_data = array();
	$email_data['transaction_status_text'] = $purchase->responseCode == '00' ? 'Plaćanje je uspešno' : 'Plaćanje nije uspešno, vaš račun nije zadužen. Najčešći uzrok je pogrešno unet broj kartice, datum isteka ili sigurnosni kod. Pokušajte ponovo, a u slučaju uzastopnih grešaka pozovite vašu banku';
	$email_data['user_name'] = $user->first_name.' '.$user->last_name;
	$email_data['user_email'] = $user->email;
	$email_data['order_name'] = 'Kupovina paketa "'.$package->name.'" na sajtu www.Belgrade Pass.rs';
	$email_data['order_quantity'] = '1';
	$email_data['order_price'] = $purchase->amount.' RSD';
	$email_data['order_tax'] = '0 RSD';
	$email_data['order_total_price'] = $purchase->amount.' RSD';
	$email_data['order_id'] = $purchase->id;
	$email_data['merchant_name'] = 'Belgrade Pass doo';
	$email_data['merchant_address'] = 'Veljka Dugoševića 54';
	$email_data['merchant_reg_id'] = '	111202038';
	$email_data['transaction_id'] = $purchase->pgTranId;
	$email_data['transaction_authorisation_code'] = $purchase->pgTranApprCode == '' ? '' : '<tr>
		<td><b>Autorizacioni kod</b></td>
		<td>'.$purchase->pgTranApprCode.'</td>
	</tr>';
	$email_data['transaction_status'] = $purchase->responseMsg;
	$email_data['transaction_status_code'] = $purchase->responseCode;
	$email_data['transaction_date'] = date('d.m.Y');
	$email_data['transaction_amount'] = $purchase->amount.' RSD';
	$email_data['transaction_referrer_id'] = $purchase->pgTranRefId;

	foreach ($email_data as $key => $value) {
		$mail_html = str_replace('{'.$key.'}', $value, $mail_html);
	}

	$wl_mailer->set_email_content($mail_html);

	$wl_mailer->send_email();
}else{
	header('Location:'.$base_url.'kupi_paket/');
	die();
}

$payment_data = array();
$payment_data['user'] = array(
	'name' => $user->first_name.' '.$user->last_name,
	'email' => $user->email
);

$payment_data['order'] = array(
	'name' => 'Kupovina paketa "'.$package->name.'" na sajtu www.Belgrade Pass.rs',
	'quantity' => '1',
	'price' => $purchase->amount,
	'tax' => '0',
	'total_price' => $purchase->amount,
	'id' => $purchase->id
);

$payment_data['transaction'] = array(
	'id' => $purchase->pgTranId,
	'authorisation_code' => $purchase->pgTranApprCode,
	'status' => $purchase->responseMsg,
	'status_code' => $purchase->responseCode,
	'status_error_text' => $purchase->pgTranErrorText,
	'purchase_date' => date('d.m.Y'),
	'price' => $purchase->amount,
	'reffer_id' => $purchase->pgTranRefId
);
<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$users = $post_data['users'];

$reg_user = $broker->get_session('user');

$validation_message = "";

for ($i=0; $i < sizeof($users); $i++) { 
	if($users[$i]['first_name'] == ''){
		$validation_message = 'Sva imena moraju biti popunjena';
		break;
	}

	if($users[$i]['last_name'] == ''){
		$validation_message = 'Sva prezimena moraju biti popunjena';
		break;
	}

	if($users[$i]['email'] == ''){
		$validation_message = 'Sve email adrese moraju biti popunjene';
		break;
	}
}

if($validation_message == ""){

	for ($i=0; $i < sizeof($users); $i++) { 
		$card = CardModule::create_card($users[$i]['first_name'],$users[$i]['last_name'],$users[$i]['email'],$reg_user->id);
    	if($card){
    		/*$transaction = PaymentModule::create_post_office_payment($card->id,$users[$i]['credits'],$reg_user->id);
    		if($transaction){
    			$id = $transaction->id;
    		}

    		EmailMoodule::send_company_user_new_card($users[$i]['email'],$card,$reg_user);*/

    		$success = true;
		    $message = "Odobrena Vam je kartica.";
    	}else{
    		$message = 'Sistemska greska prilikom otvaranja kartice.';
    	}
	}
}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
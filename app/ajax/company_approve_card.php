<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$company = $broker->get_session('company');

$validation_message = "";
$user_card = null;

if(!$company){$validation_message = "Niste ulogovani";}
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}
if($card_data["card_number"] == ""){$validation_message = "Popunite broj kartice";}

if($validation_message == ""){

	$card_number = HelperModule::translate_card_number_format($card_data["card_number"]);

	$card_numbers_all = new card_numbers();
	$card_numbers_all->set_condition('checker','!=','');
	$card_numbers_all->add_condition('recordStatus','=','O');
	$card_numbers_all->add_condition('card_number','=',$card_number);
	$card_numbers_all->set_limit(1);
	$card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

	if(sizeof($card_numbers_all) > 0){
		$available_card = $card_numbers_all[0];

		if($available_card->company_card == $company->id){
			if($available_card->company_location == $company->location->id){
				if($available_card->card_taken == 0){
					$user_card = new user_card();
				    $user_card->card_number = $available_card->card_number;
				    $user_card->card_password = $available_card->card_password;
				    $user_card->parent_name = '';
				    $user_card->child_name = '';
				    $user_card->child_birthdate = '';
				    $user_card->company_location = $company->location->id;

				    $user_card->delivery_method = 'partner';

				    $user_card->post_street = '';
				    $user_card->post_city = '';
				    $user_card->post_postal = '';
				    $user_card->customer_received = 1;

				    $user_card->partner_id = $company->id;
				    
				    $user_card->user = 'NULL';
				    $user_card->maker = 'system';
				    $user_card->makerDate = date('c');
				    $user_card->checker = 'system';
				    $user_card->checkerDate = date('c');
				    $user_card->jezik = 'rs';
				    $user_card->recordStatus = 'O';
				    
				    $user_card = $broker->insert($user_card);

				    $available_card->card_taken = 1;
				    $broker->update($available_card);

				    $success = true;
				    $message = "Aktivirana je kartica.";
				}else{
					$message = 'Ova kartica je već aktivirana.';
				}
			}else{
				$message = 'Ova kartica nije dostupna za aktivaciju na vašoj lokaciji.';
			}
		}else{
			$message = 'Ova kartica nije dostupna za aktivaciju kod vas kao partnera.';
		}
	}else{
		$message = 'Ova kartica ne postoji u sistemu';
	}

}else{
	$message = $validation_message;
} 


echo json_encode(array("success"=>$success,"message"=>$message,"card"=>$user_card));
die();
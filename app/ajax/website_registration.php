<?php

	$success = false;
	$message = "POST was made";
	$post_data = $_POST;
	$user_data = $post_data["user_data"];

	$validation_message = "";
	$id = 0;
	
	
	$user_type = $user_data["user_type"];

	if($user_data["password_again"] != $user_data["password"]){$validation_message = "Lozinke moraju da se podudaraju.";}
	if($user_data["password_again"] == ""){$validation_message = "Molimo Vas da ponovite lozinku.";}
	if($user_data["password"] == ""){$validation_message = "Molimo Vas da unesete lozinku.";}
	if(!filter_var($user_data["email"], FILTER_VALIDATE_EMAIL)){$validation_message = "Molimo Vas da unesete validan email.";}

	if($user_type == 'fizicko'){
		if($user_data["last_name"] == ""){$validation_message = "Molimo Vas da unesete prezime.";}
		if($user_data["first_name"] == ""){$validation_message = "Molimo Vas da unesete ime.";}
	}

	if($user_type == 'pravno'){
		if($user_data["maticni"] == ""){$validation_message = "Molimo Vas da unesete matični broj.";}
		if($user_data["pib"] == ""){$validation_message = "Molimo Vas da unesete pib.";}
		if($user_data["adresa"] == ""){$validation_message = "Molimo Vas da unesete adresu.";}
		if($user_data["naziv"] == ""){$validation_message = "Molimo Vas da unesete naziv preduzeća.";}
	}


	
	

	if($validation_message == ""){
		$user_insert_validation = new user();
		$user_insert_validation->set_condition('recordStatus','=','O');
		$user_insert_validation->add_condition('checker','!=','');
		$user_insert_validation->add_condition('email','=',$user_data["email"]);
		$user_insert_validation->set_order_by('id','DESC');
		$user_insert_validation = $broker->get_all_data_condition($user_insert_validation);

		if(sizeof($user_insert_validation) == 0){         
		    $user = new user();
		    $user->user_type = $user_data["user_type"];
		    $user->email = $user_data["email"];
		    $user->password = md5($user_data["password"]);

		    $user->fb_id = '';
		    $user->first_name = $user_data["first_name"];
		    $user->last_name = $user_data["last_name"];

		    $user->naziv = $user_data["naziv"];
		    $user->adresa = $user_data["adresa"];
		    $user->pib = $user_data["pib"];
		    $user->maticni = $user_data["maticni"];

		    $user->avatar = '';
		    $user->maker = 'system';
		    $user->makerDate = date('c');
		    $user->checker = 'system';
		    $user->checkerDate = date('c');
		    $user->jezik = 'rs';
		    $user->recordStatus = 'O';
		    
		    $user = $broker->insert($user);
		    $success = true;
		    $message = "Kreirali ste nalog.";
		    $broker->set_session('user',$user);

		   
			
			

		    if($user->user_type == 'fizicko'){
		    	$card = CardModule::create_card($user->first_name,$user->last_name,$user->email,$user->id);
		    	if($card){
		    		EmailMoodule::send_retail_user_registration($user,$card);
		    		$transaction = PaymentModule::create_post_office_payment($card->id,$user_data['selected_amount'],$user->id);
		    		if($transaction){
		    			$id = $transaction->id;
		    			EmailMoodule::send_new_purchase_reservation($user,$card,$transaction);
		    		}
		    	}

		    	


				
		    }

		    if($user->user_type == 'pravno'){
		    	$card = CardModule::create_card_legal($user->naziv,$user->email,$user->id);
		    	if($card){
		    		EmailMoodule::send_legal_user_registration($user,$card);
		    		$transaction = PaymentModule::create_invoice_payment($card->id,$user_data['selected_amount_legal'],$user->id);
		    		if($transaction){
		    			$id = $transaction->id;
		    			EmailMoodule::send_new_purchase_reservation_legal_user($user,$card,$transaction);
		    		}
		    	}
		    }   

		}else{
		    $success = false;
		    $message = "Email koji ste uneli već postoji u bazi podataka.";
		}

	}else{
		$message = $validation_message;
	} 

	echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
	die();
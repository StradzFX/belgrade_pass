<?php

class PaymentModule{

	public static function list_payments_admin($payment_type=null,$search_term=null,$limit=null){
		global $broker;

		$list = new purchase();
		$list->add_condition('recordStatus','=','O');
		if($payment_type){
			$list->add_condition('purchase_type','=',$payment_type);
		}

		if($search_term){
			$list->add_condition('','',"(id = $search_term OR po_name LIKE '%$search_term%')");
		}
		$list->set_order_by('id','DESC');
		if($limit){
			$list->set_limit($limit);
			$list = $broker->get_all_data_condition_limited($list);
		}else{
			$list = $broker->get_all_data_condition($list);
		}
		

		foreach ($list as $key => $value) {
			$list[$key]->user = $broker->get_data(new user($list[$key]->user));
			$list[$key]->user_card = $broker->get_data(new user_card($list[$key]->user_card));
			$list[$key]->card_package = $broker->get_data(new card_package($list[$key]->card_package));
			
			$list[$key]->status = $list[$key]->checker != '' ? 'Approved' : 'Not Approved';
			if($list[$key]->company_flag > 0){
				$list[$key]->company = $broker->get_data(new training_school($list[$key]->company_flag));
			}
		}

		return $list;
	}


	public static function save_admin_payment($data){
		global $broker;

		$success = false;
		$message = 'Entered into school save section, but could not save it';
		$id = null;

		$error_message = null;
		if($data['card_number'] == ''){$error_message = 'Please select card number.';}
		if($data['package'] == ''){$error_message = 'Please select package.';}
		if($data['price'] == ''){$error_message = 'Please insert price and it must be numberic value.';}

		if(!$error_message){
			$data['package'] = explode(',', $data['package']);
			$data['package'] = $data['package'][0];
			$card_package = $broker->get_data(new card_package($data['package']));

			$user_card = $broker->get_data(new user_card($data['card_number']));
			$user = null;
			if($user_card->user != ''){$user = $broker->get_data(new user($user_card->user));}


			$purchase = new purchase();
			if($user){
				$purchase->user = $user->id;
			}else{
				$purchase->user = 'NULL';
			}


		    $purchase->price = $data['price'];
		    $purchase->to_company = $card_package->price;
		    $purchase->to_us = $card_package->to_us;
		    $purchase->duration_days = $card_package->duration_days;
		    $purchase->number_of_passes = $card_package->number_of_passes;
		    $purchase->start_date = date('Y-m-d');
		    $purchase->end_date = date('Y-m-d',strtotime('+'.$card_package->duration_days.' days'));
		    $purchase->purchase_type = 'admin_payment';
		    $purchase->company_flag = '0';
		    $purchase->po_name = '';
		    $purchase->po_address = '';
		    $purchase->po_city = '';
		    $purchase->po_postal = '';
		    $purchase->card_package = $card_package->id;
		    $purchase->user_card = $user_card->id;
		    $purchase->maker = 'system';
		    $purchase->makerDate = date('c');
		    $purchase->checker = 'admin';
		    $purchase->checkerDate = date('c');
		    $purchase->jezik = 'rs';
		    $purchase->recordStatus = 'O';

		    $purchase = $broker->insert($purchase);

		    if($user){
				$transactions = new transactions();
			    $transactions->transaction_type = 'purchase_admin_payment';
			    $transactions->tranaction_id = $purchase->id;
			    $transactions->user = $reg_user->id;
			    $transactions->maker = 'system';
			    $transactions->makerDate = date('c');
			    $transactions->checker = 'system';
			    $transactions->checkerDate = date('c');
			    $transactions->jezik = 'rs';
			    $transactions->recordStatus = 'O';
			    
			    $transactions = $broker->insert($transactions);
		    }

		    

		    $id = $purchase->id;

		    $success = true;
			$message = "Uplacen je kredit na karticu.";

		}else{
			$message = $error_message;
		}
		

		return array($success,$message,$id);
	}

	public static function total(){
		global $broker;

		$list = new purchase();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('purchase_type','!=','admin_payment');
		return $broker->get_count_condition($list);
	}


	public static function get_total_active_packages($user_card_id){
		global $broker;
		$list = new purchase();
		$list->set_condition('checker','!=','');
		$list->add_condition('recordStatus','=','O');
		$list->add_condition('end_date','>=',date('Y-m-d'));
		$list->add_condition('user_card','=',$user_card_id);
		return $broker->get_count_condition($list);
	}

	public static function create_post_office_payment($user_card_id,$amount,$user_id){
		global $broker;

		$card_package = PackageModule::get_package_by_amount($amount);

		if($card_package){
			$purchase = new purchase();
		    $purchase->user = $user_id;
		    $purchase->price = $card_package->price;
		    $purchase->to_company = $card_package->price;
		    $purchase->to_us = $card_package->to_us;
		    $purchase->duration_days = $card_package->duration_days;
		    $purchase->number_of_passes = $card_package->number_of_passes;
		    $purchase->start_date = date('Y-m-d');
		    $purchase->end_date = date('Y-m-d',strtotime('+'.$card_package->duration_days.' days'));
		    $purchase->purchase_type = 'post_office';
		    $purchase->company_flag = '0';
		    $purchase->po_name = '';
		    $purchase->po_address = '';
		    $purchase->po_city = '';
		    $purchase->po_postal = '';
		    $purchase->card_package = $card_package->id;
		    $purchase->user_card = $user_card_id;
		    $purchase->maker = 'system';
		    $purchase->makerDate = date('c');
		    $purchase->checkerDate = date('c');
		    $purchase->jezik = 'rs';
		    $purchase->recordStatus = 'O';

		    $purchase = $broker->insert($purchase);

		    self::create_post_office_image($purchase,$card_package);

		    $transactions = new transactions();
		    $transactions->transaction_type = 'purchase_post_office';
		    $transactions->tranaction_id = $purchase->id;
		    $transactions->user = $user_id;
		    $transactions->maker = 'system';
		    $transactions->makerDate = date('c');
		    $transactions->checker = 'system';
		    $transactions->checkerDate = date('c');
		    $transactions->jezik = 'rs';
		    $transactions->recordStatus = 'O';
		    
		    $transactions = $broker->insert($transactions);

		    return $purchase;
		}else{
			return null;
		}
	}

	public static function create_post_office_image($purchase,$card_package){
		$font = realpath('public/post_office_template/arial.ttf');
		$source_image = imagecreatefrompng('public/post_office_template/uplatnica.png');
		$image_to_display = imagecreatetruecolor(600, 300);
		imagecopy($image_to_display, $source_image, 0, 0, 0, 0, 600, 300);

		// Create some colors
		$white = imagecolorallocate($image_to_display, 255, 255, 255);
		$black = imagecolorallocate($image_to_display, 0, 0, 0);

		// Image,Size,Angle,X,Y,Color,Font,Text
		imagettftext($image_to_display, 10, 0, 30, 65, $black, $font, 'IME I PREZIME');
		imagettftext($image_to_display, 10, 0, 30, 80, $black, $font, 'ULICA');
		imagettftext($image_to_display, 10, 0, 30, 135, $black, $font, "Uplata ".$purchase->price." kredita");
		imagettftext($image_to_display, 10, 0, 30, 190, $black, $font, "CITY PASS DOO, GENERAL");
		imagettftext($image_to_display, 10, 0, 30, 205, $black, $font, "ŽDANOVA 1E 1, 11010 BEOGRAD");
		imagettftext($image_to_display, 10, 0, 365, 70, $black, $font, "RSD");
		imagettftext($image_to_display, 10, 0, 450, 70, $black, $font, $purchase->price);
		imagettftext($image_to_display, 10, 0, 400, 122, $black, $font, "160-0000000370918-09");
		imagettftext($image_to_display, 10, 0, 400, 162, $black, $font, $purchase->id);
		imagejpeg($image_to_display,'public/images/post_office/'.$purchase->id.'.jpg');
	}

	
}
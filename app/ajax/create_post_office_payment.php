<?php

$success = false;
$message = "POST was made";
$post_data = $_POST;
$post_office_data = $post_data['post_office_data'];

$reg_user = $broker->get_session('user');
$id = null;

$validation_message = "";
if(!$reg_user){$validation_message = "Niste ulogovani.";}
if($post_office_data["po_name"] == ""){$validation_message = "Molimo Vas upisite ime";}
if($post_office_data["po_city"] == ""){$validation_message = "Molimo Vas upisite grad";}
if($post_office_data["po_address"] == ""){$validation_message = "Molimo Vas upisite adresu";}
if($post_office_data["po_postal"] == ""){$validation_message = "Molimo Vas upisite postanski broj";}
if($post_office_data["user_card"] == ""){$validation_message = "Molimo Vas odaberite karticu";}
if($post_office_data["package"] == ""){$validation_message = "Molimo Vas odaberite paket";}

if($validation_message == ""){

	$id = $post_office_data["package"];
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
    $purchase->purchase_type = 'post_office';
    $purchase->company_flag = '0';
    $purchase->po_name = $post_office_data['po_name'];
    $purchase->po_address = $post_office_data['po_address'];
    $purchase->po_city = $post_office_data['po_city'];
    $purchase->po_postal = $post_office_data['po_postal'];
    $purchase->card_package = $card_package->id;
    $purchase->user_card = $post_office_data['user_card'];
    $purchase->maker = 'system';
    $purchase->makerDate = date('c');
    $purchase->checkerDate = date('c');
    $purchase->jezik = 'rs';
    $purchase->recordStatus = 'O';

    $purchase = $broker->insert($purchase);

    $transactions = new transactions();
    $transactions->transaction_type = 'purchase_post_office';
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




	$font = 'public/post_office_template/arial.ttf';
	$source_image = imagecreatefrompng('public/post_office_template/uplatnica.png');
	$image_to_display = imagecreatetruecolor(600, 300);
	imagecopy($image_to_display, $source_image, 0, 0, 0, 0, 600, 300);

	// Create some colors
	$white = imagecolorallocate($image_to_display, 255, 255, 255);
	$black = imagecolorallocate($image_to_display, 0, 0, 0);

	// Image,Size,Angle,X,Y,Color,Font,Text
	imagettftext($image_to_display, 10, 0, 30, 65, $black, $font, $purchase->po_name);
	imagettftext($image_to_display, 10, 0, 30, 80, $black, $font, $purchase->po_address.', '.$purchase->po_city);
	imagettftext($image_to_display, 10, 0, 30, 135, $black, $font, "Uplata za paket ".$card_package->name);
	imagettftext($image_to_display, 10, 0, 30, 190, $black, $font, "KIDPASS d.o.o., Nehruova 68");
	imagettftext($image_to_display, 10, 0, 30, 205, $black, $font, "11070, Novi Beograd");
	imagettftext($image_to_display, 10, 0, 365, 70, $black, $font, "RSD");
	imagettftext($image_to_display, 10, 0, 450, 70, $black, $font, $purchase->price);
	imagettftext($image_to_display, 10, 0, 400, 122, $black, $font, "340-0000011022416-79");
	imagettftext($image_to_display, 10, 0, 400, 162, $black, $font, $purchase->id);
	imagejpeg($image_to_display,'public/images/post_office/'.$purchase->id.'.jpg');

	$success = true;
	$message = "All OK";
}else{
	$message = $validation_message;
}

echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));
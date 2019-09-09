<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "config.php";
require_once "pdf/html_table.php";
include_once "php/functions.php";
$purchase = $broker->get_data(new purchase($_GET["id"]));

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($purchase->user));
$purchase->user = $user->email;

require_once "../classes/domain/card_package.class.php";
$card_package = $broker->get_data(new card_package($purchase->card_package));
$purchase->card_package = $card_package->name;

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($purchase->user_card));
$purchase->user_card = $user_card->card_number;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $purchase->id;
$header_param_list["checker"] = $purchase->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($purchase->checkerDate));
$header_param_list["maker"] = $purchase->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($purchase->makerDate));
$header_param_list["number_of_modifications"] = $purchase->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($purchase->user != "" || $purchase->user != NULL){ $html .= '<b>User: </b> <BR>'.$purchase->user.'<BR><BR>';}
if($purchase->price != "" || $purchase->price != NULL){ $html .= '<b>Price: </b> <BR>'.$purchase->price.'<BR><BR>';}
if($purchase->to_company != "" || $purchase->to_company != NULL){ $html .= '<b>To Company: </b> <BR>'.$purchase->to_company.'<BR><BR>';}
if($purchase->to_us != "" || $purchase->to_us != NULL){ $html .= '<b>To Us: </b> <BR>'.$purchase->to_us.'<BR><BR>';}
if($purchase->duration_days != "" || $purchase->duration_days != NULL){ $html .= '<b>Duration Days: </b> <BR>'.$purchase->duration_days.'<BR><BR>';}
if($purchase->number_of_passes != "" || $purchase->number_of_passes != NULL){ $html .= '<b>Number Of_passes: </b> <BR>'.$purchase->number_of_passes.'<BR><BR>';}
if($purchase->start_date != "" || $purchase->start_date != NULL){ 
$html .= '<b>Start Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($purchase->start_date)); $html .='<BR><BR>';}
if($purchase->end_date != "" || $purchase->end_date != NULL){ 
$html .= '<b>End Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($purchase->end_date)); $html .='<BR><BR>';}
if($purchase->purchase_type != "" || $purchase->purchase_type != NULL){ $html .= '<b>Purchase Type: </b> <BR>'.$purchase->purchase_type.'<BR><BR>';}
if($purchase->company_flag != "" || $purchase->company_flag != NULL){ $html .= '<b>Company Flag: </b> <BR>'.$purchase->company_flag.'<BR><BR>';}
if($purchase->po_name != "" || $purchase->po_name != NULL){ $html .= '<b>Po Name: </b> <BR>'.$purchase->po_name.'<BR><BR>';}
if($purchase->po_address != "" || $purchase->po_address != NULL){ $html .= '<b>Po Address: </b> <BR>'.$purchase->po_address.'<BR><BR>';}
if($purchase->po_city != "" || $purchase->po_city != NULL){ $html .= '<b>Po City: </b> <BR>'.$purchase->po_city.'<BR><BR>';}
if($purchase->po_postal != "" || $purchase->po_postal != NULL){ $html .= '<b>Po Postal: </b> <BR>'.$purchase->po_postal.'<BR><BR>';}
if($purchase->card_package != "" || $purchase->card_package != NULL){ $html .= '<b>Card Package: </b> <BR>'.$purchase->card_package.'<BR><BR>';}
if($purchase->user_card != "" || $purchase->user_card != NULL){ $html .= '<b>User Card: </b> <BR>'.$purchase->user_card.'<BR><BR>';}
if($purchase->card_active_token != "" || $purchase->card_active_token != NULL){ $html .= '<b>Card Active_token: </b> <BR>'.$purchase->card_active_token.'<BR><BR>';}
if($purchase->returnUrl != "" || $purchase->returnUrl != NULL){ $html .= '<b>Returnurl: </b> <BR>'.$purchase->returnUrl.'<BR><BR>';}
if($purchase->merchantPaymentId != "" || $purchase->merchantPaymentId != NULL){ $html .= '<b>Merchantpaymentid: </b> <BR>'.$purchase->merchantPaymentId.'<BR><BR>';}
if($purchase->apiMerchantId != "" || $purchase->apiMerchantId != NULL){ $html .= '<b>Apimerchantid: </b> <BR>'.$purchase->apiMerchantId.'<BR><BR>';}
if($purchase->paymentSystem != "" || $purchase->paymentSystem != NULL){ $html .= '<b>Paymentsystem: </b> <BR>'.$purchase->paymentSystem.'<BR><BR>';}
if($purchase->paymentSystemType != "" || $purchase->paymentSystemType != NULL){ $html .= '<b>Paymentsystemtype: </b> <BR>'.$purchase->paymentSystemType.'<BR><BR>';}
if($purchase->paymentSystemEftCode != "" || $purchase->paymentSystemEftCode != NULL){ $html .= '<b>Paymentsystemeftcode: </b> <BR>'.$purchase->paymentSystemEftCode.'<BR><BR>';}
if($purchase->pgTranDate != "" || $purchase->pgTranDate != NULL){ $html .= '<b>Pgtrandate: </b> <BR>'.$purchase->pgTranDate.'<BR><BR>';}
if($purchase->pgTranId != "" || $purchase->pgTranId != NULL){ $html .= '<b>Pgtranid: </b> <BR>'.$purchase->pgTranId.'<BR><BR>';}
if($purchase->pgTranRefId != "" || $purchase->pgTranRefId != NULL){ $html .= '<b>Pgtranrefid: </b> <BR>'.$purchase->pgTranRefId.'<BR><BR>';}
if($purchase->pgOrderId != "" || $purchase->pgOrderId != NULL){ $html .= '<b>Pgorderid: </b> <BR>'.$purchase->pgOrderId.'<BR><BR>';}
if($purchase->customerId != "" || $purchase->customerId != NULL){ $html .= '<b>Customerid: </b> <BR>'.$purchase->customerId.'<BR><BR>';}
if($purchase->amount != "" || $purchase->amount != NULL){ $html .= '<b>Amount: </b> <BR>'.$purchase->amount.'<BR><BR>';}
if($purchase->installment != "" || $purchase->installment != NULL){ $html .= '<b>Installment: </b> <BR>'.$purchase->installment.'<BR><BR>';}
if($purchase->sessionToken != "" || $purchase->sessionToken != NULL){ $html .= '<b>Sessiontoken: </b> <BR>'.$purchase->sessionToken.'<BR><BR>';}
if($purchase->random_string != "" || $purchase->random_string != NULL){ $html .= '<b>Random String: </b> <BR>'.$purchase->random_string.'<BR><BR>';}
if($purchase->SD_SHA512 != "" || $purchase->SD_SHA512 != NULL){ $html .= '<b>Sd Sha512: </b> <BR>'.$purchase->SD_SHA512.'<BR><BR>';}
if($purchase->sdSha512 != "" || $purchase->sdSha512 != NULL){ $html .= '<b>Sdsha512: </b> <BR>'.$purchase->sdSha512.'<BR><BR>';}
if($purchase->pgTranErrorText != "" || $purchase->pgTranErrorText != NULL){ $html .= '<b>Pgtranerrortext: </b> <BR>'.$purchase->pgTranErrorText.'<BR><BR>';}
if($purchase->pgTranErrorCode != "" || $purchase->pgTranErrorCode != NULL){ $html .= '<b>Pgtranerrorcode: </b> <BR>'.$purchase->pgTranErrorCode.'<BR><BR>';}
if($purchase->errorCode != "" || $purchase->errorCode != NULL){ $html .= '<b>Errorcode: </b> <BR>'.$purchase->errorCode.'<BR><BR>';}
if($purchase->responseCode != "" || $purchase->responseCode != NULL){ $html .= '<b>Responsecode: </b> <BR>'.$purchase->responseCode.'<BR><BR>';}
if($purchase->responseMsg != "" || $purchase->responseMsg != NULL){ $html .= '<b>Responsemsg: </b> <BR>'.$purchase->responseMsg.'<BR><BR>';}
if($purchase->company_location != "" || $purchase->company_location != NULL){ $html .= '<b>Company Location: </b> <BR>'.$purchase->company_location.'<BR><BR>';}
if($purchase->po_payment_date != "" || $purchase->po_payment_date != NULL){ 
$html .= '<b>Po Payment_date: </b> <BR>'; $html .= date("d.m.Y",strtotime($purchase->po_payment_date)); $html .='<BR><BR>';}
if($purchase->po_payment_name != "" || $purchase->po_payment_name != NULL){ $html .= '<b>Po Payment_name: </b> <BR>'.$purchase->po_payment_name.'<BR><BR>';}	
$file="xenon-document-".time().".pdf";
$html = str_replace("Ä†", "C", $html); //C
$html = str_replace("Ä‡", "c", $html); //c
$html = str_replace("Ä•", "c", $html); //c
$html = str_replace("Å¾", "ž", $html); //ž
$html = utf8_decode($html);
$pdfd->WriteHTML($html);
$pdfd->Output("pdf/".$file,"F");
header("Cache-Control: public");
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=".$file);
ob_clean();
readfile("pdf/".$file);
unlink("pdf/".$file);
die();
?>

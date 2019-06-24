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
$user_card = $broker->get_data(new user_card($_GET["id"]));

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($user_card->user));
$user_card->user = $user->email;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $user_card->id;
$header_param_list["checker"] = $user_card->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($user_card->checkerDate));
$header_param_list["maker"] = $user_card->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($user_card->makerDate));
$header_param_list["number_of_modifications"] = $user_card->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($user_card->card_number != "" || $user_card->card_number != NULL){ $html .= '<b>Card Number: </b> <BR>'.$user_card->card_number.'<BR><BR>';}
if($user_card->child_birthdate != "" || $user_card->child_birthdate != NULL){ $html .= '<b>Child Birthdate: </b> <BR>'.$user_card->child_birthdate.'<BR><BR>';}
if($user_card->user != "" || $user_card->user != NULL){ $html .= '<b>User: </b> <BR>'.$user_card->user.'<BR><BR>';}
if($user_card->card_password != "" || $user_card->card_password != NULL){ $html .= '<b>Card Password: </b> <BR>**********<BR><BR>';}
if($user_card->delivery_method != "" || $user_card->delivery_method != NULL){ $html .= '<b>Delivery Method: </b> <BR>'.$user_card->delivery_method.'<BR><BR>';}
if($user_card->post_street != "" || $user_card->post_street != NULL){ $html .= '<b>Post Street: </b> <BR>'.$user_card->post_street.'<BR><BR>';}
if($user_card->post_city != "" || $user_card->post_city != NULL){ $html .= '<b>Post City: </b> <BR>'.$user_card->post_city.'<BR><BR>';}
if($user_card->post_postal != "" || $user_card->post_postal != NULL){ $html .= '<b>Post Postal: </b> <BR>'.$user_card->post_postal.'<BR><BR>';}
if($user_card->partner_id != "" || $user_card->partner_id != NULL){ $html .= '<b>Partner Id: </b> <BR>'.$user_card->partner_id.'<BR><BR>';}
if($user_card->customer_received != "" || $user_card->customer_received != NULL){ 
$html .= '<b>Customer Received: </b> <BR>';
if($user_card->customer_received == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($user_card->parent_first_name != "" || $user_card->parent_first_name != NULL){ $html .= '<b>Parent First_name: </b> <BR>'.$user_card->parent_first_name.'<BR><BR>';}
if($user_card->number_of_kids != "" || $user_card->number_of_kids != NULL){ $html .= '<b>Number Of_kids: </b> <BR>'.$user_card->number_of_kids.'<BR><BR>';}
if($user_card->city != "" || $user_card->city != NULL){ $html .= '<b>City: </b> <BR>'.$user_card->city.'<BR><BR>';}
if($user_card->phone != "" || $user_card->phone != NULL){ $html .= '<b>Phone: </b> <BR>'.$user_card->phone.'<BR><BR>';}
if($user_card->email != "" || $user_card->email != NULL){ $html .= '<b>Email: </b> <BR>'.$user_card->email.'<BR><BR>';}
if($user_card->company_location != "" || $user_card->company_location != NULL){ $html .= '<b>Company Location: </b> <BR>'.$user_card->company_location.'<BR><BR>';}
if($user_card->parent_last_name != "" || $user_card->parent_last_name != NULL){ $html .= '<b>Parent Last_name: </b> <BR>'.$user_card->parent_last_name.'<BR><BR>';}	
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

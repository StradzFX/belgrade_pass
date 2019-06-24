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
$card_numbers = $broker->get_data(new card_numbers($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $card_numbers->id;
$header_param_list["checker"] = $card_numbers->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($card_numbers->checkerDate));
$header_param_list["maker"] = $card_numbers->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($card_numbers->makerDate));
$header_param_list["number_of_modifications"] = $card_numbers->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($card_numbers->card_number != "" || $card_numbers->card_number != NULL){ $html .= '<b>Card Number: </b> <BR>'.$card_numbers->card_number.'<BR><BR>';}
if($card_numbers->card_password != "" || $card_numbers->card_password != NULL){ $html .= '<b>Card Password: </b> <BR>**********<BR><BR>';}
if($card_numbers->card_taken != "" || $card_numbers->card_taken != NULL){ 
$html .= '<b>Card Taken: </b> <BR>';
if($card_numbers->card_taken == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($card_numbers->user != "" || $card_numbers->user != NULL){ $html .= '<b>User: </b> <BR>'.$card_numbers->user.'<BR><BR>';}
if($card_numbers->card_reserved != "" || $card_numbers->card_reserved != NULL){ 
$html .= '<b>Card Reserved: </b> <BR>';
if($card_numbers->card_reserved == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($card_numbers->company_card != "" || $card_numbers->company_card != NULL){ $html .= '<b>Company Card: </b> <BR>'.$card_numbers->company_card.'<BR><BR>';}
if($card_numbers->card_number_int != "" || $card_numbers->card_number_int != NULL){ $html .= '<b>Card Number_int: </b> <BR>'.$card_numbers->card_number_int.'<BR><BR>';}
if($card_numbers->picture != "" || $card_numbers->picture != NULL){ $html .= '<b>Picture: </b> <BR>'.$card_numbers->picture.'<BR><BR>';}
if($card_numbers->company_location != "" || $card_numbers->company_location != NULL){ $html .= '<b>Company Location: </b> <BR>'.$card_numbers->company_location.'<BR><BR>';}
if($card_numbers->internal_reservation != "" || $card_numbers->internal_reservation != NULL){ 
$html .= '<b>Internal Reservation: </b> <BR>';
if($card_numbers->internal_reservation == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}	
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

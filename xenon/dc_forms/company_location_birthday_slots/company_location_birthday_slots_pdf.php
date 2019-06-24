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
$company_location_birthday_slots = $broker->get_data(new company_location_birthday_slots($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_location_birthday_slots->id;
$header_param_list["checker"] = $company_location_birthday_slots->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_location_birthday_slots->checkerDate));
$header_param_list["maker"] = $company_location_birthday_slots->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_location_birthday_slots->makerDate));
$header_param_list["number_of_modifications"] = $company_location_birthday_slots->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_location_birthday_slots->day_of_week != "" || $company_location_birthday_slots->day_of_week != NULL){ $html .= '<b>Day Of_week: </b> <BR>'.$company_location_birthday_slots->day_of_week.'<BR><BR>';}
if($company_location_birthday_slots->hours_from != "" || $company_location_birthday_slots->hours_from != NULL){ $html .= '<b>Hours From: </b> <BR>'.$company_location_birthday_slots->hours_from.'<BR><BR>';}
if($company_location_birthday_slots->minutes_from != "" || $company_location_birthday_slots->minutes_from != NULL){ $html .= '<b>Minutes From: </b> <BR>'.$company_location_birthday_slots->minutes_from.'<BR><BR>';}
if($company_location_birthday_slots->hours_to != "" || $company_location_birthday_slots->hours_to != NULL){ $html .= '<b>Hours To: </b> <BR>'.$company_location_birthday_slots->hours_to.'<BR><BR>';}
if($company_location_birthday_slots->minutes_to != "" || $company_location_birthday_slots->minutes_to != NULL){ $html .= '<b>Minutes To: </b> <BR>'.$company_location_birthday_slots->minutes_to.'<BR><BR>';}
if($company_location_birthday_slots->price != "" || $company_location_birthday_slots->price != NULL){ $html .= '<b>Price: </b> <BR>'.$company_location_birthday_slots->price.'<BR><BR>';}
if($company_location_birthday_slots->company_birthday_data != "" || $company_location_birthday_slots->company_birthday_data != NULL){ $html .= '<b>Company Birthday_data: </b> <BR>'.$company_location_birthday_slots->company_birthday_data.'<BR><BR>';}	
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

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
$company_discount_rules = $broker->get_data(new company_discount_rules($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_discount_rules->training_school));
$company_discount_rules->training_school = $training_school->id;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_discount_rules->id;
$header_param_list["checker"] = $company_discount_rules->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_discount_rules->checkerDate));
$header_param_list["maker"] = $company_discount_rules->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_discount_rules->makerDate));
$header_param_list["number_of_modifications"] = $company_discount_rules->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_discount_rules->training_school != "" || $company_discount_rules->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_discount_rules->training_school.'<BR><BR>';}
if($company_discount_rules->day_from != "" || $company_discount_rules->day_from != NULL){ $html .= '<b>Day From: </b> <BR>'.$company_discount_rules->day_from.'<BR><BR>';}
if($company_discount_rules->day_to != "" || $company_discount_rules->day_to != NULL){ $html .= '<b>Day To: </b> <BR>'.$company_discount_rules->day_to.'<BR><BR>';}
if($company_discount_rules->hours_from != "" || $company_discount_rules->hours_from != NULL){ $html .= '<b>Hours From: </b> <BR>'.$company_discount_rules->hours_from.'<BR><BR>';}
if($company_discount_rules->hours_to != "" || $company_discount_rules->hours_to != NULL){ $html .= '<b>Hours To: </b> <BR>'.$company_discount_rules->hours_to.'<BR><BR>';}
if($company_discount_rules->discount != "" || $company_discount_rules->discount != NULL){ $html .= '<b>Discount: </b> <BR>'.$company_discount_rules->discount.'<BR><BR>';}	
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

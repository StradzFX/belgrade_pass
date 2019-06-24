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
$company_location_pass_rules = $broker->get_data(new company_location_pass_rules($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_location_pass_rules->training_school));
$company_location_pass_rules->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($company_location_pass_rules->ts_location));
$company_location_pass_rules->ts_location = $ts_location->street;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_location_pass_rules->id;
$header_param_list["checker"] = $company_location_pass_rules->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_location_pass_rules->checkerDate));
$header_param_list["maker"] = $company_location_pass_rules->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_location_pass_rules->makerDate));
$header_param_list["number_of_modifications"] = $company_location_pass_rules->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_location_pass_rules->training_school != "" || $company_location_pass_rules->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_location_pass_rules->training_school.'<BR><BR>';}
if($company_location_pass_rules->ts_location != "" || $company_location_pass_rules->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$company_location_pass_rules->ts_location.'<BR><BR>';}
if($company_location_pass_rules->hours_from != "" || $company_location_pass_rules->hours_from != NULL){ $html .= '<b>Hours From: </b> <BR>'.$company_location_pass_rules->hours_from.'<BR><BR>';}
if($company_location_pass_rules->minutes_from != "" || $company_location_pass_rules->minutes_from != NULL){ $html .= '<b>Minutes From: </b> <BR>'.$company_location_pass_rules->minutes_from.'<BR><BR>';}
if($company_location_pass_rules->hours_to != "" || $company_location_pass_rules->hours_to != NULL){ $html .= '<b>Hours To: </b> <BR>'.$company_location_pass_rules->hours_to.'<BR><BR>';}
if($company_location_pass_rules->minutes_to != "" || $company_location_pass_rules->minutes_to != NULL){ $html .= '<b>Minutes To: </b> <BR>'.$company_location_pass_rules->minutes_to.'<BR><BR>';}
if($company_location_pass_rules->pass_per_kid != "" || $company_location_pass_rules->pass_per_kid != NULL){ $html .= '<b>Pass Per Kid: </b> <BR>'.$company_location_pass_rules->pass_per_kid.'<BR><BR>';}	
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

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
$company_events = $broker->get_data(new company_events($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_events->training_school));
$company_events->training_school = $training_school->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_events->id;
$header_param_list["checker"] = $company_events->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_events->checkerDate));
$header_param_list["maker"] = $company_events->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_events->makerDate));
$header_param_list["number_of_modifications"] = $company_events->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_events->training_school != "" || $company_events->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_events->training_school.'<BR><BR>';}
if($company_events->event_date != "" || $company_events->event_date != NULL){ 
$html .= '<b>Event Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($company_events->event_date)); $html .='<BR><BR>';}
if($company_events->event_time_from != "" || $company_events->event_time_from != NULL){ $html .= '<b>Event Time_from: </b> <BR>'.$company_events->event_time_from.'<BR><BR>';}
if($company_events->event_time_to != "" || $company_events->event_time_to != NULL){ $html .= '<b>Event Time_to: </b> <BR>'.$company_events->event_time_to.'<BR><BR>';}
if($company_events->event_type != "" || $company_events->event_type != NULL){ $html .= '<b>Event Type: </b> <BR>'.$company_events->event_type.'<BR><BR>';}
if($company_events->event_name != "" || $company_events->event_name != NULL){ $html .= '<b>Event Name: </b> <BR>'.$company_events->event_name.'<BR><BR>';}
if($company_events->event_horus_from != "" || $company_events->event_horus_from != NULL){ $html .= '<b>Event Horus_from: </b> <BR>'.$company_events->event_horus_from.'<BR><BR>';}
if($company_events->event_hours_to != "" || $company_events->event_hours_to != NULL){ $html .= '<b>Event Hours_to: </b> <BR>'.$company_events->event_hours_to.'<BR><BR>';}
if($company_events->event_minutes_from != "" || $company_events->event_minutes_from != NULL){ $html .= '<b>Event Minutes_from: </b> <BR>'.$company_events->event_minutes_from.'<BR><BR>';}
if($company_events->event_minutes_to != "" || $company_events->event_minutes_to != NULL){ $html .= '<b>Event Minutes_to: </b> <BR>'.$company_events->event_minutes_to.'<BR><BR>';}
if($company_events->ts_location != "" || $company_events->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$company_events->ts_location.'<BR><BR>';}
if($company_events->company_birthday_data != "" || $company_events->company_birthday_data != NULL){ $html .= '<b>Company Birthday_data: </b> <BR>'.$company_events->company_birthday_data.'<BR><BR>';}
if($company_events->company_location_birthday_slots != "" || $company_events->company_location_birthday_slots != NULL){ $html .= '<b>Company Location_birthday_slots: </b> <BR>'.$company_events->company_location_birthday_slots.'<BR><BR>';}
if($company_events->event_global_type != "" || $company_events->event_global_type != NULL){ $html .= '<b>Event Global_type: </b> <BR>'.$company_events->event_global_type.'<BR><BR>';}	
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

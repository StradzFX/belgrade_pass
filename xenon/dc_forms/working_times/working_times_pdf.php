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
$working_times = $broker->get_data(new working_times($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($working_times->training_school));
$working_times->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($working_times->ts_location));
$working_times->ts_location = $ts_location->training_school;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $working_times->id;
$header_param_list["checker"] = $working_times->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($working_times->checkerDate));
$header_param_list["maker"] = $working_times->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($working_times->makerDate));
$header_param_list["number_of_modifications"] = $working_times->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($working_times->training_school != "" || $working_times->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$working_times->training_school.'<BR><BR>';}
if($working_times->day_of_week != "" || $working_times->day_of_week != NULL){ $html .= '<b>Day Of_week: </b> <BR>'.$working_times->day_of_week.'<BR><BR>';}
if($working_times->not_working != "" || $working_times->not_working != NULL){ $html .= '<b>Not Working: </b> <BR>'.$working_times->not_working.'<BR><BR>';}
if($working_times->working_from_hours != "" || $working_times->working_from_hours != NULL){ $html .= '<b>Working From_hours: </b> <BR>'.$working_times->working_from_hours.'<BR><BR>';}
if($working_times->working_from_minutes != "" || $working_times->working_from_minutes != NULL){ $html .= '<b>Working From_minutes: </b> <BR>'.$working_times->working_from_minutes.'<BR><BR>';}
if($working_times->working_to_hours != "" || $working_times->working_to_hours != NULL){ $html .= '<b>Working To_hours: </b> <BR>'.$working_times->working_to_hours.'<BR><BR>';}
if($working_times->working_to_minutes != "" || $working_times->working_to_minutes != NULL){ $html .= '<b>Working To_minutes: </b> <BR>'.$working_times->working_to_minutes.'<BR><BR>';}
if($working_times->ts_location != "" || $working_times->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$working_times->ts_location.'<BR><BR>';}	
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

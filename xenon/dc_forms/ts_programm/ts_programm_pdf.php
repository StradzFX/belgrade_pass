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
$ts_programm = $broker->get_data(new ts_programm($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_programm->training_school));
$ts_programm->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($ts_programm->ts_location));
$ts_programm->ts_location = $ts_location->street;

require_once "../classes/domain/trainer.class.php";
$trainer = $broker->get_data(new trainer($ts_programm->trainer));
$ts_programm->trainer = $trainer->first_name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $ts_programm->id;
$header_param_list["checker"] = $ts_programm->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($ts_programm->checkerDate));
$header_param_list["maker"] = $ts_programm->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($ts_programm->makerDate));
$header_param_list["number_of_modifications"] = $ts_programm->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($ts_programm->training_school != "" || $ts_programm->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$ts_programm->training_school.'<BR><BR>';}
if($ts_programm->ts_location != "" || $ts_programm->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$ts_programm->ts_location.'<BR><BR>';}
if($ts_programm->name != "" || $ts_programm->name != NULL){ $html .= '<b>Name: </b> <BR>'.$ts_programm->name.'<BR><BR>';}
if($ts_programm->age_from != "" || $ts_programm->age_from != NULL){ $html .= '<b>Age From: </b> <BR>'.$ts_programm->age_from.'<BR><BR>';}
if($ts_programm->age_to != "" || $ts_programm->age_to != NULL){ $html .= '<b>Age To: </b> <BR>'.$ts_programm->age_to.'<BR><BR>';}
if($ts_programm->trainer != "" || $ts_programm->trainer != NULL){ $html .= '<b>Trainer: </b> <BR>'.$ts_programm->trainer.'<BR><BR>';}	
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

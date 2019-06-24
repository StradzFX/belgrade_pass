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
$ts_trainers = $broker->get_data(new ts_trainers($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_trainers->training_school));
$ts_trainers->training_school = $training_school->name;

require_once "../classes/domain/trainer.class.php";
$trainer = $broker->get_data(new trainer($ts_trainers->trainer));
$ts_trainers->trainer = $trainer->first_name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $ts_trainers->id;
$header_param_list["checker"] = $ts_trainers->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($ts_trainers->checkerDate));
$header_param_list["maker"] = $ts_trainers->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($ts_trainers->makerDate));
$header_param_list["number_of_modifications"] = $ts_trainers->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($ts_trainers->training_school != "" || $ts_trainers->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$ts_trainers->training_school.'<BR><BR>';}
if($ts_trainers->trainer != "" || $ts_trainers->trainer != NULL){ $html .= '<b>Trainer: </b> <BR>'.$ts_trainers->trainer.'<BR><BR>';}	
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

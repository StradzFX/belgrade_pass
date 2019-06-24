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
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($_GET["id"]));

require_once "../classes/domain/ts_programm.class.php";
$ts_programm = $broker->get_data(new ts_programm($tsp_day_of_week->ts_programm));
$tsp_day_of_week->ts_programm = $ts_programm->name;

require_once "../classes/domain/trainer.class.php";
$trainer = $broker->get_data(new trainer($tsp_day_of_week->trainer));
$tsp_day_of_week->trainer = $trainer->first_name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $tsp_day_of_week->id;
$header_param_list["checker"] = $tsp_day_of_week->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($tsp_day_of_week->checkerDate));
$header_param_list["maker"] = $tsp_day_of_week->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($tsp_day_of_week->makerDate));
$header_param_list["number_of_modifications"] = $tsp_day_of_week->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($tsp_day_of_week->ts_programm != "" || $tsp_day_of_week->ts_programm != NULL){ $html .= '<b>Ts Programm: </b> <BR>'.$tsp_day_of_week->ts_programm.'<BR><BR>';}
if($tsp_day_of_week->name != "" || $tsp_day_of_week->name != NULL){ $html .= '<b>Name: </b> <BR>'.$tsp_day_of_week->name.'<BR><BR>';}
if($tsp_day_of_week->day_of_week != "" || $tsp_day_of_week->day_of_week != NULL){ $html .= '<b>Day Of_week: </b> <BR>'.$tsp_day_of_week->day_of_week.'<BR><BR>';}
if($tsp_day_of_week->trainer != "" || $tsp_day_of_week->trainer != NULL){ $html .= '<b>Trainer: </b> <BR>'.$tsp_day_of_week->trainer.'<BR><BR>';}	
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

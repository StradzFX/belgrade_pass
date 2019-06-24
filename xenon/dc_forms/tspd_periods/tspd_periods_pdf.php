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
$tspd_periods = $broker->get_data(new tspd_periods($_GET["id"]));

require_once "../classes/domain/tsp_day_of_week.class.php";
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($tspd_periods->tsp_day_of_week));
$tspd_periods->tsp_day_of_week = $tsp_day_of_week->id;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $tspd_periods->id;
$header_param_list["checker"] = $tspd_periods->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($tspd_periods->checkerDate));
$header_param_list["maker"] = $tspd_periods->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($tspd_periods->makerDate));
$header_param_list["number_of_modifications"] = $tspd_periods->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($tspd_periods->tsp_day_of_week != "" || $tspd_periods->tsp_day_of_week != NULL){ $html .= '<b>Tsp Day_of_week: </b> <BR>'.$tspd_periods->tsp_day_of_week.'<BR><BR>';}
if($tspd_periods->time_from != "" || $tspd_periods->time_from != NULL){ $html .= '<b>Time From: </b> <BR>'.$tspd_periods->time_from.'<BR><BR>';}
if($tspd_periods->time_to != "" || $tspd_periods->time_to != NULL){ $html .= '<b>Time To: </b> <BR>'.$tspd_periods->time_to.'<BR><BR>';}
if($tspd_periods->price != "" || $tspd_periods->price != NULL){ $html .= '<b>Price: </b> <BR>'.$tspd_periods->price.'<BR><BR>';}
if($tspd_periods->ccy != "" || $tspd_periods->ccy != NULL){ $html .= '<b>Ccy: </b> <BR>'.$tspd_periods->ccy.'<BR><BR>';}
if($tspd_periods->trainer != "" || $tspd_periods->trainer != NULL){ $html .= '<b>Trainer: </b> <BR>'.$tspd_periods->trainer.'<BR><BR>';}	
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

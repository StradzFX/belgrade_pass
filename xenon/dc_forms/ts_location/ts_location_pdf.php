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
$ts_location = $broker->get_data(new ts_location($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_location->training_school));
$ts_location->training_school = $training_school->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $ts_location->id;
$header_param_list["checker"] = $ts_location->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($ts_location->checkerDate));
$header_param_list["maker"] = $ts_location->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($ts_location->makerDate));
$header_param_list["number_of_modifications"] = $ts_location->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($ts_location->training_school != "" || $ts_location->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$ts_location->training_school.'<BR><BR>';}
if($ts_location->city != "" || $ts_location->city != NULL){ $html .= '<b>City: </b> <BR>'.$ts_location->city.'<BR><BR>';}
if($ts_location->part_of_city != "" || $ts_location->part_of_city != NULL){ $html .= '<b>Part Of_city: </b> <BR>'.$ts_location->part_of_city.'<BR><BR>';}
if($ts_location->street != "" || $ts_location->street != NULL){ $html .= '<b>Street: </b> <BR>'.$ts_location->street.'<BR><BR>';}
if($ts_location->latitude != "" || $ts_location->latitude != NULL){ $html .= '<b>Latitude: </b> <BR>'.$ts_location->latitude.'<BR><BR>';}
if($ts_location->longitude != "" || $ts_location->longitude != NULL){ $html .= '<b>Longitude: </b> <BR>'.$ts_location->longitude.'<BR><BR>';}
if($ts_location->username != "" || $ts_location->username != NULL){ $html .= '<b>Username: </b> <BR>'.$ts_location->username.'<BR><BR>';}
if($ts_location->password != "" || $ts_location->password != NULL){ $html .= '<b>Password: </b> <BR>**********<BR><BR>';}
if($ts_location->email != "" || $ts_location->email != NULL){ $html .= '<b>Email: </b> <BR>'.$ts_location->email.'<BR><BR>';}	
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

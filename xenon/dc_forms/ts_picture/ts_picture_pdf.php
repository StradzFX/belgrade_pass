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
$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_picture->training_school));
$ts_picture->training_school = $training_school->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $ts_picture->id;
$header_param_list["checker"] = $ts_picture->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($ts_picture->checkerDate));
$header_param_list["maker"] = $ts_picture->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($ts_picture->makerDate));
$header_param_list["number_of_modifications"] = $ts_picture->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($ts_picture->training_school != "" || $ts_picture->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$ts_picture->training_school.'<BR><BR>';}
if($ts_picture->picture != "" || $ts_picture->picture != NULL){ 
$html .= '<b>Picture: </b> 
<BR> <img src="../pictures/ts_picture/picture/'.$ts_picture->picture.'" height="50"/><BR><BR><BR><BR><BR>';}
if($ts_picture->thumb != "" || $ts_picture->thumb != NULL){ 
$html .= '<b>Thumb: </b> 
<BR> <img src="../pictures/ts_picture/thumb/'.$ts_picture->thumb.'" height="50"/><BR><BR><BR><BR><BR>';}	
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

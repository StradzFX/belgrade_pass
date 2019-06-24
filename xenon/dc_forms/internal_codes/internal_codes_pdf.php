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
$internal_codes = $broker->get_data(new internal_codes($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($internal_codes->training_school));
$internal_codes->training_school = $training_school->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $internal_codes->id;
$header_param_list["checker"] = $internal_codes->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($internal_codes->checkerDate));
$header_param_list["maker"] = $internal_codes->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($internal_codes->makerDate));
$header_param_list["number_of_modifications"] = $internal_codes->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($internal_codes->code_name != "" || $internal_codes->code_name != NULL){ $html .= '<b>Code Name: </b> <BR>'.$internal_codes->code_name.'<BR><BR>';}
if($internal_codes->training_school != "" || $internal_codes->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$internal_codes->training_school.'<BR><BR>';}
if($internal_codes->code_value != "" || $internal_codes->code_value != NULL){ $html .= '<b>Code Value: </b> <BR>'.$internal_codes->code_value.'<BR><BR>';}	
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

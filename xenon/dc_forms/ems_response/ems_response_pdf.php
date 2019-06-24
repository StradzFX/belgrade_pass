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
$ems_response = $broker->get_data(new ems_response($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $ems_response->id;
$header_param_list["checker"] = $ems_response->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($ems_response->checkerDate));
$header_param_list["maker"] = $ems_response->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($ems_response->makerDate));
$header_param_list["number_of_modifications"] = $ems_response->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($ems_response->response_date != "" || $ems_response->response_date != NULL){ 
$html .= '<b>Response Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($ems_response->response_date)); $html .='<BR><BR>';}	
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

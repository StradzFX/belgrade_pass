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
$proba = $broker->get_data(new proba($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $proba->id;
$header_param_list["checker"] = $proba->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($proba->checkerDate));
$header_param_list["maker"] = $proba->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($proba->makerDate));
$header_param_list["number_of_modifications"] = $proba->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($proba->ime != "" || $proba->ime != NULL){ $html .= '<b>Ime: </b> <BR>'.$proba->ime.'<BR><BR>';}
if($proba->prezime != "" || $proba->prezime != NULL){ $html .= '<b>Prezime: </b> <BR>'.$proba->prezime.'<BR><BR>';}
if($proba->godine != "" || $proba->godine != NULL){ 
$html .= '<b>Godine: </b> <BR>';
if($proba->godine == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}	
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

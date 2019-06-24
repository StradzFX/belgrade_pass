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
$company_category = $broker->get_data(new company_category($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_category->id;
$header_param_list["checker"] = $company_category->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_category->checkerDate));
$header_param_list["maker"] = $company_category->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_category->makerDate));
$header_param_list["number_of_modifications"] = $company_category->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_category->company != "" || $company_category->company != NULL){ $html .= '<b>Company: </b> <BR>'.$company_category->company.'<BR><BR>';}
if($company_category->category != "" || $company_category->category != NULL){ $html .= '<b>Category: </b> <BR>'.$company_category->category.'<BR><BR>';}	
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

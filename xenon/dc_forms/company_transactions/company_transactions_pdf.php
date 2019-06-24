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
$company_transactions = $broker->get_data(new company_transactions($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_transactions->training_school));
$company_transactions->training_school = $training_school->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_transactions->id;
$header_param_list["checker"] = $company_transactions->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_transactions->checkerDate));
$header_param_list["maker"] = $company_transactions->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_transactions->makerDate));
$header_param_list["number_of_modifications"] = $company_transactions->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_transactions->training_school != "" || $company_transactions->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_transactions->training_school.'<BR><BR>';}
if($company_transactions->transaction_type != "" || $company_transactions->transaction_type != NULL){ $html .= '<b>Transaction Type: </b> <BR>'.$company_transactions->transaction_type.'<BR><BR>';}
if($company_transactions->transaction_value != "" || $company_transactions->transaction_value != NULL){ $html .= '<b>Transaction Value: </b> <BR>'.$company_transactions->transaction_value.'<BR><BR>';}
if($company_transactions->transaction_date != "" || $company_transactions->transaction_date != NULL){ 
$html .= '<b>Transaction Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($company_transactions->transaction_date)); $html .='<BR><BR>';}	
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

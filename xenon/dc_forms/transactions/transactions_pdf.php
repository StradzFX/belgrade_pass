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
$transactions = $broker->get_data(new transactions($_GET["id"]));

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($transactions->user));
$transactions->user = $user->email;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $transactions->id;
$header_param_list["checker"] = $transactions->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($transactions->checkerDate));
$header_param_list["maker"] = $transactions->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($transactions->makerDate));
$header_param_list["number_of_modifications"] = $transactions->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($transactions->transaction_type != "" || $transactions->transaction_type != NULL){ $html .= '<b>Transaction Type: </b> <BR>'.$transactions->transaction_type.'<BR><BR>';}
if($transactions->tranaction_id != "" || $transactions->tranaction_id != NULL){ $html .= '<b>Tranaction Id: </b> <BR>'.$transactions->tranaction_id.'<BR><BR>';}
if($transactions->user != "" || $transactions->user != NULL){ $html .= '<b>User: </b> <BR>'.$transactions->user.'<BR><BR>';}	
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

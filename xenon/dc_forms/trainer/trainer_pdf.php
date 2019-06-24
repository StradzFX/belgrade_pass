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
$trainer = $broker->get_data(new trainer($_GET["id"]));

require_once "../classes/domain/sport_category.class.php";
$sport_category = $broker->get_data(new sport_category($trainer->sport_category));
$trainer->sport_category = $sport_category->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $trainer->id;
$header_param_list["checker"] = $trainer->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($trainer->checkerDate));
$header_param_list["maker"] = $trainer->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($trainer->makerDate));
$header_param_list["number_of_modifications"] = $trainer->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($trainer->first_name != "" || $trainer->first_name != NULL){ $html .= '<b>First Name: </b> <BR>'.$trainer->first_name.'<BR><BR>';}
if($trainer->last_name != "" || $trainer->last_name != NULL){ $html .= '<b>Last Name: </b> <BR>'.$trainer->last_name.'<BR><BR>';}
if($trainer->photo != "" || $trainer->photo != NULL){ $html .= '<b>Photo: </b> <BR>'.$trainer->photo.'<BR><BR>';}
if($trainer->sport_category != "" || $trainer->sport_category != NULL){ $html .= '<b>Sport Category: </b> <BR>'.$trainer->sport_category.'<BR><BR>';}	
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

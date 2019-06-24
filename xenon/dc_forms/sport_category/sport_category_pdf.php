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
$sport_category = $broker->get_data(new sport_category($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $sport_category->id;
$header_param_list["checker"] = $sport_category->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($sport_category->checkerDate));
$header_param_list["maker"] = $sport_category->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($sport_category->makerDate));
$header_param_list["number_of_modifications"] = $sport_category->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($sport_category->name != "" || $sport_category->name != NULL){ $html .= '<b>Name: </b> <BR>'.$sport_category->name.'<BR><BR>';}
if($sport_category->logo != "" || $sport_category->logo != NULL){ 
$html .= '<b>Logo: </b> 
<BR> <img src="../pictures/sport_category/logo/'.$sport_category->logo.'" height="50"/><BR><BR><BR><BR><BR>';}
if($sport_category->popularity != "" || $sport_category->popularity != NULL){ $html .= '<b>Popularity: </b> <BR>'.$sport_category->popularity.'<BR><BR>';}
if($sport_category->map_logo != "" || $sport_category->map_logo != NULL){ 
$html .= '<b>Map Logo: </b> 
<BR> <img src="../pictures/sport_category/map_logo/'.$sport_category->map_logo.'" height="50"/><BR><BR><BR><BR><BR>';}	
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

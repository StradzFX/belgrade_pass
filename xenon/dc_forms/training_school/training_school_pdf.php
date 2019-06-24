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
$training_school = $broker->get_data(new training_school($_GET["id"]));

require_once "../classes/domain/sport_category.class.php";
$sport_category = $broker->get_data(new sport_category($training_school->sport_category));
$training_school->sport_category = $sport_category->name;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $training_school->id;
$header_param_list["checker"] = $training_school->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($training_school->checkerDate));
$header_param_list["maker"] = $training_school->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($training_school->makerDate));
$header_param_list["number_of_modifications"] = $training_school->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($training_school->name != "" || $training_school->name != NULL){ $html .= '<b>Name: </b> <BR>'.$training_school->name.'<BR><BR>';}
if($training_school->sport_category != "" || $training_school->sport_category != NULL){ $html .= '<b>Sport Category: </b> <BR>'.$training_school->sport_category.'<BR><BR>';}
if($training_school->featured != "" || $training_school->featured != NULL){ $html .= '<b>Featured: </b> <BR>'.$training_school->featured.'<BR><BR>';}
if($training_school->number_of_views != "" || $training_school->number_of_views != NULL){ $html .= '<b>Number Of_views: </b> <BR>'.$training_school->number_of_views.'<BR><BR>';}
if($training_school->promoted != "" || $training_school->promoted != NULL){ $html .= '<b>Promoted: </b> <BR>'.$training_school->promoted.'<BR><BR>';}
if($training_school->username != "" || $training_school->username != NULL){ $html .= '<b>Username: </b> <BR>'.$training_school->username.'<BR><BR>';}
if($training_school->password != "" || $training_school->password != NULL){ $html .= '<b>Password: </b> <BR>**********<BR><BR>';}
if($training_school->pass_options != "" || $training_school->pass_options != NULL){ $html .= '<b>Pass Options: </b> <BR>'.$training_school->pass_options.'<BR><BR>';}
if($training_school->extra_goods_options != "" || $training_school->extra_goods_options != NULL){ $html .= '<b>Extra Goods_options: </b> <BR>'.$training_school->extra_goods_options.'<BR><BR>';}
if($training_school->birthday_options != "" || $training_school->birthday_options != NULL){ $html .= '<b>Birthday Options: </b> <BR>'.$training_school->birthday_options.'<BR><BR>';}
if($training_school->pass_customer_percentage != "" || $training_school->pass_customer_percentage != NULL){ $html .= '<b>Pass Customer_percentage: </b> <BR>'.$training_school->pass_customer_percentage.'<BR><BR>';}
if($training_school->pass_company_percentage != "" || $training_school->pass_company_percentage != NULL){ $html .= '<b>Pass Company_percentage: </b> <BR>'.$training_school->pass_company_percentage.'<BR><BR>';}	
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

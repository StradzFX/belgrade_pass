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
$company_birthday_data = $broker->get_data(new company_birthday_data($_GET["id"]));

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_birthday_data->training_school));
$company_birthday_data->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($company_birthday_data->ts_location));
$company_birthday_data->ts_location = $ts_location->id;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_birthday_data->id;
$header_param_list["checker"] = $company_birthday_data->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_birthday_data->checkerDate));
$header_param_list["maker"] = $company_birthday_data->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_birthday_data->makerDate));
$header_param_list["number_of_modifications"] = $company_birthday_data->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_birthday_data->training_school != "" || $company_birthday_data->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_birthday_data->training_school.'<BR><BR>';}
if($company_birthday_data->ts_location != "" || $company_birthday_data->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$company_birthday_data->ts_location.'<BR><BR>';}
if($company_birthday_data->garden != "" || $company_birthday_data->garden != NULL){ 
$html .= '<b>Garden: </b> <BR>';
if($company_birthday_data->garden == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($company_birthday_data->smoking != "" || $company_birthday_data->smoking != NULL){ 
$html .= '<b>Smoking: </b> <BR>';
if($company_birthday_data->smoking == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($company_birthday_data->max_kids != "" || $company_birthday_data->max_kids != NULL){ $html .= '<b>Max Kids: </b> <BR>'.$company_birthday_data->max_kids.'<BR><BR>';}
if($company_birthday_data->max_adults != "" || $company_birthday_data->max_adults != NULL){ $html .= '<b>Max Adults: </b> <BR>'.$company_birthday_data->max_adults.'<BR><BR>';}
if($company_birthday_data->catering != "" || $company_birthday_data->catering != NULL){ 
$html .= '<b>Catering: </b> <BR>';
if($company_birthday_data->catering == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($company_birthday_data->animators != "" || $company_birthday_data->animators != NULL){ 
$html .= '<b>Animators: </b> <BR>';
if($company_birthday_data->animators == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($company_birthday_data->watching_kids != "" || $company_birthday_data->watching_kids != NULL){ 
$html .= '<b>Watching Kids: </b> <BR>';
if($company_birthday_data->watching_kids == 1) $html .= $ap_lang["Yes"];
else 	$html .= $ap_lang["No"];
$html .='<BR><BR>';
}
if($company_birthday_data->name != "" || $company_birthday_data->name != NULL){ $html .= '<b>Name: </b> <BR>'.$company_birthday_data->name.'<BR><BR>';}	
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

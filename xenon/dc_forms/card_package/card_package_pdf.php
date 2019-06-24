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
$card_package = $broker->get_data(new card_package($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $card_package->id;
$header_param_list["checker"] = $card_package->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($card_package->checkerDate));
$header_param_list["maker"] = $card_package->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($card_package->makerDate));
$header_param_list["number_of_modifications"] = $card_package->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($card_package->name != "" || $card_package->name != NULL){ $html .= '<b>Name: </b> <BR>'.$card_package->name.'<BR><BR>';}
if($card_package->picture != "" || $card_package->picture != NULL){ 
$html .= '<b>Picture: </b> 
<BR> <img src="../pictures/card_package/picture/'.$card_package->picture.'" height="50"/><BR><BR><BR><BR><BR>';}
if($card_package->price != "" || $card_package->price != NULL){ $html .= '<b>Price: </b> <BR>'.$card_package->price.'<BR><BR>';}
if($card_package->to_company != "" || $card_package->to_company != NULL){ $html .= '<b>To Company: </b> <BR>'.$card_package->to_company.'<BR><BR>';}
if($card_package->to_us != "" || $card_package->to_us != NULL){ $html .= '<b>To Us: </b> <BR>'.$card_package->to_us.'<BR><BR>';}
if($card_package->duration_days != "" || $card_package->duration_days != NULL){ $html .= '<b>Duration Days: </b> <BR>'.$card_package->duration_days.'<BR><BR>';}
if($card_package->number_of_passes != "" || $card_package->number_of_passes != NULL){ $html .= '<b>Number Of Passes: </b> <BR>'.$card_package->number_of_passes.'<BR><BR>';}
if($card_package->best_value != "" || $card_package->best_value != NULL){ 
$html .= '<b>Best Value: </b> <BR>';
if($card_package->best_value == 1) $html .= $ap_lang["Yes"];
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

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
$accepted_passes = $broker->get_data(new accepted_passes($_GET["id"]));

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($accepted_passes->user_card));
$accepted_passes->user_card = $user_card->card_number;

require_once "../classes/domain/purchase.class.php";
$purchase = $broker->get_data(new purchase($accepted_passes->purchase));
$accepted_passes->purchase = $purchase->id;

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($accepted_passes->training_school));
$accepted_passes->training_school = $training_school->name;

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($accepted_passes->user));
$accepted_passes->user = $user->email;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $accepted_passes->id;
$header_param_list["checker"] = $accepted_passes->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($accepted_passes->checkerDate));
$header_param_list["maker"] = $accepted_passes->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($accepted_passes->makerDate));
$header_param_list["number_of_modifications"] = $accepted_passes->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($accepted_passes->user_card != "" || $accepted_passes->user_card != NULL){ $html .= '<b>User Card: </b> <BR>'.$accepted_passes->user_card.'<BR><BR>';}
if($accepted_passes->purchase != "" || $accepted_passes->purchase != NULL){ $html .= '<b>Purchase: </b> <BR>'.$accepted_passes->purchase.'<BR><BR>';}
if($accepted_passes->taken_passes != "" || $accepted_passes->taken_passes != NULL){ $html .= '<b>Taken Passes: </b> <BR>'.$accepted_passes->taken_passes.'<BR><BR>';}
if($accepted_passes->training_school != "" || $accepted_passes->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$accepted_passes->training_school.'<BR><BR>';}
if($accepted_passes->number_of_kids != "" || $accepted_passes->number_of_kids != NULL){ $html .= '<b>Number Of_kids: </b> <BR>'.$accepted_passes->number_of_kids.'<BR><BR>';}
if($accepted_passes->user != "" || $accepted_passes->user != NULL){ $html .= '<b>User: </b> <BR>'.$accepted_passes->user.'<BR><BR>';}
if($accepted_passes->pay_to_company != "" || $accepted_passes->pay_to_company != NULL){ $html .= '<b>Pay To_company: </b> <BR>'.$accepted_passes->pay_to_company.'<BR><BR>';}
if($accepted_passes->pay_to_us != "" || $accepted_passes->pay_to_us != NULL){ $html .= '<b>Pay To_us: </b> <BR>'.$accepted_passes->pay_to_us.'<BR><BR>';}
if($accepted_passes->company_location != "" || $accepted_passes->company_location != NULL){ $html .= '<b>Company Location: </b> <BR>'.$accepted_passes->company_location.'<BR><BR>';}
if($accepted_passes->pass_type != "" || $accepted_passes->pass_type != NULL){ $html .= '<b>Pass Type: </b> <BR>'.$accepted_passes->pass_type.'<BR><BR>';}
if($accepted_passes->reservation_id != "" || $accepted_passes->reservation_id != NULL){ $html .= '<b>Reservation Id: </b> <BR>'.$accepted_passes->reservation_id.'<BR><BR>';}	
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

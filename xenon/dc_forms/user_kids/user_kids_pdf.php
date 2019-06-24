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
$user_kids = $broker->get_data(new user_kids($_GET["id"]));

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($user_kids->user));
$user_kids->user = $user->email;

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($user_kids->user_card));
$user_kids->user_card = $user_card->card_number;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $user_kids->id;
$header_param_list["checker"] = $user_kids->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($user_kids->checkerDate));
$header_param_list["maker"] = $user_kids->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($user_kids->makerDate));
$header_param_list["number_of_modifications"] = $user_kids->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($user_kids->user != "" || $user_kids->user != NULL){ $html .= '<b>User: </b> <BR>'.$user_kids->user.'<BR><BR>';}
if($user_kids->name != "" || $user_kids->name != NULL){ $html .= '<b>Name: </b> <BR>'.$user_kids->name.'<BR><BR>';}
if($user_kids->date_of_birth != "" || $user_kids->date_of_birth != NULL){ 
$html .= '<b>Date Of_birth: </b> <BR>'; $html .= date("d.m.Y",strtotime($user_kids->date_of_birth)); $html .='<BR><BR>';}
if($user_kids->user_card != "" || $user_kids->user_card != NULL){ $html .= '<b>User Card: </b> <BR>'.$user_kids->user_card.'<BR><BR>';}	
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

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
$user = $broker->get_data(new user($_GET["id"]));

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $user->id;
$header_param_list["checker"] = $user->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($user->checkerDate));
$header_param_list["maker"] = $user->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($user->makerDate));
$header_param_list["number_of_modifications"] = $user->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($user->email != "" || $user->email != NULL){ $html .= '<b>Email: </b> <BR>'.$user->email.'<BR><BR>';}
if($user->password != "" || $user->password != NULL){ $html .= '<b>Password: </b> <BR>**********<BR><BR>';}
if($user->fb_id != "" || $user->fb_id != NULL){ $html .= '<b>Fb Id: </b> <BR>'.$user->fb_id.'<BR><BR>';}
if($user->first_name != "" || $user->first_name != NULL){ $html .= '<b>First Name: </b> <BR>'.$user->first_name.'<BR><BR>';}
if($user->last_name != "" || $user->last_name != NULL){ $html .= '<b>Last Name: </b> <BR>'.$user->last_name.'<BR><BR>';}
if($user->avatar != "" || $user->avatar != NULL){ $html .= '<b>Avatar: </b> <BR>'.$user->avatar.'<BR><BR>';}
if($user->user_type != "" || $user->user_type != NULL){ $html .= '<b>User Type: </b> <BR>'.$user->user_type.'<BR><BR>';}
if($user->pib != "" || $user->pib != NULL){ $html .= '<b>Pib: </b> <BR>'.$user->pib.'<BR><BR>';}
if($user->maticni != "" || $user->maticni != NULL){ $html .= '<b>Maticni: </b> <BR>'.$user->maticni.'<BR><BR>';}
if($user->adresa != "" || $user->adresa != NULL){ $html .= '<b>Adresa: </b> <BR>'.$user->adresa.'<BR><BR>';}
if($user->naziv != "" || $user->naziv != NULL){ $html .= '<b>Naziv: </b> <BR>'.$user->naziv.'<BR><BR>';}	
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

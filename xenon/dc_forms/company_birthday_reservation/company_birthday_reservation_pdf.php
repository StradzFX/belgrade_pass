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
$company_birthday_reservation = $broker->get_data(new company_birthday_reservation($_GET["id"]));

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($company_birthday_reservation->user));
$company_birthday_reservation->user = $user->email;

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($company_birthday_reservation->user_card));
$company_birthday_reservation->user_card = $user_card->card_number;

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_birthday_reservation->training_school));
$company_birthday_reservation->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($company_birthday_reservation->ts_location));
$company_birthday_reservation->ts_location = $ts_location->id;

require_once "../classes/domain/company_birthday_data.class.php";
$company_birthday_data = $broker->get_data(new company_birthday_data($company_birthday_reservation->company_birthday_data));
$company_birthday_reservation->company_birthday_data = $company_birthday_data->name;

require_once "../classes/domain/company_location_birthday_slots.class.php";
$company_location_birthday_slots = $broker->get_data(new company_location_birthday_slots($company_birthday_reservation->company_location_birthday_slots));
$company_birthday_reservation->company_location_birthday_slots = $company_location_birthday_slots->id;

$pdfd = new PDF();
$header_param_list["logo"] = "pdf/images/xenon_document_logo.jpg";
$header_param_list["id"] = $company_birthday_reservation->id;
$header_param_list["checker"] = $company_birthday_reservation->checker;
$header_param_list["checker_date"] = date("d.m.Y H:i:s",strtotime($company_birthday_reservation->checkerDate));
$header_param_list["maker"] = $company_birthday_reservation->maker;
$header_param_list["maker_date"] = date("d.m.Y H:i:s",strtotime($company_birthday_reservation->makerDate));
$header_param_list["number_of_modifications"] = $company_birthday_reservation->modNumber;
$pdfd->set_header($header_param_list);
$pdfd->AddPage();
$pdfd->SetFont("Arial","",8);
$html='';

if($company_birthday_reservation->user != "" || $company_birthday_reservation->user != NULL){ $html .= '<b>User: </b> <BR>'.$company_birthday_reservation->user.'<BR><BR>';}
if($company_birthday_reservation->user_card != "" || $company_birthday_reservation->user_card != NULL){ $html .= '<b>User Card: </b> <BR>'.$company_birthday_reservation->user_card.'<BR><BR>';}
if($company_birthday_reservation->training_school != "" || $company_birthday_reservation->training_school != NULL){ $html .= '<b>Training School: </b> <BR>'.$company_birthday_reservation->training_school.'<BR><BR>';}
if($company_birthday_reservation->ts_location != "" || $company_birthday_reservation->ts_location != NULL){ $html .= '<b>Ts Location: </b> <BR>'.$company_birthday_reservation->ts_location.'<BR><BR>';}
if($company_birthday_reservation->birthday_date != "" || $company_birthday_reservation->birthday_date != NULL){ 
$html .= '<b>Birthday Date: </b> <BR>'; $html .= date("d.m.Y",strtotime($company_birthday_reservation->birthday_date)); $html .='<BR><BR>';}
if($company_birthday_reservation->birthday_from_hours != "" || $company_birthday_reservation->birthday_from_hours != NULL){ $html .= '<b>Birthday From_hours: </b> <BR>'.$company_birthday_reservation->birthday_from_hours.'<BR><BR>';}
if($company_birthday_reservation->birthday_from_minutes != "" || $company_birthday_reservation->birthday_from_minutes != NULL){ $html .= '<b>Birthday From_minutes: </b> <BR>'.$company_birthday_reservation->birthday_from_minutes.'<BR><BR>';}
if($company_birthday_reservation->birthday_to_hours != "" || $company_birthday_reservation->birthday_to_hours != NULL){ $html .= '<b>Birthday To_hours: </b> <BR>'.$company_birthday_reservation->birthday_to_hours.'<BR><BR>';}
if($company_birthday_reservation->birthday_to_minutes != "" || $company_birthday_reservation->birthday_to_minutes != NULL){ $html .= '<b>Birthday To_minutes: </b> <BR>'.$company_birthday_reservation->birthday_to_minutes.'<BR><BR>';}
if($company_birthday_reservation->status != "" || $company_birthday_reservation->status != NULL){ $html .= '<b>Status: </b> <BR>'.$company_birthday_reservation->status.'<BR><BR>';}
if($company_birthday_reservation->number_of_kids != "" || $company_birthday_reservation->number_of_kids != NULL){ $html .= '<b>Number Of_kids: </b> <BR>'.$company_birthday_reservation->number_of_kids.'<BR><BR>';}
if($company_birthday_reservation->number_of_adults != "" || $company_birthday_reservation->number_of_adults != NULL){ $html .= '<b>Number Of_adults: </b> <BR>'.$company_birthday_reservation->number_of_adults.'<BR><BR>';}
if($company_birthday_reservation->company_birthday_data != "" || $company_birthday_reservation->company_birthday_data != NULL){ $html .= '<b>Company Birthday_data: </b> <BR>'.$company_birthday_reservation->company_birthday_data.'<BR><BR>';}
if($company_birthday_reservation->company_location_birthday_slots != "" || $company_birthday_reservation->company_location_birthday_slots != NULL){ $html .= '<b>Company Location_birthday_slots: </b> <BR>'.$company_birthday_reservation->company_location_birthday_slots.'<BR><BR>';}	
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

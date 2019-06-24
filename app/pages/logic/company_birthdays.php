<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$selected_tab = 'reservations';

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Rođendani";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$company = $broker->get_session('company');
if($company->type != 'location'){$validation_message = "Morate da se ulogujete kao prodajna lokacija";}


$b_reservations = new company_birthday_reservation();
$b_reservations->set_condition('checker','!=','');
$b_reservations->add_condition('recordStatus','=','O');
$b_reservations->add_condition('ts_location','=',$company->location->id);
$b_reservations->add_condition('birthday_date','>=',date('Y-m-d'));
$b_reservations->add_condition('status','=','unconfirmed');
$b_reservations->set_order_by('pozicija','DESC');
$b_reservations = $broker->get_all_data_condition($b_reservations);

for($i=0;$i<sizeof($b_reservations);$i++){
if($b_reservations[$i]->user != ''){$b_reservations[$i]->user = $broker->get_data(new user($b_reservations[$i]->user));}
if($b_reservations[$i]->user_card != ''){$b_reservations[$i]->user_card = $broker->get_data(new user_card($b_reservations[$i]->user_card));}
if($b_reservations[$i]->training_school != ''){$b_reservations[$i]->training_school = $broker->get_data(new training_school($b_reservations[$i]->training_school));}
if($b_reservations[$i]->ts_location != ''){$b_reservations[$i]->ts_location = $broker->get_data(new ts_location($b_reservations[$i]->ts_location));}

	$b_reservations[$i]->birthday_date = date('d.m.Y.',strtotime($b_reservations[$i]->birthday_date));
	$bfh = $b_reservations[$i]->birthday_from_hours < 10 ? '0'.$b_reservations[$i]->birthday_from_hours : $b_reservations[$i]->birthday_from_hours;
	$bfm = $b_reservations[$i]->birthday_from_minutes < 10 ? '0'.$b_reservations[$i]->birthday_from_minutes : $b_reservations[$i]->birthday_from_minutes;
	$bth = $b_reservations[$i]->birthday_to_hours < 10 ? '0'.$b_reservations[$i]->birthday_to_hours : $b_reservations[$i]->birthday_to_hours;
	$btm = $b_reservations[$i]->birthday_to_minutes < 10 ? '0'.$b_reservations[$i]->birthday_to_minutes : $b_reservations[$i]->birthday_to_minutes;

	$b_reservations[$i]->birthday_time = $bfh.':'.$bfm.' - '.$bth.':'.$btm;

	$b_reservations[$i]->number_of_kids = $b_reservations[$i]->number_of_kids == '' ? '-' : $b_reservations[$i]->number_of_kids;
	$b_reservations[$i]->number_of_adults = $b_reservations[$i]->number_of_adults == '' ? '-' : $b_reservations[$i]->number_of_adults;

}


$b_done_deals = new company_birthday_reservation();
$b_done_deals->set_condition('checker','!=','');
$b_done_deals->add_condition('recordStatus','=','O');
$b_done_deals->add_condition('status','=','approved');
$b_done_deals->add_condition('ts_location','=',$company->location->id);
$b_done_deals->set_order_by('pozicija','DESC');
$b_done_deals = $broker->get_all_data_condition($b_done_deals);

for($i=0;$i<sizeof($b_done_deals);$i++){
if($b_done_deals[$i]->user != ''){$b_done_deals[$i]->user = $broker->get_data(new user($b_done_deals[$i]->user));}
if($b_done_deals[$i]->user_card != ''){$b_done_deals[$i]->user_card = $broker->get_data(new user_card($b_done_deals[$i]->user_card));}
if($b_done_deals[$i]->training_school != ''){$b_done_deals[$i]->training_school = $broker->get_data(new training_school($b_done_deals[$i]->training_school));}
if($b_done_deals[$i]->ts_location != ''){$b_done_deals[$i]->ts_location = $broker->get_data(new ts_location($b_done_deals[$i]->ts_location));}

	$b_done_deals[$i]->can_delete = strtotime($b_done_deals[$i]->birthday_date) >= strtotime(date('Y-m-d'));

	$b_done_deals[$i]->birthday_date = date('d.m.Y.',strtotime($b_done_deals[$i]->birthday_date));
	$bfh = $b_done_deals[$i]->birthday_from_hours < 10 ? '0'.$b_done_deals[$i]->birthday_from_hours : $b_done_deals[$i]->birthday_from_hours;
	$bfm = $b_done_deals[$i]->birthday_from_minutes < 10 ? '0'.$b_done_deals[$i]->birthday_from_minutes : $b_done_deals[$i]->birthday_from_minutes;
	$bth = $b_done_deals[$i]->birthday_to_hours < 10 ? '0'.$b_done_deals[$i]->birthday_to_hours : $b_done_deals[$i]->birthday_to_hours;
	$btm = $b_done_deals[$i]->birthday_to_minutes < 10 ? '0'.$b_done_deals[$i]->birthday_to_minutes : $b_done_deals[$i]->birthday_to_minutes;

	$b_done_deals[$i]->birthday_time = $bfh.':'.$bfm.' - '.$bth.':'.$btm;

	$b_done_deals[$i]->number_of_kids = $b_done_deals[$i]->number_of_kids == '' ? '-' : $b_done_deals[$i]->number_of_kids;
	$b_done_deals[$i]->number_of_adults = $b_done_deals[$i]->number_of_adults == '' ? '-' : $b_done_deals[$i]->number_of_adults;

}

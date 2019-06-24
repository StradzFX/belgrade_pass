<?php
$website_list = new user_card();
$website_list->set_condition('checker','!=','');
$website_list->add_condition('recordStatus','=','O');
$website_list->add_condition('delivery_method','=','post');
$website_list->add_condition('','',"card_number NOT IN (SELECT card_number FROM card_numbers WHERE internal_reservation = 1)");
$website_list->set_order_by('pozicija','DESC');
$website_list = $broker->get_all_data_condition($website_list);

for ($i=0; $i < sizeof($website_list); $i++) { 
	$website_list[$i]->address = $website_list[$i]->post_street.', '.$website_list[$i]->post_postal.' '.$website_list[$i]->post_city;
	$website_list[$i]->customer_received = $website_list[$i]->customer_received == 1 ? 'Yes' : 'No';
	$website_list[$i]->full_name = $website_list[$i]->parent_first_name.' '.$website_list[$i]->parent_last_name;
	$website_list[$i]->date_issued = date('d.m.Y.',strtotime($website_list[$i]->makerDate));
}

$partner_list = new user_card();
$partner_list->set_condition('checker','!=','');
$partner_list->add_condition('recordStatus','=','O');
$partner_list->add_condition('delivery_method','=','partner');
$partner_list->add_condition('company_location','>',0);
$partner_list->set_order_by('pozicija','DESC');
$partner_list = $broker->get_all_data_condition($partner_list);

for ($i=0; $i < sizeof($partner_list); $i++) { 
	$partner_list[$i]->partner = $broker->get_data(new ts_location($partner_list[$i]->company_location));
	$partner_list[$i]->partner->company = $broker->get_data(new training_school($partner_list[$i]->partner->training_school));
	$partner_list[$i]->partner->full_name = $partner_list[$i]->partner->company->name.' - '.$partner_list[$i]->partner->part_of_city.', '.$partner_list[$i]->partner->street;
	$partner_list[$i]->customer_received = $partner_list[$i]->customer_received == 1 ? 'Yes' : 'No';
	$partner_list[$i]->full_name = $partner_list[$i]->parent_first_name.' '.$partner_list[$i]->parent_last_name;
	$partner_list[$i]->date_issued = date('d.m.Y.',strtotime($partner_list[$i]->makerDate));
}



$internal_cards_list = new user_card();
$internal_cards_list->set_condition('checker','!=','');
$internal_cards_list->add_condition('recordStatus','=','O');
$internal_cards_list->add_condition('delivery_method','=','post');
$internal_cards_list->add_condition('','',"card_number IN (SELECT card_number FROM card_numbers WHERE internal_reservation = 1)");
$internal_cards_list->set_order_by('pozicija','DESC');
$internal_cards_list = $broker->get_all_data_condition($internal_cards_list);

for ($i=0; $i < sizeof($internal_cards_list); $i++) { 
	$internal_cards_list[$i]->address = $internal_cards_list[$i]->post_street.', '.$internal_cards_list[$i]->post_postal.' '.$internal_cards_list[$i]->post_city;
	$internal_cards_list[$i]->customer_received = $internal_cards_list[$i]->customer_received == 1 ? 'Yes' : 'No';
	$internal_cards_list[$i]->full_name = $internal_cards_list[$i]->parent_first_name.' '.$internal_cards_list[$i]->parent_last_name;
	$internal_cards_list[$i]->date_issued = date('d.m.Y.',strtotime($internal_cards_list[$i]->makerDate));
}


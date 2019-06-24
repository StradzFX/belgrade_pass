<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}


$selected_tab = 'new_card';

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Kartice";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$company = $broker->get_session('company');

if($company->type != 'location'){
	header('Location:'.$base_url.'company_home/');
	die();
}

//======== ALL COMPANY CARDS ===========
$company_cards = new card_numbers();
$company_cards->set_condition('checker','!=','');
$company_cards->add_condition('recordStatus','=','O');
$company_cards->add_condition('company_card','=',$company->id);
$company_cards->add_condition('company_location','=',$company->location->id);
$company_cards->set_order_by('id','ASC');
$company_cards = $broker->get_all_data_condition($company_cards);

for($i=0;$i<sizeof($company_cards);$i++){

}

//======== RESERVED CARDS ===========
$reserved_cards = new user_card();
$reserved_cards->set_condition('checker','!=','');
$reserved_cards->add_condition('recordStatus','=','O');
$reserved_cards->add_condition('partner_id','=',$company->id);
$reserved_cards->add_condition('company_location','=',$company->location->id);
$reserved_cards->add_condition('customer_received','=','0');
$reserved_cards->add_condition('delivery_method','=','partner');
$reserved_cards->set_order_by('id','ASC');
$reserved_cards = $broker->get_all_data_condition($reserved_cards);

for($i=0;$i<sizeof($reserved_cards);$i++){

}

//======== CARDS TO FILL ===========
$cards_to_fill = new user_card();
$cards_to_fill->set_condition('checker','!=','');
$cards_to_fill->add_condition('recordStatus','=','O');
$cards_to_fill->add_condition('partner_id','=',$company->id);
$cards_to_fill->add_condition('company_location','=',$company->location->id);
$cards_to_fill->add_condition('parent_first_name','=','');
$cards_to_fill->add_condition('delivery_method','=','partner');
$cards_to_fill->set_order_by('id','ASC');
$cards_to_fill = $broker->get_all_data_condition($cards_to_fill);

for($i=0;$i<sizeof($cards_to_fill);$i++){

}

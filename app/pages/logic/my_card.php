<?php

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}


//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Moja kartica";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$reg_user = $broker->get_session('user');

$card_list = new user_card();
$card_list->set_condition('checker','!=','');
$card_list->set_condition('checker','!=','company');
$card_list->add_condition('recordStatus','=','O');
$card_list->add_condition('user','=',$reg_user->id);
$card_list->set_order_by('pozicija','DESC');
$card_list->set_order_by('id','DESC');
$card_list = $broker->get_all_data_condition($card_list);

for ($i=0; $i < sizeof($card_list); $i++) { 
	if($card_list[$i]->delivery_method == 'post'){
		$address = $card_list[$i]->post_street.', '.$card_list[$i]->post_postal.' '.$card_list[$i]->post_city.'';
		$card_list[$i]->card_status = "Dostava na kućnu adresu: <b>$address</b>";
	}

	if($card_list[$i]->delivery_method == 'partner'){
		$card_list[$i]->partner = $broker->get_data(new training_school($card_list[$i]->partner_id));
		$card_list[$i]->card_status = 'Preuzeti kod patnera "<b>'.$card_list[$i]->partner->name.'</b>"';
	}

	$card_list[$i]->balance = CardModule::get_card_credits($card_list[$i]);
}

$preselected_package = null;
if($url_params[0] != ''){
	$preselected_package = $url_params[0];
}

$SQL = "SELECT DISTINCT company_card AS id FROM card_numbers WHERE card_taken = 0 AND company_card > 0";
$company_list = $broker->execute_sql_get_array($SQL);

for ($i=0; $i < sizeof($company_list); $i++) { 
	$company = $broker->get_data(new training_school($company_list[$i]['id']));

	$ts_location_all = new ts_location();
	$ts_location_all->set_condition('checker','!=','');
	$ts_location_all->add_condition('recordStatus','=','O');
	$ts_location_all->add_condition('training_school','=',$company->id);
	$ts_location_all->set_order_by('pozicija','DESC');
	$company->locations = $broker->get_all_data_condition($ts_location_all);
	$company->number_of_locations = sizeof($company->locations) < 2 ? '1 Lokacija' : 'Više lokacija';

	$company_list[$i] = $company;
}
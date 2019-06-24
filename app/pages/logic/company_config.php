<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Podešavanja";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$company = $broker->get_session('company');

$internal_codes = array();


$card_package_all = new card_package();
$card_package_all->set_condition('checker','!=','');
$card_package_all->add_condition('recordStatus','=','O');
$card_package_all->set_order_by('pozicija','DESC');
$card_package_all = $broker->get_all_data_condition($card_package_all);
$has_best_value = false;
for($i=0;$i<sizeof($card_package_all);$i++){
	$code_name = 'package_'.$card_package_all[$i]->id;
	$code_name_display = 'Prodaja paketa '.$card_package_all[$i]->name;

	$internal_codes_all = new internal_codes();
	$internal_codes_all->set_condition('checker','!=','');
	$internal_codes_all->add_condition('recordStatus','=','O');
	$internal_codes_all->add_condition('training_school','=',$company->id);
	$internal_codes_all->add_condition('code_name','=',$code_name);
	$internal_codes_all->set_order_by('pozicija','DESC');
	$internal_codes_all = $broker->get_all_data_condition($internal_codes_all);

	if(sizeof($internal_codes_all) > 0){
		$code_value = $internal_codes_all[0]->code_value;
	}else{
		$code_value = '';
	}

	$internal_codes[] = array(
		'code_name' => $code_name,
		'code_name_display' => $code_name_display,
		'code_value' => $code_value
	);
}

$code_name = 'approved_pass';
$code_name_display = 'Zabelezeni prolazi';

$internal_codes_all = new internal_codes();
$internal_codes_all->set_condition('checker','!=','');
$internal_codes_all->add_condition('recordStatus','=','O');
$internal_codes_all->add_condition('training_school','=',$company->id);
$internal_codes_all->add_condition('code_name','=',$code_name);
$internal_codes_all->set_order_by('pozicija','DESC');
$internal_codes_all = $broker->get_all_data_condition($internal_codes_all);

if(sizeof($internal_codes_all) > 0){
	$code_value = $internal_codes_all[0]->code_value;
}else{
	$code_value = '';
}

$internal_codes[] = array(
	'code_name' => $code_name,
	'code_name_display' => $code_name_display,
	'code_value' => $code_value
);

<?php

if(!$_SESSION['company']){
	$url_addon = '';
	if(isset($_GET['card'])){
		$url_addon = "?card=".$_GET['card']."&approval_code=".$_GET['approval_code'];
	}

	header('Location:'.$base_url.'company_panel/'.$url_addon);
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Odobravanje prolaza";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$company = $broker->get_session('company');

$ts_location_all = new ts_location();
$ts_location_all->set_condition('checker','!=','');
$ts_location_all->add_condition('recordStatus','=','O');
$ts_location_all->add_condition('training_school','=',$company->id);
$ts_location_all->set_order_by('pozicija','DESC');
$ts_location_all = $broker->get_all_data_condition($ts_location_all);

for($i=0;$i<sizeof($ts_location_all);$i++){
	
}


$credit_ponder = (100 - $company->pass_customer_percentage)/100;
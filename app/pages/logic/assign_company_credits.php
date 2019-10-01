<?php

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Dodeli kredit";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$reg_user = $broker->get_session('user');
$reg_user->card = CardModule::get_company_mster_card($reg_user->id);
$reg_user->card->balance = CardModule::get_card_credits($reg_user->card);

$card = $broker->get_data(new user_card($url_params[0]));


$slider_max = $reg_user->card->balance < 100000 ? $reg_user->card->balance : 100000;
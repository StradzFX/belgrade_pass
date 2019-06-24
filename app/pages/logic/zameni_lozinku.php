<?php
$reg_user = $broker->get_session('user');
if($reg_user){
	header('Location:'.$base_url.'profile/');
	die();
}

$user_id = $url_params[0];

$user = new user();
$user->set_condition('','',"MD5(id) = '".$user_id."'");
$user = $broker->get_all_data_condition($user);

if(sizeof($user) == 0){
	header('Location:'.$base_url);
	die();
}

$title = "Belgrade Pass - Resetuj lozinku";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================
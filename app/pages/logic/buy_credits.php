<?php

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Kupi Kredit";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$reg_user = $broker->get_session('user');

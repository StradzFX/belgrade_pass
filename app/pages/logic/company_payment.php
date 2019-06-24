<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Uplate";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

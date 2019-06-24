<?php

if($_SESSION['company']){
	header('Location:'.$base_url.'company_home/');
	die();
}

if($_GET['username']){
	$kompanija = $_GET['username'];
}else{
	$kompanija = '';
}

$url_addon = '';
if(isset($_GET['card'])){
	$url_addon = "?card=".$_GET['card']."&approval_code=".$_GET['approval_code'];
}


//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Logovanje za kompanije";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

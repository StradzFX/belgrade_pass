<?php
$list_categories = CategoryModule::list_all();

$list_cities = SchoolLocationModule::list_cities_select();


//========================== SEO PARAMETERS =======================================================
$title = "Search for coaches";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================
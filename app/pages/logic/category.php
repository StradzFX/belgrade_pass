<?php

$selected_category = $url_params[0];

$list_categories = CategoryModule::list_all();

$list_cities = SchoolLocationModule::list_cities_select();

//========================== SEO PARAMETERS =======================================================
$title = "Search";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$body_classes = 'page-template-default page page-id-6 wp-custom-logo tribe-no-js group-blog page-listings listable';
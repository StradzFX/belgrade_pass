<?php
$list_categories = CategoryModule::list_all();

$list_cities = CompanyLocationModule::list_cities_select();

$selected_category = null;
if($url_params[0] == 'category'){
	$selected_category = addslashes($url_params[1]);
}


//========================== SEO PARAMETERS =======================================================
$title = "Pregraga aktivnosti - Belgrade Pass";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$body_classes = 'page-template-default page page-id-6 wp-custom-logo tribe-no-js group-blog page-listings listable';
<?php

$coach = CoachModule::get($url_params[0]);

$list_schools = SchoolModule::get_by_coach($coach->id);

//========================== SEO PARAMETERS =======================================================
$title = $coach->first_name.' '.$coach->last_name;
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

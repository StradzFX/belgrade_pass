<?php

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Početna strana";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================


$featured_schools = SchoolModule::get_home_featured();

$trending_schools = SchoolModule::get_home_trending();

$list_categories = CategoryModule::list_all_popular();

$latest_coaches = CoachModule::get_home_latest();


$card_package_all = new card_package();
$card_package_all->set_condition('checker','!=','');
$card_package_all->add_condition('recordStatus','=','O');
$card_package_all->set_order_by('pozicija','DESC');
$card_package_all = $broker->get_all_data_condition($card_package_all);
$has_best_value = false;
for($i=0;$i<sizeof($card_package_all);$i++){
	$card_package_all[$i]->picture = 'pictures/card_package/picture/'.$card_package_all[$i]->picture;
	if($card_package_all[$i]->best_value == 1){
		$has_best_value = true;
	}
}


$training_school_all = new training_school();
$training_school_all->set_condition('checker','!=','');
$training_school_all->add_condition('recordStatus','=','O');
$training_school_all->add_condition('pass_options','=','1');
$training_school_all->set_order_by('pozicija','DESC');
$training_school_count = $broker->get_count_condition($training_school_all);


$user_card_all = new user_card();
$user_card_all->set_condition('checker','!=','');
$user_card_all->add_condition('recordStatus','=','O');
$user_card_all->set_order_by('pozicija','DESC');
$user_card_count = $broker->get_count_condition($user_card_all);

$categories_highlights = new sport_category();
$categories_highlights->set_condition('checker','!=','');
$categories_highlights->add_condition('recordStatus','=','O');
$categories_highlights->set_order_by('popularity','DESC');
$categories_highlights->set_limit(5);
$categories_highlights = $broker->get_all_data_condition_limited($categories_highlights);

$categories_search = new sport_category();
$categories_search->set_condition('checker','!=','');
$categories_search->add_condition('recordStatus','=','O');
$categories_search->set_order_by('popularity','DESC');
$categories_search = $broker->get_all_data_condition($categories_search);

$categories_wrap = new sport_category();
$categories_wrap->set_condition('checker','!=','');
$categories_wrap->add_condition('recordStatus','=','O');
$categories_wrap->set_order_by('popularity','DESC');
$categories_wrap = $broker->get_all_data_condition($categories_wrap);

for ($i=0; $i < sizeof($categories_wrap); $i++) { 
	$count = new company_category();
	$count->add_condition('checker','!=','');
	$count->add_condition('recordStatus','=','O');
	$count->add_condition('category','=',$categories_wrap[$i]->id);

	$categories_wrap[$i]->count = $broker->get_count_condition($count);

	$categories_wrap[$i]->map_logo = 'pictures/sport_category/map_logo/'.$categories_wrap[$i]->map_logo;
}


$top_places = new training_school();
$top_places->set_condition('checker','!=','');
$top_places->add_condition('recordStatus','=','O');
$top_places->set_order_by('pass_customer_percentage','DESC');
$top_places->set_limit(3);
$top_places = $broker->get_all_data_condition_limited($top_places);

for ($i=0; $i < sizeof($top_places); $i++) { 
	$ts_picture_all = new ts_picture();
	$ts_picture_all->set_condition('checker','!=','');
	$ts_picture_all->add_condition('training_school','=',$top_places[$i]->id);
	$ts_picture_all->add_condition('recordStatus','=','O');
	$ts_picture_all->add_condition('thumb','=',1);
	$ts_picture_all->set_order_by('pozicija','DESC');
	$ts_picture_all = $broker->get_all_data_condition($ts_picture_all);

	$top_places[$i]->thumb = $ts_picture_all[0];
	$top_places[$i]->thumb = 'pictures/ts_picture/picture/'.$top_places[$i]->thumb->picture;


	$categories = new sport_category();
	$categories->add_condition('checker','!=','');
	$categories->add_condition('recordStatus','=','O');
	$categories->add_condition('id','IN',"(SELECT category FROM company_category WHERE company = ".$top_places[$i]->id.")");

	$top_places[$i]->categories = $broker->get_all_data_condition($categories);
}
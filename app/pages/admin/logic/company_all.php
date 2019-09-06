<?php
global $broker;

$list = SchoolModule::get_admin_list();

for ($i=0; $i < sizeof($list); $i++) {
	$list[$i]->card_usage_total = CardModule::get_card_usage_total($list[$i]->id);

	$categories = new sport_category();
	$categories->set_condition('checker','!=','');
	$categories->add_condition('recordStatus','=','O');
	$categories->add_condition('id','IN',"(SELECT category FROM company_category WHERE company = ".$list[$i]->id." AND checker != '' AND recordStatus = 'O')");
	$categories->set_order_by('popularity','DESC');
	$categories->set_limit(5);
	$categories = $broker->get_all_data_condition_limited($categories);

	$categories_display = array();
	foreach ($categories as $value) {
		$categories_display[] = $value->name;
	}


	$categories_display = implode(', ', $categories_display);
	$list[$i]->categories_display = $categories_display;
}
<?php

$title = "Belgrade Pass - Kupi paket";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

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


$reg_user = $broker->get_session('user');
if($reg_user){
	$user_card_all = new user_card();
	$user_card_all->set_condition('checker','!=','');
	$user_card_all->add_condition('recordStatus','=','O');
	$user_card_all->add_condition('user','=',$reg_user->id);
	$user_card_all->set_order_by('pozicija','DESC');
	$user_card_all = $broker->get_all_data_condition($user_card_all);

	for($i=0;$i<sizeof($user_card_all);$i++){
	if($user_card_all[$i]->user != ''){$user_card_all[$i]->user = $broker->get_data(new user($user_card_all[$i]->user));}
	}

}

$preselected_package = null;
if($url_params[0] != ''){
	$preselected_package = $url_params[0];
}

$SQL = "SELECT DISTINCT company_card AS id FROM card_numbers WHERE card_taken = 0 AND company_card > 0";
$company_list = $broker->execute_sql_get_array($SQL);

for ($i=0; $i < sizeof($company_list); $i++) { 
	$company_list[$i] = $broker->get_data(new training_school($company_list[$i]['id']));
}
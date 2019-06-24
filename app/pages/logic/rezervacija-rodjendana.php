<?php

//========================== SEO PARAMETERS =======================================================
$title = "Rezervacija rođendana - Belgrade Pass.rs";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$reg_user = $broker->get_session('user');
$selected_date = $url_params[0];
$selected_date = date('Y-m-d',strtotime($selected_date));
$selected_company = $url_params[1];

//=====================================
$filters = array();
foreach ($_GET as $key => $value) {
	$filters[$key] = addslashes($value);
}
// =======================================

if($reg_user){
	$valid_date = false;
	if(strtotime($selected_date) >= strtotime(date('Y-m-d'))){
		$valid_date = true;
	}

	if($valid_date){

		$card_list = new user_card();
		$card_list->set_condition('checker','!=','');
		$card_list->add_condition('recordStatus','=','O');
		$card_list->add_condition('user','=',$reg_user->id);
		$card_list->set_order_by('pozicija','DESC');
		$card_list->set_order_by('id','DESC');
		$card_list = $broker->get_all_data_condition($card_list);

		

		$company_list = BirthdayReservationsModule::get_list($selected_date,$filters);

		
	}
}

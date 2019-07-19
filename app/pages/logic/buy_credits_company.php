<?php

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Kupi kredit";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$reg_user = $broker->get_session('user');

$card_list = new user_card();
$card_list->set_condition('checker','!=','');
$card_list->add_condition('recordStatus','=','O');
$card_list->add_condition('user','=',$reg_user->id);
$card_list->set_order_by('pozicija','DESC');
$card_list->set_order_by('id','DESC');
$card_list = $broker->get_all_data_condition($card_list);

for ($i=0; $i < sizeof($card_list); $i++) { 
	if($card_list[$i]->delivery_method == 'post'){
		$address = $card_list[$i]->post_street.', '.$card_list[$i]->post_postal.' '.$card_list[$i]->post_city.'';
		$card_list[$i]->card_status = "Dostava na kućnu adresu: <b>$address</b>";
	}

	if($card_list[$i]->delivery_method == 'partner'){
		$card_list[$i]->partner = $broker->get_data(new training_school($card_list[$i]->partner_id));
		$card_list[$i]->card_status = 'Preuzeti kod patnera "<b>'.$card_list[$i]->partner->name.'</b>"';
	}
}
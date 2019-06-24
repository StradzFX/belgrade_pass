<?php

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Moj profil";
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
$card_list->set_order_by('pozicija','ASC');
$card_list->set_order_by('id','ASC');
$card_list = $broker->get_all_data_condition($card_list);

for ($i=0; $i < sizeof($card_list); $i++) { 
	$card_list[$i]->left_passes = 0;
	$card_list[$i]->last_package_date = 'Nema uplaćenih paketa';


	$total_passes = 0;
	$taken_passes = 0;

	$purchase_all = new purchase();
	$purchase_all->set_condition('checker','!=','');
	$purchase_all->add_condition('recordStatus','=','O');
	$purchase_all->add_condition('user_card','=',$card_list[$i]->id);
	$purchase_all->add_condition('end_date','>=',date('Y-m-d'));
	$purchase_all->set_order_by('pozicija','ASC');
	$purchase_all = $broker->get_all_data_condition($purchase_all);


	if(sizeof($purchase_all) > 0){
		for($j=0;$j<sizeof($purchase_all);$j++){
			$total_passes += $purchase_all[$j]->number_of_passes;
			$card_list[$i]->last_package_date = date('d.m.Y.',strtotime($purchase_all[$j]->end_date));

			$accepted_passes_all = new accepted_passes();
			$accepted_passes_all->set_condition('checker','!=','');
			$accepted_passes_all->add_condition('recordStatus','=','O');
			$accepted_passes_all->add_condition('purchase','=',$purchase_all[$j]->id);
			$accepted_passes_all->add_condition('user_card','=',$card_list[$i]->id);
			$accepted_passes_all->set_order_by('pozicija','DESC');
			$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

			
			for($z=0;$z<sizeof($accepted_passes_all);$z++){
				$taken_passes += $accepted_passes_all[$j]->taken_passes;
			}
		}


	}

	

	$card_list[$i]->left_passes = $total_passes - $taken_passes;

}
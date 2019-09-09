<?php

$any_transaction = false;
$selected_tab = 'package_payments';

if(!$_SESSION['user']){
	header('Location:'.$base_url.'registracija/');
	die();
}

$reg_user = $broker->get_session('user');

if(!$reg_user){
	header('Location:'.$base_url);
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Moje transakcije";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$transactions_all = new transactions();
$transactions_all->set_condition('checker','!=','');
$transactions_all->add_condition('recordStatus','=','O');
$transactions_all->add_condition('user','=',$reg_user->id);
$transactions_all->set_order_by('pozicija','DESC');
$transactions_all = $broker->get_all_data_condition($transactions_all);

for($i=0;$i<sizeof($transactions_all);$i++){

	$transactions_all[$i]->display_date = date('d.m.Y.',strtotime($transactions_all[$i]->makerDate));

	if($transactions_all[$i]->transaction_type == 'purchase_post_office'){
		$transactions_all[$i]->purchase = $broker->get_data(new purchase($transactions_all[$i]->tranaction_id));
		$transactions_all[$i]->status = $transactions_all[$i]->purchase->checker == '' ? 'Nije plaćen' : 'Plaćen';
		$transactions_all[$i]->status_css = $transactions_all[$i]->purchase->checker != '' ? 'green' : 'red';
	}

	if($transactions_all[$i]->transaction_type == 'purchase_card'){
		$transactions_all[$i]->purchase = $broker->get_data(new purchase($transactions_all[$i]->tranaction_id));
		$transactions_all[$i]->status = $transactions_all[$i]->purchase->checker == '' ? 'Nije plaćen' : 'Plaćen';
		$transactions_all[$i]->status_css = $transactions_all[$i]->purchase->checker != '' ? 'green' : 'red';
	}

	if($transactions_all[$i]->transaction_type == 'purchase_company'){
		$transactions_all[$i]->purchase = $broker->get_data(new purchase($transactions_all[$i]->tranaction_id));
		$transactions_all[$i]->status = $transactions_all[$i]->purchase->checker == '' ? 'Nije plaćen' : 'Plaćen';
		$transactions_all[$i]->status_css = $transactions_all[$i]->purchase->checker != '' ? 'green' : 'red';
	}
}

if(sizeof($transactions_all)){
	$any_transaction = true;
}


$accepted_passes_all = new accepted_passes();
$accepted_passes_all->set_condition('checker','!=','');
$accepted_passes_all->add_condition('recordStatus','=','O');
$accepted_passes_all->add_condition('user','=',$reg_user->id);
$accepted_passes_all->set_order_by('id','DESC');
$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

for($i=0;$i<sizeof($accepted_passes_all);$i++){
	if($accepted_passes_all[$i]->user_card != ''){$accepted_passes_all[$i]->user_card = $broker->get_data(new user_card($accepted_passes_all[$i]->user_card));}
	if($accepted_passes_all[$i]->purchase != ''){$accepted_passes_all[$i]->purchase = $broker->get_data(new purchase($accepted_passes_all[$i]->purchase));}
	if($accepted_passes_all[$i]->training_school != ''){$accepted_passes_all[$i]->company = $broker->get_data(new training_school($accepted_passes_all[$i]->training_school));}
	if($accepted_passes_all[$i]->user != ''){$accepted_passes_all[$i]->user = $broker->get_data(new user($accepted_passes_all[$i]->user));}
	if($accepted_passes_all[$i]->company_location != ''){$accepted_passes_all[$i]->company_location = $broker->get_data(new ts_location($accepted_passes_all[$i]->company_location));}

	$accepted_passes_all[$i]->display_date = date('d.m.Y. H:i:s',strtotime($accepted_passes_all[$i]->makerDate));
}


if(sizeof($accepted_passes_all)){
	$any_transaction = true;
}
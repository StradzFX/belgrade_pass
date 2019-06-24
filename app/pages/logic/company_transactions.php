<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$company = $broker->get_session('company');
$any_transaction = false;

$internal_codes_all = new internal_codes();
$internal_codes_all->set_condition('checker','!=','');
$internal_codes_all->add_condition('recordStatus','=','O');
$internal_codes_all->add_condition('training_school','=',$company->id);
$internal_codes_all->set_order_by('pozicija','DESC');
$internal_codes_all = $broker->get_all_data_condition($internal_codes_all);

$internal_codes = array();
for($i=0;$i<sizeof($internal_codes_all);$i++){
	$internal_codes[$internal_codes_all[$i]->code_name] = $internal_codes_all[$i]->code_value;
}


$selected_tab = 'approved_passes';
if($url_params[0] != ''){
	$selected_tab = $url_params[0];
}

$purchase_all = new purchase();
$purchase_all->set_condition('checker','!=','');
$purchase_all->add_condition('recordStatus','=','O');
$purchase_all->add_condition('purchase_type','=','company');
$purchase_all->add_condition('company_flag','=',$company->id);
if($company->type == 'location'){
	$purchase_all->add_condition('company_location','=',$company->location->id);
}
$purchase_all->set_order_by('pozicija','DESC');
$purchase_all = $broker->get_all_data_condition($purchase_all);

if(sizeof($purchase_all) > 0){$any_transaction = true;}

$total_to_pay = 0;
for($i=0;$i<sizeof($purchase_all);$i++){
	if($purchase_all[$i]->user != ''){$purchase_all[$i]->user = $broker->get_data(new user($purchase_all[$i]->user));}
	if($purchase_all[$i]->card_package != ''){$purchase_all[$i]->card_package = $broker->get_data(new card_package($purchase_all[$i]->card_package));}
	if($purchase_all[$i]->user_card != ''){$purchase_all[$i]->user_card = $broker->get_data(new user_card($purchase_all[$i]->user_card));}

	$purchase_all[$i]->display_date = date('d.m.Y. H:i:s',strtotime($purchase_all[$i]->makerDate));
	$total_to_pay += $purchase_all[$i]->price;
	$purchase_all[$i]->internal_code = '-';

	if($internal_codes['package_'.$purchase_all[$i]->card_package->id]){
		$purchase_all[$i]->internal_code = $internal_codes['package_'.$purchase_all[$i]->card_package->id];
		if($purchase_all[$i]->internal_code == ''){
			$purchase_all[$i]->internal_code = '-';
		}
	}

}

$total_to_pay_to_partner = 0;

$approvals_all = new accepted_passes();
$approvals_all->set_condition('checker','!=','');
$approvals_all->add_condition('recordStatus','=','O');
if($company->type == 'location'){
	$approvals_all->add_condition('company_location','=',$company->location->id);
}
$approvals_all->add_condition('training_school','=',$company->id);
$approvals_all->set_order_by('pozicija','DESC');
$approvals_all = $broker->get_all_data_condition($approvals_all);

for($i=0;$i<sizeof($approvals_all);$i++){
	if($approvals_all[$i]->user_card != ''){$approvals_all[$i]->user_card = $broker->get_data(new user_card($approvals_all[$i]->user_card));}
	if($approvals_all[$i]->purchase != ''){$approvals_all[$i]->purchase = $broker->get_data(new purchase($approvals_all[$i]->purchase));}
	$approvals_all[$i]->purchase->card_package = $broker->get_data(new card_package($approvals_all[$i]->purchase->card_package));

	$approvals_all[$i]->display_date = date('d.m.Y. H:i:s',strtotime($approvals_all[$i]->makerDate));
	$approvals_all[$i]->internal_code = '-';

	if($internal_codes['approved_pass']){
		$approvals_all[$i]->internal_code = $internal_codes['approved_pass'];
		if($approvals_all[$i]->internal_code == ''){
			$approvals_all[$i]->internal_code = '-';
		}
	}

	if(in_array($approvals_all[$i]->taken_passes, array(1,2,3,4,5,6,7,8,9,10))){
		$approvals_all[$i]->taken_passes_display = (int)$approvals_all[$i]->taken_passes;
	}else{
		$approvals_all[$i]->taken_passes_display = number_format($approvals_all[$i]->taken_passes,1,'.',',');
	}

	$approvals_all[$i]->taken_passes = $approvals_all[$i]->taken_passes >= 1 ? (int)$approvals_all[$i]->taken_passes : round($approvals_all[$i]->taken_passes,1);

	if($approvals_all[$i]->company_location > 0){
		$approvals_all[$i]->company_location = $broker->get_data(new ts_location($approvals_all[$i]->company_location));
	}

	$total_to_pay_to_partner += $approvals_all[$i]->pay_to_company;
}
if(sizeof($approvals_all) > 0){$any_transaction = true;}


//================ UPLATE ================
$payments_credit = new company_transactions();
$payments_credit->set_condition('checker','!=','');
$payments_credit->add_condition('recordStatus','=','O');
$payments_credit->add_condition('transaction_type','=','credit');
$payments_credit->add_condition('training_school','=',$company->id);
$payments_credit->set_order_by('transaction_date','DESC');
$payments_credit = $broker->get_all_data_condition($payments_credit);
if(sizeof($payments_credit) > 0){$any_transaction = true;}

for ($i=0; $i < sizeof($payments_credit); $i++) { 
	$payments_credit[$i]->transaction_value = number_format($payments_credit[$i]->transaction_value,2,',','.').' RSD';
	$payments_credit[$i]->transaction_date = date('d.m.Y.',strtotime($payments_credit[$i]->transaction_date));
}

//================ ISPLATE ================
$payments_debit = new company_transactions();
$payments_debit->set_condition('checker','!=','');
$payments_debit->add_condition('recordStatus','=','O');
$payments_debit->add_condition('transaction_type','=','debit');
$payments_debit->add_condition('training_school','=',$company->id);
$payments_debit->set_order_by('transaction_date','DESC');
$payments_debit = $broker->get_all_data_condition($payments_debit);
if(sizeof($payments_debit) > 0){$any_transaction = true;}

for ($i=0; $i < sizeof($payments_debit); $i++) { 
	$payments_debit[$i]->transaction_value = number_format($payments_debit[$i]->transaction_value,2,',','.').' RSD';
	$payments_debit[$i]->transaction_date = date('d.m.Y.',strtotime($payments_debit[$i]->transaction_date));
}


$SQL = "SELECT SUM(transaction_value) AS total FROM company_transactions WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id." AND transaction_type = 'debit'";
$total_payed = $broker->execute_sql_get_array($SQL);
$total_payed = $total_payed[0]['total'];

$SQL = "SELECT SUM(transaction_value) AS total FROM company_transactions WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id." AND transaction_type = 'credit'";
$total_sent_payment = $broker->execute_sql_get_array($SQL);
$total_sent_payment = $total_sent_payment[0]['total'];


$total_to_pay -= $total_payed;
$total_to_pay = number_format($total_to_pay,2,',','.');

$total_to_pay_to_partner -= $total_sent_payment;
$total_to_pay_to_partner = number_format($total_to_pay_to_partner,2,',','.');


//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Transakcije";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================
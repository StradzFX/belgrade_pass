<?php

if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

//========================== SEO PARAMETERS =======================================================
$title = "Belgrade Pass - Partneri - Početna";
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$month_t['01'] = 'Januar';
$month_t['02'] = 'Februar';
$month_t['03'] = 'Mart';
$month_t['04'] = 'April';
$month_t['05'] = 'Maj';
$month_t['06'] = 'Jun';
$month_t['07'] = 'Jul';
$month_t['08'] = 'Avgust';
$month_t['09'] = 'Septembar';
$month_t['10'] = 'Oktobar';
$month_t['11'] = 'Novembar';
$month_t['12'] = 'Decembar';

$company = $broker->get_session('company');

//============== MONEY ============
$statistics_list_money = array();

$SQL = "SELECT SUM(pay_to_company) AS total FROM accepted_passes WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id." AND MONTH(makerDate) = ".date('m');
$total_profit_current_month = $broker->execute_sql_get_array($SQL);
$total_profit_current_month = $total_profit_current_month[0]['total'];
$total_profit_current_month = number_format($total_profit_current_month,2,',','.');
$total_profit_current_month .= ' RSD';
$statistics_list_money[] = array(
	'title' => 'Bruto ukupan promet za prethodnu nedelju',
	'value' => $total_profit_current_month,
	'info' => 'Ukupna zarada na odobrenim prolazima evidentirano za tekući mesec.'
);

$SQL = "SELECT SUM(pay_to_company) AS total FROM accepted_passes WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id."";
$total_profit = $broker->execute_sql_get_array($SQL);
$total_profit = $total_profit[0]['total'];

$total_profit = number_format($total_profit,2,',','.');
$total_profit .= ' RSD';
$statistics_list_money[] = array(
	'title' => 'Neto ukupan promet za prethodnu nedelju',
	'value' => $total_profit,
	'info' => 'Ukupna zarada na odobrenim prolazima evidentirano od početka saradnje.'
);


$SQL = "SELECT SUM(pay_to_company) AS total FROM accepted_passes WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id."";
$we_need_to_pay = $broker->execute_sql_get_array($SQL);
$we_need_to_pay = $we_need_to_pay[0]['total'];

$SQL = "SELECT SUM(transaction_value) AS total FROM company_transactions WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id." AND transaction_type = 'credit'";
$total_sent_payment = $broker->execute_sql_get_array($SQL);
$total_sent_payment = $total_sent_payment[0]['total'];

$we_need_to_pay -= $total_sent_payment;

$we_need_to_pay = number_format($we_need_to_pay,2,',','.');
$we_need_to_pay .= ' RSD';
$statistics_list_money[] = array(
	'title' => 'Zaduženja prema partneru',
	'value' => $we_need_to_pay,
	'info' => 'Ukupno zaduženje prema Vama za sve neisplaćene odobrene prolaze.'
);


$SQL = "SELECT SUM(price) AS total FROM purchase WHERE recordStatus = 'O' AND checker != '' AND company_flag = ".$company->id."";
$company_needs_to_pay = $broker->execute_sql_get_array($SQL);
$company_needs_to_pay = $company_needs_to_pay[0]['total'];

$SQL = "SELECT SUM(transaction_value) AS total FROM company_transactions WHERE recordStatus = 'O' AND checker != '' AND training_school = ".$company->id." AND transaction_type = 'debit'";
$total_payed = $broker->execute_sql_get_array($SQL);
$total_payed = $total_payed[0]['total'];

$company_needs_to_pay -= $total_payed;


$company_needs_to_pay = number_format($company_needs_to_pay,2,',','.');
$company_needs_to_pay .= ' RSD';
$statistics_list_money[] = array(
	'title' => 'Zaduženja prema BelgradePassu',
	'value' => $company_needs_to_pay,
	'info' => 'Ukupno zaduženje prema Belgrade Pass-u za sve evidentirane a neuplaćene pakete.'
);




//============== NUMBERS ============
$statistics_list_numbers = array();
$SQL = "SELECT COUNT(*) AS total FROM user_card WHERE recordStatus = 'O' AND checker != '' AND partner_id = ".$company->id."";
$created_cards = $broker->execute_sql_get_array($SQL);
$created_cards = $created_cards[0]['total'];
$statistics_list_numbers[] = array(
	'title' => 'Izdatih kartica',
	'value' => $created_cards,
	'info' => null
);


$SQL = "SELECT COUNT(*) AS total FROM purchase WHERE recordStatus = 'O' AND checker != '' AND company_flag = ".$company->id."";
$created_purchases = $broker->execute_sql_get_array($SQL);
$created_purchases = $created_purchases[0]['total'];
$statistics_list_numbers[] = array(
	'title' => 'Uplaćenih paketa',
	'value' => $created_purchases,
	'info' => null
);


//============== NUMBERS BIRTHDAYS ============
$statistics_list_numbers_birthdays = array();
$SQL = "SELECT COUNT(*) AS total FROM user_card WHERE recordStatus = 'O' AND checker != '' AND partner_id = ".$company->id."";
$created_cards = $broker->execute_sql_get_array($SQL);
$created_cards = $created_cards[0]['total'];
$created_cards = 0;
$statistics_list_numbers_birthdays[] = array(
	'title' => 'Rezervisanih rođendana',
	'value' => $created_cards,
	'info' => null
);


$SQL = "SELECT COUNT(*) AS total FROM purchase WHERE recordStatus = 'O' AND checker != '' AND company_flag = ".$company->id."";
$created_purchases = $broker->execute_sql_get_array($SQL);
$created_purchases = $created_purchases[0]['total'];
$created_purchases = 0;
$statistics_list_numbers_birthdays[] = array(
	'title' => 'Rezervacija na čekanju',
	'value' => $created_purchases,
	'info' => null
);

<?php

$company_transactions_all = new company_transactions();
$company_transactions_all->set_condition('checker','!=','');
$company_transactions_all->add_condition('recordStatus','=','O');
$company_transactions_all->set_order_by('transaction_date','DESC');
$list = $broker->get_all_data_condition($company_transactions_all);

for($i=0;$i<sizeof($list);$i++){
	if($list[$i]->training_school != ''){$list[$i]->company = $broker->get_data(new training_school($list[$i]->training_school));}

	$list[$i]->transaction_value = $list[$i]->transaction_type == 'credit' ? $list[$i]->transaction_value*-1 : $list[$i]->transaction_value;
	$list[$i]->transaction_value = number_format($list[$i]->transaction_value,2,',','.');
	$list[$i]->transaction_type = $list[$i]->transaction_type == 'credit' ? 'Payment to company' : 'Payment from company';
}

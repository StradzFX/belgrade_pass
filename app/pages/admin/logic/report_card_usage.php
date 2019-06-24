<?php

$preselected_company = null;
if($_GET['company']){
	$preselected_company = $_GET['company'];
}

$company_list = new training_school();
$company_list->set_condition('checker','!=','');
$company_list->add_condition('recordStatus','=','O');
$company_list->set_order_by('pozicija','DESC');
$company_list = $broker->get_all_data_condition($company_list);


$filter_date_from = date('Y-m-d',strtotime('-3 months'));
$filter_date_to = date('Y-m-d');
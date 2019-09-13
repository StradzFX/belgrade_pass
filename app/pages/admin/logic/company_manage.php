<?php
global $broker;
$url_params[0] = $url_params[0] == '' ? 0 : $url_params[0];
$item = SchoolModule::get_admin_data($url_params[0]);
$system_message = isset($_GET['message']) ? 'Company saved successfully.' : '';

$category_id = $item->category_display->id > 0 ? $item->category_display->id : null;

$category_list = CategoryModule::get_admin_list();

$coach_list = CoachModule::get_admin_list($category_id);

$working_days = array(
	array('day_of_week'=>1,'name'=>'Monday','short' => 'Mon'),
	array('day_of_week'=>2,'name'=>'Tuesday','short' => 'Tue'),
	array('day_of_week'=>3,'name'=>'Wednesday','short' => 'Wed'),
	array('day_of_week'=>4,'name'=>'Thursday','short' => 'Thu'),
	array('day_of_week'=>5,'name'=>'Friday','short' => 'Fri'),
	array('day_of_week'=>6,'name'=>'Saturday','short' => 'Sat'),
	array('day_of_week'=>7,'name'=>'Sunday','short' => 'Sun')
);

$options = array();

$options[] = array(
	'tag' => 'tag-bike',
	'name' => 'Mesto za bicikl',
);
$options[] = array(
	'tag' => 'tag-car-park',
	'name' => 'Mesto za parkiranje',
);
$options[] = array(
	'tag' => 'tag-card',
	'name' => 'Plaćanje karticom',
);
$options[] = array(
	'tag' => 'tag-delivery',
	'name' => 'Dostava',
);
$options[] = array(
	'tag' => 'tag-family',
	'name' => 'Za porodicu',
);
$options[] = array(
	'tag' => 'tag-pets',
	'name' => 'Dozvoljeni kućni ljubimci',
);
$options[] = array(
	'tag' => 'tag-price',
	'name' => 'Stalni popusti',
);
$options[] = array(
	'tag' => 'tag-reservation',
	'name' => 'Rezervacije',
);
$options[] = array(
	'tag' => 'tag-smoking',
	'name' => 'Dozvoljeno pušenje',
);
$options[] = array(
	'tag' => 'tag-wheel-chair',
	'name' => 'Prilagođeno',
);
$options[] = array(
	'tag' => 'tag-wifi',
	'name' => 'Besplatan Internet',
);

$company_options_all = new company_options();
$company_options_all->set_condition('checker','!=','');
$company_options_all->add_condition('recordStatus','=','O');
$company_options_all->add_condition('company','=',$item->id);
$company_options_all->set_order_by('pozicija','DESC');
$company_options_all = $broker->get_all_data_condition($company_options_all);


$company_options_array = array();
for($i=0;$i<sizeof($company_options_all);$i++){
	$company_options_array[] = $company_options_all[$i]->tag;


/*
VEROVATNO SE BRISE
$list_company_transactions = DeleteModule::delete_all_company_transactions_module('company_transactions');

$list_accepted_passes = DeleteModule::delete_all_company_transactions_module('accepted_passes');
*/
}

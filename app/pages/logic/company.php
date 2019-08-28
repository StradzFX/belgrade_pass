<?php

$id = $url_params[0] == 'location' ? $url_params[1] : $url_params[0];
$display = $url_params[0] == 'location' ? 'location' : 'company';

$company_location = CompanyLocationModule::get($id);
$item = $company_location->company;

SchoolModule::record_view($item->id);

$days = array();
$days[1] = 'Monday';
$days[2] = 'Tuesday';
$days[3] = 'Wednesday';
$days[4] = 'Thursday';
$days[5] = 'Friday';
$days[6] = 'Saturday';
$days[7] = 'Sunday';

//========================== SEO PARAMETERS =======================================================
$title = $school->name.' - Belgrade Pass.rs';
$keywords = "";
$description = "";
$og_image = "";
$og_url = $base_url;
$seo->set_basic_tags($title,$keywords,$description);
$seo->set_open_graph_protocol_parameters($title,$og_url,$description,$og_image,"website");
//=================================================================================================

$body_classes = 'job_listing-template-default single single-job_listing postid-11623 wp-custom-logo tribe-js group-blog listable';

if($item){
	$sport_category_all = new sport_category();
	$sport_category_all->set_condition('checker','!=','');
	$sport_category_all->add_condition('recordStatus','=','O');
	$sport_category_all->add_condition('id','IN',"(SELECT DISTINCT category FROM company_category WHERE company = ".$item->id." AND recordStatus = 'O')");
	$sport_category_all->set_order_by('pozicija','DESC');
	$item->categories =  $broker->get_all_data_condition($sport_category_all);


	$options = array();

	$options['tag-bike'] = array(
		'tag' => 'tag-bike',
		'name' => 'Mesto za bicikl',
	);
	$options['tag-car-park'] = array(
		'tag' => 'tag-car-park',
		'name' => 'Mesto za parkiranje',
	);
	$options['tag-card'] = array(
		'tag' => 'tag-card',
		'name' => 'Plaćanje karticom',
	);
	$options['tag-delivery'] = array(
		'tag' => 'tag-delivery',
		'name' => 'Dostava',
	);
	$options['tag-family'] = array(
		'tag' => 'tag-family',
		'name' => 'Za porodicu',
	);
	$options['tag-pets'] = array(
		'tag' => 'tag-pets',
		'name' => 'Dozvoljeni kućni ljubimci',
	);
	$options['tag-price'] = array(
		'tag' => 'tag-price',
		'name' => 'Stalni popusti',
	);
	$options['tag-reservation'] = array(
		'tag' => 'tag-reservation',
		'name' => 'Rezervacije',
	);
	$options['tag-smoking'] = array(
		'tag' => 'tag-smoking',
		'name' => 'Dozvoljeno pušenje',
	);
	$options['tag-wheel-chair'] = array(
		'tag' => 'tag-wheel-chair',
		'name' => 'Prilagođeno',
	);
	$options['tag-wifi'] = array(
		'tag' => 'tag-wifi',
		'name' => 'Besplatan Internet',
	);

	$company_options_all = new company_options();
	$company_options_all->set_condition('checker','!=','');
	$company_options_all->add_condition('recordStatus','=','O');
	$company_options_all->add_condition('company','=',$item->id);
	$company_options_all->set_order_by('pozicija','DESC');
	$company_options_all = $broker->get_all_data_condition($company_options_all);



	$previuos_company = new training_school();
	$previuos_company->set_condition('checker','!=','');
	$previuos_company->add_condition('recordStatus','=','O');
	$previuos_company->add_condition('id','<',$item->id);
	$previuos_company->set_order_by('pozicija','DESC');
	$previuos_company->set_limit(1);
	$previuos_company = $broker->get_all_data_condition($previuos_company);
	if(sizeof($previuos_company) == 0){
		$previuos_company = new training_school();
		$previuos_company->set_condition('checker','!=','');
		$previuos_company->add_condition('recordStatus','=','O');
		$previuos_company->add_condition('id','>',$item->id);
		$previuos_company->set_limit(1);
		$previuos_company->set_order_by('pozicija','DESC');
		$previuos_company = $broker->get_all_data_condition_limited($previuos_company);
	}
	$previuos_company = $previuos_company[0];

	$next_company = new training_school();
	$next_company->set_condition('checker','!=','');
	$next_company->add_condition('recordStatus','=','O');
	$next_company->add_condition('id','>',$item->id);
	$next_company->set_order_by('pozicija','ASC');
	$next_company->set_limit(1);
	$next_company = $broker->get_all_data_condition($next_company);
	if(sizeof($next_company) == 0){
		$next_company = new training_school();
		$next_company->set_condition('checker','!=','');
		$next_company->add_condition('recordStatus','=','O');
		$next_company->add_condition('id','<',$item->id);
		$next_company->set_limit(1);
		$next_company->set_order_by('pozicija','ASC');
		$next_company = $broker->get_all_data_condition_limited($next_company);
	}
	$next_company = $next_company[0];
}


$company_location->working_hours = new working_times();
$company_location->working_hours->set_condition('checker','!=','');
$company_location->working_hours->add_condition('recordStatus','=','O');
$company_location->working_hours->add_condition('ts_location','=',$company_location->id);
$company_location->working_hours->set_order_by('pozicija','ASC');
$company_location->working_hours = $broker->get_all_data_condition($company_location->working_hours);

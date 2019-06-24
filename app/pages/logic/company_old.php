<?php

$school = SchoolModule::get($url_params[0]);

SchoolModule::record_view($school->id);

$company_birthday_data_all = new company_birthday_data();
$company_birthday_data_all->set_condition('checker','!=','');
$company_birthday_data_all->add_condition('recordStatus','=','O');
$company_birthday_data_all->add_condition('training_school','=',$school->id);
$company_birthday_data_all->set_order_by('pozicija','DESC');
$company_birthday_data_all = $broker->get_all_data_condition($company_birthday_data_all);

for($i=0;$i<sizeof($company_birthday_data_all);$i++){
if($company_birthday_data_all[$i]->training_school != ''){$company_birthday_data_all[$i]->training_school = $broker->get_data(new training_school($company_birthday_data_all[$i]->training_school));}
if($company_birthday_data_all[$i]->ts_location != ''){$company_birthday_data_all[$i]->ts_location = $broker->get_data(new ts_location($company_birthday_data_all[$i]->ts_location));}
}


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

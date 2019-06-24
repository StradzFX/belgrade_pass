<?php
global $broker;
$options_data = $post_data['options_data'];

$success = true;
$message = 'Post was made';

$SQL = "DELETE FROM company_options WHERE company = ".$options_data['company'];
$broker->execute_query($SQL);

if($options_data['options']){
	for ($i=0; $i < sizeof($options_data['options']); $i++) { 
		$company_options = new company_options();
	    $company_options->company = $options_data['company'];
	    $company_options->tag = $options_data['options'][$i];
	    $company_options->maker = 'system';
	    $company_options->makerDate = date('c');
	    $company_options->checker = 'system';
	    $company_options->checkerDate = date('c');
	    $company_options->jezik = 'rs';
	    $company_options->recordStatus = 'O';
	    
	    $company_options = $broker->insert($company_options);
	}
}


echo json_encode(array("success"=>$success,"message"=>$message));
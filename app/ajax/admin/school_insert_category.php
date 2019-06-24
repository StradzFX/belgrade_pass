<?php
global $broker;
$success = false;
$message = 'Category not inserted.';

$data = $post_data['save_data'];

$error_message = null;
if($data['company'] == ''){$error_message = 'Please insert city.';}
if($data['category'] == ''){$error_message = 'Please select category.';}

if(!$error_message){
	$company_category = new company_category();
    $company_category->company = $data['company'];
    $company_category->category = $data['category'];
    $company_category->maker = 'system';
    $company_category->makerDate = date('c');
    $company_category->checker = 'system';
    $company_category->checkerDate = date('c');
    $company_category->jezik = 'rs';
    $company_category->recordStatus = 'O';
    
    $company_category = $broker->insert($company_category);

	$success = true;
	$message = 'Category saved.';
}else{
	$message = $error_message;
}

echo json_encode(array("success"=>$success,"message"=>$message));
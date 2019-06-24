<?php
global $broker;
$success = false;
$message = 'Category not removed.';

$data = $post_data['data'];


$company_category = new company_category($data['id']);
$company_category->recordStatus = 'C';
$broker->update($company_category);

$success = true;
$message = 'Category removed.';


echo json_encode(array("success"=>$success,"message"=>$message));
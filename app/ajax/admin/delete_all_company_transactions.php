<?php
$data = $post_data['data'];
$success = true;
global $broker;

$message = 'Uspešno ste obrisali sve kompanijske transakcije';
DeleteModule::delete_all_company_transactions_module($data['id']);


echo json_encode(array("success"=>$success , "message"=>$message ));
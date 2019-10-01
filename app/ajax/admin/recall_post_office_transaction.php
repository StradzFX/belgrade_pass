<?php
global $broker;
$data=$post_data['data'];
$success = true;
$message = 'Transakcija uspesno opozvana';


DeleteModule::recall_company_transaction_module($data['id']);

echo json_encode(array("success"=>$success, "message"=>$message));

?>
    
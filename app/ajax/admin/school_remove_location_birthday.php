<?php
global $broker;
$success = false;
$message = 'Location not removed.';

$data = $post_data['data'];


$SQL = "UPDATE company_birthday_data SET recordStatus = 'C' WHERE id = ".$data['id'];
$broker->execute_query($SQL);

$success = true;
$message = 'Location removed.';

echo json_encode(array("success"=>$success,"message"=>$message));
<?php

$success = true;
$message = 'Days not inserted.';

$data = $post_data['data'];

$school_id = $data['id'];

$item = SchoolModule::promote($school_id);

echo json_encode(array("success"=>$success,"message"=>$message));
<?php

global $broker;

$success = false;
$message = 'Image not inserted.';

$data = $post_data['save_data'];

$update_field = $data['type'];
$is_checked = $data['is_checked'];
$id = $data['id'];

$SQL = "UPDATE training_school SET $update_field = $is_checked WHERE id = $id";
$broker->execute_query($SQL);

$success = true;
$message = 'You have updated business option.';

echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));

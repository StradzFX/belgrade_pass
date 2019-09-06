<?php

global $broker;
$data = $post_data['data'];
$success = true;
$id = $data['id'];

$ts = new training_school($id);
$ts = $broker->get_data($ts);
/*
$ts->name = addslashes($ts->name);
$ts->into_text = addslashes($ts->into_text);
$ts->general_text = addslashes($ts->general_text);
$ts->discount_description = addslashes($ts->discount_description);
$ts->checker = '';
$broker->update($ts);*/


if($ts->checker == ''){
	$SQL = "UPDATE training_school SET checker = 'admin'
	WHERE id = ".$ts->id;
	$broker->execute_query($SQL);
}else{
	$SQL = "UPDATE training_school SET checker = ''
	WHERE id = ".$ts->id;
	$broker->execute_query($SQL);
}


echo json_encode(array("success"=>$success, "message"=>$message));



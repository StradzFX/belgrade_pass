<?php

unset($_SESSION['user']);

$success = true;
$message = 'You are logged out';

echo json_encode(array('success'=>$success,'message'=>$message));
die();
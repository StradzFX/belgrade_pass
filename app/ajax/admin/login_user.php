<?php

$login_data = $post_data['login_data'];

list($success,$message) = KryptonAdminController::login_user($login_data);

echo json_encode(array("success"=>$success,"message"=>$message));
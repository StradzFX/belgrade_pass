<?php

list($success,$message) = KryptonAdminController::logout_user();

echo json_encode(array("success"=>$success,"message"=>$message));
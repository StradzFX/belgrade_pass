<?php

$url_params[0] = $url_params[0] == '' ? 0 : $url_params[0];
$item = CoachModule::get_admin_data($url_params[0]);
$system_message = isset($_GET['message']) ? 'School saved successfully.' : '';

$category_list = CategoryModule::get_admin_list();
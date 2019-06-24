<?php

$url_params[0] = $url_params[0] == '' ? 0 : $url_params[0];
$item = CategoryModule::get_admin_data($url_params[0]);
$system_message = isset($_GET['message']) ? 'Category saved successfully.' : '';


$partner_list = SchoolModule::get_admin_list();
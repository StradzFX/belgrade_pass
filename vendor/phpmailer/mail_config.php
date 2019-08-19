<?php
$send_gmail = true;
if(!$send_gmail){
	$host_email = 'info@kidcard.rs';
	$host_password = 'webbrod2015+';
	$sender_name = 'KidCard';
	$sender_email = 'info@kidcard.rs';
	$replier_name = 'KidCard';
	$replier_email = 'info@kidcard.rs';
	$host = 'smtp.gmail.com';
	$port = 25;
	$priority = 3;
	$char_set = 'UTF-8';
}else{
	$host_email = 'no-reply@belgradepass.com';
	$host_password = 'webbrod2015+';
	$sender_name = 'BelgradePass';
	$sender_email = 'no-reply@belgradepass.com';
	$replier_name = 'BelgradePass';
	$replier_email = 'no-reply@belgradepass.com';
	$host = 'mailcluster.loopia.se';
	$port = 587;
	$priority = 3;
	$char_set = 'UTF-8';
}


?> 
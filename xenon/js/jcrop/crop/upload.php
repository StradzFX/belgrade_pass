<?php

session_start();
require "../scripts/fileuploader/fileuploader.php";
require "gd_image.php";
$_SESSION['data'] = $_GET['data'];
$data_array = explode("|",$_SESSION['data']);
define('UPLOAD_DIR','../../../'.$data_array[1]);
date_default_timezone_set('UTC');
$allowedExtensions = array('jpeg','jpg','gif','png');
$sizeLimit = 10 * 1024 * 1024; // max file size in bytes
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(UPLOAD_DIR, false, md5(uniqid())); 
$gd = new gd_image();
$filePath = UPLOAD_DIR . $result['filename'];
$copyName = $gd->createName($result['filename'], 'FULLSIZE_');
$gd->copy($filePath, UPLOAD_DIR.$copyName);
$oldSize = $gd->getProperties($filePath);

$old_width = $oldSize['w'];
if(intval($old_width) > 900) $old_width = 900;
$newSize = $gd->getAspectRatio($oldSize['w'], $oldSize['h'], intval($old_width), 0);

$gd->resize($filePath, $newSize['w'], $newSize['h']);
echo json_encode($result);
exit();
?>

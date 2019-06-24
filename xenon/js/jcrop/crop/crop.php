<?php
session_start();
require "gd_image.php";
$data = $_SESSION['data'];
$data_array = explode("|",$data);
define('UPLOAD_DIR','../../../'.$data_array[1]);
ini_set('display_errors',1);
ini_set('log_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('UTC');
$gd = new gd_image();
$i = 1;
foreach($_POST['imgcrop'] as $k => $v) 
{
	$filePath = UPLOAD_DIR . $v['filename'];
	$fullSizeFilePath = UPLOAD_DIR . $gd->createName($v['filename'], 'FULLSIZE_');
	$scaledSize = $gd->getProperties($filePath);
	$oldsize = $gd->getProperties($fullSizeFilePath);
	$old_width = $oldsize['w'];
	if(intval($old_width) > 900) $old_width = 900;
	
	$percentChange = $scaledSize['w'] / $old_width; 
	$newCoords = array
	(
		'x' => $v['x'] * $percentChange,
		'y' => $v['y'] * $percentChange,
		'w' => $v['w'] * $percentChange,
		'h' => $v['h'] * $percentChange
	);
	$gd->crop($filePath, $newCoords['x'], $newCoords['y'], $newCoords['w'], $newCoords['h']);
	$ar = $gd->getAspectRatio($newCoords['w'], $newCoords['h'], intval($data_array[0]), 0);
	$gd->resize($filePath, $ar['w'], $ar['h']);
	if($i==1)	break;
}
?>


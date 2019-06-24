<?php 
session_start();
include_once '../config.php';
include_once '../../classes/database/db_broker.php';
include_once '../../classes/domain/'.$_SESSION['export_dc'].'.class.php';
$broker = new db_broker();
$dc_object = unserialize($_SESSION['export_csv']);
$all_dc_objects = $broker->get_all_data_condition($dc_object);

$header = array();
foreach(array_slice(get_object_vars($all_dc_objects[0]), 0, -13) as $key => $value)
	$header = array_merge($header,(array)$key);
$row[] = array_merge($header,array("status"));

for($i=1;$i<=sizeof($all_dc_objects);$i++)
{
	$row[$i] = array_slice(get_object_vars($all_dc_objects[$i-1]), 0, -13);
	foreach(get_object_vars($all_dc_objects[$i-1]) as $key => $value)
		if($key == 'checker')
			if($value != '')	$status = array("online");
			else				$status = array("offline");
	$row[$i] = array_merge($row[$i], $status);
}

$server_file = 'export.csv';
$download_file = $dc_object->get_domain_name() . '.csv';

$fp = fopen($server_file, 'w');
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
foreach($row as $fields) 
	fputcsv($fp, $fields);
fclose($fp);

header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=".$download_file); 
header("Content-Description: Download");	
readfile($server_file);

unlink($server_file);
?>

<?php
$broker = new db_broker();

if($_GET['type'] == "r")
{
	if($_GET['page'])
	{
		
		include_once "php/reports/".$_GET['page'].".php";
	}
	else include_once "php/reports/dataaudittrail.php";
}
else include_once "php/dc_dashboard.php";
?>
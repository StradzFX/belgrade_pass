<?php
if($_GET['type'] == "r")
{
	if($_GET['page'])
	{
		switch($_GET['page'])
		{
			//ovde nastaviti niz - menjati samo REPORT sa nazivom
			//case "REPORT":	include_once "php/reports/REPORT.php";
			//break; 
			
			
			default:	include_once "php/reports/dataaudittrail.php";
		}
	}
	else include_once "php/reports/dataaudittrail.php";
}
else include_once "php/dc_dashboard.php";
?>
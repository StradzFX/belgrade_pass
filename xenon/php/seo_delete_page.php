<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/seo_configuration.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$seo_configuration = new seo_configuration($_GET['id']);
$seo_configuration = $broker->get_data($seo_configuration);
$broker->delete($seo_configuration);
header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>

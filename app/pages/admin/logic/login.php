<?php

if($_SESSION['admin']){
	header('Location: home/');
}

if($_GET['login']){
	$_SESSION['admin'] = $_GET['login'];
}
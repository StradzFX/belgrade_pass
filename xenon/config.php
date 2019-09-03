<?php
define(FTPSERVER, "");
define(FTPUSERNAME, "");
define(FTPPASSWORD, "");
define(FTPROOT, "websites/kidpass/");
define(DBNAME, "kidpass"); 
define(DBHOST, "localhost"); 
define(DBUSER, "root"); 
define(DBPASS, ""); 
define(MAGICQUOTES, get_magic_quotes_gpc());
define(TIMEZONE, "Europe/Belgrade");

define(SITENAME, "Kidpass");
define(ADMINLOGGEDIN, "kidpass_admin_loggedin");					//KOJI JE USER ULOGOVAN
define(ADMINUSER, "kidpass_user");								//SELEKTOVAN OBJEKAT TIPA ADMIN KORISNIK
define(ADMINMAKER, "kidpass_maker");								//DA LI USER IMA PRIVILEGIJE DA BUDE MAKER
define(ADMINCHECKER, "kidpass_checker");							//DA LI USER IMA PRIVILEGIJE DA BUDE CHECKER
define(ADMINAUTHDC, "kidpass_auth_dc");							//LISTA PRIVILEGIJA ZA DOMENSKE KLASE
define(ADMINAUTHMODULES, "kidpass_auth_modules"); 				//LISTA PRIVILEGIJA ZA MODULE
define(ADMINPANELLANG, "kidpass_admin_panel_lang");				//LISTA PRIVILEGIJA ZA DOMENSKE KLASE
define(FRONTENDLANG, "kidpass_front_end_lang"); 					//DEFAULTNI JEZIK ZA PREDNJU STRANU
define(XMLSERVICENEWS, "kidpass_xml_service_news");				//XML SERVICE NEWS
define(XMLSERVICEPROMOTIONS, "kidpass_xml_service_promotions");	//XML SERVICE PROMOTIONS

$_global_config = array();
$_global_config['DBNAME'] = "kidpass";
$_global_config['DBHOST'] = "localhost";
$_global_config['DBUSER'] = "root";
$_global_config['DBPASS'] = "";

?>
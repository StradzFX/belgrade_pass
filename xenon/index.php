<?php
ob_start();
session_start();



if($_POST["install_parameters"]){
	//var_dump($_POST);
	
	$host = $_POST["xenon_start_localhost"];
	$username = $_POST["xenon_start_username"];
	$password = $_POST["xenon_start_password"];
	$database = $_POST["xenon_start_database"];
  $install_instructions = $_POST["install_instructions"];

  if($install_instructions == 'save_data'){
    $mysqli = @new mysqli($host, $username, $password);

    if (!$mysqli->connect_error) {
      $configuration_file = file_get_contents("config.php");

      //=============================== HOST ========================================================
      $configuration_file_host = explode('define(DBHOST, "',$configuration_file);
      $configuration_file_host = $configuration_file_host[1];
      $configuration_file_host = explode('"',$configuration_file_host);
      $configuration_file_host = $configuration_file_host[0];
      
      $configuration_file = str_replace($configuration_file_host,$host,$configuration_file);
      
      //=============================== USERNAME ========================================================
      $configuration_file_username = explode('define(DBUSER, "',$configuration_file);
      $configuration_file_username = $configuration_file_username[1];
      $configuration_file_username = explode('"',$configuration_file_username);
      $configuration_file_username = $configuration_file_username[0];
      
      $configuration_file = str_replace($configuration_file_username,$username,$configuration_file);
      
      
      //=============================== PASSWORD ========================================================
      $configuration_file_password = explode('define(DBPASS, "',$configuration_file);
      $configuration_file_password = $configuration_file_password[1];
      $configuration_file_password = explode('"',$configuration_file_password);
      $configuration_file_password = $configuration_file_password[0];
      
      $configuration_file = str_replace($configuration_file_password,$password,$configuration_file);
      
      file_put_contents("config.php",$configuration_file);
    }
  }

  if($install_instructions == 'create_database'){
    $mysqli = @new mysqli($host, 'weblab', 'webbrod2015+');
    $sql = "CREATE DATABASE ".$database;
    $mysqli->query($sql);


    //$priv_db = str_replace('_','\_',$database);
    $sql = "GRANT ALL ON $database.* TO weblab_regular@localhost";
    $mysqli->query($sql);


    $mysqli = @new mysqli($host, $username, $password,$database);
    $filename = "sql/database.sql";
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line)
    {
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query

        $mysqli->query($templine);
        // Reset temp variable to empty
        $templine = '';
    }
    }


    $configuration_file = file_get_contents("config.php");
    //=============================== DATABASE ========================================================
    $configuration_file_database = explode('define(DBNAME, "',$configuration_file);
    $configuration_file_database = $configuration_file_database[1];
    $configuration_file_database = explode('"',$configuration_file_database);
    $configuration_file_database = $configuration_file_database[0];
    $configuration_file = str_replace($configuration_file_database,$database,$configuration_file);
    file_put_contents("config.php",$configuration_file);
  }
	
	
}

require_once "config.php";

define(COMPANYNAME, "");
define(COMPANYADDRESS, "");     
define(COMPANYCITY, "");        
define(COMPANYCOUNTRY, "");     
define(COMPANYPOSTALCODE, "");  
define(COMPANYPHONE, "");       
define(COMPANYMOBILE, "");      
define(COMPANYFAX, "");         
define(COMPANYEMAIL, ""); 
define(COMPANYSITE, ""); 

require_once "../classes/database/db_broker.php";
require_once "../classes/domain/xenon_user.class.php";
require_once "../classes/domain/xenon_languages.class.php";
require_once "../classes/domain/xenon_privilege.class.php";
require_once "../classes/domain/xenon_modules.class.php";
date_default_timezone_set(TIMEZONE);

$connection_error = false;
$general_connection_error = false;
$database_connection_error  = false;


if($_GET['mysql_dump']){
  $exec_command = 'd:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump -ustradz -pkengur -hlocalhost '.DBNAME.' --tables > sql/database.sql';
  shell_exec($exec_command);
  echo 'MySQL file created';
  die();
}



$mysqli = @new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
if($mysqli->connect_error) {
  $database_connection_error = true;
  $connection_error = true;
  $install_instructions = 'create_database';
  $install_text = "Install database";
}

$mysqli = @new mysqli(DBHOST, DBUSER, DBPASS);
if($mysqli->connect_error) {
  $general_connection_error = true;
  $connection_error = true;
  $install_instructions = 'save_data';
  $install_text = "Save data";
}

if ($connection_error) {
  

	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITENAME; ?> - Admin Panel</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
</head>
<body>

	<div style="width:285px;margin:150px auto;">
    	<div style="width:285px;text-align:center;margin:0px 0px 20px 0px;font-size:14px;color:#006699">Install database parameters</div>
        
        <div style="width:230px;margin:0px auto;"><img src="images/xenon-login.png" width="230" /></div>
        <div>
        	<form action="" method="post" style="font-size:14px;">
            	<table>
                
                	<tr>
                    	<td>Localhost:</td>
                      <td><input type="text" name="xenon_start_localhost" value="<?php echo DBHOST; ?>" /></td>
                      <td><img src="images/checked.png" /></td>
                    </tr>
                    
                    <tr>
                    	<td>Username:</td>
                        <td><input type="text" name="xenon_start_username" value="weblab_regular" /></td>
                        <?php if(!$general_connection_error){ ?>
                        <td><img src="images/checked.png" /></td>
                        <?php }else{ ?>
                        <td><img src="images/not_checked.png" /></td>
                        <?php } ?>
                    </tr>
                    
                    <tr>
                    	<td>Password:</td>
                      <td><input type="text" name="xenon_start_password" value="lmn84opq54" /></td>
                      <?php if(!$general_connection_error){ ?>
                        <td><img src="images/checked.png" /></td>
                        <?php }else{ ?>
                        <td><img src="images/not_checked.png" /></td>
                        <?php } ?>
                    </tr>
                    <?php if(!$general_connection_error){ ?>
                    <tr>
                      <td>DB name:</td>
                      <td><input type="text" name="xenon_start_database" value="weblab_<?php echo DBNAME; ?>" /></td>
                      <td><img src="images/not_checked.png" /></td>
                    </tr>
                    <?php } ?>

                    <input type="hidden" name="install_instructions" value="<?php echo $install_instructions; ?>" />
                    
                    
                    <tr>
                    	<td></td>
                        <td><button type="submit" name="install_parameters" value="submit"><?php echo $install_text; ?></button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</body>
</html>
    
 <?php
}else{
	
	$broker = new db_broker();
	$default_lang = new xenon_languages();
	$default_lang->set_condition("defaultlang","=","1");
	$default_lang = $broker->get_data($default_lang);

  include_once 'classes/xenon_functions.class.php';
  $xenon_functions = new xenon_functions($_GET["page"]);

  $class_path = "../classes/domain/";
  $spisak_fajlova = scandir($class_path);
  array_shift($spisak_fajlova);
  array_shift($spisak_fajlova);
  for($i=0;$i<sizeof($spisak_fajlova);$i++){
    if($spisak_fajlova[$i] != "base_domain_object.php"){
      require_once $class_path.$spisak_fajlova[$i];
    }
  }
  
	
	if($_GET["lang"])	$_SESSION[ADMINPANELLANG] = $_GET["lang"];
	else				$_SESSION[ADMINPANELLANG] = $default_lang->short;
	
	$_SESSION[FRONTENDLANG] = $_SESSION[ADMINPANELLANG];
	
	include_once "lang/lang.".$_SESSION[ADMINPANELLANG].".php";
	
	$action_array = array("all","new","edit","preview","pdf"); 
	$type_array = array("dc","m","s","c","r");
	
	if(!in_array($_GET['action'],$action_array) && $_GET['action']!=NULL)	header("Location: index.php");
	if(!in_array($_GET['type'],$type_array) && $_GET['type']!=NULL)			header("Location: index.php");
	
	$all_modules = $broker->get_all_data(new xenon_modules());
		
	$info_message = '';
	$error_message = '';
	$success_message = '';
	$warning_message = '';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITENAME; ?> - Admin Panel</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript">
	$(document).ready(function () {
		$("#successful_message").fadeOut(6000);
		$("#warning_message").fadeOut(6000);
		$("#info_message").fadeOut(6000);
		$("#error_message").fadeOut(6000);
	});
</script>
</head>
<body>
<?php 
if($_COOKIE[DBNAME . '_admin_cookie'] == NULL)		include_once "auth.php";
else
{ 
	if($_SESSION[ADMINLOGGEDIN] == NULL)
	{
		$user = new xenon_user();
		$user->set_condition('username','=',$_COOKIE[DBNAME . '_admin_cookie']);
		$user = $broker->get_data($user);
		
		$privilege = $broker->get_data(new xenon_privilege($user->privilege));
		$_SESSION[ADMINLOGGEDIN] 	= $user->username;
		$_SESSION[ADMINUSER] 		= serialize($user);
		$_SESSION[ADMINAUTHDC] 		= explode(",",$privilege->dc_auth);
		$_SESSION[ADMINAUTHMODULES] = explode(",",$privilege->module_auth);
		$_SESSION[ADMINMAKER] 		= $privilege->maker;
		$_SESSION[ADMINCHECKER] 	= $privilege->checker;
		setcookie("admin_cookie", $user->username, time()+3600*24);
	}
	$user = unserialize($_SESSION[ADMINUSER]);
?>
<div class="wrapper">
	<div id="header">
    	<div id="content">
        	<div id="logo">
            	<a href="index.php"><img src="images/logo.png" alt="<?php echo COMPANYNAME; ?>" title="<?php echo COMPANYNAME; ?>" height="50" width="200" border="0"/></a>
            </div><!--logo-->
            <img src="images/xenon_logo.png" alt="Xenon" class="logo" />
            <div id="menu">
            	<p><?php echo $ap_lang["Welcome"]; ?> <strong><?php echo $user->username; ?></strong>!</p>
                <ul>
                    <li><a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG];?>&type=dc"><img src="images/menu/dashboard.png" alt="<?php echo $ap_lang["Dashboard"]; ?>" title="<?php echo $ap_lang["Dashboard"]; ?>" border="0" /> <?php echo $ap_lang["Dashboard"]; ?></a></li>
                    <?php if(sizeof($all_modules) > 0){ ?>
                    <li><a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG];?>&type=m"><img src="images/menu/modules.png" alt="<?php echo $ap_lang["Modules"]; ?>" title="<?php echo $ap_lang["Modules"]; ?>" border="0" /> <?php echo $ap_lang["Modules"]; ?></a></li>
                    <?php } ?>
					
                    <li><a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG];?>&type=r"><img src="images/menu/reports.png" alt="<?php echo $ap_lang["Reports"]; ?>" title="<?php echo $ap_lang["Reports"]; ?>" border="0" /> <?php echo $ap_lang["Reports"]; ?></a></li>
                    <?php if($user->username == "admin" || $user->username == "xenon_admin"){ ?><li><a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG];?>&type=s"><img src="images/menu/settings.png" alt="<?php echo $ap_lang["Settings"]; ?>" title="<?php echo $ap_lang["Settings"]; ?>" border="0" /> <?php echo $ap_lang["Settings"]; ?></a></li><?php }?>
                    <li><a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG];?>&page=logout"><img src="images/menu/logout.png" alt="<?php echo $ap_lang["Logout"]; ?>" title="<?php echo $ap_lang["Logout"]; ?>" border="0" /> <?php echo $ap_lang["Logout"]; ?></a></li>
                </ul> 
            </div><!--menu-->
        </div><!--content-->
    </div><!--header-->
   	<div style="clear:both"></div>
	<?php 
    if($_GET)
    {
        if($_GET['type'])
            switch($_GET['type'])
            {
                case "dc":
                {
                    if($_GET['page'])	include_once "dc_forms/".$_GET['page']."/".$_GET['page']."_".$_GET['action'].".php";
                    else				include_once "php/dc_dashboard.php";
                }
                break;   
                case "m":
                {
                    if($_GET['page'])	include_once "modules/".$_GET['page']."/index.php";
                    else				include_once "php/modules_dashboard.php";
                }
                break; 
                case "s":	include_once "php/settings_dashboard.php";
                break; 
				case "r":	include_once "php/reports_dashboard.php";
                break; 
                case "c":	include_once "php/contact_dashboard.php";
                break;
                default:	include_once "php/dc_dashboard.php";
            }
        if($_GET['page'] && !$_GET['type'])
            switch($_GET['page'])
            {
                case "auth":	include_once "auth.php";
                break;
                case "logout":	include_once "logout.php";
                break;
                default:		include_once "php/dc_dashboard.php";
            }	
    }
    else	
        include_once "php/dc_dashboard.php";
    ?>
   	<div class="push"></div><!--OBAVEZNO IDE PRE WRAPPERA-->
    </div><!--wrapper--> 
    <div class="footer">   
        <div id="footer">
            <div id="content">
                <table width="350" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" class="company_name"><?php echo COMPANYNAME; ?></td>
                  </tr>
                  <?php if(COMPANYADDRESS != ""){ ?>
                  <tr>
                    <td width="100"><?php echo $ap_lang["Address"]; ?>:</td>
                    <td width="250"><?php echo COMPANYADDRESS; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYCITY != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["City"]; ?>:</td>
                    <td><?php echo COMPANYCITY; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYPOSTALCODE != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Postal code"]; ?>:</td>
                    <td><?php echo COMPANYPOSTALCODE .' '. COMPANYCITY; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYCOUNTRY != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Country"]; ?>:</td>
                    <td><?php echo COMPANYCOUNTRY; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYPHONE != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Phone"]; ?>:</td>
                    <td><?php echo COMPANYPHONE; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYFAX != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Fax"]; ?>:</td>
                    <td><?php echo COMPANYFAX; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYMOBILE != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Mobile"]; ?>:</td>
                    <td><?php echo COMPANYMOBILE; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYEMAIL != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Email"]; ?>:</td>
                    <td><?php echo COMPANYEMAIL; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if(COMPANYSITE != ""){ ?>
                  <tr>
                    <td><?php echo $ap_lang["Website"]; ?>:</td>
                    <td><?php echo COMPANYSITE; ?></td>
                  </tr>
                  <?php } ?>
                </table>
                <div id="web_lab_info">
                    <p>development by WEB LAB <img src="images/web_lab_logo.png" alt="*" /></p> 
                </div><!--web_lab_info-->
                <div style="clear:both;"></div>
            </div><!--content-->
        </div><!--footer-->
    </div>  
<?php } ?> 
</body>
</html>
<?php ob_flush(); ?>
<?php } ?>
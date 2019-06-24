<?php
require_once "../classes/domain/xenon_languages.class.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);

if($_POST)
{
	$body = "
	".$_POST["contact_name"]."
	".$_POST["contact_email"]."
	".$_POST["contact_phone"]."
	".$_POST["contact_message"]."
	";
	
 	if(mail("office@weblab.us","Question from Xenon Admin Panel",$body))	
		$success_message = $ap_lang["Message successfully sent!"];
	else													
		$error_message = $ap_lang["Message delivery failed!"];
}
if($_GET['page'])
{
	switch($_GET['page'])
	{
		case "company_info":
			include_once "php/company_info.php";
			break;
		case "website_language":
			include_once "php/website_language.php";
			break;	
		case "icons":
			include_once "php/icons.php";
		break;
		case "users":
			include_once "php/users.php";
		break;
		case "privileges":
			include_once "php/privileges.php";
		break;
		case "update":
			include_once "php/install_update.php";
		break; 
		default:
			include_once "php/settings_dashboard.php";
	}
}else{
?>
<div id="container">
	<div id="header_information">
		<h1><?php echo $ap_lang["Contact us"]; ?></h1>
		<p class="contact_us"><?php echo $ap_lang["Here you can send us a message if you have any questions!"]; ?></p>
	</div><!--header_information-->
	<div id="top" class="contact_us" >
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
        <div id="content">
            <div id="left_dashboard">
                <div id="contact_us">
                <form action="" method="post" enctype="multipart/form-data">
                <table border="0" cellspacing="0" cellpadding="5">
                <tr>
                    <td><?php echo $ap_lang["Name and Surname"];?></td>
                    <td><input name="contact_name" type="text" id="contact_name" size="20" value="<?php echo COMPANYNAME .' - '. $user->username; ?>"/></td>
                </tr>
                <tr>
                    <td><?php echo $ap_lang["Contact e-mail"];?></td>
                    <td><input name="contact_email" type="text" id="contact_email" size="20" value="<?php echo COMPANYEMAIL; ?>"/></td>
                </tr>
                <tr>
                    <td><?php echo $ap_lang["Contact phone"];?></td>
                    <td><input name="contact_phone" type="text" id="contact_phone" size="20" value="<?php echo COMPANYPHONE; ?>"/></td>
                </tr>
                <tr>
                    <td><?php echo $ap_lang["Your message"];?></td>
                    <td><textarea name="contact_message" cols="50" rows="10" id="contact_message"></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button type="submit" value="<?php echo $ap_lang["Send"];?>"/><?php echo $ap_lang["Send"];?></button></td>
                </tr>
                </table>
                </form>    
				</div><!--contact_us-->	
			</div><!--left_dashboard-->
			<?php include_once 'php/dc_right_dashboard.php'; ?>
		<div style="clear:both"></div>
	</div><!--content-->    
</div><!--container-->
<?php } ?>


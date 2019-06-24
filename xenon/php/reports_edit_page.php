<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/admin_reports.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$admin_reports = $broker->get_data(new admin_reports($_GET['id']));
if($_POST)
{
	$admin_reports = $broker->get_data(new admin_reports($_GET['id']));
	$admin_reports->display_name=$_POST['display_name'];
	$admin_reports->custom_sql=$_POST['custom_sql'];
	$admin_reports->instruction=$_POST['instruction'];
	$broker->update($admin_reports);
	$success_message = $ap_lang["You have successfully updated report"];
}
?>
<style>
	.seo_element{
		font-size:14px;
		margin-bottom:25px;
		padding-bottom:10px;
		border-bottom:1px solid #CCC;
	}
	
	a{
		text-decoration:none;
		color:#0099CC;
	}
	
	a:hover{
		text-decoration:underline;
		color:#0099CC;
	}
	
	.page_title{
		color:#0099CC;
	}
	
	fieldset{
		border:1px solid #CFE8FC;
	}
</style>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(function() {new nicEditor({fullPanel : true}).panelInstance("instruction");});</script>

<div id="container">
	<div id="top">
	<h1>Edit - <?php echo $admin_reports->display_name; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
    
        <div id="new_edit_record">
                <button type="button" onclick="location.href='index.php?type=s&page=reports_configuration'" class="general"><?php echo $ap_lang["Back"]; ?></button>

        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="page" value="<?php echo $admin_reports->display_name; ?>"/>

        <table>
        	<tr>
            	<td><?php echo $ap_lang["Name"]; ?>:</td>
                <td><input type="text" name="display_name" value="<?php echo $admin_reports->display_name; ?>" style="width:200px"/></td>
            </tr>
            <tr>
				<td><?php echo $ap_lang["Custom SQL"]; ?>:</td>
                <td><textarea name="custom_sql" style="height:400px; width:600px;"><?php echo $admin_reports->custom_sql; ?></textarea></td>
			</tr>
            <tr>
				<td><?php echo $ap_lang["Instruction:"];?></td>
                <td><textarea id="instruction" name="instruction" style="height:400px; width:600px;"><?php echo stripslashes($admin_reports->instruction); ?></textarea></td>
			</tr>
            <tr>
            	<td></td>
                <td><button type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
        </table>
		</form>
        <br />
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
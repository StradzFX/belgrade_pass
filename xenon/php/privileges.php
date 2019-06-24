<?php 
include_once "../classes/database/db_broker.php";
include_once "../classes/domain/xenon_privilege.class.php";
include_once "../classes/domain/xenon_menu.class.php";
include_once "../classes/domain/xenon_user.class.php";
include_once "../classes/domain/xenon_modules.class.php";
include_once "php/functions.php";
$broker = new db_broker();
//DELETE HANDLING
if($_GET["delete"])
{
	$users_with_deleted_privilege = new xenon_user();
	$users_with_deleted_privilege->set_condition("privilege","=",$_GET["delete"]);
	$users_with_deleted_privilege = $broker->get_all_data_condition($users_with_deleted_privilege);
	for($i=0;$i<sizeof($users_with_deleted_privilege); $i++)
		$users_with_deleted_privilege[$i]->privilege = "";
	
	if($broker->update_objects($users_with_deleted_privilege,true) == sizeof($users_with_deleted_privilege))
		if($broker->delete(new xenon_privilege($_GET["delete"])) == 1)
			$success_message = $ap_lang["Privilege has been successfully deleted!"];
		else	
			$error_message = $ap_lang["There was an error while deleting this privilege!"];
}
//SUBMIT HANDLING
if($_POST["submit"])
{
	if(MAGICQUOTES == 1)	$name = addslashes($_POST["name"]);
	else					$name = $_POST["name"];
	
	if($name == "")			$error_message = $ap_lang["Field"]." '".$ap_lang["Privilege"]."' ". $ap_lang["is required!"];
	if(strlen($name) > 50)	$error_message = $ap_lang["Field"]." '".$ap_lang["Privilege"]."' ". $ap_lang["must be below"]." 50 ". $ap_lang["characters"];
	
	if($_POST["maker"] == "on")		$maker = 1;
	else 							$maker = 0;

	if($_POST["checker"] == "on")	$checker = 1;
	else 							$checker = 0;
	
	if(!$_POST['all_dc'])
	{
		foreach($_POST as $value => $key)
			if(strpos($value,'dc_') === 0)	
				$dc_auth .= $key . ",";
		$dc_auth = substr($dc_auth, 0, -1);
	}
	else 	$dc_auth = "All";
	
	if(!$_POST['all_modules'])
	{
		foreach($_POST as $value => $key)
			if(strpos($value,'module_') === 0)
				$module_auth .= $key . ",";
		$module_auth = substr($module_auth, 0, -1);
	}
	else	$module_auth = "All";
	
	if($_GET['action'] == 'new')
	{
		$existing_privilege = new xenon_privilege();
		$existing_privilege->set_condition('name','=',$name);
		$existing_privilege = $broker->get_data($existing_privilege);
		
		if($existing_user != NULL)
			$error_message = $ap_lang["Privilege with name"]. " '".$existing_user->name."' " .$ap_lang["already exists!"];
		
		if($error_message == "")
			if($broker->insert(new xenon_privilege('',$name,$dc_auth,$module_auth,$maker,$checker),false,true) == 1)
				$success_message = $ap_lang["This privilege was inserted successfully!"];
			else	$error_message = $ap_lang["There was an error while editing this privilege!"];
		
	}
	if($_GET['action'] == 'edit')
	{	
		if($broker->update(new xenon_privilege($_GET["id"],$name,$dc_auth,$module_auth,$maker,$checker)) >= 0)
		{
			$_SESSION[ADMINAUTHDC] = $dc_auth;
			$_SESSION[ADMINAUTHMODULES] = $module_auth;
			$success_message = $ap_lang["This privilege was edited successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while editing this privilege!"];
	}
}

if($_GET['action'] == 'new')
	if($error_message == "")
		unset($new_privilege);	

if($_GET['action'] == 'edit')
{	
	$new_privilege = $broker->get_data(new xenon_privilege($_GET["id"]));
	$dc_option = explode(",",$new_privilege->dc_auth);
	$module_option = explode(",",$new_privilege->module_auth);
}

if($error_message != "")
{
	$new_privilege->name = $_POST['name'];
	foreach($_POST as $key => $value)
	{
		if(strpos($key,'dc_') === 0)			$dc_option[] = $_POST[$key];
		if(strpos($key,'all_dc') === 0)			$dc_option[] = 'All';
		
		if(strpos($key,'module_') === 0)		$module_option[] = $_POST[$key];
		if(strpos($key,'all_module') === 0)		$module_option[] = 'All';
	}
		
	if(isset($_POST["maker"]))		$new_privilege->maker = 1;
	else							$new_privilege->maker = 0;
		
	if(isset($_POST["checker"]))	$new_privilege->checker = 1;
	else							$new_privilege->checker = 0;
}

$xenon_privileges = $broker->get_all_data(new xenon_privilege());
$xenon_menu = $broker->get_all_data(new xenon_menu());
$xenon_modules = $broker->get_all_data(new xenon_modules());
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Privilege management"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
    <?php if($_GET['action']){ ?>
        <div id="new_edit_record">
        <form action="" method="post" name="edit" enctype="multipart/form-data">
        <button type="button" onclick="location.href='<?php echo url_link("action&id&delete"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
		<table border="0" cellspacing="0" cellpadding="0">
            <!--FORM TYPE INPUT-->
            <tr>
            <td><?php echo $ap_lang["Name"]; ?></td>
            <td>
             <input type="text" name="name" value="<?php echo $new_privilege->name; ?>"<?php if($_GET["action"] != "new"){ ?>style="width:150px; background:transparent; border:none;" readonly="readonly" <?php }else{?> style="width:150px;"<?php }?>>
            </td>
            </tr>	
            <!--FORM TYPE RADIOGROUP-->
			<SCRIPT language="javascript">
            $(function(){
                $("#selectalldc").click(function () {
                      $('.case_dc').attr('checked', this.checked);
                });
                $(".case_dc").click(function(){
                    if($(".case_dc").length == $(".case_dc:checked").length) {
                        $("#selectalldc").attr("checked", "checked");
                    } else {
                        $("#selectalldc").removeAttr("checked");
                    }
                });
            });
            </SCRIPT>
            <tr>
            <td><?php echo $ap_lang["Dashboard"]; ?></td>
            <td>
            <input type="checkbox" id="selectalldc" name="all_dc" value="All" <?php if($dc_option[0] == "All"){ ?> checked="checked"<?php } ?>/><strong> <?php echo $ap_lang["All options"]; ?></strong><br />
            <?php for($i = 0; $i < sizeof($xenon_menu); $i++){ ?><input type="checkbox" class="case_dc" name="dc_<?php echo $i; ?>" value="<?php echo $xenon_menu[$i]->name; ?>" <?php for($j = 0; $j < sizeof($dc_option); $j++){ 
			if($dc_option[$j] == $xenon_menu[$i]->name || $dc_option[0] == "All"){ ?> checked="checked"<?php }} ?> /> 
			<?php echo $xenon_menu[$i]->namemenu; ?><br /><?php } ?>
            </td>
            </tr>
            <!--FORM TYPE RADIOGROUP-->
			<SCRIPT language="javascript">
			$(function(){
                $("#selectallmodules").click(function () {
                      $('.case_module').attr('checked', this.checked);
                });
                $(".case_module").click(function(){
                    if($(".case_module").length == $(".case_module:checked").length) {
                        $("#selectallmodules").attr("checked", "checked");
                    } else {
                        $("#selectallmodules").removeAttr("checked");
                    }
                });
            });
            </SCRIPT>
            <tr>
            <td><?php echo $ap_lang["Modules"]; ?></td>
            <td>
            <input type="checkbox" id="selectallmodules" name="all_modules" value="All" <?php if($module_option[0] == "All"){ ?> checked="checked"<?php } ?>/> <strong><?php echo $ap_lang["All modules"]; ?></strong><br />
            <?php for($i = 0; $i < sizeof($xenon_modules); $i++){  ?>
			<input type="checkbox" class="case_module" name="module_<?php echo $i; ?>" value="<?php echo $xenon_modules[$i]->name . ' ' . $xenon_modules[$i]->version;  ?>" <?php for($j = 0; $j < sizeof($module_option); $j++){ if($module_option[$j] == $xenon_modules[$i]->name . ' ' . $xenon_modules[$i]->version || $module_option[0] == "All"){ ?> checked="checked"<?php }} ?> /> <?php echo $xenon_modules[$i]->name . ' ' . $xenon_modules[$i]->version; ?> <br />
            <?php } ?>
            </td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Maker"]; ?></td>
                <td>
                <?php if($new_privilege->maker == 1){ ?>
                <input type="checkbox" name="maker" checked="checked"/>	
                <?php }else{ ?>
                <input type="checkbox" name="maker"/>	
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Checker"]; ?></td>
                <td>
                <?php if($new_privilege->checker == 1){ ?>
                <input type="checkbox" name="checker" checked="checked"/>	
                <?php }else{ ?>
                <input type="checkbox" name="checker"/>	
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button name="submit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
		</table>
		</form>
        </div>
    <?php } else { ?>
    	<div id="new_edit_record">
        <form action="" method="post" enctype="multipart/form-data">
            <button type="button" onclick="location.href='<?php echo url_link("delete&id&action=new"); ?>'" class="general"><?php echo $ap_lang["New"]; ?></button>
        </form>
        <div id="see_all">
        <table width="757" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                	<th width="35"><?php echo $ap_lang["No."]; ?></th>
                    <th width="208"><?php echo $ap_lang["Name"]; ?></th>
                    <th width="103"><?php echo $ap_lang["Dashboard"]; ?></th>
                    <th width="103"><?php echo $ap_lang["Modules"]; ?></th>
                    <th width="100"><?php echo $ap_lang["Maker"]; ?></th>
                    <th width="100"><?php echo $ap_lang["Checker"]; ?></th>
                    <th colspan="2" width="108"><?php echo $ap_lang["Actions"]; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php 
				$counter = 1;
				foreach($xenon_privileges as $privilege) { ?>
                <tr>
                	<td><?php echo $counter;?></td>
                    <?php $counter++; ?>
                    <td><?php echo $privilege->name;?></td>
                    <td><?php 
						if($privilege->dc_auth != "All")
						{
							$options = explode(",",$privilege->dc_auth);
							for($i = 0; $i < sizeof($options); $i++)
								for($j = 0; $j < sizeof($xenon_menu); $j++)
									if(strcmp($options[$i],$xenon_menu[$j]->name)==0)
										echo $xenon_menu[$j]->namemenu . '<br />';
                        }
                        else echo $ap_lang["All options"];
                        ?>
                    </td>
                    <td><?php 
						if($privilege->module_auth != "All")
						{
							$modules = explode(",",$privilege->module_auth);
							for($i = 0; $i < sizeof($modules); $i++)
								echo $modules[$i] . '<br />'; 
                        }
                        else echo $ap_lang["All modules"];
                        ?>
                    </td>
                    <td align="center"><?php if($privilege->maker == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];} ?></td>
                    <td align="center"><?php if($privilege->checker == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];} ?></td>
                    <?php if($privilege->name == "Administrator"){?>
                    <td>
                    <img src="images/action_icons/off/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" />
                    </td>
                    <td><img src="images/action_icons/off/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /></td>
                    <?php }else{ ?>
                    <td><a href="<?php echo url_link("delete&action=edit&id=".$privilege->id); ?>">
                    <img src="images/action_icons/on/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /></a></td>
                    <td><a href="<?php echo url_link("id&promote&delete=".$privilege->id); ?>">
					<img src="images/action_icons/on/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /></a></td>
                    <?php }?>
                </tr>
            <?php }?>		
            </tbody>
        </table>
        </div>
        </div>
    <?php } ?>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

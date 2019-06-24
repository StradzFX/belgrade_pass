<?php 
include_once "../classes/database/db_broker.php";
include_once "../classes/domain/xenon_user.class.php";
include_once "../classes/domain/xenon_privilege.class.php";
include_once "php/functions.php";
$broker = new db_broker();
//DELETE HANDLING
if($_GET["delete"])
{
	if($broker->delete(new xenon_user($_GET["delete"])) == 1)
		$success_message = $ap_lang["User has been successfully deleted!"];
	else $error_message = $ap_lang["There was an error while deleting this user!"];
}
//PROMOTE HANDLING
if($_GET["promote"] != "")
{
	if($_GET["promote"] == "1"){
		$action = "promote";
		$active = 1;
	} else {
		$action = "demote";
		$active = 0;
	}
	
	$new_user = $broker->get_data(new xenon_user($_GET["id"]));
	$new_user->active = $active;
	$broker->update($new_user);
}

//SUBMIT HANDLING
if($_POST["submit"])
{
	if(MAGICQUOTES == 1)			$username = addslashes($_POST["username"]);
	else							$username = $_POST["username"];
	
	if(MAGICQUOTES == 1)			$password = addslashes($_POST["password"]);
	else							$password = $_POST["password"];
	
	if(MAGICQUOTES == 1)			$password_confirm = addslashes($_POST["password_confirm"]);
	else							$password_confirm = $_POST["password_confirm"];
	
	if($_POST["active"] == "on")	$active = 1;
	else 							$active = 0;
	
	if($_POST["see_other_data"] == "on")	$see_other_data = 1;
	else 									$see_other_data = 0;
	
	$password_changed = $_POST["password_changed"];	
	$privilege = $_POST["privilege"];

	if($username == "") 		
		$error_message =  $ap_lang["Field"]." '".$ap_lang["Username"]."' ". $ap_lang["is required!"];
	if(strlen($username) > 50)	
		$error_message = $ap_lang["Field"]." '".$ap_lang["Username"]."' ". $ap_lang["must be below"]." 50 ". $ap_lang["characters"];
	
	if($password == "" && $password_changed == "1")
		if($password == "")
			$error_message = $ap_lang["Field"] . " '".$ap_lang["Password"]."' ". $ap_lang["is required!"];
			
	if(strcmp($_POST["password"],$_POST["password_confirm"]) != 0)
		$error_message = $ap_lang["Validation is not correct, please try again!"];

	if(strlen($password) > 50)		
		$error_message = $ap_lang["Field"]." '".$ap_lang["Password"]."' ". $ap_lang["must be below"]." 50 ". $ap_lang["characters"];
	if($error_message == "")
	{	
		if($_GET['action'] == 'edit')
		{	
			$edited_user = $broker->get_data(new xenon_user($_GET["id"]));
			if($password_changed == "1")
			{
				if($password == "")			$edited_user->password = "";
				else						$edited_user->password = md5($password);
			}
			
			
			if($username == "admin")
			{
				$active = 1;
				$privilege = 1;
				$see_other_data = 1;
			}
			
			
			$edited_user->see_other_data = $see_other_data;
			
			
			if($broker->update($edited_user) >= 0)
			{
				if($active == 1)	$action = "promote";
				else 				$action = "demote";
				
				$success_message = $ap_lang["User has been edited successfully!"];
			}
			else	$error_message = $ap_lang["There was an error while editing this user!"];
		}
		if($_GET['action'] == 'new')
		{
			if($_POST["password"] == "")	$password = "";
			else							$password = md5($password);
		
			$existing_user = new xenon_user();
			$existing_user->set_condition('username','=',$username);
			$existing_user = $broker->get_data($existing_user);
			if($existing_user->id != NULL)
				$error_message = $ap_lang["User with name"]." '".$existing_user->username."' ".$ap_lang["already exists!"];
		
			if($error_message == "")
			{
				if($broker->insert(new xenon_user('',$username,$password,$active,$privilege,$see_other_data)) == 1)
					$success_message = $ap_lang["This user was inserted successfully!"];
				else 	$error_message = $ap_lang["There was an error while inserting this user!"];
			}
		}
	}
}
if($_GET['action'] == 'edit')
{
	if($error_message != "")
	{
		$new_user = $broker->get_data(new xenon_user($_GET["id"]));
		
		$active = $new_user->active;
		foreach($_POST as $key => $value)
			$new_user->$key = $_POST[$key];
	
		if($_POST['active'] == "on")	$new_user->active = 1;
		if($_POST['active'] == NULL)	$new_user->active = 0;
		if($username == "admin")
		{
			$new_user->active = 1;
			$new_user->privilege = 1;
		}
	}
	else 	$new_user = $broker->get_data(new xenon_user($_GET["id"]));
}

if($_GET['action'] == 'new')
{
	$new_user = new xenon_user();
	if($error_message != "")
	{
		foreach($_POST as $key => $value)
			$new_user->$key = $_POST[$key];
		if(isset($_POST["active"]))		$new_user->active = 1;
		else							$new_user->active = 0;
	}
	else	unset($new_user);	
}

$xenon_users = $broker->get_all_data(new xenon_user());
$xenon_privileges = $broker->get_all_data(new xenon_privilege());
for($i = 0; $i < sizeof($xenon_users); $i++)
	for($j = 0; $j < sizeof($xenon_privileges); $j++)
		if(strcmp($xenon_users[$i]->privilege,$xenon_privileges[$j]->id) == 0)
			$xenon_users[$i]->privilege = $xenon_privileges[$j]->name;
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["User management"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
    <div id="new_edit_record">
    <?php if($_GET['action']){ ?>
    		<form action="" method="post" enctype="multipart/form-data">
    		<button type="button" onclick="location.href='<?php echo url_link("action&id&promote&delete"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
            <table border="0" cellspacing="0" cellpadding="0">
                <!--FORM TYPE INPUT-->
                <tr>
                <td><?php echo $ap_lang["Username"]; ?></td>
                <td>
                <input type="text" name="username" value="<?php echo $new_user->username; ?>"<?php if($_GET["action"] != "new"){ ?>style="width:150px; background:transparent; border:none;" readonly="readonly" <?php }else{?> style="width:150px;"<?php }?> maxlength="7">
                </td>
                </tr>	
                <script>
				<?php 
					if($error_message == "" && $new_user->password != ""){ ?>
					
					$('table').delegate('[name=change_password]', 'click', function() {
							$(this).closest('tr').hide( function() {
							$('.insert_password').show();
							$('[name="password_changed"]').val('1');
						});
					});
				<?php }else{ ?>	
					$(function() {
						$('[name=change_password]').closest('tr').hide();
						$('.insert_password').show();
						$('[name="password_changed"]').val('1');
					});
				<?php } ?>
				</script>
				<input type="hidden" name="password_changed" value="0"/>
                <tr>
                <td><span class="required">* </span><?php echo $ap_lang["Password"]; ?></td>
                <td><button type="button" name="change_password"><?php echo $ap_lang["Change"]; ?></button></td>
                </tr>
                <!--FORM TYPE INPUT-->
                <tr class="insert_password" style="display:none">
                <td><span class="required">* </span><?php echo $ap_lang["Password"]; ?></td>
                <td>
                <input type="password" name="password" value="" style="width:150px;">
                </td>
                </tr>
                <!--FORM TYPE INPUT-->
                <tr class="insert_password" style="display:none">
                <td><span class="required">* </span><?php echo $ap_lang["Confirm password"]; ?></td>
                <td>
                <input type="password" name="password_confirm" value="" style="width:150px;">
                </td>
                </tr>
                <!--FORM TYPE RADIOGROUP-->
                <tr>
                <td><?php echo $ap_lang["Privilege"]; ?></td>
                <td>
                <?php for($i = 0; $i < sizeof($xenon_privileges); $i++){ ?><input type="radio" name="privilege" value="<?php echo $xenon_privileges[$i]->id; ?>" id="privileges_<?php echo $i; ?>"<?php if($i == 0 || $new_user->privilege == $xenon_privileges[$i]->id){ ?> checked="checked"<?php } if($new_user->username == "admin" && $_GET["action"] != "new"){?> DISABLED <?php }?>/><?php echo $xenon_privileges[$i]->name;?><br />
                <?php } ?>
                </td>
                </tr>
                
                
                 <tr>
                <td><?php echo $ap_lang["see_other_data"]; ?></td>
                <td>
                <input type="checkbox" name="see_other_data" value="on" <?php if($new_user->see_other_data == 1){ ?>checked="checked"<?php } ?> <?php if($new_user->username == "admin" && $_GET["action"] != "new"){ ?> DISABLED <?php } ?>>
                </td>
                </tr>
                
                <tr>
                    <td><?php echo $ap_lang["Enable user"]; ?></td>
                    <td>
                    <?php if($new_user->active == 1){ ?>
                    <input type="checkbox" name="active" checked="checked" <?php if($new_user->username == "admin" && $_GET["action"] != "new"){?> DISABLED <?php }?>/>	
                    <?php }else{ ?>
                    <input type="checkbox" name="active" />	
                    <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><button name="submit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
                </tr>
			</table>
            </form>
    <?php } else { ?>
    		<form action="" method="post" enctype="multipart/form-data">
            <button type="button" onclick="location.href='<?php echo url_link("promote&delete&id&action=new"); ?>'" class="general"><?php echo $ap_lang["New"]; ?></button>
            </form>
            <div id="see_all">
            <table width="757" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                    	<th width="35">ID</th>
                        <th width="282"><?php echo $ap_lang["Username"]; ?></th>
                        <th width="282"><?php echo $ap_lang["Privilege"]; ?></th>
                        <th width="282"><?php echo $ap_lang["see_other_data"]; ?></th>
                        <th width="50"><?php echo $ap_lang["Status"]; ?></th>
                        <th colspan="3" width="108"><?php echo $ap_lang["Actions"]; ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					foreach($xenon_users as $user) 
                    if($user->username != "xenon_admin")
                    { ?>
                    <tr>
                    	<td><?php echo $user->id-1;?></td>
                        <td><?php echo $user->username;?></td>
                        <td align="center"><?php if($user->privilege == "0"){echo $ap_lang["No privileges"];}else{echo $user->privilege;}?></td>
                        <td align="center"><?php if($user->see_other_data == "0"){echo $ap_lang["No"];}else{echo $ap_lang["Yes"];}?></td>
                        <td align="center">
                        <?php if($user->active == "0")  {?>
						<img src="images/action_icons/on/inactive.png" alt="<?php echo $ap_lang["Offline"]; ?>" title="<?php echo $ap_lang["Offline"]; ?>" width="16" height="16" border="0" />
						<?php }else {?>
						<img src="images/action_icons/on/active.png" alt="<?php echo $ap_lang["Online"]; ?>" title="<?php echo $ap_lang["Online"]; ?>" width="16" height="16" border="0" />
						<?php } ?>
                        </td>
                        <?php if($user->username != "admin"){ ?>
                        <td>
                        <?php if($user->active == "0"){ ?>
                        <a href="<?php echo url_link("delete&promote=1&id=".$user->id); ?>"><img src="images/action_icons/on/promote.png" alt="<?php echo $ap_lang["Promote"]; ?>" title="<?php echo $ap_lang["Promote"]; ?>" width="16" height="16" border="0" /></a>
                        <?php } else { ?>
                        <a href="<?php echo url_link("delete&promote=0&id=".$user->id); ?>"><img src="images/action_icons/on/demote.png" alt="<?php echo $ap_lang["Demote"]; ?>" title="<?php echo $ap_lang["Demote"]; ?>" width="16" height="16" border="0" /></a>
                        <?php } ?>
                        </td>
                        <td><a href="<?php echo url_link("delete&action=edit&promote&id=".$user->id); ?>"><img src="images/action_icons/on/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /></a></td>
                        <td><a href="<?php echo url_link("id&promote&delete=".$user->id); ?>">
                        <img src="images/action_icons/on/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /></a></td>
              			<?php } else { ?> 
                        <td>
                        <img src="images/action_icons/off/promote.png" alt="<?php echo $ap_lang["Promote"]; ?>" title="<?php echo $ap_lang["Promote"]; ?>" width="16" height="16" border="0" />
                        </td>
                        <?php if($user->username == "admin"){ ?>
                        <td><a href="<?php echo url_link("delete&action=edit&promote&id=".$user->id); ?>"><img src="images/action_icons/on/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /></a></td>
                        <?php } else{ ?>
                        <td><img src="images/action_icons/off/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /></td>
                        <?php } ?>
                        <td><img src="images/action_icons/off/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /></td>
              <?php }?>
                    </tr>
                        <?php }?>		
                </tbody>
            </table>
            </div>
    <?php } ?>
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

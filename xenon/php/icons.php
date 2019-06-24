<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "php/functions.php";
$broker = new db_broker();
if($_POST["submit"])
{
	$xenon_menu = $broker->get_data(new xenon_menu($_POST['edit_icon_id']));
	$xenon_menu->icon = $_POST['selected_icon'];
	$xenon_menu->namemenu = $_POST['dc_name'];
	if($_POST['dc_show']){
		$xenon_menu->showindashboard = 1;
	}else{
		$xenon_menu->showindashboard = 0;
	}
	$broker->update($xenon_menu);
	$success_message = $ap_lang["You successfully changed icon for this object!"];
}
$xenon_menu = new xenon_menu();
$xenon_menu->set_condition("showindashboard","!=","2");
$xenon_menu->set_order_by("pozicija",$direction="ASC");
$xenon_menu = $broker->get_all_data_condition($xenon_menu);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Dashboard icons"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <div id="icon_picker">
 		<?php
		$dc_option_array = $_SESSION[ADMINAUTHDC];
		$visible_dc_classes_namemenu = array();
		$visible_dc_classes_name = array();
		for($i=0; $i<sizeof($xenon_menu); $i++)
			for($j=0; $j<sizeof($dc_option_array); $j++)
				if(strcmp($xenon_menu[$i]->namemenu,$dc_option_array[$j])==0)
				{	
					$visible_dc_classes_namemenu[] = $xenon_menu[$i]->namemenu;
					$visible_dc_classes_name[] = $xenon_menu[$i]->name;
				}
		?>
    	<form action="<?php echo url_link("action=edit"); ?>" method="post" enctype="multipart/form-data">
		<?php if($_GET['action'] == "edit"){ ?>
		<button type="button" onclick="location.href='<?php echo url_link("action&object"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
        <?php 
			if($_POST['dc_object'])$_SESSION['pic_ses'] = $_POST['dc_object'];
			$edit_icon_dc = new xenon_menu();
			$edit_icon_dc->set_condition("name","=",$_SESSION['pic_ses']);
			$edit_icon_dc = $broker->get_data($edit_icon_dc);
		?>
        <?php ?>
        <input type="hidden" name="edit_icon_id" value="<?php echo $edit_icon_dc->id; ?>"/>
        <input type="hidden" name="dc_object" value="<?php echo $edit_icon_dc->name; ?>"/>
       	<br />
        <br />
        Name: <input type="text" name="dc_name" value="<?php echo $edit_icon_dc->namemenu; ?>"/>
        <br />
        Show in dashboard: <input type="checkbox" name="dc_show" value="yes" <?php if($edit_icon_dc->showindashboard == 1){ ?>checked="checked"<?php } ?>/>
		<br />
		<?php
        if ($handle = opendir('images/dashboard_icons')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "Thumbs.db") {
					 ?>
                    <div class="item" style="width:50px;margin: 20px 24px 0 0;">
					<input name="selected_icon" type="radio" value="<?php echo $entry; ?>" <?php if(strcmp($edit_icon_dc->icon,$entry)==0){ ?>checked="checked"<?php }?> id="item_<?php echo $entry; ?>"  />
					<label for="item_<?php echo $entry; ?>" style="width:50px;height:50px;">
                    	<img src="images/dashboard_icons/<?php echo $entry; ?>" border="0" width="40" />
                    </label>
                    </div>
          <?php }
            }
            closedir($handle);
 		} ?>
        <div style="clear:both;"></div>
		<hr />
        <button name="submit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button>
		</form>
<?php }else{ ?>
        <select name="dc_object" style="width:150px;" onchange="this.form.submit();">
	  	<?php if($_SESSION[ADMINAUTHDC][0] == "All"){?>
        	<option value="0" selected="selected"><?php echo $ap_lang["Choose object"]; ?></option>
			<?php for($i=0; $i<sizeof($xenon_menu); $i++){ ?><option value="<?php echo $xenon_menu[$i]->name; ?>" <?php if(strcmp($xenon_menu[$i]->name,$_POST['dc_object'])==0){?> selected="selected" <?php }?>><?php echo $xenon_menu[$i]->namemenu; ?></option><?php }} else { for($i=0; $i<sizeof($visible_dc_classes_name); $i++){ ?><option value="0" selected="selected"><?php echo $ap_lang["Choose object"]; ?></option><option value="<?php echo $visible_dc_classes_name[$i]; ?>"><?php echo $visible_dc_classes_namemenu[$i]; ?></option><?php }} ?>
        </select>
        </form>
		<?php }?>
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
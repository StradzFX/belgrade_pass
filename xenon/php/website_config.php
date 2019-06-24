<?php 
include_once "../classes/database/db_broker.php";
include_once "../classes/domain/xenon_languages.class.php";
$broker = new db_broker();
//======================== UPDATING SITE INFORMATION START
if($_POST['submit_site_config'])
{	
	$default_language = $_POST['default_language'];
	if($error_message == "")
	{
		$all_active_languages = $broker->get_all_data(new xenon_languages());
		for($i=0;$i<sizeof($all_active_languages);$i++)
		{
			if(strcmp($all_active_languages[$i]->short,$default_language) == 0)
			{
				$updated_language = new xenon_languages($all_active_languages[$i]->id,$all_active_languages[$i]->name,$all_active_languages[$i]->short,$all_active_languages[$i]->active,1,$all_active_languages[$i]->maker,$all_active_languages[$i]->makerDate,$all_active_languages[$i]->checker,$all_active_languages[$i]->checkerDate,$all_active_languages[$i]->pozicija);
			}
			else
				$updated_language = new xenon_languages($all_active_languages[$i]->id,$all_active_languages[$i]->name,$all_active_languages[$i]->short,$all_active_languages[$i]->active,0,$all_active_languages[$i]->maker,$all_active_languages[$i]->makerDate,$all_active_languages[$i]->checker,$all_active_languages[$i]->checkerDate,$all_active_languages[$i]->pozicija);
			$broker->update($updated_language);
			
		}
		$success_message = $ap_lang["You have successfully updated website information!"];	
	}
	else
		$error_message = $ap_lang["Failed to update site information!"];
}
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);
?>
<div class="wlfb-wr">
	<div class="wlfb-fl wlfb-negmx wlfb-15">
	<?php	include_once "php/settings_menu.php";	?>
	</div> 
<div class="wlfb-last wlfb-oh">
<div class="wlfb-box">
<div class="wlfb-last wlfb-oh">
		<div class="wlfb-box">
			<div id="h1"><?php echo $ap_lang["Website configuration"]; ?></div> 
		</div> 
		<div class="wlfb-box">
		<?php echo $ap_lang["Here you can edit your Website configuration!"]; ?>
		</div> 
<div class="wlfb-box" id="message-box">
		<!-- ERROR Start -->
		<?php if($error_message!=""){ ?><div id="box_error"><?php echo $error_message;   ?> </div><?php } ?> 
		<?php if($warning_message!=""){ ?><div id="box_warning"><?php echo $warning_message;   ?> </div><?php } ?>
		<?php if($success_message!=""){ ?><div id="box_success"><?php echo $success_message;   ?> </div><?php } ?>
		<!-- ERROR End -->
		</div>
 	</div>
<form enctype="multipart/form-data" name="edit" method="post" action="">
        <table width="0" border="0" cellpadding="2">
        <tr>
            <td style="min-width:150px;"><?php echo $ap_lang["Default language"]; ?></td>
            <td>
			<?php for($i=0;$i<sizeof($all_active_languages);$i++){ ?>
            <input type="radio" name="default_language" value="<?php echo $all_active_languages[$i]->short; ?>" id="jezicak_<?php echo $i; ?>"<?php if($all_active_languages[$i]->defaultlang == "1"){ ?>checked="checked"<?php } ?>/><?php echo $all_active_languages[$i]->name; ?><br /><?php } ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input id="button" name="submit_site_config" type="submit" value="<?php echo $ap_lang["Submit"]; ?>" /></td>
          </tr>
        </table>
</form>
         



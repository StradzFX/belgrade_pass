<?php 
include_once "../classes/database/db_broker.php";
include_once "../classes/domain/xenon_languages.class.php";
$broker = new db_broker();
//======================== UPDATING SITE INFORMATION START
if($_POST['submit_site_language'])
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
}else
{
	$company_name = COMPANYNAME;
	$company_address = COMPANYADDRESS;
	$company_city = COMPANYCITY;
	$company_country = COMPANYCOUNTRY;
	$company_postalcode = COMPANYPOSTALCODE;
	$company_phone = COMPANYPHONE;
	$company_mobile = COMPANYMOBILE;
	$company_fax = COMPANYFAX;
	$company_email = COMPANYEMAIL;
}
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);
?>

<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Website language"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
       	<form enctype="multipart/form-data" name="edit" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            <td><?php echo $ap_lang["Default language"]; ?></td>
            <td>
			<?php for($i=0;$i<sizeof($all_active_languages);$i++){ ?>
            <div class="item"><input name="default_language" type="radio" value="<?php echo $all_active_languages[$i]->short; ?>" id="item_<?php echo $i; ?>"<?php if($all_active_languages[$i]->defaultlang == "1"){ ?>checked="checked"<?php } ?>/><label for="item_<?php echo $i; ?>"><?php echo $all_active_languages[$i]->name; ?></label></div> <?php } ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
            <button name="submit_site_language" type="submit" value="<?php echo $ap_lang["Submit"]; ?>" ><?php echo $ap_lang["Submit"]; ?></button>
            </td>
          </tr>
        </table>
		</form>
        </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
         



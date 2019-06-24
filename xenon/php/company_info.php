<?php 
if($_POST['submit_site_config'])
{	
	$company_name = addslashes($_POST['company_name']);
	$company_address = addslashes($_POST['company_address']);
	$company_city = addslashes($_POST['company_city']);
	$company_country = addslashes($_POST['company_country']);
	$company_postalcode = addslashes($_POST['company_postalcode']);
	$company_phone = addslashes($_POST['company_phone']);
	$company_mobile = addslashes($_POST['company_mobile']);
	$company_fax = addslashes($_POST['company_fax']);
	$company_email = addslashes($_POST['company_email']);
	$company_site = addslashes($_POST['company_site']);
	
	if(!empty($_FILES['logo_file']['tmp_name']))
	{
		$file_ext = strrchr($_FILES['logo_file']['name'], ".");
		$whitelist = array(".jpg", ".jpeg", ".gif", ".png");
		if(!(in_array($file_ext, $whitelist)))		
			$error_message = $ap_lang["Image extension is not allowed!"];
		$imgsize = getimagesize($_FILES['logo_file']['tmp_name']);
		$imgsize = $imgsize[0];
		if($imgsize <= 0)
			$error_message = $ap_lang["This image is corrupted!"];
		
		$target = "images/logo.png";
		if(move_uploaded_file($_FILES['logo_file']['tmp_name'], $target)) 
		{
			$image_info = getimagesize($target);
			$image_type = $image_info[2];
			if($image_type == IMAGETYPE_JPEG)		$image = imagecreatefromjpeg($target);
			elseif($image_type == IMAGETYPE_GIF)	$image = imagecreatefromgif($target);
			elseif($image_type == IMAGETYPE_PNG)	$image = imagecreatefrompng($target);	
				
			$new_image = imagecreatetruecolor(200, 50);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, 200, 50, imagesx($image), imagesy($image));
			$image = $new_image;
			
			if($image_type == IMAGETYPE_JPEG)		imagejpeg($image,$target,80);
      		elseif($image_type == IMAGETYPE_GIF)	imagegif($image,$target);
      		elseif($image_type == IMAGETYPE_PNG)	imagepng($image,$target);
		}
		else
			$error_message = 'RESPONSE: Error while uploading logo!';
	}
	
	if($error_message == "")
	{
$file_code_string = '<?php
	define(COMPANYNAME, "'.$company_name.'");
	define(COMPANYADDRESS, "'.$company_address.'");			
	define(COMPANYCITY, "'.$company_city.'");				
	define(COMPANYCOUNTRY, "'.$company_country.'");			
	define(COMPANYPOSTALCODE, "'.$company_postalcode.'");	
	define(COMPANYPHONE, "'.$company_phone.'");				
	define(COMPANYMOBILE, "'.$company_mobile.'"); 			
	define(COMPANYFAX, "'.$company_fax.'");					
	define(COMPANYEMAIL, "'.$company_email.'");
	define(COMPANYSITE, "'.$company_site.'"); 			
?>';
		$fh = fopen('../company_config.php', 'w') or die("can't open file");
		fwrite($fh, $file_code_string);
		fclose($fh);
		
		$success_message = $ap_lang["You have successfully updated company information"];	
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
	$company_site = COMPANYSITE;
}
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Company information"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <form enctype="multipart/form-data" name="edit" method="post" action="">
            <table width="0" border="0" cellpadding="2">
            <tr>
                <td style="min-width:150px;"><?php echo $ap_lang["Name"]; ?></td>
                <td><input type="text" name="company_name" value="<?php echo $company_name; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Address"]; ?></td>
                <td><input type="text" name="company_address" value="<?php echo $company_address; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["City"]; ?></td>
                <td><input type="text" name="company_city" value="<?php echo $company_city; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Country"]; ?></td>
                <td><input type="text" name="company_country" value="<?php echo $company_country; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Postal code"]; ?></td>
                <td><input type="text" name="company_postalcode" value="<?php echo $company_postalcode; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Phone"]; ?></td>
                <td><input type="text" name="company_phone" value="<?php echo $company_phone; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Mobile"]; ?></td>
                <td><input type="text" name="company_mobile" value="<?php echo $company_mobile; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Fax"]; ?></td>
                <td><input type="text" name="company_fax" value="<?php echo $company_fax; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Website"]; ?></td>
                <td><input type="text" name="company_site" value="<?php echo $company_site; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Email"]; ?></td>
                <td><input type="text" name="company_email" value="<?php echo $company_email; ?>"/></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Website logo"]; ?></td>
                <td><img src="images/logo.png" /></td>
            </tr>
            <tr>
                <td><?php echo $ap_lang["Change website logo"]; ?></td>
                <td><input type="file" name="logo_file" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><button name="submit_site_config" type="submit" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
            </table>
        </form>
        </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
         



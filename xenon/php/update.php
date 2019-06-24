<?php 
include_once "php/functions.php";
//======================== UPDATING SITE INFORMATION START
if(isset($_POST['update']))
{	
	$target_folder = "install";
	if($_FILES['file']['name'] == "")
		$warning_message = $ap_lang["You must choose a file to install!"];
	else
	{
		if(!(in_array(strrchr($_FILES['file']['name'], '.'), array(".wlf"))))
			$error_message = $ap_lang["This file extension is not allowed!"];
		
		if($error_message == "")
		{
			if(!file_exists($target_folder))
			{
				mkdir($target_folder, 0777);
				chmod($target_folder, 0755);
			}
			$target_source = basename($_FILES['file']['name']);
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_source)) 
				$error_message = $ap_lang["There was a problem installing your file. Please, try again!"];
		}
	}
	if($error_message == "" && $warning_message == "")
	{
		extractZipFile($target_source, $target_folder);
		if(file_exists($target_folder . '/install.php'))
		{
			include_once($target_folder . '/install.php');
			delete_directory($target_folder);
			mkdir($target_folder,0777);
			chmod($target_folder,0777);
		}
		else
		{
			delete_directory($target_folder);
			mkdir($target_folder,0777);
			chmod($target_folder,0777);
			$error_message = $ap_lang["There was a problem installing your file. Please, try again!"];
		}
		if($error_message == "")	$success_message = $ap_lang["Installation done succesfully!"];
	}
}
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Install update"];	?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
       	<form enctype="multipart/form-data" action="" method="post">
        <input type="File" name="file"/>
        </br>
        <button type="submit" name="update" value="<?php echo $ap_lang["Submit"];?>"><?php echo $ap_lang["Submit"];?></button>
    	</form>
        </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
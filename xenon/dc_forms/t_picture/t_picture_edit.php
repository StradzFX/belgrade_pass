<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}

require_once "config.php";
include_once "php/functions.php";

error_reporting(E_ERROR);

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$edit_disabled = false;
$t_picture = $broker->get_data(new t_picture($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - trainer
require_once "../classes/domain/trainer.class.php";
$trainer = new trainer();
$trainer->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$trainer->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$trainer->add_condition("recordStatus","=","O");
$trainer->add_condition("jezik","=",$filter_lang);
$trainer->set_order_by("first_name","ASC");
$all_trainer = $broker->get_all_data_condition($trainer);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $t_picture->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$trainer = $_POST["trainer"];
	$picture_file = $_FILES["picture"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Trainer

	if(isset($trainer))
	{
		if(!is_numeric($trainer) && $trainer != "NULL")
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be number!"];
		
		if(strlen($trainer) > 11)
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - IMAGE|IMAGEW|IMAGEH|IMAGEWH ELEMENT - Picture

	if($picture_file["name"] == "")
	{
		if($_GET["id"] == NULL)
			$picture = "";
		else
		{
			$t_picture = $broker->get_data(new t_picture($_GET["id"]));
			$picture = $t_picture->picture;
			$picture_file["name"] = $t_picture->picture;
		}
	}else{
		$file_ext_arr = explode(".",$picture_file["name"]);
		$file_ext = $file_ext_arr[sizeof($file_ext_arr)-1];
		$whitelist = array("jpg", "jpeg", "gif", "png", "JPG", "PNG", "GIF", "JPEG");
		if(!(in_array($file_ext, $whitelist)))
			$error_message = $ap_lang["Image extension is not allowed!"];
		$imgsize = getimagesize($picture_file["tmp_name"]);
		$imgsize = $imgsize[0];
		if($imgsize <= 0)
			$error_message = $ap_lang["This image is corrupted!"];
	}
	
	if(strlen($picture_file["name"]) > 250)
		$error_message = $ap_lang["Field"] . " Picture " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	
//=================================================================================================
//================ ERROR HANDLER FOR VARIABLES - END ==============================================
//=================================================================================================
	
	if($error_message == "")
	{
//================ ERROR HANDLER FOR FILE|IMAGE|IMAGEW|IMAGEH|IMAGEWH|IMAGEC|JWPLAYER
		$file_moved = false;
		if($picture_file["name"] != "")
		{
			$random_number = rand(1,10000);
			$target_file = str_replace(" ","_",basename($picture_file["name"]));
			$target_folder = "../pictures/t_picture/picture";
			if($picture_file["name"] != $t_picture->picture && $picture_file["name"] != "") 
			{
				if(!file_exists($target_folder))	mkdir($target_folder, 0777, true);
				$target = $target_folder . "/".$random_number . "_" . $target_file; 
				$file_moved = move_uploaded_file($picture_file["tmp_name"], $target); 
				$picture = $random_number . "_" . $target_file;
			}
			else
			{
				$t_picture = $broker->get_data(new t_picture($_GET["id"]));
				$picture = $t_picture->picture;
			}
		}
		if($_POST["delete_picture"])
		{
			$file_to_delete = $target_folder . "/" . $t_picture->picture;
			if(file_exists($file_to_delete))	unlink($file_to_delete);
			if(!$file_moved)$picture = "";
		}
		
		if($_POST["promote"] == "yes")
		{
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checkerDate = date("Y-m-d H:i:s");
			if($noviobjekat->checker == ""){
				if(file_exists("promote_custom.php")){
					include_once "promote_custom.php";
				}
			}
		}
		else
		{
			$checker = "";
			$checkerDate = $t_picture->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new t_picture($id,$trainer,$picture,$t_picture->maker,$t_picture->makerDate,$checker,$checkerDate,$t_picture->pozicija,$t_picture->jezik,$t_picture->recordStatus,$t_picture->modNumber+1,$t_picture->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"t_picture","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$t_picture = $broker->get_data(new t_picture($_GET["id"]));
foreach($t_picture as $key => $value)
	$t_picture->$key = htmlentities($t_picture->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$t_picture->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $t_picture->checker == "")	
	$t_picture->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - T Picture</h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<div id="left_menu">
		<?php	include_once "php/dc_dashboard_menu.php";	?>
	</div><!--left_menu-->
		<div id="right_domain_object">
			<div id="new_edit_record">
<form action="" method="post" enctype="multipart/form-data">
<button type="button" onclick="location.href='<?php echo url_link("action=all&id&promote&pos"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
<table>
<?php if($edit_disabled){ ?>
<?php }else{ ?>
<tr>
	<td style="width:160px;"></td>
	<?php if($_SESSION[ADMINCHECKER] == 1 || $_SESSION[ADMINMAKER] == 1){ ?>
	<td><button name="submit-edit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
	<?php } ?>
</tr>
<?php } ?>

<!--FORM TYPE HIDDEN-->
<input type="hidden" name="id" value="<?php echo $t_picture->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Trainer</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $t_picture->trainer; }else{ ?>
<select name="trainer" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_trainer);$i++)
{
	if($all_trainer[$i]->id == $t_picture->trainer){ ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>" <?php if($t_picture->trainer == $all_trainer[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>"><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE IMAGE or IMAGEW or IMAGEH or IMAGEWH-->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
<script>
$(document).ready(function() {
    $("#picture").fancybox({
    	openEffect	: "none",
    	closeEffect	: "none"
    });
});
</script>
<tr>
<td>Picture</td>
<td>
<?php if($_GET["action"] == "preview"){ if($t_picture->picture != ""){?><a id="picture" href="../pictures/t_picture/picture/<?php echo $t_picture->picture; ?>"><img src="../pictures/t_picture/picture/<?php echo $t_picture->picture; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php }}else{ ?><input id="picture_upload" type="file" name="picture" value="<?php echo $t_picture->picture; ?>"/>
<label for="picture_upload" class="upload">&larr; <?php echo $ap_lang["Upload new picture"];?></label>
<?php if($t_picture->picture != NULL && $t_picture->picture != ""){ ?>
<br /><br /><a id="picture" href="../pictures/t_picture/picture/<?php echo $t_picture->picture; ?>"><img src="../pictures/t_picture/picture/<?php echo $t_picture->picture; ?>"     style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php if($t_picture->picture != NULL && $t_picture->picture != ""){ ?>
<br /><br /><input id="picture_del" type="checkbox" name="delete_picture" value="<?php echo $t_picture->picture; ?>"/><label for="picture_del"><?php echo $ap_lang["Delete image?"]; ?></label> 
<?php } ?>
<?php } ?>
</td>
</tr>
	
<?php if($t_picture->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $t_picture->maker; ?> (<?php  echo $t_picture->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($t_picture->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $t_picture->checker; ?> (<?php  echo $t_picture->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($t_picture->checker != ""){ ?>
	<input type="checkbox" name="promote" value="yes" checked="checked"/>	
	<?php }else{ ?>
	<input type="checkbox" name="promote" value="yes"/>	
	<?php } ?>
	</td>
</tr>
<?php } ?>
<?php if($edit_disabled){ ?>
<?php }else{ ?>
<tr>
	<td class="last"></td>
	<?php if($_SESSION[ADMINCHECKER] == 1 || $_SESSION[ADMINMAKER] == 1){ ?>
	<td class="last"><button name="submit-edit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
	<?php } ?>
</tr>
<?php } ?>
</table>
</form>
     		</div>
		</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

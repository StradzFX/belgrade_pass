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
$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - training_school
require_once "../classes/domain/training_school.class.php";
$training_school = new training_school();
$training_school->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$training_school->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$training_school->add_condition("recordStatus","=","O");
$training_school->add_condition("jezik","=",$filter_lang);
$training_school->set_order_by("name","ASC");
$all_training_school = $broker->get_all_data_condition($training_school);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $ts_picture->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$picture_file = $_FILES["picture"];
	$thumb = $_POST["thumb_jcrop"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - IMAGE|IMAGEW|IMAGEH|IMAGEWH ELEMENT - Picture

	if($picture_file["name"] == "")
	{
		if($_GET["id"] == NULL)
			$picture = "";
		else
		{
			$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));
			$picture = $ts_picture->picture;
			$picture_file["name"] = $ts_picture->picture;
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
	
//================ ERROR HANDLER - JCROP ELEMENT - Thumb

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
			$target_folder = "../pictures/ts_picture/picture";
			if($picture_file["name"] != $ts_picture->picture && $picture_file["name"] != "") 
			{
				if(!file_exists($target_folder))	mkdir($target_folder, 0777, true);
				$target = $target_folder . "/".$random_number . "_" . $target_file; 
				$file_moved = move_uploaded_file($picture_file["tmp_name"], $target); 
				$picture = $random_number . "_" . $target_file;
			}
			else
			{
				$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));
				$picture = $ts_picture->picture;
			}
		}
		if($_POST["delete_picture"])
		{
			$file_to_delete = $target_folder . "/" . $ts_picture->picture;
			if(file_exists($file_to_delete))	unlink($file_to_delete);
			if(!$file_moved)$picture = "";
		}
		
		
		$jcrop_existing_image = $ts_picture->thumb;
		
		if($_POST["thumb_jcrop"] == "" && $_POST["delete_thumb"] == NULL)
			$thumb = $ts_picture->thumb;
			
		if($_POST["thumb_jcrop"] != "" && $ts_picture->thumb != "")
		{
			if(strcmp($jcrop_existing_image,$_POST["thumb_jcrop"])!=0)
			{
				
			}
		}
		if($_POST["delete_thumb"] && file_exists("../pictures/ts_picture/thumb/".$jcrop_existing_image))
		{
			
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
			$checkerDate = $ts_picture->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new ts_picture($id,$training_school,$picture,$thumb,$ts_picture->maker,$ts_picture->makerDate,$checker,$checkerDate,$ts_picture->pozicija,$ts_picture->jezik,$ts_picture->recordStatus,$ts_picture->modNumber+1,$ts_picture->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"ts_picture","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));
foreach($ts_picture as $key => $value)
	$ts_picture->$key = htmlentities($ts_picture->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$ts_picture->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $ts_picture->checker == "")	
	$ts_picture->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - TS Picture</h1>
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
<input type="hidden" name="id" value="<?php echo $ts_picture->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $ts_picture->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $ts_picture->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($ts_picture->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
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
<?php if($_GET["action"] == "preview"){ if($ts_picture->picture != ""){?><a id="picture" href="../pictures/ts_picture/picture/<?php echo $ts_picture->picture; ?>"><img src="../pictures/ts_picture/picture/<?php echo $ts_picture->picture; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php }}else{ ?><input id="picture_upload" type="file" name="picture" value="<?php echo $ts_picture->picture; ?>"/>
<label for="picture_upload" class="upload">&larr; <?php echo $ap_lang["Upload new picture"];?></label>
<?php if($ts_picture->picture != NULL && $ts_picture->picture != ""){ ?>
<br /><br /><a id="picture" href="../pictures/ts_picture/picture/<?php echo $ts_picture->picture; ?>"><img src="../pictures/ts_picture/picture/<?php echo $ts_picture->picture; ?>"     style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php if($ts_picture->picture != NULL && $ts_picture->picture != ""){ ?>
<br /><br /><input id="picture_del" type="checkbox" name="delete_picture" value="<?php echo $ts_picture->picture; ?>"/><label for="picture_del"><?php echo $ap_lang["Delete image?"]; ?></label> 
<?php } ?>
<?php } ?>
</td>
</tr>

<!--FORM TYPE JCROP-->
<tr>
<td>Thumb</td>
<td>
<?php if($_GET["action"] == "new" || $_GET["action"] == "edit"){ ?>
<link href="js/jcrop/css/default.css" rel="stylesheet" type="text/css" />
<link href="js/jcrop/scripts/fileuploader/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="js/jcrop/scripts/Jcrop/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jcrop/scripts/jquery-impromptu.js"></script>
<script type="text/javascript" src="js/jcrop/scripts/fileuploader/fileuploader.js"></script>
<script type="text/javascript" src="js/jcrop/scripts/Jcrop/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="js/jcrop/scripts/jquery-uberuploadcropper.js"></script>
<?php 
	$dc_name = "ts_picture";
	$dc_element_name = "thumb"; 
	$custom_value = "200,200";
	$dimensions = explode(",",$custom_value);
	$width = $dimensions[0];
	$height = $dimensions[1];
	$a_ratio = $width/$height;
	$upload_folder = "../pictures/".$dc_name."/".$dc_element_name."/";
	if(!file_exists($upload_folder))
	{
		mkdir($upload_folder, 0777, true);
		chmod($upload_folder, 0777);
	}
?>
<input type="hidden" name="<?php echo $dc_element_name; ?>_jcrop" value=""/>
<script type="text/javascript">
		$(function() {
				var name= "UploadImages_<?php echo $dc_element_name; ?>";
				$('#'+name).uberuploadcropper({
					'action'	: 'js/jcrop/crop/upload.php',
					'params'	: {data:'<?php echo $width; ?>|<?php echo $upload_folder; ?>'},
					'allowedExtensions': ['jpg','jpeg','png','gif'],
					'aspectRatio': <?php echo $a_ratio; ?>, 
					'element_name': name, 
					'allowSelect': true,						//can reselect
					'allowResize' : true,						//can resize selection
					'setSelect': [ 0, 0, 50, 50 ],				//these are the dimensions of the crop box x1,y1,x2,y2
					'minSize': [ 0, 0 ],						//if you want to be able to resize, use these
					'maxSize': [ 1500, 1500 ],
					'folder': '<?php echo $upload_folder; ?>',	// only used in uber, not passed to server
					'cropAction': 'js/jcrop/crop/crop.php',		// server side request to crop image
					'onComplete': function(imgs,data){ 
					var $PhotoPrevs = $('#PhotoPrevs_<?php echo $dc_element_name; ?>');
					for(var i=0; i<1; i++){
					$PhotoPrevs.append('<img src="<?php echo $upload_folder; ?>/'+ imgs[imgs.length-1].filename +'?d='+ (new Date()).getTime() +'" style="max-width:250px;max-height:100px;"/>');
					$('[name=<?php echo $dc_element_name; ?>_jcrop]').val(imgs[imgs.length-1].filename);
					$('#<?php echo $dc_element_name; ?>_oldpic').hide();
					}
				}
			});
		});
</script>
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
<script>
$(document).ready(function() {
    $("#thumb").fancybox({
    	openEffect	: "none",
    	closeEffect	: "none"
    });
});
</script>
<?php if($_GET["action"] == "new"){ ?>
<div id="UploadImages_<?php echo $dc_element_name; ?>"><?php $ap_lang["Please enable javascript to upload and crop images."]; ?></div>
<div id="PhotoPrevs_<?php echo $dc_element_name; ?>"></div>
<?php } ?>
<?php if($_GET["action"] == "edit")
{ 
	if($ts_picture->thumb == "" || $ts_picture->thumb == NULL)
	{ ?>
	<div id="UploadImages_<?php echo $dc_element_name; ?>"><?php $ap_lang["Please enable javascript to upload and crop images."]; ?></div>
	<div id="PhotoPrevs_<?php echo $dc_element_name; ?>"></div> <?php
	}
	if($ts_picture->thumb != ""){?>
	<div id="UploadImages_<?php echo $dc_element_name; ?>"><?php $ap_lang["Please enable javascript to upload and crop images."]; ?></div>
	<div id="PhotoPrevs_<?php echo $dc_element_name; ?>"></div>
	<div id="thumb_oldpic">
	<a id="thumb" href="../pictures/ts_picture/thumb/<?php echo $ts_picture->thumb; ?>"><img src="../pictures/ts_picture/thumb/<?php echo $ts_picture->thumb; ?>" style="max-width:250px;max-height:100px;border:0px;"/></a><br /><br />
	<input id="thumb_del" type="checkbox" name="delete_thumb" value="<?php echo $ts_picture->thumb; ?>"/>
	<label for="thumb_del"><?php echo $ap_lang["Delete image?"]; ?></label>
	</div>
	
<?php }
} 
}?>
<?php if($_GET["action"] == "preview"){ ?>
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
<script>
$(document).ready(function() {
    $("#thumb").fancybox({
    	openEffect	: "none",
    	closeEffect	: "none"
    });
});
</script>
<?php if($ts_picture->thumb != ""){ ?>
<a id="thumb" href="../pictures/ts_picture/thumb/<?php echo $ts_picture->thumb; ?>"><img src="../pictures/ts_picture/thumb/<?php echo $ts_picture->thumb; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php } ?>
</td>
</tr>
	
<?php if($ts_picture->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $ts_picture->maker; ?> (<?php  echo $ts_picture->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($ts_picture->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $ts_picture->checker; ?> (<?php  echo $ts_picture->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($ts_picture->checker != ""){ ?>
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

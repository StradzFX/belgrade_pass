<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/ts_picture.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

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
$ts_picture = $broker->get_data(new ts_picture($_GET["id"]));
require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_picture->training_school));
$ts_picture->training_school = $training_school->name;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";

$dc_objects = new ts_picture();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("picture","LIKE","%".$search."%","OR");
	$array_som[] = array("thumb","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_picture != "all" && $filter_picture != "")
	$dc_objects->add_condition("picture","=",$filter_picture);

if($filter_thumb != "all" && $filter_thumb != "")
	$dc_objects->add_condition("thumb","=",$filter_thumb);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new ts_picture();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new ts_picture();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$ts_picture->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new ts_picture();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$ts_picture->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new ts_picture();
$max_item->condition = $dc_objects->condition;
$max_item->order_by = $dc_objects->order_by;
$max_item->add_condition("pozicija","=",$broker->get_max_position_condition($max_item));
$max_item = $broker->get_all_data_condition($max_item);
$max_item = $max_item[0]->id;

if($sec_to_max == NULL)	$sec_to_max = $min_item; 
if($sec_to_min == NULL)	$sec_to_min = $max_item; 

?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Preview"]; ?> - TS Picture</h1>
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
			<button type="button" onclick="location.href='<?php echo url_link("action=pdf"); ?>'" class="general"><?php echo $ap_lang["Download PDF"]; ?></button>
			<?php if(!$_GET["sort_column"] || !$_GET["sort_direction"]){?>
			<button type="button" onclick="location.href='<?php echo url_link("id=".$sec_to_min); ?>'" class="pagination_right" style="float:right;"></button>
			<button type="button" onclick="location.href='<?php echo url_link("id=".$sec_to_max); ?>'" class="pagination_left" style="float:right;"></button>
			<?php } ?>
			<table width="757" border="0" cellspacing="0" cellpadding="0">
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
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

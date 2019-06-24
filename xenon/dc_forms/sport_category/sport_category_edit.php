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
$sport_category = $broker->get_data(new sport_category($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $sport_category->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$name = $_POST["name"];
	$logo_file = $_FILES["logo"];
	$popularity = $_POST["popularity"];
	$map_logo_file = $_FILES["map_logo"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Name

	if(isset($name))
	{
		if(strlen($name) > 250)
			$error_message = $ap_lang["Field"] . " Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - IMAGE|IMAGEW|IMAGEH|IMAGEWH ELEMENT - Logo

	if($logo_file["name"] == "")
	{
		if($_GET["id"] == NULL)
			$logo = "";
		else
		{
			$sport_category = $broker->get_data(new sport_category($_GET["id"]));
			$logo = $sport_category->logo;
			$logo_file["name"] = $sport_category->logo;
		}
	}else{
		$file_ext_arr = explode(".",$logo_file["name"]);
		$file_ext = $file_ext_arr[sizeof($file_ext_arr)-1];
		$whitelist = array("jpg", "jpeg", "gif", "png", "JPG", "PNG", "GIF", "JPEG");
		if(!(in_array($file_ext, $whitelist)))
			$error_message = $ap_lang["Image extension is not allowed!"];
		$imgsize = getimagesize($logo_file["tmp_name"]);
		$imgsize = $imgsize[0];
		if($imgsize <= 0)
			$error_message = $ap_lang["This image is corrupted!"];
	}
	
	if(strlen($logo_file["name"]) > 250)
		$error_message = $ap_lang["Field"] . " Logo " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Popularity

	if(isset($popularity))
	{
		if(!is_numeric($popularity) && $popularity != "NULL")
			$error_message = $ap_lang["Field"] . " Popularity " . $ap_lang["must be number!"];
		
		if(strlen($popularity) > 11)
			$error_message = $ap_lang["Field"] . " Popularity " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - IMAGE|IMAGEW|IMAGEH|IMAGEWH ELEMENT - Map Logo

	if($map_logo_file["name"] == "")
	{
		if($_GET["id"] == NULL)
			$map_logo = "";
		else
		{
			$sport_category = $broker->get_data(new sport_category($_GET["id"]));
			$map_logo = $sport_category->map_logo;
			$map_logo_file["name"] = $sport_category->map_logo;
		}
	}else{
		$file_ext_arr = explode(".",$map_logo_file["name"]);
		$file_ext = $file_ext_arr[sizeof($file_ext_arr)-1];
		$whitelist = array("jpg", "jpeg", "gif", "png", "JPG", "PNG", "GIF", "JPEG");
		if(!(in_array($file_ext, $whitelist)))
			$error_message = $ap_lang["Image extension is not allowed!"];
		$imgsize = getimagesize($map_logo_file["tmp_name"]);
		$imgsize = $imgsize[0];
		if($imgsize <= 0)
			$error_message = $ap_lang["This image is corrupted!"];
	}
	
	if(strlen($map_logo_file["name"]) > 250)
		$error_message = $ap_lang["Field"] . " Map Logo " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	
//=================================================================================================
//================ ERROR HANDLER FOR VARIABLES - END ==============================================
//=================================================================================================
	
	if($error_message == "")
	{
//================ ERROR HANDLER FOR FILE|IMAGE|IMAGEW|IMAGEH|IMAGEWH|IMAGEC|JWPLAYER
		$file_moved = false;
		if($logo_file["name"] != "")
		{
			$random_number = rand(1,10000);
			$target_file = str_replace(" ","_",basename($logo_file["name"]));
			$target_folder = "../pictures/sport_category/logo";
			if($logo_file["name"] != $sport_category->logo && $logo_file["name"] != "") 
			{
				if(!file_exists($target_folder))	mkdir($target_folder, 0777, true);
				$target = $target_folder . "/".$random_number . "_" . $target_file; 
				$file_moved = move_uploaded_file($logo_file["tmp_name"], $target); 
				$logo = $random_number . "_" . $target_file;
			}
			else
			{
				$sport_category = $broker->get_data(new sport_category($_GET["id"]));
				$logo = $sport_category->logo;
			}
		}
		if($_POST["delete_logo"])
		{
			$file_to_delete = $target_folder . "/" . $sport_category->logo;
			if(file_exists($file_to_delete))	unlink($file_to_delete);
			if(!$file_moved)$logo = "";
		}
		
//================ ERROR HANDLER FOR FILE|IMAGE|IMAGEW|IMAGEH|IMAGEWH|IMAGEC|JWPLAYER
		$file_moved = false;
		if($map_logo_file["name"] != "")
		{
			$random_number = rand(1,10000);
			$target_file = str_replace(" ","_",basename($map_logo_file["name"]));
			$target_folder = "../pictures/sport_category/map_logo";
			if($map_logo_file["name"] != $sport_category->map_logo && $map_logo_file["name"] != "") 
			{
				if(!file_exists($target_folder))	mkdir($target_folder, 0777, true);
				$target = $target_folder . "/".$random_number . "_" . $target_file; 
				$file_moved = move_uploaded_file($map_logo_file["tmp_name"], $target); 
				$map_logo = $random_number . "_" . $target_file;
			}
			else
			{
				$sport_category = $broker->get_data(new sport_category($_GET["id"]));
				$map_logo = $sport_category->map_logo;
			}
		}
		if($_POST["delete_map_logo"])
		{
			$file_to_delete = $target_folder . "/" . $sport_category->map_logo;
			if(file_exists($file_to_delete))	unlink($file_to_delete);
			if(!$file_moved)$map_logo = "";
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
			$checkerDate = $sport_category->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new sport_category($id,$name,$logo,$popularity,$map_logo,$sport_category->maker,$sport_category->makerDate,$checker,$checkerDate,$sport_category->pozicija,$sport_category->jezik,$sport_category->recordStatus,$sport_category->modNumber+1,$sport_category->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"sport_category","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$sport_category = $broker->get_data(new sport_category($_GET["id"]));
foreach($sport_category as $key => $value)
	$sport_category->$key = htmlentities($sport_category->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$sport_category->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $sport_category->checker == "")	
	$sport_category->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Category</h1>
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
<input type="hidden" name="id" value="<?php echo $sport_category->id; ?>"/>
<!--FORM TYPE INPUT-->
<script>
	function count_input_limit(element_name){
		var input_limit = parseInt($('[name="'+element_name+'"]').attr("limit"));
		var input_value = $('[name="'+element_name+'"]').val();
		var input_value_length = input_value.length;
		$("#"+element_name+"_counter").html("("+(input_limit-input_value_length)+")");
		if(input_value_length <= input_limit){
			$("#"+element_name+"_counter").css("color","#999");
		}else{
			$("#"+element_name+"_counter").css("color","#F00");
		}
	}
	$(function(){
		count_input_limit("name");
		
	});
</script>
<tr>
<td>Name <span id="name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $sport_category->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $sport_category->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE IMAGE or IMAGEW or IMAGEH or IMAGEWH-->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
<script>
$(document).ready(function() {
    $("#logo").fancybox({
    	openEffect	: "none",
    	closeEffect	: "none"
    });
});
</script>
<tr>
<td>Logo</td>
<td>
<?php if($_GET["action"] == "preview"){ if($sport_category->logo != ""){?><a id="logo" href="../pictures/sport_category/logo/<?php echo $sport_category->logo; ?>"><img src="../pictures/sport_category/logo/<?php echo $sport_category->logo; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php }}else{ ?><input id="logo_upload" type="file" name="logo" value="<?php echo $sport_category->logo; ?>"/>
<label for="logo_upload" class="upload">&larr; <?php echo $ap_lang["Upload new picture"];?></label>
<?php if($sport_category->logo != NULL && $sport_category->logo != ""){ ?>
<br /><br /><a id="logo" href="../pictures/sport_category/logo/<?php echo $sport_category->logo; ?>"><img src="../pictures/sport_category/logo/<?php echo $sport_category->logo; ?>"     style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php if($sport_category->logo != NULL && $sport_category->logo != ""){ ?>
<br /><br /><input id="logo_del" type="checkbox" name="delete_logo" value="<?php echo $sport_category->logo; ?>"/><label for="logo_del"><?php echo $ap_lang["Delete image?"]; ?></label> 
<?php } ?>
<?php } ?>
</td>
</tr>

<!--FORM TYPE INPUT-->
<script>
	function count_input_limit(element_name){
		var input_limit = parseInt($('[name="'+element_name+'"]').attr("limit"));
		var input_value = $('[name="'+element_name+'"]').val();
		var input_value_length = input_value.length;
		$("#"+element_name+"_counter").html("("+(input_limit-input_value_length)+")");
		if(input_value_length <= input_limit){
			$("#"+element_name+"_counter").css("color","#999");
		}else{
			$("#"+element_name+"_counter").css("color","#F00");
		}
	}
	$(function(){
		count_input_limit("popularity");
		
	});
</script>
<tr>
<td>Popularity <span id="popularity_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $sport_category->popularity; 
		}else{ 
	?>
	<input type="text" name="popularity" value="<?php echo $sport_category->popularity; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('popularity')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE IMAGE or IMAGEW or IMAGEH or IMAGEWH-->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
<script>
$(document).ready(function() {
    $("#map_logo").fancybox({
    	openEffect	: "none",
    	closeEffect	: "none"
    });
});
</script>
<tr>
<td>Map Logo</td>
<td>
<?php if($_GET["action"] == "preview"){ if($sport_category->map_logo != ""){?><a id="map_logo" href="../pictures/sport_category/map_logo/<?php echo $sport_category->map_logo; ?>"><img src="../pictures/sport_category/map_logo/<?php echo $sport_category->map_logo; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php }}else{ ?><input id="map_logo_upload" type="file" name="map_logo" value="<?php echo $sport_category->map_logo; ?>"/>
<label for="map_logo_upload" class="upload">&larr; <?php echo $ap_lang["Upload new picture"];?></label>
<?php if($sport_category->map_logo != NULL && $sport_category->map_logo != ""){ ?>
<br /><br /><a id="map_logo" href="../pictures/sport_category/map_logo/<?php echo $sport_category->map_logo; ?>"><img src="../pictures/sport_category/map_logo/<?php echo $sport_category->map_logo; ?>"     style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php if($sport_category->map_logo != NULL && $sport_category->map_logo != ""){ ?>
<br /><br /><input id="map_logo_del" type="checkbox" name="delete_map_logo" value="<?php echo $sport_category->map_logo; ?>"/><label for="map_logo_del"><?php echo $ap_lang["Delete image?"]; ?></label> 
<?php } ?>
<?php } ?>
</td>
</tr>
	
<?php if($sport_category->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $sport_category->maker; ?> (<?php  echo $sport_category->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($sport_category->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $sport_category->checker; ?> (<?php  echo $sport_category->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($sport_category->checker != ""){ ?>
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

<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_POST["submit-new"]){

$id = $_POST["id"];
	$name = $_POST["name"];
	$picture_file = $_FILES["picture"];	
		$price = $_POST["price"];
	$to_company = $_POST["to_company"];
	$to_us = $_POST["to_us"];
	$duration_days = $_POST["duration_days"];
	$number_of_passes = $_POST["number_of_passes"];
	$best_value = $_POST["best_value"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Name

	if(isset($name))
	{
		if(strlen($name) > 250)
			$error_message = $ap_lang["Field"] . " Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - IMAGE|IMAGEW|IMAGEH|IMAGEWH ELEMENT - Picture

	if($picture_file["name"] == "")
	{
		if($_GET["id"] == NULL)
			$picture = "";
		else
		{
			$card_package = $broker->get_data(new card_package($_GET["id"]));
			$picture = $card_package->picture;
			$picture_file["name"] = $card_package->picture;
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
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Price

	if(isset($price))
	{
		if(!is_numeric($price) && $price != "NULL")
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be number!"];
		
		if(strlen($price) > 11)
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - To Company

	if(isset($to_company))
	{
		if(!is_numeric($to_company) && $to_company != "NULL")
			$error_message = $ap_lang["Field"] . " To Company " . $ap_lang["must be number!"];
		
		if(strlen($to_company) > 11)
			$error_message = $ap_lang["Field"] . " To Company " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - To Us

	if(isset($to_us))
	{
		if(!is_numeric($to_us) && $to_us != "NULL")
			$error_message = $ap_lang["Field"] . " To Us " . $ap_lang["must be number!"];
		
		if(strlen($to_us) > 11)
			$error_message = $ap_lang["Field"] . " To Us " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Duration Days

	if(isset($duration_days))
	{
		if(!is_numeric($duration_days) && $duration_days != "NULL")
			$error_message = $ap_lang["Field"] . " Duration Days " . $ap_lang["must be number!"];
		
		if(strlen($duration_days) > 11)
			$error_message = $ap_lang["Field"] . " Duration Days " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of Passes

	if(isset($number_of_passes))
	{
		if(!is_numeric($number_of_passes) && $number_of_passes != "NULL")
			$error_message = $ap_lang["Field"] . " Number Of Passes " . $ap_lang["must be number!"];
		
		if(strlen($number_of_passes) > 11)
			$error_message = $ap_lang["Field"] . " Number Of Passes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Best Value

	if(isset($best_value))
	{
		$best_value = 1;
		$_POST["best_value"] = 1;
	}else{
		$best_value = 0;
		$_POST["best_value"] = 0;
	}
	

	if($error_message == "")
	{
//================ ERROR HANDLER FOR FILE|IMAGE|IMAGEW|IMAGEH|IMAGEWH|IMAGEC|JWPLAYER
		if($picture_file["name"] != "")
		{
			$random_number = rand(1,10000);
			$target_file = str_replace(" ","_",basename($picture_file["name"]));
			$target_folder = "../pictures/card_package/picture";
			if(!file_exists($target_folder))	mkdir($target_folder, 0777, true);
			$target = $target_folder . "/".$random_number . "_" . $target_file; 
			$file_moved = move_uploaded_file($picture_file["tmp_name"], $target);
			$picture = $random_number . "_" . $target_file; 
		}
		else	$picture = "";
		
		if($_POST["delete_picture"])	unlink($target_folder . "/" . $card_package->picture);
		
		if($_POST["promote"] == "yes"){
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checkerDate = date("Y-m-d H:i:s");
			if(file_exists("promote_custom.php")){
				include_once "promote_custom.php";
			}
		}else{
			$checker = "";
			$checkerDate = $card_package->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new card_package();
		$new_object->name = $name;$new_object->picture = $picture;$new_object->price = $price;$new_object->to_company = $to_company;$new_object->to_us = $to_us;$new_object->duration_days = $duration_days;$new_object->number_of_passes = $number_of_passes;$new_object->best_value = $best_value;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
		$new_object->makerDate = date("c");
		$new_object->checker = $checker;
		$new_object->checkerDate = $checkerDate;
		$new_object->jezik = $language;
		$new_object->recordStatus = "O";
		$new_dc_id = $broker->insert($new_object,false,false,true);
		if($new_dc_id > 0)
		{
			if(file_exists("insert_custom.php")){
				include_once "insert_custom.php";
			}
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"card_package","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$card_package = new card_package();
	foreach($_POST as $key => $value)
		$card_package->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$card_package->checker = $_SESSION[ADMINLOGGEDIN];
	else							$card_package->checker = "";
}
else	unset($card_package);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Card Package</h1>
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
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<form action="" method="post" enctype="multipart/form-data">
<button type="button" onclick="location.href='<?php echo url_link("action=all&id&promote&pos"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
<table>
<tr>
	<td class="last" style="width:160px;"></td>
	<td class="last"><button name="submit-new" type="submit" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
</tr>

<!--FORM TYPE HIDDEN-->
<input type="hidden" name="id" value="<?php echo $card_package->id; ?>"/>
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
			echo $card_package->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $card_package->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
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
<?php if($_GET["action"] == "preview"){ if($card_package->picture != ""){?><a id="picture" href="../pictures/card_package/picture/<?php echo $card_package->picture; ?>"><img src="../pictures/card_package/picture/<?php echo $card_package->picture; ?>" style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php }}else{ ?><input id="picture_upload" type="file" name="picture" value="<?php echo $card_package->picture; ?>"/>
<label for="picture_upload" class="upload">&larr; <?php echo $ap_lang["Upload new picture"];?></label>
<?php if($card_package->picture != NULL && $card_package->picture != ""){ ?>
<br /><br /><a id="picture" href="../pictures/card_package/picture/<?php echo $card_package->picture; ?>"><img src="../pictures/card_package/picture/<?php echo $card_package->picture; ?>"     style="max-width:250px;max-height:100px;border:0px;" title="<?php echo $ap_lang["Click to see in original resolution"]; ?>" alt="<?php echo $ap_lang["Click to see in original resolution"]; ?>"/></a><?php } ?>
<?php if($card_package->picture != NULL && $card_package->picture != ""){ ?>
<br /><br /><input id="picture_del" type="checkbox" name="delete_picture" value="<?php echo $card_package->picture; ?>"/><label for="picture_del"><?php echo $ap_lang["Delete image?"]; ?></label> 
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
		count_input_limit("price");
		
	});
</script>
<tr>
<td>Price <span id="price_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_package->price; 
		}else{ 
	?>
	<input type="text" name="price" value="<?php echo $card_package->price; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('price')">
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
		count_input_limit("to_company");
		
	});
</script>
<tr>
<td>To Company <span id="to_company_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_package->to_company; 
		}else{ 
	?>
	<input type="text" name="to_company" value="<?php echo $card_package->to_company; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('to_company')">
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
		count_input_limit("to_us");
		
	});
</script>
<tr>
<td>To Us <span id="to_us_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_package->to_us; 
		}else{ 
	?>
	<input type="text" name="to_us" value="<?php echo $card_package->to_us; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('to_us')">
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
		count_input_limit("duration_days");
		
	});
</script>
<tr>
<td>Duration Days <span id="duration_days_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_package->duration_days; 
		}else{ 
	?>
	<input type="text" name="duration_days" value="<?php echo $card_package->duration_days; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('duration_days')">
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
		count_input_limit("number_of_passes");
		
	});
</script>
<tr>
<td>Number Of Passes <span id="number_of_passes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_package->number_of_passes; 
		}else{ 
	?>
	<input type="text" name="number_of_passes" value="<?php echo $card_package->number_of_passes; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_passes')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Best Value</td>
<td>
<?php if($_GET["action"] == "preview"){
if($card_package->best_value == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="best_value" <?php if($card_package->best_value == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($card_package->checker != ""){ ?>
	<input type="checkbox" name="promote" value="yes" checked="checked"/>	
	<?php }else{ ?>
	<input type="checkbox" name="promote" value="yes"/>	
	<?php } ?>
	</td>
</tr>
<?php } ?>
<tr>
	<td class="last"></td>
	<td class="last"><button name="submit-new" type="submit" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
</tr>
</table>
</form>  
		</div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

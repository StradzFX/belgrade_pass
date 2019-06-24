<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


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
$all_training_school = $broker->get_all_data_condition($training_school);//==================== HANDLER FOR DROPMENU EXTENDED - ts_location
require_once "../classes/domain/ts_location.class.php";
$ts_location = new ts_location();
$ts_location->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$ts_location->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$ts_location->add_condition("recordStatus","=","O");
$ts_location->add_condition("jezik","=",$filter_lang);
$ts_location->set_order_by("id","ASC");
$all_ts_location = $broker->get_all_data_condition($ts_location);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$ts_location = $_POST["ts_location"];
	$garden = $_POST["garden"];
	$smoking = $_POST["smoking"];
	$max_kids = $_POST["max_kids"];
	$max_adults = $_POST["max_adults"];
	$catering = $_POST["catering"];
	$animators = $_POST["animators"];
	$watching_kids = $_POST["watching_kids"];
	$name = $_POST["name"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ts Location

	if(isset($ts_location))
	{
		if(!is_numeric($ts_location) && $ts_location != "NULL")
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be number!"];
		
		if(strlen($ts_location) > 11)
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Garden

	if(isset($garden))
	{
		$garden = 1;
		$_POST["garden"] = 1;
	}else{
		$garden = 0;
		$_POST["garden"] = 0;
	}
	
//================ ERROR HANDLER - CHECKBOX ELEMENT - Smoking

	if(isset($smoking))
	{
		$smoking = 1;
		$_POST["smoking"] = 1;
	}else{
		$smoking = 0;
		$_POST["smoking"] = 0;
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Max Kids

	if(isset($max_kids))
	{
		if(!is_numeric($max_kids) && $max_kids != "NULL")
			$error_message = $ap_lang["Field"] . " Max Kids " . $ap_lang["must be number!"];
		
		if(strlen($max_kids) > 11)
			$error_message = $ap_lang["Field"] . " Max Kids " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Max Adults

	if(isset($max_adults))
	{
		if(!is_numeric($max_adults) && $max_adults != "NULL")
			$error_message = $ap_lang["Field"] . " Max Adults " . $ap_lang["must be number!"];
		
		if(strlen($max_adults) > 11)
			$error_message = $ap_lang["Field"] . " Max Adults " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Catering

	if(isset($catering))
	{
		$catering = 1;
		$_POST["catering"] = 1;
	}else{
		$catering = 0;
		$_POST["catering"] = 0;
	}
	
//================ ERROR HANDLER - CHECKBOX ELEMENT - Animators

	if(isset($animators))
	{
		$animators = 1;
		$_POST["animators"] = 1;
	}else{
		$animators = 0;
		$_POST["animators"] = 0;
	}
	
//================ ERROR HANDLER - CHECKBOX ELEMENT - Watching Kids

	if(isset($watching_kids))
	{
		$watching_kids = 1;
		$_POST["watching_kids"] = 1;
	}else{
		$watching_kids = 0;
		$_POST["watching_kids"] = 0;
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Name

	if(isset($name))
	{
		if(strlen($name) > 250)
			$error_message = $ap_lang["Field"] . " Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}

	if($error_message == "")
	{
		if($_POST["promote"] == "yes"){
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checkerDate = date("Y-m-d H:i:s");
			if(file_exists("promote_custom.php")){
				include_once "promote_custom.php";
			}
		}else{
			$checker = "";
			$checkerDate = $company_birthday_data->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new company_birthday_data();
		$new_object->training_school = $training_school;$new_object->ts_location = $ts_location;$new_object->garden = $garden;$new_object->smoking = $smoking;$new_object->max_kids = $max_kids;$new_object->max_adults = $max_adults;$new_object->catering = $catering;$new_object->animators = $animators;$new_object->watching_kids = $watching_kids;$new_object->name = $name;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_birthday_data","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$company_birthday_data = new company_birthday_data();
	foreach($_POST as $key => $value)
		$company_birthday_data->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$company_birthday_data->checker = $_SESSION[ADMINLOGGEDIN];
	else							$company_birthday_data->checker = "";
}
else	unset($company_birthday_data);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Company Birthday Data</h1>
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
<input type="hidden" name="id" value="<?php echo $company_birthday_data->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_data->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $company_birthday_data->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($company_birthday_data->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Ts Location</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_data->ts_location; }else{ ?>
<select name="ts_location" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_location);$i++)
{
	if($all_ts_location[$i]->id == $company_birthday_data->ts_location){ ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>" <?php if($company_birthday_data->ts_location == $all_ts_location[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_location[$i]->id; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>"><?php echo $all_ts_location[$i]->id; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Garden</td>
<td>
<?php if($_GET["action"] == "preview"){
if($company_birthday_data->garden == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="garden" <?php if($company_birthday_data->garden == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Smoking</td>
<td>
<?php if($_GET["action"] == "preview"){
if($company_birthday_data->smoking == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="smoking" <?php if($company_birthday_data->smoking == 1) { ?> checked="checked" <?php } ?>/>
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
		count_input_limit("max_kids");
		
	});
</script>
<tr>
<td>Max Kids <span id="max_kids_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_data->max_kids; 
		}else{ 
	?>
	<input type="text" name="max_kids" value="<?php echo $company_birthday_data->max_kids; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('max_kids')">
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
		count_input_limit("max_adults");
		
	});
</script>
<tr>
<td>Max Adults <span id="max_adults_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_data->max_adults; 
		}else{ 
	?>
	<input type="text" name="max_adults" value="<?php echo $company_birthday_data->max_adults; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('max_adults')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Catering</td>
<td>
<?php if($_GET["action"] == "preview"){
if($company_birthday_data->catering == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="catering" <?php if($company_birthday_data->catering == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Animators</td>
<td>
<?php if($_GET["action"] == "preview"){
if($company_birthday_data->animators == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="animators" <?php if($company_birthday_data->animators == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Watching Kids</td>
<td>
<?php if($_GET["action"] == "preview"){
if($company_birthday_data->watching_kids == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="watching_kids" <?php if($company_birthday_data->watching_kids == 1) { ?> checked="checked" <?php } ?>/>
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
		count_input_limit("name");
		
	});
</script>
<tr>
<td>Name <span id="name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_data->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $company_birthday_data->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
	<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_birthday_data->checker != ""){ ?>
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

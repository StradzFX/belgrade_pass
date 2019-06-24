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
$ts_location->set_order_by("training_school","ASC");
$all_ts_location = $broker->get_all_data_condition($ts_location);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$day_of_week = $_POST["day_of_week"];
	$not_working = $_POST["not_working"];
	$working_from_hours = $_POST["working_from_hours"];
	$working_from_minutes = $_POST["working_from_minutes"];
	$working_to_hours = $_POST["working_to_hours"];
	$working_to_minutes = $_POST["working_to_minutes"];
	$ts_location = $_POST["ts_location"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Day Of_week

	if(isset($day_of_week))
	{
		if(strlen($day_of_week) > 250)
			$error_message = $ap_lang["Field"] . " Day Of_week " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Not Working

	if(isset($not_working))
	{
		if(!is_numeric($not_working) && $not_working != "NULL")
			$error_message = $ap_lang["Field"] . " Not Working " . $ap_lang["must be number!"];
		
		if(strlen($not_working) > 11)
			$error_message = $ap_lang["Field"] . " Not Working " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Working From_hours

	if(isset($working_from_hours))
	{
		if(!is_numeric($working_from_hours) && $working_from_hours != "NULL")
			$error_message = $ap_lang["Field"] . " Working From_hours " . $ap_lang["must be number!"];
		
		if(strlen($working_from_hours) > 11)
			$error_message = $ap_lang["Field"] . " Working From_hours " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Working From_minutes

	if(isset($working_from_minutes))
	{
		if(!is_numeric($working_from_minutes) && $working_from_minutes != "NULL")
			$error_message = $ap_lang["Field"] . " Working From_minutes " . $ap_lang["must be number!"];
		
		if(strlen($working_from_minutes) > 11)
			$error_message = $ap_lang["Field"] . " Working From_minutes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Working To_hours

	if(isset($working_to_hours))
	{
		if(!is_numeric($working_to_hours) && $working_to_hours != "NULL")
			$error_message = $ap_lang["Field"] . " Working To_hours " . $ap_lang["must be number!"];
		
		if(strlen($working_to_hours) > 11)
			$error_message = $ap_lang["Field"] . " Working To_hours " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Working To_minutes

	if(isset($working_to_minutes))
	{
		if(!is_numeric($working_to_minutes) && $working_to_minutes != "NULL")
			$error_message = $ap_lang["Field"] . " Working To_minutes " . $ap_lang["must be number!"];
		
		if(strlen($working_to_minutes) > 11)
			$error_message = $ap_lang["Field"] . " Working To_minutes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ts Location

	if(isset($ts_location))
	{
		if(!is_numeric($ts_location) && $ts_location != "NULL")
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be number!"];
		
		if(strlen($ts_location) > 11)
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $working_times->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new working_times();
		$new_object->training_school = $training_school;$new_object->day_of_week = $day_of_week;$new_object->not_working = $not_working;$new_object->working_from_hours = $working_from_hours;$new_object->working_from_minutes = $working_from_minutes;$new_object->working_to_hours = $working_to_hours;$new_object->working_to_minutes = $working_to_minutes;$new_object->ts_location = $ts_location;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"working_times","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$working_times = new working_times();
	foreach($_POST as $key => $value)
		$working_times->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$working_times->checker = $_SESSION[ADMINLOGGEDIN];
	else							$working_times->checker = "";
}
else	unset($working_times);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Working times</h1>
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
<input type="hidden" name="id" value="<?php echo $working_times->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $working_times->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $working_times->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($working_times->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
	<?php }
} ?>
</select>
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
		count_input_limit("day_of_week");
		
	});
</script>
<tr>
<td>Day Of_week <span id="day_of_week_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->day_of_week; 
		}else{ 
	?>
	<input type="text" name="day_of_week" value="<?php echo $working_times->day_of_week; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('day_of_week')">
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
		count_input_limit("not_working");
		
	});
</script>
<tr>
<td>Not Working <span id="not_working_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->not_working; 
		}else{ 
	?>
	<input type="text" name="not_working" value="<?php echo $working_times->not_working; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('not_working')">
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
		count_input_limit("working_from_hours");
		
	});
</script>
<tr>
<td>Working From_hours <span id="working_from_hours_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->working_from_hours; 
		}else{ 
	?>
	<input type="text" name="working_from_hours" value="<?php echo $working_times->working_from_hours; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('working_from_hours')">
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
		count_input_limit("working_from_minutes");
		
	});
</script>
<tr>
<td>Working From_minutes <span id="working_from_minutes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->working_from_minutes; 
		}else{ 
	?>
	<input type="text" name="working_from_minutes" value="<?php echo $working_times->working_from_minutes; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('working_from_minutes')">
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
		count_input_limit("working_to_hours");
		
	});
</script>
<tr>
<td>Working To_hours <span id="working_to_hours_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->working_to_hours; 
		}else{ 
	?>
	<input type="text" name="working_to_hours" value="<?php echo $working_times->working_to_hours; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('working_to_hours')">
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
		count_input_limit("working_to_minutes");
		
	});
</script>
<tr>
<td>Working To_minutes <span id="working_to_minutes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $working_times->working_to_minutes; 
		}else{ 
	?>
	<input type="text" name="working_to_minutes" value="<?php echo $working_times->working_to_minutes; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('working_to_minutes')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Ts Location</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $working_times->ts_location; }else{ ?>
<select name="ts_location" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_location);$i++)
{
	if($all_ts_location[$i]->id == $working_times->ts_location){ ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>" <?php if($working_times->ts_location == $all_ts_location[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_location[$i]->training_school; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>"><?php echo $all_ts_location[$i]->training_school; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($working_times->checker != ""){ ?>
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

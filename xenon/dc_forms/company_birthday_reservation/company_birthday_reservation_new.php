<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - user
require_once "../classes/domain/user.class.php";
$user = new user();
$user->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user->add_condition("recordStatus","=","O");
$user->add_condition("jezik","=",$filter_lang);
$user->set_order_by("email","ASC");
$all_user = $broker->get_all_data_condition($user);//==================== HANDLER FOR DROPMENU EXTENDED - user_card
require_once "../classes/domain/user_card.class.php";
$user_card = new user_card();
$user_card->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user_card->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user_card->add_condition("recordStatus","=","O");
$user_card->add_condition("jezik","=",$filter_lang);
$user_card->set_order_by("card_number","ASC");
$all_user_card = $broker->get_all_data_condition($user_card);//==================== HANDLER FOR DROPMENU EXTENDED - training_school
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
$all_ts_location = $broker->get_all_data_condition($ts_location);//==================== HANDLER FOR DROPMENU EXTENDED - company_birthday_data
require_once "../classes/domain/company_birthday_data.class.php";
$company_birthday_data = new company_birthday_data();
$company_birthday_data->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$company_birthday_data->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$company_birthday_data->add_condition("recordStatus","=","O");
$company_birthday_data->add_condition("jezik","=",$filter_lang);
$company_birthday_data->set_order_by("name","ASC");
$all_company_birthday_data = $broker->get_all_data_condition($company_birthday_data);//==================== HANDLER FOR DROPMENU EXTENDED - company_location_birthday_slots
require_once "../classes/domain/company_location_birthday_slots.class.php";
$company_location_birthday_slots = new company_location_birthday_slots();
$company_location_birthday_slots->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$company_location_birthday_slots->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$company_location_birthday_slots->add_condition("recordStatus","=","O");
$company_location_birthday_slots->add_condition("jezik","=",$filter_lang);
$company_location_birthday_slots->set_order_by("id","ASC");
$all_company_location_birthday_slots = $broker->get_all_data_condition($company_location_birthday_slots);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$user = $_POST["user"];
	$user_card = $_POST["user_card"];
	$training_school = $_POST["training_school"];
	$ts_location = $_POST["ts_location"];
	$birthday_date = explode("/",$_POST["birthday_date"]);
	$birthday_date = $birthday_date[2]."-".$birthday_date[0]."-".$birthday_date[1];
	$_POST["birthday_date"] = $birthday_date;
	$birthday_from_hours = $_POST["birthday_from_hours"];
	$birthday_from_minutes = $_POST["birthday_from_minutes"];
	$birthday_to_hours = $_POST["birthday_to_hours"];
	$birthday_to_minutes = $_POST["birthday_to_minutes"];
	$status = $_POST["status"];
	$comment = $_POST["comment"];
	$number_of_kids = $_POST["number_of_kids"];
	$number_of_adults = $_POST["number_of_adults"];
	$company_birthday_data = $_POST["company_birthday_data"];
	$company_location_birthday_slots = $_POST["company_location_birthday_slots"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User

	if(isset($user))
	{
		if(!is_numeric($user) && $user != "NULL")
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be number!"];
		
		if(strlen($user) > 11)
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User Card

	if(isset($user_card))
	{
		if(!is_numeric($user_card) && $user_card != "NULL")
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be number!"];
		
		if(strlen($user_card) > 11)
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
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
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Birthday From_hours

	if(isset($birthday_from_hours))
	{
		if(!is_numeric($birthday_from_hours) && $birthday_from_hours != "NULL")
			$error_message = $ap_lang["Field"] . " Birthday From_hours " . $ap_lang["must be number!"];
		
		if(strlen($birthday_from_hours) > 11)
			$error_message = $ap_lang["Field"] . " Birthday From_hours " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Birthday From_minutes

	if(isset($birthday_from_minutes))
	{
		if(!is_numeric($birthday_from_minutes) && $birthday_from_minutes != "NULL")
			$error_message = $ap_lang["Field"] . " Birthday From_minutes " . $ap_lang["must be number!"];
		
		if(strlen($birthday_from_minutes) > 11)
			$error_message = $ap_lang["Field"] . " Birthday From_minutes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Birthday To_hours

	if(isset($birthday_to_hours))
	{
		if(!is_numeric($birthday_to_hours) && $birthday_to_hours != "NULL")
			$error_message = $ap_lang["Field"] . " Birthday To_hours " . $ap_lang["must be number!"];
		
		if(strlen($birthday_to_hours) > 11)
			$error_message = $ap_lang["Field"] . " Birthday To_hours " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Birthday To_minutes

	if(isset($birthday_to_minutes))
	{
		if(!is_numeric($birthday_to_minutes) && $birthday_to_minutes != "NULL")
			$error_message = $ap_lang["Field"] . " Birthday To_minutes " . $ap_lang["must be number!"];
		
		if(strlen($birthday_to_minutes) > 11)
			$error_message = $ap_lang["Field"] . " Birthday To_minutes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Status

	if(isset($status))
	{
		if(strlen($status) > 250)
			$error_message = $ap_lang["Field"] . " Status " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - TEXTAREA ELEMENT - Comment
	if(isset($comment))
	{
		if(strlen($comment) > 250)
			$error_message = $ap_lang["Field"] . " Comment " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_kids

	if(isset($number_of_kids))
	{
		if(strlen($number_of_kids) > 250)
			$error_message = $ap_lang["Field"] . " Number Of_kids " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_adults

	if(isset($number_of_adults))
	{
		if(strlen($number_of_adults) > 250)
			$error_message = $ap_lang["Field"] . " Number Of_adults " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Birthday_data

	if(isset($company_birthday_data))
	{
		if(!is_numeric($company_birthday_data) && $company_birthday_data != "NULL")
			$error_message = $ap_lang["Field"] . " Company Birthday_data " . $ap_lang["must be number!"];
		
		if(strlen($company_birthday_data) > 11)
			$error_message = $ap_lang["Field"] . " Company Birthday_data " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Location_birthday_slots

	if(isset($company_location_birthday_slots))
	{
		if(!is_numeric($company_location_birthday_slots) && $company_location_birthday_slots != "NULL")
			$error_message = $ap_lang["Field"] . " Company Location_birthday_slots " . $ap_lang["must be number!"];
		
		if(strlen($company_location_birthday_slots) > 11)
			$error_message = $ap_lang["Field"] . " Company Location_birthday_slots " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $company_birthday_reservation->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new company_birthday_reservation();
		$new_object->user = $user;$new_object->user_card = $user_card;$new_object->training_school = $training_school;$new_object->ts_location = $ts_location;$new_object->birthday_date = $birthday_date;$new_object->birthday_from_hours = $birthday_from_hours;$new_object->birthday_from_minutes = $birthday_from_minutes;$new_object->birthday_to_hours = $birthday_to_hours;$new_object->birthday_to_minutes = $birthday_to_minutes;$new_object->status = $status;$new_object->comment = $comment;$new_object->number_of_kids = $number_of_kids;$new_object->number_of_adults = $number_of_adults;$new_object->company_birthday_data = $company_birthday_data;$new_object->company_location_birthday_slots = $company_location_birthday_slots;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_birthday_reservation","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$company_birthday_reservation = new company_birthday_reservation();
	foreach($_POST as $key => $value)
		$company_birthday_reservation->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	$birthday_date = explode("-",$company_birthday_reservation->birthday_date);
	$company_birthday_reservation->birthday_date = $birthday_date[1]."/".$birthday_date[2]."/".$birthday_date[0];
	
	if(isset($_POST["promote"]))	$company_birthday_reservation->checker = $_SESSION[ADMINLOGGEDIN];
	else							$company_birthday_reservation->checker = "";
}
else	unset($company_birthday_reservation);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Company birthday reservation</h1>
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
<input type="hidden" name="id" value="<?php echo $company_birthday_reservation->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->user; }else{ ?>
<select name="user" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user);$i++)
{
	if($all_user[$i]->id == $company_birthday_reservation->user){ ?>
	<option value="<?php echo $all_user[$i]->id; ?>" <?php if($company_birthday_reservation->user == $all_user[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user[$i]->email; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_user[$i]->id; ?>"><?php echo $all_user[$i]->email; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User Card</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->user_card; }else{ ?>
<select name="user_card" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user_card);$i++)
{
	if($all_user_card[$i]->id == $company_birthday_reservation->user_card){ ?>
	<option value="<?php echo $all_user_card[$i]->id; ?>" <?php if($company_birthday_reservation->user_card == $all_user_card[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user_card[$i]->card_number; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_user_card[$i]->id; ?>"><?php echo $all_user_card[$i]->card_number; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $company_birthday_reservation->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($company_birthday_reservation->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
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
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->ts_location; }else{ ?>
<select name="ts_location" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_location);$i++)
{
	if($all_ts_location[$i]->id == $company_birthday_reservation->ts_location){ ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>" <?php if($company_birthday_reservation->ts_location == $all_ts_location[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_location[$i]->id; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>"><?php echo $all_ts_location[$i]->id; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE DATEPICKER-->
<link rel="stylesheet" type="text/css" href="js/datepicker/css/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="js/datepicker/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	$(function() {
		$("#birthday_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>Birthday Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($company_birthday_reservation->birthday_date)); }else{ ?>
<input type="text" name="birthday_date" id="birthday_date" value="<?php if($company_birthday_reservation->birthday_date == "" || $company_birthday_reservation->birthday_date == NULL){ echo date('m/d/Y'); } else{ echo $company_birthday_reservation->birthday_date; } ?>" />
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
		count_input_limit("birthday_from_hours");
		
	});
</script>
<tr>
<td>Birthday From_hours <span id="birthday_from_hours_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->birthday_from_hours; 
		}else{ 
	?>
	<input type="text" name="birthday_from_hours" value="<?php echo $company_birthday_reservation->birthday_from_hours; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_from_hours')">
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
		count_input_limit("birthday_from_minutes");
		
	});
</script>
<tr>
<td>Birthday From_minutes <span id="birthday_from_minutes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->birthday_from_minutes; 
		}else{ 
	?>
	<input type="text" name="birthday_from_minutes" value="<?php echo $company_birthday_reservation->birthday_from_minutes; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_from_minutes')">
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
		count_input_limit("birthday_to_hours");
		
	});
</script>
<tr>
<td>Birthday To_hours <span id="birthday_to_hours_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->birthday_to_hours; 
		}else{ 
	?>
	<input type="text" name="birthday_to_hours" value="<?php echo $company_birthday_reservation->birthday_to_hours; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_to_hours')">
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
		count_input_limit("birthday_to_minutes");
		
	});
</script>
<tr>
<td>Birthday To_minutes <span id="birthday_to_minutes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->birthday_to_minutes; 
		}else{ 
	?>
	<input type="text" name="birthday_to_minutes" value="<?php echo $company_birthday_reservation->birthday_to_minutes; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_to_minutes')">
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
		count_input_limit("status");
		
	});
</script>
<tr>
<td>Status <span id="status_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->status; 
		}else{ 
	?>
	<input type="text" name="status" value="<?php echo $company_birthday_reservation->status; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('status')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Comment</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->comment; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="comment" rows="5" style="width:600px;height:px;background-color:#FFF;border:1px;"><?php echo stripslashes($company_birthday_reservation->comment); ?></textarea>
</div>
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
		count_input_limit("number_of_kids");
		
	});
</script>
<tr>
<td>Number Of_kids <span id="number_of_kids_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->number_of_kids; 
		}else{ 
	?>
	<input type="text" name="number_of_kids" value="<?php echo $company_birthday_reservation->number_of_kids; ?>" style="width:200px;" limit="250" onkeyup="count_input_limit('number_of_kids')">
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
		count_input_limit("number_of_adults");
		
	});
</script>
<tr>
<td>Number Of_adults <span id="number_of_adults_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_birthday_reservation->number_of_adults; 
		}else{ 
	?>
	<input type="text" name="number_of_adults" value="<?php echo $company_birthday_reservation->number_of_adults; ?>" style="width:200px;" limit="250" onkeyup="count_input_limit('number_of_adults')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Company Birthday_data</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->company_birthday_data; }else{ ?>
<select name="company_birthday_data" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_company_birthday_data);$i++)
{
	if($all_company_birthday_data[$i]->id == $company_birthday_reservation->company_birthday_data){ ?>
	<option value="<?php echo $all_company_birthday_data[$i]->id; ?>" <?php if($company_birthday_reservation->company_birthday_data == $all_company_birthday_data[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_company_birthday_data[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_company_birthday_data[$i]->id; ?>"><?php echo $all_company_birthday_data[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Company Location_birthday_slots</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_birthday_reservation->company_location_birthday_slots; }else{ ?>
<select name="company_location_birthday_slots" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_company_location_birthday_slots);$i++)
{
	if($all_company_location_birthday_slots[$i]->id == $company_birthday_reservation->company_location_birthday_slots){ ?>
	<option value="<?php echo $all_company_location_birthday_slots[$i]->id; ?>" <?php if($company_birthday_reservation->company_location_birthday_slots == $all_company_location_birthday_slots[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_company_location_birthday_slots[$i]->id; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_company_location_birthday_slots[$i]->id; ?>"><?php echo $all_company_location_birthday_slots[$i]->id; ?></option>
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
	<?php if($company_birthday_reservation->checker != ""){ ?>
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

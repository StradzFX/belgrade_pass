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
$company_events = $broker->get_data(new company_events($_GET["id"]));

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
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $company_events->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$event_date = explode("/",$_POST["event_date"]);
	$event_date = $event_date[2]."-".$event_date[0]."-".$event_date[1];
	$_POST["event_date"] = $event_date;
	$event_time_from = $_POST["event_time_from"];
	$event_time_to = $_POST["event_time_to"];
	$event_type = $_POST["event_type"];
	$event_name = $_POST["event_name"];
	$event_horus_from = $_POST["event_horus_from"];
	$event_hours_to = $_POST["event_hours_to"];
	$event_minutes_from = $_POST["event_minutes_from"];
	$event_minutes_to = $_POST["event_minutes_to"];
	$ts_location = $_POST["ts_location"];
	$company_birthday_data = $_POST["company_birthday_data"];
	$company_location_birthday_slots = $_POST["company_location_birthday_slots"];
	$event_global_type = $_POST["event_global_type"];
	
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
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Time_from

	if(isset($event_time_from))
	{
		if(!is_numeric($event_time_from) && $event_time_from != "NULL")
			$error_message = $ap_lang["Field"] . " Event Time_from " . $ap_lang["must be number!"];
		
		if(strlen($event_time_from) > 11)
			$error_message = $ap_lang["Field"] . " Event Time_from " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Time_to

	if(isset($event_time_to))
	{
		if(!is_numeric($event_time_to) && $event_time_to != "NULL")
			$error_message = $ap_lang["Field"] . " Event Time_to " . $ap_lang["must be number!"];
		
		if(strlen($event_time_to) > 11)
			$error_message = $ap_lang["Field"] . " Event Time_to " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Type

	if(isset($event_type))
	{
		if(strlen($event_type) > 250)
			$error_message = $ap_lang["Field"] . " Event Type " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Name

	if(isset($event_name))
	{
		if(strlen($event_name) > 250)
			$error_message = $ap_lang["Field"] . " Event Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Horus_from

	if(isset($event_horus_from))
	{
		if(strlen($event_horus_from) > 250)
			$error_message = $ap_lang["Field"] . " Event Horus_from " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Hours_to

	if(isset($event_hours_to))
	{
		if(strlen($event_hours_to) > 250)
			$error_message = $ap_lang["Field"] . " Event Hours_to " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Minutes_from

	if(isset($event_minutes_from))
	{
		if(strlen($event_minutes_from) > 250)
			$error_message = $ap_lang["Field"] . " Event Minutes_from " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Minutes_to

	if(isset($event_minutes_to))
	{
		if(strlen($event_minutes_to) > 250)
			$error_message = $ap_lang["Field"] . " Event Minutes_to " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ts Location

	if(isset($ts_location))
	{
		if(!is_numeric($ts_location) && $ts_location != "NULL")
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be number!"];
		
		if(strlen($ts_location) > 11)
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Event Global_type

	if(isset($event_global_type))
	{
		if(strlen($event_global_type) > 250)
			$error_message = $ap_lang["Field"] . " Event Global_type " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//=================================================================================================
//================ ERROR HANDLER FOR VARIABLES - END ==============================================
//=================================================================================================
	
	if($error_message == "")
	{
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
			$checkerDate = $company_events->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new company_events($id,$training_school,$event_date,$event_time_from,$event_time_to,$event_type,$event_name,$event_horus_from,$event_hours_to,$event_minutes_from,$event_minutes_to,$ts_location,$company_birthday_data,$company_location_birthday_slots,$event_global_type,$company_events->maker,$company_events->makerDate,$checker,$checkerDate,$company_events->pozicija,$company_events->jezik,$company_events->recordStatus,$company_events->modNumber+1,$company_events->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_events","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$company_events = $broker->get_data(new company_events($_GET["id"]));
foreach($company_events as $key => $value)
	$company_events->$key = htmlentities($company_events->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$company_events->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

$event_date = explode("-",$company_events->event_date);
$company_events->event_date = $event_date[1]."/".$event_date[2]."/".$event_date[0];

if(isset($_POST["promote"]) && $company_events->checker == "")	
	$company_events->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Company periods</h1>
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
<input type="hidden" name="id" value="<?php echo $company_events->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_events->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $company_events->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($company_events->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
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
		$("#event_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>Event Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($company_events->event_date)); }else{ ?>
<input type="text" name="event_date" id="event_date" value="<?php if($company_events->event_date == "" || $company_events->event_date == NULL){ echo date('m/d/Y'); } else{ echo $company_events->event_date; } ?>" />
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
		count_input_limit("event_time_from");
		
	});
</script>
<tr>
<td>Event Time_from <span id="event_time_from_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_time_from; 
		}else{ 
	?>
	<input type="text" name="event_time_from" value="<?php echo $company_events->event_time_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('event_time_from')">
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
		count_input_limit("event_time_to");
		
	});
</script>
<tr>
<td>Event Time_to <span id="event_time_to_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_time_to; 
		}else{ 
	?>
	<input type="text" name="event_time_to" value="<?php echo $company_events->event_time_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('event_time_to')">
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
		count_input_limit("event_type");
		
	});
</script>
<tr>
<td>Event Type <span id="event_type_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_type; 
		}else{ 
	?>
	<input type="text" name="event_type" value="<?php echo $company_events->event_type; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_type')">
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
		count_input_limit("event_name");
		
	});
</script>
<tr>
<td>Event Name <span id="event_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_name; 
		}else{ 
	?>
	<input type="text" name="event_name" value="<?php echo $company_events->event_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_name')">
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
		count_input_limit("event_horus_from");
		
	});
</script>
<tr>
<td>Event Horus_from <span id="event_horus_from_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_horus_from; 
		}else{ 
	?>
	<input type="text" name="event_horus_from" value="<?php echo $company_events->event_horus_from; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_horus_from')">
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
		count_input_limit("event_hours_to");
		
	});
</script>
<tr>
<td>Event Hours_to <span id="event_hours_to_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_hours_to; 
		}else{ 
	?>
	<input type="text" name="event_hours_to" value="<?php echo $company_events->event_hours_to; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_hours_to')">
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
		count_input_limit("event_minutes_from");
		
	});
</script>
<tr>
<td>Event Minutes_from <span id="event_minutes_from_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_minutes_from; 
		}else{ 
	?>
	<input type="text" name="event_minutes_from" value="<?php echo $company_events->event_minutes_from; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_minutes_from')">
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
		count_input_limit("event_minutes_to");
		
	});
</script>
<tr>
<td>Event Minutes_to <span id="event_minutes_to_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_minutes_to; 
		}else{ 
	?>
	<input type="text" name="event_minutes_to" value="<?php echo $company_events->event_minutes_to; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_minutes_to')">
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
		count_input_limit("ts_location");
		
	});
</script>
<tr>
<td>Ts Location <span id="ts_location_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->ts_location; 
		}else{ 
	?>
	<input type="text" name="ts_location" value="<?php echo $company_events->ts_location; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('ts_location')">
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
		count_input_limit("company_birthday_data");
		
	});
</script>
<tr>
<td>Company Birthday_data <span id="company_birthday_data_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->company_birthday_data; 
		}else{ 
	?>
	<input type="text" name="company_birthday_data" value="<?php echo $company_events->company_birthday_data; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_birthday_data')">
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
		count_input_limit("company_location_birthday_slots");
		
	});
</script>
<tr>
<td>Company Location_birthday_slots <span id="company_location_birthday_slots_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->company_location_birthday_slots; 
		}else{ 
	?>
	<input type="text" name="company_location_birthday_slots" value="<?php echo $company_events->company_location_birthday_slots; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_location_birthday_slots')">
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
		count_input_limit("event_global_type");
		
	});
</script>
<tr>
<td>Event Global_type <span id="event_global_type_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_events->event_global_type; 
		}else{ 
	?>
	<input type="text" name="event_global_type" value="<?php echo $company_events->event_global_type; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('event_global_type')">
	<?php } ?>
</td>
</tr>	
<?php if($company_events->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_events->maker; ?> (<?php  echo $company_events->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_events->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_events->checker; ?> (<?php  echo $company_events->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_events->checker != ""){ ?>
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

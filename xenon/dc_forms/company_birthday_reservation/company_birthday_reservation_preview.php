<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/company_birthday_reservation.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$company_birthday_reservation = $broker->get_data(new company_birthday_reservation($_GET["id"]));

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
$company_birthday_reservation = $broker->get_data(new company_birthday_reservation($_GET["id"]));
require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($company_birthday_reservation->user));
$company_birthday_reservation->user = $user->email;

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($company_birthday_reservation->user_card));
$company_birthday_reservation->user_card = $user_card->card_number;

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($company_birthday_reservation->training_school));
$company_birthday_reservation->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($company_birthday_reservation->ts_location));
$company_birthday_reservation->ts_location = $ts_location->id;

require_once "../classes/domain/company_birthday_data.class.php";
$company_birthday_data = $broker->get_data(new company_birthday_data($company_birthday_reservation->company_birthday_data));
$company_birthday_reservation->company_birthday_data = $company_birthday_data->name;

require_once "../classes/domain/company_location_birthday_slots.class.php";
$company_location_birthday_slots = $broker->get_data(new company_location_birthday_slots($company_birthday_reservation->company_location_birthday_slots));
$company_birthday_reservation->company_location_birthday_slots = $company_location_birthday_slots->id;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_user"]) 		$filter_user = $_GET["filter_user"];
else							$filter_user = "all";
if($_GET["filter_user_card"]) 		$filter_user_card = $_GET["filter_user_card"];
else							$filter_user_card = "all";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";
if($_GET["filter_ts_location"]) 		$filter_ts_location = $_GET["filter_ts_location"];
else							$filter_ts_location = "all";
if($_GET["filter_company_birthday_data"]) 		$filter_company_birthday_data = $_GET["filter_company_birthday_data"];
else							$filter_company_birthday_data = "all";
if($_GET["filter_company_location_birthday_slots"]) 		$filter_company_location_birthday_slots = $_GET["filter_company_location_birthday_slots"];
else							$filter_company_location_birthday_slots = "all";

$dc_objects = new company_birthday_reservation();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("status","LIKE","%".$search."%","OR");
	$array_som[] = array("comment","LIKE","%".$search."%","OR");
	$array_som[] = array("number_of_kids","LIKE","%".$search."%","OR");
	$array_som[] = array("number_of_adults","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("user_card","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
		$array_som[] = array("ts_location","=",$search,"OR");
		$array_som[] = array("birthday_from_hours","=",$search,"OR");
		$array_som[] = array("birthday_from_minutes","=",$search,"OR");
		$array_som[] = array("birthday_to_hours","=",$search,"OR");
		$array_som[] = array("birthday_to_minutes","=",$search,"OR");
		$array_som[] = array("company_birthday_data","=",$search,"OR");
		$array_som[] = array("company_location_birthday_slots","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_user != "all" && $filter_user != "")
	$dc_objects->add_condition("user","=",$filter_user);	

if($filter_user_card != "all" && $filter_user_card != "")
	$dc_objects->add_condition("user_card","=",$filter_user_card);	

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_ts_location != "all" && $filter_ts_location != "")
	$dc_objects->add_condition("ts_location","=",$filter_ts_location);	

if($filter_status != "all" && $filter_status != "")
	$dc_objects->add_condition("status","=",$filter_status);

if($filter_comment != "all" && $filter_comment != "")
	$dc_objects->add_condition("comment","=",$filter_comment);

if($filter_number_of_kids != "all" && $filter_number_of_kids != "")
	$dc_objects->add_condition("number_of_kids","=",$filter_number_of_kids);

if($filter_number_of_adults != "all" && $filter_number_of_adults != "")
	$dc_objects->add_condition("number_of_adults","=",$filter_number_of_adults);

if($filter_company_birthday_data != "all" && $filter_company_birthday_data != "")
	$dc_objects->add_condition("company_birthday_data","=",$filter_company_birthday_data);	

if($filter_company_location_birthday_slots != "all" && $filter_company_location_birthday_slots != "")
	$dc_objects->add_condition("company_location_birthday_slots","=",$filter_company_location_birthday_slots);	

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new company_birthday_reservation();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new company_birthday_reservation();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$company_birthday_reservation->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new company_birthday_reservation();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$company_birthday_reservation->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new company_birthday_reservation();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Company birthday reservation</h1>
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
<?php if($company_birthday_reservation->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_birthday_reservation->maker; ?> (<?php  echo $company_birthday_reservation->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_birthday_reservation->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_birthday_reservation->checker; ?> (<?php  echo $company_birthday_reservation->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

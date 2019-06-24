<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/working_times.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$working_times = $broker->get_data(new working_times($_GET["id"]));

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
$working_times = $broker->get_data(new working_times($_GET["id"]));
require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($working_times->training_school));
$working_times->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($working_times->ts_location));
$working_times->ts_location = $ts_location->training_school;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";
if($_GET["filter_ts_location"]) 		$filter_ts_location = $_GET["filter_ts_location"];
else							$filter_ts_location = "all";

$dc_objects = new working_times();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("day_of_week","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
		$array_som[] = array("not_working","=",$search,"OR");
		$array_som[] = array("working_from_hours","=",$search,"OR");
		$array_som[] = array("working_from_minutes","=",$search,"OR");
		$array_som[] = array("working_to_hours","=",$search,"OR");
		$array_som[] = array("working_to_minutes","=",$search,"OR");
		$array_som[] = array("ts_location","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_day_of_week != "all" && $filter_day_of_week != "")
	$dc_objects->add_condition("day_of_week","=",$filter_day_of_week);

if($filter_ts_location != "all" && $filter_ts_location != "")
	$dc_objects->add_condition("ts_location","=",$filter_ts_location);	

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new working_times();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new working_times();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$working_times->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new working_times();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$working_times->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new working_times();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Working times</h1>
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
<?php if($working_times->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $working_times->maker; ?> (<?php  echo $working_times->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($working_times->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $working_times->checker; ?> (<?php  echo $working_times->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

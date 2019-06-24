<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/cl_pass_rules.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$cl_pass_rules = $broker->get_data(new cl_pass_rules($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
//==================== HANDLER FOR DROPMENU PARENT - training_school
require_once "../classes/domain/training_school.class.php";
$training_school = new training_school();
$training_school->set_condition("checker","!=","");
$training_school->add_condition("recordStatus","=","O");
$training_school->add_condition("jezik","=",$filter_lang);
$training_school->set_order_by("name","ASC");
$all_training_school = $broker->get_all_data_condition($training_school);
//==================== HANDLER FOR DROPMENU PARENT - ts_location
if($_POST["training_school"] == NULL){
	if($cl_pass_rules->training_school == ""){
		$cl_pass_rules->training_school = "NULL";
	}
	$_POST["training_school"] = $cl_pass_rules->training_school;
}
require_once "../classes/domain/ts_location.class.php";
$ts_location = new ts_location();
$ts_location->set_condition("checker","!=","");
$ts_location->add_condition("recordStatus","=","O");
$ts_location->add_condition("jezik","=",$filter_lang);
if($_GET["action"] != "new")
	$ts_location->add_condition("training_school","=",$_POST["training_school"]);
$ts_location->set_order_by("part_of_city","ASC");
$all_ts_location = $broker->get_all_data_condition($ts_location);
$cl_pass_rules = $broker->get_data(new cl_pass_rules($_GET["id"]));
require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($cl_pass_rules->training_school));
$cl_pass_rules->training_school = $training_school->name;

require_once "../classes/domain/ts_location.class.php";
$ts_location = $broker->get_data(new ts_location($cl_pass_rules->ts_location));
$cl_pass_rules->ts_location = $ts_location->part_of_city;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";
if($_GET["filter_ts_location"]) 		$filter_ts_location = $_GET["filter_ts_location"];
else							$filter_ts_location = "all";

$dc_objects = new cl_pass_rules();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
		$array_som[] = array("ts_location","=",$search,"OR");
		$array_som[] = array("hours_from","=",$search,"OR");
		$array_som[] = array("minutes_from","=",$search,"OR");
		$array_som[] = array("hours_to","=",$search,"OR");
		$array_som[] = array("minutes_to","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_ts_location != "all" && $filter_ts_location != "")
	$dc_objects->add_condition("ts_location","=",$filter_ts_location);	

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new cl_pass_rules();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new cl_pass_rules();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$cl_pass_rules->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new cl_pass_rules();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$cl_pass_rules->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new cl_pass_rules();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - cl_pass_rules</h1>
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
<input type="hidden" name="id" value="<?php echo $cl_pass_rules->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUPARENT-->
	
<script language="javascript">
$(function() {
<?php if($_GET["action"] == "new"){ ?>
	get_children('training_school','ts_location','id','part_of_city');
<?php } ?>
});
function get_children(parent,child,child_id,child_name){
	var parent_value = $("[name="+parent+"]").val();
	var child_value = $("[name="+child+"]").val();
	var cur_language = "<?php echo $filter_lang; ?>";
	$.ajax({
		type: "POST",
		url: "js/parent.php",
		data:{
			parent:parent,
			parent_value:parent_value,
			child:child,
			child_id:child_id,
			child_name:child_name,
			child_value:child_value,
			cur_language:cur_language
		},
		cache:false,
		success: function(result)
		{
			$("[name="+child+"]").html(result);
			$("[name="+child+"]").change();
		},
		error:function (xhr, ajaxOptions, thrownError){
       		alert(xhr.status);
        	alert(thrownError);
        }    
	});
}
</script>
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $cl_pass_rules->training_school; }else{ ?>
<select name="training_school" style="width:600px;" onchange="javascript:get_children('training_school','ts_location','id','part_of_city');">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $cl_pass_rules->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($cl_pass_rules->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUPARENT-->
			
<tr>
<td>Ts Location</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $cl_pass_rules->ts_location; }else{ ?>

<select name="ts_location" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_location);$i++)
{
	if($all_ts_location[$i]->id == $cl_pass_rules->ts_location){ ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>" <?php if($cl_pass_rules->ts_location == $all_ts_location[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_location[$i]->part_of_city; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>"><?php echo $all_ts_location[$i]->part_of_city; ?></option>
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
		count_input_limit("hours_from");
		
	});
</script>
<tr>
<td>Hours From <span id="hours_from_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $cl_pass_rules->hours_from; 
		}else{ 
	?>
	<input type="text" name="hours_from" value="<?php echo $cl_pass_rules->hours_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_from')">
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
		count_input_limit("minutes_from");
		
	});
</script>
<tr>
<td>Minutes From <span id="minutes_from_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $cl_pass_rules->minutes_from; 
		}else{ 
	?>
	<input type="text" name="minutes_from" value="<?php echo $cl_pass_rules->minutes_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_from')">
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
		count_input_limit("hours_to");
		
	});
</script>
<tr>
<td>Hours To <span id="hours_to_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $cl_pass_rules->hours_to; 
		}else{ 
	?>
	<input type="text" name="hours_to" value="<?php echo $cl_pass_rules->hours_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_to')">
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
		count_input_limit("minutes_to");
		
	});
</script>
<tr>
<td>Minutes To <span id="minutes_to_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $cl_pass_rules->minutes_to; 
		}else{ 
	?>
	<input type="text" name="minutes_to" value="<?php echo $cl_pass_rules->minutes_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_to')">
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
		count_input_limit("pass_per_kid");
		
	});
</script>
<tr>
<td>Pass Per_kid <span id="pass_per_kid_counter" style="color:#999">(11,1)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $cl_pass_rules->pass_per_kid; 
		}else{ 
	?>
	<input type="text" name="pass_per_kid" value="<?php echo $cl_pass_rules->pass_per_kid; ?>" style="width:600px;" limit="11,1" onkeyup="count_input_limit('pass_per_kid')">
	<?php } ?>
</td>
</tr>	
<?php if($cl_pass_rules->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $cl_pass_rules->maker; ?> (<?php  echo $cl_pass_rules->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($cl_pass_rules->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $cl_pass_rules->checker; ?> (<?php  echo $cl_pass_rules->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

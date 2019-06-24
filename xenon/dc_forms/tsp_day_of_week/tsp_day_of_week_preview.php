<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/tsp_day_of_week.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - ts_programm
require_once "../classes/domain/ts_programm.class.php";
$ts_programm = new ts_programm();
$ts_programm->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$ts_programm->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$ts_programm->add_condition("recordStatus","=","O");
$ts_programm->add_condition("jezik","=",$filter_lang);
$ts_programm->set_order_by("name","ASC");
$all_ts_programm = $broker->get_all_data_condition($ts_programm);//==================== HANDLER FOR DROPMENU EXTENDED - trainer
require_once "../classes/domain/trainer.class.php";
$trainer = new trainer();
$trainer->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$trainer->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$trainer->add_condition("recordStatus","=","O");
$trainer->add_condition("jezik","=",$filter_lang);
$trainer->set_order_by("first_name","ASC");
$all_trainer = $broker->get_all_data_condition($trainer);
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($_GET["id"]));
require_once "../classes/domain/ts_programm.class.php";
$ts_programm = $broker->get_data(new ts_programm($tsp_day_of_week->ts_programm));
$tsp_day_of_week->ts_programm = $ts_programm->name;

require_once "../classes/domain/trainer.class.php";
$trainer = $broker->get_data(new trainer($tsp_day_of_week->trainer));
$tsp_day_of_week->trainer = $trainer->first_name;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_ts_programm"]) 		$filter_ts_programm = $_GET["filter_ts_programm"];
else							$filter_ts_programm = "all";
if($_GET["filter_trainer"]) 		$filter_trainer = $_GET["filter_trainer"];
else							$filter_trainer = "all";

$dc_objects = new tsp_day_of_week();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("name","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("ts_programm","=",$search,"OR");
		$array_som[] = array("day_of_week","=",$search,"OR");
		$array_som[] = array("trainer","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_ts_programm != "all" && $filter_ts_programm != "")
	$dc_objects->add_condition("ts_programm","=",$filter_ts_programm);	

if($filter_name != "all" && $filter_name != "")
	$dc_objects->add_condition("name","=",$filter_name);

if($filter_trainer != "all" && $filter_trainer != "")
	$dc_objects->add_condition("trainer","=",$filter_trainer);	

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new tsp_day_of_week();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new tsp_day_of_week();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$tsp_day_of_week->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new tsp_day_of_week();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$tsp_day_of_week->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new tsp_day_of_week();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - TSP day of week</h1>
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
<input type="hidden" name="id" value="<?php echo $tsp_day_of_week->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Ts Programm</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $tsp_day_of_week->ts_programm; }else{ ?>
<select name="ts_programm" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_programm);$i++)
{
	if($all_ts_programm[$i]->id == $tsp_day_of_week->ts_programm){ ?>
	<option value="<?php echo $all_ts_programm[$i]->id; ?>" <?php if($tsp_day_of_week->ts_programm == $all_ts_programm[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_programm[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_programm[$i]->id; ?>"><?php echo $all_ts_programm[$i]->name; ?></option>
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
		count_input_limit("name");
		
	});
</script>
<tr>
<td>Name <span id="name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tsp_day_of_week->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $tsp_day_of_week->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
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
<td>Day Of_week <span id="day_of_week_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tsp_day_of_week->day_of_week; 
		}else{ 
	?>
	<input type="text" name="day_of_week" value="<?php echo $tsp_day_of_week->day_of_week; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('day_of_week')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Trainer</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $tsp_day_of_week->trainer; }else{ ?>
<select name="trainer" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_trainer);$i++)
{
	if($all_trainer[$i]->id == $tsp_day_of_week->trainer){ ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>" <?php if($tsp_day_of_week->trainer == $all_trainer[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>"><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>	
<?php if($tsp_day_of_week->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $tsp_day_of_week->maker; ?> (<?php  echo $tsp_day_of_week->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($tsp_day_of_week->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $tsp_day_of_week->checker; ?> (<?php  echo $tsp_day_of_week->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

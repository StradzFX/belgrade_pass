<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/tspd_periods.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$tspd_periods = $broker->get_data(new tspd_periods($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - tsp_day_of_week
require_once "../classes/domain/tsp_day_of_week.class.php";
$tsp_day_of_week = new tsp_day_of_week();
$tsp_day_of_week->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$tsp_day_of_week->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$tsp_day_of_week->add_condition("recordStatus","=","O");
$tsp_day_of_week->add_condition("jezik","=",$filter_lang);
$tsp_day_of_week->set_order_by("id","ASC");
$all_tsp_day_of_week = $broker->get_all_data_condition($tsp_day_of_week);
$tspd_periods = $broker->get_data(new tspd_periods($_GET["id"]));
require_once "../classes/domain/tsp_day_of_week.class.php";
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($tspd_periods->tsp_day_of_week));
$tspd_periods->tsp_day_of_week = $tsp_day_of_week->id;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_tsp_day_of_week"]) 		$filter_tsp_day_of_week = $_GET["filter_tsp_day_of_week"];
else							$filter_tsp_day_of_week = "all";

$dc_objects = new tspd_periods();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("ccy","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("tsp_day_of_week","=",$search,"OR");
		$array_som[] = array("time_from","=",$search,"OR");
		$array_som[] = array("time_to","=",$search,"OR");
		$array_som[] = array("price","=",$search,"OR");
		$array_som[] = array("trainer","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_tsp_day_of_week != "all" && $filter_tsp_day_of_week != "")
	$dc_objects->add_condition("tsp_day_of_week","=",$filter_tsp_day_of_week);	

if($filter_ccy != "all" && $filter_ccy != "")
	$dc_objects->add_condition("ccy","=",$filter_ccy);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new tspd_periods();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new tspd_periods();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$tspd_periods->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new tspd_periods();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$tspd_periods->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new tspd_periods();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - TSPD Periods</h1>
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
<input type="hidden" name="id" value="<?php echo $tspd_periods->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Tsp Day_of_week</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $tspd_periods->tsp_day_of_week; }else{ ?>
<select name="tsp_day_of_week" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_tsp_day_of_week);$i++)
{
	if($all_tsp_day_of_week[$i]->id == $tspd_periods->tsp_day_of_week){ ?>
	<option value="<?php echo $all_tsp_day_of_week[$i]->id; ?>" <?php if($tspd_periods->tsp_day_of_week == $all_tsp_day_of_week[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_tsp_day_of_week[$i]->id; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_tsp_day_of_week[$i]->id; ?>"><?php echo $all_tsp_day_of_week[$i]->id; ?></option>
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
		count_input_limit("time_from");
		
	});
</script>
<tr>
<td>Time From <span id="time_from_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tspd_periods->time_from; 
		}else{ 
	?>
	<input type="text" name="time_from" value="<?php echo $tspd_periods->time_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('time_from')">
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
		count_input_limit("time_to");
		
	});
</script>
<tr>
<td>Time To <span id="time_to_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tspd_periods->time_to; 
		}else{ 
	?>
	<input type="text" name="time_to" value="<?php echo $tspd_periods->time_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('time_to')">
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
			echo $tspd_periods->price; 
		}else{ 
	?>
	<input type="text" name="price" value="<?php echo $tspd_periods->price; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('price')">
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
		count_input_limit("ccy");
		
	});
</script>
<tr>
<td>Ccy <span id="ccy_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tspd_periods->ccy; 
		}else{ 
	?>
	<input type="text" name="ccy" value="<?php echo $tspd_periods->ccy; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('ccy')">
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
		count_input_limit("trainer");
		
	});
</script>
<tr>
<td>Trainer <span id="trainer_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tspd_periods->trainer; 
		}else{ 
	?>
	<input type="text" name="trainer" value="<?php echo $tspd_periods->trainer; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('trainer')">
	<?php } ?>
</td>
</tr>	
<?php if($tspd_periods->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $tspd_periods->maker; ?> (<?php  echo $tspd_periods->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($tspd_periods->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $tspd_periods->checker; ?> (<?php  echo $tspd_periods->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

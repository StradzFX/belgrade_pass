<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


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
if($_POST["submit-new"]){

$id = $_POST["id"];
	$tsp_day_of_week = $_POST["tsp_day_of_week"];
	$time_from = $_POST["time_from"];
	$time_to = $_POST["time_to"];
	$price = $_POST["price"];
	$ccy = $_POST["ccy"];
	$trainer = $_POST["trainer"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Tsp Day_of_week

	if(isset($tsp_day_of_week))
	{
		if(!is_numeric($tsp_day_of_week) && $tsp_day_of_week != "NULL")
			$error_message = $ap_lang["Field"] . " Tsp Day_of_week " . $ap_lang["must be number!"];
		
		if(strlen($tsp_day_of_week) > 11)
			$error_message = $ap_lang["Field"] . " Tsp Day_of_week " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Time From

	if(isset($time_from))
	{
		if(!is_numeric($time_from) && $time_from != "NULL")
			$error_message = $ap_lang["Field"] . " Time From " . $ap_lang["must be number!"];
		
		if(strlen($time_from) > 11)
			$error_message = $ap_lang["Field"] . " Time From " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Time To

	if(isset($time_to))
	{
		if(!is_numeric($time_to) && $time_to != "NULL")
			$error_message = $ap_lang["Field"] . " Time To " . $ap_lang["must be number!"];
		
		if(strlen($time_to) > 11)
			$error_message = $ap_lang["Field"] . " Time To " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Price

	if(isset($price))
	{
		if(!is_numeric($price) && $price != "NULL")
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be number!"];
		
		if(strlen($price) > 11)
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ccy

	if(isset($ccy))
	{
		if(strlen($ccy) > 250)
			$error_message = $ap_lang["Field"] . " Ccy " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Trainer

	if(isset($trainer))
	{
		if(!is_numeric($trainer) && $trainer != "NULL")
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be number!"];
		
		if(strlen($trainer) > 11)
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $tspd_periods->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new tspd_periods();
		$new_object->tsp_day_of_week = $tsp_day_of_week;$new_object->time_from = $time_from;$new_object->time_to = $time_to;$new_object->price = $price;$new_object->ccy = $ccy;$new_object->trainer = $trainer;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"tspd_periods","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$tspd_periods = new tspd_periods();
	foreach($_POST as $key => $value)
		$tspd_periods->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$tspd_periods->checker = $_SESSION[ADMINLOGGEDIN];
	else							$tspd_periods->checker = "";
}
else	unset($tspd_periods);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - TSPD Periods</h1>
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
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($tspd_periods->checker != ""){ ?>
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

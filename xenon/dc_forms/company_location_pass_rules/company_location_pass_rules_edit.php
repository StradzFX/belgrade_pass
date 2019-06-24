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
$company_location_pass_rules = $broker->get_data(new company_location_pass_rules($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
//==================== HANDLER FOR DROPMENU PARENT - training_school
require_once "../classes/domain/training_school.class.php";
$training_school = new training_school();
$training_school->set_condition("checker","!=","");
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
$ts_location->set_order_by("street","ASC");
$all_ts_location = $broker->get_all_data_condition($ts_location);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $company_location_pass_rules->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$ts_location = $_POST["ts_location"];
	$hours_from = $_POST["hours_from"];
	$minutes_from = $_POST["minutes_from"];
	$hours_to = $_POST["hours_to"];
	$minutes_to = $_POST["minutes_to"];
	$pass_per_kid = $_POST["pass_per_kid"];
	
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
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ts Location

	if(isset($ts_location))
	{
		if(!is_numeric($ts_location) && $ts_location != "NULL")
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be number!"];
		
		if(strlen($ts_location) > 11)
			$error_message = $ap_lang["Field"] . " Ts Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Hours From

	if(isset($hours_from))
	{
		if(!is_numeric($hours_from) && $hours_from != "NULL")
			$error_message = $ap_lang["Field"] . " Hours From " . $ap_lang["must be number!"];
		
		if(strlen($hours_from) > 11)
			$error_message = $ap_lang["Field"] . " Hours From " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Minutes From

	if(isset($minutes_from))
	{
		if(!is_numeric($minutes_from) && $minutes_from != "NULL")
			$error_message = $ap_lang["Field"] . " Minutes From " . $ap_lang["must be number!"];
		
		if(strlen($minutes_from) > 11)
			$error_message = $ap_lang["Field"] . " Minutes From " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Hours To

	if(isset($hours_to))
	{
		if(!is_numeric($hours_to) && $hours_to != "NULL")
			$error_message = $ap_lang["Field"] . " Hours To " . $ap_lang["must be number!"];
		
		if(strlen($hours_to) > 11)
			$error_message = $ap_lang["Field"] . " Hours To " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Minutes To

	if(isset($minutes_to))
	{
		if(!is_numeric($minutes_to) && $minutes_to != "NULL")
			$error_message = $ap_lang["Field"] . " Minutes To " . $ap_lang["must be number!"];
		
		if(strlen($minutes_to) > 11)
			$error_message = $ap_lang["Field"] . " Minutes To " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pass Per Kid

	if(isset($pass_per_kid))
	{
		if(strlen($pass_per_kid) > 11)
			$error_message = $ap_lang["Field"] . " Pass Per Kid " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $company_location_pass_rules->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new company_location_pass_rules($id,$training_school,$ts_location,$hours_from,$minutes_from,$hours_to,$minutes_to,$pass_per_kid,$company_location_pass_rules->maker,$company_location_pass_rules->makerDate,$checker,$checkerDate,$company_location_pass_rules->pozicija,$company_location_pass_rules->jezik,$company_location_pass_rules->recordStatus,$company_location_pass_rules->modNumber+1,$company_location_pass_rules->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_location_pass_rules","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$company_location_pass_rules = $broker->get_data(new company_location_pass_rules($_GET["id"]));
foreach($company_location_pass_rules as $key => $value)
	$company_location_pass_rules->$key = htmlentities($company_location_pass_rules->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$company_location_pass_rules->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $company_location_pass_rules->checker == "")	
	$company_location_pass_rules->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Company Location Pass Rules</h1>
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
<input type="hidden" name="id" value="<?php echo $company_location_pass_rules->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUPARENT-->
	
<script language="javascript">
$(function() {
<?php if($_GET["action"] == "new"){ ?>
	get_children('training_school','ts_location','id','street');
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
<?php if($_GET["action"] == "preview"){ echo $company_location_pass_rules->training_school; }else{ ?>
<select name="training_school" style="width:600px;" onchange="javascript:get_children('training_school','ts_location','id','street');">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $company_location_pass_rules->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($company_location_pass_rules->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
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
<?php if($_GET["action"] == "preview"){ echo $company_location_pass_rules->ts_location; }else{ ?>
<select name="ts_location" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_location);$i++)
{
	if($all_ts_location[$i]->id == $company_location_pass_rules->ts_location){ ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>" <?php if($company_location_pass_rules->ts_location == $all_ts_location[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_location[$i]->street; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_location[$i]->id; ?>"><?php echo $all_ts_location[$i]->street; ?></option>
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
			echo $company_location_pass_rules->hours_from; 
		}else{ 
	?>
	<input type="text" name="hours_from" value="<?php echo $company_location_pass_rules->hours_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_from')">
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
			echo $company_location_pass_rules->minutes_from; 
		}else{ 
	?>
	<input type="text" name="minutes_from" value="<?php echo $company_location_pass_rules->minutes_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_from')">
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
			echo $company_location_pass_rules->hours_to; 
		}else{ 
	?>
	<input type="text" name="hours_to" value="<?php echo $company_location_pass_rules->hours_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_to')">
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
			echo $company_location_pass_rules->minutes_to; 
		}else{ 
	?>
	<input type="text" name="minutes_to" value="<?php echo $company_location_pass_rules->minutes_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_to')">
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
<td>Pass Per Kid <span id="pass_per_kid_counter" style="color:#999">(11,2)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_location_pass_rules->pass_per_kid; 
		}else{ 
	?>
	<input type="text" name="pass_per_kid" value="<?php echo $company_location_pass_rules->pass_per_kid; ?>" style="width:600px;" limit="11,2" onkeyup="count_input_limit('pass_per_kid')">
	<?php } ?>
</td>
</tr>	
<?php if($company_location_pass_rules->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_location_pass_rules->maker; ?> (<?php  echo $company_location_pass_rules->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_location_pass_rules->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_location_pass_rules->checker; ?> (<?php  echo $company_location_pass_rules->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_location_pass_rules->checker != ""){ ?>
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

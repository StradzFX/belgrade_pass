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
$company_location_birthday_slots = $broker->get_data(new company_location_birthday_slots($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $company_location_birthday_slots->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$day_of_week = $_POST["day_of_week"];
	$hours_from = $_POST["hours_from"];
	$minutes_from = $_POST["minutes_from"];
	$hours_to = $_POST["hours_to"];
	$minutes_to = $_POST["minutes_to"];
	$price = $_POST["price"];
	$company_birthday_data = $_POST["company_birthday_data"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Day Of_week

	if(isset($day_of_week))
	{
		if(strlen($day_of_week) > 250)
			$error_message = $ap_lang["Field"] . " Day Of_week " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Price

	if(isset($price))
	{
		if(!is_numeric($price) && $price != "NULL")
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be number!"];
		
		if(strlen($price) > 11)
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Birthday_data

	if(isset($company_birthday_data))
	{
		if(!is_numeric($company_birthday_data) && $company_birthday_data != "NULL")
			$error_message = $ap_lang["Field"] . " Company Birthday_data " . $ap_lang["must be number!"];
		
		if(strlen($company_birthday_data) > 11)
			$error_message = $ap_lang["Field"] . " Company Birthday_data " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $company_location_birthday_slots->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new company_location_birthday_slots($id,$day_of_week,$hours_from,$minutes_from,$hours_to,$minutes_to,$price,$company_birthday_data,$company_location_birthday_slots->maker,$company_location_birthday_slots->makerDate,$checker,$checkerDate,$company_location_birthday_slots->pozicija,$company_location_birthday_slots->jezik,$company_location_birthday_slots->recordStatus,$company_location_birthday_slots->modNumber+1,$company_location_birthday_slots->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_location_birthday_slots","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$company_location_birthday_slots = $broker->get_data(new company_location_birthday_slots($_GET["id"]));
foreach($company_location_birthday_slots as $key => $value)
	$company_location_birthday_slots->$key = htmlentities($company_location_birthday_slots->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$company_location_birthday_slots->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $company_location_birthday_slots->checker == "")	
	$company_location_birthday_slots->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - CLBSlots</h1>
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
<input type="hidden" name="id" value="<?php echo $company_location_birthday_slots->id; ?>"/>
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
			echo $company_location_birthday_slots->day_of_week; 
		}else{ 
	?>
	<input type="text" name="day_of_week" value="<?php echo $company_location_birthday_slots->day_of_week; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('day_of_week')">
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
			echo $company_location_birthday_slots->hours_from; 
		}else{ 
	?>
	<input type="text" name="hours_from" value="<?php echo $company_location_birthday_slots->hours_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_from')">
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
			echo $company_location_birthday_slots->minutes_from; 
		}else{ 
	?>
	<input type="text" name="minutes_from" value="<?php echo $company_location_birthday_slots->minutes_from; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_from')">
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
			echo $company_location_birthday_slots->hours_to; 
		}else{ 
	?>
	<input type="text" name="hours_to" value="<?php echo $company_location_birthday_slots->hours_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('hours_to')">
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
			echo $company_location_birthday_slots->minutes_to; 
		}else{ 
	?>
	<input type="text" name="minutes_to" value="<?php echo $company_location_birthday_slots->minutes_to; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('minutes_to')">
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
			echo $company_location_birthday_slots->price; 
		}else{ 
	?>
	<input type="text" name="price" value="<?php echo $company_location_birthday_slots->price; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('price')">
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
			echo $company_location_birthday_slots->company_birthday_data; 
		}else{ 
	?>
	<input type="text" name="company_birthday_data" value="<?php echo $company_location_birthday_slots->company_birthday_data; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_birthday_data')">
	<?php } ?>
</td>
</tr>	
<?php if($company_location_birthday_slots->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_location_birthday_slots->maker; ?> (<?php  echo $company_location_birthday_slots->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_location_birthday_slots->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_location_birthday_slots->checker; ?> (<?php  echo $company_location_birthday_slots->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_location_birthday_slots->checker != ""){ ?>
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

<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - user_card
require_once "../classes/domain/user_card.class.php";
$user_card = new user_card();
$user_card->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user_card->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user_card->add_condition("recordStatus","=","O");
$user_card->add_condition("jezik","=",$filter_lang);
$user_card->set_order_by("card_number","ASC");
$all_user_card = $broker->get_all_data_condition($user_card);//==================== HANDLER FOR DROPMENU EXTENDED - purchase
require_once "../classes/domain/purchase.class.php";
$purchase = new purchase();
$purchase->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$purchase->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$purchase->add_condition("recordStatus","=","O");
$purchase->add_condition("jezik","=",$filter_lang);
$purchase->set_order_by("id","ASC");
$all_purchase = $broker->get_all_data_condition($purchase);//==================== HANDLER FOR DROPMENU EXTENDED - training_school
require_once "../classes/domain/training_school.class.php";
$training_school = new training_school();
$training_school->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$training_school->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$training_school->add_condition("recordStatus","=","O");
$training_school->add_condition("jezik","=",$filter_lang);
$training_school->set_order_by("name","ASC");
$all_training_school = $broker->get_all_data_condition($training_school);//==================== HANDLER FOR DROPMENU EXTENDED - user
require_once "../classes/domain/user.class.php";
$user = new user();
$user->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user->add_condition("recordStatus","=","O");
$user->add_condition("jezik","=",$filter_lang);
$user->set_order_by("email","ASC");
$all_user = $broker->get_all_data_condition($user);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$user_card = $_POST["user_card"];
	$purchase = $_POST["purchase"];
	$taken_passes = $_POST["taken_passes"];
	$training_school = $_POST["training_school"];
	$number_of_kids = $_POST["number_of_kids"];
	$user = $_POST["user"];
	$pay_to_company = $_POST["pay_to_company"];
	$pay_to_us = $_POST["pay_to_us"];
	$company_location = $_POST["company_location"];
	$pass_type = $_POST["pass_type"];
	$reservation_id = $_POST["reservation_id"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User Card

	if(isset($user_card))
	{
		if(!is_numeric($user_card) && $user_card != "NULL")
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be number!"];
		
		if(strlen($user_card) > 11)
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Purchase

	if(isset($purchase))
	{
		if(!is_numeric($purchase) && $purchase != "NULL")
			$error_message = $ap_lang["Field"] . " Purchase " . $ap_lang["must be number!"];
		
		if(strlen($purchase) > 11)
			$error_message = $ap_lang["Field"] . " Purchase " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Taken Passes

	if(isset($taken_passes))
	{
		if(strlen($taken_passes) > 11)
			$error_message = $ap_lang["Field"] . " Taken Passes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_kids

	if(isset($number_of_kids))
	{
		if(!is_numeric($number_of_kids) && $number_of_kids != "NULL")
			$error_message = $ap_lang["Field"] . " Number Of_kids " . $ap_lang["must be number!"];
		
		if(strlen($number_of_kids) > 11)
			$error_message = $ap_lang["Field"] . " Number Of_kids " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User

	if(isset($user))
	{
		if(!is_numeric($user) && $user != "NULL")
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be number!"];
		
		if(strlen($user) > 11)
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pay To_company

	if(isset($pay_to_company))
	{
		if(!is_numeric($pay_to_company) && $pay_to_company != "NULL")
			$error_message = $ap_lang["Field"] . " Pay To_company " . $ap_lang["must be number!"];
		
		if(strlen($pay_to_company) > 11)
			$error_message = $ap_lang["Field"] . " Pay To_company " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pay To_us

	if(isset($pay_to_us))
	{
		if(!is_numeric($pay_to_us) && $pay_to_us != "NULL")
			$error_message = $ap_lang["Field"] . " Pay To_us " . $ap_lang["must be number!"];
		
		if(strlen($pay_to_us) > 11)
			$error_message = $ap_lang["Field"] . " Pay To_us " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Location

	if(isset($company_location))
	{
		if(!is_numeric($company_location) && $company_location != "NULL")
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be number!"];
		
		if(strlen($company_location) > 11)
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Reservation Id

	if(isset($reservation_id))
	{
		if(!is_numeric($reservation_id) && $reservation_id != "NULL")
			$error_message = $ap_lang["Field"] . " Reservation Id " . $ap_lang["must be number!"];
		
		if(strlen($reservation_id) > 11)
			$error_message = $ap_lang["Field"] . " Reservation Id " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $accepted_passes->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new accepted_passes();
		$new_object->user_card = $user_card;$new_object->purchase = $purchase;$new_object->taken_passes = $taken_passes;$new_object->training_school = $training_school;$new_object->number_of_kids = $number_of_kids;$new_object->user = $user;$new_object->pay_to_company = $pay_to_company;$new_object->pay_to_us = $pay_to_us;$new_object->company_location = $company_location;$new_object->pass_type = $pass_type;$new_object->reservation_id = $reservation_id;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"accepted_passes","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$accepted_passes = new accepted_passes();
	foreach($_POST as $key => $value)
		$accepted_passes->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$accepted_passes->checker = $_SESSION[ADMINLOGGEDIN];
	else							$accepted_passes->checker = "";
}
else	unset($accepted_passes);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Accepted Passes</h1>
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
<input type="hidden" name="id" value="<?php echo $accepted_passes->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User Card</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $accepted_passes->user_card; }else{ ?>
<select name="user_card" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user_card);$i++)
{
	if($all_user_card[$i]->id == $accepted_passes->user_card){ ?>
	<option value="<?php echo $all_user_card[$i]->id; ?>" <?php if($accepted_passes->user_card == $all_user_card[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user_card[$i]->card_number; ?></option>
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
<td>Purchase</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $accepted_passes->purchase; }else{ ?>
<select name="purchase" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_purchase);$i++)
{
	if($all_purchase[$i]->id == $accepted_passes->purchase){ ?>
	<option value="<?php echo $all_purchase[$i]->id; ?>" <?php if($accepted_passes->purchase == $all_purchase[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_purchase[$i]->id; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_purchase[$i]->id; ?>"><?php echo $all_purchase[$i]->id; ?></option>
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
		count_input_limit("taken_passes");
		
	});
</script>
<tr>
<td>Taken Passes <span id="taken_passes_counter" style="color:#999">(11,2)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->taken_passes; 
		}else{ 
	?>
	<input type="text" name="taken_passes" value="<?php echo $accepted_passes->taken_passes; ?>" style="width:600px;" limit="11,2" onkeyup="count_input_limit('taken_passes')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $accepted_passes->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $accepted_passes->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($accepted_passes->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
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
		count_input_limit("number_of_kids");
		
	});
</script>
<tr>
<td>Number Of_kids <span id="number_of_kids_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->number_of_kids; 
		}else{ 
	?>
	<input type="text" name="number_of_kids" value="<?php echo $accepted_passes->number_of_kids; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_kids')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $accepted_passes->user; }else{ ?>
<select name="user" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user);$i++)
{
	if($all_user[$i]->id == $accepted_passes->user){ ?>
	<option value="<?php echo $all_user[$i]->id; ?>" <?php if($accepted_passes->user == $all_user[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user[$i]->email; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_user[$i]->id; ?>"><?php echo $all_user[$i]->email; ?></option>
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
		count_input_limit("pay_to_company");
		
	});
</script>
<tr>
<td>Pay To_company <span id="pay_to_company_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->pay_to_company; 
		}else{ 
	?>
	<input type="text" name="pay_to_company" value="<?php echo $accepted_passes->pay_to_company; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pay_to_company')">
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
		count_input_limit("pay_to_us");
		
	});
</script>
<tr>
<td>Pay To_us <span id="pay_to_us_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->pay_to_us; 
		}else{ 
	?>
	<input type="text" name="pay_to_us" value="<?php echo $accepted_passes->pay_to_us; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pay_to_us')">
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
		count_input_limit("company_location");
		
	});
</script>
<tr>
<td>Company Location <span id="company_location_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->company_location; 
		}else{ 
	?>
	<input type="text" name="company_location" value="<?php echo $accepted_passes->company_location; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_location')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE DROPMENUFIXED-->
<tr>
<td>Pass Type</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $accepted_passes->pass_type; }else{ ?><select name="pass_type">
<option value="regular" 
<?php if($accepted_passes->pass_type == "" || $accepted_passes->pass_type == "regular"){ ?>selected="selected"<?php } ?>>regular</option><br />
<option value="birthday" 
<?php if($accepted_passes->pass_type == "birthday"){ ?>selected="selected"<?php } ?>>birthday</option><br />
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
		count_input_limit("reservation_id");
		
	});
</script>
<tr>
<td>Reservation Id <span id="reservation_id_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $accepted_passes->reservation_id; 
		}else{ 
	?>
	<input type="text" name="reservation_id" value="<?php echo $accepted_passes->reservation_id; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('reservation_id')">
	<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($accepted_passes->checker != ""){ ?>
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

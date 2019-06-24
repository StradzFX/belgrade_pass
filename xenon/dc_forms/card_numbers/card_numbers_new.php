<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_POST["submit-new"]){

$id = $_POST["id"];
	$card_number = $_POST["card_number"];
	$card_password = $_POST["card_password"];
	$card_password_confirm = $_POST["card_password_confirm"];
	$card_password_changed = $_POST["card_password_changed"];$card_taken = $_POST["card_taken"];
	$user = $_POST["user"];
	$card_reserved = $_POST["card_reserved"];
	$company_card = $_POST["company_card"];
	$card_number_int = $_POST["card_number_int"];
	$picture = $_POST["picture"];
	$company_location = $_POST["company_location"];
	$internal_reservation = $_POST["internal_reservation"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Card Number

	if(isset($card_number))
	{
		if(strlen($card_number) > 250)
			$error_message = $ap_lang["Field"] . " Card Number " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - PASSWORD ELEMENT - Card Password

	if(isset($card_password))
	{
		if(strlen($card_password) > 250)
			$error_message = $ap_lang["Field"] . " Card Password " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
	if($_GET["action"] == "new")
	{
		if(strcmp($_POST["card_password"],$_POST["card_password_confirm"]) != 0)
			$error_message = $ap_lang["Validation is not correct, please try again!"];
		else 
			if($_POST["card_password"] == "")	$card_password = "";
			else								$_POST["card_password"] = md5($card_password);
	}
	if($_GET["action"] == "edit")
	{

		if($card_password_changed == "0"){	
			$card_password = $card_numbers->card_password;
		}else{
			if($card_password == ""){
				$_POST["card_password"] = "";
			}else{
				if(strcmp($_POST["card_password"],$_POST["card_password_confirm"]) != 0){
					$error_message = $ap_lang["Validation is not correct, please try again!"];
				}else{
					$card_password = md5($card_password);
				}
				
			}
		}
	}
	
//================ ERROR HANDLER - CHECKBOX ELEMENT - Card Taken

	if(isset($card_taken))
	{
		$card_taken = 1;
		$_POST["card_taken"] = 1;
	}else{
		$card_taken = 0;
		$_POST["card_taken"] = 0;
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User

	if(isset($user))
	{
		if(!is_numeric($user) && $user != "NULL")
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be number!"];
		
		if(strlen($user) > 11)
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Card Reserved

	if(isset($card_reserved))
	{
		$card_reserved = 1;
		$_POST["card_reserved"] = 1;
	}else{
		$card_reserved = 0;
		$_POST["card_reserved"] = 0;
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Card

	if(isset($company_card))
	{
		if(!is_numeric($company_card) && $company_card != "NULL")
			$error_message = $ap_lang["Field"] . " Company Card " . $ap_lang["must be number!"];
		
		if(strlen($company_card) > 11)
			$error_message = $ap_lang["Field"] . " Company Card " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Card Number_int

	if(isset($card_number_int))
	{
		if(!is_numeric($card_number_int) && $card_number_int != "NULL")
			$error_message = $ap_lang["Field"] . " Card Number_int " . $ap_lang["must be number!"];
		
		if(strlen($card_number_int) > 11)
			$error_message = $ap_lang["Field"] . " Card Number_int " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Picture

	if(isset($picture))
	{
		if(strlen($picture) > 250)
			$error_message = $ap_lang["Field"] . " Picture " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Location

	if(isset($company_location))
	{
		if(!is_numeric($company_location) && $company_location != "NULL")
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be number!"];
		
		if(strlen($company_location) > 11)
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Internal Reservation

	if(isset($internal_reservation))
	{
		$internal_reservation = 1;
		$_POST["internal_reservation"] = 1;
	}else{
		$internal_reservation = 0;
		$_POST["internal_reservation"] = 0;
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
			$checkerDate = $card_numbers->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new card_numbers();
		$new_object->card_number = $card_number;$new_object->card_password = $card_password;$new_object->card_taken = $card_taken;$new_object->user = $user;$new_object->card_reserved = $card_reserved;$new_object->company_card = $company_card;$new_object->card_number_int = $card_number_int;$new_object->picture = $picture;$new_object->company_location = $company_location;$new_object->internal_reservation = $internal_reservation;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"card_numbers","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$card_numbers = new card_numbers();
	foreach($_POST as $key => $value)
		$card_numbers->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$card_numbers->checker = $_SESSION[ADMINLOGGEDIN];
	else							$card_numbers->checker = "";
}
else	unset($card_numbers);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Card Numbers</h1>
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
<input type="hidden" name="id" value="<?php echo $card_numbers->id; ?>"/>
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
		count_input_limit("card_number");
		
	});
</script>
<tr>
<td>Card Number <span id="card_number_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_numbers->card_number; 
		}else{ 
	?>
	<input type="text" name="card_number" value="<?php echo $card_numbers->card_number; ?>" style="width:200px;" limit="250" onkeyup="count_input_limit('card_number')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $card_numbers->card_password != ""){ ?>
	$('table').delegate('[name=change_card_password]', 'click', function() {
	  		$(this).closest('tr').hide( function() {
		 	$('.insert_card_password').show();
			$('[name="card_password_changed"]').val('1');
	  	});
	});
<?php }else{ ?>	
	$(function() {
		$('[name=change_card_password]').closest('tr').hide();
		$('.insert_card_password').show();
		$('[name="card_password_changed"]').val('1');
	});
<?php } ?>
</script>
<input type="hidden" name="card_password_changed" value="0"/>
<tr>
<td>Card Password</td>
<td><button type="button" name="change_card_password"><?php echo $ap_lang["Change"]; ?></button></td>
</tr>
<tr class="insert_card_password" style="display:none">
<td>Card Password</td>
<td>
<?php if($_GET["action"] == "preview"){ if($card_numbers->card_password != "" || $card_numbers->card_password != NULL ){?>**********<?php } }else{ ?>
<input type="password" name="card_password" value="" style="width:600px;">
<?php } ?>
</td>
</tr>
<tr class="insert_card_password" style="display:none">
<?php if($_GET["action"] != "preview"){ ?>
<td><?php echo $ap_lang["Confirm"]; ?> Card Password</td>
<td>
<input type="password" name="card_password_confirm" value="" style="width:600px;">
</td>
</tr>
<?php } ?>

<!--FORM TYPE CHECKBOX-->
<tr>
<td>Card Taken</td>
<td>
<?php if($_GET["action"] == "preview"){
if($card_numbers->card_taken == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="card_taken" <?php if($card_numbers->card_taken == 1) { ?> checked="checked" <?php } ?>/>
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
		count_input_limit("user");
		
	});
</script>
<tr>
<td>User <span id="user_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_numbers->user; 
		}else{ 
	?>
	<input type="text" name="user" value="<?php echo $card_numbers->user; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('user')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Card Reserved</td>
<td>
<?php if($_GET["action"] == "preview"){
if($card_numbers->card_reserved == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="card_reserved" <?php if($card_numbers->card_reserved == 1) { ?> checked="checked" <?php } ?>/>
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
		count_input_limit("company_card");
		
	});
</script>
<tr>
<td>Company Card <span id="company_card_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_numbers->company_card; 
		}else{ 
	?>
	<input type="text" name="company_card" value="<?php echo $card_numbers->company_card; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_card')">
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
		count_input_limit("card_number_int");
		
	});
</script>
<tr>
<td>Card Number_int <span id="card_number_int_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_numbers->card_number_int; 
		}else{ 
	?>
	<input type="text" name="card_number_int" value="<?php echo $card_numbers->card_number_int; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('card_number_int')">
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
		count_input_limit("picture");
		
	});
</script>
<tr>
<td>Picture <span id="picture_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $card_numbers->picture; 
		}else{ 
	?>
	<input type="text" name="picture" value="<?php echo $card_numbers->picture; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('picture')">
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
			echo $card_numbers->company_location; 
		}else{ 
	?>
	<input type="text" name="company_location" value="<?php echo $card_numbers->company_location; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_location')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Internal Reservation</td>
<td>
<?php if($_GET["action"] == "preview"){
if($card_numbers->internal_reservation == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="internal_reservation" <?php if($card_numbers->internal_reservation == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($card_numbers->checker != ""){ ?>
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

<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


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
$all_user = $broker->get_all_data_condition($user);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$card_number = $_POST["card_number"];
	$child_birthdate = $_POST["child_birthdate"];
	$user = $_POST["user"];
	$card_password = $_POST["card_password"];
	$card_password_confirm = $_POST["card_password_confirm"];
	$card_password_changed = $_POST["card_password_changed"];$delivery_method = $_POST["delivery_method"];
	$post_street = $_POST["post_street"];
	$post_city = $_POST["post_city"];
	$post_postal = $_POST["post_postal"];
	$partner_id = $_POST["partner_id"];
	$customer_received = $_POST["customer_received"];
	$parent_first_name = $_POST["parent_first_name"];
	$number_of_kids = $_POST["number_of_kids"];
	$city = $_POST["city"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$company_location = $_POST["company_location"];
	$parent_last_name = $_POST["parent_last_name"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Card Number

	if(isset($card_number))
	{
		if(strlen($card_number) > 250)
			$error_message = $ap_lang["Field"] . " Card Number " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Child Birthdate

	if(isset($child_birthdate))
	{
		if(strlen($child_birthdate) > 250)
			$error_message = $ap_lang["Field"] . " Child Birthdate " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User

	if(isset($user))
	{
		if(!is_numeric($user) && $user != "NULL")
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be number!"];
		
		if(strlen($user) > 11)
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$card_password = $user_card->card_password;
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
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Delivery Method

	if(isset($delivery_method))
	{
		if(strlen($delivery_method) > 250)
			$error_message = $ap_lang["Field"] . " Delivery Method " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Post Street

	if(isset($post_street))
	{
		if(strlen($post_street) > 250)
			$error_message = $ap_lang["Field"] . " Post Street " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Post City

	if(isset($post_city))
	{
		if(strlen($post_city) > 250)
			$error_message = $ap_lang["Field"] . " Post City " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Post Postal

	if(isset($post_postal))
	{
		if(strlen($post_postal) > 250)
			$error_message = $ap_lang["Field"] . " Post Postal " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Partner Id

	if(isset($partner_id))
	{
		if(strlen($partner_id) > 250)
			$error_message = $ap_lang["Field"] . " Partner Id " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - CHECKBOX ELEMENT - Customer Received

	if(isset($customer_received))
	{
		$customer_received = 1;
		$_POST["customer_received"] = 1;
	}else{
		$customer_received = 0;
		$_POST["customer_received"] = 0;
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Parent First_name

	if(isset($parent_first_name))
	{
		if(strlen($parent_first_name) > 250)
			$error_message = $ap_lang["Field"] . " Parent First_name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_kids

	if(isset($number_of_kids))
	{
		if(!is_numeric($number_of_kids) && $number_of_kids != "NULL")
			$error_message = $ap_lang["Field"] . " Number Of_kids " . $ap_lang["must be number!"];
		
		if(strlen($number_of_kids) > 11)
			$error_message = $ap_lang["Field"] . " Number Of_kids " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - City

	if(isset($city))
	{
		if(strlen($city) > 250)
			$error_message = $ap_lang["Field"] . " City " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Phone

	if(isset($phone))
	{
		if(strlen($phone) > 250)
			$error_message = $ap_lang["Field"] . " Phone " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Email

	if(isset($email))
	{
		if(strlen($email) > 250)
			$error_message = $ap_lang["Field"] . " Email " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Location

	if(isset($company_location))
	{
		if(!is_numeric($company_location) && $company_location != "NULL")
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be number!"];
		
		if(strlen($company_location) > 11)
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Parent Last_name

	if(isset($parent_last_name))
	{
		if(strlen($parent_last_name) > 250)
			$error_message = $ap_lang["Field"] . " Parent Last_name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
			$checkerDate = $user_card->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new user_card();
		$new_object->card_number = $card_number;$new_object->child_birthdate = $child_birthdate;$new_object->user = $user;$new_object->card_password = $card_password;$new_object->delivery_method = $delivery_method;$new_object->post_street = $post_street;$new_object->post_city = $post_city;$new_object->post_postal = $post_postal;$new_object->partner_id = $partner_id;$new_object->customer_received = $customer_received;$new_object->parent_first_name = $parent_first_name;$new_object->number_of_kids = $number_of_kids;$new_object->city = $city;$new_object->phone = $phone;$new_object->email = $email;$new_object->company_location = $company_location;$new_object->parent_last_name = $parent_last_name;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"user_card","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$user_card = new user_card();
	foreach($_POST as $key => $value)
		$user_card->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$user_card->checker = $_SESSION[ADMINLOGGEDIN];
	else							$user_card->checker = "";
}
else	unset($user_card);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - User card</h1>
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
<input type="hidden" name="id" value="<?php echo $user_card->id; ?>"/>
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
			echo $user_card->card_number; 
		}else{ 
	?>
	<input type="text" name="card_number" value="<?php echo $user_card->card_number; ?>" style="width:200px;" limit="250" onkeyup="count_input_limit('card_number')">
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
		count_input_limit("child_birthdate");
		
	});
</script>
<tr>
<td>Child Birthdate <span id="child_birthdate_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->child_birthdate; 
		}else{ 
	?>
	<input type="text" name="child_birthdate" value="<?php echo $user_card->child_birthdate; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('child_birthdate')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $user_card->user; }else{ ?>
<select name="user" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user);$i++)
{
	if($all_user[$i]->id == $user_card->user){ ?>
	<option value="<?php echo $all_user[$i]->id; ?>" <?php if($user_card->user == $all_user[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user[$i]->email; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_user[$i]->id; ?>"><?php echo $all_user[$i]->email; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $user_card->card_password != ""){ ?>
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
<?php if($_GET["action"] == "preview"){ if($user_card->card_password != "" || $user_card->card_password != NULL ){?>**********<?php } }else{ ?>
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
		count_input_limit("delivery_method");
		
	});
</script>
<tr>
<td>Delivery Method <span id="delivery_method_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->delivery_method; 
		}else{ 
	?>
	<input type="text" name="delivery_method" value="<?php echo $user_card->delivery_method; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('delivery_method')">
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
		count_input_limit("post_street");
		
	});
</script>
<tr>
<td>Post Street <span id="post_street_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->post_street; 
		}else{ 
	?>
	<input type="text" name="post_street" value="<?php echo $user_card->post_street; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('post_street')">
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
		count_input_limit("post_city");
		
	});
</script>
<tr>
<td>Post City <span id="post_city_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->post_city; 
		}else{ 
	?>
	<input type="text" name="post_city" value="<?php echo $user_card->post_city; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('post_city')">
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
		count_input_limit("post_postal");
		
	});
</script>
<tr>
<td>Post Postal <span id="post_postal_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->post_postal; 
		}else{ 
	?>
	<input type="text" name="post_postal" value="<?php echo $user_card->post_postal; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('post_postal')">
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
		count_input_limit("partner_id");
		
	});
</script>
<tr>
<td>Partner Id <span id="partner_id_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->partner_id; 
		}else{ 
	?>
	<input type="text" name="partner_id" value="<?php echo $user_card->partner_id; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('partner_id')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Customer Received</td>
<td>
<?php if($_GET["action"] == "preview"){
if($user_card->customer_received == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="customer_received" <?php if($user_card->customer_received == 1) { ?> checked="checked" <?php } ?>/>
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
		count_input_limit("parent_first_name");
		
	});
</script>
<tr>
<td>Parent First_name <span id="parent_first_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->parent_first_name; 
		}else{ 
	?>
	<input type="text" name="parent_first_name" value="<?php echo $user_card->parent_first_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('parent_first_name')">
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
			echo $user_card->number_of_kids; 
		}else{ 
	?>
	<input type="text" name="number_of_kids" value="<?php echo $user_card->number_of_kids; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_kids')">
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
		count_input_limit("city");
		
	});
</script>
<tr>
<td>City <span id="city_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->city; 
		}else{ 
	?>
	<input type="text" name="city" value="<?php echo $user_card->city; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('city')">
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
		count_input_limit("phone");
		
	});
</script>
<tr>
<td>Phone <span id="phone_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->phone; 
		}else{ 
	?>
	<input type="text" name="phone" value="<?php echo $user_card->phone; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('phone')">
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
		count_input_limit("email");
		
	});
</script>
<tr>
<td>Email <span id="email_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->email; 
		}else{ 
	?>
	<input type="text" name="email" value="<?php echo $user_card->email; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('email')">
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
			echo $user_card->company_location; 
		}else{ 
	?>
	<input type="text" name="company_location" value="<?php echo $user_card->company_location; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_location')">
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
		count_input_limit("parent_last_name");
		
	});
</script>
<tr>
<td>Parent Last_name <span id="parent_last_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user_card->parent_last_name; 
		}else{ 
	?>
	<input type="text" name="parent_last_name" value="<?php echo $user_card->parent_last_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('parent_last_name')">
	<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($user_card->checker != ""){ ?>
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

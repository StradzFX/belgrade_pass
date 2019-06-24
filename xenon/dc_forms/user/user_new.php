<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_POST["submit-new"]){

$id = $_POST["id"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password_confirm = $_POST["password_confirm"];
	$password_changed = $_POST["password_changed"];$fb_id = $_POST["fb_id"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$avatar = $_POST["avatar"];
	$user_type = $_POST["user_type"];
	$pib = $_POST["pib"];
	$maticni = $_POST["maticni"];
	$adresa = $_POST["adresa"];
	$naziv = $_POST["naziv"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Email

	if(isset($email))
	{
		if(strlen($email) > 250)
			$error_message = $ap_lang["Field"] . " Email " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - PASSWORD ELEMENT - Password

	if(isset($password))
	{
		if(strlen($password) > 250)
			$error_message = $ap_lang["Field"] . " Password " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
	if($_GET["action"] == "new")
	{
		if(strcmp($_POST["password"],$_POST["password_confirm"]) != 0)
			$error_message = $ap_lang["Validation is not correct, please try again!"];
		else 
			if($_POST["password"] == "")	$password = "";
			else								$_POST["password"] = md5($password);
	}
	if($_GET["action"] == "edit")
	{

		if($password_changed == "0"){	
			$password = $user->password;
		}else{
			if($password == ""){
				$_POST["password"] = "";
			}else{
				if(strcmp($_POST["password"],$_POST["password_confirm"]) != 0){
					$error_message = $ap_lang["Validation is not correct, please try again!"];
				}else{
					$password = md5($password);
				}
				
			}
		}
	}
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Fb Id

	if(isset($fb_id))
	{
		if(strlen($fb_id) > 250)
			$error_message = $ap_lang["Field"] . " Fb Id " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - First Name

	if(isset($first_name))
	{
		if(strlen($first_name) > 250)
			$error_message = $ap_lang["Field"] . " First Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Last Name

	if(isset($last_name))
	{
		if(strlen($last_name) > 250)
			$error_message = $ap_lang["Field"] . " Last Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Avatar

	if(isset($avatar))
	{
		if(strlen($avatar) > 250)
			$error_message = $ap_lang["Field"] . " Avatar " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User Type

	if(isset($user_type))
	{
		if(strlen($user_type) > 250)
			$error_message = $ap_lang["Field"] . " User Type " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pib

	if(isset($pib))
	{
		if(strlen($pib) > 250)
			$error_message = $ap_lang["Field"] . " Pib " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Maticni

	if(isset($maticni))
	{
		if(strlen($maticni) > 250)
			$error_message = $ap_lang["Field"] . " Maticni " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Adresa

	if(isset($adresa))
	{
		if(strlen($adresa) > 250)
			$error_message = $ap_lang["Field"] . " Adresa " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Naziv

	if(isset($naziv))
	{
		if(strlen($naziv) > 250)
			$error_message = $ap_lang["Field"] . " Naziv " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
			$checkerDate = $user->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new user();
		$new_object->email = $email;$new_object->password = $password;$new_object->fb_id = $fb_id;$new_object->first_name = $first_name;$new_object->last_name = $last_name;$new_object->avatar = $avatar;$new_object->user_type = $user_type;$new_object->pib = $pib;$new_object->maticni = $maticni;$new_object->adresa = $adresa;$new_object->naziv = $naziv;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"user","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$user = new user();
	foreach($_POST as $key => $value)
		$user->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$user->checker = $_SESSION[ADMINLOGGEDIN];
	else							$user->checker = "";
}
else	unset($user);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - User</h1>
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
<input type="hidden" name="id" value="<?php echo $user->id; ?>"/>
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
			echo $user->email; 
		}else{ 
	?>
	<input type="text" name="email" value="<?php echo $user->email; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('email')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $user->password != ""){ ?>
	$('table').delegate('[name=change_password]', 'click', function() {
	  		$(this).closest('tr').hide( function() {
		 	$('.insert_password').show();
			$('[name="password_changed"]').val('1');
	  	});
	});
<?php }else{ ?>	
	$(function() {
		$('[name=change_password]').closest('tr').hide();
		$('.insert_password').show();
		$('[name="password_changed"]').val('1');
	});
<?php } ?>
</script>
<input type="hidden" name="password_changed" value="0"/>
<tr>
<td>Password</td>
<td><button type="button" name="change_password"><?php echo $ap_lang["Change"]; ?></button></td>
</tr>
<tr class="insert_password" style="display:none">
<td>Password</td>
<td>
<?php if($_GET["action"] == "preview"){ if($user->password != "" || $user->password != NULL ){?>**********<?php } }else{ ?>
<input type="password" name="password" value="" style="width:600px;">
<?php } ?>
</td>
</tr>
<tr class="insert_password" style="display:none">
<?php if($_GET["action"] != "preview"){ ?>
<td><?php echo $ap_lang["Confirm"]; ?> Password</td>
<td>
<input type="password" name="password_confirm" value="" style="width:600px;">
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
		count_input_limit("fb_id");
		
	});
</script>
<tr>
<td>Fb Id <span id="fb_id_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->fb_id; 
		}else{ 
	?>
	<input type="text" name="fb_id" value="<?php echo $user->fb_id; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('fb_id')">
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
		count_input_limit("first_name");
		
	});
</script>
<tr>
<td>First Name <span id="first_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->first_name; 
		}else{ 
	?>
	<input type="text" name="first_name" value="<?php echo $user->first_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('first_name')">
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
		count_input_limit("last_name");
		
	});
</script>
<tr>
<td>Last Name <span id="last_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->last_name; 
		}else{ 
	?>
	<input type="text" name="last_name" value="<?php echo $user->last_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('last_name')">
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
		count_input_limit("avatar");
		
	});
</script>
<tr>
<td>Avatar <span id="avatar_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->avatar; 
		}else{ 
	?>
	<input type="text" name="avatar" value="<?php echo $user->avatar; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('avatar')">
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
		count_input_limit("user_type");
		
	});
</script>
<tr>
<td>User Type <span id="user_type_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->user_type; 
		}else{ 
	?>
	<input type="text" name="user_type" value="<?php echo $user->user_type; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('user_type')">
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
		count_input_limit("pib");
		
	});
</script>
<tr>
<td>Pib <span id="pib_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->pib; 
		}else{ 
	?>
	<input type="text" name="pib" value="<?php echo $user->pib; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pib')">
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
		count_input_limit("maticni");
		
	});
</script>
<tr>
<td>Maticni <span id="maticni_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->maticni; 
		}else{ 
	?>
	<input type="text" name="maticni" value="<?php echo $user->maticni; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('maticni')">
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
		count_input_limit("adresa");
		
	});
</script>
<tr>
<td>Adresa <span id="adresa_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->adresa; 
		}else{ 
	?>
	<input type="text" name="adresa" value="<?php echo $user->adresa; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('adresa')">
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
		count_input_limit("naziv");
		
	});
</script>
<tr>
<td>Naziv <span id="naziv_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $user->naziv; 
		}else{ 
	?>
	<input type="text" name="naziv" value="<?php echo $user->naziv; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('naziv')">
	<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($user->checker != ""){ ?>
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

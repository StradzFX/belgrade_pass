<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - sport_category
require_once "../classes/domain/sport_category.class.php";
$sport_category = new sport_category();
$sport_category->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$sport_category->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$sport_category->add_condition("recordStatus","=","O");
$sport_category->add_condition("jezik","=",$filter_lang);
$sport_category->set_order_by("name","ASC");
$all_sport_category = $broker->get_all_data_condition($sport_category);
if($_POST["submit-new"]){

$id = $_POST["id"];
	$name = $_POST["name"];
	$into_text = $_POST["into_text"];
	$general_text = $_POST["general_text"];
	$sport_category = $_POST["sport_category"];
	$featured = $_POST["featured"];
	$number_of_views = $_POST["number_of_views"];
	$short_description = $_POST["short_description"];
	$main_description = $_POST["main_description"];
	$promoted = $_POST["promoted"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password_confirm = $_POST["password_confirm"];
	$password_changed = $_POST["password_changed"];$pass_options = $_POST["pass_options"];
	$extra_goods_options = $_POST["extra_goods_options"];
	$birthday_options = $_POST["birthday_options"];
	$pass_customer_percentage = $_POST["pass_customer_percentage"];
	$pass_company_percentage = $_POST["pass_company_percentage"];
	$discount_description = $_POST["discount_description"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Name

	if(isset($name))
	{
		if(strlen($name) > 250)
			$error_message = $ap_lang["Field"] . " Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Sport Category

	if(isset($sport_category))
	{
		if(!is_numeric($sport_category) && $sport_category != "NULL")
			$error_message = $ap_lang["Field"] . " Sport Category " . $ap_lang["must be number!"];
		
		if(strlen($sport_category) > 11)
			$error_message = $ap_lang["Field"] . " Sport Category " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Featured

	if(isset($featured))
	{
		if(!is_numeric($featured) && $featured != "NULL")
			$error_message = $ap_lang["Field"] . " Featured " . $ap_lang["must be number!"];
		
		if(strlen($featured) > 11)
			$error_message = $ap_lang["Field"] . " Featured " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_views

	if(isset($number_of_views))
	{
		if(!is_numeric($number_of_views) && $number_of_views != "NULL")
			$error_message = $ap_lang["Field"] . " Number Of_views " . $ap_lang["must be number!"];
		
		if(strlen($number_of_views) > 11)
			$error_message = $ap_lang["Field"] . " Number Of_views " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Promoted

	if(isset($promoted))
	{
		if(!is_numeric($promoted) && $promoted != "NULL")
			$error_message = $ap_lang["Field"] . " Promoted " . $ap_lang["must be number!"];
		
		if(strlen($promoted) > 11)
			$error_message = $ap_lang["Field"] . " Promoted " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Username

	if(isset($username))
	{
		if(strlen($username) > 250)
			$error_message = $ap_lang["Field"] . " Username " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
			$password = $training_school->password;
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
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pass Options

	if(isset($pass_options))
	{
		if(!is_numeric($pass_options) && $pass_options != "NULL")
			$error_message = $ap_lang["Field"] . " Pass Options " . $ap_lang["must be number!"];
		
		if(strlen($pass_options) > 11)
			$error_message = $ap_lang["Field"] . " Pass Options " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Extra Goods_options

	if(isset($extra_goods_options))
	{
		if(!is_numeric($extra_goods_options) && $extra_goods_options != "NULL")
			$error_message = $ap_lang["Field"] . " Extra Goods_options " . $ap_lang["must be number!"];
		
		if(strlen($extra_goods_options) > 11)
			$error_message = $ap_lang["Field"] . " Extra Goods_options " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Birthday Options

	if(isset($birthday_options))
	{
		if(!is_numeric($birthday_options) && $birthday_options != "NULL")
			$error_message = $ap_lang["Field"] . " Birthday Options " . $ap_lang["must be number!"];
		
		if(strlen($birthday_options) > 11)
			$error_message = $ap_lang["Field"] . " Birthday Options " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pass Customer_percentage

	if(isset($pass_customer_percentage))
	{
		if(!is_numeric($pass_customer_percentage) && $pass_customer_percentage != "NULL")
			$error_message = $ap_lang["Field"] . " Pass Customer_percentage " . $ap_lang["must be number!"];
		
		if(strlen($pass_customer_percentage) > 11)
			$error_message = $ap_lang["Field"] . " Pass Customer_percentage " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pass Company_percentage

	if(isset($pass_company_percentage))
	{
		if(!is_numeric($pass_company_percentage) && $pass_company_percentage != "NULL")
			$error_message = $ap_lang["Field"] . " Pass Company_percentage " . $ap_lang["must be number!"];
		
		if(strlen($pass_company_percentage) > 11)
			$error_message = $ap_lang["Field"] . " Pass Company_percentage " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $training_school->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new training_school();
		$new_object->name = $name;$new_object->into_text = $into_text;$new_object->general_text = $general_text;$new_object->sport_category = $sport_category;$new_object->featured = $featured;$new_object->number_of_views = $number_of_views;$new_object->short_description = $short_description;$new_object->main_description = $main_description;$new_object->promoted = $promoted;$new_object->username = $username;$new_object->password = $password;$new_object->pass_options = $pass_options;$new_object->extra_goods_options = $extra_goods_options;$new_object->birthday_options = $birthday_options;$new_object->pass_customer_percentage = $pass_customer_percentage;$new_object->pass_company_percentage = $pass_company_percentage;$new_object->discount_description = $discount_description;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
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
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"training_school","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$training_school = new training_school();
	foreach($_POST as $key => $value)
		$training_school->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$training_school->checker = $_SESSION[ADMINLOGGEDIN];
	else							$training_school->checker = "";
}
else	unset($training_school);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - Training school</h1>
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
<input type="hidden" name="id" value="<?php echo $training_school->id; ?>"/>
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
			echo $training_school->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $training_school->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Into Text</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->into_text; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="into_text" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->into_text); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>General Text</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->general_text; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="general_text" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->general_text); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Sport Category</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->sport_category; }else{ ?>
<select name="sport_category" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_sport_category);$i++)
{
	if($all_sport_category[$i]->id == $training_school->sport_category){ ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>" <?php if($training_school->sport_category == $all_sport_category[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_sport_category[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>"><?php echo $all_sport_category[$i]->name; ?></option>
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
		count_input_limit("featured");
		
	});
</script>
<tr>
<td>Featured <span id="featured_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->featured; 
		}else{ 
	?>
	<input type="text" name="featured" value="<?php echo $training_school->featured; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('featured')">
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
		count_input_limit("number_of_views");
		
	});
</script>
<tr>
<td>Number Of_views <span id="number_of_views_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->number_of_views; 
		}else{ 
	?>
	<input type="text" name="number_of_views" value="<?php echo $training_school->number_of_views; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_views')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Short Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->short_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="short_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->short_description); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Main Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->main_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="main_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->main_description); ?></textarea>
</div>
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
		count_input_limit("promoted");
		
	});
</script>
<tr>
<td>Promoted <span id="promoted_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->promoted; 
		}else{ 
	?>
	<input type="text" name="promoted" value="<?php echo $training_school->promoted; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('promoted')">
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
		count_input_limit("username");
		
	});
</script>
<tr>
<td>Username <span id="username_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->username; 
		}else{ 
	?>
	<input type="text" name="username" value="<?php echo $training_school->username; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('username')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $training_school->password != ""){ ?>
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
<?php if($_GET["action"] == "preview"){ if($training_school->password != "" || $training_school->password != NULL ){?>**********<?php } }else{ ?>
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
		count_input_limit("pass_options");
		
	});
</script>
<tr>
<td>Pass Options <span id="pass_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_options; 
		}else{ 
	?>
	<input type="text" name="pass_options" value="<?php echo $training_school->pass_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_options')">
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
		count_input_limit("extra_goods_options");
		
	});
</script>
<tr>
<td>Extra Goods_options <span id="extra_goods_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->extra_goods_options; 
		}else{ 
	?>
	<input type="text" name="extra_goods_options" value="<?php echo $training_school->extra_goods_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('extra_goods_options')">
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
		count_input_limit("birthday_options");
		
	});
</script>
<tr>
<td>Birthday Options <span id="birthday_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->birthday_options; 
		}else{ 
	?>
	<input type="text" name="birthday_options" value="<?php echo $training_school->birthday_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_options')">
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
		count_input_limit("pass_customer_percentage");
		
	});
</script>
<tr>
<td>Pass Customer_percentage <span id="pass_customer_percentage_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_customer_percentage; 
		}else{ 
	?>
	<input type="text" name="pass_customer_percentage" value="<?php echo $training_school->pass_customer_percentage; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_customer_percentage')">
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
		count_input_limit("pass_company_percentage");
		
	});
</script>
<tr>
<td>Pass Company_percentage <span id="pass_company_percentage_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_company_percentage; 
		}else{ 
	?>
	<input type="text" name="pass_company_percentage" value="<?php echo $training_school->pass_company_percentage; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_company_percentage')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Discount Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->discount_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="discount_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->discount_description); ?></textarea>
</div>
<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($training_school->checker != ""){ ?>
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

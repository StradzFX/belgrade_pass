<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/user_card.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$user_card = $broker->get_data(new user_card($_GET["id"]));

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
$user_card = $broker->get_data(new user_card($_GET["id"]));
require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($user_card->user));
$user_card->user = $user->email;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_user"]) 		$filter_user = $_GET["filter_user"];
else							$filter_user = "all";
if($_GET["filter_customer_received"]) 		$filter_customer_received = $_GET["filter_customer_received"];
else							$filter_customer_received = "all";

$dc_objects = new user_card();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("card_number","LIKE","%".$search."%","OR");
	$array_som[] = array("child_birthdate","LIKE","%".$search."%","OR");
	$array_som[] = array("card_password","LIKE","%".$search."%","OR");
	$array_som[] = array("delivery_method","LIKE","%".$search."%","OR");
	$array_som[] = array("post_street","LIKE","%".$search."%","OR");
	$array_som[] = array("post_city","LIKE","%".$search."%","OR");
	$array_som[] = array("post_postal","LIKE","%".$search."%","OR");
	$array_som[] = array("partner_id","LIKE","%".$search."%","OR");
	$array_som[] = array("parent_first_name","LIKE","%".$search."%","OR");
	$array_som[] = array("city","LIKE","%".$search."%","OR");
	$array_som[] = array("phone","LIKE","%".$search."%","OR");
	$array_som[] = array("email","LIKE","%".$search."%","OR");
	$array_som[] = array("parent_last_name","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("customer_received","=",$search,"OR");
		$array_som[] = array("number_of_kids","=",$search,"OR");
		$array_som[] = array("company_location","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_card_number != "all" && $filter_card_number != "")
	$dc_objects->add_condition("card_number","=",$filter_card_number);

if($filter_child_birthdate != "all" && $filter_child_birthdate != "")
	$dc_objects->add_condition("child_birthdate","=",$filter_child_birthdate);

if($filter_user != "all" && $filter_user != "")
	$dc_objects->add_condition("user","=",$filter_user);	

if($filter_card_password != "all" && $filter_card_password != "")
	$dc_objects->add_condition("card_password","=",$filter_card_password);

if($filter_delivery_method != "all" && $filter_delivery_method != "")
	$dc_objects->add_condition("delivery_method","=",$filter_delivery_method);

if($filter_post_street != "all" && $filter_post_street != "")
	$dc_objects->add_condition("post_street","=",$filter_post_street);

if($filter_post_city != "all" && $filter_post_city != "")
	$dc_objects->add_condition("post_city","=",$filter_post_city);

if($filter_post_postal != "all" && $filter_post_postal != "")
	$dc_objects->add_condition("post_postal","=",$filter_post_postal);

if($filter_partner_id != "all" && $filter_partner_id != "")
	$dc_objects->add_condition("partner_id","=",$filter_partner_id);

$element = "";
if($filter_customer_received == "yes")		$element = 1;
if($filter_customer_received == "no")		$element = 0;
if($filter_customer_received != "all" && $filter_customer_received != "")
	$dc_objects->add_condition("customer_received","=",$element);

if($filter_parent_first_name != "all" && $filter_parent_first_name != "")
	$dc_objects->add_condition("parent_first_name","=",$filter_parent_first_name);

if($filter_city != "all" && $filter_city != "")
	$dc_objects->add_condition("city","=",$filter_city);

if($filter_phone != "all" && $filter_phone != "")
	$dc_objects->add_condition("phone","=",$filter_phone);

if($filter_email != "all" && $filter_email != "")
	$dc_objects->add_condition("email","=",$filter_email);

if($filter_parent_last_name != "all" && $filter_parent_last_name != "")
	$dc_objects->add_condition("parent_last_name","=",$filter_parent_last_name);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new user_card();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new user_card();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$user_card->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new user_card();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$user_card->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new user_card();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - User card</h1>
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
<?php if($user_card->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $user_card->maker; ?> (<?php  echo $user_card->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($user_card->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $user_card->checker; ?> (<?php  echo $user_card->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

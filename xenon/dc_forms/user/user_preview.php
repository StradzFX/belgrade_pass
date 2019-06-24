<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/user.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$user = $broker->get_data(new user($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
$user = $broker->get_data(new user($_GET["id"]));
if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";

$dc_objects = new user();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("email","LIKE","%".$search."%","OR");
	$array_som[] = array("password","LIKE","%".$search."%","OR");
	$array_som[] = array("fb_id","LIKE","%".$search."%","OR");
	$array_som[] = array("first_name","LIKE","%".$search."%","OR");
	$array_som[] = array("last_name","LIKE","%".$search."%","OR");
	$array_som[] = array("avatar","LIKE","%".$search."%","OR");
	$array_som[] = array("user_type","LIKE","%".$search."%","OR");
	$array_som[] = array("pib","LIKE","%".$search."%","OR");
	$array_som[] = array("maticni","LIKE","%".$search."%","OR");
	$array_som[] = array("adresa","LIKE","%".$search."%","OR");
	$array_som[] = array("naziv","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_email != "all" && $filter_email != "")
	$dc_objects->add_condition("email","=",$filter_email);

if($filter_password != "all" && $filter_password != "")
	$dc_objects->add_condition("password","=",$filter_password);

if($filter_fb_id != "all" && $filter_fb_id != "")
	$dc_objects->add_condition("fb_id","=",$filter_fb_id);

if($filter_first_name != "all" && $filter_first_name != "")
	$dc_objects->add_condition("first_name","=",$filter_first_name);

if($filter_last_name != "all" && $filter_last_name != "")
	$dc_objects->add_condition("last_name","=",$filter_last_name);

if($filter_avatar != "all" && $filter_avatar != "")
	$dc_objects->add_condition("avatar","=",$filter_avatar);

if($filter_user_type != "all" && $filter_user_type != "")
	$dc_objects->add_condition("user_type","=",$filter_user_type);

if($filter_pib != "all" && $filter_pib != "")
	$dc_objects->add_condition("pib","=",$filter_pib);

if($filter_maticni != "all" && $filter_maticni != "")
	$dc_objects->add_condition("maticni","=",$filter_maticni);

if($filter_adresa != "all" && $filter_adresa != "")
	$dc_objects->add_condition("adresa","=",$filter_adresa);

if($filter_naziv != "all" && $filter_naziv != "")
	$dc_objects->add_condition("naziv","=",$filter_naziv);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new user();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new user();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$user->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new user();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$user->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new user();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - User</h1>
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
<?php if($user->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $user->maker; ?> (<?php  echo $user->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($user->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $user->checker; ?> (<?php  echo $user->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

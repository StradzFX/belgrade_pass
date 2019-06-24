<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/card_numbers.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$card_numbers = $broker->get_data(new card_numbers($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
$card_numbers = $broker->get_data(new card_numbers($_GET["id"]));
if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_card_taken"]) 		$filter_card_taken = $_GET["filter_card_taken"];
else							$filter_card_taken = "all";
if($_GET["filter_card_reserved"]) 		$filter_card_reserved = $_GET["filter_card_reserved"];
else							$filter_card_reserved = "all";
if($_GET["filter_internal_reservation"]) 		$filter_internal_reservation = $_GET["filter_internal_reservation"];
else							$filter_internal_reservation = "all";

$dc_objects = new card_numbers();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("card_number","LIKE","%".$search."%","OR");
	$array_som[] = array("card_password","LIKE","%".$search."%","OR");
	$array_som[] = array("picture","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("card_taken","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("card_reserved","=",$search,"OR");
		$array_som[] = array("company_card","=",$search,"OR");
		$array_som[] = array("card_number_int","=",$search,"OR");
		$array_som[] = array("company_location","=",$search,"OR");
		$array_som[] = array("internal_reservation","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_card_number != "all" && $filter_card_number != "")
	$dc_objects->add_condition("card_number","=",$filter_card_number);

if($filter_card_password != "all" && $filter_card_password != "")
	$dc_objects->add_condition("card_password","=",$filter_card_password);

$element = "";
if($filter_card_taken == "yes")		$element = 1;
if($filter_card_taken == "no")		$element = 0;
if($filter_card_taken != "all" && $filter_card_taken != "")
	$dc_objects->add_condition("card_taken","=",$element);

$element = "";
if($filter_card_reserved == "yes")		$element = 1;
if($filter_card_reserved == "no")		$element = 0;
if($filter_card_reserved != "all" && $filter_card_reserved != "")
	$dc_objects->add_condition("card_reserved","=",$element);

if($filter_picture != "all" && $filter_picture != "")
	$dc_objects->add_condition("picture","=",$filter_picture);

$element = "";
if($filter_internal_reservation == "yes")		$element = 1;
if($filter_internal_reservation == "no")		$element = 0;
if($filter_internal_reservation != "all" && $filter_internal_reservation != "")
	$dc_objects->add_condition("internal_reservation","=",$element);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new card_numbers();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new card_numbers();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$card_numbers->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new card_numbers();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$card_numbers->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new card_numbers();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Card Numbers</h1>
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
<?php if($card_numbers->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $card_numbers->maker; ?> (<?php  echo $card_numbers->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($card_numbers->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $card_numbers->checker; ?> (<?php  echo $card_numbers->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

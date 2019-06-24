<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/accepted_passes.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$accepted_passes = $broker->get_data(new accepted_passes($_GET["id"]));

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
$accepted_passes = $broker->get_data(new accepted_passes($_GET["id"]));
require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($accepted_passes->user_card));
$accepted_passes->user_card = $user_card->card_number;

require_once "../classes/domain/purchase.class.php";
$purchase = $broker->get_data(new purchase($accepted_passes->purchase));
$accepted_passes->purchase = $purchase->id;

require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($accepted_passes->training_school));
$accepted_passes->training_school = $training_school->name;

require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($accepted_passes->user));
$accepted_passes->user = $user->email;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_user_card"]) 		$filter_user_card = $_GET["filter_user_card"];
else							$filter_user_card = "all";
if($_GET["filter_purchase"]) 		$filter_purchase = $_GET["filter_purchase"];
else							$filter_purchase = "all";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";
if($_GET["filter_user"]) 		$filter_user = $_GET["filter_user"];
else							$filter_user = "all";
if($_GET["filter_pass_type"]) 		$filter_pass_type = $_GET["filter_pass_type"];
else							$filter_pass_type = "all";

$dc_objects = new accepted_passes();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("pass_type","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("user_card","=",$search,"OR");
		$array_som[] = array("purchase","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
		$array_som[] = array("number_of_kids","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("pay_to_company","=",$search,"OR");
		$array_som[] = array("pay_to_us","=",$search,"OR");
		$array_som[] = array("company_location","=",$search,"OR");
		$array_som[] = array("reservation_id","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_user_card != "all" && $filter_user_card != "")
	$dc_objects->add_condition("user_card","=",$filter_user_card);	

if($filter_purchase != "all" && $filter_purchase != "")
	$dc_objects->add_condition("purchase","=",$filter_purchase);	

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_user != "all" && $filter_user != "")
	$dc_objects->add_condition("user","=",$filter_user);	

if($filter_pass_type != "all" && $filter_pass_type != "")
	$dc_objects->add_condition("pass_type","=",$filter_pass_type);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new accepted_passes();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new accepted_passes();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$accepted_passes->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new accepted_passes();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$accepted_passes->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new accepted_passes();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Accepted Passes</h1>
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
<?php if($accepted_passes->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $accepted_passes->maker; ?> (<?php  echo $accepted_passes->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($accepted_passes->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $accepted_passes->checker; ?> (<?php  echo $accepted_passes->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

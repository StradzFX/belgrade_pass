<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/purchase.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$purchase = $broker->get_data(new purchase($_GET["id"]));

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
$all_user = $broker->get_all_data_condition($user);//==================== HANDLER FOR DROPMENU EXTENDED - card_package
require_once "../classes/domain/card_package.class.php";
$card_package = new card_package();
$card_package->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$card_package->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$card_package->add_condition("recordStatus","=","O");
$card_package->add_condition("jezik","=",$filter_lang);
$card_package->set_order_by("name","ASC");
$all_card_package = $broker->get_all_data_condition($card_package);//==================== HANDLER FOR DROPMENU EXTENDED - user_card
require_once "../classes/domain/user_card.class.php";
$user_card = new user_card();
$user_card->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user_card->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user_card->add_condition("recordStatus","=","O");
$user_card->add_condition("jezik","=",$filter_lang);
$user_card->set_order_by("card_number","ASC");
$all_user_card = $broker->get_all_data_condition($user_card);
$purchase = $broker->get_data(new purchase($_GET["id"]));
require_once "../classes/domain/user.class.php";
$user = $broker->get_data(new user($purchase->user));
$purchase->user = $user->email;

require_once "../classes/domain/card_package.class.php";
$card_package = $broker->get_data(new card_package($purchase->card_package));
$purchase->card_package = $card_package->name;

require_once "../classes/domain/user_card.class.php";
$user_card = $broker->get_data(new user_card($purchase->user_card));
$purchase->user_card = $user_card->card_number;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_user"]) 		$filter_user = $_GET["filter_user"];
else							$filter_user = "all";
if($_GET["filter_card_package"]) 		$filter_card_package = $_GET["filter_card_package"];
else							$filter_card_package = "all";
if($_GET["filter_user_card"]) 		$filter_user_card = $_GET["filter_user_card"];
else							$filter_user_card = "all";

$dc_objects = new purchase();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("to_company","LIKE","%".$search."%","OR");
	$array_som[] = array("to_us","LIKE","%".$search."%","OR");
	$array_som[] = array("duration_days","LIKE","%".$search."%","OR");
	$array_som[] = array("purchase_type","LIKE","%".$search."%","OR");
	$array_som[] = array("company_flag","LIKE","%".$search."%","OR");
	$array_som[] = array("po_name","LIKE","%".$search."%","OR");
	$array_som[] = array("po_address","LIKE","%".$search."%","OR");
	$array_som[] = array("po_city","LIKE","%".$search."%","OR");
	$array_som[] = array("po_postal","LIKE","%".$search."%","OR");
	$array_som[] = array("card_active_token","LIKE","%".$search."%","OR");
	$array_som[] = array("returnUrl","LIKE","%".$search."%","OR");
	$array_som[] = array("merchantPaymentId","LIKE","%".$search."%","OR");
	$array_som[] = array("apiMerchantId","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystem","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystemType","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystemEftCode","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranDate","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranId","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranRefId","LIKE","%".$search."%","OR");
	$array_som[] = array("pgOrderId","LIKE","%".$search."%","OR");
	$array_som[] = array("customerId","LIKE","%".$search."%","OR");
	$array_som[] = array("amount","LIKE","%".$search."%","OR");
	$array_som[] = array("installment","LIKE","%".$search."%","OR");
	$array_som[] = array("sessionToken","LIKE","%".$search."%","OR");
	$array_som[] = array("random_string","LIKE","%".$search."%","OR");
	$array_som[] = array("SD_SHA512","LIKE","%".$search."%","OR");
	$array_som[] = array("sdSha512","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranErrorText","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranErrorCode","LIKE","%".$search."%","OR");
	$array_som[] = array("errorCode","LIKE","%".$search."%","OR");
	$array_som[] = array("responseCode","LIKE","%".$search."%","OR");
	$array_som[] = array("responseMsg","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("price","=",$search,"OR");
		$array_som[] = array("number_of_passes","=",$search,"OR");
		$array_som[] = array("card_package","=",$search,"OR");
		$array_som[] = array("user_card","=",$search,"OR");
		$array_som[] = array("company_location","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_user != "all" && $filter_user != "")
	$dc_objects->add_condition("user","=",$filter_user);	

if($filter_to_company != "all" && $filter_to_company != "")
	$dc_objects->add_condition("to_company","=",$filter_to_company);

if($filter_to_us != "all" && $filter_to_us != "")
	$dc_objects->add_condition("to_us","=",$filter_to_us);

if($filter_duration_days != "all" && $filter_duration_days != "")
	$dc_objects->add_condition("duration_days","=",$filter_duration_days);

if($filter_purchase_type != "all" && $filter_purchase_type != "")
	$dc_objects->add_condition("purchase_type","=",$filter_purchase_type);

if($filter_company_flag != "all" && $filter_company_flag != "")
	$dc_objects->add_condition("company_flag","=",$filter_company_flag);

if($filter_po_name != "all" && $filter_po_name != "")
	$dc_objects->add_condition("po_name","=",$filter_po_name);

if($filter_po_address != "all" && $filter_po_address != "")
	$dc_objects->add_condition("po_address","=",$filter_po_address);

if($filter_po_city != "all" && $filter_po_city != "")
	$dc_objects->add_condition("po_city","=",$filter_po_city);

if($filter_po_postal != "all" && $filter_po_postal != "")
	$dc_objects->add_condition("po_postal","=",$filter_po_postal);

if($filter_card_package != "all" && $filter_card_package != "")
	$dc_objects->add_condition("card_package","=",$filter_card_package);	

if($filter_user_card != "all" && $filter_user_card != "")
	$dc_objects->add_condition("user_card","=",$filter_user_card);	

if($filter_card_active_token != "all" && $filter_card_active_token != "")
	$dc_objects->add_condition("card_active_token","=",$filter_card_active_token);

if($filter_returnUrl != "all" && $filter_returnUrl != "")
	$dc_objects->add_condition("returnUrl","=",$filter_returnUrl);

if($filter_merchantPaymentId != "all" && $filter_merchantPaymentId != "")
	$dc_objects->add_condition("merchantPaymentId","=",$filter_merchantPaymentId);

if($filter_apiMerchantId != "all" && $filter_apiMerchantId != "")
	$dc_objects->add_condition("apiMerchantId","=",$filter_apiMerchantId);

if($filter_paymentSystem != "all" && $filter_paymentSystem != "")
	$dc_objects->add_condition("paymentSystem","=",$filter_paymentSystem);

if($filter_paymentSystemType != "all" && $filter_paymentSystemType != "")
	$dc_objects->add_condition("paymentSystemType","=",$filter_paymentSystemType);

if($filter_paymentSystemEftCode != "all" && $filter_paymentSystemEftCode != "")
	$dc_objects->add_condition("paymentSystemEftCode","=",$filter_paymentSystemEftCode);

if($filter_pgTranDate != "all" && $filter_pgTranDate != "")
	$dc_objects->add_condition("pgTranDate","=",$filter_pgTranDate);

if($filter_pgTranId != "all" && $filter_pgTranId != "")
	$dc_objects->add_condition("pgTranId","=",$filter_pgTranId);

if($filter_pgTranRefId != "all" && $filter_pgTranRefId != "")
	$dc_objects->add_condition("pgTranRefId","=",$filter_pgTranRefId);

if($filter_pgOrderId != "all" && $filter_pgOrderId != "")
	$dc_objects->add_condition("pgOrderId","=",$filter_pgOrderId);

if($filter_customerId != "all" && $filter_customerId != "")
	$dc_objects->add_condition("customerId","=",$filter_customerId);

if($filter_amount != "all" && $filter_amount != "")
	$dc_objects->add_condition("amount","=",$filter_amount);

if($filter_installment != "all" && $filter_installment != "")
	$dc_objects->add_condition("installment","=",$filter_installment);

if($filter_sessionToken != "all" && $filter_sessionToken != "")
	$dc_objects->add_condition("sessionToken","=",$filter_sessionToken);

if($filter_random_string != "all" && $filter_random_string != "")
	$dc_objects->add_condition("random_string","=",$filter_random_string);

if($filter_SD_SHA512 != "all" && $filter_SD_SHA512 != "")
	$dc_objects->add_condition("SD_SHA512","=",$filter_SD_SHA512);

if($filter_sdSha512 != "all" && $filter_sdSha512 != "")
	$dc_objects->add_condition("sdSha512","=",$filter_sdSha512);

if($filter_pgTranErrorText != "all" && $filter_pgTranErrorText != "")
	$dc_objects->add_condition("pgTranErrorText","=",$filter_pgTranErrorText);

if($filter_pgTranErrorCode != "all" && $filter_pgTranErrorCode != "")
	$dc_objects->add_condition("pgTranErrorCode","=",$filter_pgTranErrorCode);

if($filter_errorCode != "all" && $filter_errorCode != "")
	$dc_objects->add_condition("errorCode","=",$filter_errorCode);

if($filter_responseCode != "all" && $filter_responseCode != "")
	$dc_objects->add_condition("responseCode","=",$filter_responseCode);

if($filter_responseMsg != "all" && $filter_responseMsg != "")
	$dc_objects->add_condition("responseMsg","=",$filter_responseMsg);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new purchase();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new purchase();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$purchase->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new purchase();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$purchase->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new purchase();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Purchase</h1>
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
<input type="hidden" name="id" value="<?php echo $purchase->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $purchase->user; }else{ ?>
<select name="user" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user);$i++)
{
	if($all_user[$i]->id == $purchase->user){ ?>
	<option value="<?php echo $all_user[$i]->id; ?>" <?php if($purchase->user == $all_user[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user[$i]->email; ?></option>
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
		count_input_limit("price");
		
	});
</script>
<tr>
<td>Price <span id="price_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->price; 
		}else{ 
	?>
	<input type="text" name="price" value="<?php echo $purchase->price; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('price')">
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
		count_input_limit("to_company");
		
	});
</script>
<tr>
<td>To Company <span id="to_company_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->to_company; 
		}else{ 
	?>
	<input type="text" name="to_company" value="<?php echo $purchase->to_company; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('to_company')">
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
		count_input_limit("to_us");
		
	});
</script>
<tr>
<td>To Us <span id="to_us_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->to_us; 
		}else{ 
	?>
	<input type="text" name="to_us" value="<?php echo $purchase->to_us; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('to_us')">
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
		count_input_limit("duration_days");
		
	});
</script>
<tr>
<td>Duration Days <span id="duration_days_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->duration_days; 
		}else{ 
	?>
	<input type="text" name="duration_days" value="<?php echo $purchase->duration_days; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('duration_days')">
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
		count_input_limit("number_of_passes");
		
	});
</script>
<tr>
<td>Number Of_passes <span id="number_of_passes_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->number_of_passes; 
		}else{ 
	?>
	<input type="text" name="number_of_passes" value="<?php echo $purchase->number_of_passes; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_passes')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE DATEPICKER-->
<link rel="stylesheet" type="text/css" href="js/datepicker/css/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="js/datepicker/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	$(function() {
		$("#start_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>Start Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($purchase->start_date)); }else{ ?>
<input type="text" name="start_date" id="start_date" value="<?php if($purchase->start_date == "" || $purchase->start_date == NULL){ echo date('m/d/Y'); } else{ echo $purchase->start_date; } ?>" />
<?php } ?>
</td>
</tr>
<!--FORM TYPE DATEPICKER-->
<link rel="stylesheet" type="text/css" href="js/datepicker/css/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="js/datepicker/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/datepicker/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	$(function() {
		$("#end_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>End Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($purchase->end_date)); }else{ ?>
<input type="text" name="end_date" id="end_date" value="<?php if($purchase->end_date == "" || $purchase->end_date == NULL){ echo date('m/d/Y'); } else{ echo $purchase->end_date; } ?>" />
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
		count_input_limit("purchase_type");
		
	});
</script>
<tr>
<td>Purchase Type <span id="purchase_type_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->purchase_type; 
		}else{ 
	?>
	<input type="text" name="purchase_type" value="<?php echo $purchase->purchase_type; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('purchase_type')">
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
		count_input_limit("company_flag");
		
	});
</script>
<tr>
<td>Company Flag <span id="company_flag_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->company_flag; 
		}else{ 
	?>
	<input type="text" name="company_flag" value="<?php echo $purchase->company_flag; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('company_flag')">
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
		count_input_limit("po_name");
		
	});
</script>
<tr>
<td>Po Name <span id="po_name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->po_name; 
		}else{ 
	?>
	<input type="text" name="po_name" value="<?php echo $purchase->po_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('po_name')">
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
		count_input_limit("po_address");
		
	});
</script>
<tr>
<td>Po Address <span id="po_address_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->po_address; 
		}else{ 
	?>
	<input type="text" name="po_address" value="<?php echo $purchase->po_address; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('po_address')">
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
		count_input_limit("po_city");
		
	});
</script>
<tr>
<td>Po City <span id="po_city_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->po_city; 
		}else{ 
	?>
	<input type="text" name="po_city" value="<?php echo $purchase->po_city; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('po_city')">
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
		count_input_limit("po_postal");
		
	});
</script>
<tr>
<td>Po Postal <span id="po_postal_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->po_postal; 
		}else{ 
	?>
	<input type="text" name="po_postal" value="<?php echo $purchase->po_postal; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('po_postal')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Card Package</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $purchase->card_package; }else{ ?>
<select name="card_package" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_card_package);$i++)
{
	if($all_card_package[$i]->id == $purchase->card_package){ ?>
	<option value="<?php echo $all_card_package[$i]->id; ?>" <?php if($purchase->card_package == $all_card_package[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_card_package[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_card_package[$i]->id; ?>"><?php echo $all_card_package[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>User Card</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $purchase->user_card; }else{ ?>
<select name="user_card" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_user_card);$i++)
{
	if($all_user_card[$i]->id == $purchase->user_card){ ?>
	<option value="<?php echo $all_user_card[$i]->id; ?>" <?php if($purchase->user_card == $all_user_card[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user_card[$i]->card_number; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_user_card[$i]->id; ?>"><?php echo $all_user_card[$i]->card_number; ?></option>
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
		count_input_limit("card_active_token");
		
	});
</script>
<tr>
<td>Card Active_token <span id="card_active_token_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->card_active_token; 
		}else{ 
	?>
	<input type="text" name="card_active_token" value="<?php echo $purchase->card_active_token; ?>" style="width:200px;" limit="250" onkeyup="count_input_limit('card_active_token')">
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
		count_input_limit("returnUrl");
		
	});
</script>
<tr>
<td>Returnurl <span id="returnUrl_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->returnUrl; 
		}else{ 
	?>
	<input type="text" name="returnUrl" value="<?php echo $purchase->returnUrl; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('returnUrl')">
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
		count_input_limit("merchantPaymentId");
		
	});
</script>
<tr>
<td>Merchantpaymentid <span id="merchantPaymentId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->merchantPaymentId; 
		}else{ 
	?>
	<input type="text" name="merchantPaymentId" value="<?php echo $purchase->merchantPaymentId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('merchantPaymentId')">
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
		count_input_limit("apiMerchantId");
		
	});
</script>
<tr>
<td>Apimerchantid <span id="apiMerchantId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->apiMerchantId; 
		}else{ 
	?>
	<input type="text" name="apiMerchantId" value="<?php echo $purchase->apiMerchantId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('apiMerchantId')">
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
		count_input_limit("paymentSystem");
		
	});
</script>
<tr>
<td>Paymentsystem <span id="paymentSystem_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->paymentSystem; 
		}else{ 
	?>
	<input type="text" name="paymentSystem" value="<?php echo $purchase->paymentSystem; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('paymentSystem')">
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
		count_input_limit("paymentSystemType");
		
	});
</script>
<tr>
<td>Paymentsystemtype <span id="paymentSystemType_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->paymentSystemType; 
		}else{ 
	?>
	<input type="text" name="paymentSystemType" value="<?php echo $purchase->paymentSystemType; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('paymentSystemType')">
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
		count_input_limit("paymentSystemEftCode");
		
	});
</script>
<tr>
<td>Paymentsystemeftcode <span id="paymentSystemEftCode_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->paymentSystemEftCode; 
		}else{ 
	?>
	<input type="text" name="paymentSystemEftCode" value="<?php echo $purchase->paymentSystemEftCode; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('paymentSystemEftCode')">
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
		count_input_limit("pgTranDate");
		
	});
</script>
<tr>
<td>Pgtrandate <span id="pgTranDate_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgTranDate; 
		}else{ 
	?>
	<input type="text" name="pgTranDate" value="<?php echo $purchase->pgTranDate; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgTranDate')">
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
		count_input_limit("pgTranId");
		
	});
</script>
<tr>
<td>Pgtranid <span id="pgTranId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgTranId; 
		}else{ 
	?>
	<input type="text" name="pgTranId" value="<?php echo $purchase->pgTranId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgTranId')">
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
		count_input_limit("pgTranRefId");
		
	});
</script>
<tr>
<td>Pgtranrefid <span id="pgTranRefId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgTranRefId; 
		}else{ 
	?>
	<input type="text" name="pgTranRefId" value="<?php echo $purchase->pgTranRefId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgTranRefId')">
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
		count_input_limit("pgOrderId");
		
	});
</script>
<tr>
<td>Pgorderid <span id="pgOrderId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgOrderId; 
		}else{ 
	?>
	<input type="text" name="pgOrderId" value="<?php echo $purchase->pgOrderId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgOrderId')">
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
		count_input_limit("customerId");
		
	});
</script>
<tr>
<td>Customerid <span id="customerId_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->customerId; 
		}else{ 
	?>
	<input type="text" name="customerId" value="<?php echo $purchase->customerId; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('customerId')">
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
		count_input_limit("amount");
		
	});
</script>
<tr>
<td>Amount <span id="amount_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->amount; 
		}else{ 
	?>
	<input type="text" name="amount" value="<?php echo $purchase->amount; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('amount')">
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
		count_input_limit("installment");
		
	});
</script>
<tr>
<td>Installment <span id="installment_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->installment; 
		}else{ 
	?>
	<input type="text" name="installment" value="<?php echo $purchase->installment; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('installment')">
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
		count_input_limit("sessionToken");
		
	});
</script>
<tr>
<td>Sessiontoken <span id="sessionToken_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->sessionToken; 
		}else{ 
	?>
	<input type="text" name="sessionToken" value="<?php echo $purchase->sessionToken; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('sessionToken')">
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
		count_input_limit("random_string");
		
	});
</script>
<tr>
<td>Random String <span id="random_string_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->random_string; 
		}else{ 
	?>
	<input type="text" name="random_string" value="<?php echo $purchase->random_string; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('random_string')">
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
		count_input_limit("SD_SHA512");
		
	});
</script>
<tr>
<td>Sd Sha512 <span id="SD_SHA512_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->SD_SHA512; 
		}else{ 
	?>
	<input type="text" name="SD_SHA512" value="<?php echo $purchase->SD_SHA512; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('SD_SHA512')">
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
		count_input_limit("sdSha512");
		
	});
</script>
<tr>
<td>Sdsha512 <span id="sdSha512_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->sdSha512; 
		}else{ 
	?>
	<input type="text" name="sdSha512" value="<?php echo $purchase->sdSha512; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('sdSha512')">
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
		count_input_limit("pgTranErrorText");
		
	});
</script>
<tr>
<td>Pgtranerrortext <span id="pgTranErrorText_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgTranErrorText; 
		}else{ 
	?>
	<input type="text" name="pgTranErrorText" value="<?php echo $purchase->pgTranErrorText; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgTranErrorText')">
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
		count_input_limit("pgTranErrorCode");
		
	});
</script>
<tr>
<td>Pgtranerrorcode <span id="pgTranErrorCode_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->pgTranErrorCode; 
		}else{ 
	?>
	<input type="text" name="pgTranErrorCode" value="<?php echo $purchase->pgTranErrorCode; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('pgTranErrorCode')">
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
		count_input_limit("errorCode");
		
	});
</script>
<tr>
<td>Errorcode <span id="errorCode_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->errorCode; 
		}else{ 
	?>
	<input type="text" name="errorCode" value="<?php echo $purchase->errorCode; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('errorCode')">
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
		count_input_limit("responseCode");
		
	});
</script>
<tr>
<td>Responsecode <span id="responseCode_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->responseCode; 
		}else{ 
	?>
	<input type="text" name="responseCode" value="<?php echo $purchase->responseCode; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('responseCode')">
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
		count_input_limit("responseMsg");
		
	});
</script>
<tr>
<td>Responsemsg <span id="responseMsg_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $purchase->responseMsg; 
		}else{ 
	?>
	<input type="text" name="responseMsg" value="<?php echo $purchase->responseMsg; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('responseMsg')">
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
			echo $purchase->company_location; 
		}else{ 
	?>
	<input type="text" name="company_location" value="<?php echo $purchase->company_location; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company_location')">
	<?php } ?>
</td>
</tr>	
<?php if($purchase->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $purchase->maker; ?> (<?php  echo $purchase->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($purchase->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $purchase->checker; ?> (<?php  echo $purchase->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

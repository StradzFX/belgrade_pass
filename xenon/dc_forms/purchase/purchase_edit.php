<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}

require_once "config.php";
include_once "php/functions.php";

error_reporting(E_ERROR);

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$edit_disabled = false;
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
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $purchase->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$user = $_POST["user"];
	$price = $_POST["price"];
	$to_company = $_POST["to_company"];
	$to_us = $_POST["to_us"];
	$duration_days = $_POST["duration_days"];
	$number_of_passes = $_POST["number_of_passes"];
	$start_date = explode("/",$_POST["start_date"]);
	$start_date = $start_date[2]."-".$start_date[0]."-".$start_date[1];
	$_POST["start_date"] = $start_date;
	$end_date = explode("/",$_POST["end_date"]);
	$end_date = $end_date[2]."-".$end_date[0]."-".$end_date[1];
	$_POST["end_date"] = $end_date;
	$purchase_type = $_POST["purchase_type"];
	$company_flag = $_POST["company_flag"];
	$po_name = $_POST["po_name"];
	$po_address = $_POST["po_address"];
	$po_city = $_POST["po_city"];
	$po_postal = $_POST["po_postal"];
	$card_package = $_POST["card_package"];
	$user_card = $_POST["user_card"];
	$card_active_token = $_POST["card_active_token"];
	$returnUrl = $_POST["returnUrl"];
	$merchantPaymentId = $_POST["merchantPaymentId"];
	$apiMerchantId = $_POST["apiMerchantId"];
	$paymentSystem = $_POST["paymentSystem"];
	$paymentSystemType = $_POST["paymentSystemType"];
	$paymentSystemEftCode = $_POST["paymentSystemEftCode"];
	$pgTranDate = $_POST["pgTranDate"];
	$pgTranId = $_POST["pgTranId"];
	$pgTranRefId = $_POST["pgTranRefId"];
	$pgOrderId = $_POST["pgOrderId"];
	$customerId = $_POST["customerId"];
	$amount = $_POST["amount"];
	$installment = $_POST["installment"];
	$sessionToken = $_POST["sessionToken"];
	$random_string = $_POST["random_string"];
	$SD_SHA512 = $_POST["SD_SHA512"];
	$sdSha512 = $_POST["sdSha512"];
	$pgTranErrorText = $_POST["pgTranErrorText"];
	$pgTranErrorCode = $_POST["pgTranErrorCode"];
	$errorCode = $_POST["errorCode"];
	$responseCode = $_POST["responseCode"];
	$responseMsg = $_POST["responseMsg"];
	$company_location = $_POST["company_location"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User

	if(isset($user))
	{
		if(!is_numeric($user) && $user != "NULL")
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be number!"];
		
		if(strlen($user) > 11)
			$error_message = $ap_lang["Field"] . " User " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Price

	if(isset($price))
	{
		if(!is_numeric($price) && $price != "NULL")
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be number!"];
		
		if(strlen($price) > 11)
			$error_message = $ap_lang["Field"] . " Price " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - To Company

	if(isset($to_company))
	{
		if(strlen($to_company) > 250)
			$error_message = $ap_lang["Field"] . " To Company " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - To Us

	if(isset($to_us))
	{
		if(strlen($to_us) > 250)
			$error_message = $ap_lang["Field"] . " To Us " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Duration Days

	if(isset($duration_days))
	{
		if(strlen($duration_days) > 250)
			$error_message = $ap_lang["Field"] . " Duration Days " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Number Of_passes

	if(isset($number_of_passes))
	{
		if(!is_numeric($number_of_passes) && $number_of_passes != "NULL")
			$error_message = $ap_lang["Field"] . " Number Of_passes " . $ap_lang["must be number!"];
		
		if(strlen($number_of_passes) > 11)
			$error_message = $ap_lang["Field"] . " Number Of_passes " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Purchase Type

	if(isset($purchase_type))
	{
		if(strlen($purchase_type) > 250)
			$error_message = $ap_lang["Field"] . " Purchase Type " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Flag

	if(isset($company_flag))
	{
		if(strlen($company_flag) > 250)
			$error_message = $ap_lang["Field"] . " Company Flag " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Po Name

	if(isset($po_name))
	{
		if(strlen($po_name) > 250)
			$error_message = $ap_lang["Field"] . " Po Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Po Address

	if(isset($po_address))
	{
		if(strlen($po_address) > 250)
			$error_message = $ap_lang["Field"] . " Po Address " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Po City

	if(isset($po_city))
	{
		if(strlen($po_city) > 250)
			$error_message = $ap_lang["Field"] . " Po City " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Po Postal

	if(isset($po_postal))
	{
		if(strlen($po_postal) > 250)
			$error_message = $ap_lang["Field"] . " Po Postal " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Card Package

	if(isset($card_package))
	{
		if(!is_numeric($card_package) && $card_package != "NULL")
			$error_message = $ap_lang["Field"] . " Card Package " . $ap_lang["must be number!"];
		
		if(strlen($card_package) > 11)
			$error_message = $ap_lang["Field"] . " Card Package " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - User Card

	if(isset($user_card))
	{
		if(!is_numeric($user_card) && $user_card != "NULL")
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be number!"];
		
		if(strlen($user_card) > 11)
			$error_message = $ap_lang["Field"] . " User Card " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Card Active_token

	if(isset($card_active_token))
	{
		if(strlen($card_active_token) > 250)
			$error_message = $ap_lang["Field"] . " Card Active_token " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Returnurl

	if(isset($returnUrl))
	{
		if(strlen($returnUrl) > 250)
			$error_message = $ap_lang["Field"] . " Returnurl " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Merchantpaymentid

	if(isset($merchantPaymentId))
	{
		if(strlen($merchantPaymentId) > 250)
			$error_message = $ap_lang["Field"] . " Merchantpaymentid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Apimerchantid

	if(isset($apiMerchantId))
	{
		if(strlen($apiMerchantId) > 250)
			$error_message = $ap_lang["Field"] . " Apimerchantid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Paymentsystem

	if(isset($paymentSystem))
	{
		if(strlen($paymentSystem) > 250)
			$error_message = $ap_lang["Field"] . " Paymentsystem " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Paymentsystemtype

	if(isset($paymentSystemType))
	{
		if(strlen($paymentSystemType) > 250)
			$error_message = $ap_lang["Field"] . " Paymentsystemtype " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Paymentsystemeftcode

	if(isset($paymentSystemEftCode))
	{
		if(strlen($paymentSystemEftCode) > 250)
			$error_message = $ap_lang["Field"] . " Paymentsystemeftcode " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgtrandate

	if(isset($pgTranDate))
	{
		if(strlen($pgTranDate) > 250)
			$error_message = $ap_lang["Field"] . " Pgtrandate " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgtranid

	if(isset($pgTranId))
	{
		if(strlen($pgTranId) > 250)
			$error_message = $ap_lang["Field"] . " Pgtranid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgtranrefid

	if(isset($pgTranRefId))
	{
		if(strlen($pgTranRefId) > 250)
			$error_message = $ap_lang["Field"] . " Pgtranrefid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgorderid

	if(isset($pgOrderId))
	{
		if(strlen($pgOrderId) > 250)
			$error_message = $ap_lang["Field"] . " Pgorderid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Customerid

	if(isset($customerId))
	{
		if(strlen($customerId) > 250)
			$error_message = $ap_lang["Field"] . " Customerid " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Amount

	if(isset($amount))
	{
		if(strlen($amount) > 250)
			$error_message = $ap_lang["Field"] . " Amount " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Installment

	if(isset($installment))
	{
		if(strlen($installment) > 250)
			$error_message = $ap_lang["Field"] . " Installment " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Sessiontoken

	if(isset($sessionToken))
	{
		if(strlen($sessionToken) > 250)
			$error_message = $ap_lang["Field"] . " Sessiontoken " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Random String

	if(isset($random_string))
	{
		if(strlen($random_string) > 250)
			$error_message = $ap_lang["Field"] . " Random String " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Sd Sha512

	if(isset($SD_SHA512))
	{
		if(strlen($SD_SHA512) > 250)
			$error_message = $ap_lang["Field"] . " Sd Sha512 " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Sdsha512

	if(isset($sdSha512))
	{
		if(strlen($sdSha512) > 250)
			$error_message = $ap_lang["Field"] . " Sdsha512 " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgtranerrortext

	if(isset($pgTranErrorText))
	{
		if(strlen($pgTranErrorText) > 250)
			$error_message = $ap_lang["Field"] . " Pgtranerrortext " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Pgtranerrorcode

	if(isset($pgTranErrorCode))
	{
		if(strlen($pgTranErrorCode) > 250)
			$error_message = $ap_lang["Field"] . " Pgtranerrorcode " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Errorcode

	if(isset($errorCode))
	{
		if(strlen($errorCode) > 250)
			$error_message = $ap_lang["Field"] . " Errorcode " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Responsecode

	if(isset($responseCode))
	{
		if(strlen($responseCode) > 250)
			$error_message = $ap_lang["Field"] . " Responsecode " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Responsemsg

	if(isset($responseMsg))
	{
		if(strlen($responseMsg) > 250)
			$error_message = $ap_lang["Field"] . " Responsemsg " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company Location

	if(isset($company_location))
	{
		if(!is_numeric($company_location) && $company_location != "NULL")
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be number!"];
		
		if(strlen($company_location) > 11)
			$error_message = $ap_lang["Field"] . " Company Location " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//=================================================================================================
//================ ERROR HANDLER FOR VARIABLES - END ==============================================
//=================================================================================================
	
	if($error_message == "")
	{
		if($_POST["promote"] == "yes")
		{
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checkerDate = date("Y-m-d H:i:s");
			if($noviobjekat->checker == ""){
				if(file_exists("promote_custom.php")){
					include_once "promote_custom.php";
				}
			}
		}
		else
		{
			$checker = "";
			$checkerDate = $purchase->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new purchase($id,$user,$price,$to_company,$to_us,$duration_days,$number_of_passes,$start_date,$end_date,$purchase_type,$company_flag,$po_name,$po_address,$po_city,$po_postal,$card_package,$user_card,$card_active_token,$returnUrl,$merchantPaymentId,$apiMerchantId,$paymentSystem,$paymentSystemType,$paymentSystemEftCode,$pgTranDate,$pgTranId,$pgTranRefId,$pgOrderId,$customerId,$amount,$installment,$sessionToken,$random_string,$SD_SHA512,$sdSha512,$pgTranErrorText,$pgTranErrorCode,$errorCode,$responseCode,$responseMsg,$company_location,$purchase->maker,$purchase->makerDate,$checker,$checkerDate,$purchase->pozicija,$purchase->jezik,$purchase->recordStatus,$purchase->modNumber+1,$purchase->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"purchase","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$purchase = $broker->get_data(new purchase($_GET["id"]));
foreach($purchase as $key => $value)
	$purchase->$key = htmlentities($purchase->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$purchase->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

$start_date = explode("-",$purchase->start_date);
$purchase->start_date = $start_date[1]."/".$start_date[2]."/".$start_date[0];

$end_date = explode("-",$purchase->end_date);
$purchase->end_date = $end_date[1]."/".$end_date[2]."/".$end_date[0];

if(isset($_POST["promote"]) && $purchase->checker == "")	
	$purchase->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Purchase</h1>
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
<table>
<?php if($edit_disabled){ ?>
<?php }else{ ?>
<tr>
	<td style="width:160px;"></td>
	<?php if($_SESSION[ADMINCHECKER] == 1 || $_SESSION[ADMINMAKER] == 1){ ?>
	<td><button name="submit-edit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
	<?php } ?>
</tr>
<?php } ?>

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
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($purchase->checker != ""){ ?>
	<input type="checkbox" name="promote" value="yes" checked="checked"/>	
	<?php }else{ ?>
	<input type="checkbox" name="promote" value="yes"/>	
	<?php } ?>
	</td>
</tr>
<?php } ?>
<?php if($edit_disabled){ ?>
<?php }else{ ?>
<tr>
	<td class="last"></td>
	<?php if($_SESSION[ADMINCHECKER] == 1 || $_SESSION[ADMINMAKER] == 1){ ?>
	<td class="last"><button name="submit-edit" type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
	<?php } ?>
</tr>
<?php } ?>
</table>
</form>
     		</div>
		</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

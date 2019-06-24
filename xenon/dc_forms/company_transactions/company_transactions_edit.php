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
$company_transactions = $broker->get_data(new company_transactions($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - training_school
require_once "../classes/domain/training_school.class.php";
$training_school = new training_school();
$training_school->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$training_school->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$training_school->add_condition("recordStatus","=","O");
$training_school->add_condition("jezik","=",$filter_lang);
$training_school->set_order_by("name","ASC");
$all_training_school = $broker->get_all_data_condition($training_school);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $company_transactions->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$transaction_type = $_POST["transaction_type"];
	$transaction_value = $_POST["transaction_value"];
	$transaction_date = explode("/",$_POST["transaction_date"]);
	$transaction_date = $transaction_date[2]."-".$transaction_date[0]."-".$transaction_date[1];
	$_POST["transaction_date"] = $transaction_date;
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Transaction Type

	if(isset($transaction_type))
	{
		if(strlen($transaction_type) > 250)
			$error_message = $ap_lang["Field"] . " Transaction Type " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
			$checkerDate = $company_transactions->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new company_transactions($id,$training_school,$transaction_type,$transaction_value,$transaction_date,$company_transactions->maker,$company_transactions->makerDate,$checker,$checkerDate,$company_transactions->pozicija,$company_transactions->jezik,$company_transactions->recordStatus,$company_transactions->modNumber+1,$company_transactions->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_transactions","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$company_transactions = $broker->get_data(new company_transactions($_GET["id"]));
foreach($company_transactions as $key => $value)
	$company_transactions->$key = htmlentities($company_transactions->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$company_transactions->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

$transaction_date = explode("-",$company_transactions->transaction_date);
$company_transactions->transaction_date = $transaction_date[1]."/".$transaction_date[2]."/".$transaction_date[0];

if(isset($_POST["promote"]) && $company_transactions->checker == "")	
	$company_transactions->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Company transactions</h1>
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
<input type="hidden" name="id" value="<?php echo $company_transactions->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_transactions->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $company_transactions->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($company_transactions->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
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
		count_input_limit("transaction_type");
		
	});
</script>
<tr>
<td>Transaction Type <span id="transaction_type_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_transactions->transaction_type; 
		}else{ 
	?>
	<input type="text" name="transaction_type" value="<?php echo $company_transactions->transaction_type; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('transaction_type')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE DROPMENUFIXED-->
<tr>
<td>Transaction Value</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $company_transactions->transaction_value; }else{ ?><select name="transaction_value">
<option value="debit" 
<?php if($company_transactions->transaction_value == "" || $company_transactions->transaction_value == "debit"){ ?>selected="selected"<?php } ?>>debit</option><br />
<option value="credit" 
<?php if($company_transactions->transaction_value == "credit"){ ?>selected="selected"<?php } ?>>credit</option><br />
</select>
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
		$("#transaction_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>Transaction Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($company_transactions->transaction_date)); }else{ ?>
<input type="text" name="transaction_date" id="transaction_date" value="<?php if($company_transactions->transaction_date == "" || $company_transactions->transaction_date == NULL){ echo date('m/d/Y'); } else{ echo $company_transactions->transaction_date; } ?>" />
<?php } ?>
</td>
</tr>	
<?php if($company_transactions->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_transactions->maker; ?> (<?php  echo $company_transactions->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_transactions->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_transactions->checker; ?> (<?php  echo $company_transactions->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_transactions->checker != ""){ ?>
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

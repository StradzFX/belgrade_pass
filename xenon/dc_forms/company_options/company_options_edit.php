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
$company_options = $broker->get_data(new company_options($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $company_options->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$company = $_POST["company"];
	$tag = $_POST["tag"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Company

	if(isset($company))
	{
		if(!is_numeric($company) && $company != "NULL")
			$error_message = $ap_lang["Field"] . " Company " . $ap_lang["must be number!"];
		
		if(strlen($company) > 11)
			$error_message = $ap_lang["Field"] . " Company " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Tag

	if(isset($tag))
	{
		if(strlen($tag) > 250)
			$error_message = $ap_lang["Field"] . " Tag " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
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
			$checkerDate = $company_options->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new company_options($id,$company,$tag,$company_options->maker,$company_options->makerDate,$checker,$checkerDate,$company_options->pozicija,$company_options->jezik,$company_options->recordStatus,$company_options->modNumber+1,$company_options->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"company_options","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$company_options = $broker->get_data(new company_options($_GET["id"]));
foreach($company_options as $key => $value)
	$company_options->$key = htmlentities($company_options->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$company_options->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $company_options->checker == "")	
	$company_options->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Company options</h1>
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
<input type="hidden" name="id" value="<?php echo $company_options->id; ?>"/>
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
		count_input_limit("company");
		
	});
</script>
<tr>
<td>Company <span id="company_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_options->company; 
		}else{ 
	?>
	<input type="text" name="company" value="<?php echo $company_options->company; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('company')">
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
		count_input_limit("tag");
		
	});
</script>
<tr>
<td>Tag <span id="tag_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $company_options->tag; 
		}else{ 
	?>
	<input type="text" name="tag" value="<?php echo $company_options->tag; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('tag')">
	<?php } ?>
</td>
</tr>	
<?php if($company_options->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $company_options->maker; ?> (<?php  echo $company_options->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($company_options->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $company_options->checker; ?> (<?php  echo $company_options->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($company_options->checker != ""){ ?>
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

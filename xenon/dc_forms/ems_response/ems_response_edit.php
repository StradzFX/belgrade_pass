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
$ems_response = $broker->get_data(new ems_response($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $ems_response->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$whole_response = $_POST["whole_response"];
	$response_date = explode("/",$_POST["response_date"]);
	$response_date = $response_date[2]."-".$response_date[0]."-".$response_date[1];
	$_POST["response_date"] = $response_date;
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
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
			$checkerDate = $ems_response->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new ems_response($id,$whole_response,$response_date,$ems_response->maker,$ems_response->makerDate,$checker,$checkerDate,$ems_response->pozicija,$ems_response->jezik,$ems_response->recordStatus,$ems_response->modNumber+1,$ems_response->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"ems_response","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$ems_response = $broker->get_data(new ems_response($_GET["id"]));
foreach($ems_response as $key => $value)
	$ems_response->$key = htmlentities($ems_response->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$ems_response->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

$response_date = explode("-",$ems_response->response_date);
$ems_response->response_date = $response_date[1]."/".$response_date[2]."/".$response_date[0];

if(isset($_POST["promote"]) && $ems_response->checker == "")	
	$ems_response->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - ems_response</h1>
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
<input type="hidden" name="id" value="<?php echo $ems_response->id; ?>"/>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Whole Response</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $ems_response->whole_response; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="whole_response" rows="5" style="width:600px;height:250px;background-color:#FFF;border:1px;"><?php echo stripslashes($ems_response->whole_response); ?></textarea>
</div>
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
		$("#response_date").datepicker({
			showOn: 'button',
			buttonImage: 'js/datepicker/calendar.gif',
			buttonImageOnly: true
		});
	});
</script>
<tr>
<td>Response Date</td>
<td>
<?php if($_GET["action"] == "preview"){ echo date("d.m.Y",strtotime($ems_response->response_date)); }else{ ?>
<input type="text" name="response_date" id="response_date" value="<?php if($ems_response->response_date == "" || $ems_response->response_date == NULL){ echo date('m/d/Y'); } else{ echo $ems_response->response_date; } ?>" />
<?php } ?>
</td>
</tr>	
<?php if($ems_response->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $ems_response->maker; ?> (<?php  echo $ems_response->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($ems_response->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $ems_response->checker; ?> (<?php  echo $ems_response->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($ems_response->checker != ""){ ?>
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

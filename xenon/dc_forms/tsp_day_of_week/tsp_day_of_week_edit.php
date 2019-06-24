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
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - ts_programm
require_once "../classes/domain/ts_programm.class.php";
$ts_programm = new ts_programm();
$ts_programm->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$ts_programm->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$ts_programm->add_condition("recordStatus","=","O");
$ts_programm->add_condition("jezik","=",$filter_lang);
$ts_programm->set_order_by("name","ASC");
$all_ts_programm = $broker->get_all_data_condition($ts_programm);//==================== HANDLER FOR DROPMENU EXTENDED - trainer
require_once "../classes/domain/trainer.class.php";
$trainer = new trainer();
$trainer->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$trainer->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$trainer->add_condition("recordStatus","=","O");
$trainer->add_condition("jezik","=",$filter_lang);
$trainer->set_order_by("first_name","ASC");
$all_trainer = $broker->get_all_data_condition($trainer);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $tsp_day_of_week->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$ts_programm = $_POST["ts_programm"];
	$name = $_POST["name"];
	$day_of_week = $_POST["day_of_week"];
	$trainer = $_POST["trainer"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Ts Programm

	if(isset($ts_programm))
	{
		if(!is_numeric($ts_programm) && $ts_programm != "NULL")
			$error_message = $ap_lang["Field"] . " Ts Programm " . $ap_lang["must be number!"];
		
		if(strlen($ts_programm) > 11)
			$error_message = $ap_lang["Field"] . " Ts Programm " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Name

	if(isset($name))
	{
		if(strlen($name) > 250)
			$error_message = $ap_lang["Field"] . " Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Day Of_week

	if(isset($day_of_week))
	{
		if(!is_numeric($day_of_week) && $day_of_week != "NULL")
			$error_message = $ap_lang["Field"] . " Day Of_week " . $ap_lang["must be number!"];
		
		if(strlen($day_of_week) > 11)
			$error_message = $ap_lang["Field"] . " Day Of_week " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Trainer

	if(isset($trainer))
	{
		if(!is_numeric($trainer) && $trainer != "NULL")
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be number!"];
		
		if(strlen($trainer) > 11)
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $tsp_day_of_week->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new tsp_day_of_week($id,$ts_programm,$name,$day_of_week,$trainer,$tsp_day_of_week->maker,$tsp_day_of_week->makerDate,$checker,$checkerDate,$tsp_day_of_week->pozicija,$tsp_day_of_week->jezik,$tsp_day_of_week->recordStatus,$tsp_day_of_week->modNumber+1,$tsp_day_of_week->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"tsp_day_of_week","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$tsp_day_of_week = $broker->get_data(new tsp_day_of_week($_GET["id"]));
foreach($tsp_day_of_week as $key => $value)
	$tsp_day_of_week->$key = htmlentities($tsp_day_of_week->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$tsp_day_of_week->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $tsp_day_of_week->checker == "")	
	$tsp_day_of_week->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - TSP day of week</h1>
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
<input type="hidden" name="id" value="<?php echo $tsp_day_of_week->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Ts Programm</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $tsp_day_of_week->ts_programm; }else{ ?>
<select name="ts_programm" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_ts_programm);$i++)
{
	if($all_ts_programm[$i]->id == $tsp_day_of_week->ts_programm){ ?>
	<option value="<?php echo $all_ts_programm[$i]->id; ?>" <?php if($tsp_day_of_week->ts_programm == $all_ts_programm[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_ts_programm[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_ts_programm[$i]->id; ?>"><?php echo $all_ts_programm[$i]->name; ?></option>
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
		count_input_limit("name");
		
	});
</script>
<tr>
<td>Name <span id="name_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tsp_day_of_week->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $tsp_day_of_week->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
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
		count_input_limit("day_of_week");
		
	});
</script>
<tr>
<td>Day Of_week <span id="day_of_week_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $tsp_day_of_week->day_of_week; 
		}else{ 
	?>
	<input type="text" name="day_of_week" value="<?php echo $tsp_day_of_week->day_of_week; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('day_of_week')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Trainer</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $tsp_day_of_week->trainer; }else{ ?>
<select name="trainer" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_trainer);$i++)
{
	if($all_trainer[$i]->id == $tsp_day_of_week->trainer){ ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>" <?php if($tsp_day_of_week->trainer == $all_trainer[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>"><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>	
<?php if($tsp_day_of_week->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $tsp_day_of_week->maker; ?> (<?php  echo $tsp_day_of_week->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($tsp_day_of_week->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $tsp_day_of_week->checker; ?> (<?php  echo $tsp_day_of_week->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($tsp_day_of_week->checker != ""){ ?>
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

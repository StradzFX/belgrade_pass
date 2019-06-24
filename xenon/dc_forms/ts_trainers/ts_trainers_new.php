<?php
include_once "config.php";
include_once "php/functions.php";
$xenon_functions->validate_user();


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
$all_training_school = $broker->get_all_data_condition($training_school);//==================== HANDLER FOR DROPMENU EXTENDED - trainer
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
if($_POST["submit-new"]){

$id = $_POST["id"];
	$training_school = $_POST["training_school"];
	$trainer = $_POST["trainer"];
	

	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Training School

	if(isset($training_school))
	{
		if(!is_numeric($training_school) && $training_school != "NULL")
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be number!"];
		
		if(strlen($training_school) > 11)
			$error_message = $ap_lang["Field"] . " Training School " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Trainer

	if(isset($trainer))
	{
		if(!is_numeric($trainer) && $trainer != "NULL")
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be number!"];
		
		if(strlen($trainer) > 11)
			$error_message = $ap_lang["Field"] . " Trainer " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
	}

	if($error_message == "")
	{
		if($_POST["promote"] == "yes"){
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checkerDate = date("Y-m-d H:i:s");
			if(file_exists("promote_custom.php")){
				include_once "promote_custom.php";
			}
		}else{
			$checker = "";
			$checkerDate = $ts_trainers->checkerDate;
			if(file_exists("demote_custom.php")){
				include_once "demote_custom.php";
			}
		}
		
		if($_GET["filter_lang"])	$language = addslashes($_GET["filter_lang"]);
		else						$language = $filter_lang;
		
		$new_object = new ts_trainers();
		$new_object->training_school = $training_school;$new_object->trainer = $trainer;$new_object->maker = $_SESSION[ADMINLOGGEDIN];
		$new_object->makerDate = date("c");
		$new_object->checker = $checker;
		$new_object->checkerDate = $checkerDate;
		$new_object->jezik = $language;
		$new_object->recordStatus = "O";
		$new_dc_id = $broker->insert($new_object,false,false,true);
		if($new_dc_id > 0)
		{
			if(file_exists("insert_custom.php")){
				include_once "insert_custom.php";
			}
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"ts_trainers","new",$new_dc_id));
			$success_message = $ap_lang["This object was inserted successfully!"];
		}
		else	$error_message = $ap_lang["There was an error while inserting data!"];
	}
}
	
if($error_message != "")
{
	$ts_trainers = new ts_trainers();
	foreach($_POST as $key => $value)
		$ts_trainers->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");
	
	if(isset($_POST["promote"]))	$ts_trainers->checker = $_SESSION[ADMINLOGGEDIN];
	else							$ts_trainers->checker = "";
}
else	unset($ts_trainers);
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["New"]; ?> - TS Trainers</h1>
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
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<form action="" method="post" enctype="multipart/form-data">
<button type="button" onclick="location.href='<?php echo url_link("action=all&id&promote&pos"); ?>'" class="general"><?php echo $ap_lang["Back"]; ?></button>
<table>
<tr>
	<td class="last" style="width:160px;"></td>
	<td class="last"><button name="submit-new" type="submit" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
</tr>

<!--FORM TYPE HIDDEN-->
<input type="hidden" name="id" value="<?php echo $ts_trainers->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $ts_trainers->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $ts_trainers->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($ts_trainers->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>"><?php echo $all_training_school[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Trainer</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $ts_trainers->trainer; }else{ ?>
<select name="trainer" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_trainer);$i++)
{
	if($all_trainer[$i]->id == $ts_trainers->trainer){ ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>" <?php if($ts_trainers->trainer == $all_trainer[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_trainer[$i]->id; ?>"><?php echo $all_trainer[$i]->first_name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>	
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($ts_trainers->checker != ""){ ?>
	<input type="checkbox" name="promote" value="yes" checked="checked"/>	
	<?php }else{ ?>
	<input type="checkbox" name="promote" value="yes"/>	
	<?php } ?>
	</td>
</tr>
<?php } ?>
<tr>
	<td class="last"></td>
	<td class="last"><button name="submit-new" type="submit" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
</tr>
</table>
</form>  
		</div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

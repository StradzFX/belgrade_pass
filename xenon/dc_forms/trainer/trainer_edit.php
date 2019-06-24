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
$trainer = $broker->get_data(new trainer($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];//==================== HANDLER FOR DROPMENU EXTENDED - sport_category
require_once "../classes/domain/sport_category.class.php";
$sport_category = new sport_category();
$sport_category->set_condition("checker","!=","");
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$sport_category->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$sport_category->add_condition("recordStatus","=","O");
$sport_category->add_condition("jezik","=",$filter_lang);
$sport_category->set_order_by("name","ASC");
$all_sport_category = $broker->get_all_data_condition($sport_category);
if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $trainer->checker != "")
{
 	$warning_message = $ap_lang["You cannot edit this object because it is authorized!"];
	$edit_disabled = true;
}

if($_POST["submit-edit"])
{	
//================ POST VARIABLES INITIALIZATION
	$id = $_POST["id"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$photo = $_POST["photo"];
	$short_description = $_POST["short_description"];
	$sport_category = $_POST["sport_category"];
	
//=================================================================================================	
//================ ERROR HANDLER FOR VARIABLES - START ============================================
//=================================================================================================
	
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - First Name

	if(isset($first_name))
	{
		if(strlen($first_name) > 250)
			$error_message = $ap_lang["Field"] . " First Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Last Name

	if(isset($last_name))
	{
		if(strlen($last_name) > 250)
			$error_message = $ap_lang["Field"] . " Last Name " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Photo

	if(isset($photo))
	{
		if(strlen($photo) > 250)
			$error_message = $ap_lang["Field"] . " Photo " . $ap_lang["must be below"] . " 250 ". $ap_lang["characters!"];
	}
//================ ERROR HANDLER - INPUT|INPUT READONLY|DROPMENUEXT|DROPMENUPARENT ELEMENT - Sport Category

	if(isset($sport_category))
	{
		if(!is_numeric($sport_category) && $sport_category != "NULL")
			$error_message = $ap_lang["Field"] . " Sport Category " . $ap_lang["must be number!"];
		
		if(strlen($sport_category) > 11)
			$error_message = $ap_lang["Field"] . " Sport Category " . $ap_lang["must be below"] . " 11 ". $ap_lang["characters!"];
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
			$checkerDate = $trainer->checkerDate;
			
			if($noviobjekat->checker != ""){
				if(file_exists("demote_custom.php")){
					include_once "demote_custom.php";
				}
			}
		}
		
		
		if($broker->update(new trainer($id,$first_name,$last_name,$photo,$short_description,$sport_category,$trainer->maker,$trainer->makerDate,$checker,$checkerDate,$trainer->pozicija,$trainer->jezik,$trainer->recordStatus,$trainer->modNumber+1,$trainer->multilang_id)) == 1)
		{
			$success_message = $ap_lang["This object was edited successfully!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"trainer","edit",$_GET["id"]));
		}
		else	$error_message = $ap_lang["There was an error while editing data!"];
	}
}
$trainer = $broker->get_data(new trainer($_GET["id"]));
foreach($trainer as $key => $value)
	$trainer->$key = htmlentities($trainer->$key,ENT_COMPAT,"UTF-8");


if($error_message != "")
	foreach($_POST as $key => $value)
		$trainer->$key = htmlentities(stripslashes($_POST[$key]),ENT_COMPAT,"UTF-8");

if(isset($_POST["promote"]) && $trainer->checker == "")	
	$trainer->checker = $_SESSION[ADMINLOGGEDIN];
?>
<script src="js/wledit/wledit.js" type="text/javascript"></script>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Edit"]; ?> - Trainer</h1>
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
<input type="hidden" name="id" value="<?php echo $trainer->id; ?>"/>
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
			echo $trainer->first_name; 
		}else{ 
	?>
	<input type="text" name="first_name" value="<?php echo $trainer->first_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('first_name')">
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
			echo $trainer->last_name; 
		}else{ 
	?>
	<input type="text" name="last_name" value="<?php echo $trainer->last_name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('last_name')">
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
		count_input_limit("photo");
		
	});
</script>
<tr>
<td>Photo <span id="photo_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $trainer->photo; 
		}else{ 
	?>
	<input type="text" name="photo" value="<?php echo $trainer->photo; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('photo')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Short Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $trainer->short_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="short_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($trainer->short_description); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Sport Category</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $trainer->sport_category; }else{ ?>
<select name="sport_category" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_sport_category);$i++)
{
	if($all_sport_category[$i]->id == $trainer->sport_category){ ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>" <?php if($trainer->sport_category == $all_sport_category[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_sport_category[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>"><?php echo $all_sport_category[$i]->name; ?></option>
	<?php }
} ?>
</select>
<?php } ?>
</td>
</tr>	
<?php if($trainer->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $trainer->maker; ?> (<?php  echo $trainer->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($trainer->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $trainer->checker; ?> (<?php  echo $trainer->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($_SESSION[ADMINCHECKER] == 1){ ?>
<tr>
	<td><?php echo $ap_lang["Show online"]; ?></td>
	<td>
	<?php if($trainer->checker != ""){ ?>
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

<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/trainer.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

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
$trainer = $broker->get_data(new trainer($_GET["id"]));
require_once "../classes/domain/sport_category.class.php";
$sport_category = $broker->get_data(new sport_category($trainer->sport_category));
$trainer->sport_category = $sport_category->name;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_sport_category"]) 		$filter_sport_category = $_GET["filter_sport_category"];
else							$filter_sport_category = "all";

$dc_objects = new trainer();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("first_name","LIKE","%".$search."%","OR");
	$array_som[] = array("last_name","LIKE","%".$search."%","OR");
	$array_som[] = array("photo","LIKE","%".$search."%","OR");
	$array_som[] = array("short_description","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("sport_category","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_first_name != "all" && $filter_first_name != "")
	$dc_objects->add_condition("first_name","=",$filter_first_name);

if($filter_last_name != "all" && $filter_last_name != "")
	$dc_objects->add_condition("last_name","=",$filter_last_name);

if($filter_photo != "all" && $filter_photo != "")
	$dc_objects->add_condition("photo","=",$filter_photo);

if($filter_short_description != "all" && $filter_short_description != "")
	$dc_objects->add_condition("short_description","=",$filter_short_description);

if($filter_sport_category != "all" && $filter_sport_category != "")
	$dc_objects->add_condition("sport_category","=",$filter_sport_category);	

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new trainer();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new trainer();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$trainer->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new trainer();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$trainer->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new trainer();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Trainer</h1>
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
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

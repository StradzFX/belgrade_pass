<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/proba.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$proba = $broker->get_data(new proba($_GET["id"]));

if($_GET["filter_lang"])	$filter_lang = $_GET["filter_lang"];
else $filter_lang = $_SESSION[FRONTENDLANG];
$proba = $broker->get_data(new proba($_GET["id"]));
if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_godine"]) 		$filter_godine = $_GET["filter_godine"];
else							$filter_godine = "all";

$dc_objects = new proba();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("prezime","LIKE","%".$search."%","OR");
	$array_som[] = array("ime","LIKE","%".$search."%","OR");
	$array_som[] = array("opis","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("godine","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_prezime != "all" && $filter_prezime != "")
	$dc_objects->add_condition("prezime","=",$filter_prezime);

if($filter_ime != "all" && $filter_ime != "")
	$dc_objects->add_condition("ime","=",$filter_ime);

$element = "";
if($filter_godine == "yes")		$element = 1;
if($filter_godine == "no")		$element = 0;
if($filter_godine != "all" && $filter_godine != "")
	$dc_objects->add_condition("godine","=",$element);

if($filter_opis != "all" && $filter_opis != "")
	$dc_objects->add_condition("opis","=",$filter_opis);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new proba();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new proba();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$proba->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new proba();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$proba->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new proba();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Proba</h1>
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
<input type="hidden" name="id" value="<?php echo $proba->id; ?>"/>
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
		count_input_limit("prezime");
		
	});
</script>
<tr>
<td>Prezime <span id="prezime_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $proba->prezime; 
		}else{ 
	?>
	<input type="text" name="prezime" value="<?php echo $proba->prezime; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('prezime')">
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
		count_input_limit("ime");
		
	});
</script>
<tr>
<td>Ime <span id="ime_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $proba->ime; 
		}else{ 
	?>
	<input type="text" name="ime" value="<?php echo $proba->ime; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('ime')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE CHECKBOX-->
<tr>
<td>Godine</td>
<td>
<?php if($_GET["action"] == "preview"){
if($proba->godine == 1){echo $ap_lang["Yes"];}else{echo $ap_lang["No"];}
}else{ ?>
<input type="checkbox" name="godine" <?php if($proba->godine == 1) { ?> checked="checked" <?php } ?>/>
<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Opis</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $proba->opis; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="opis" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($proba->opis); ?></textarea>
</div>
<?php } ?>
</td>
</tr>	
<?php if($proba->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $proba->maker; ?> (<?php  echo $proba->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($proba->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $proba->checker; ?> (<?php  echo $proba->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/ts_location.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$ts_location = $broker->get_data(new ts_location($_GET["id"]));

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
$ts_location = $broker->get_data(new ts_location($_GET["id"]));
require_once "../classes/domain/training_school.class.php";
$training_school = $broker->get_data(new training_school($ts_location->training_school));
$ts_location->training_school = $training_school->name;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_training_school"]) 		$filter_training_school = $_GET["filter_training_school"];
else							$filter_training_school = "all";

$dc_objects = new ts_location();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("city","LIKE","%".$search."%","OR");
	$array_som[] = array("part_of_city","LIKE","%".$search."%","OR");
	$array_som[] = array("street","LIKE","%".$search."%","OR");
	$array_som[] = array("username","LIKE","%".$search."%","OR");
	$array_som[] = array("password","LIKE","%".$search."%","OR");
	$array_som[] = array("email","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("training_school","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_training_school != "all" && $filter_training_school != "")
	$dc_objects->add_condition("training_school","=",$filter_training_school);	

if($filter_city != "all" && $filter_city != "")
	$dc_objects->add_condition("city","=",$filter_city);

if($filter_part_of_city != "all" && $filter_part_of_city != "")
	$dc_objects->add_condition("part_of_city","=",$filter_part_of_city);

if($filter_street != "all" && $filter_street != "")
	$dc_objects->add_condition("street","=",$filter_street);

if($filter_username != "all" && $filter_username != "")
	$dc_objects->add_condition("username","=",$filter_username);

if($filter_password != "all" && $filter_password != "")
	$dc_objects->add_condition("password","=",$filter_password);

if($filter_email != "all" && $filter_email != "")
	$dc_objects->add_condition("email","=",$filter_email);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new ts_location();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new ts_location();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$ts_location->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new ts_location();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$ts_location->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new ts_location();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - TS Location</h1>
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
<input type="hidden" name="id" value="<?php echo $ts_location->id; ?>"/>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Training School</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $ts_location->training_school; }else{ ?>
<select name="training_school" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_training_school);$i++)
{
	if($all_training_school[$i]->id == $ts_location->training_school){ ?>
	<option value="<?php echo $all_training_school[$i]->id; ?>" <?php if($ts_location->training_school == $all_training_school[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_training_school[$i]->name; ?></option>
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
		count_input_limit("city");
		
	});
</script>
<tr>
<td>City <span id="city_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->city; 
		}else{ 
	?>
	<input type="text" name="city" value="<?php echo $ts_location->city; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('city')">
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
		count_input_limit("part_of_city");
		
	});
</script>
<tr>
<td>Part Of_city <span id="part_of_city_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->part_of_city; 
		}else{ 
	?>
	<input type="text" name="part_of_city" value="<?php echo $ts_location->part_of_city; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('part_of_city')">
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
		count_input_limit("street");
		
	});
</script>
<tr>
<td>Street <span id="street_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->street; 
		}else{ 
	?>
	<input type="text" name="street" value="<?php echo $ts_location->street; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('street')">
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
		count_input_limit("latitude");
		
	});
</script>
<tr>
<td>Latitude <span id="latitude_counter" style="color:#999">(11,6)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->latitude; 
		}else{ 
	?>
	<input type="text" name="latitude" value="<?php echo $ts_location->latitude; ?>" style="width:600px;" limit="11,6" onkeyup="count_input_limit('latitude')">
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
		count_input_limit("longitude");
		
	});
</script>
<tr>
<td>Longitude <span id="longitude_counter" style="color:#999">(11,6)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->longitude; 
		}else{ 
	?>
	<input type="text" name="longitude" value="<?php echo $ts_location->longitude; ?>" style="width:600px;" limit="11,6" onkeyup="count_input_limit('longitude')">
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
		count_input_limit("username");
		
	});
</script>
<tr>
<td>Username <span id="username_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->username; 
		}else{ 
	?>
	<input type="text" name="username" value="<?php echo $ts_location->username; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('username')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $ts_location->password != ""){ ?>
	$('table').delegate('[name=change_password]', 'click', function() {
	  		$(this).closest('tr').hide( function() {
		 	$('.insert_password').show();
			$('[name="password_changed"]').val('1');
	  	});
	});
<?php }else{ ?>	
	$(function() {
		$('[name=change_password]').closest('tr').hide();
		$('.insert_password').show();
		$('[name="password_changed"]').val('1');
	});
<?php } ?>
</script>
<input type="hidden" name="password_changed" value="0"/>
<tr>
<td>Password</td>
<td><button type="button" name="change_password"><?php echo $ap_lang["Change"]; ?></button></td>
</tr>
<tr class="insert_password" style="display:none">
<td>Password</td>
<td>
<?php if($_GET["action"] == "preview"){ if($ts_location->password != "" || $ts_location->password != NULL ){?>**********<?php } }else{ ?>
<input type="password" name="password" value="" style="width:600px;">
<?php } ?>
</td>
</tr>
<tr class="insert_password" style="display:none">
<?php if($_GET["action"] != "preview"){ ?>
<td><?php echo $ap_lang["Confirm"]; ?> Password</td>
<td>
<input type="password" name="password_confirm" value="" style="width:600px;">
</td>
</tr>
<?php } ?>

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
		count_input_limit("email");
		
	});
</script>
<tr>
<td>Email <span id="email_counter" style="color:#999">(250)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $ts_location->email; 
		}else{ 
	?>
	<input type="text" name="email" value="<?php echo $ts_location->email; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('email')">
	<?php } ?>
</td>
</tr>	
<?php if($ts_location->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $ts_location->maker; ?> (<?php  echo $ts_location->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($ts_location->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $ts_location->checker; ?> (<?php  echo $ts_location->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

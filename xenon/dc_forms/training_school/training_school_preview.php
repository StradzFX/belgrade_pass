<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}
require_once "../classes/domain/training_school.class.php";
require_once "config.php";
include_once "php/functions.php";

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

$training_school = $broker->get_data(new training_school($_GET["id"]));

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
$training_school = $broker->get_data(new training_school($_GET["id"]));
require_once "../classes/domain/sport_category.class.php";
$sport_category = $broker->get_data(new sport_category($training_school->sport_category));
$training_school->sport_category = $sport_category->name;

if($_GET["search"]) 			$search = $_GET["search"];
else							$search = "";
if($_GET["filter_sport_category"]) 		$filter_sport_category = $_GET["filter_sport_category"];
else							$filter_sport_category = "all";

$dc_objects = new training_school();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("name","LIKE","%".$search."%","OR");
	$array_som[] = array("into_text","LIKE","%".$search."%","OR");
	$array_som[] = array("general_text","LIKE","%".$search."%","OR");
	$array_som[] = array("short_description","LIKE","%".$search."%","OR");
	$array_som[] = array("main_description","LIKE","%".$search."%","OR");
	$array_som[] = array("username","LIKE","%".$search."%","OR");
	$array_som[] = array("password","LIKE","%".$search."%","OR");
	$array_som[] = array("discount_description","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("sport_category","=",$search,"OR");
		$array_som[] = array("featured","=",$search,"OR");
		$array_som[] = array("number_of_views","=",$search,"OR");
		$array_som[] = array("promoted","=",$search,"OR");
		$array_som[] = array("pass_options","=",$search,"OR");
		$array_som[] = array("extra_goods_options","=",$search,"OR");
		$array_som[] = array("birthday_options","=",$search,"OR");
		$array_som[] = array("pass_customer_percentage","=",$search,"OR");
		$array_som[] = array("pass_company_percentage","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION

if($filter_name != "all" && $filter_name != "")
	$dc_objects->add_condition("name","=",$filter_name);

if($filter_into_text != "all" && $filter_into_text != "")
	$dc_objects->add_condition("into_text","=",$filter_into_text);

if($filter_general_text != "all" && $filter_general_text != "")
	$dc_objects->add_condition("general_text","=",$filter_general_text);

if($filter_sport_category != "all" && $filter_sport_category != "")
	$dc_objects->add_condition("sport_category","=",$filter_sport_category);	

if($filter_short_description != "all" && $filter_short_description != "")
	$dc_objects->add_condition("short_description","=",$filter_short_description);

if($filter_main_description != "all" && $filter_main_description != "")
	$dc_objects->add_condition("main_description","=",$filter_main_description);

if($filter_username != "all" && $filter_username != "")
	$dc_objects->add_condition("username","=",$filter_username);

if($filter_password != "all" && $filter_password != "")
	$dc_objects->add_condition("password","=",$filter_password);

if($filter_discount_description != "all" && $filter_discount_description != "")
	$dc_objects->add_condition("discount_description","=",$filter_discount_description);

$dc_objects->add_condition("jezik","=",$filter_lang);
$dc_objects->set_order_by("pozicija","DESC");

$min_item = new training_school();
$min_item->condition = $dc_objects->condition;
$min_item->order_by = $dc_objects->order_by;
$min_item->add_condition("pozicija","=",$broker->get_min_position_condition($min_item));
$min_item = $broker->get_all_data_condition($min_item);
$min_item = $min_item[0]->id;

$sec_to_min = new training_school();
$sec_to_min->condition = $dc_objects->condition;
$sec_to_min->order_by = $dc_objects->order_by;
$sec_to_min->add_condition("pozicija","<",$training_school->pozicija);
$sec_to_min->set_order_by("pozicija","DESC");
$sec_to_min->set_limit(1,0);
$sec_to_min = $broker->get_all_data_condition_limited($sec_to_min);
$sec_to_min = $sec_to_min[0]->id;

$sec_to_max = new training_school();
$sec_to_max->condition = $dc_objects->condition;
$sec_to_max->order_by = $dc_objects->order_by;
$sec_to_max->add_condition("pozicija",">",$training_school->pozicija);
$sec_to_max->set_order_by("pozicija","ASC");
$sec_to_max->set_limit(1,0);
$sec_to_max = $broker->get_all_data_condition_limited($sec_to_max);
$sec_to_max = $sec_to_max[0]->id;

$max_item = new training_school();
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
	<h1><?php echo $ap_lang["Preview"]; ?> - Training school</h1>
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
<input type="hidden" name="id" value="<?php echo $training_school->id; ?>"/>
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
			echo $training_school->name; 
		}else{ 
	?>
	<input type="text" name="name" value="<?php echo $training_school->name; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('name')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Into Text</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->into_text; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="into_text" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->into_text); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>General Text</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->general_text; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="general_text" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->general_text); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE EXTERN CLASS DROPMENUEXT-->
<tr>
<td>Sport Category</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->sport_category; }else{ ?>
<select name="sport_category" style="width:600px;">
<option value="NULL">---</option>
<?php for($i=0;$i<sizeof($all_sport_category);$i++)
{
	if($all_sport_category[$i]->id == $training_school->sport_category){ ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>" <?php if($training_school->sport_category == $all_sport_category[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_sport_category[$i]->name; ?></option>
	<?php }else{  ?>
	<option value="<?php echo $all_sport_category[$i]->id; ?>"><?php echo $all_sport_category[$i]->name; ?></option>
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
		count_input_limit("featured");
		
	});
</script>
<tr>
<td>Featured <span id="featured_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->featured; 
		}else{ 
	?>
	<input type="text" name="featured" value="<?php echo $training_school->featured; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('featured')">
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
		count_input_limit("number_of_views");
		
	});
</script>
<tr>
<td>Number Of_views <span id="number_of_views_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->number_of_views; 
		}else{ 
	?>
	<input type="text" name="number_of_views" value="<?php echo $training_school->number_of_views; ?>" style="width:200px;" limit="11" onkeyup="count_input_limit('number_of_views')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Short Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->short_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="short_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->short_description); ?></textarea>
</div>
<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Main Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->main_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="main_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->main_description); ?></textarea>
</div>
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
		count_input_limit("promoted");
		
	});
</script>
<tr>
<td>Promoted <span id="promoted_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->promoted; 
		}else{ 
	?>
	<input type="text" name="promoted" value="<?php echo $training_school->promoted; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('promoted')">
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
			echo $training_school->username; 
		}else{ 
	?>
	<input type="text" name="username" value="<?php echo $training_school->username; ?>" style="width:600px;" limit="250" onkeyup="count_input_limit('username')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE PASSWORD-->
<script>
<?php 
	if($error_message == "" && $training_school->password != ""){ ?>
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
<?php if($_GET["action"] == "preview"){ if($training_school->password != "" || $training_school->password != NULL ){?>**********<?php } }else{ ?>
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
		count_input_limit("pass_options");
		
	});
</script>
<tr>
<td>Pass Options <span id="pass_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_options; 
		}else{ 
	?>
	<input type="text" name="pass_options" value="<?php echo $training_school->pass_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_options')">
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
		count_input_limit("extra_goods_options");
		
	});
</script>
<tr>
<td>Extra Goods_options <span id="extra_goods_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->extra_goods_options; 
		}else{ 
	?>
	<input type="text" name="extra_goods_options" value="<?php echo $training_school->extra_goods_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('extra_goods_options')">
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
		count_input_limit("birthday_options");
		
	});
</script>
<tr>
<td>Birthday Options <span id="birthday_options_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->birthday_options; 
		}else{ 
	?>
	<input type="text" name="birthday_options" value="<?php echo $training_school->birthday_options; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('birthday_options')">
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
		count_input_limit("pass_customer_percentage");
		
	});
</script>
<tr>
<td>Pass Customer_percentage <span id="pass_customer_percentage_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_customer_percentage; 
		}else{ 
	?>
	<input type="text" name="pass_customer_percentage" value="<?php echo $training_school->pass_customer_percentage; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_customer_percentage')">
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
		count_input_limit("pass_company_percentage");
		
	});
</script>
<tr>
<td>Pass Company_percentage <span id="pass_company_percentage_counter" style="color:#999">(11)</span></td>
	
<td>
	<?php 
		if($_GET["action"] == "preview"){ 
			echo $training_school->pass_company_percentage; 
		}else{ 
	?>
	<input type="text" name="pass_company_percentage" value="<?php echo $training_school->pass_company_percentage; ?>" style="width:600px;" limit="11" onkeyup="count_input_limit('pass_company_percentage')">
	<?php } ?>
</td>
</tr>
<!--FORM TYPE WLEDITOR-->
<tr>
<td>Discount Description</td>
<td>
<?php if($_GET["action"] == "preview"){ echo $training_school->discount_description; }else{ ?>
<div style="background-color:#FFF;border:1px #CCCCCC solid;">
<textarea name="discount_description" rows="5" style="width:600px;height:100px;background-color:#FFF;border:1px;"><?php echo stripslashes($training_school->discount_description); ?></textarea>
</div>
<?php } ?>
</td>
</tr>	
<?php if($training_school->maker != ""){ ?>
<tr>
	<td><?php echo $ap_lang["Maker"]; ?></td>
	<td>
	<?php  echo $training_school->maker; ?> (<?php  echo $training_school->makerDate; ?>)
	</td>
</tr>
<?php } ?>
<?php if($training_school->checker != "" && $error_message == ""){ ?>
<tr>
	<td><?php echo $ap_lang["Checker"]; ?></td>
	<td>
	<?php  echo $training_school->checker; ?> (<?php  echo $training_school->checkerDate; ?>)
	</td>
</tr>
<?php } ?>
</table>
                </form>
     		</div>
        </div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

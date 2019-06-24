<?php
$spisak_fajlova = scandir("../classes/domain");
for($i=0;$i<sizeof($spisak_fajlova);$i++){
	if($spisak_fajlova[$i] != "." && $spisak_fajlova[$i] != ".." && $spisak_fajlova[$i] != "base_domain_object.php"){
		require_once "../classes/domain/".$spisak_fajlova[$i];
	}
}

include_once "php/functions.php";
error_reporting(E_ERROR);
$all_languages = new xenon_languages();
$all_languages->set_condition("active","=",1);
$all_languages = $broker->get_all_data_condition($all_languages);

if($_SESSION[ADMINAUTHDC][0] != "All")
{
	$dc_array = $_SESSION[ADMINAUTHDC];
	if(!in_array($_GET["page"],$dc_array))
		header ("Location: ".$_SERVER["PHP_SELF"]);
}

if($_GET["filter_lang"])
{
	$filter_lang = $_GET["filter_lang"];
	$_SESSION[FRONTENDLANG] = $_GET["filter_lang"];
}
else $filter_lang = $_SESSION[FRONTENDLANG];
if(isset($_GET["show"]) && is_numeric($_GET["show"]))	$show_num_of_rows = $_GET["show"];
else													$show_num_of_rows = 10;

//=================================================================================================
//================ PHP HANDLER FOR EXTENDED CLASSES - START =======================================
//=================================================================================================
	
//================ PHP HANDLER FOR DROPMENUEXT CLASS user	
require_once "../classes/domain/user.class.php";
$user = new user();
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user->add_condition("recordStatus","=","O");
$user->add_condition("jezik","=",$filter_lang);
$user->set_order_by("email","ASC");
$all_user = $broker->get_all_data_condition($user); 
	
//================ PHP HANDLER FOR DROPMENUEXT CLASS card_package	
require_once "../classes/domain/card_package.class.php";
$card_package = new card_package();
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$card_package->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$card_package->add_condition("recordStatus","=","O");
$card_package->add_condition("jezik","=",$filter_lang);
$card_package->set_order_by("name","ASC");
$all_card_package = $broker->get_all_data_condition($card_package); 
	
//================ PHP HANDLER FOR DROPMENUEXT CLASS user_card	
require_once "../classes/domain/user_card.class.php";
$user_card = new user_card();
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$user_card->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$user_card->add_condition("recordStatus","=","O");
$user_card->add_condition("jezik","=",$filter_lang);
$user_card->set_order_by("card_number","ASC");
$all_user_card = $broker->get_all_data_condition($user_card); 
	
//=================================================================================================
//================ PHP HANDLER FOR EXTENDED CLASSES - END =========================================
//=================================================================================================
	
if($_GET)
{
	$search = $_GET["search"];
	$filter_maker = $_GET["filter_maker"];
	$filter_status = $_GET["filter_status"];
	$filter_user = $_GET["filter_user"];
	$filter_card_package = $_GET["filter_card_package"];
	$filter_user_card = $_GET["filter_user_card"];
	
	if($_GET["sort_column"])
	{
		$sort_column = $_GET["sort_column"];
		$sort_direction = $_GET["sort_direction"];
		$sort_is_active = true;
	}
	else 
	{
		$sort_column = "pozicija";
		$sort_direction = "desc";
		$sort_is_active = false;
	}
}
else
{
	$search = "";
	$filter_maker = "all";
	$filter_status = "all";
//================ FILTER INITIALIZATION 
	$filter_user = "all";
	$filter_card_package = "all";
	$filter_user_card = "all";
	
}
if(!$_GET["nav"])	$nav_page = 1;
else				$nav_page = $_GET["nav"];

$dc_objects = new purchase();
$dc_objects->add_condition("recordStatus","=","O");
if($search != "")
{
//================ SEARCH FILTER INITIALIZATION 	

	$array_som[] = array("to_company","LIKE","%".$search."%","OR");
	$array_som[] = array("to_us","LIKE","%".$search."%","OR");
	$array_som[] = array("duration_days","LIKE","%".$search."%","OR");
	$array_som[] = array("purchase_type","LIKE","%".$search."%","OR");
	$array_som[] = array("company_flag","LIKE","%".$search."%","OR");
	$array_som[] = array("po_name","LIKE","%".$search."%","OR");
	$array_som[] = array("po_address","LIKE","%".$search."%","OR");
	$array_som[] = array("po_city","LIKE","%".$search."%","OR");
	$array_som[] = array("po_postal","LIKE","%".$search."%","OR");
	$array_som[] = array("card_active_token","LIKE","%".$search."%","OR");
	$array_som[] = array("returnUrl","LIKE","%".$search."%","OR");
	$array_som[] = array("merchantPaymentId","LIKE","%".$search."%","OR");
	$array_som[] = array("apiMerchantId","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystem","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystemType","LIKE","%".$search."%","OR");
	$array_som[] = array("paymentSystemEftCode","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranDate","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranId","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranRefId","LIKE","%".$search."%","OR");
	$array_som[] = array("pgOrderId","LIKE","%".$search."%","OR");
	$array_som[] = array("customerId","LIKE","%".$search."%","OR");
	$array_som[] = array("amount","LIKE","%".$search."%","OR");
	$array_som[] = array("installment","LIKE","%".$search."%","OR");
	$array_som[] = array("sessionToken","LIKE","%".$search."%","OR");
	$array_som[] = array("random_string","LIKE","%".$search."%","OR");
	$array_som[] = array("SD_SHA512","LIKE","%".$search."%","OR");
	$array_som[] = array("sdSha512","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranErrorText","LIKE","%".$search."%","OR");
	$array_som[] = array("pgTranErrorCode","LIKE","%".$search."%","OR");
	$array_som[] = array("errorCode","LIKE","%".$search."%","OR");
	$array_som[] = array("responseCode","LIKE","%".$search."%","OR");
	$array_som[] = array("responseMsg","LIKE","%".$search."%","OR");
	if(is_numeric($search))
	{
		$array_som[] = array("id","=",$search,"OR");
		$array_som[] = array("user","=",$search,"OR");
		$array_som[] = array("price","=",$search,"OR");
		$array_som[] = array("number_of_passes","=",$search,"OR");
		$array_som[] = array("card_package","=",$search,"OR");
		$array_som[] = array("user_card","=",$search,"OR");
		$array_som[] = array("company_location","=",$search,"OR");
	}	
	$dc_objects->add_group_condition($array_som,"AND");
}
//================ FILTER INITIALIZATION
if($filter_maker != "all" && $filter_maker != "")	$dc_objects->add_condition("maker","=",$filter_maker);
if($filter_status != "all" && $filter_status != "")	
{
	if($filter_status == "promoted")				$dc_objects->add_condition("checker","!=","");
	if($filter_status == "demoted")					$dc_objects->add_condition("checker","=","");
}

if($filter_user != "all" && $filter_user != "")
	$dc_objects->add_condition("user","=",$filter_user);	

if($filter_to_company != "all" && $filter_to_company != "")
	$dc_objects->add_condition("to_company","=",$filter_to_company);

if($filter_to_us != "all" && $filter_to_us != "")
	$dc_objects->add_condition("to_us","=",$filter_to_us);

if($filter_duration_days != "all" && $filter_duration_days != "")
	$dc_objects->add_condition("duration_days","=",$filter_duration_days);

if($filter_purchase_type != "all" && $filter_purchase_type != "")
	$dc_objects->add_condition("purchase_type","=",$filter_purchase_type);

if($filter_company_flag != "all" && $filter_company_flag != "")
	$dc_objects->add_condition("company_flag","=",$filter_company_flag);

if($filter_po_name != "all" && $filter_po_name != "")
	$dc_objects->add_condition("po_name","=",$filter_po_name);

if($filter_po_address != "all" && $filter_po_address != "")
	$dc_objects->add_condition("po_address","=",$filter_po_address);

if($filter_po_city != "all" && $filter_po_city != "")
	$dc_objects->add_condition("po_city","=",$filter_po_city);

if($filter_po_postal != "all" && $filter_po_postal != "")
	$dc_objects->add_condition("po_postal","=",$filter_po_postal);

if($filter_card_package != "all" && $filter_card_package != "")
	$dc_objects->add_condition("card_package","=",$filter_card_package);	

if($filter_user_card != "all" && $filter_user_card != "")
	$dc_objects->add_condition("user_card","=",$filter_user_card);	

if($filter_card_active_token != "all" && $filter_card_active_token != "")
	$dc_objects->add_condition("card_active_token","=",$filter_card_active_token);

if($filter_returnUrl != "all" && $filter_returnUrl != "")
	$dc_objects->add_condition("returnUrl","=",$filter_returnUrl);

if($filter_merchantPaymentId != "all" && $filter_merchantPaymentId != "")
	$dc_objects->add_condition("merchantPaymentId","=",$filter_merchantPaymentId);

if($filter_apiMerchantId != "all" && $filter_apiMerchantId != "")
	$dc_objects->add_condition("apiMerchantId","=",$filter_apiMerchantId);

if($filter_paymentSystem != "all" && $filter_paymentSystem != "")
	$dc_objects->add_condition("paymentSystem","=",$filter_paymentSystem);

if($filter_paymentSystemType != "all" && $filter_paymentSystemType != "")
	$dc_objects->add_condition("paymentSystemType","=",$filter_paymentSystemType);

if($filter_paymentSystemEftCode != "all" && $filter_paymentSystemEftCode != "")
	$dc_objects->add_condition("paymentSystemEftCode","=",$filter_paymentSystemEftCode);

if($filter_pgTranDate != "all" && $filter_pgTranDate != "")
	$dc_objects->add_condition("pgTranDate","=",$filter_pgTranDate);

if($filter_pgTranId != "all" && $filter_pgTranId != "")
	$dc_objects->add_condition("pgTranId","=",$filter_pgTranId);

if($filter_pgTranRefId != "all" && $filter_pgTranRefId != "")
	$dc_objects->add_condition("pgTranRefId","=",$filter_pgTranRefId);

if($filter_pgOrderId != "all" && $filter_pgOrderId != "")
	$dc_objects->add_condition("pgOrderId","=",$filter_pgOrderId);

if($filter_customerId != "all" && $filter_customerId != "")
	$dc_objects->add_condition("customerId","=",$filter_customerId);

if($filter_amount != "all" && $filter_amount != "")
	$dc_objects->add_condition("amount","=",$filter_amount);

if($filter_installment != "all" && $filter_installment != "")
	$dc_objects->add_condition("installment","=",$filter_installment);

if($filter_sessionToken != "all" && $filter_sessionToken != "")
	$dc_objects->add_condition("sessionToken","=",$filter_sessionToken);

if($filter_random_string != "all" && $filter_random_string != "")
	$dc_objects->add_condition("random_string","=",$filter_random_string);

if($filter_SD_SHA512 != "all" && $filter_SD_SHA512 != "")
	$dc_objects->add_condition("SD_SHA512","=",$filter_SD_SHA512);

if($filter_sdSha512 != "all" && $filter_sdSha512 != "")
	$dc_objects->add_condition("sdSha512","=",$filter_sdSha512);

if($filter_pgTranErrorText != "all" && $filter_pgTranErrorText != "")
	$dc_objects->add_condition("pgTranErrorText","=",$filter_pgTranErrorText);

if($filter_pgTranErrorCode != "all" && $filter_pgTranErrorCode != "")
	$dc_objects->add_condition("pgTranErrorCode","=",$filter_pgTranErrorCode);

if($filter_errorCode != "all" && $filter_errorCode != "")
	$dc_objects->add_condition("errorCode","=",$filter_errorCode);

if($filter_responseCode != "all" && $filter_responseCode != "")
	$dc_objects->add_condition("responseCode","=",$filter_responseCode);

if($filter_responseMsg != "all" && $filter_responseMsg != "")
	$dc_objects->add_condition("responseMsg","=",$filter_responseMsg);

$dc_objects->add_condition("jezik","=",$filter_lang);
if(unserialize($_SESSION[ADMINUSER])->see_other_data == 0 && property_exists("xenon_user","see_other_data")){
	$dc_objects->add_condition("maker","=",$_SESSION[ADMINLOGGEDIN]);
}
$dc_objects->set_order_by($sort_column,$sort_direction);
$dc_objects->set_limit($show_num_of_rows,$nav_page*$show_num_of_rows-$show_num_of_rows);

//================ PROMOTE ITEM PROCESSING
	if($_GET["promote"] != "")
	{
		if($_GET["promote"] == "1"){
			$action = "promote";
			$checker = $_SESSION[ADMINLOGGEDIN];
			$checker_date = date("Y-m-d H:i:s");
			include_once "promote_custom.php";
		}else{
			$action = "demote";
			$checker = "";
			$checker_date = "";
			include_once "demote_custom.php";
		}
		
		$purchase = $broker->get_data(new purchase($_GET["id"]));
		$purchase->checker = $checker;
		$purchase->checkerDate = $checker_date;
		foreach(get_class_vars(get_class($purchase)) as $name => $value)
		{
			$purchase->$name = addslashes($purchase->$name);
		}
		if($broker->update($purchase,true) >= 1)
			$dc_object = $broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"purchase",$action,$_GET["id"]),false,true,false);
	}
//================ DELETE ITEM PROCESSING
	if($_GET["delete"])
	{
		$dc_object = $broker->get_data(new purchase($_GET["delete"]));
		$dc_object->recordStatus = "C";
		foreach(get_class_vars(get_class($dc_object)) as $name => $value)
		{
			$dc_object->$name = addslashes($dc_object->$name);	
		}
		if($broker->update($dc_object) >= 1)	
		{
			$success_message = $ap_lang["Object has been successfully deleted!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"purchase","delete",$_GET["delete"]));
		}
		else	$error_message = $ap_lang["There was an error while deleting this element!"];
		
		include_once "delete_custom.php";
	}
//================ POSITION ITEM PROCESSING
	if($_GET["pos"])
	{
		$all_dc_objects = $broker->get_all_data_condition($dc_objects);
		for($i = 0 ; $i < sizeof($all_dc_objects) ; $i++)
		{
			if($all_dc_objects[$i]->id == $_GET["id"])
			{
				if($_GET["pos"] == "up"){
					$first = $all_dc_objects[$i];
					$second = $all_dc_objects[$i-1];
				}else{
					$first = $all_dc_objects[$i+1];
					$second = $all_dc_objects[$i];
				}
				$reserve = $first->pozicija;
				$first->pozicija = $second->pozicija;
				$second->pozicija = $reserve;
					
				$purchase = $broker->get_data(new purchase($first->id));
				$purchase->pozicija = $first->pozicija;
				foreach(get_class_vars(get_class($purchase)) as $name => $value)
				{
					$purchase->$name = addslashes($purchase->$name);	
				}
				$broker->update($purchase);
						
				$purchase = $broker->get_data(new purchase($second->id));
				$purchase->pozicija = $second->pozicija;
				foreach(get_class_vars(get_class($purchase)) as $name => $value)
				{
					$purchase->$name = addslashes($purchase->$name);		
				}
				$broker->update($purchase);
			}	
		}
		include_once "position_custom.php";
	}

$min_position = $broker->get_min_position_condition($dc_objects);
$max_position = $broker->get_max_position_condition($dc_objects);
$all_dc_objects = $broker->get_all_data_condition_limited($dc_objects,($nav_page-1)*$show_num_of_rows);
//session initializing for export_sql
$_SESSION["export_csv"] = serialize($dc_objects);
$_SESSION["export_dc"] = "purchase";

for($i=0; $i<sizeof($all_dc_objects); $i++)
{
	
	

	if($all_dc_objects[$i]->user != NULL){
		
		$all_dc_objects[$i]->user = $broker->get_data(new user($all_dc_objects[$i]->user));
	$all_dc_objects[$i]->user = $all_dc_objects[$i]->user->email;	
	
	}else{
		$all_dc_objects[$i]->user = "";
	}

}
for($i=0; $i<sizeof($all_dc_objects); $i++)
{
	
	

	if($all_dc_objects[$i]->card_package != NULL){
		
		$all_dc_objects[$i]->card_package = $broker->get_data(new card_package($all_dc_objects[$i]->card_package));
	$all_dc_objects[$i]->card_package = $all_dc_objects[$i]->card_package->name;	
	
	}else{
		$all_dc_objects[$i]->card_package = "";
	}

}
for($i=0; $i<sizeof($all_dc_objects); $i++)
{
	
	

	if($all_dc_objects[$i]->user_card != NULL){
		
		$all_dc_objects[$i]->user_card = $broker->get_data(new user_card($all_dc_objects[$i]->user_card));
	$all_dc_objects[$i]->user_card = $all_dc_objects[$i]->user_card->card_number;	
	
	}else{
		$all_dc_objects[$i]->user_card = "";
	}

}
$num_of_rows = $broker->get_count_condition($dc_objects);
$num_of_pages = sprintf(ceil($num_of_rows/$show_num_of_rows));
if($nav_page != 1)	$nav_page_left = $nav_page-1;
else 
{
	$nav_page_left = $nav_page;
	$first_page = true;
}
if($nav_page != $num_of_pages)	$nav_page_right = $nav_page+1;
else
{
	$nav_page_right = $num_of_pages;
	$last_page = true;
}
$sql = $broker->execute_query("select distinct `maker` from `purchase` where `recordStatus` = 'O'");
$makers = array();
while($row = $sql->fetch_assoc())
	$makers[] = $row["maker"];
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["List of all entries for object"]; ?> - Purchase</h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<div id="left_menu">
		<?php	include_once "php/dc_dashboard_menu.php";	?>
	</div><!--left_menu-->
	<div id="right_domain_object">
	<form action="" method="get" enctype="multipart/form-data">
		<input type="hidden" name="lang" value="<?php echo $_GET["lang"]; ?>" />
		<input type="hidden" name="type" value="<?php echo $_GET["type"]; ?>" />
		<input type="hidden" name="page" value="<?php echo $_GET["page"]; ?>" />
		<input type="hidden" name="action" value="<?php echo $_GET["action"]; ?>" />
	<div id="search">
		<input type="text" name="search" value="<?php echo $search; ?>" />
		<button type="submit" class="search" value="<?php echo $ap_lang["Search"]; ?>"><?php echo $ap_lang["Search"]; ?></button>
	</div><!--search-->
	<br />
	<div id="filters">
	<fieldset>
		<legend><?php echo $ap_lang["Search filters"]; ?></legend>
		<?php if(sizeof($all_languages)>1) { ?>
			<div class="item">
			<label><?php echo $ap_lang["Language"]; ?></label> 
			<select name="filter_lang" onchange="submit()">
				<?php for($i=0; $i < sizeof($all_languages); $i++) { ?> 
				<option value="<?php echo $all_languages[$i]->short; ?>" <?php if($filter_lang == $all_languages[$i]->short){ ?>selected="selected"<?php } ?>><?php echo $all_languages[$i]->name; ?></option>
				<?php } ?>
			</select>
			</div>
		<?php } ?>
		<?php if(unserialize($_SESSION[ADMINUSER])->see_other_data != 0 || !property_exists("xenon_user","see_other_data")){ ?>
    	<div class="item">
		<label><?php echo $ap_lang["Maker"]; ?></label> 
		<select name="filter_maker" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
            <?php for($i=0;$i<sizeof($makers);$i++){ ?>
 			<option value="<?php echo $makers[$i]; ?>" <?php if($filter_maker == $makers[$i]){ ?>selected="selected"<?php } ?>><?php echo $makers[$i]; ?></option>
			<?php }?>
		</select>
		</div>
		<?php } ?>
        <div class="item">
		<label><?php echo $ap_lang["Status"]; ?></label> 
		<select name="filter_status" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
 			<option value="promoted" <?php if($filter_status == "promoted"){ ?>selected="selected"<?php } ?>><?php echo $ap_lang["Online"]; ?></option>
        	<option value="demoted" <?php if($filter_status == "demoted"){ ?>selected="selected"<?php } ?>><?php echo $ap_lang["Offline"]; ?></option>
		</select>
		</div>
	
		<div class="item">
		<label>User</label> 
		<select name="filter_user" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
 		<?php for($i=0; $i < sizeof($all_user); $i++) { ?> 
			<option value="<?php echo $all_user[$i]->id; ?>" <?php if($filter_user == $all_user[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user[$i]->email; ?></option>
        <?php } ?>
		</select>
		</div>
		
		<div class="item">
		<label>Card Package</label> 
		<select name="filter_card_package" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
 		<?php for($i=0; $i < sizeof($all_card_package); $i++) { ?> 
			<option value="<?php echo $all_card_package[$i]->id; ?>" <?php if($filter_card_package == $all_card_package[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_card_package[$i]->name; ?></option>
        <?php } ?>
		</select>
		</div>
		
		<div class="item">
		<label>User Card</label> 
		<select name="filter_user_card" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
 		<?php for($i=0; $i < sizeof($all_user_card); $i++) { ?> 
			<option value="<?php echo $all_user_card[$i]->id; ?>" <?php if($filter_user_card == $all_user_card[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $all_user_card[$i]->card_number; ?></option>
        <?php } ?>
		</select>
		</div>
		
	</fieldset>
	<div style="clear:both;"></div>
	</div><!--filters-->	
	<?php if($_SESSION[ADMINMAKER]==1){ ?>
	<button type="button" onclick="location.href='<?php echo url_link("action=new&id&delete&promote&nav&pos"); ?>'" id="fleft" class="general"><?php echo $ap_lang["New"]; ?></button>
  	<?php } if($num_of_rows>0) { ?>
	<button type="button" onclick="location.href='php/export_csv.php'" class="general"><?php echo $ap_lang["Export CSV"]; ?></button>
	<div id="see_all_options">   
			<label><?php echo $ap_lang["Show"]; ?></label> 
			<select name="show" onchange="submit()" style="width:55px;">
                <option value="10" <?php if($show_num_of_rows == 10) {?>selected="selected" <?php } ?>>10</option>
                <option value="20" <?php if($show_num_of_rows == 20) {?>selected="selected" <?php } ?>><?php ?>20</option>
                <option value="50" <?php if($show_num_of_rows == 50) {?>selected="selected" <?php } ?>><?php ?>50</option>
                <option value="100" <?php if($show_num_of_rows == 100) {?>selected="selected" <?php } ?>><?php ?>100</option>
			</select>
			<?php
			$start_nav_num = $nav_page*$show_num_of_rows-($show_num_of_rows-1);
			$end_nav_num = $nav_page*$show_num_of_rows;
			if($end_nav_num>$num_of_rows)	
				$end_nav_num = $num_of_rows;
			if($first_page){ ?><button type="button" class="pagination_left"></button>
			<?php }else { ?><button type="button" onclick="location.href='<?php echo url_link("id&pos&promote&delete&nav=".$nav_page_left); ?>'" class="pagination_left"></button>
	  		<?php } if($last_page){ ?><button type="button" class="pagination_right"></button>
	  		<?php }else { ?><button type="button" onclick="location.href='<?php echo url_link("id&pos&promote&delete&nav=".$nav_page_right); ?>'" class="pagination_right"></button>
      		<?php } ?>
		<p><strong><?php echo $start_nav_num; ?>-<?php echo $end_nav_num; ?></strong> <?php echo $ap_lang["of"]; ?> <strong><?php echo $num_of_rows; ?></strong></p>
	</div><!--see_all_options-->
	<div style="clear:both;"></div>
	</form> 
	<div id="see_all"> 
	<table width="757" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35">
		<?php 
		if($sort_column=="id")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="id";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">ID</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="user")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="user";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">User</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="price")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="price";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Price</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="purchase_type")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="purchase_type";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Purchase Type</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="company_flag")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="company_flag";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Company Flag</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="card_package")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="card_package";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Card Package</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="user_card")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="user_card";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">User Card</a>
		</th>
		<th width="71">
		<?php 
		if($sort_column=="card_active_token")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="card_active_token";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Card Active_token</a>
		</th>
	<?php if(unserialize($_SESSION[ADMINUSER])->see_other_data != 0 || !property_exists("xenon_user","see_other_data")){ ?>
		<th width="64">
		<?php 
 		if($sort_column=="maker")
       		if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="maker";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang["Maker"]; ?></a>
		</th>
		<?php } ?>
		<th width="50">
		<?php 
       	if($sort_column=="checker")
    		if($sort_direction == "asc")	$sort_direction = "desc";
     		else							$sort_direction = "asc";
		$sort="checker";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang["Status"]; ?></a>
		</th>

		<?php include_once "custom_see_all_th.php"; ?>

		<th colspan="6" width="108">
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column&sort_direction"); ?>"><?php echo $ap_lang["Actions"]; ?></a>
		</th>
		</tr>
		</thead>
		<tbody>
        <?php for($i=0; $i<sizeof($all_dc_objects); $i++){ ?>
		<tr>
		<td><?php echo $all_dc_objects[$i]->id; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->user; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->price; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->purchase_type; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->company_flag; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->card_package; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->user_card; ?></td>
		<?php include_once "custom_td.php";?>
		
		<td><?php echo $all_dc_objects[$i]->card_active_token; ?></td>
		<?php include_once "custom_td.php";?>
		
<?php if(unserialize($_SESSION[ADMINUSER])->see_other_data != 0 || !property_exists("xenon_user","see_other_data")){ ?>
		<td><?php echo $all_dc_objects[$i]->maker; ?></td>
		<?php } ?>
                <td><?php if($all_dc_objects[$i]->checker!=""){ ?><img src="images/action_icons/on/active.png" alt="<?php echo $ap_lang["Online"]; ?>" title="<?php echo $ap_lang["Online"]; ?>" width="16" height="16" border="0" />
		<?php } else{ ?><img src="images/action_icons/on/inactive.png" alt="<?php echo $ap_lang["Offline"]; ?>" title="<?php echo $ap_lang["Offline"]; ?>" width="16" height="16" border="0" /><?php } ?>
                </td>
				
			<?php include "custom_see_all_td.php"; ?>
                <!--STATUS PROMOTE START-->
                <?php if($_SESSION[ADMINCHECKER] == 1){  ?>
                <td>
                    <?php if($all_dc_objects[$i]->checker == ""){ ?>
                        <a href="<?php echo url_link("id&delete&pos&promote=1&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/promote.png" alt="<?php echo $ap_lang["Promote"]; ?>" title="<?php echo $ap_lang["Promote"]; ?>" width="16" height="16" border="0" /></a>
                    <?php } else { ?>
                        <a href="<?php echo url_link("id&delete&pos&promote=0&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/demote.png" alt="<?php echo $ap_lang["Demote"]; ?>" title="<?php echo $ap_lang["Demote"]; ?>" width="16" height="16" border="0" /></a>
                    <?php } ?>
                </td>
                <?php } ?>
				<!--STATUS PROMOTE END--> 
				<!--STATUS PREVIEW START--> 
                <td><a href="<?php echo url_link("action=preview&id&delete&pos&promote&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/show.png" alt="<?php echo $ap_lang["Preview"]; ?>" title="<?php echo $ap_lang["Preview"]; ?>" width="16" height="16" border="0" /></a></td>
                <!--STATUS PREVIEW END--> 
                <!--STATUS EDIT START--> 
                <td><?php if($_SESSION[ADMINCHECKER] == 0 && $_SESSION[ADMINMAKER] == 0){?><img src="images/action_icons/off/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /><?php }else{ ?><a href="<?php echo url_link("action=edit&id&delete&pos&promote&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/edit.png" alt="<?php echo $ap_lang["Edit"]; ?>" title="<?php echo $ap_lang["Edit"]; ?>" width="16" height="16" border="0" /></a><?php } ?></td>
                <!--STATUS EDIT END--> 
                <!--UP START-->
                <?php if($_SESSION[ADMINCHECKER] == 1){ ?>
                <td align="center">
					<?php if(!$sort_is_active) { ?>
                    <?php if($all_dc_objects[$i]->pozicija != $max_position){ ?>
                    <a href="<?php echo url_link("id&delete&promote&pos=up&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/up.png" alt="<?php echo $ap_lang["Up"]; ?>" title="<?php echo $ap_lang["Up"]; ?>" width="16" height="16" border="0" /></a>
                    <?php }else{ ?> <img src="images/action_icons/off/up.png" alt="<?php echo $ap_lang["Up"]; ?>" title="<?php echo $ap_lang["Up"]; ?>" width="16" height="16" border="0" /> <?php } ?>
					<?php }else{ ?> <img src="images/action_icons/off/up.png" alt="<?php echo $ap_lang["Up"]; ?>" title="<?php echo $ap_lang["Up"]; ?>" width="16" height="16" border="0" /> <?php } ?>
                </td>
				<!--UP END-->
                <!--DOWN START-->
                <td align="center">
					<?php if(!$sort_is_active) { ?>
                    <?php if($all_dc_objects[$i]->pozicija != $min_position){ ?>
                    <a href="<?php echo url_link("id&delete&promote&pos=down&id=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/down.png" alt="<?php echo $ap_lang["Down"]; ?>" title="<?php echo $ap_lang["Down"]; ?>" width="16" height="16" border="0" /></a>
                    <?php }else{ ?> <img src="images/action_icons/off/down.png" alt="<?php echo $ap_lang["Down"]; ?>" title="<?php echo $ap_lang["Down"]; ?>" width="16" height="16" border="0" /> <?php } ?>
					<?php }else{ ?> <img src="images/action_icons/off/down.png" alt="<?php echo $ap_lang["Down"]; ?>" title="<?php echo $ap_lang["Down"]; ?>" width="16" height="16" border="0" /> <?php } ?>
                </td>
				<!--DOWN END-->
				<!--STATUS DELETE START--> 
                <td>
		<?php if($_SESSION[ADMINMAKER]==1 && $_SESSION[ADMINCHECKER]==0 && $all_dc_objects[$i]->checker == ""
				|| $_SESSION[ADMINCHECKER]==1){ ?>
                <a href="<?php echo url_link("id&promote&pos&delete=".$all_dc_objects[$i]->id); ?>"><img src="images/action_icons/on/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /></a>
        	<?php }else{ ?><img src="images/action_icons/off/delete.png" alt="<?php echo $ap_lang["Delete"]; ?>" title="<?php echo $ap_lang["Delete"]; ?>" width="16" height="16" border="0" /><?php } ?>
                </td>
        		<!--STATUS DELETE END--> 
                	<?php } ?>
				<?php } ?>
   		  </tr>
        </tbody>
 	</table>
	<?php } else { ?>
	<p class="empty_db"><?php echo $ap_lang["There are no entries for this object!"]; ?></p>
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php } ?>
			</div> 
		</div><!--right_see_all-->
	<div style="clear:both"></div>
</div><!--container-->

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
	
//=================================================================================================
//================ PHP HANDLER FOR EXTENDED CLASSES - END =========================================
//=================================================================================================
	
if($_GET)
{
	$search = $_GET["search"];
	$filter_maker = $_GET["filter_maker"];
	$filter_status = $_GET["filter_status"];
	$filter_godine = $_GET["filter_godine"];
	
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
	
}
if(!$_GET["nav"])	$nav_page = 1;
else				$nav_page = $_GET["nav"];

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
if($filter_maker != "all" && $filter_maker != "")	$dc_objects->add_condition("maker","=",$filter_maker);
if($filter_status != "all" && $filter_status != "")	
{
	if($filter_status == "promoted")				$dc_objects->add_condition("checker","!=","");
	if($filter_status == "demoted")					$dc_objects->add_condition("checker","=","");
}

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
		
		$proba = $broker->get_data(new proba($_GET["id"]));
		$proba->checker = $checker;
		$proba->checkerDate = $checker_date;
		foreach(get_class_vars(get_class($proba)) as $name => $value)
		{
			$proba->$name = addslashes($proba->$name);
		}
		if($broker->update($proba,true) >= 1)
			$dc_object = $broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"proba",$action,$_GET["id"]),false,true,false);
	}
//================ DELETE ITEM PROCESSING
	if($_GET["delete"])
	{
		$dc_object = $broker->get_data(new proba($_GET["delete"]));
		$dc_object->recordStatus = "C";
		foreach(get_class_vars(get_class($dc_object)) as $name => $value)
		{
			$dc_object->$name = addslashes($dc_object->$name);	
		}
		if($broker->update($dc_object) >= 1)	
		{
			$success_message = $ap_lang["Object has been successfully deleted!"];
			$broker->insert(new xenon_dataaudittrail(0,$_SERVER["REMOTE_ADDR"],date("Y-m-d H:i:s"),$_SESSION[ADMINLOGGEDIN],"proba","delete",$_GET["delete"]));
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
					
				$proba = $broker->get_data(new proba($first->id));
				$proba->pozicija = $first->pozicija;
				foreach(get_class_vars(get_class($proba)) as $name => $value)
				{
					$proba->$name = addslashes($proba->$name);	
				}
				$broker->update($proba);
						
				$proba = $broker->get_data(new proba($second->id));
				$proba->pozicija = $second->pozicija;
				foreach(get_class_vars(get_class($proba)) as $name => $value)
				{
					$proba->$name = addslashes($proba->$name);		
				}
				$broker->update($proba);
			}	
		}
		include_once "position_custom.php";
	}

$min_position = $broker->get_min_position_condition($dc_objects);
$max_position = $broker->get_max_position_condition($dc_objects);
$all_dc_objects = $broker->get_all_data_condition_limited($dc_objects,($nav_page-1)*$show_num_of_rows);
//session initializing for export_sql
$_SESSION["export_csv"] = serialize($dc_objects);
$_SESSION["export_dc"] = "proba";

for($i=0; $i<sizeof($all_dc_objects); $i++)
{
	
	
		if($all_dc_objects[$i]->godine == "1")	$all_dc_objects[$i]->godine = 1;
		else														$all_dc_objects[$i]->godine = 0;
	
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
$sql = $broker->execute_query("select distinct `maker` from `proba` where `recordStatus` = 'O'");
$makers = array();
while($row = $sql->fetch_assoc())
	$makers[] = $row["maker"];
?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["List of all entries for object"]; ?> - Proba</h1>
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
		<label>Godine</label> 
		<select name="filter_godine" onchange="submit()">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
 			<option value="yes" <?php if($filter_godine == "yes"){ ?>selected="selected"<?php } ?>><?php echo $ap_lang["Yes"]; ?></option>
        	<option value="no" <?php if($filter_godine == "no"){ ?>selected="selected"<?php } ?>><?php echo $ap_lang["No"]; ?></option>
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
		<th width="500">
		<?php 
		if($sort_column=="ime")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="ime";
        ?>
		<a href="<?php echo url_link("id&pos&promote&delete&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">Ime</a>
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
		
		<td><?php echo $all_dc_objects[$i]->ime; ?></td>
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

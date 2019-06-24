<?php
require_once "../classes/domain/xenon_dataaudittrail.class.php";
require_once "../classes/domain/xenon_user.class.php";
include_once "php/functions.php";

	// DISTINCT VALUES FOR FILTERS ---- START
	$sql = $broker->execute_query("select distinct `user` from xenon_dataaudittrail");
	$xenon_users = array();
	while($row = $sql->fetch_assoc())
		$xenon_users[] = $row;
	
	$sql = $broker->execute_query("select distinct `action` from xenon_dataaudittrail");
	$xenon_actions = array();
	while($row = $sql->fetch_assoc())
		$xenon_actions[] = $row;
		
	$sql = $broker->execute_query("select distinct `table` from xenon_dataaudittrail");
	$xenon_objects = array();
	while($row = $sql->fetch_assoc())
		$xenon_objects[] = $row;
	
	$sql = $broker->execute_query("select distinct `name`,`namemenu` from xenon_menu");
	$xenon_objects_menuname = array();
	while($row = $sql->fetch_assoc())
		$xenon_objects_menuname[] = $row;
	
	// DISTINCT VALUES FOR FILTERS ---- END
	if(isset($_GET["show"]) && is_numeric($_GET["show"]))	$show_num_of_rows = $_GET["show"];
	else													$show_num_of_rows = 10;
	
	if($_GET)
	{
		if($_GET['piker1'])
		{
			$piker1 = explode("/",$_GET["piker1"]);
			$piker1 = $piker1[2]."-".$piker1[0]."-".$piker1[1];	
			
			$piker2 = explode("/",$_GET["piker2"]);
			$piker2 = $piker2[2]."-".$piker2[0]."-".$piker2[1];
		}else{
			$piker1 = date('Y-m-d', mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			$piker2 = date('Y-m-d');	
		}
		
		// FILTER GETTER start
		$filter_user = $_GET["filter_user"];
		$filter_object = $_GET["filter_object"];
		$filter_action = $_GET["filter_action"];
		// FILTER GETTER end
		if($_GET["sort_column"])
		{
			$sort_column = '`'.$_GET["sort_column"].'`';
			$sort_direction = $_GET["sort_direction"];
		}
		else 
		{
			$sort_column = "id";
			$sort_direction = "desc";
		}
	}
	else
	{
		// FILTER  start
		$filter_user = "all";
		$filter_object = "all";
		$filter_action = "all";
		// FILTER  end
	}
		
	if(!$_GET["nav"])	$nav_page = 1;
	else				$nav_page = $_GET["nav"];

	$dc_objects = new xenon_dataaudittrail();
	$dc_objects->add_condition("actiondate",">=",$piker1);
	$dc_objects->add_condition("actiondate","<=",$piker2 ." 23:59:59");
	
	// FILTER  start
	if($filter_user != "all" && $filter_user != "")		$dc_objects->add_condition("user","=",$filter_user);
	if($filter_object != "all" && $filter_object != "")	$dc_objects->add_condition("`table`","=","'".$filter_object."'");
	if($filter_action != "all" && $filter_action != "")	$dc_objects->add_condition("action","=",$filter_action);
	// FILTER  end
	
	$dc_objects->set_order_by($sort_column,$sort_direction);
	$dc_objects->set_limit($show_num_of_rows,$nav_page*$show_num_of_rows-$show_num_of_rows);
	
	$num_of_rows = $broker->get_count_condition($dc_objects);
	$num_of_pages = sprintf(ceil($num_of_rows/$show_num_of_rows));
	
	if($nav_page!=1)	$nav_page_left=$nav_page-1;
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
	
	$all_dc_objects = $broker->get_all_data_condition_limited($dc_objects);
	
	$piker1 = explode("-",$piker1);
	$piker1 = $piker1[1]."/".$piker1[2]."/".$piker1[0];
			
	$piker2 = explode("-",$piker2);
	$piker2 = $piker2[1]."/".$piker2[2]."/".$piker2[0];
?>
<div id="container">
	<div id="top">
		<h1>Data Audit Trail</h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<div id="left_menu">
		<?php	include_once "php/reports_menu.php";	?>
	</div><!--left_menu-->
	<div id="right_domain_object">
	<form action="" method="get" enctype="multipart/form-data">
	<link rel="stylesheet" type="text/css" href="js/datepicker/css/jquery-ui-1.8.4.custom.css"/>
        <script type="text/javascript" src="js/datepicker/jquery.ui.core.js"></script>
        <script type="text/javascript" src="js/datepicker/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="js/datepicker/jquery.ui.datepicker.js"></script>
        <script type="text/javascript">
            $(function() {
                $('[name=piker1]').datepicker({
                    showOn: 'button',
                    buttonImage: 'js/datepicker/calendar.gif',
                    buttonImageOnly: true
                });
				 $('[name=piker2]').datepicker({
                    showOn: 'button',
                    buttonImage: 'js/datepicker/calendar.gif',
                    buttonImageOnly: true
                });
            });
        </script>
    <input type="hidden" name="type" value="<?php echo $_GET["type"]; ?>" />
	<input type="hidden" name="page" value="<?php echo $_GET["page"]; ?>" />
 	<div id="search_reports">
    <div id="picker_date">   
		<label><?php echo $ap_lang['From']; ?></label><input type="text" name="piker1" value="<?php echo $piker1; ?>" />
		<label><?php echo $ap_lang['To']; ?></label><input type="text" name="piker2" value="<?php echo $piker2; ?>" />
	</div><!--picker_date-->
    <button type="submit" class="search" onchange="submit()" value="<?php echo $ap_lang["Search"]; ?>"><?php echo $ap_lang["Search"]; ?></button>
    <div style="clear:both;"></div>
    </div><!--search_reports-->
	<div id="filters">
	<fieldset>
		<legend><?php echo $ap_lang["Search filters"]; ?></legend>
        <div class="item">
		<label><?php echo $ap_lang['User']; ?></label>
		<select name="filter_user">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
            <?php for($i=0; $i<sizeof($xenon_users); $i++){ ?>
 			<option value="<?php echo $xenon_users[$i]['user']; ?>" <?php if($filter_user == $xenon_users[$i]['user']){ ?>selected="selected"<?php } ?>><?php echo $xenon_users[$i]['user']; ?></option>
            <?php } ?>
		</select>
        </div>
        <div class="item">
        <label><?php echo $ap_lang['Object']; ?></label>
		<select name="filter_object">
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
            <?php for($i=0; $i<sizeof($xenon_objects_menuname); $i++){ ?>
 			<option value="<?php echo $xenon_objects_menuname[$i]['name']; ?>" <?php if($filter_object == (string)$xenon_objects_menuname[$i]['name']){ ?>selected="selected"<?php } ?>><?php echo $xenon_objects_menuname[$i]['namemenu']; ?></option>
            <?php } ?>
		</select>
        </div>
        <div class="item">
        <label><?php echo $ap_lang['Action']; ?></label>
		<select name="filter_action" >
			<option value="all"><?php echo $ap_lang["All"]; ?></option>
            <?php for($i=0; $i<sizeof($xenon_actions); $i++){ ?>
 			<option value="<?php echo $xenon_actions[$i]['action']; ?>" <?php if($filter_action == $xenon_actions[$i]['action']){ ?>selected="selected"<?php } ?>><?php echo $ap_lang[ucfirst($xenon_actions[$i]['action'])]; ?></option>
            <?php } ?>
		</select>
        </div>
	</fieldset>
	<div style="clear:both;"></div>
	</div><!--filters-->	
<?php if($num_of_rows>0) { ?>
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
			<?php }else { ?><button type="button" onclick="location.href='<?php echo url_link("nav=".$nav_page_left); ?>'" class="pagination_left"></button>
	  		<?php } if($last_page){ ?><button type="button" class="pagination_right"></button>
	  		<?php }else { ?><button type="button" onclick="location.href='<?php echo url_link("nav=".$nav_page_right); ?>'" class="pagination_right"></button>
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
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>">ID</a>
		</th>
		<th width="120">
		<?php 
		if($sort_column=="ip")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="ip";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['IP Address']; ?></a>
		</th>
		<th width="120">
		<?php 
		if($sort_column=="actiondate")
			if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="actiondate";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['Date']; ?></a>
		</th>
		<th width="120">
		<?php 
 		if($sort_column=="user")
       		if($sort_direction == "asc")	$sort_direction = "desc";
			else							$sort_direction = "asc";
		$sort="user";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['User']; ?></a>
		</th>
		<th width="120">
		<?php 
       	if($sort_column=="table")
    		if($sort_direction == "asc")	$sort_direction = "desc";
     		else							$sort_direction = "asc";
		$sort="table";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['Object']; ?></a>
		</th>
        <th width="120">
		<?php 
       	if($sort_column=="dataid")
    		if($sort_direction == "asc")	$sort_direction = "desc";
     		else							$sort_direction = "asc";
		$sort="dataid";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['Data ID']; ?></a>
		</th>
		<th width="120">
		<?php 
       	if($sort_column=="action")
    		if($sort_direction == "asc")	$sort_direction = "desc";
     		else							$sort_direction = "asc";
		$sort="action";
        ?>
		<a href="<?php echo url_link("id&sort_column=".$sort."&sort_direction=".$sort_direction); ?>"><?php echo $ap_lang['Action']; ?></a>
		</th>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0; $i<sizeof($all_dc_objects); $i++){ ?>
            <tr>
            <td><?php echo $all_dc_objects[$i]->id; ?></td>
            <td><?php echo $all_dc_objects[$i]->ip; ?></td>
            <td><?php echo date_format(date_create($all_dc_objects[$i]->actiondate), 'm/d/Y H:i:s'); ?></td>
            <td><?php echo $all_dc_objects[$i]->user; ?></td>
            <td><?php
				for($j=0;$j<sizeof($xenon_objects_menuname);$j++)
					if(strcmp($xenon_objects_menuname[$j]['name'],$all_dc_objects[$i]->table)==0)
						echo $xenon_objects_menuname[$j]['namemenu'];
			?>
            </td>
            <td><?php echo $all_dc_objects[$i]->dataid; ?></td>
            <td><?php echo $ap_lang[ucfirst($all_dc_objects[$i]->action)]; ?></td>
            </tr>
        <?php } ?>
    	</tbody>
 	</table>
	<?php } else { ?>
	<p class="empty_db"><?php echo $ap_lang["There are no entries for this report!"];?></p>
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php } ?>
			</div> 
		</div><!--right_see_all-->
	<div style="clear:both"></div>
</div><!--container-->

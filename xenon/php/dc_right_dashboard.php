<?php 
require_once "settings_elements.php";
require_once "../classes/domain/admin_reports.class.php";
require_once "../classes/domain/xenon_modules.class.php";
$admin_reports=$broker->get_all_data(new admin_reports());
$all_modules = $broker->get_all_data(new xenon_modules());

?>
<style>
.right_section{
	border:1px solid #CCC;
	margin:0px 0px 20px 0px;
	padding:5px;
	font-size:12px;
	background-color:#F5F5F5;
}

.right_section_title{
	font-size:16px;	
	color:#09a5d9;
	background-color:#FFFFFF;
	margin:0px 0px 5px 0px;
	padding:0px 5px;
	border-bottom:1px solid #CCC;
}

.right_section_content{
	padding:5px;
	background-color:#FFFFFF;
}

.right_section li{
	list-style:decimal;
	margin:0px 0px 5px 0px;	
}

.right_section a{
	color:#09a5d9;
	text-decoration:none;
}

.right_section a:hover{
	color:#09a5d9;
	text-decoration:underline;
}
</style>
<div id="right_dashboard">

<?php if(sizeof($all_modules) > 0){ ?>
<div class="right_section">
	<div class="right_section_title">
    	<a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG]?>&type=m"><?php echo $ap_lang["Modules"]; ?></a>
    </div>
    <div class="right_section_content">
	<?php for($i=0; $i<sizeof($all_modules); $i++){?>
    	<li <?php if(strcmp($all_modules[$i]->tablename,$_GET["page"]) == 0){ ?>id="active" <?php } if($i == sizeof($all_modules)-1){ ?>class="last"<?php } ?>><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>"><?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?></a></li>
	<?php } ?>
    </div>
</div>
<?php } ?>


<div class="right_section">
	<div class="right_section_title">
    	<a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG]?>&type=r"><?php echo $ap_lang["Reports"]; ?></a>
    </div>
    <div class="right_section_content">
        <li <?php if($_GET["page"] == "dataaudittrail" || !$_GET["page"]){ ?>id="active"<?php } ?> class="last"><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=dataaudittrail"; ?>">Data Audit Trail</a></li>
        <?php for ($i=0;$i<sizeof($admin_reports);$i++){?>
        <li <?php if($_GET["page"] == $admin_reports[$i]->page){?>id="active"<?php } ?>><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=".$admin_reports[$i]->page; ?>"><?php echo $admin_reports[$i]->display_name;?></a></li>
        <?php }?>
    </div>
</div>


<div class="right_section">
	<div class="right_section_title">
    	<a href="index.php?lang=<?php echo $_SESSION[ADMINPANELLANG]?>&type=s"><?php echo $ap_lang["Settings"]; ?></a>
    </div>
    <div class="right_section_content">
    		<?php for($i=0;$i<sizeof($settings_menu);$i++){
				if($user->username == 'xenon_admin' || !$settings_menu[$i]['only_for_admin']){ ?>   
        	<li>
                <a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=s&page=".$settings_menu[$i]['name']; ?>">
                    <?php echo $ap_lang[$settings_menu[$i]['ap_lang']]; ?>
                </a>
            </li>
            <?php }} ?>
    </div>
</div>





</div><!--right_dashboard-->
<?php
require_once "../classes/domain/xenon_languages.class.php";
require_once "../classes/domain/admin_reports.class.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);
$admin_reports = new admin_reports();
$admin_reports=$broker->get_all_data($admin_reports);
?>
<div id="left_menu">
	<menu>
		<li class="title"><?php echo $ap_lang['Reports']; ?></li>
        <?php for ($i=0;$i<sizeof($admin_reports);$i++){?>
        <li <?php if($_GET["page"] == $admin_reports[$i]->page){?>id="active"<?php } ?>><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=".$admin_reports[$i]->page; ?>"><?php echo $admin_reports[$i]->display_name;?></a></li>
        <?php }?>
        <li <?php if($_GET["page"] == "dataaudittrail" || !$_GET["page"]){ ?>id="active"<?php } ?> class="last"><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=dataaudittrail"; ?>">Data Audit Trail</a></li>
	</menu>
</div><!--left_menu-->
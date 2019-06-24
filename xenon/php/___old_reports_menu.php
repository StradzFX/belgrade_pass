<?php
require_once "../classes/domain/xenon_languages.class.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);
?>
<div id="left_menu">
	<menu>
		<li class="title"><?php echo $ap_lang['Reports']; ?></li>
        <!--ovde nastaviti niz  - menjati samo REPORT sa nazivom -->
        <?php /*?><li <?php if($_GET["page"] == "REPORT"){?>id="active"<?php } ?>>REPORT<a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=REPORT"; ?>">REPORT</a></li><?php */?>
        <!--poslednji obavezno implementirati zbog dizajna pa je zato defaultni Data Audit Trail-->
        <li <?php if($_GET["page"] == "dataaudittrail" || !$_GET["page"]){ ?>id="active"<?php } ?> class="last"><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=r&page=dataaudittrail"; ?>">Data Audit Trail</a></li>
	</menu>
</div><!--left_menu-->
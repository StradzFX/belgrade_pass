<?php
require_once "../classes/domain/xenon_languages.class.php";
require_once "settings_elements.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);

?>
<div id="left_menu">
	<menu>
		<li class="title"><?php echo $ap_lang["Settings"]; ?></li>
        <?php for($i=0;$i<sizeof($settings_menu);$i++){ ?>
            <li <?php if($_GET["page"] == $settings_menu[$i]['name']){?>id="active"<?php } ?>>
                <a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=s&page=".$settings_menu[$i]['name']; ?>">
                    <?php echo $ap_lang[$settings_menu[$i]['ap_lang']]; ?>
                </a>
            </li>
        <?php } ?>
	</menu>
</div><!--left_menu-->
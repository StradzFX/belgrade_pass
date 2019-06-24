<?php
require_once "../classes/domain/xenon_languages.class.php";
require_once "settings_elements.php";
$all_active_languages = new xenon_languages();
$all_active_languages->set_condition("active","=","1");
$all_active_languages = $broker->get_all_data_condition($all_active_languages);




if($_GET['page'])
{
	include_once "php/".$_GET['page'].".php";
}else{
?>
<div id="container">
    	<div id="header_information">
        	<h1><?php echo $ap_lang["Settings"]; ?></h1>
            <p><?php echo $ap_lang["Here you can edit users, website settings and your company information!"]; ?></p>
        </div><!--header_information-->
        <div id="content">
            <div id="left_dashboard">
                <div id="dashboard_menu">  
                    <?php for($i=0;$i<sizeof($settings_menu);$i++){ ?>                    
                    <div class="item">
                        <div class="item_icon">
                            <a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=s&page=".$settings_menu[$i]['name']; ?>">
                                <img src="images/dashboard_icons/<?php echo $settings_menu[$i]['icon']; ?>.png" border="0" />
                            </a>
                        </div>
                        <p>
                        	<a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=s&page=".$settings_menu[$i]['name']; ?>; ?>">
								<?php echo $ap_lang[$settings_menu[$i]['ap_lang']]; ?>
                            </a>
                        </p>
                    </div>
                    <?php } ?>
                </div><!--dashboard_menu-->
            </div><!--left_dashboard-->
            <?php include_once 'php/dc_right_dashboard.php'; ?>
            <div style="clear:both"></div>
        </div><!--content-->    
    </div><!--container-->
<?php } ?>


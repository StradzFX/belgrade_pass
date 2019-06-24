<?php
require_once "../classes/database/db_broker.php";
require_once "../classes/domain/xenon_modules.class.php";

$broker = new db_broker();
$all_modules = $broker->get_all_data(new xenon_modules());
?>
<div id="container">
	<div id="header_information">
		<h1><?php echo $ap_lang["Modules"]; ?></h1>
		<p><?php echo $ap_lang["Here you can choose which module you want to manage!"]; ?></p>
	</div><!--header_information-->
	<div id="content">
		<div id="left_dashboard">
        	<div id="dashboard_menu">  
<?php if($_SESSION[ADMINAUTHMODULES][0] == "All"){
		for($i=0;$i<sizeof($all_modules);$i++){ ?>
			<div class="item">
                <div class="item_icon">
                <a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>"><img src="modules/<?php echo $all_modules[$i]->tablename; ?>/images/logo.png" alt="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" title="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" border="0" /></a>
                </div>
                <p><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>" alt="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" title="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>"><?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?></a>
                </p>
            </div>
			<?php }}else{ for($i=0;$i<sizeof($all_modules);$i++){
            for($j=0;$j<sizeof($_SESSION[ADMINAUTHMODULES]);$j++){
				if(strcmp($all_modules[$i]->name .' '.$all_modules[$i]->version,$_SESSION[ADMINAUTHMODULES][$j])==0){
			?>
			<div class="item">
                <div class="item_icon">
                <a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>"><img src="modules/<?php echo $all_modules[$i]->tablename; ?>/images/logo.png" alt="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" title="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" border="0" /></a>
                </div>
                <p><a href="<?php echo "index.php?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>" alt="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>" title="<?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?>"><?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?></a>
                </p>
            </div>
			<?php }}}} ?>
        	</div><!--dashboard_menu-->
		</div><!--left_dashboard-->
            <?php include_once 'php/dc_right_dashboard.php'; ?>
		<div style="clear:both"></div>
	</div><!--content-->    
</div><!--container-->


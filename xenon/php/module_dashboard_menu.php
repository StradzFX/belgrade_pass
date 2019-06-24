<?php 
require_once "../classes/database/db_broker.php";
require_once "../classes/domain/xenon_modules.class.php";

$broker = new db_broker();
$all_modules = $broker->get_all_data(new xenon_modules());

?>
<menu>
	<li class="title"><?php echo $ap_lang["Modules"]; ?></li>
	<?php for($i=0; $i<sizeof($all_modules); $i++){
	?><li <?php if(strcmp($all_modules[$i]->tablename,$_GET["page"]) == 0){ ?>id="active" <?php } if($i == sizeof($all_modules)-1){ ?>class="last"<?php } ?>><a href="<?php echo $_SERVER['PHP_SELF']."?lang=".$_SESSION[ADMINPANELLANG]."&type=m&page=".$all_modules[$i]->tablename; ?>"><?php echo $all_modules[$i]->name . " " . $all_modules[$i]->version; ?></a></li>
<?php } ?>
</menu>
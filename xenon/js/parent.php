<?php
require_once "../config.php";
require_once "../../classes/domain/".$_POST["child"].".class.php";
require_once "../../classes/database/db_broker.php";

$broker = new db_broker();
$object = new $_POST["child"]();
$object->set_condition("checker","!="," ");
$object->add_condition("recordStatus","=","O");
$object->add_condition($_POST["parent"],"=",$_POST["parent_value"]);
$object->add_condition("jezik","=",$_POST["cur_language"]);
$object->set_order_by($_POST["child_id"],"ASC");
$all_objects = $broker->get_all_data_condition($object); 
?>

<?php for($i=0;$i<sizeof($all_objects);$i++){ ?>
<option value="<?php echo $all_objects[$i]->$_POST["child_id"]; ?>" <?php if(strcmp($all_objects[$i]->$_POST["child_id"],$_POST["child_value"])==0){ ?>selected="selected"<?php } ?>><?php echo $all_objects[$i]->$_POST["child_name"]; ?></option>
<?php } ?>
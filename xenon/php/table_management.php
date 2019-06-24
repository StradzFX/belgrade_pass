<?php 
include_once "../classes/database/db_broker.php";
include_once "../classes/domain/xenon_menu.class.php";
include_once "../classes/domain/xenon_privilege.class.php";
include_once "php/functions.php";
$broker = new db_broker();
//DELETE HANDLING
if($_GET["todo"])
{
	$sql = $broker->execute_query("UPDATE ".$_GET["dc"]." SET recordStatus = 'C'");
	$success_message = 'Data from table '.$_GET["dc"].' has been successfully deleted';
}

$xenon_menus = $broker->get_all_data(new xenon_menu());
for($i=0;$i<sizeof($xenon_menus);$i++){
	include_once "../classes/domain/".$xenon_menus[$i]->name.".class.php";
	$domain_class=$xenon_menus[$i]->name;
	$domain_class_elements = new $domain_class();
	$domain_class_elements->set_condition("recordStatus","=","O");
	$domain_class_elements = $broker->get_all_data_condition($domain_class_elements);
	$xenon_menus[$i]->domain_class_elements = $domain_class_elements;
}

?>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Table management"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
    <div id="new_edit_record">
    		<div style="float:left;margin:20px 0px 0px 20px;width:340px;">
            <div id="see_all">
            <?php if(sizeof($xenon_menus) > 0){ ?>
            	<table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th style="width:200px;text-align:left"><?php echo $ap_lang["Name"]; ?></th>
                        <th style="width:50px;"><?php echo $ap_lang["Status"]; ?></th>
                        <th style="width:50px;"><?php echo $ap_lang["Actions"]; ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					for($i=0;$i<sizeof($xenon_menus);$i++){
					
					?>
                    <tr>
                        <td style="width:200px;text-align:left"><?php echo $xenon_menus[$i]->name;?></td>
                        <td align="center" style="width:40px;">
                        <?php if(sizeof ($xenon_menus[$i]->domain_class_elements) == 0)  {?>
						<img src="images/action_icons/on/inactive.png" border="0" />
						<?php }else {?>
						<img src="images/action_icons/on/active.png" border="0" />
						<?php } ?>
                        </td>
                        <?php if(sizeof ($xenon_menus[$i]->domain_class_elements) != 0){ ?>
                        <td>
                        	<a 
                            	href="index.php?lang=<?php echo $_GET['lang']?>&type=s&page=table_management&todo=truncate&dc=<?php echo $xenon_menus[$i]->name;?>" 
                            	onclick="return confirm('Are you sure you want to truncate this table?');">
                        		<img src="images/action_icons/on/delete.png" border="0" />
                            </a>
                        </td>
              			<?php } else { ?> 
                        <td>
                        <img src="images/action_icons/off/delete.png" border="0" />
                        </td>
              <?php }?>
                    </tr>
                        <?php }?>		
                </tbody>
            </table>
            <?php }else{ ?>
            	<div style="width:340px;margin:50px 0px 80px 20px;">
                	<div style="width:200px;font-size:18px;color:#999999;text-align:center;margin:0 auto;">
                    	Currently, there are no domain classes created.
                    </div>
                </div>
            <?php } ?>
            </div>
          </div>  
            <div style="float:left;margin:20px 0px 0px 80px;">
        	<img src="images/truncate_icon.png" /><div style="clear:left">
            <br />
        <a href="php/export_pictures.php" style="color:#09A5D9">Skini sve slike</a>
            <br /><br />
        <a href="php/export_files.php" style="color:#09A5D9">Skini sve fajlove</a>
        </div>
        <div style="clear:left">
        </div>
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

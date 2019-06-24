<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/admin_reports.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$admin_reports = $broker->get_all_data(new admin_reports);
//DELETE HANDLING
if($_GET["todo"])
{
	$admin_reports = new admin_reports($_GET['id']);
	$admin_reports = $broker->get_data($admin_reports);
	$broker->delete($admin_reports);
	$success_message = $ap_lang["Report has been successfully deleted"];
}


$admin_reports = new admin_reports();
$admin_reports->set_condition('recordStatus','=','O');
$admin_reports->add_condition('page','!=','');
$admin_reports = $broker->get_all_data_condition($admin_reports);


?>
<style>
	.admin_reports_element{
		font-size:14px;
		margin-bottom:25px;
		padding-bottom:10px;
		border-bottom:1px solid #CCC;
	}
	
	a{
		text-decoration:none;
		color:#0099CC;
	}
	
	a:hover{
		text-decoration:underline;
		color:#0099CC;
	}
	
	.page_title{
		color:#0099CC;
	}
	
	fieldset{
		border:1px solid #CFE8FC;
	}
	
	.configuration_table{
		width:500px;
		font-size:12px;
	}
	
	.configuration_table th{
		border-bottom:1px solid #666;
		text-align:left;
	}
	
	
	.configuration_table .action{
		width:30px;
	}
	
	.configuration_table td{
		padding:3px 0px;
		border-bottom:1px solid #CCC;
	}
</style>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Reports configuration"]; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>   
	<fieldset>
    	<legend></legend>
        
        

		<div style="float:left;margin:20px 0px 0px 20px;">
        	<button type="button" onclick="location.href='index.php?type=s&page=reports_add_page&action=new'" id="fleft" class="general"><?php echo $ap_lang["New_report"]; ?></button><br />
        	
            <?php if(sizeof($admin_reports) > 0){ ?><br />

            <h1 style="color:#f8379b;font-size:18px"><?php echo $ap_lang["List of reports"]; ?>:</h1>
        <table class="configuration_table" cellpadding="0" cellspacing="0">
        	<tr>
            	<th><?php echo $ap_lang["Page"]; ?></th>
                <th><?php echo $ap_lang["Name"]; ?></th>
                <th style="text-align:center">Custom SQL</th>
                <th style="text-align:center">Instructions</th>
                <th colspan="2" class="actions"><?php echo $ap_lang["Options"]; ?></th>
            </tr>
             <?php for ($i=0;$i<sizeof($admin_reports);$i++){ ?>
            <tr>
            	<td><?php echo $admin_reports[$i]->page; ?>.php</td>
                <td><?php echo $admin_reports[$i]->display_name; ?></td>
                <td align="center"><img src="images/<?php if($admin_reports[$i]->custom_sql == ''){ echo 'not_'; } ?>checked.png" /></td>
                <td align="center"><img src="images/<?php if(strip_tags($admin_reports[$i]->instruction) == ''){ echo 'not_'; } ?>checked.png" /></td>
                <td class="action">
                    <a href="index.php?type=s&page=reports_edit_page&id=<?php echo $admin_reports[$i]->id; ?>">
                    	<img src="images/action_icons/on/edit.png" />
                    </a>
                </td>
                <td class="action">
                	<a href="index.php?type=s&page=reports_configuration&todo=delete&id=<?php echo $admin_reports[$i]->id; ?>" onclick="return confirm('<?php echo $ap_lang["Are you sure you want to delete this report?"]; ?>')">
					<img src="images/action_icons/on/delete.png" />
                    </a>
                </td>
            </tr>
            <?php }?>
        </table>
        <?php }else{ ?>
        	<div style="width:500px;margin:60px 0px">
            	<div style="width:250px;margin:0 auto;color:#999999;font-size:18px;text-align:center;">
                	<?php echo $ap_lang["no_reports_error"]; ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <div style="float:left;margin:64px 0px 0px 70px;">
        	<img src="images/reports_icon.png" />
        </div>
        <div style="clear:left">
        </div>
    </fieldset>
    
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

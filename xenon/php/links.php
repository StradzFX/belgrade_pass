<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/admin_links.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$admin_links = $broker->get_all_data(new admin_links);
//DELETE HANDLING
if($_GET["todo"])
{
	$admin_links = new admin_links($_GET['id']);
	$admin_links = $broker->get_data($admin_links);
	$broker->delete($admin_links);
	$success_message = $ap_lang["Link has been successfully deleted"];
	$admin_links = $broker->get_all_data(new admin_links);
}

if($_POST)
{	
	$admin_links = $broker->get_data(new admin_links());

	
	$admin_links->name=$_POST['name'];
	$admin_links->link=$_POST['link'];
	
	$broker->insert($admin_links);
	$success_message = $ap_lang["You have successfully updated website"];	
}

$admin_links = new admin_links();
$admin_links = $broker->get_all_data($admin_links);


?>
<style>
	.link_element{
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
</style>
<div id="container">
	<div id="top">
	<h1><?php echo $ap_lang["Links"]; ?></h1>
	<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
    <?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
    <?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
    <?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <form action="" method="post" enctype="multipart/form-data" >
        
        <div style="float:left">
        	<fieldset>
            	<legend>Create link</legend>
                
                <table cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php echo $ap_lang["Name"]; ?>:</td>
                    <td><input type="text" name="name" value="" style="width:450px"/></td>
                </tr>
                
                <tr>
                    <td><?php echo $ap_lang["Link"]; ?>:</td>
                    <td><input type="text" name="link" value="" style="width:450px"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
                </tr>
            </table>
            </fieldset>
        </div>
        <div style="float:left;margin:30px 0px 0px 60px;">
        	<img src="images/link_add_icon.png" />
        </div>
        <div style="clear:left"></div>
        
		</form>
        <br />
    </div>
    
   
	<?php if(sizeof($admin_links) > 0){ ?>
    	<fieldset>
    	<legend><?php echo $ap_lang["List of links"]; ?></legend>

        <hr />
	 <?php for ($i=0;$i<sizeof($admin_links);$i++){?>
     	<div class="link_element">
        	<div><strong><?php echo $ap_lang["Name"]; ?>:</strong> <span class="page_title"><?php echo $admin_links[$i]->name; ?></span></div>
        	<div><strong>Link:</strong> <?php echo $admin_links[$i]->link; ?></div>
            <div><strong><?php echo $ap_lang["Options"]; ?>:</strong> 
            	<a href="index.php?type=s&page=edit_link&id=<?php echo $admin_links[$i]->id; ?>"><?php echo $ap_lang["Edit"]; ?></a> |
            	<a href="index.php?type=s&page=links&todo=delete&id=<?php echo $admin_links[$i]->id; ?>" onclick="return confirm('<?php echo $ap_lang["Are you sure you want to delete this link?"];?>');"><?php echo $ap_lang["Delete"]; ?></a>
            </div>
        </div>
        <?php }?>
    </fieldset>
    
    <?php }else{ ?>
    	<div style="width:720px;margin:50px 0px 80px 20px;">
                	<div style="width:320px;font-size:18px;color:#999999;text-align:center;margin:0 auto;">
                    	Currently, there are no links created...<br />
						Create some links now!
                    </div>
                </div>
    <?php } ?>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/seo_configuration.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$seo_configuration = $broker->get_data(new seo_configuration($_GET['id']));
if($_POST)
{
	$seo_configuration = $broker->get_data(new seo_configuration($_GET['id']));
	$seo_configuration->page=$_POST['page'];
	
	if($_POST['obrisi_sliku'] == ''){
		if($_FILES['image']['error'] == 0){
			$seo_image=$_FILES['image']['name'];
			$seo_temp_image = $_FILES['image']['tmp_name'];
			move_uploaded_file($seo_temp_image, '../images/seo_images/'.$seo_image);
			$seo_configuration->image = $_FILES["image"]["name"];
			}else{
				$seo_configuration->image = $_POST['old_image'];
				}
				}else{
					$seo_configuration->image = '';
					}
	
	$seo_configuration->title=$_POST['title'];
	$seo_configuration->keyword=$_POST['keyword'];
	$seo_configuration->description=$_POST['description'];
	$seo_configuration->type=$_POST['type'];

	$broker->update($seo_configuration);
	$success_message = $ap_lang["You have successfully updated website"];

}
?>
<style>
	.seo_element{
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
	<h1><?php echo $seo_configuration->page; ?></h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="page" value="<?php echo $seo_configuration->page; ?>"/>

        <table>
        	<tr>
            	<td>Title:</td>
                <td><input type="text" name="title" value="<?php echo $seo_configuration->title; ?>" style="width:450px"/></td>
            </tr>
            
            <tr>
            	<td>Keywords: </td>
                <td><input type="text" name="keyword" value="<?php echo $seo_configuration->keyword; ?>" style="width:450px"/></td>
            </tr>
            <tr>
            	<td>Description:</td>
                <td><input type="text" name="description" value="<?php echo $seo_configuration->description; ?>" style="width:450px"/></td>
            </tr>
            <tr>
            	<td>Image:</td>
                <td>
                	<input type="file" name="image" />
                    <input type="hidden" name="old_image" value="<?php echo $seo_configuration->image; ?>" />
                    
                    <?php if ($seo_configuration->image!=''){?>
                    <br /><input type="checkbox" name="obrisi_sliku" value="da" id="obrisi" />
 <label for="obrisi">Delete image</label><br />

                    <img src="../images/seo_images/<?php echo $seo_configuration->image; ?>" height="70" /><br />
                    <?php }?>
                </td>
            </tr>
            <tr>
            	<td>Type:</td>
                <td><select name="type">
                	<option value="fixed" style="width:450px">Fixed</option>
                    <option value="domain_object" style="width:450px">Domain object</option>
                    </select></td>
            </tr>
            <tr>
            	<td></td>
                <td><button type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
        </table>
		</form>
        <br />
    </div>
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->
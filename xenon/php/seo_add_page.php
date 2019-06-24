<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/seo_configuration.class.php";
require_once "php/functions.php";
$broker = new db_broker();
if($_POST)
{
	$seo_configuration = new seo_configuration();
	
	$seo_configuration->page=$_POST['page'];
	$seo_configuration->image=$_FILES["image"]["name"];
	$seo_configuration->title=$_POST['title'];
	$seo_configuration->keyword=$_POST['keyword'];
	$seo_configuration->description=$_POST['description'];
	$seo_configuration->type=$_POST['type'];
	$seo_configuration->recordStatus='O';
	$seo_configuration->maker='website';
	$seo_configuration->makerDate=date('c');
	$seo_configuration->checker='website';
	$seo_configuration->checkerDate=date('c');
	$seo_configuration->jezik='en';
	$success_message = $ap_lang["New SEO page successfully added!"];
	$seo_image=$_FILES['image']['name'];
	$seo_temp_image = $_FILES['image']['tmp_name'];
	move_uploaded_file($seo_temp_image, '../images/seo_images/'.$seo_image);
	$seo_configuration=$broker->insert($seo_configuration);
}
$seo_configuration = new seo_configuration();
$seo_configuration->set_condition('recordStatus','=','O');
$seo_configuration->add_condition('page','!=','');
$seo_configuration = $broker->get_all_data_condition($seo_configuration);

$seo_existing_pages=array();
for ($i=0;$i<sizeof($seo_configuration);$i++){
	$seo_existing_pages[]=$seo_configuration[$i]->page;
}

$stranice=scandir('../');
$nove_stranice=array();
for ($i=0;$i<sizeof($stranice);$i++){
  if (strpos($stranice[$i],'.') > 1 && $stranice[$i]!='company_config.php' && $stranice[$i]!='robots.txt' && $stranice[$i]!='template.php' && $stranice[$i]!='index.php' && !in_array($stranice[$i], $seo_existing_pages)){	  
	$nove_stranice[]=$stranice[$i];
	}
}
$stranice=$nove_stranice;

?>
<div id="container">
	<div id="top">
	<h1>New SEO page</h1>
		<?php if($error_message!=""){ ?><p id="error_message"><?php echo $error_message;   ?></p><?php } ?> 
		<?php if($warning_message!=""){ ?><p id="warning_message"><?php echo $warning_message;   ?></p><?php } ?>
		<?php if($success_message!=""){ ?><p id="successful_message"><?php echo $success_message;   ?></p><?php } ?>
		<?php if($info_message!=""){ ?><p id="info_message"><?php echo $info_message;   ?></p><?php } ?>
	</div><!--top-->
	<?php include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <form action="" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Page:</td><td><select name="page">
				<?php for ($i=0;$i<sizeof($stranice);$i++){?>
                <option value="<?php echo $stranice[$i]; ?>"><?php echo $stranice[$i]; ?></option>
				<?php }?>
                </select></td>
			</tr>
            <tr>
            	<td>Title:</td>
                <td><input type="text" name="title" value="<?php echo $seo_configuration->title; ?>"/></td>
			</tr>
            <tr>
				<td>Keywords:</td>
                <td><input type="text" name="keyword" value="<?php echo $seo_configuration->keyword; ?>"/></td>
			</tr>
            <tr>
				<td>Description:</td>
                <td><input type="text" name="description" value="<?php echo $seo_configuration->description; ?>"/></td>
			</tr>
            <tr>
            	<td>Image:</td>
                <td><input type="file" name="image" />
				<?php if ($seo_configuration->image!=''){?>
                <img src="../images/seo_images/<?php echo $seo_configuration->image; ?>" />
				<?php echo "Stored in: " . "../images/seo_images/" . $_FILES["image"]["name"];
				}else{
					echo 'No image';
					}?></td>
			</tr>
            <tr>
            	<td>Type:</td>
                <td><select name="type">
                <option value="fixed">Fixed</option>
                <option value="domain_object">Domain object</option>
                </select></td>
			</tr>        
        <div style="clear:both;"></div>
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

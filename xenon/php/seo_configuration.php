<?php 
require_once "../classes/domain/xenon_menu.class.php";
require_once "../classes/domain/seo_configuration.class.php";
require_once "php/functions.php";
$broker = new db_broker();
$seo_default_configuration = $broker->get_data(new seo_configuration(1));
$seo_configuration = $broker->get_all_data(new seo_configuration);

if($_POST)
{	
	$seo_default_configuration = $broker->get_data(new seo_configuration(1));

	if($_POST['obrisi_sliku'] == ''){
		if($_FILES['image']['error'] == 0){
			$seo_image=$_FILES['image']['name'];
			$seo_temp_image = $_FILES['image']['tmp_name'];
			move_uploaded_file($seo_temp_image, '../images/seo_images/'.$seo_image);
			$seo_default_configuration->image = $_FILES["image"]["name"];
		}else{
			$seo_default_configuration->image = $_POST['old_image'];
			}
	}else{
		$seo_default_configuration->image = '';
	}
	
	$seo_default_configuration->page = 'default';
	$seo_default_configuration->type = 'fixed';
	$seo_default_configuration->title=$_POST['title'];
	$seo_default_configuration->keyword=$_POST['keyword'];
	$seo_default_configuration->description=$_POST['description'];
	
	if (sizeof($seo_configuration[0])!=0){
		$broker->update($seo_default_configuration);
	}else{
	if (sizeof($seo_configuration[0])==0){
		$broker->insert($seo_default_configuration);
		}
	}
	$success_message = $ap_lang["You have successfully updated website"];	
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
	<h1><?php echo $ap_lang["Default SEO"]; ?></h1>
		 <?php if (sizeof($stranice) == 0){?>
        <p id="successful_message">Sve stranice imaju popunjene SEO podatke.</p>
        <?php }else{ ?>
        <p id="error_message"> Broj stranica bez SEO podataka: <?php echo sizeof($stranice)?></p>
        <?php }?>
	</div><!--top-->
	<?php	include_once "php/settings_menu.php";	?>
	<div id="right_domain_object">
        <div id="new_edit_record">
        <form action="" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="page" value="<?php echo $seo_default_configuration->page; ?>"/>
        <table>
        	<tr>
            	<td>Title:</td>
                <td><input type="text" name="title" value="<?php echo $seo_default_configuration->title; ?>" style="width:450px"/></td>
            </tr>
            
            <tr>
            	<td>Keywords: </td>
                <td><input type="text" name="keyword" value="<?php echo $seo_default_configuration->keyword; ?>" style="width:450px"/></td>
            </tr>
            <tr>
            	<td>Description:</td>
                <td><input type="text" name="description" value="<?php echo $seo_default_configuration->description; ?>" style="width:450px"/></td>
            </tr>
            <tr>
            	<td>Image:</td>
                <td>
                	<input type="file" name="image" />
                    <input type="hidden" name="old_image" value="<?php echo $seo_default_configuration->image; ?>" />
                    
                    <?php if ($seo_default_configuration->image!=''){?>
                    <br /><input type="checkbox" name="obrisi_sliku" value="da" id="obrisi" />
                    <label for="obrisi">Delete image</label><br />

                    <img src="../images/seo_images/<?php echo $seo_default_configuration->image; ?>" style="max-height:70px"  /><br />
                    <?php }?>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td><button type="submit" id="button" value="<?php echo $ap_lang["Submit"]; ?>"><?php echo $ap_lang["Submit"]; ?></button></td>
            </tr>
        </table>
		</form>
        <br />
    </div>
    
   
	<fieldset>
    	<legend>SEO parameters for pages</legend>
        <a href="index.php?lang=en&type=s&page=seo_add_page">Add new page</a><br /><br />

		List of pages:
        <hr />
	 <?php for ($i=1;$i<sizeof($seo_configuration);$i++){?>
     	<div class="seo_element">
        	<div><strong>Page:</strong> <span class="page_title"><?php echo $seo_configuration[$i]->page; ?></span></div>
        	<div><strong>SEO Title:</strong> <?php echo $seo_configuration[$i]->title; ?></div>
            <div><strong>SEO Keywords:</strong> <?php echo $seo_configuration[$i]->keyword; ?></div>
            <div><strong>SEO Description:</strong> <?php echo $seo_configuration[$i]->description; ?></div>
            <div><strong>Image:</strong><br />
            	<?php if ($seo_configuration[$i]->image!=''){ ?>
                <img src="../images/seo_images/<?php echo $seo_configuration[$i]->image; ?>" height="70" />
                <?php }?>
            </div>
            <div><strong>Options:</strong> 
            	<a href="index.php?lang=en&type=s&page=seo_edit_page&id=<?php echo $seo_configuration[$i]->id; ?>">Edit page</a> |
            	<a href="index.php?lang=en&type=s&page=seo_delete_page&id=<?php echo $seo_configuration[$i]->id; ?>">Delete page</a>
            </div>
        </div>
        <?php }?>
    </fieldset>
    
	</div><!--right_domain_object-->
	<div style="clear:both"></div>
</div><!--container-->

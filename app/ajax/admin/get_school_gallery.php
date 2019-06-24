<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->gallery) > 0){ ?>
	<?php for ($i=0; $i < sizeof($item->gallery); $i++) {
      $picture = $item->gallery[$i];
    ?>
    <div class="gallery_item">
        <div class="options">
          <i class="fa fa-star <?php if($picture->thumb == 1){ ?>gold<?php }else{ ?>white<?php } ?>" onclick="set_as_thumb(<?php echo $picture->id; ?>)"></i>
          <i class="fa fa-times" onclick="remove_picture(<?php echo $picture->id; ?>)" title="Set as thumb picture"></i>
          <div style="clear:both"></div>
        </div>
        <div class="gallery_image" style="background-image: url(<?php echo $picture->display_picture; ?>);"></div>
    </div>
    <?php } ?>
    <div style="clear: both;"></div>
<?php }else{ ?>
	<div class="alert alert-default alert-dismissible" style="margin: 10px;">
      <h4><i class="icon fa fa-info"></i> Info</h4>
      You do not have any pictures in gallery
    </div>
    <br>
<?php } ?>


<style type="text/css">
  .gallery_item{
    width: 23%;
    float: left;
    margin: 0.9%;
    border: 2px solid #3c8dbc;
    border-radius: 4px;
  }

  .options{
    background-color: #3c8dbc;
    padding: 5px;
  }

  .options .fa-star{
    float: left;
  }

  .options .fa-times{
    float: right;
  }

  .options .fa-star.gold{
    color: gold;
  }

  .options .fa-star.white{
    color: white;
  }

  .options .fa-star.white:hover{
    color: gold;
  }

  .options i{
    cursor: pointer;
  }

  .options i:hover{
    color:red;
  }

  .gallery_item .gallery_image{
    width: 100%;
    padding-top: 100%;
    background-size: cover!important;
  }
</style>
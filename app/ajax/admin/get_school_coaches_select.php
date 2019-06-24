<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->coaches) > 0){ ?>
  <option value="0">Do not assign coach for whole programm</option>
  <?php for ($i=0; $i < sizeof($item->coaches); $i++) { 
          $coach = $item->coaches[$i];
        ?>
    <option value="<?php echo $coach->id; ?>"><?php echo $coach->full_name; ?> will be responsible for whole programm</option>
  <?php } ?>
<?php } ?>
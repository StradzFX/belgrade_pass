<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->locations) > 0){ ?>
  <option value="">Select location</option>
  <?php for ($i=0; $i < sizeof($item->locations); $i++) { 
          $location = $item->locations[$i];
        ?>
    <option value="<?php echo $location->id; ?>"><?php echo $location->city.', '.$location->part_of_city.', '.$location->street; ?></option>
  <?php } ?>
<?php } ?>
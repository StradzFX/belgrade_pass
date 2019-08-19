<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->locations) > 0){ ?>
	<table class="table table-striped">
        <tbody id="all_coaches">
          <tr>
            <th>City</th>
            <th>Part of the city</th>
            <th>Address</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($item->locations); $i++) { 
          $location = $item->locations[$i];
        ?>
          <tr id="coach_<?php echo $location->id; ?>">
            <td>
              <?php echo $location->city; ?>
            </td>
            <td>
              <?php echo $location->part_of_city; ?>
            </td>
            <td>
              <?php echo $location->street; ?>
            </td>
            <td>
              <a href="javascript:void(0)" onclick="edit_location(<?php echo $location->id; ?>,'<?php echo $location->city; ?>','<?php echo $location->part_of_city; ?>','<?php echo $location->street; ?>','<?php echo $location->email; ?>','<?php echo $location->username; ?>','<?php echo $location->latitude; ?>','<?php echo $location->longitude; ?>')">
                  <div class="btn btn-primary">
                    <i class="fa fa-pencil" title="edit"></i>
                  </div>
                </a>

                <a href="javascript:void(0)" onclick="remove_location(<?php echo $location->id; ?>)">
                  <div class="btn btn-primary">
                    <i class="fa fa-trash" title="delete"></i>
                  </div>
                </a>


            </td>
          </tr>
        <?php } ?>
        
      </tbody>
  </table>
<?php }else{ ?>
	<div class="alert alert-default alert-dismissible" style="margin: 10px;">
      <h4><i class="icon fa fa-info"></i> Info</h4>
      You do not have any locations
    </div>
    <br>
<?php } ?>
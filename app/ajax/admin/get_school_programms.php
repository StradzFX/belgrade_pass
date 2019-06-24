<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->programms) > 0){ ?>
	<table class="table table-striped">
        <tbody id="all_coaches">
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Location</th>
            <th>Number of days</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($item->programms); $i++) { 
          $programm = $item->programms[$i];
        ?>
          <tr>
            <td>
              <?php echo $programm->name; ?>
            </td>
            <td>
              <?php echo $programm->age_from; ?>-<?php echo $programm->age_to; ?>
            </td>
            <td>
              <?php echo $programm->location_name; ?>
            </td>
            <td>
              <?php echo $programm->number_of_days; ?>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="edit_days(<?php echo $programm->id; ?>)">
                  <i class="fa fa-calendar" title="edit days"></i>
                </a>

                <a href="javascript:void(0)" onclick="remove_programm(<?php echo $programm->id; ?>)">
                  <i class="fa fa-trash" title="delete"></i>
                </a>
            </td>
          </tr>
        <?php } ?>
        
      </tbody>
  </table>
<?php }else{ ?>
	<div class="alert alert-default alert-dismissible" style="margin: 10px;">
      <h4><i class="icon fa fa-info"></i> Info</h4>
      You do not have any programms
    </div>
    <br>
<?php } ?>
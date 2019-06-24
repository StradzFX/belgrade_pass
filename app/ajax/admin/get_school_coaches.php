<?php

$data = $post_data['data'];

$item = SchoolModule::get_admin_data($data['id']);
?>

<?php if(sizeof($item->coaches) > 0){ ?>
	<table class="table table-striped">
        <tbody id="all_coaches">
          <tr>
            <th>Full name</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($item->coaches); $i++) { 
          $coach = $item->coaches[$i];
        ?>
          <tr id="coach_<?php echo $coach->id; ?>">
            <td>
              <?php echo $coach->full_name; ?>
              <input type="hidden" name="coaches[]" value="<?php echo $coach->id; ?>">
            </td>
            <td>
                <a href="javascript:void(0)" onclick="remove_coach(<?php echo $item->id; ?>,<?php echo $coach->id; ?>)">
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
      You do not have any coaches associated
    </div>
    <br>
<?php } ?>
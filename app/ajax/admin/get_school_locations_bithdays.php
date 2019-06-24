<?php
global $broker;
$data = $post_data['data'];

$company_birthday_data_all = new company_birthday_data();
$company_birthday_data_all->set_condition('checker','!=','');
$company_birthday_data_all->add_condition('recordStatus','=','O');
$company_birthday_data_all->add_condition('training_school','=',$data['id']);
$company_birthday_data_all->set_order_by('pozicija','DESC');
$company_birthday_data_all = $broker->get_all_data_condition($company_birthday_data_all);

for($i=0;$i<sizeof($company_birthday_data_all);$i++){
  if($company_birthday_data_all[$i]->ts_location != ''){$company_birthday_data_all[$i]->ts_location = $broker->get_data(new ts_location($company_birthday_data_all[$i]->ts_location));}
}

?>

<?php if(sizeof($company_birthday_data_all) > 0){ ?>
	<table class="table table-striped">
        <tbody id="all_coaches">
          <tr>
            <th>Name</th>
            <th>City</th>
            <th>Street</th>
            <th>Max Kids</th>
            <th>Max Adults</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($company_birthday_data_all); $i++) { 
          $location = $company_birthday_data_all[$i];
        ?>
          <tr id="coach_<?php echo $location->id; ?>">
            <td>
              <?php echo $location->name; ?>
            </td>
            <td>
              <?php echo $location->ts_location->city; ?>
            </td>
            <td>
              <?php echo $location->ts_location->street; ?>
            </td>
            <td>
              <?php echo $location->max_kids; ?>
            </td>
            <td>
              <?php echo $location->max_adults; ?>
            </td>
            <td>
              <a href="javascript:void(0)" onclick="open_lb_data_location(<?php echo $location->id; ?>,'<?php echo $location->ts_location->id; ?>','<?php echo $location->name; ?>','<?php echo $location->max_kids; ?>','<?php echo $location->max_adults; ?>','<?php echo $location->garden; ?>','<?php echo $location->smoking; ?>','<?php echo $location->catering; ?>','<?php echo $location->animators; ?>','<?php echo $location->watching_kids; ?>')">
                  <i class="fa fa-pencil" title="edit"></i>
                </a>

                <a href="javascript:void(0)" onclick="remove_location_birthday(<?php echo $location->id; ?>)">
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
      You do not have any locations
    </div>
    <br>
<?php } ?>
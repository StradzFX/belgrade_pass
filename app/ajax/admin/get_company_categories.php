<?php

$data = $post_data['data'];

global $broker;

$company_category_all = new company_category();
$company_category_all->set_condition('checker','!=','');
$company_category_all->add_condition('recordStatus','=','O');
$company_category_all->add_condition('company','=',$data['id']);
$company_category_all->set_order_by('pozicija','DESC');
$company_category_all = $broker->get_all_data_condition($company_category_all);

for($i=0;$i<sizeof($company_category_all);$i++){
    $company_category_all[$i]->category = $broker->get_data(new sport_category($company_category_all[$i]->category));
}

?>

<?php if(sizeof($company_category_all) > 0){ ?>
	<table class="table table-striped">
        <tbody id="all_coaches">
          <tr>
            <th>Name</th>
            <th>Icon</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($company_category_all); $i++) { 
          $category = $company_category_all[$i];
        ?>
          <tr id="coach_<?php echo $location->id; ?>">
            <td>
              <?php echo $category->category->name; ?>
            </td>
            <td>
              <img src="../public/images/icons/<?php echo $category->category->logo; ?>">
            </td>
            <td>
                <a href="javascript:void(0)" onclick="remove_category(<?php echo $category->id; ?>)">
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
      You do not have any categories
    </div>
    <br>
<?php } ?>
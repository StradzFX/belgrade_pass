<?php

$data = $post_data['data'];

$day_of_week_cdr[1] = 'Ponedeljak';
$day_of_week_cdr[2] = 'Utorak';
$day_of_week_cdr[3] = 'Sreda';
$day_of_week_cdr[4] = 'Četvrtak';
$day_of_week_cdr[5] = 'Petak';
$day_of_week_cdr[6] = 'Subota';
$day_of_week_cdr[7] = 'Nedelja';

global $broker;

$company_discount_rules = new company_discount_rules();
$company_discount_rules->set_condition('checker','!=','');
$company_discount_rules->add_condition('recordStatus','=','O');
$company_discount_rules->add_condition('training_school','=',$data['id']);

$company_discount_rules = $broker->get_all_data_condition($company_discount_rules);



for ($i=0; $i < sizeof($company_discount_rules); $i++) { 
	if($company_discount_rules[$i]->day_from == $company_discount_rules[$i]->day_to){
		$company_discount_rules[$i]->day_display = $day_of_week_cdr[$company_discount_rules[$i]->day_from];
	}else{
		$company_discount_rules[$i]->day_display = $day_of_week_cdr[$company_discount_rules[$i]->day_from].' - '.$day_of_week_cdr[$company_discount_rules[$i]->day_to];
	}

	$company_discount_rules[$i]->display_hours_from = floor($company_discount_rules[$i]->hours_from/60);
	$company_discount_rules[$i]->display_minutes_from =  $company_discount_rules[$i]->hours_from - $company_discount_rules[$i]->display_hours_from * 60;

	$company_discount_rules[$i]->display_time_from = sprintf('%02d',$company_discount_rules[$i]->display_hours_from).':'.sprintf('%02d',$company_discount_rules[$i]->display_minutes_from);


	$company_discount_rules[$i]->display_hours_to = floor($company_discount_rules[$i]->hours_to/60);
	$company_discount_rules[$i]->display_minutes_to =  $company_discount_rules[$i]->hours_to - $company_discount_rules[$i]->display_hours_to * 60;

	$company_discount_rules[$i]->display_time_to = sprintf('%02d',$company_discount_rules[$i]->display_hours_to).':'.sprintf('%02d',$company_discount_rules[$i]->display_minutes_to);
}




?>

<?php if(sizeof($company_discount_rules) > 0){ ?>
	<table class="table table-striped">
        <tbody id="">
          <tr>
            <th>Day(s)</th>
            <th>Time</th>
            <th>Discount</th>
            <th style="width: 150px">Actions</th>
          </tr>
        <?php for ($i=0; $i < sizeof($company_discount_rules); $i++) { ?>
          <tr>
            <td>
              <?php echo $company_discount_rules[$i]->day_display; ?>
            </td>
            <td>
              <?php echo $company_discount_rules[$i]->display_time_from; ?> - <?php echo $company_discount_rules[$i]->display_time_to; ?>
            </td>
            <td>
              <?php echo $company_discount_rules[$i]->discount; ?>%
            </td>
            <td>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_company_discount_rules" onclick="get_discount_rules_data(<?php echo $company_discount_rules[$i]->id; ?>)">
                  <div class="btn btn-primary btn-sm">
                    <i class="fa fa-edit" title="edit"></i>
                  </div>
                </a>

                <a href="javascript:void(0)" onclick="remove_company_discount_rule(<?php echo $company_discount_rules[$i]->id; ?>)">
                  <div class="btn btn-primary btn-sm">
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
      You do not have any special discount rules
    </div>
    <br>
<?php } ?>
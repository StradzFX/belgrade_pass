<?php

$data = $post_data['data'];

global $broker;


$accepted_passes_all = new accepted_passes();
$accepted_passes_all->set_condition('checker','!=','');
$accepted_passes_all->add_condition('recordStatus','=','O');

if($data['date_from'] != ''){
  $accepted_passes_all->add_condition('makerDate','>=',$data['date_from']);
}

if($data['date_to'] != ''){
  $accepted_passes_all->add_condition('makerDate','<=',$data['date_to']);
}

if($data['company'] != ''){
  $accepted_passes_all->add_condition('training_school','=',$data['company']);
}

if($data['card_id'] != ''){
  $accepted_passes_all->add_condition('user_card','=',$data['card_id']);
}

if($data['user_search'] != ''){
  $user_search = $data['user_search'];
  $accepted_passes_all->add_condition('','',"user IN (SELECT id FROM user WHERE email LIKE '$user_search%' OR CONCAT(first_name,' ',last_name) LIKE '$user_search%' OR CONCAT(last_name,' ',first_name) LIKE '$user_search%')");
}


$total_price = 0;
$total_user_payed = 0;
$total_commision = 0;

$accepted_passes_all->set_order_by('makerDate','DESC');
$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

for($i=0;$i<sizeof($accepted_passes_all);$i++){
  if($accepted_passes_all[$i]->user_card != ''){$accepted_passes_all[$i]->user_card = $broker->get_data(new user_card($accepted_passes_all[$i]->user_card));}
  if($accepted_passes_all[$i]->purchase != ''){$accepted_passes_all[$i]->purchase = $broker->get_data(new purchase($accepted_passes_all[$i]->purchase));}
  if($accepted_passes_all[$i]->training_school != ''){$accepted_passes_all[$i]->training_school = $broker->get_data(new training_school($accepted_passes_all[$i]->training_school));}
  if($accepted_passes_all[$i]->user != ''){$accepted_passes_all[$i]->user = $broker->get_data(new user($accepted_passes_all[$i]->user));}
  if($accepted_passes_all[$i]->company_location != ''){$accepted_passes_all[$i]->company_location = $broker->get_data(new ts_location($accepted_passes_all[$i]->company_location));}

  $total_price += round($accepted_passes_all[$i]->taken_passes * 100 / (100 - $accepted_passes_all[$i]->training_school->pass_customer_percentage),1);
  $total_user_payed += $accepted_passes_all[$i]->taken_passes;
  $total_commision += $accepted_passes_all[$i]->pay_to_us;
  
}



?>
<table class="table table-striped all_items">
  <tbody>
    <tr>
      <th style="width: 10px">#</th>
      <th>Date</th>
      <th>Company</th>
      <th>Location</th>
      <th>Total price</th>
      <th>User payed</th>
      <th>BP commision</th>
      <th>Card Number</th>
      <th>User Email</th>
      <th>User Full Name</th>
    </tr>
    <?php for ($i=0; $i < sizeof($accepted_passes_all); $i++) { ?>
      <tr>
        <td><?php echo $i+1 ?>.</td>
        <td><?php echo date('d.m.Y H:i:s',strtotime($accepted_passes_all[$i]->makerDate)); ?></td>
        <td><?php echo $accepted_passes_all[$i]->training_school->name; ?></td>
        <td><?php echo $accepted_passes_all[$i]->company_location->street; ?></td>

        <td><?php echo round($accepted_passes_all[$i]->taken_passes * 100 / (100 - $accepted_passes_all[$i]->training_school->pass_customer_percentage),1); ?> RSD</td>
        <td><?php echo $accepted_passes_all[$i]->taken_passes; ?> RSD</td>
        <td><?php echo $accepted_passes_all[$i]->pay_to_us; ?> RSD</td>

        <td><?php echo $accepted_passes_all[$i]->user_card->card_number; ?></td>
        <td><?php echo $accepted_passes_all[$i]->user_card->email; ?></td>
        <td><?php echo $accepted_passes_all[$i]->user_card->parent_first_name; ?> <?php echo $accepted_passes_all[$i]->user_card->parent_last_name; ?></td>
      </tr>
    <?php } ?>

    <tr>
      <td colspan="4"><b class="pull-right">Total</b></td>

      <td><?php echo $total_price; ?> RSD</td>
      <td><?php echo $total_user_payed; ?> RSD</td>
      <td><?php echo $total_commision; ?> RSD</td>

      <td></td>
      <td></td>
      <td></td>
    </tr>
    
  </tbody>
</table>
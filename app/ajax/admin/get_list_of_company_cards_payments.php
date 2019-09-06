<?php
$data=$post_data['data'];
$company_id = $data['id'];

global $broker;

$company_cards_payment = new accepted_passes();
$company_cards_payment->set_condition('checker', '!=', '');
$company_cards_payment->add_condition('recordStatus', '=', 'O');
$company_cards_payment->add_condition('training_school', '=', $company_id);
$company_cards_payment->add_condition('makerDate', '>=', $data['payment_date_from']);
if($data['payment_date_to'] != ''){
  $company_cards_payment->add_condition('makerDate', '<=', $data['payment_date_to']);
  $company_cards_payment->add_condition('user_card', 'IN',"(SELECT id FROM user_card WHERE email LIKE '%".$data['payment_user_search']."%')");
}

$total_price = 0;
$bp_comission = 0;

$company_cards_payment -> set_order_by('makerDate', 'DESC');
$list = $broker->get_all_data_condition($company_cards_payment);

for ($i=0;$i<sizeof($list);$i++) { 
  $location = new ts_location($list[$i]->company_location);
  $list[$i]->location = $broker->get_data($location);

  $user_card = new user_card($list[$i]->user_card);
  $list[$i]->card = $broker->get_data($user_card);

  $user_name = new user($list[$i]->user);
  $list[$i]->user = $broker->get_data($user_name);

  $total_price += $list[$i]->taken_passes;
  $total_user_payed +=$list[$i]->pay_to_company;
  $bp_comission += $list[$i]->pay_to_us;
}
?>

<table class="table table-striped all_items">
  <tbody>
    <tr>
      <th>#</th>
      <th>Date:</th>
      <th>Location</th>s
      <th>Card Number</th>
      <th>User</th>
      <th>Total price</th>
      <th>User payed</th>
      <th>BP commission</th>
    </tr>
    <?php for ($i=0; $i < sizeof($list); $i++) { ?>
    <tr>
      <td><?php echo $i+1; ?>.</td>
      <td><?php echo date('d.m.Y.',strtotime($list[$i]->makerDate)); ?></td>
      <td><?php echo $list[$i]->location->street; ?></td>
      <td><?php echo $list[$i]->card->card_number; ?></td>
      <td><?php echo $list[$i]->user->first_name; ?> <?php echo $list[$i]->user->last_name; ?> (<?php echo $list[$i]->user->email; ?>)</td>
      <td><?php echo $list[$i]->taken_passes; ?></td>
      <td><?php echo $list[$i]->pay_to_company; ?></td>
      <td><?php echo $list[$i]->pay_to_us; ?></td>
    </tr>
  <?php } ?>
     <tr>
      <td colspan="5"><b class="pull-right">Total</b></td>

      <td><?php echo $total_price; ?> RSD</td>
      <td><?php echo $total_user_payed; ?> RSD</td>
      <td><?php echo $bp_comission; ?> RSD</td>
    </tr>
  </tbody>
</table> 

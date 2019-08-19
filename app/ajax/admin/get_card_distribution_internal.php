<?php

global $broker;

$data=$post_data['data'];

$internal_cards_list = new user_card();
$internal_cards_list->set_condition('checker','!=','');
$internal_cards_list->add_condition('recordStatus','=','O');
$internal_cards_list->add_condition('delivery_method','=','post');
$internal_cards_list->add_condition('','',"card_number IN (SELECT card_number FROM card_numbers WHERE internal_reservation = 1)");
$internal_cards_list->set_order_by('pozicija','DESC');
$internal_cards_list = $broker->get_all_data_condition($internal_cards_list);

for ($i=0; $i < sizeof($internal_cards_list); $i++) { 
	$internal_cards_list[$i]->address = $internal_cards_list[$i]->post_street.', '.$internal_cards_list[$i]->post_postal.' '.$internal_cards_list[$i]->post_city;
	$internal_cards_list[$i]->customer_received = $internal_cards_list[$i]->customer_received == 1 ? 'Yes' : 'No';
	$internal_cards_list[$i]->full_name = $internal_cards_list[$i]->parent_first_name.' '.$internal_cards_list[$i]->parent_last_name;
	$internal_cards_list[$i]->date_issued = date('d.m.Y.',strtotime($internal_cards_list[$i]->makerDate));
}

?>

<table class="table table-striped">
  <tbody>
    <tr>
      <th style="width: 10px">#</th>
      <th>Card number</th>
      <th>Date issued</th>
      <th>Customer Name</th>
      <th>Customer Phone</th>
      <th>Customer Email</th>
      <th>Address</th>
      <th>Customer received</th>
    </tr>
    <?php for ($i=0; $i < sizeof($internal_cards_list); $i++) { ?>
      <tr>
        <td><?php echo $i+1; ?>.</td>
        <td><?php echo $internal_cards_list[$i]->card_number; ?></td>
        <td><?php echo $internal_cards_list[$i]->date_issued; ?></td>
        <td><?php echo $internal_cards_list[$i]->full_name; ?></td>
        <td><?php echo $internal_cards_list[$i]->phone; ?></td>
        <td><?php echo $internal_cards_list[$i]->email; ?></td>
        <td><?php echo $internal_cards_list[$i]->address; ?></td>
        <td>
            <?php echo $internal_cards_list[$i]->customer_received; ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
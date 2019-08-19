
<?php
global $broker;

$data=$post_data['data'];

$website_list = new user_card();
$website_list->set_condition('checker','!=','');
$website_list->add_condition('recordStatus','=','O');
$website_list->add_condition('delivery_method','=','post');
$website_list->add_condition('','',"card_number NOT IN (SELECT card_number FROM card_numbers WHERE internal_reservation = 1)");
$website_list->set_order_by('pozicija','DESC');
$website_list = $broker->get_all_data_condition($website_list);

for ($i=0; $i < sizeof($website_list); $i++) { 
  $website_list[$i]->address = $website_list[$i]->post_street.', '.$website_list[$i]->post_postal.' '.$website_list[$i]->post_city;
  $website_list[$i]->customer_received = $website_list[$i]->customer_received == 1 ? 'Yes' : 'No';
  $website_list[$i]->full_name = $website_list[$i]->parent_first_name.' '.$website_list[$i]->parent_last_name;
  $website_list[$i]->date_issued = date('d.m.Y.',strtotime($website_list[$i]->makerDate));
}

?>
  <div>
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
        <?php for ($i=0; $i < sizeof($website_list); $i++) { ?>
          <tr>
            <td><?php echo $i+1; ?>.</td>
            <td><?php echo $website_list[$i]->card_number; ?></td>
            <td><?php echo $website_list[$i]->date_issued; ?></td>
            <td><?php echo $website_list[$i]->full_name; ?></td>
            <td><?php echo $website_list[$i]->phone; ?></td>
            <td><?php echo $website_list[$i]->email; ?></td>
            <td><?php echo $website_list[$i]->address; ?></td>
            <td>
                <?php echo $website_list[$i]->customer_received; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
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

if($data['user_search'] != ''){
  $user_search = $data['user_search'];
  $accepted_passes_all->add_condition('','',"user IN (SELECT id FROM user WHERE email LIKE '$user_search%' OR CONCAT(first_name,' ',last_name) LIKE '$user_search%' OR CONCAT(last_name,' ',first_name) LIKE '$user_search%')");
}



$accepted_passes_all->set_order_by('makerDate','DESC');
$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

for($i=0;$i<sizeof($accepted_passes_all);$i++){
  if($accepted_passes_all[$i]->user_card != ''){$accepted_passes_all[$i]->user_card = $broker->get_data(new user_card($accepted_passes_all[$i]->user_card));}
  if($accepted_passes_all[$i]->purchase != ''){$accepted_passes_all[$i]->purchase = $broker->get_data(new purchase($accepted_passes_all[$i]->purchase));}
  if($accepted_passes_all[$i]->training_school != ''){$accepted_passes_all[$i]->training_school = $broker->get_data(new training_school($accepted_passes_all[$i]->training_school));}
  if($accepted_passes_all[$i]->user != ''){$accepted_passes_all[$i]->user = $broker->get_data(new user($accepted_passes_all[$i]->user));}
  if($accepted_passes_all[$i]->company_location != ''){$accepted_passes_all[$i]->company_location = $broker->get_data(new ts_location($accepted_passes_all[$i]->company_location));}
  
}



?>
<table class="table table-striped all_items">
  <tbody>
    <tr>
      <th style="width: 10px">#</th>
      <th>Date</th>
      <th>Company</th>
      <th>Location</th>
      <th>Card Number</th>
      <th>User Email</th>
      <th>User Full Name</th>
    </tr>
    <?php for ($i=0; $i < sizeof($accepted_passes_all); $i++) { ?>
      <tr>
        <td><?php echo $i+1 ?>.</td>
        <td><?php echo date('d.m.Y H:i:s',strtotime($accepted_passes_all[$i]->makerDate)); ?></td>
        <td><?php echo $accepted_passes_all[$i]->training_school->name; ?></td>
        <td><?php echo $accepted_passes_all[$i]->company_location->username; ?></td>
        <td><?php echo $accepted_passes_all[$i]->user_card->card_number; ?></td>
        <td><?php echo $accepted_passes_all[$i]->user->email; ?></td>
        <td><?php echo $accepted_passes_all[$i]->user->first_name; ?> <?php echo $accepted_passes_all[$i]->user->last_name; ?></td>
      </tr>
    <?php } ?>
    
  </tbody>
</table>
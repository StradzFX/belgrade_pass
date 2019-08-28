<?php
global $broker;
$data = $post_data['data'];
//var_dump($data);
/*

$data['id']
$data['date_from']
$data['date_to']

*/
$accepted_passes_all = new accepted_passes();
$accepted_passes_all->set_condition('checker','!=','');
$accepted_passes_all->add_condition('recordStatus','=','O');
$accepted_passes_all->add_condition('user','=',$data['id']);
$accepted_passes_all->add_condition('makerDate','>=',$data['date_from']);
$accepted_passes_all->add_condition('makerDate','<=',$data['date_to']);
$accepted_passes_all->set_order_by('pozicija','DESC');
$accepted_passes_all = $broker->get_all_data_condition($accepted_passes_all);

$total_taken_passes = 0;
$total_bp_profit = 0;

for($i=0;$i<sizeof($accepted_passes_all);$i++){
if($accepted_passes_all[$i]->user_card != ''){$accepted_passes_all[$i]->user_card = $broker->get_data(new user_card($accepted_passes_all[$i]->user_card));}
if($accepted_passes_all[$i]->purchase != ''){$accepted_passes_all[$i]->purchase = $broker->get_data(new purchase($accepted_passes_all[$i]->purchase));}
if($accepted_passes_all[$i]->training_school != ''){$accepted_passes_all[$i]->training_school = $broker->get_data(new training_school($accepted_passes_all[$i]->training_school));}
if($accepted_passes_all[$i]->user != ''){$accepted_passes_all[$i]->user = $broker->get_data(new user($accepted_passes_all[$i]->user));}
if($accepted_passes_all[$i]->company_location != ''){$accepted_passes_all[$i]->company_location = $broker->get_data(new ts_location($accepted_passes_all[$i]->company_location));}

  $total_taken_passes += $accepted_passes_all[$i]->taken_passes;
  $total_bp_profit += $accepted_passes_all[$i]->pay_to_us;

}



?>
<table class="table table-striped all_items">
  <tbody>
    <tr>
      <th style="width: 10px">#</th>
      <th>Date</th>
      <th>Company</th>
      <th>Location</th>
      <th>User payed</th>
      <th>BP commision</th>
    </tr>
    <?php for($i=0;$i<sizeof($accepted_passes_all);$i++){ ?>
    <tr>
        <td><?php echo $i+1; ?>.</td>
        <td><?php echo date('d.m.Y. H:i:s',strtotime($accepted_passes_all[$i]->makerDate)); ?></td>
        <td><?php echo $accepted_passes_all[$i]->training_school->name; ?></td>
        <td><?php echo $accepted_passes_all[$i]->company_location->street; ?></td>
        <td><?php echo $accepted_passes_all[$i]->taken_passes; ?> RSD</td>
        <td><?php echo $accepted_passes_all[$i]->pay_to_us; ?> RSD</td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="4"><b class="pull-right">Total</b></td>

      <td><?php echo $total_taken_passes; ?> RSD</td>
      <td><?php echo $total_bp_profit; ?> RSD</td>
    </tr>
    
  </tbody>
</table>
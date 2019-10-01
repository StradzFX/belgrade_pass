<?php
  $data = $post_data['data'];

  $purchase_types['post_office'] = array(
    'name' => 'Post office'
  );

  $purchase_types['admin_payment'] = array(
    'name' => 'Admin Payment'
  );

  global $broker;
  $purchase_all = new purchase();
  $purchase_all->add_condition('recordStatus','=','O');
  $purchase_all->add_condition('user','=',$data['id']);
  $purchase_all->set_order_by('pozicija','DESC');
  $purchase_all = $broker->get_all_data_condition($purchase_all);

  for($i=0;$i<sizeof($purchase_all);$i++){
  if($purchase_all[$i]->user != ''){$purchase_all[$i]->user = $broker->get_data(new user($purchase_all[$i]->user));}
  if($purchase_all[$i]->card_package != ''){$purchase_all[$i]->card_package = $broker->get_data(new card_package($purchase_all[$i]->card_package));}
  if($purchase_all[$i]->user_card != ''){$purchase_all[$i]->user_card = $broker->get_data(new user_card($purchase_all[$i]->user_card));}
  }

?>


  <table class="table table-hover">
    <tbody>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Credits</th>
        <th>Payment type</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
      <?php for($i=0;$i<sizeof($purchase_all);$i++){ ?>
      <tr>
        <td><?php echo $purchase_all[$i]->id; ?></td>
        <td><?php echo date('d.m.Y.',strtotime($purchase_all[$i]->makerDate)); ?></td>
        <td><?php echo $purchase_all[$i]->price; ?> din</td>
        <td>
          <?php echo $purchase_types[$purchase_all[$i]->purchase_type]['name']; ?>
        </td>
        <td>
          <?php if($purchase_all[$i]->checker != ''){ ?>
            <span class="label label-success">Approved</span>
          <?php }else{ ?>
            <span class="label label-warning">Pending</span>
          <?php } ?>
          
        </td>
        <td>
          <?php if($purchase_all[$i]->checker == ''){ ?>
            <a href="javascript:void(0)" onclick="approve_purchase(<?php echo $purchase_all[$i]->id; ?>)" class="btn btn-primary btn-xs">Approve</a>
          <?php } ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

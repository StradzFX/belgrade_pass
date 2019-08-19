<?php
global $broker;
$data=$post_data['data'];
$list = PaymentModule::list_payments_admin('post_office');

?>


<table class="table table-striped">
  <tbody><tr>
    <th style="width: 100px;">Purchase no.</th>
    <th>Price</th>
    <th>Card number</th>
    <th>User</th>
    <th style="width: 150px">Actions</th>
  </tr>
  <?php for ($i=0; $i < sizeof($list); $i++) { ?>
    <tr>
      <td><?php echo $list[$i]->id; ?></td>
      <td><?php echo $list[$i]->price; ?> RSD</td>
      <td><?php echo $list[$i]->user_card->card_number; ?></td>
      <td><?php echo $list[$i]->user->email; ?></td>
      <td>

        <?php if($list[$i]->status != 'Approved'){ ?>
        <a href="javascript:void(0)" onclick="approve_post_office(<?php echo $list[$i]->id; ?>)">
          <div class="btn btn-default">
            <i class="fa fa-thumbs-up" title="Approve"></i>
          </div>
        </a>
        <?php }else{ ?>
        <div class="btn btn-primary" disabled>
          <i class="fa fa-thumbs-up" title="Approved"></i>
        </div>
        <?php } ?>
        

        <?php /*<a href="categories_manage/<?php echo $list[$i]->id; ?>">
          <i class="fa fa-pencil" title="Edit data"></i>
        </a>*/ ?>

          
      </td>
    </tr>
  <?php } ?>
  
</tbody></table>
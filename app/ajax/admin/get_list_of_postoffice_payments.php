<?php
global $broker;
$data = $post_data['data'];
$list = PaymentModule::list_payments_admin('post_office',$data['post_office_name_search'], null, $data['post_office_by_number_search'], $data['post_office_dateFrom_search'], $data['post_office_dateTo_search'], $data['post_office_status_search'], $data['post_office_acc_search'])
?>


<table class="table table-striped">
  <tbody><tr>
    <th style="width: 100px;">Purchase no.</th>
    <th>Price</th>
    <th>Card number</th>
    <th>Email</th>
    <th>User name</th>
    <th>Transaction date</th>
    <th style="width: 150px">Actions</th>
  </tr>
  <?php for ($i=0; $i < sizeof($list); $i++) { ?>
    <tr>
      <td><?php echo $list[$i]->id; ?></td>
      <td><?php echo $list[$i]->price; ?> RSD</td>
      <td><?php echo $list[$i]->user_card->card_number; ?></td>
      <td><?php echo $list[$i]->user->email; ?></td>
      <td><?php echo $list[$i]->po_payment_name;?></td>
      <td><?php echo $list[$i]->po_payment_date;?></td>
      <td>

        <?php if($list[$i]->status != 'Approved'){ ?>
        <a href="javascript:void(0)">
          <div class="btn btn-default" data-toggle="modal" data-target="#modal_approve_post_office_payment"
          onclick="set_approve_id(<?php echo $list[$i]->id; ?>)" >
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

<script type="text/javascript">
  function set_approve_id(id){
    $('[name="approve_id"]').val(id);
    /*Prilikom poziva funkcije u kodu iznad prosledjujes(echo) id (post office transakcije) koji je ranije povucen iz baze i ispisan u tabeli.
    Funkcija uzima vrednost i dodeljuje je approve_id-ju i to je to.
     */
  }

</script>
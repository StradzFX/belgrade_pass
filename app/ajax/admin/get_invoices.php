<?php

global $broker;
$data=$post_data['data'];
$list = PaymentModule::list_payments_admin('post_office');

?>


<table class="table table-striped">
  <tbody>
    <tr>
      <th style="width: 100px;">Broj fakture</th>
      <th>Iznos</th>
      <th>Uplata na karticu</th>
      <th>Korisnik</th>
      <th>Status</th>
      <th>Actions</th>
      <th>Print PDF</th>
      <th>Info</th>
    </tr>
    <?php for ($i=0; $i < sizeof($list); $i++) { ?>
    <tr>
      <td><?php echo $list[$i]->id; ?></td>
      <td><?php echo $list[$i]->price; ?> RSD</td>
      <td><?php echo $list[$i]->user_card->card_number; ?></td>
      <td><?php echo $list[$i]->user->email; ?></td>
      <td><span class="label label-success">Approved</span></td>
      <td><span class="label label-warning" name="recall">Recall</span></td>
      <td>
        <a href="javascript:void(0)">
          <div class="btn btn-primary" data-toggle="modal" data-target="#modal_print_invoice_pdf">
            <i class="fa fa-file"></i>
          </div>
        </a>
      </td>
      <td>
        <a href="invoices_info/">
          <div class="btn btn-primary">
            <i class="fas fa-info-circle"></i>
          </div>
        </a>
      </td>
    </tr>
  <?php } ?>
  
  </tbody>
</table>
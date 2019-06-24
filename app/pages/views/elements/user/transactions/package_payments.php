<div class="paying_option_box payment_option_package_payments" <?php if($selected_tab != 'package_payments'){ ?>style="display: none;"<?php } ?>>
    <?php if(sizeof($transactions_all) > 0){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tip</th>
          <th scope="col">Status</th>
          <th scope="col">Datum</th>
          <th scope="col">Akcija</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($transactions_all); $i++) { ?>
          <tr>
            <th scope="row"><?php echo $i+1; ?></th>
            <td><?php echo $tr_types[$transactions_all[$i]->transaction_type]; ?></td>
            <td><?php echo $transactions_all[$i]->status; ?></td>
            <td><?php echo $transactions_all[$i]->display_date; ?></td>
            <td><a href="transakcija/<?php echo $transactions_all[$i]->purchase->id; ?>" class="btn">Vidi detalje</a></td>
          </tr>
        <?php } ?>
        
      </tbody>
    </table>
    <?php }else{ ?>
    <div class="no_transactions">
      <i class="fas fa-credit-card"></i>
      <br/><br/>
      Trenutno nemate nikakve transakcije
    </div>
    <?php } ?>
</div><!--paying_option_box-->
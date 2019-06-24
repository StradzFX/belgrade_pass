<div class="paying_option_box payment_option_payments_debit" <?php if($selected_tab != 'payments_debit'){ ?>style="display: none;"<?php } ?>>
    <div class="hello">
        Spisak svih uplata provizije koje ste izvršili prema BelgradePass-u
    </div>
    <?php if(sizeof($payments_debit) > 0){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Iznos</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($payments_debit); $i++) { ?>
            <tr>
              <th scope="row"><?php echo $i+1; ?></th>
              <td><?php echo $payments_debit[$i]->transaction_date; ?></td>
              <td><?php echo $payments_debit[$i]->transaction_value; ?></td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
    <?php } ?>
    
</div><!--paying_option_box-->
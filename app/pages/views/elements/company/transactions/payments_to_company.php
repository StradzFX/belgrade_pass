<div class="paying_option_box payment_option_payments_credit" <?php if($selected_tab != 'payments_to_company'){ ?>style="display: none;"<?php } ?>>
    <div class="hello">
        Spisak svih isplata koje je BelgradePass izvršio prema Vama
    </div>
    <?php if(sizeof($payments_credit) > 0){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Iznos</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($payments_credit); $i++) { ?>
            <tr>
              <th scope="row"><?php echo $i+1; ?></th>
              <td><?php echo $payments_credit[$i]->transaction_date; ?></td>
              <td><?php echo $payments_credit[$i]->transaction_value; ?></td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
    <?php } ?>
    
</div><!--paying_option_box-->
<div class="paying_option_box payment_option_package_payments" <?php if($selected_tab != 'package_payments'){ ?>style="display: none;"<?php } ?>>
    <?php if($company->type == 'master'){ ?>
    <div class="hello">
        Ukupno za uplatu BelgradePass-u: <span><?php echo $total_to_pay; ?> RSD</span>
    </div>
    <?php } ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Kartica</th>
          <th scope="col">Paket</th>
          <th scope="col">Cena</th>
          <th scope="col">Interna šifra</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($purchase_all); $i++) { ?>
            <tr>
              <th scope="row"><?php echo $i+1; ?></th>
              <td><?php echo $purchase_all[$i]->display_date; ?></td>
              <td><?php echo $purchase_all[$i]->user_card->card_number; ?></td>
              <td><?php echo $purchase_all[$i]->card_package->name; ?></td>
              <td><?php echo $purchase_all[$i]->price; ?> RSD</td>
              <td><?php echo $purchase_all[$i]->internal_code; ?></td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
</div><!--paying_option_box-->
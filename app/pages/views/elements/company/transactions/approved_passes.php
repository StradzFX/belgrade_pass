<div class="paying_option_box payment_option_approved_passes table-responsive" <?php if($selected_tab != 'approved_passes'){ ?>style="display: none;"<?php } ?>>
    <?php if($company->type == 'master'){ ?>
    <div class="hello">
        Ukupno za uplatu Partneru-u: <span><?php echo $total_to_pay_to_partner; ?> RSD</span>
    </div>
    <?php } ?>
    <?php if(sizeof($approvals_all) > 0){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Kartica</th>
          <th scope="col">Kredita</th>
          <?php if($company->type == 'master'){ ?>
          <th scope="col">Zarada</th>
          <th scope="col">BelgradePass-u</th>
          <th scope="col">Lokacija</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($approvals_all); $i++) { ?>
            <tr>
              <th scope="row"><?php echo $i+1; ?></th>
              <td><?php echo $approvals_all[$i]->display_date; ?></td>
              <td><?php echo $approvals_all[$i]->user_card->card_number; ?></td>
              <td><?php echo $approvals_all[$i]->taken_passes_display; ?></td>
              <?php if($company->type == 'master'){ ?>
              <td><?php echo $approvals_all[$i]->pay_to_company; ?> RSD</td>
              <td><?php echo $approvals_all[$i]->pay_to_us; ?> RSD</td>
              <td><?php echo $approvals_all[$i]->company_location->username; ?></td>
              <?php } ?>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
    <?php } ?>
    
</div><!--paying_option_box-->
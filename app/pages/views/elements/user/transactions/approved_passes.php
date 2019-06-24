<div class="paying_option_box payment_option_approved_passes" <?php if($selected_tab != 'approved_passes'){ ?>style="display: none;"<?php } ?>>
    <?php if(sizeof($accepted_passes_all) > 0){ ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Kartica</th>
          <th scope="col">Kredita</th>
          <th scope="col">Kompanija</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($accepted_passes_all); $i++) { ?>
          <tr>
            <th scope="row"><?php echo $i+1; ?></th>
            <td><?php echo $accepted_passes_all[$i]->display_date; ?></td>
            <td><?php echo $accepted_passes_all[$i]->user_card->card_number; ?></td>
            <td><?php echo $accepted_passes_all[$i]->taken_passes; ?></td>
            <td><?php echo $accepted_passes_all[$i]->company->name; ?></td>
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
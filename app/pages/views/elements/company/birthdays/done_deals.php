<div class="tab_box tab_box_done_deals" <?php if($selected_tab != 'done_deals'){ ?>style="display: none;"<?php } ?>>
    <div class="content">
      <div class="title">Zakazani rođendani</div>
      <?php if(sizeof($b_done_deals) > 0){ ?>
      <table class="table">
<thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Datum</th>
          <th scope="col">Vreme</th>
          <th scope="col">Kartica</th>
          <th scope="col" style="text-align: center;">Akcije</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($b_done_deals); $i++) { ?>
            <tr class="reservation_headers reservation_header_<?php echo $i; ?>">
              <td scope="row"><?php echo $i+1; ?></td>
              <td scope="row"><?php echo $b_done_deals[$i]->birthday_date; ?></td>
              <td scope="row"><?php echo $b_done_deals[$i]->birthday_time; ?></td>
              <td scope="row"><?php echo $b_done_deals[$i]->user_card->card_number; ?></td>
              <td scope="row">
               
                <?php if($b_done_deals[$i]->can_delete){ ?>
                <a href="javascript:void(0)" class="btn btn-sm pull-right" onclick="make_invalid(<?php echo $b_done_deals[$i]->id; ?>)">
                  Otkaži
                </a>
                <?php }else{ ?>
                <a href="javascript:void(0)" class="btn btn-sm pull-right disabled">
                  Otkaži
                </a>
                <?php } ?>
                
                 <a href="javascript:void(0)" class="btn btn-sm pull-right" onclick="view_reservation_row(<?php echo $i; ?>)">
                  Vidi detalje
                </a>
               
              </td>
            </tr>
            <tr class="reservation_rows reservation_row_<?php echo $i; ?>" style="display:none">
              <td colspan="7">
                <div class="row">
                    <div class="col col-sm-3">
                      <b>Korisnik:</b><br/>
                      <?php echo $b_done_deals[$i]->user_card->parent_first_name; ?> <?php echo $b_done_deals[$i]->user_card->parent_last_name; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Telefon:</b><br/>
                      <?php echo $b_done_deals[$i]->user_card->phone; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Email:</b><br/>
                      <?php echo $b_done_deals[$i]->user_card->email; ?>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col col-sm-3">
                      <b>Broj dece:</b><br/>
                      <?php echo $b_done_deals[$i]->number_of_kids; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Broj odraslih:</b><br/>
                      <?php echo $b_done_deals[$i]->number_of_adults; ?>
                    </div>
                    <div class="col col-sm-6">
                      <b>Dodatni komentar:</b><br/>
                      <?php echo $b_done_deals[$i]->comments; ?>
                    </div>
                </div>
              </td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
      <?php }else{ ?>
      <div class="hello">
          Trenutno nemate ni jedan zakazan rođendan
      </div>
      <?php } ?>
      
    </div>
</div>

<script type="text/javascript">
  function pre_approve_card(card_number){
    $('[name="card_number"]').val(card_number);
    toggle_tab('new_card');
  }

  function change_active_cards(){
    var aktivne_kartice = $('[name="aktivne_kartice"]').is(':checked');
    if(aktivne_kartice){
      $('.grey_card').hide();
    }else{
      $('.grey_card').show();
    }
  }
</script>
<div class="tab_box tab_box_all_cards" <?php if($selected_tab != 'all_cards'){ ?>style="display: none;"<?php } ?>>
    <div class="content">
      <div class="title">Sve kartice</div>
      <?php if(sizeof($company_cards) > 0){ ?>
      <div>
        <div>
          
          <div class="switch">
            <label>
              Sve
              <input name="aktivne_kartice" onchange="change_active_cards()" type="checkbox">
              <span class="lever"></span>
              Aktivne
            </label>
          </div>
        </div>
        <div class="row">
          <?php for ($i=0; $i < sizeof($company_cards); $i++) { ?>
            <div class="col s6 m4 l2 card_<?php echo $company_cards[$i]->card_number; ?> <?php if($company_cards[$i]->card_taken == 1){ ?>grey_card<?php } ?>">
              <div class="company_card_select">
                <a href="javascript:void(0)" <?php if($company_cards[$i]->card_taken == 0){ ?>onclick="pre_approve_card('<?php echo $company_cards[$i]->card_number; ?>')"<?php } ?>>
                  <?php echo $company_cards[$i]->card_number; ?>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php }else{ ?>
      <div class="hello">
          Trenutno nemate ni jednu karticu dostupnu za aktivaciju
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
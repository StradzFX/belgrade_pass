<div class="tab_box tab_box_cards_to_give" <?php if($selected_tab != 'cards_to_give'){ ?>style="display: none;"<?php } ?>>
    <div class="content">
      <div class="title">Kartice za izdavanje korisnicima</div>
      <?php if(sizeof($reserved_cards) > 0){ ?>
      <table>
        <tr>
          <td>Broj kartice</td>
          <td>Ime roditelja</td>
          <td>Ime deteta</td>
          <td>&nbsp;</td>
        </tr>
        <?php for ($i=0; $i < sizeof($reserved_cards); $i++) { ?> 
          <tr id="give_card_<?php echo $reserved_cards[$i]->id; ?>">
            <td>
              <?php echo $reserved_cards[$i]->card_number; ?>
            </td>
            <td><?php echo $reserved_cards[$i]->parent_name; ?></td>
            <td><?php echo $reserved_cards[$i]->child_name; ?></td>
            <td>
              <div class="switch">
                <label>
                  
                  <input name="give_card_<?php echo $reserved_cards[$i]->id; ?>" onchange="give_card('<?php echo $reserved_cards[$i]->id; ?>')" type="checkbox">
                  <span class="lever"></span>
                  Predaj karticu
                </label>
              </div>
            </td>
          </tr>
        <?php } ?>
      </table>
      <?php }else{ ?>
      <div class="hello">
          Trenutno nemate ni jednu karticu dostupnu za izdavanje
      </div>
      <?php } ?>
      
    </div>
</div>

<script type="text/javascript">
  function give_card(card_id){
    var card_data = {};
      card_data.card_id = card_id;

    start_global_call_loader(); 
      var call_url = "company_give_card";  
      var call_data = { 
          card_data:card_data 
      }  
      var callback = function(odgovor){  
          finish_global_call_loader(); 
          if(odgovor.success){  
              valid_selector = "success";
              setTimeout(function(){
                $('#give_card_'+card_id).remove();
              },200);
              
          }else{  
              valid_selector = "error";
          } 
        show_user_message(valid_selector,odgovor.message);
           
      }  
      ajax_json_call(call_url, call_data, callback); 
  }
</script>
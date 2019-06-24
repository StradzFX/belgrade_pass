<div class="tab_box tab_box_edit_cards" <?php if($selected_tab != 'edit_cards'){ ?>style="display: none;"<?php } ?>>
    <div>
      <div class="title">Dopunite podatke za kartice</div>
      <div class="list_all_cards_to_fill">
        <table>
          <tr>
            <td>Broj kartice</td>
            <td>Ime roditelja</td>
            <td>Ime deteta</td>
            <td>&nbsp;</td>
          </tr>
          <?php for ($i=0; $i < sizeof($cards_to_fill); $i++) { ?> 
            <tr id="fill_card_<?php echo $cards_to_fill[$i]->card_number; ?>">
              <td>
                <?php echo $cards_to_fill[$i]->card_number; ?>
              </td>
              <td>-</td>
              <td>-</td>
              <td>
                <a href="javascript:void(0)" onclick="get_card_edit_form('<?php echo $cards_to_fill[$i]->card_number; ?>')" title="Izmenite podatke za karticu">
                  <i class="fas fa-edit"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </table>

      </div>

      <div class="edit_card" style="display: none;">
        <div class="row">
          <div class="col col-sm-12">
            <div>
              Broj kartice
            </div>
            <div>
              <input type="text" disabled="disabled" name="edit_card_number_existing">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Ime roditelja
            </div>
            <div>
              <input type="text" name="edit_parent_first_name">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Prezime roditelja
            </div>
            <div>
              <input type="text" name="edit_parent_last_name">
            </div>
          </div>

          <div class="col col-sm-3">
            <div>
              Broj dece
            </div>
            <div>
              <input type="text" name="edit_number_of_kids">
            </div>
          </div>

          <div class="col col-sm-9">
            <div>
              Uzrast dece (datum rođenja)
            </div>
            <div>
              <input type="text" name="edit_child_birthdate">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Grad/Mesto
            </div>
            <div>
              <input type="text" name="edit_city">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Telefon
            </div>
            <div>
              <input type="text" name="edit_phone">
            </div>
          </div>

          <div class="col col-sm-12">
            <div>
              Email
            </div>
            <div>
              <input type="text" name="edit_email">
            </div>
          </div>
        </div>
        <div>
          <a href="javascript:void(0)" onclick="update_card_data()" class="btn">Sačuvajte podatke</a>
          <a href="javascript:void(0)" onclick="get_back_to_list()" class="btn">Nazad</a>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">

  function get_card_edit_form(card_number){
    $('[name="edit_card_number_existing"]').val(card_number);
    $('.list_all_cards_to_fill').fadeOut(300,function(){
      $('.edit_card').fadeIn(300);
    });
  }

  function get_back_to_list(){
    $('.edit_card').fadeOut(300,function(){
      $('.list_all_cards_to_fill').fadeIn(300);
    });
  }

  function update_card_data(){
    var card_data = {};
      card_data.card_number = $('[name="edit_card_number_existing"]').val();
      card_data.parent_first_name = $('[name="edit_parent_first_name"]').val();
      card_data.parent_last_name = $('[name="edit_parent_last_name"]').val();
      card_data.number_of_kids = $('[name="edit_number_of_kids"]').val();
      card_data.child_birthdate = $('[name="edit_child_birthdate"]').val();
      card_data.city = $('[name="edit_city"]').val();
      card_data.phone = $('[name="edit_phone"]').val();
      card_data.email = $('[name="edit_email"]').val();

    start_global_call_loader(); 
      var call_url = "company_save_card_data";  
      var call_data = { 
          card_data:card_data 
      }  
      var callback = function(odgovor){  
          finish_global_call_loader(); 
          if(odgovor.success){  
              valid_selector = "success";

              $('[name="edit_card_number_existing"]').val('');
              $('.edit_card').fadeOut(300,function(){
                $('#fill_card_'+card_data.card_number).remove();
                $('.list_all_cards_to_fill').fadeIn(300);
                
                $('[name="edit_card_number_existing"]').val('');
                $('[name="edit_parent_first_name"]').val('');
                $('[name="edit_parent_last_name"]').val('');
                $('[name="edit_number_of_kids"]').val('');
                $('[name="edit_child_birthdate"]').val('');
                $('[name="edit_city"]').val('');
                $('[name="edit_phone"]').val('');
                $('[name="edit_email"]').val('');
              });
          }else{  
              valid_selector = "error";
          }
          show_user_message(valid_selector,odgovor.message); 
           
      }  
      ajax_json_call(call_url, call_data, callback); 
  }

  function get_card_to_fill_list(){
    var card_data = 'card_data';

      var call_url = "company_get_card_to_fill_list";  
      var call_data = { 
          card_data:card_data 
      }  
      var callback = function(odgovor){ 
        $('.list_all_cards_to_fill').html(odgovor); 
      }  
      ajax_call(call_url, call_data, callback); 
  }

  $(function(){
    get_card_to_fill_list();
  });
</script>
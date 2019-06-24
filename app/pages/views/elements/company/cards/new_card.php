<div class="tab_box tab_box_new_card" <?php if($selected_tab != 'new_card'){ ?>style="display: none;"<?php } ?>>
    <div class="content">
      <div class="title">Aktivirajte karticu</div>
      <?php if(sizeof($company_cards) > 0){ ?>
      <div class="approve_card">
        <div>
          <div>
            Broj kartice
          </div>
          <div>
            <input type="text" name="card_number">
          </div>
        </div>

        <div>
          <a href="javascript:void(0)" onclick="company_approve_card()" class="btn">Aktivirajte karticu</a>
        </div>
      </div>
      <div class="approve_card_step_2" style="display: none;">
        <div class="alert alert-success" role="alert">
          Kartica je aktivirana
        </div>
        <div>
          <a href="javascript:void(0)" onclick="fill_card_data_form()" class="btn">Popunite podatke o kartici</a>
          <a href="javascript:void(0)" onclick="new_card_to_activate()" class="btn">Aktivirajte novu karticu</a>
        </div>
      </div>

      <div class="approve_card_step_3" style="display: none;">
        <div class="row">
          <div class="col col-sm-12">
            <div>
              Broj kartice
            </div>
            <div>
              <input type="text" disabled="disabled" name="card_number_existing">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Ime roditelja
            </div>
            <div>
              <input type="text" name="parent_first_name">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Prezime roditelja
            </div>
            <div>
              <input type="text" name="parent_last_name">
            </div>
          </div>

          <div class="col col-sm-3">
            <div>
              Broj dece
            </div>
            <div>
              <input type="text" name="number_of_kids">
            </div>
          </div>

          <div class="col col-sm-9">
            <div>
              Uzrast dece (datum rođenja)
            </div>
            <div>
              <input type="text" name="child_birthdate">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Grad/Mesto
            </div>
            <div>
              <input type="text" name="city">
            </div>
          </div>

          <div class="col col-sm-6">
            <div>
              Telefon
            </div>
            <div>
              <input type="text" name="phone">
            </div>
          </div>

          <div class="col col-sm-12">
            <div>
              Email
            </div>
            <div>
              <input type="text" name="email">
            </div>
          </div>
        </div>
        <div>
          <a href="javascript:void(0)" onclick="save_card_data()" class="btn">Sačuvajte podatke</a>
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
  function company_approve_card(){
    var card_data = {};
      card_data.card_number = $('[name="card_number"]').val();

    start_global_call_loader(); 
      var call_url = "company_approve_card";  
      var call_data = { 
          card_data:card_data 
      }  
      var callback = function(odgovor){  
          finish_global_call_loader(); 
          get_card_to_fill_list();
          if(odgovor.success){  
              valid_selector = "success";
              $('[name="card_number_existing"]').val(odgovor.card.card_number);
              $('.approve_card').fadeOut(300,function(){
                $('.approve_card_step_2').fadeIn(300);
              });
              
          }else{  
              valid_selector = "error";
              show_user_message(valid_selector,odgovor.message);
          }  
           
      }  
      ajax_json_call(call_url, call_data, callback); 
  }

  function save_card_data(){
    var card_data = {};
      card_data.card_number = $('[name="card_number_existing"]').val();
      card_data.parent_first_name = $('[name="parent_first_name"]').val();
      card_data.parent_last_name = $('[name="parent_last_name"]').val();
      card_data.number_of_kids = $('[name="number_of_kids"]').val();
      card_data.child_birthdate = $('[name="child_birthdate"]').val();
      card_data.city = $('[name="city"]').val();
      card_data.phone = $('[name="phone"]').val();
      card_data.email = $('[name="email"]').val();

    start_global_call_loader(); 
      var call_url = "company_save_card_data";  
      var call_data = { 
          card_data:card_data 
      }  
      var callback = function(odgovor){  
          finish_global_call_loader(); 
          if(odgovor.success){  
              valid_selector = "success";

              $('.card_'+card_data.card_number).addClass('grey_card');
              change_active_cards();
              get_card_to_fill_list();

              $('[name="card_number"]').val('');
              $('.approve_card_step_3').fadeOut(300,function(){
                $('.approve_card').fadeIn(300,function(){
                  $('[name="card_number"]').focus();

                  $('[name="card_number_existing"]').val('');
                  $('[name="parent_first_name"]').val('');
                  $('[name="parent_last_name"]').val('');
                  $('[name="number_of_kids"]').val('');
                  $('[name="child_birthdate"]').val('');
                  $('[name="city"]').val('');
                  $('[name="phone"]').val('');
                  $('[name="email"]').val('');
                });
              });
          }else{  
              valid_selector = "error";
          }
          show_user_message(valid_selector,odgovor.message); 
           
      }  
      ajax_json_call(call_url, call_data, callback); 
  }

  

  function new_card_to_activate(){
    $('[name="card_number"]').val('');

    $('.approve_card_step_2').fadeOut(300,function(){
      $('.approve_card').fadeIn(300,function(){
        $('[name="card_number"]').focus();
      });
    });
  }

  function fill_card_data_form(){
    $('[name="card_number"]').val('');

    $('.approve_card_step_2').fadeOut(300,function(){
      $('.approve_card_step_3').fadeIn(300,function(){
      });
    });
  }

  $('[name="card_number"]').on('keyup', function (e) {
      if (e.keyCode == 13) {
          company_approve_card();
      }
  });
</script>
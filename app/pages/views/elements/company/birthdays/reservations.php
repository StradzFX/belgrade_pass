<div class="tab_box tab_box_reservations" <?php if($selected_tab != 'reservations'){ ?>style="display: none;"<?php } ?>>
    <div class="content">
      <div class="title">Rezervacije</div>
      <?php if(sizeof($b_reservations) > 0){ ?>
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
        <?php for ($i=0; $i < sizeof($b_reservations); $i++) { ?>
            <tr class="reservation_headers reservation_header_<?php echo $i; ?>">
              <td scope="row"><?php echo $i+1; ?></td>
              <td scope="row"><?php echo $b_reservations[$i]->birthday_date; ?></td>
              <td scope="row"><?php echo $b_reservations[$i]->birthday_time; ?></td>
              <td scope="row"><?php echo $b_reservations[$i]->user_card->card_number; ?></td>
              <td scope="row">
               
                <a href="javascript:void(0)" class="btn btn-sm pull-right" onclick="make_invalid(<?php echo $b_reservations[$i]->id; ?>)">
                  Otkaži
                </a>
                 <a href="javascript:void(0)" class="btn btn-sm pull-right" onclick="make_valid(<?php echo $b_reservations[$i]->id; ?>)">
                  Kapariši
                </a>
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
                      <?php echo $b_reservations[$i]->user_card->parent_first_name; ?> <?php echo $b_reservations[$i]->user_card->parent_last_name; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Telefon:</b><br/>
                      <?php echo $b_reservations[$i]->user_card->phone; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Email:</b><br/>
                      <?php echo $b_reservations[$i]->user_card->email; ?>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col col-sm-3">
                      <b>Broj dece:</b><br/>
                      <?php echo $b_reservations[$i]->number_of_kids; ?>
                    </div>
                    <div class="col col-sm-3">
                      <b>Broj odraslih:</b><br/>
                      <?php echo $b_reservations[$i]->number_of_adults; ?>
                    </div>
                    <div class="col col-sm-6">
                      <b>Dodatni komentar:</b><br/>
                      <?php echo $b_reservations[$i]->comments; ?>
                    </div>
                </div>
              </td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
      <?php }else{ ?>
      <div class="hello">
          Trenutno nemate ni jednu rezervaciju
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


  function view_reservation_row(index){
    $('.reservation_rows').hide();
    $('.reservation_row_'+index).show();
    $('.reservation_headers').addClass('focus_out');
    $('.reservation_header_'+index).removeClass('focus_out');
  }


  function make_valid(id){
    var result = confirm('Da li želite da označite rezervaciju kao validnu i ubacite rođendan u sekciju termina?');
    if(result){
      var data = {};
          data.id = id;

          start_global_call_loader(); 
          var call_url = "company_approve_birthday_reservation";  
          var call_data = { 
              data:data 
          }  
          var callback = function(odgovor){  
              finish_global_call_loader(); 
              if(odgovor.success){  
                  valid_selector = "success";
                  document.location = master_data.base_url+'company_birthdays';
              }else{  
                  valid_selector = "error";
                  show_user_message(valid_selector,odgovor.message) 
              }  
               
          }  
          ajax_json_call(call_url, call_data, callback); 
    }
  }

  function make_invalid(id){
    var result = confirm('Da li želite da oktažete rezervaciju?');
    if(result){
        var data = {};
          data.id = id;

          start_global_call_loader(); 
          var call_url = "company_reject_birthday_reservation";  
          var call_data = { 
              data:data 
          }  
          var callback = function(odgovor){  
              finish_global_call_loader(); 
              if(odgovor.success){  
                  valid_selector = "success";
                  document.location = master_data.base_url+'company_birthdays';
              }else{  
                  valid_selector = "error";
                  show_user_message(valid_selector,odgovor.message) 
              }  
               
          }  
          ajax_json_call(call_url, call_data, callback); 
    }
  }
</script>

<style type="text/css">
  .focus_out{
    color: #9e9e9e;
  }
</style>
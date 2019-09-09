<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Unesite email, a mi ćemo Vam poslati u Inbox link za promenu lozinke</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="text" name="forgot_email" class="form-control" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="forgot_password()">Pošalji zahtev</button>
      </div>
    </div>
  </div>
</div>

<div class="page_content">
  <div class="login">
    <div class="container">
      <div class="row">
          <div class="col-12 col-sm-12 col-md-6">
              <div class="forms">
                  <div class="title">
                    Logovanje <i class="fa fa-lock"></i>
                  </div>
                  <div class="content">
                    <div class="login_option">
                      <div class="title"><i class="fa fa-envelope"></i> Putem email adrese</div>
                      <div class="content">
                          <div class="form_field">
                            <div class="field_title">Email:</div>
                            <div class="field_component">
                              <input name="email_login" id="email_login" type="text" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="field_title">Lozinka:</div>
                            <div class="field_component">
                               <input name="lozinka_login" id="lozinka_login" type="password" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="button" onclick="website_login()">Uloguj se</div>
                          </div>

                          <div class="form_field">
                            <a href="resetuj_lozinku/" class="forgot_password">
                              Zaboravili ste lozinku?
                            </a>
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
              <div class="forms">
                  <div class="title">
                    Registracija <i class="fa fa-edit"></i>
                  </div>
                  <div class="content">

                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="tab_option fizicko active"  ><a href="javascript:void(0)" onclick="toggle_tab('fizicko')" data-toggle="tab">Fizičko lice</a></li>
                        <li class="tab_option pravno"><a href="javascript:void(0)" onclick="toggle_tab('pravno')" data-toggle="tab">Pravno lice</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active tab_box tab_box_fizicko" id="fizicko">
                          <div class="row">
                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">Ime:</div>
                                  <div class="field_component">
                                    <input name="ime" id="ime" type="text" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">Prezime:</div>
                                  <div class="field_component">
                                    <input name="prezime" id="prezime" type="text" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                <div class="form_field">
                                  <div class="field_title">Email:</div>
                                  <div class="field_component">
                                    <input name="email" id="email" type="text" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                  <div class="form_field">
                                    <div class="field_title">Lozinka:</div>
                                    <div class="field_component">
                                       <input name="lozinka" id="lozinka" type="password" />
                                    </div>
                                  </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                  <div class="form_field">
                                    <div class="field_title">Ponovi lozinku:</div>
                                    <div class="field_component">
                                       <input name="potvrdi_lozinku" id="potvrdi_lozinku" type="password" />
                                    </div>
                                  </div>
                              </div>

                              <div class="col-12 col-sm-12">
                                  <div class="form_field">
                                    <div class="field_title">Odaberite koliko kredita želite da uplatite:<br/><br/></div>
                                    <div class="field_component">
                                       <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="500" data-slider-max="10000" data-slider-step="500" data-slider-value="2500"/>
                                       <span id="ex6CurrentSliderValLabel">Uplata: <span id="ex1SliderVal">2500</span> RSD</span>
                                    </div>
                                  </div>
                              </div>
                          </div>
                            

                            

                            

                            

                            
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane tab_box tab_box_pravno" id="pravno">
                          <div class="row">
                              <div class="col-12 col-sm-12">
                                <div class="form_field">
                                  <div class="field_title">Naziv preduzeca:</div>
                                  <div class="field_component">
                                    <input name="naziv" id="naziv" type="text" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-12">
                                <div class="form_field">
                                  <div class="field_title">Adresa:</div>
                                  <div class="field_component">
                                    <input name="adresa" id="adresa" type="text" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">PIB:</div>
                                  <div class="field_component">
                                    <input name="pib" id="pib" type="text" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">Matični:</div>
                                  <div class="field_component">
                                    <input name="maticni" id="maticni" type="text" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-12">
                                <div class="form_field">
                                  <div class="field_title">Email:</div>
                                  <div class="field_component">
                                    <input name="email" id="email_pravno" type="text" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">Lozinka:</div>
                                  <div class="field_component">
                                    <input name="lozinka" id="lozinka_pravno" type="password" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 col-sm-6">
                                <div class="form_field">
                                  <div class="field_title">Ponovi lozinku:</div>
                                  <div class="field_component">
                                    <input name="potvrdi_lozinku" id="potvrdi_lozinku_pravno" type="password" />
                                  </div>
                                </div>
                              </div>

                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>


                   

                    <div class="form_field">
                      <div class="button" onclick="website_registration()">Registruj se</div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-12 col-sm-12 col-md-12">
              <div class="forms">
                  <div class="title">
                    Partneri <i class="fas fa-building"></i>
                  </div>
                  <div class="content login_partner">
                    Za logovanje partnera smo obezbedili poseban panel za logovanje. Molimo Vas da pređete na <a href="company_panel/">panel za logovanje partnera</a>. 
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>


<input type="hidden" value="<?php echo $_SESSION["offer_id"]; ?>" id="kupovina_id" />
<input type="hidden" value="<?php echo $redirect_buy_id; ?>" name="redirect_buy_id" />
<input type="hidden" value="<?php echo $poklon; ?>" id="pokloni" />


<script>

//============================================ AJAX ZA LOGOVANJE ==========================================================
  function ajax_logovanje(){

    var log_in_data = {};
        log_in_data.email = $("#email_login").val();
        log_in_data.lozinka = $("#lozinka_login").val();
        log_in_data.kupovina_id = $("#kupovina_id").val();
        log_in_data.pokloni = $("#poklon").val();
        log_in_data.zapamti_me = $("#one").is(':checked');

    var call_url = "php/ajax/ajax_logovanje.php";  

    var call_data = { 
        log_in_data:log_in_data 
    }  

    var callback = function(response){  
      if(response.success){
        var redirect_buy_id = $('[name="redirect_buy_id"]').val();
        if(redirect_buy_id != ''){
          var redirect_link = master_data.base_url+'kupovina/'+redirect_buy_id+'/';
          document.location = redirect_link;
        }else{
          var redirect_link = master_data.base_url+'moj_nalog/';
          document.location = redirect_link;
        }
      }else{
        var valid_selector = "error";  
        if(response.error_code == 'email_not_found'){
          var message = "Email ne postoji u bazi podataka";
        }

        if(response.error_code == 'email_not_verified'){
          var message = "Email nije verifikovan";
        }

        if(response.error_code == 'password_not_valid'){
          var message = "Lozinka ne odgovara emailu koji ste uneli";
        }

        show_user_message(valid_selector,message);
      }

    }  

    ajax_json_call(call_url, call_data, callback);  

  }

  function registracija(){

    var user_data = {};
        user_data.ime = $('[name="ime"]').val();
        user_data.prezime = $('[name="prezime"]').val();
        user_data.email = $('[name="email"]').val();
        user_data.lozinka = $('[name="lozinka"]').val();
        user_data.potvrdi_lozinku = $('[name="potvrdi_lozinku"]').val();

    var call_url = "php/ajax/ajax_registracija.php";  

    var call_data = { 
        data:user_data 
    }  

    var callback = function(response){  
      if(response.success){
        var redirect_buy_id = $('[name="redirect_buy_id"]').val();
        if(redirect_buy_id != ''){
          var redirect_link = master_data.base_url+'uspesna_registracija/'+redirect_buy_id+'/';
          document.location = redirect_link;
        }else{
          var redirect_link = master_data.base_url+'uspesna_registracija/';
        document.location = redirect_link;
        }
        
      }else{
        var valid_selector = 'error';
        show_user_message(valid_selector,response.message);
      }

    }  
    ajax_json_call(call_url, call_data, callback);  
  }

  function forgot_password(){
    var data = {};
        data.forgot_email = $('[name="forgot_email"]').val();

    var call_url = "php/ajax/forgot_password.php";  

    var call_data = { 
        data:data 
    }  

    var callback = function(response){  
      if(response.success){
        var valid_selector = 'success';
        $('#exampleModal').modal('toggle');
      }else{
        var valid_selector = 'error';
      }
      show_user_message(valid_selector,response.message);

    }  
    ajax_json_call(call_url, call_data, callback);  
  }

  $(function(){
  });
</script>

<script type="text/javascript">
  var user_type = 'fizicko';
  var selected_amount = 2500;
  function toggle_tab(option){
        $('.tab_option').removeClass('active');
        $('.'+option).addClass('active');
        $('.tab_box').hide();
        $('.tab_box_'+option).show();
        user_type = option;
    }
</script>

<link rel='stylesheet'  href='public/js/bootstrap-slider-master/css/bootstrap-slider.css' type='text/css' media='all' />
<script type='text/javascript' src='public/js/bootstrap-slider-master/bootstrap-slider.js'></script>
<script>
   // With JQuery
$(function(){
  $('#ex1').bootstrapSlider({
    formatter: function(value) {
      return value + ' RSD';
    }
  });

  $("#ex1").on("slide", function(slideEvt) {
    $("#ex1SliderVal").text(slideEvt.value);
    selected_amount = slideEvt.value;
  });
});

</script>
<div class="page_content">
  <div class="login">
    <div class="container">
      <div class="row">
          <div class="col-12 col-sm-12 col-md-12">
            <div class="header">
              Zamenite lozinku na svom profilu na <span>KIDCARD</span>u <br/><br/>
              Unesite novu lozinku i potvrdite istu u označena polja.
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-md-offset-3">
              <div class="forms">
                  <div class="title">
                    Resetovanje lozinke <i class="fa fa-lock"></i>
                  </div>
                  <div class="content">
                    <div class="login_option">
                      <div class="title"><i class="fa fa-envelope"></i> Unesite novu lozinku</div>
                      <div class="content">
                          <div class="form_field">
                            <div class="field_title">Nova lozinka:</div>
                            <div class="field_component">
                              <input type="password" name="new_password" class="form-control" id="new_password" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="field_title">Ponovite lozinku:</div>
                            <div class="field_component">
                              <input type="password" name="new_password_again" class="form-control" id="new_password_again" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="button" onclick="change_password()">Zamenite lozinku</div>
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>

      </div>
    </div>
  </div>
</div>



<script>

  function change_password(){
    var data = {};
        data.new_password = $('[name="new_password"]').val();
        data.new_password_again = $('[name="new_password_again"]').val();
        data.user_id = '<?php echo $user_id; ?>';

    var call_url = "change_password";  

    var call_data = { 
        data:data 
    }  

    var callback = function(response){  
      if(response.success){
        var valid_selector = 'success';
        setTimeout(
          function(){
            var redirect_link = master_data.base_url+'profile/';
            document.location = redirect_link;
          },1500
        );
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
<div class="page_content">
  <div class="login">
    <div class="container">
      <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-md-offset-3">
              <div class="forms">
                  <div class="title">
                    Resetovanje lozinke <i class="fa fa-lock"></i>
                  </div>
                  <div class="content">
                    <div class="login_option">
                      <div class="title"><i class="fa fa-envelope"></i> Unesite email adresu</div>
                      <div class="content">
                          <div class="form_field">
                            <div class="field_title">Email:</div>
                            <div class="field_component">
                              <input name="forgot_email" class="form-control" id="recipient-name" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="button" onclick="forgot_password()">Pošaljite zahtev</div>
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

  function forgot_password(){
    var data = {};
        data.email = $('[name="forgot_email"]').val();

    var call_url = "forgot_password";  

    var call_data = { 
        data:data 
    }  

    var callback = function(response){  
      if(response.success){
        var valid_selector = 'success';
        $('[name="forgot_email"]').val('');
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
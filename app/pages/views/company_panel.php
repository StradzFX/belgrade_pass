<div class="page_content">
  <div class="login">
    <div class="container">
      <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-offset-3">
              <div class="forms">
                  <div class="title">
                    Logovanje za partnere <i class="fa fa-lock"></i>
                  </div>
                  <div class="content">
                    <div class="login_option">
                      <div class="content">
                          <div class="form_field">
                            <div class="field_title">Username:</div>
                            <div class="field_component">
                              <input name="email_login" value="<?php echo $kompanija; ?>" id="email_login" type="text" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="field_title">Lozinka:</div>
                            <div class="field_component">
                               <input name="lozinka_login" id="lozinka_login" type="password" />
                            </div>
                          </div>

                          <div class="form_field">
                            <div class="button" onclick="company_login()">Ulogujte se</div>
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


<input type="hidden" value="<?php echo $_SESSION["offer_id"]; ?>" id="kupovina_id" />
<input type="hidden" value="<?php echo $redirect_buy_id; ?>" name="redirect_buy_id" />
<input type="hidden" value="<?php echo $poklon; ?>" id="pokloni" />


<script>

function company_login(){ 

	var user_data = {};
		user_data.username = $('[name="email_login"]').val();
		user_data.password = $('[name="lozinka_login"]').val();

    start_global_call_loader(); 
    var call_url = "company_login";  
    var call_data = { 
        user_data:user_data 
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){  
            valid_selector = "success";
            setTimeout(function(){
              var url_addon = '<?php echo $url_addon; ?>';
              if(url_addon == ''){
                window.location = master_data.base_url+'company_home';
              }else{
                window.location = master_data.base_url+'company_approval/'+url_addon;
              }
            },1500); 
        }else{  
            valid_selector = "error";  
        }  
        show_user_message(valid_selector,odgovor.message)  
    }  
    ajax_json_call(call_url, call_data, callback);      
} 
</script>
<div class="login-box">
  <div class="login-logo">
    <b>Kr</b>ypton
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Log in to start your session</p>

    <form>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="button" class="btn btn-primary btn-block btn-flat" onclick="login()">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</div>
<!-- /.login-box -->

<script type="text/javascript">
  function login(){
    var login_data = {};
        login_data.username = $('[name="username"]').val();
        login_data.password = $('[name="password"]').val();

        var call_url = "login_user";  
        var call_data = { 
            login_data:login_data 
        }  
        var callback = function(odgovor){  
            if(odgovor.success){  
                valid_selector = "success"; 
                document.location = master_data.base_url;
            }else{  
                valid_selector = "error";
                alert(odgovor.message);
            }  
            
        }  
        ajax_json_call(call_url, call_data, callback);  
  }

  $('[name="username"]').keypress(function(e) {
      if(e.which == 13) {
          login();
      }
  });

  $('[name="password"]').keypress(function(e) {
      if(e.which == 13) {
          login();
      }
  });
</script>



  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 3.0
    </div>
    <strong>Copyright &copy; 2014-2016 All rights
    reserved.</strong>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<style type="text/css">
  .no-results{
    text-align: center;
    font-size: 25px;
    color: #ccc;
    margin-bottom: 20px;
  }
</style>


<!-- Bootstrap 3.3.7 -->
<script src="../public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../public/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../public/admin/dist/js/adminlte.min.js"></script>

<!-- bootstrap datepicker -->
<script src="../public/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../public/admin/dist/js/demo.js"></script>

<script src="../public/js/ajax_call.js"></script>

<script type="text/javascript">
  function logout(){
      var call_url = "logout_user";  
        var call_data = { 
            logout_user:'logout_user' 
        }  
        var callback = function(odgovor){  
            if(odgovor.success){  
                valid_selector = "success"; 
                document.location = master_data.base_url+'login/';
            }else{  
                valid_selector = "error";
                alert(odgovor.message);
            }  
            
        }  
        ajax_json_call(call_url, call_data, callback);  
  }
</script>
</body>
</html>

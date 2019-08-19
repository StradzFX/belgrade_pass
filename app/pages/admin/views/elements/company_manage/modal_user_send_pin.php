<div class="modal fade" id="modal_user_send_pin" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Pošalji pin</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>Upišite željenu e-mail adresu</label>
            <input type="text" name="text" class="form-control" id="text">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-primary" onclick="send_user_email_pin()">Pošalji pin</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    
     function send_user_email_pin(){
      var data={};
          data.id = $('[name="id"]').val();
          data.text =$('[name="text"]').val();

      var call_url = "send_user_email_pin";

      var call_data = {data:data}

      var callback = function(response){
        if(response.success){
          alert(response.message);
          $('#modal_user_send_pin').modal('hide');
        }
        else{
          alert(response.message);

        }
      }

      ajax_json_call(call_url, call_data, callback);
    }

  </script>
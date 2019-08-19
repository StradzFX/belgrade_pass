<div class="modal fade" id="modal_user_add_card_credit" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Uplata na karticu</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="id" value="0">
          <div class="col-12 col-xs-12">
            <label>
              Odredite visinu uplate
            </label>
            <select class="form-control" name="card_deposit">
              <option value=""></option>
              <option value="100">100</option>
              <option value="200">200</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="save_card_deposit()">Izvrši uplatu</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
  function save_card_deposit(){
    var data={};
        data.id=$('[name="id"]').val();
        data.card_deposit_save=$('[name="card_deposit"]').val();

        var call_url="save_card_deposit"
        var call_data={data:data};
        var callback=function(response){
          if(response.success){
            alert(response.message);
            $('#modal_user_add_card_credit').modal('hide');
          }else{alert(response.message)};
        }
        ajax_json_call(call_url, call_data, callback);
  }
</script>
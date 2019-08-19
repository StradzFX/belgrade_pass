<div class="modal fade" id="modal_repeat_transaction" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Ponavaljanje transakcije</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <input type="hidden" name="id" value="0">
            <label>
              Da li ste sigurni da želite da ponovite uplatu?
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <a href="javascript:void(0)" class="btn btn-primary pull-right" onclick="repeat_transaction()">Ponovi uplatu <i class="fas fa-redo-alt"></i></a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function repeat_transaction(){
  
    var data={};
        data.id = $('[name="id"]').val();
    var call_url = "repeat_transaction";
    var call_data = {data:data}
    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          $('#modal_repeat_transaction').modal('hide');
      }
    }
    ajax_json_call(call_url, call_data, call_back);
}

</script>
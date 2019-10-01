<div class="modal fade" id="modal_recall_post_office_transaction" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <input type="hidden" name="recall_id" value="0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Brisanje Korisnika</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>
              Da li ste sigurni da želite da poništite odobrenje?
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="recall_post_office_transaction()">Poništi</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function recall_post_office_transaction(){
  
    var data={};
        data.id = $('[name="recall_id"]').val();
        data.transaction_value = $('[name="recall_id"]').val();

    var call_url = "recall_post_office_transaction";

    var call_data = {
        data:data
    }

    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          document.location = master_data.base_url+'post_office/';
          $('#modal_recall_post_office_transaction').modal('hide');
      }
    }
    ajax_json_call(call_url, call_data, call_back);
}

</script>
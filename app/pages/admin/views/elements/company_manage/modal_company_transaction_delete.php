<div class="modal fade" id="modal_company_transaction_delete">
  <input type="hidden" name="transaction_id" value="0">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Brisanje uplate</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>
              Da li ste sigurni da želite da obrišete uplatu?
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="company_payment_delete()">Obriši uplatu</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function set_transaction_id(id){
    $('[name="transaction_id"]').val(id);
  }

  function company_payment_delete(){
  
    var data={};
        data.id = $('[name="transaction_id"]').val();


    var call_url = "company_payment_delete";

    var call_data = {
        data:data
    }



    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          $('#modal_company_transaction_delete').modal('hide');
          get_list_of_transactions_with_companies();
      }
    }
    ajax_json_call(call_url, call_data, call_back);
}

</script>
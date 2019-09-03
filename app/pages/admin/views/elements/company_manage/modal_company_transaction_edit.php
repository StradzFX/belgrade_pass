<div class="modal fade" id="modal_company_transaction_edit" style="display: none;">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Transaction</h4>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="row">
            <div class="col-12 col-md-12">
              <form role="form">
                <div class="edit_input_fields_holder">
                  
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad
          </button>
          <button type="button" class="btn btn-primary" onclick="save_company_transaction_edit()">
            Promeni
          </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

function get_edit_input_fields(transaction_id){

  var data = {};
      data.id = transaction_id;

      var call_url = 'get_edit_input_fields';
      var call_data = {data:data}
      var call_back = function(response){
        $('.edit_input_fields_holder').html(response);
      }
      ajax_call(call_url, call_data, call_back);
}


function save_company_transaction_edit() {
  // funkcija koja uzima podatke iz input polja modala
  //modal_company_transactions_edit

  var data = {};
      data.edit_transaction_id = $('[name = "edit_transaction_id"]').val();
      data.edit_transaction_type = $('[name = "edit_transaction_type"]').val();
      data.edit_transaction_value = $('[name = "edit_transaction_value"]').val();
      data.edit_transaction_date = $('[name = "edit_transaction_date"]').val();

  var call_url = 'save_company_transaction_edit';
  var call_data = {data:data};
  var call_back = function(response){
    if(response.success){
      alert(response.message);
      get_list_of_transactions_with_companies();
      $('#modal_company_transaction_edit').modal('hide');
    } else{
      alert(response.message);
    }
  }

  ajax_json_call(call_url, call_data, call_back);
}
    


</script>
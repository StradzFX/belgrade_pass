<div class="modal fade" id="modal_delete_all_company_transactions" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Brisanje svih kompanijskih transakcija</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>
              Da li ste sigurni da želite da obrišete sve transakcije?
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="delete_all_company_transactions()">Obriši sve transakcije</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function delete_all_company_transactions(){
  
    var data={};
        data.id = $('[name="id"]').val();


    var call_url = 'delete_all_company_transactions';

    var call_data = {data:data};
    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          get_list_of_transactions_with_companies();
          get_list_of_company_cards_payments()
          $('#modal_delete_all_company_transactions').modal('hide');
      }
    }
    ajax_json_call(call_url, call_data, call_back);

}

</script>
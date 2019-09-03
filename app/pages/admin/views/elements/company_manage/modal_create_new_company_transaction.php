<div class="modal fade" id="modal_create_new_company_transaction" style="display: none;">
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
                <div class="form-group">
                  <label for="field_name">Transaction Type</label>
                  <select class="form-control" name="transaction_type">
                    <option value="">Select Type</option>
                    <option value="debit" <?php if('debit' == $item->transaction_type){ ?>selected="selected"<?php } ?>>Payment from company</option>
                    <option value="credit" <?php if('credit' == $item->transaction_type){ ?>selected="selected"<?php } ?>>Payment to company</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="field_name">Value</label>
                  <input type="text" class="form-control" name="transaction_value" id="transaction_value" placeholder="Enter value (e.g. 1000)" value="<?php echo $item->transaction_value; ?>">
                </div>
                <div class="form-group">
                  <label for="field_name">Transaction Date</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" value="<?php echo $item->transaction_date; ?>" name="transaction_date" class="form-control pull-right" id="datepicker">
                  </div>
                  <!-- /.input group -->
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-primary" onclick="commit_company_transaction()">Izvrši transakciju</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function commit_company_transaction(){
    var data={};
        data.id = $('[name="id"]').val();
        data.transaction_type = $('[name="transaction_type"]').val();
        data.transaction_value = $('[name="transaction_value"]').val();
        data.transaction_date = $('[name="transaction_date"]').val();


    var call_url = "commit_company_transaction";
    var call_data = {data:data}

    var callback = function(response){
      if(response.success){
          alert(response.message);
          $('#modal_create_new_company_transaction').modal('hide');
          get_list_of_transactions_with_companies();

          $('[name="transaction_type"]').val('');
          $('[name="transaction_value"]').val('');
          $('[name="transaction_date"]').val('');
      } else {
          alert(response.message);
        }
    }
    ajax_json_call(call_url, call_data, callback);
}

  function card_change_save(){
    var data={};
        data.id = $('[name="user_id"]').val();
        data.card_number = $('[name="new_card_number"]').val();


    var call_url = "card_change_save";
    var call_data = {data:data}

    var callback = function(response){
      if(response.success){
          alert(response.message);
          $('#modal-change-card').modal('hide');
          location.reload();
      } else {
          alert(response.message);
        }
    }
    ajax_json_call(call_url, call_data, callback);
}

</script>
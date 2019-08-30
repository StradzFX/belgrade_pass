<div class="modal fade" id="modal_company_transaction_edit" style="display: none;">
  <input type="hidden" name="id" value="<?php echo $item->id; ?>">
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
                <div class="box-body">
                  <div class="form-group">
                    <label for="field_name">Company</label>
                    <select class="form-control" name="training_school">
                      <option value="">Select Company</option>
                      <?php for($i=0;$i<sizeof($training_school_all);$i++){ ?>
                        <option value="<?php echo $training_school_all[$i]->id; ?>" <?php if($training_school_all[$i]->id == $item->training_school){ ?>selected="selected"<?php } ?>><?php echo $training_school_all[$i]->name; ?></option>
                      <?php } ?>
                      
                    </select>
                  </div>

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
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">    Nazad
          </button>
          <button type="button" class="btn btn-primary" onclick="save_record()">
            Promeni
          </button>
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
          $('#modal-change-card').modal('hide');
          location.reload();
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

function save_record(){
      var save_data = {};
          save_data.section = 'company_transaction';
          save_data.id = $('[name="id"]').val();
          save_data.training_school = $('[name="training_school"]').val();
          save_data.transaction_type = $('[name="transaction_type"]').val();
          save_data.transaction_value = $('[name="transaction_value"]').val();
          save_data.transaction_date = $('[name="transaction_date"]').val();
          console.log(save_data);

      var call_url = "save_item";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'company_transactions/';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

</script>
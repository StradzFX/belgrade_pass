<div class="modal fade" id="modal_approve_post_office_payment" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Approve post office transaction</h4>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="row">
            <div class="col-12 col-md-12">
              <form role="form">
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-12 col-xs-6">
                      <input type="hidden" name="approve_id" value="0">
                      <label for="approve_name">Name</label>
                      <input type="text" class="form-control" name="approve_name" id="approve_name" placeholder="Enter name">
                      </div>
                      <div class="col-12 col-xs-6">
                        <label for="field_name">Transaction Date</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" value="<?php echo $item->transaction_date; ?>" name="approve_date" class="form-control pull-right" id="datepicker">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel
          </button>
          <button type="button" class="btn btn-primary" onclick="approve_post_office()">
            Approve
          </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function approve_post_office(){
      var data = {};
          data.id = $('[name="approve_id"]').val();
          data.approve_name = $('[name = "approve_name"]').val();
          data.approve_date = $('[name = "approve_date"]').val();

      var call_url = "approve_post_office";  
      var call_data = { data:data }  
      var callback = function(response){  
        if(response.success){  
          
            alert(response.message) 
            location.reload();
        }else{  
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }    
</script>

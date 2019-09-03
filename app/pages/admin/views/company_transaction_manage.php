<div class="content-wrapper" style="min-height: 989.8px;">
    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
    <!-- Content Header (Page header) -->

    

    <section class="content-header">
      <?php if($system_message != ''){ ?>
      <div class="row">
          <!-- left column -->
          <div class="col-sm-12">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-info"></i> Info</h4>
              <?php echo $system_message; ?>
            </div>
          </div>
        </div>
      <?php } ?>
      <h1>
        <i class="fa fa-list"></i> <?php echo $item->id == 0 ? 'New' : 'Edit'; ?> Company transaction
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-sm-12 col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
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
                    <input type="text" value="<?php echo $item->transaction_date; ?>" name="transaction_date" class="form-control pull-right" id="datepicker">
                  </div>
                  <!-- /.input group -->
                </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="save_record()">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>

<style type="text/css">
  .image_preview_logo{
    background-color: #999;
    width: 64px;
  }
</style>

<script>
    $(function(){
      //Date picker
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd.mm.yyyy',
      })
    });

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



    var new_logo = '';
    function readURL_home(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              new_logo = e.target.result;
              $('.image_preview_logo').html('<img src="'+e.target.result+'" style="height:64px" />');
          };

          reader.readAsDataURL(input.files[0]);
      }
    }

    var new_map_logo = '';
    function readURL_map(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              new_map_logo = e.target.result;
              $('.image_preview_map_logo').html('<img src="'+e.target.result+'" style="height:16px"  />');
          };

          reader.readAsDataURL(input.files[0]);
      }
    }

    
</script>
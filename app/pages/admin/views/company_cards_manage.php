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
        <i class="fa fa-credit-card"></i> Assign cards
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
                  <label for="field_name">Partner</label>
                  <select class="form-control" name="company" onchange="change_partner()">
                    <option value="">Select partner</option>
                    <?php foreach ($partner_list as $key => $value) { ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <?php foreach ($partner_list as $key => $value) { ?>
                    <div class="company_locations company_location_<?php echo $value->id; ?>" style="display:none">
                      <label for="field_name">Location</label>
                      <select class="form-control" name="company_location_<?php echo $value->id; ?>">
                        <option value="">Select location</option>
                        <?php foreach ($value->locations as $lkey => $lvalue) { ?>
                          <option value="<?php echo $lvalue->id; ?>"><?php echo $lvalue->username; ?> (<?php echo $lvalue->part_of_city; ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Card Number From</label>
                  <input type="text" class="form-control" name="cards_from" id="field_name" placeholder="Card number from" value="<?php echo $item->name; ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">Card Number To</label>
                  <input type="text" class="form-control" name="cards_to" id="field_name" placeholder="Card number to" value="<?php echo $item->name; ?>">
                </div>

                <div class="form-group no_cards_holder" style="display: none;">
                  <label for="exampleInputFile">Cards with following numbers are not available</label>
                  <br/>
                  <div class="no_cards"></div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="validate_card_availability()">Validate cards</button>
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

    function change_partner(){
      var company = $('[name="company"]').val();
      $('.company_locations').hide();
      $('.company_location_'+company).show();
    }

    function validate_card_availability(){
      var validate_data = {};
          validate_data.cards_from = $('[name="cards_from"]').val();
          validate_data.cards_to = $('[name="cards_to"]').val();

      var call_url = "validate_card_availability";  
      var call_data = { 
        validate_data:validate_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          assign_cards();
      }else{  
          valid_selector = "error";
          $('.no_cards_holder').show();
          $('.no_cards').html(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function assign_cards(){
      var validate_data = {};
          validate_data.cards_from = $('[name="cards_from"]').val();
          validate_data.cards_to = $('[name="cards_to"]').val();
          validate_data.company = $('[name="company"]').val();
          validate_data.company_location = $('[name="company_location_'+validate_data.company+'"]').val();
          console.log(validate_data);
      if(validate_data.company != ''){
        var call_url = "assign_cards";  
        var call_data = { 
          validate_data:validate_data 
        }  
        var callback = function(response){  
        if(response.success){  
            valid_selector = "success"; 
            document.location = 'company_cards_all';
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }else{
          valid_selector = "error";
          alert('Please select company');
      }

      
    }
</script>
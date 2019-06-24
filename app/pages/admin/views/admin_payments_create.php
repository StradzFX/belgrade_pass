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
        <i class="fa fa-money"></i> Create new admin payment
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-sm-12 col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="row">
                    <div class="col col-md-6">
                      <div class="form-group">
                        <label for="field_name">Card number</label>
                        <select class="form-control" name="card_number">
                          
                        </select>
                      </div>
                    </div>

                    <div class="col col-md-6">
                      <div class="form-group">
                        <label for="field_name">Search cards by user (email, name)</label>
                        <input type="text" class="form-control" name="user_search" onkeyup="filter_data_user()" />
                      </div>
                    </div>
                </div>

                <div class="form-group">
                  <label for="field_name">Package</label>
                  <select class="form-control" name="package" onchange="select_price()">
                    <option value="">Select package</option>
                    <?php for ($i=0; $i < sizeof($card_package_all); $i++) { ?> 
                      <option value="<?php echo $card_package_all[$i]->id; ?>,<?php echo $card_package_all[$i]->price; ?>"><?php echo $card_package_all[$i]->name; ?> - <?php echo $card_package_all[$i]->number_of_passes; ?> passes</option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="field_name">Price (change if you need)</label>
                  <input type="text" class="form-control" disabled="disabled" name="price"/>
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="save_record()">Create payment</button>
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

<script type="text/javascript">
    
    var cards = new Array();

    <?php for ($i=0; $i < sizeof($user_card_all); $i++) { ?> 
        var card = {};
            card.id = '<?php echo $user_card_all[$i]->id; ?>';
            card.card_number = '<?php echo $user_card_all[$i]->card_number; ?>';
            <?php if($user_card_all[$i]->user != ''){ ?>
                card.user_email = '<?php echo $user_card_all[$i]->user->email; ?>';
                card.user_full_name = '<?php echo $user_card_all[$i]->user->first_name; ?> <?php echo $user_card_all[$i]->user->last_name; ?>';
                card.user_full_name_2 = '<?php echo $user_card_all[$i]->user->last_name; ?> <?php echo $user_card_all[$i]->user->first_name; ?>';
            <?php }else{ ?>
                card.user_email = 'N/A';
                card.user_full_name = 'N/A';
                card.user_full_name_2 = 'N/A';
            <?php } ?>
           cards[cards.length] = card; 
    <?php } ?>

      function fill_card_number_list(filter_data,preselected_card){
        $('[name="card_number"]').html('');
        $('[name="card_number"]').append('<option value="">Select card number</option>');

          if(filter_data == ''){
              for(var i =0; i<cards.length;i++){
                    if(preselected_card == ''){
                        $('[name="card_number"]').append('<option value="'+cards[i].id+'">'+cards[i].card_number+' - '+cards[i].user_email+' ('+cards[i].user_full_name+')</option>');
                    }else{
                        if(cards[i].card_number == preselected_card){
                          $('[name="card_number"]').append('<option value="'+cards[i].id+'" selected="selected">'+cards[i].card_number+' - '+cards[i].user_email+' ('+cards[i].user_full_name+')</option>');
                        }else{
                          $('[name="card_number"]').append('<option value="'+cards[i].id+'">'+cards[i].card_number+' - '+cards[i].user_email+' ('+cards[i].user_full_name+')</option>');
                        }
                    }
                  
              }
          }else{
              var new_list = new Array();
              var reg_expression = new RegExp(filter_data+'.*');
              for(var i =0; i<cards.length;i++){
                  if(cards[i].user_email.match(reg_expression)){
                      new_list[new_list.length] = cards[i];
                  }else{
                    if(cards[i].user_full_name.match(reg_expression)){
                        new_list[new_list.length] = cards[i];
                    }else{
                      if(cards[i].user_full_name_2.match(reg_expression)){
                          new_list[new_list.length] = cards[i];
                      }else{
                        
                      }
                    }
                  }
              }

              for(var i =0; i<new_list.length;i++){
                  $('[name="card_number"]').append('<option value="'+new_list[i].id+'">'+new_list[i].card_number+' - '+new_list[i].user_email+' ('+new_list[i].user_full_name+')</option>');
              }
          }
      }


      function filter_data_user(){
        var user_search = $('[name="user_search"]').val();
        fill_card_number_list(user_search,'');
      }


        fill_card_number_list('','<?php echo $preselected_card; ?>');


      function select_price(){
        var selected_package = $('[name="package"]').val();
        if(selected_package == ''){
            $('[name="price"]').val('');
            $('[name="price"]').attr('disabled','disabled');
        }else{
            $('[name="price"]').attr('disabled',null);
            selected_package = selected_package.split(',');
            $('[name="price"]').val(selected_package[1]);
        }
      }
</script>






























<script>
    function save_record(){
      var save_data = {};
          save_data.section = 'admin_payment';
          save_data.card_number = $('[name="card_number"]').val();
          save_data.package = $('[name="package"]').val();
          save_data.price = $('[name="price"]').val();

      var call_url = "save_item";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'admin_payments/';
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
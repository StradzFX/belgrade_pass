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
        <i class="fa fa-credit-card"></i> Assign new internal card
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
                    <div class="col col-md-9">
                      <div class="form-group">
                        <label for="field_name">Available cards to assign</label>
                        <select class="form-control" name="card_number">
                          <option value="">Select card</option>
                          <?php for ($i=0; $i < sizeof($card_numbers_all); $i++) { ?> 
                            <option value="<?php echo $card_numbers_all[$i]->id; ?>"><?php echo $card_numbers_all[$i]->card_number; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col col-md-23">
                      <div class="form-group">
                        <label for="field_name">No cards?</label>
                        <a class="btn btn-success" href="internal_card_reserve/">Reserve cards</a>
                      </div>
                    </div>


                    
                </div>

                <div>
                  <div class="row">
                    <?php /* ======================== BASIC DETAILS ====================== */ ?>
                    <div class="col col-sm-12 new_user_card">
                      <div class="row">
                        <div class="col col-sm-6">
                          <div>First name</div>
                          <div><input type="text" class="form-control" name="parent_first_name"></div>
                        </div>
                        <div class="col col-sm-6">
                          <div>Last name</div>
                          <div><input type="text" class="form-control" name="parent_last_name"></div>
                        </div>
                         <div class="col col-sm-12">
                           &nbsp;
                         </div>
                        <div class="col col-sm-6">
                          <div>City/Place</div>
                          <div><input type="text" class="form-control" name="city"></div>
                        </div>
                        <div class="col col-sm-6">
                          <div>Phone</div>
                          <div><input type="text" class="form-control" name="phone"></div>
                        </div>
                        <div class="col col-sm-12">
                          <div>Email</div>
                          <div><input type="text" class="form-control" name="email"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="create_card()">Assign card</button>
                <a href="internal_cards_all/" class="btn btn-primary pull-right">Back</a>
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

    function display_child_birthdays(){
      $('.date_of_birth').hide();
      var max_kids = $('[name="number_of_kids"]').val();
      for(var i=1; i<= max_kids;i++){
        $('.date_of_birth_'+i).show();
      }
      
    }

    function create_card(){
      var card_data = {};
            card_data.card_number = $('[name="card_number"]').val();
            card_data.parent_first_name = $('[name="parent_first_name"]').val();
            card_data.parent_last_name = $('[name="parent_last_name"]').val();
            card_data.number_of_kids = $('[name="number_of_kids"]').val();
            card_data.city = $('[name="city"]').val();
            card_data.phone = $('[name="phone"]').val();
            card_data.email = $('[name="email"]').val();

            var birthdays = new Array();
            var max_kids = $('[name="number_of_kids"]').val();
            for(var i=1; i<= max_kids;i++){
              var birthday = {};
                  birthday.name = '';
                  birthday.date_of_birth = $('.date_of_birth_'+i).find('[name="child_birthdate"]').val();
                  birthdays[birthdays.length] = birthday;
            }
            console.log(birthdays);
            card_data.birthdays = birthdays;

        var call_url = "assign_internal_card";  
        var call_data = { 
            card_data:card_data 
        }  
        var callback = function(odgovor){  
            if(odgovor.success){  
                valid_selector = "success"; 
                document.location = master_data.base_url+'internal_cards_all/';
            }else{  
                valid_selector = "error";
                alert(odgovor.message);
            } 
        }  
        ajax_json_call(call_url, call_data, callback); 
    }
</script>
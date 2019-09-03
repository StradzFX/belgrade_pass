<?php include_once 'app/pages/admin/views/elements/company_manage/modals.php'; ?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_create_new_company_transaction.php'; ?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_company_transaction_edit.php'; ?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_company_transaction_delete.php'; ?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_company_discount_rules.php'; ?>

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
        <i class="fa fa-building"></i> <?php echo $item->id == 0 ? 'New' : 'Edit'; ?> company
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#company_data" data-toggle="tab">Company data</a></li>
          <li><a href="#company_transactions" data-toggle="tab">Transactions</a></li>
          <li><a href="#company_payments" data-toggle="tab">Payments</a></li>
        </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="company_data">
                <?php require 'app/pages/admin/views/elements/company_manage/tab_company_info.php'; ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="company_transactions">
              <section class="content">
              <div class="row">
                <div class="col col-sm-3">
                  Date From:<br/>
                  <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime('-1 year')); ?>" name="transactions_date_from" onchange="get_list_of_transactions_with_companies()">
                </div>
                <div class="col col-sm-3">
                  Date To:<br/>
                  <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="transactions_date_to" onchange="get_list_of_transactions_with_companies()">
                </div>
                <div class="col-12 col-md-6">
                  <div class="pull-right">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#modal_create_new_company_transaction">New transaction</a>
                  </div>
                </div>
              </div><br>
              <div class="row">
                <div class="col-12 col-xs-12">
                  <div class="transactions_with_company_holder">
                  
                  </div>
                </div>
              </div><br>
            </section>
            </div>
            <div class="tab-pane" id="company_payments">
              <section class="content">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col col-sm-3">
                        Date From:<br/>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime('-1 year')); ?>" name="payment_date_from" onchange="get_list_of_company_cards_payments()">
                      </div>
                      <div class="col col-sm-3">
                        Date To:<br/>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="payment_date_to" onchange="get_list_of_company_cards_payments()">
                      </div>
                      <div class="col col-sm-3">
                          User Email or Full Name:<br/>
                          <input type="text" class="form-control" value="" name="payment_user_search" onkeyup="get_list_of_company_cards_payments()">
                      </div>
                    </div><br>

                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-body no-padding company_card_usage_holder">
                      
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              <div>
              </section>
            </div>
            <!-- /.tab-pane -->
          </div>
            <!-- /.tab-content -->
      </div>
    </section>
    <!-- /.content -->
</div>




<style type="text/css">
  .image_preview{
    padding: 10px 0px;
  }

  .image_preview img{
    max-width: 100%;
  }

  .main_options{
    padding: 10px;
  }
</style>

<script>

    function get_list_of_company_cards_payments(){
      var data={};
          data.id=$('[name="id"]').val();
          data.payment_date_from = $('[name="payment_date_from"]').val();
          data.payment_date_to = $('[name="payment_date_to"]').val();
          data.payment_user_search = $('[name="payment_user_search"]').val();
          
      var call_url='get_list_of_company_cards_payments';
      var call_data={data:data}
      var callback = function(response){
        $('.company_card_usage_holder').html(response);
      }
      ajax_call(call_url, call_data, callback);

    }

    $(function(){
      get_list_of_company_cards_payments()
    });

    function get_list_of_transactions_with_companies(){
      var data={};
          data.id=$('[name="id"]').val();
          data.date_from = $('[name="transactions_date_from"]').val();
          data.date_to = $('[name="transactions_date_to"]').val();

      var call_url='get_list_of_transactions_with_companies';
      var call_data={data:data}
      var callback = function(response){
        $('.transactions_with_company_holder').html(response);
      }
      ajax_call(call_url, call_data, callback);

    }

    $(function(){
      get_list_of_transactions_with_companies()
    });

    function change_business_option(type){
      var is_checked = $('[name="'+type+'"]').is(':checked');
      is_checked = is_checked ? '1' : '0';

      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.is_checked = is_checked;
          save_data.type = type;

      var call_url = "change_business_option";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success";
      }else{  
          valid_selector = "error";
      }

      

      if(type == 'birthday_options'){
        if(is_checked == 1){
          $('.birthday_options_main_holder').css('display','block');
        }else{
          $('.birthday_options_main_holder').css('display','none');
        }
      }

      //alert(response.message);

      }  
      ajax_json_call(call_url, call_data, callback); 

    }

    function save_record(){
      var save_data = {};
          save_data.section = 'schools';
          save_data.id = $('[name="id"]').val();
          save_data.name = $('[name="name"]').val();
          save_data.sport_category = $('[name="sport_category"]').val();
          save_data.short_description = $('[name="short_description"]').val();
          save_data.discount_description = $('[name="discount_description"]').val();
          save_data.main_description = CKEDITOR.instances.ckeditor.getData();
          save_data.pass_customer_percentage = $('[name="pass_customer_percentage"]').val();
          save_data.pass_company_percentage = $('[name="pass_company_percentage"]').val();
          

          
          

      var call_url = "save_item";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'company_manage/'+response.id+'?message=success';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    function remove_coach(id,trainer){
      var confirm_response = confirm('Are you sure you want to remoove this coach?');

      if(confirm_response){
        var data = {};
            data.id = id;
            data.trainer = trainer;

        var call_url = "school_remove_coach";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_school_coaches();
            get_school_coaches_select();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }

    function add_coach(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.trainer = $('[name="new_coach"]').val();
          

      var call_url = "school_insert_coach";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_school_coaches();
          get_school_coaches_select();
          $('#modal-coach').modal('toggle');
          $('[name="new_coach"]').val('');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
      
    }


    var new_image = '';


    function readURL(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              console.log(e.target.result);
              new_image = e.target.result;
              $('.image_preview').html('<img src="'+e.target.result+'" />');
          };

          reader.readAsDataURL(input.files[0]);
      }
    }



    function get_school_gallery(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_gallery";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.gallery_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }
    

    function get_school_coaches(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_coaches";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.coach_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function get_school_coaches_select(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_coaches_select";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('[name="programm_coach"]').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function get_school_locations(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_locations";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.location_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function get_company_categories(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_company_categories";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.category_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function get_school_locations_select(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_locations_select";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('[name="programm_location"]').html(response);
        $('[name="lb_location"]').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function get_school_programms(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_school_programms";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.programm_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function add_image(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.image = new_image;
          

      var call_url = "school_insert_image";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_school_gallery();
          $('#modal-image').modal('toggle');
          $('.image_preview').html('');
          $('[name="new_image"]').val('');
          new_image = '';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function add_location(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.latitude = $('[name="latitude"]').val();
          save_data.longitude = $('[name="longitude"]').val();
          save_data.location_id = $('[name="location_id"]').val();
          save_data.city = $('[name="location_city"]').val();
          save_data.part_of_city = $('[name="location_part_of_city"]').val();
          save_data.street = $('[name="location_street"]').val();
          save_data.email = $('[name="location_email"]').val();
          save_data.username = $('[name="location_username"]').val();
          save_data.password = $('[name="location_password"]').val();

          var change_u_a_p = $('[name="change_u_a_p"]').is(':checked');
          if(!change_u_a_p){
            save_data.password = '';
          }

          var working_days = new Array();
          for(var i=1;i<=7;i++){
            var working_data = {};
                working_data.day_of_week = i;
                working_data.not_working = $('[name="not_working_'+i+'"]').is(':checked');
                working_data.working_from_hours = $('[name="working_from_hours_'+i+'"]').val();
                working_data.working_from_minutes = $('[name="working_from_minutes_'+i+'"]').val();
                working_data.working_to_hours = $('[name="working_to_hours_'+i+'"]').val();
                working_data.working_to_minutes = $('[name="working_to_minutes_'+i+'"]').val();

             working_days[working_days.length] = working_data;
          }

          save_data.working_days = working_days;

         console.log(save_data);

      var call_url = "school_insert_location";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_school_locations();
          get_school_locations_select();
          $('#modal-location').modal('toggle');

          $('[name="latitude"]').val('44.8029925');
          $('[name="longitude"]').val('20.4865823');
          $('[name="location_id"]').val('');
          $('[name="location_city"]').val('');
          $('[name="location_part_of_city"]').val('');
          $('[name="location_street"]').val('');
          $('[name="location_email"]').val('');
          $('[name="location_username"]').val('');
          $('[name="location_password"]').val('');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function add_category(){
      var save_data = {};
          save_data.company = $('[name="id"]').val();
          save_data.category = $('[name="new_category"]').val();

         console.log(save_data);

      var call_url = "school_insert_category";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_company_categories();
          $('#modal-category').modal('toggle');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function add_programm(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.name = $('[name="programm_name"]').val();
          save_data.age = $('[name="programm_age"]').val();
          save_data.age = save_data.age.split(',');
          save_data.age_from = save_data.age[0];
          save_data.age_to = save_data.age[1];
          save_data.trainer = $('[name="programm_coach"]').val();
          save_data.ts_location = $('[name="programm_location"]').val();

          console.log(save_data);

      var call_url = "school_insert_programm";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_school_programms();
          $('#modal-programm').modal('toggle');

          $('[name="programm_name"]').val('');
          $('[name="programm_coach"]').val('');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    function save_days(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.days_programm_id = $('[name="days_programm_id"]').val();

          save_data.days = new Array();
          $('[name="days"]:checked').each(function(){
            var day = {};
                day.id = $(this).val();

              save_data.days[save_data.days.length] = day;
          });

          for(var i=0;i<save_data.days.length;i++){
            save_data.days[i].coach = $('#day_'+save_data.days[i].id).find('[name="day_coach"]').val();

            save_data.days[i].periods = new Array();
            $('.period_holder_'+save_data.days[i].id).find('.period_row').each(function(){
                var period = {};
                    period.from = $(this).find('[name="from"]').val();
                    period.to = $(this).find('[name="to"]').val();
                    period.price = $(this).find('[name="price"]').val();
                    period.ccy = $(this).find('[name="ccy"]').val();
                    period.period_coach = $(this).find('[name="period_coach"]').val();

                    save_data.days[i].periods[save_data.days[i].periods.length] = period;
            });
          }

          console.log(save_data);

      var call_url = "school_insert_days";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_school_programms();
          $('#modal-days').modal('toggle');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    function set_as_thumb(id){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.picture_id = id;

      var call_url = "school_set_picture_thumb";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          get_school_gallery();
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    function remove_period(id){
      $('.period_row_'+id).remove();
    }
    


    function remove_picture(id){
      var confirm_response = confirm('Are you sure you want to delete this picture?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "school_remove_image";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_school_gallery();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }

    function remove_programm(id){
      var confirm_response = confirm('Are you sure you want to delete this programm?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "school_remove_programm";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_school_programms();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }

    

    function remove_location(id){
      var confirm_response = confirm('Are you sure you want to delete this location?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "school_remove_location";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_school_locations();
            get_school_locations_select();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }

    function remove_category(id){
      var confirm_response = confirm('Are you sure you want to delete this category?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "school_remove_category";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_company_categories();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }

    

    function edit_location(id,city,part_of_city,street,email,username,latitude,longitude){
      $('#modal-location').modal('toggle');

      $('[name="location_id"]').val(id);
      $('[name="location_city"]').val(city);
      $('[name="location_part_of_city"]').val(part_of_city);
      $('[name="location_street"]').val(street);
      $('[name="location_email"]').val(email);
      $('[name="location_username"]').val(username);
      $('[name="latitude"]').val(latitude);
      $('[name="longitude"]').val(longitude);

      set_working_days(id);

      marker.setMap(null);

      var center = new google.maps.LatLng(latitude, longitude);
      // using global variable:
      map.panTo(center);

      marker = new google.maps.Marker({
          position: center,
          map: map,
          draggable:true,
          title:"Drag me!"
      });

      google.maps.event.addListener(marker, 'dragend', function(evt){
        $('[name="latitude"]').val(evt.latLng.lat().toFixed(6));
        $('[name="longitude"]').val(evt.latLng.lng().toFixed(6));
      });
    }

    function set_working_days(id){
      var data = {};
          data.id = id;

          var call_url = "get_working_days";  
          var call_data = { 
            data:data 
          }  
          var callback = function(response){  
            var working_days = response.working_days;

            if(working_days.length > 0){
              for(var i=0;i<working_days.length;i++){
                var day_of_week = working_days[i].day_of_week;

                if(working_days[i].not_working){
                  $('[name="not_working_'+day_of_week+'"]').attr('checked','checked');
                  $('.working_day_'+day_of_week).addClass('disabled_select');
                }
                $('[name="working_from_hours_'+day_of_week+'"]').val(working_days[i].working_from_hours);
                $('[name="working_from_minutes_'+day_of_week+'"]').val(working_days[i].working_from_minutes);
                $('[name="working_to_hours_'+day_of_week+'"]').val(working_days[i].working_to_hours);
                $('[name="working_to_minutes_'+day_of_week+'"]').val(working_days[i].working_to_minutes);
              }
            }else{
              for(var i=1;i<=7;i++){
                var day_of_week = i;

                $('[name="not_working_'+day_of_week+'"]').attr('disabled',null);
                $('[name="not_working_'+day_of_week+'"]').attr('checked',null);
                $('.working_day_'+day_of_week).removeClass('disabled_select');
                $('[name="working_from_hours_'+day_of_week+'"]').val(0);
                $('[name="working_from_minutes_'+day_of_week+'"]').val(0);
                $('[name="working_to_hours_'+day_of_week+'"]').val(0);
                $('[name="working_to_minutes_'+day_of_week+'"]').val(0);
              }
            }
            
            console.log(working_days);
          }  
          ajax_json_call(call_url, call_data, callback); 
    }

    function save_username(){
      var data = {};
          data.id = $('[name="id"]').val();
          data.username = $('[name="username"]').val();
          data.password = $('[name="password"]').val();

          var call_url = "school_save_username";  
          var call_data = { 
            data:data 
          }  
          var callback = function(response){  
            if(response.success){  
                $('[name="password"]').val('');
                $('.company_panel_link').attr('href','../company_panel/?username='+data.username);
            }else{  
                valid_selector = "error";
                
            }  
            alert(response.message);
          }  
          ajax_json_call(call_url, call_data, callback); 
    }


    function edit_days(id){

      var data = {};
          data.id = id;
          data.school_id = $('[name="id"]').val();

      var call_url = "school_get_programm_days";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('#modal-days').find('.modal-body').html(response);
        $('#modal-days').modal('toggle');
      }  
      ajax_call(call_url, call_data, callback); 

      
    }
    
    <?php if($item->id > 0){ ?>
    $(function(){
      get_school_gallery();
      get_school_coaches();
      get_school_coaches_select();
      get_school_locations();
      get_school_locations_select();
      get_school_programms();
      get_school_locations_bithdays();
      get_company_categories();
    });
    <?php } ?>
</script>

 <script>
// Initialize and add the map
var marker = null;
var map = null;
function initMap() {


    
  $('[name="latitude"]').val(44.8029925);
  $('[name="longitude"]').val(20.4865823);

  var map_center = {lat: 44.8029925, lng: 20.4865823};
  var myLatlng = new google.maps.LatLng(44.8029925,20.4865823);
  // The map, centered at Uluru
  map = new google.maps.Map(
      document.getElementById('map'), {zoom: 12, center: map_center}
  );

  marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable:true,
        title:"Drag me!"
    });

  google.maps.event.addListener(marker, 'dragend', function(evt){
    $('[name="latitude"]').val(evt.latLng.lat().toFixed(6));
    $('[name="longitude"]').val(evt.latLng.lng().toFixed(6));
  });
}



</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOsWQtPLZxsiYNQd5Eky48Tu2Hg-PSQZU&callback=initMap">
    </script>


    <style type="text/css">
      #map{
        width: 100%;
        height: 200px;
      }
    </style>

<script src="../public/admin/plugins/bootstrap-slider/bootstrap-slider.js"></script>

<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

<script>
  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').slider();
  })

   document.addEventListener('DOMContentLoaded', function(){
     CKEDITOR.replace('ckeditor');
    });

</script>
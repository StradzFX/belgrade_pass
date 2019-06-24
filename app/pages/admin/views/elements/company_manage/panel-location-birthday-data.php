
  <div class="row">
    <div class="col-sm-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location Birthday Data</h3>
          <a href="javascript:void(0)" class="btn btn-success pull-right" onclick="open_lb_blank()">Add location</a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" class="location_birthday_holder">
          
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>

<script type="text/javascript">

  function open_lb_data_location(id,lb_location,lb_name,lb_max_kids,lb_max_adults,lb_garden,lb_smoking,lb_catering,lb_animators,lb_watching_kids){

    var data = {};
        data.id = id;

    var call_url = "get_birthday_slots";  
    var call_data = { 
      data:data 
    }  
    var callback = function(response){  
      var data = {};
          data.lb_id = id;
          data.lb_location = lb_location;
          data.lb_name = lb_name;
          data.lb_max_kids = lb_max_kids;
          data.lb_max_adults = lb_max_adults;
          data.lb_garden = lb_garden == 1;
          data.lb_smoking = lb_smoking == 1;
          data.lb_catering = lb_catering == 1;
          data.lb_animators = lb_animators == 1;
          data.lb_watching_kids = lb_watching_kids == 1;
          data.slots = response.slots;
          open_lb_modal(data);
    }  
    ajax_json_call(call_url, call_data, callback); 

    
  }

  function get_school_locations_bithdays(){
    var data = {};
        data.id = $('[name="id"]').val();

    var call_url = "get_school_locations_bithdays";  
    var call_data = { 
      data:data 
    }  
    var callback = function(response){  
      $('.location_birthday_holder').html(response);
    }  
    ajax_call(call_url, call_data, callback); 
  }

  function remove_location_birthday(id){
      var confirm_response = confirm('Are you sure you want to delete this location?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "school_remove_location_birthday";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_school_locations_bithdays();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }
</script>
<div class="modal fade" id="modal-image">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add image</h4>
      </div>
      <div class="modal-body">
        <input type="file" name="new_image"   onchange="readURLGallery(this);" >
        <div class="image_preview">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add_image()">Upload</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
        <i class="fa fa-user"></i> <?php echo $item->id == 0 ? 'New' : 'Edit'; ?> coach
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
                  <label for="field_first_name">First name</label>
                  <input type="text" class="form-control" name="first_name" id="field_first_name" placeholder="Enter first name" value="<?php echo $item->first_name; ?>">
                </div>
                <div class="form-group">
                  <label for="field_last_name">Last name</label>
                  <input type="text" class="form-control" name="last_name" id="field_last_name" placeholder="Enter last name" value="<?php echo $item->last_name; ?>">
                </div>

                <div class="form-group">
                  <label for="field_sport_category">Category</label>
                  <select class="form-control" name="sport_category" id="field_sport_category">
                      <option value="">Select category</option>

                      <?php for ($i=0; $i < sizeof($category_list); $i++) { ?> 
                        <option <?php if($category_list[$i]->id == $item->sport_category){ ?>selected="selected"<?php } ?> value="<?php echo $category_list[$i]->id; ?>"><?php echo $category_list[$i]->name; ?></option>
                      <?php } ?>
                  </select>
                </div>


                <div class="form-group">
                  <label for="exampleInputFile">Photo</label>
                  <input type="file" name="new_photo"   onchange="readURL(this);" >

                  <p class="help-block">Upload image in any size.</p>
                  <div class="image_preview_photo">
                    <img src="<?php echo $item->photo_display; ?>" style="height:200px"  />
                  </div>
                </div>

                <div class="form-group">
                  <label for="field_short_description">Short description</label>
                  <textarea class="form-control" name="short_description" rows="5"><?php echo $item->short_description; ?></textarea>
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

        <?php if($item->id > 0){ ?>
        <div class="col-sm-12 col-md-6">

          <div class="row">
            <div class="col-sm-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Gallery</h3>
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-image" class="btn btn-success pull-right">Add image</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" class="gallery_holder">
                  
                </form>
              </div>
              <!-- /.box -->
            </div>

          </div>
          
        </div>
        <!--/.col (left) -->
        <?php } ?>

        
      </div>
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>

<script>
    function save_record(){
      var save_data = {};
          save_data.section = 'coaches';
          save_data.id = $('[name="id"]').val();
          save_data.first_name = $('[name="first_name"]').val();
          save_data.last_name = $('[name="last_name"]').val();
          save_data.short_description = $('[name="short_description"]').val();
          save_data.sport_category = $('[name="sport_category"]').val();
          save_data.new_photo = new_photo;
          

      var call_url = "save_item";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'coaches_manage/'+response.id+'?message=success';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    var new_photo = '';
    function readURL(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              new_photo = e.target.result;
              $('.image_preview_photo').html('<img src="'+e.target.result+'" style="height:200px" />');
          };
          reader.readAsDataURL(input.files[0]);
      }
    }



    var new_gallery_picture = '';
    function readURLGallery(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              new_gallery_picture = e.target.result;
              $('.image_preview').html('<img src="'+e.target.result+'" style="width:100%" />');
          };
          reader.readAsDataURL(input.files[0]);
      }
    }

    function get_coach_gallery(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_coach_gallery";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.gallery_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }

    function add_image(){
      var save_data = {};
          save_data.id = $('[name="id"]').val();
          save_data.image = new_gallery_picture;
          

      var call_url = "coach_insert_image";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          get_coach_gallery();
          $('#modal-image').modal('toggle');
          $('.image_preview').html('');
          $('[name="new_image"]').val('');
          new_gallery_picture = '';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function remove_picture(id){
      var confirm_response = confirm('Are you sure you want to delete this picture?');

      if(confirm_response){
        var data = {};
            data.id = id;

        var call_url = "coach_remove_image";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            get_coach_gallery();
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }


    $(function(){
        get_coach_gallery();
    });

</script>
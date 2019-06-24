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
        <i class="fa fa-list"></i> <?php echo $item->id == 0 ? 'New' : 'Edit'; ?> category
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
                  <label for="field_name">Name</label>
                  <input type="text" class="form-control" name="name" id="field_name" placeholder="Enter category name" value="<?php echo $item->name; ?>">
                </div>
                

                <div class="form-group">
                  <label for="exampleInputFile">Icon</label>
                  <br/>
                  <?php foreach ($icons as $key => $value) { ?>
                    <div class="icon">
                        <label for="<?php echo $value; ?>">
                          <div class="icon_display">
                            <img src="../public/images/icons/<?php echo $value; ?>">
                          </div>
                        </label>
                        <div class="icon_control">
                          <input type="radio" name="icon" <?php if($item->logo == $value){ ?>checked="checked"<?php } ?> id="<?php echo $value; ?>" value="<?php echo $value; ?>" >
                        </div>
                    </div>
                  <?php } ?>
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
                  <label for="field_name">Home page picture</label>
                  <input type="file" name="map_logo"   onchange="readURL(this);" >
                  <div class="image_preview">
                    <img src="../pictures/sport_category/map_logo/<?php echo $item->map_logo; ?>">
                  </div>
                </div>

                


              </div>
              <!-- /.box-body -->

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

  .icon{
    display: inline-block;
    background-color: #ccc;
    margin-right: 10px;
    width: 50px;
    padding: 10px;
    text-align: center;
    margin-bottom: 10px;
  }

  .icon_control{
    height: 30px;
  }

  .icon_display{
    height: 30px;
  }
</style>

<script>
    function save_record(){
      var save_data = {};
          save_data.section = 'categories';
          save_data.id = $('[name="id"]').val();
          save_data.name = $('[name="name"]').val();
          save_data.new_logo = $('[name="icon"]:checked').val();
          save_data.new_map_logo = map_logo;

          console.log(save_data);

      var call_url = "save_item";  
      var call_data = { 
        save_data:save_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'categories_manage/'+response.id+'?message=success';
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

    var map_logo = '';


    function readURL(input) {
      if(input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              console.log(e.target.result);
              map_logo = e.target.result;
              $('.image_preview').html('<img src="'+e.target.result+'" />');
          };

          reader.readAsDataURL(input.files[0]);
      }
    }

</script>
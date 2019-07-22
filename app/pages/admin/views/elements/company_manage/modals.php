  <!-- bootstrap slider -->
  <link rel="stylesheet" href="../public/admin/plugins/bootstrap-slider/slider.css">

<div class="modal fade" id="modal-coach">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add coach</h4>
      </div>
      <div class="modal-body">
        <select name="new_coach" class="form-control">
          <option value="">Select coach</option>
          <?php for ($i=0; $i < sizeof($coach_list); $i++) { ?> 
            <option value="<?php echo $coach_list[$i]->id; ?>"><?php echo $coach_list[$i]->full_name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add_coach()">Insert</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal-category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add category</h4>
      </div>
      <div class="modal-body">
        <select name="new_category" class="form-control">
          <option value="">Select category</option>
          <?php for ($i=0; $i < sizeof($category_list); $i++) { ?> 
            <option value="<?php echo $category_list[$i]->id; ?>"><?php echo $category_list[$i]->name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add_category()">Insert</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-days">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit programm days</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_days()">Insert</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal-programm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add programm</h4>
      </div>
      <div class="modal-body">
        Name:<br/>
        <input type="text" class="form-control" name="programm_name" placeholder="Insert name of a programm" />
      </div>


      <div class="modal-body">
        Age range:<br/>
        <input type="hidden" class="form-control" name="programm_age_from" />
        <input type="hidden" class="form-control" name="programm_age_to" />
        <input type="text" name="programm_age" value="10,50" class="slider form-control" data-slider-min="1" data-slider-max="99"
                         data-slider-step="1" data-slider-value="[10,50]" data-slider-orientation="horizontal"
                         data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">
      </div>

      <div class="modal-body">
        Coach:<br/>
        <select name="programm_coach" class="form-control">
          <option value="">Select coach</option>
        </select>
      </div>

      <div class="modal-body">
        Location:<br/>
        <select name="programm_location" class="form-control">
          <option value="">Select location</option>
        </select>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add_programm()">Insert</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php include_once 'app/pages/admin/views/elements/company_manage/modal-location.php'; ?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal-location-birthday-data.php'; ?>


<style type="text/css">
  .margin_form{
    margin-bottom: 10px;
  }

  .wth{
    height: 22px;
  }

  .tar{
    text-align: right;
  }

  .disabled_select{
    color: #ccc;
  }
</style>

<script type="text/javascript">
  function change_working_day(day_of_week){
    var is_checked = $('[name="not_working_'+day_of_week+'"]').is(':checked');
    if(is_checked){
      $('.working_day_'+day_of_week).find('select').attr('disabled','disabled');
      $('.working_day_'+day_of_week).addClass('disabled_select');
    }else{
      $('.working_day_'+day_of_week).find('select').attr('disabled',null);
      $('.working_day_'+day_of_week).removeClass('disabled_select');
    }
  }
</script>

<div class="modal fade" id="modal-image">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add image</h4>
      </div>
      <div class="modal-body">
        <input type="file" name="new_image"   onchange="readURL(this);" >
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

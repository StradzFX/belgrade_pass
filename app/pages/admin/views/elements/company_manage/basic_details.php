<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Basic data</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form role="form">
    <div class="box-body">

      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="form-group">
            <label for="field_name">Name</label>
            <input type="text" class="form-control" name="name" id="field_name" placeholder="Enter name" value="<?php echo $item->name; ?>">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label for="field_name">BelgradePass Profit (%)</label>
            <input type="text" class="form-control" name="pass_company_percentage" id="pass_company_percentage" placeholder="Enter name" value="<?php echo $item->pass_company_percentage; ?>">
          </div>
        </div>

        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label for="field_name">Customer discount (%)</label>
            <input type="text" class="form-control" name="pass_customer_percentage" id="pass_customer_percentage" placeholder="Enter name" value="<?php echo $item->pass_customer_percentage; ?>">
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label for="field_name">Short company description</label>
            <textarea name="short_description" rows="5" class="form-control"><?php echo $item->short_description; ?></textarea>
          </div>
        </div>

        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label for="field_name">Discount description</label>
            <textarea name="discount_description" rows="5" class="form-control"><?php echo $item->discount_description; ?></textarea>
          </div>
        </div>
      </div>

      

      

      


    <div class="box-body" style="display: none;">
      <div class="form-group">
        <label for="field_sport_category">Category</label>
        <select class="form-control" name="sport_category" id="field_sport_category">

            <?php for ($i=0; $i < sizeof($category_list); $i++) { ?> 
              <option <?php if($category_list[$i]->id == $item->sport_category){ ?>selected="selected"<?php } ?> value="<?php echo $category_list[$i]->id; ?>"><?php echo $category_list[$i]->name; ?></option>
            <?php } ?>
        </select>
      </div>
    </div>
    <!-- /.box-body -->


      

      <div class="form-group">
        <label for="field_name">Main description</label>
        <textarea name="main_description" id="ckeditor" class="form-control" rows="8"><?php echo $item->main_description; ?></textarea>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <button type="button" class="btn btn-primary" onclick="save_record()">Submit</button>
    </div>
  </form>
</div>
<!-- /.box -->
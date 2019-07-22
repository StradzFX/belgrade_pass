<div class="row">
        <!-- left column -->
        <div class="col-sm-12 col-md-7">
          <!-- general form elements -->
          <div class="row">
            <div class="col-sm-12">
                <?php include_once 'app/pages/admin/views/elements/company_manage/basic_details.php'; ?>
            </div>   
            <?php if($item->id > 0){ ?>
            <div class="col-sm-12">
              <?php include_once 'app/pages/admin/views/elements/company_manage/master_login.php'; ?>
              
            </div>
            <?php } ?>
          </div>
        </div>
        <!--/.col (left) -->

        <div class="col-sm-12 col-md-5">
          <div class="row">
            <?php if($item->id > 0){ ?>
            <div class="col-sm-12 col-md-12">
              <?php include_once 'app/pages/admin/views/elements/company_manage/company_options.php'; ?>
            </div>

            <div class="col-sm-12 col-md-12">
              <?php include_once 'app/pages/admin/views/elements/company_manage/categories.php'; ?>
            </div>

            <div class="col-sm-12 col-md-12" style="display: none;">
              <?php include_once 'app/pages/admin/views/elements/company_manage/main_business_options.php'; ?>
            </div>

            <div class="col-sm-12 col-md-12 birthday_options_main_holder" style="display: none;">
              <?php include_once 'app/pages/admin/views/elements/company_manage/panel-location-birthday-data.php'; ?>
            </div>

            <div class="col-sm-12 col-md-12">
              <?php include_once 'app/pages/admin/views/elements/company_manage/gallery.php'; ?>
            </div>

            <div class="col-sm-12 col-md-12">
              <?php include_once 'app/pages/admin/views/elements/company_manage/locations.php'; ?>
            </div>
          <?php } ?>
          </div>
        </div>
      </div>
      <!-- /.row -->
    <div>
    </div>
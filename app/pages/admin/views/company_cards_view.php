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
        <i class="fa fa-building"></i> <?php echo $company->name; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-sm-12 col-md-12">
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
                  <select class="form-control" name="company">
                    <option value="">Select partner</option>
                    <?php foreach ($partner_list as $key => $value) { ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                  </select>
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
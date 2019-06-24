<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            <b>Master Login data</b>
          </h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
          <div class="box-body">
            <div class="form-group">
              <label for="field_username">Master Username (go to <a href="../company_panel/?username=<?php echo $item->username; ?>" class="company_panel_link" target="_blank">company panel</a>)</label>
              <input type="text" class="form-control" name="username" id="field_username" placeholder="Enter username" value="<?php echo $item->username; ?>">
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-body">
            <div class="form-group">
              <label for="field_password">Password</label>
              <input type="password" class="form-control" name="password" id="field_password" placeholder="Leave blank if you do not want to change" value="">
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="button" class="btn btn-primary" onclick="save_username()">Save login data</button>
          </div>
        </form>
      </div>
      <!-- /.box -->
  </div>
</div>
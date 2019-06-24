<div class="row">
  <div class="col-sm-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Main business options</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form">
        <div class="row main_options">
            <div class="col col-sm-4">
              <label for="pass_options">Take passes</label><br/>
              <input type="checkbox" id="pass_options" name="pass_options" onchange="change_business_option('pass_options')" <?php if($item->pass_options == 1){ ?>checked="checked"<?php } ?> />
            </div>

            <div class="col col-sm-4">
              <label for="birthday_options">Birthdays</label><br/>
              <input type="checkbox" id="birthday_options" name="birthday_options" onchange="change_business_option('birthday_options')" <?php if($item->birthday_options == 1){ ?>checked="checked"<?php } ?> />
            </div>

            <div class="col col-sm-4">
              <label for="extra_goods_options">Extra services</label><br/>
              <input type="checkbox" id="extra_goods_options" name="extra_goods_options" onchange="change_business_option('extra_goods_options')" <?php if($item->extra_goods_options == 1){ ?>checked="checked"<?php } ?> />
            </div>
        </div>
      </form>
    </div>
    <!-- /.box -->
  </div>

</div>

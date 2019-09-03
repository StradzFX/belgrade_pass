<?php

  $day_of_week_cdr[1] = 'Ponedeljak';
  $day_of_week_cdr[2] = 'Utorak';
  $day_of_week_cdr[3] = 'Sreda';
  $day_of_week_cdr[4] = 'Četvrtak';
  $day_of_week_cdr[5] = 'Petak';
  $day_of_week_cdr[6] = 'Subota';
  $day_of_week_cdr[7] = 'Nedelja';

  $time_cdr = array();
  for ($working_hours=0; $working_hours <= 23 ; $working_hours++) { 
    for ($woring_minutes=0; $woring_minutes <= 50; $woring_minutes += 10) { 
      $time_cdr[] = array(
        'value' => $working_hours * 60 + $woring_minutes,
        'name' => sprintf('%02d',$working_hours).':'.sprintf('%02d',$woring_minutes)
      );
    }
  }



?>
<div class="modal fade" id="modal_company_discount_rules" style="display: none;">
  <input type="hidden" name="cdr_id" value="0">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Discount rule</h4>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="row">
            <div class="col-12 col-md-12">
              <form role="form">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label for="cdr_day_from">Day from</label>
                    <select class="form-control" name="cdr_day_from" id="cdr_day_from">
                      <option value="">---</option>
                      <?php foreach ($day_of_week_cdr as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="cdr_day_to">Day to</label>
                    <select class="form-control" name="cdr_day_to" id="cdr_day_to">
                      <option value="">---</option>
                      <?php foreach ($day_of_week_cdr as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="cdr_hours_from">Time from</label>
                    <select class="form-control" name="cdr_hours_from" id="cdr_hours_from">
                      <option value="">---</option>
                      <?php for ($i=0; $i < sizeof($time_cdr); $i++) { ?>
                        <option value="<?php echo $time_cdr[$i]['value']; ?>"><?php echo $time_cdr[$i]['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="cdr_hours_to">Time to</label>
                    <select class="form-control" name="cdr_hours_to" id="cdr_hours_to">
                      <option value="">---</option>
                      <?php for ($i=0; $i < sizeof($time_cdr); $i++) { ?>
                        <option value="<?php echo $time_cdr[$i]['value']; ?>"><?php echo $time_cdr[$i]['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-12">
                    <label for="cdr_discount">Discount (%)</label>
                    <input type="text" value="" name="cdr_discount" id="cdr_discount" placeholder="Discount for customer" class="form-control">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Back
          </button>
          <button type="button" class="btn btn-primary" onclick="save_company_discount_rule()">
            Save
          </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
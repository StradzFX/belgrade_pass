<div class="modal fade" id="modal-location">
  <input type="hidden" class="form-control" name="latitude" placeholder="Latitude">
  <input type="hidden" class="form-control" name="longitude" placeholder="Longitude">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Location data</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" class="form-control" name="location_id" value="" placeholder="City name">
          <div class="col col-sm-6 margin_form">
            City:<br/>
            <input type="text" class="form-control" name="location_city" placeholder="City name">
          </div>
          <div class="col col-sm-6 margin_form">
            Part of city:<br/>
            <input type="text" class="form-control" name="location_part_of_city" placeholder="Part of the city">
          </div>
          <div class="col col-sm-12 margin_form">
            Address:<br/>
            <input type="text" class="form-control" name="location_street" placeholder="Address">
          </div>
          <div class="col col-sm-12 margin_form">
            Email:<br/>
            <input type="text" class="form-control" name="location_email" placeholder="Email">
          </div>

          <div class="col col-sm-12">
              <input type="checkbox" id="change_u_a_p" name="change_u_a_p" onchange="change_u_a_p_change()"> <label for="change_u_a_p">Change username and password</label>

              <div class="row change_u_a_p" style="display: none;">
                  <div class="col col-sm-6 margin_form">
                    Username:<br/>
                    <input type="text" class="form-control" name="location_username" placeholder="Username">
                  </div>
                  <div class="col col-sm-6 margin_form">
                    Password:<br/>
                    <input type="password" class="form-control" name="location_password" placeholder="Password">
                  </div>
              </div>
          </div>
          
          <div class="col col-sm-12 margin_form">
            GEO location (drag marker to pin location):<br/>
            <div id="map"></div>
          </div>

          <div class="col col-sm-12 margin_form">
            
            <b>Working times:</b><br/>
            <div class="row">
                <div class="col-sm-2 wth">
                  <b>Day</b>
                </div>
                <div class="col-sm-3 wth">
                  <b>Not working</b>
                </div>
                <div class="col-sm-7 wth">
                  <b>Working hours</b>
                </div>
                <?php for ($j=0; $j < sizeof($working_days); $j++) { ?> 
                  <div class="col-sm-2 wth">
                    <?php echo $working_days[$j]['name']; ?>
                  </div>
                  <div class="col-sm-3 wth">
                    <input type="checkbox" name="not_working_<?php echo $working_days[$j]['day_of_week']; ?>" onchange="change_working_day(<?php echo $working_days[$j]['day_of_week']; ?>)">
                  </div>
                  <div class="col-sm-7 wth working_day_<?php echo $working_days[$j]['day_of_week']; ?>">
                     <div class="row">
                        <div class="col-sm-2 tar">From:</div>
                        <div class="col-sm-4">
                          <select name="working_from_hours_<?php echo $working_days[$j]['day_of_week']; ?>">
                            <?php for ($i=0; $i <= 23; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                          </select>

                          <select name="working_from_minutes_<?php echo $working_days[$j]['day_of_week']; ?>">
                            <?php for ($i=0; $i < 59; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-sm-2 tar">To:</div>
                        <div class="col-sm-4">
                          <select name="working_to_hours_<?php echo $working_days[$j]['day_of_week']; ?>">
                            <?php for ($i=0; $i <= 23; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                            
                          </select>

                          <select name="working_to_minutes_<?php echo $working_days[$j]['day_of_week']; ?>">
                            <?php for ($i=0; $i < 59; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                     </div>

                  </div>
                 <hr/>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add_location()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
  
  function change_u_a_p_change(){
    var change_u_a_p = $('[name="change_u_a_p"]').is(':checked');
    $('.change_u_a_p').toggle();
  }

</script>
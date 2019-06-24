<div class="modal fade" id="modal-location-birthday">
  <input type="hidden" name="lb_id" value="0">
  <div class="modal-dialog"  id="modal-location-birthday-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Location Birthday Data</h4>
      </div>
      <div class="modal-body">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lbd_basic" data-toggle="tab">Basic Data</a></li>
              <li><a href="#lbd_birthday_slots" data-toggle="tab">Birthday Slots</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="lbd_basic">
                <div class="row">
                  <div class="col col-sm-12 margin_form">
                    Company Location:<br/>
                    <select class="form-control" name="lb_location">
                      <option value="">Select location</option>
                    </select>
                  </div>
                  <div class="col col-sm-12 margin_form">
                    Name:<br/>
                    <input type="text" class="form-control" name="lb_name"/>
                  </div>
                  <div class="col col-sm-6 margin_form">
                    Maximum number of kids:<br/>
                    <input type="text" class="form-control" name="lb_max_kids"/>
                  </div>
                  <div class="col col-sm-6 margin_form">
                    Maximum number of adults:<br/>
                    <input type="text" class="form-control" name="lb_max_adults"/>
                  </div>
                  <div class="col col-sm-2 margin_form">
                    Garden:<br/>
                    <input type="checkbox" name="lb_garden" />
                  </div>

                  <div class="col col-sm-2 margin_form">
                    Smoking:<br/>
                    <input type="checkbox" name="lb_smoking"/>
                  </div>

                  <div class="col col-sm-2 margin_form">
                    Catering:<br/>
                    <input type="checkbox" name="lb_catering" />
                  </div>

                  <div class="col col-sm-2 margin_form">
                    Animators:<br/>
                    <input type="checkbox" name="lb_animators" />
                  </div>

                  <div class="col col-sm-3 margin_form">
                    Watching kids:<br/>
                    <input type="checkbox" name="lb_watching_kids" />
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="lbd_birthday_slots">

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <?php for ($j=0; $j < sizeof($working_days); $j++) { ?> 
                    <li <?php if($j==0){ ?>class="active"<?php } ?>>
                      <a href="#lbd_birthday_slots_<?php echo $working_days[$j]['day_of_week']; ?>" data-toggle="tab">
                        <?php echo $working_days[$j]['short']; ?>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                  <div class="tab-content">
                    <?php for ($j=0; $j < sizeof($working_days); $j++) { ?> 
                    <div class="<?php if($j==0){ ?>active<?php } ?> tab-pane" id="lbd_birthday_slots_<?php echo $working_days[$j]['day_of_week']; ?>">
                      
                      <div class="row">
                        <a href="javascript:void(0)" class="btn btn-success" onclick="add_slot(<?php echo $working_days[$j]['day_of_week']; ?>,0,0,0,0,0)">
                          Add slot
                        </a>
                      </div>


                      <div class="row">
                        <div class="col-sm-3 wth">
                          <b>Price</b>
                        </div>
                        <div class="col-sm-7 wth">
                          <b>Slot hours</b>
                        </div>
                        
                      </div>
                      <hr class="hr-slots" />
                      <div class="lbdbs lbdbs_<?php echo $working_days[$j]['day_of_week']; ?>" day-of_week="<?php echo $working_days[$j]['day_of_week']; ?>" style="margin-bottom: 10px;">
                        
                      </div>

                    </div>
                    <?php } ?>
                  </div>
                </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_location_birthday_data()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function open_lb_blank(){
      var data = {};
          data.lb_id = 0;
          data.lb_location = '';
          data.lb_name = '';
          data.lb_max_kids = '';
          data.lb_max_adults = '';
          data.lb_garden = false;
          data.lb_smoking = false;
          data.lb_catering = false;
          data.lb_animators = false;
          data.lb_watching_kids = false;
          data.slots = new Array();
          open_lb_modal(data);
    }

    function open_lb_modal(data){
      $('[name="lb_id"]').val(data.lb_id);
      $('[name="lb_location"]').val(data.lb_location);
      $('[name="lb_name"]').val(data.lb_name);
      $('[name="lb_max_kids"]').val(data.lb_max_kids);
      $('[name="lb_max_adults"]').val(data.lb_max_adults);
      $('[name="lb_garden"]').prop('checked',data.lb_garden);
      $('[name="lb_smoking"]').prop('checked',data.lb_smoking);
      $('[name="lb_catering"]').prop('checked',data.lb_catering);
      $('[name="lb_animators"]').prop('checked',data.lb_animators);
      $('[name="lb_watching_kids"]').prop('checked',data.lb_watching_kids);
      $('.slot_indexes').remove();

      for(var i=0; i<data.slots.length;i++){
        var day_of_week = data.slots[i].id;
        var slots = data.slots[i].slots;
          for(var j=0;j<slots.length;j++){
            var slot = slots[j];
            add_slot(day_of_week,slot.price,slot.hours_from,slot.minutes_from,slot.hours_to,slot.minutes_to)
          }
      }

      $("#modal-location-birthday").modal();
    }

    function save_location_birthday_data(){
      var data = {};
          data.id = $('[name="lb_id"]').val();
          data.training_school = $('[name="id"]').val();
          data.ts_location = $('[name="lb_location"]').val();

          data.name = $('[name="lb_name"]').val();
          data.max_kids = $('[name="lb_max_kids"]').val();
          data.max_adults = $('[name="lb_max_adults"]').val();

          data.garden = $('[name="lb_garden"]').is(':checked') ? 1 : 0;
          data.smoking = $('[name="lb_smoking"]').is(':checked') ? 1 : 0;
          data.catering = $('[name="lb_catering"]').is(':checked') ? 1 : 0;
          data.animators = $('[name="lb_animators"]').is(':checked') ? 1 : 0;
          data.watching_kids = $('[name="lb_watching_kids"]').is(':checked') ? 1 : 0;

          var birthday_slots = new Array();
          $('.lbdbs').each(function(){
              birthday_day = {};
              birthday_day.day_of_week = $(this).attr('day-of_week');
              birthday_slots[birthday_slots.length] = birthday_day;

              var slots = new Array();
              $('.lbdbs_'+birthday_day.day_of_week).find('.slot_indexes').each(function(){
                  var slot = {};
                      slot.price = $(this).find('[name="slot_price"]').val();
                      slot.hours_from = $(this).find('[name="slot_hours_from"]').val();
                      slot.minutes_from = $(this).find('[name="slot_minutes_from"]').val();
                      slot.hours_to = $(this).find('[name="slot_hours_to"]').val();
                      slot.minutes_to = $(this).find('[name="slot_minutes_to"]').val();

                slots[slots.length] = slot;
              });

              birthday_day.slots = slots;
          });

          data.birthday_slots = birthday_slots;

          var call_url = "save_location_birthday_data";  
          var call_data = { 
            data:data 
          }  
          var callback = function(response){  
            if(response.success){  
                $("#modal-location-birthday").modal("hide");
                get_school_locations_bithdays();
            }else{  
                valid_selector = "error";
                alert(response.message);
            }
          }  
          ajax_json_call(call_url, call_data, callback); 
    }

    var slot_template = '<div class="row slot_indexes slot_index_{si}">\
                          <div class="col-sm-2 wth_input">\
                            <input type="input" class="form-control" name="slot_price">\
                          </div>\
                          <div class="col-sm-10 wth_input">\
                             <div class="row">\
                                <div class="col-sm-1 tar">From:</div>\
                                <div class="col-sm-2">\
                                  <select class="form-control" name="slot_hours_from">\
                                    <?php for ($i=0; $i <= 23; $i++) { ?>\
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                    <?php } ?>\
                                  </select>\
                                </div>\
                                <div class="col-sm-2">\
                                  <select class="form-control" name="slot_minutes_from">\
                                    <?php for ($i=0; $i <= 59; $i+=15) { ?>\
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                    <?php } ?>\
                                  </select>\
                                </div>\
                                <div class="col-sm-1 tar">To:</div>\
                                <div class="col-sm-2">\
                                  <select class="form-control" name="slot_hours_to">\
                                    <?php for ($i=0; $i <= 23; $i++) { ?>\
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                    <?php } ?>\
                                  </select>\
                                </div>\
                                <div class="col-sm-2">\
                                  <select class="form-control"  name="slot_minutes_to">\
                                    <?php for ($i=0; $i <= 59; $i+=15) { ?>\
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                    <?php } ?>\
                                  </select>\
                                </div>\
                                <div class="col-sm-1">\
                                  <a href="javascript:void(0)" onclick="remove_slot({si})">\
                                    <i class="fa fa-times"></i>\
                                  </a>\
                                </div>\
                             </div>\
                          </div>\
                        </div>';

    var global_slot_index = 999;
    function add_slot(slot_holder_id,price,hours_from,minutes_from,hours_to,minutes_to){
      
      var slot_data = slot_template;
      slot_data = slot_data.replace('{si}',global_slot_index);
      slot_data = slot_data.replace('{si}',global_slot_index);
      $('.lbdbs_'+slot_holder_id).append(slot_data);

      $('.slot_index_'+global_slot_index).find('[name="slot_price"]').val(price);
      $('.slot_index_'+global_slot_index).find('[name="slot_hours_from"]').val(hours_from);
      $('.slot_index_'+global_slot_index).find('[name="slot_minutes_from"]').val(minutes_from);
      $('.slot_index_'+global_slot_index).find('[name="slot_hours_to"]').val(hours_to);
      $('.slot_index_'+global_slot_index).find('[name="slot_minutes_to"]').val(minutes_to);

      global_slot_index++;

    }

    function remove_slot(slot_index){
      $('.slot_index_'+slot_index).remove();
    }
</script>

<style type="text/css">
  .hr-slots{
    margin-bottom: 6px;
    margin-top: 6px;
  }

  #modal-location-birthday-dialog{
    width: 65%;
  }

  .wth_input{
    height: 40px;
  }
</style>
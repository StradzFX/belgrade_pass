<?php 

  $card_numbers_all = new card_numbers();
  $card_numbers_all->set_condition('checker','!=','');
  $card_numbers_all->add_condition('recordStatus','=','O');
  $card_numbers_all->add_condition('card_taken','=','0');
  $card_numbers_all->set_order_by('pozicija','ASC');
  $card_numbers_all->set_limit(1000);
  $card_numbers_all = $broker->get_all_data_condition_limited($card_numbers_all);

  for($i=0;$i<sizeof($card_numbers_all);$i++){
  }


?>
<div class="modal fade" id="modal-change-card" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Promena broja kartice</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>Odaberite novi broj kartice</label>
            <input type="hidden" name="id" value="0">
            <select class="form-control" name="new_card_number">
              <option value=""></option>
              <?php for($i=0;$i<sizeof($card_numbers_all);$i++){ ?>
              <option value="<?php echo $card_numbers_all[$i]->id; ?>"><?php echo $card_numbers_all[$i]->card_number; ?></option>
              <?php } ?>
            </select>
            <!--PITAJ OVDE ZASTO NE VIDI PODATAK-->


          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-primary" onclick="card_change_save()">Promeni Karticu</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function card_change_save(){
    var data={};
        data.id = $('[name="user_id"]').val();
        data.card_number = $('[name="new_card_number"]').val();


    var call_url = "card_change_save";
    var call_data = {data:data}

    var callback = function(response){
      if(response.success){
          alert(response.message);
          $('#modal-change-card').modal('hide');
          location.reload();
      } else {
          alert(response.message);
        }
    }
    ajax_json_call(call_url, call_data, callback);
}

</script>
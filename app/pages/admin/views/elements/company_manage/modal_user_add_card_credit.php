<?php

$card_package_all = new card_package();
$card_package_all->set_condition('checker','!=','');
$card_package_all->add_condition('recordStatus','=','O');
$card_package_all->set_order_by('price','ASC');
$card_package_all = $broker->get_all_data_condition($card_package_all);

for($i=0;$i<sizeof($card_package_all);$i++){
}


?>
<div class="modal fade" id="modal_user_add_card_credit" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Uplata na karticu</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="id" value="0">
          <div class="col-12 col-xs-12">
            <label>
              Odredite visinu uplate
            </label>
            <select class="form-control" name="card_deposit">
              <option value=""></option>
              <?php for($i=0;$i<sizeof($card_package_all);$i++){ ?>
              <option value="<?php echo $card_package_all[$i]->id; ?>"><?php echo $card_package_all[$i]->price; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="save_card_deposit()">Izvrši uplatu</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
  function save_card_deposit(){
    var data={};
        data.id=$('[name="card_id"]').val();
        data.card_deposit_save=$('[name="card_deposit"]').val();

        var call_url="save_card_deposit"
        var call_data={data:data};
        var callback=function(response){
          if(response.success){
            alert(response.message);
            $('#modal_user_add_card_credit').modal('hide');


            $('.user_balance_info').html(response.user_balance + ' din');
            get_card_payments();

          }else{alert(response.message)};
        }
        ajax_json_call(call_url, call_data, callback);
  }
</script>
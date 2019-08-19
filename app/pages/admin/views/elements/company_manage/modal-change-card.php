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
              <option value="0022">0022</option>
              <option value="0023">0222</option>
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
        data.id = $('[name="id"]').val();
        data.card_number = $('[name="new_card_number"]').val();


    var call_url = "card_change_save";
    var call_data = {data:data}

    var callback = function(response){
      if(response.success){
          alert(response.message);
          $('#modal-change-card').modal('hide');
      } else {
          alert(response.message);
        }
    }
    ajax_json_call(call_url, call_data, callback);
}

</script>
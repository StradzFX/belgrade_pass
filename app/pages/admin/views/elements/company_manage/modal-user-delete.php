<div class="modal fade" id="modal-user-delete" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Brisanje Korisnika</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-xs-12">
            <label>
              Da li ste sigurni da želite da obrišete korisnika?
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="user_delete()">Obriši korisnika</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  function user_delete(){
  
    var data={};
        data.id = $('[name="id"]').val();


    var call_url = "user_delete";

    var call_data = {
        data:data
    }



    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          $('#modal-user-delete').modal('hide');
      }
    }
    ajax_json_call(call_url, call_data, call_back);
}

</script>
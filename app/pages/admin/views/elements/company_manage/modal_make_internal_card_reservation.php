<div class="modal fade" id="modal_make_internal_card_reservation" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Select cards to make internal reservation</h4>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="card_number_from">Available cards from</label>
                <input type="text" class="form-control" name="card_number_from">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                  <label for="card_number_to">Broj kartice do</label><br>
                  <input type="text" class="form-control" name="card_number_to">
                </div>
              </div>
            </div>
          </div>
        </section>
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad
          </button>
          <button type="button" class="btn btn-primary" onclick="get_internal_card_reservation_inputs_value()">
            Promeni
          </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function get_internal_card_reservation_inputs_value(){

  var data = {};
      data.card_number_from = $('[name = "card_number_from"]').val();
      data.card_number_to = $('[name = "card_number_to"]').val();

      call_url = 'get_internal_card_reservation_inputs_value';
      call_data = {data:data};
      call_back = function (response){
        if (response.success){
          alert(response.message);
        }else{
          alert(response.message);
        }
      }
      ajax_json_call(call_url, call_data, call_back);
}

</script>


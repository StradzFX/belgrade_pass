<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Payments
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pretraga</h3>
              <a class="btn btn-success pull-right" href="admin_payments_create/">Create new payment</a>
            </div>
            <div class="col-12 col-xs-4">
              <div class="form-group">
                <label>Ime i Prezime</label>
                  <input type="text" class="form-control" value="">
              </div>
            </div>
            <div class="col-12 col-xs-4">
              <div class="form-group">
                <label>Odobreno</label>
                <select class="form-control">
                  <option>--</option>
                  <option>Da</option>
                  <option>Ne</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-xs-4">
              <div class="form-group">
                <label>Za računovodstvo</label>
                <select class="form-control">
                  <option>--</option>
                  <option>Spremni</option>
                  <option>Nepopunjeni</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-xs-4">
              <label>Date From:</label> 
              <input type="date" class="form-control" value="2019-04-02" name="date_from" onchange="get_company_transactions()">
            </div>
            <div class="col-12 col-xs-4">
              <label>Date to:</label>
              <input type="date" class="form-control" name="date_to" onchange="get_company_transactions()">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header">
              <h3 class="box-title">Spisak uplata</h3>
            </div>
            <div class="box-body">
              <input type="hidden" name="id" value="0">
              <div class="list_of_admin_payments_holder">
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-approve">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Odobri uplatu</h4>
      </div>
      <div class="modal-body">
        <p>Da li ste sigurni da želite da odobrite uplatu?</p>
        <div class="row">
            <div class="col-12 col-xs-6">
              <div class="form-group">
                <label>Ime i prezime</label>
                <input type="text" name="name_surname" class="form-control">
              </div>
            </div>
            <div class="col-12 col-xs-6">
              <label>Datum uplate</label> 
              <input type="date" class="form-control" value="" name="date">
            </div><br>
          </div>
        </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-success" onclick="get_admin_approve_payment_data()">Odobri</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-delete-admin-payment">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Brisanje uplate</h4>
      </div>
      <div class="modal-body">
        <p>Da li ste sigurni da želite da odobrite uplatu?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
        <button type="button" class="btn btn-danger" onclick="delete_admin_payment()">Obriši</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<style type="text/css">

</style>
<script type="text/javascript">
    /*function approve_post_office(id){
      var confirm_result = confirm('Are you sure you want to approve this transaction?');

      var data = {};
          data.id = id;

      if(confirm_result){
        var call_url = "approve_post_office";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
        if(response.success){  
            valid_selector = "success"; 
            document.location = master_data.base_url+'post_office/';
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }*/
    function  delete_admin_payment(){
        alert('Uplata obrisana');
        $('#modal-delete-admin-payment').modal('hide');
    }

    function get_list_of_admin_payments(){
      var data={};
          data.id=$('[name="id"]').val();

      var call_url='get_list_of_admin_payments';
      var call_data={data:data}
      var callback = function(response){
        $('.list_of_admin_payments_holder').html(response);
      }
      ajax_call(call_url, call_data, callback);

    }

    $(function(){
      get_list_of_admin_payments()
    });

    function  get_admin_approve_payment_data(){
      var data={};
          data.id=$('[name="id"]').val()
          data.name_surname=$('[name="name_surname"]').val();
          data.date=$('[name="date"]').val()

      var call_url='get_admin_approve_payment_data'
      var call_data={data:data}
      var call_back=function(response){
        if (response.success){
          alert(response.message)
        }else{
          alert(response.message)
        }
      }
      ajax_json_call(call_url, call_data, call_back)
    }


</script>
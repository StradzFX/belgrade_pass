<div class="content-wrapper" style="min-height: 960px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Post Office Payments
    </h1>
  </section>
    <!-- Main content -->
  <section class="content">
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
          <label>Poziv na broj</label>
            <input type="text" class="form-control" value="">
        </div>
      </div><div class="col-12 col-xs-4">
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
    <div class="box box-primary">
    <div class="box">
      <div class="box-header">
      </div>
      <div class="box-body">
        <input type="hidden" name="id" value="0">
        <div class="list_of_postoffice_payments_holder">
          
        </div>
      </div>
    </div>
  </section>
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

<div class="modal fade" id="modal_create_postoffice_payment">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Odobri uplatu</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
              <div class="col-12 col-xs-12">
                <div class="box box-primary">
                  <!-- form start -->
                  <form role="form">
                    <div class="box-body">
                      <div class="row">
                        <div class="col col-md-6">
                          <div class="form-group">
                            <label for="field_name">Card number</label>
                            <select class="form-control" name="card_number">
                            </select>
                          </div>
                        </div>
                        <div class="col col-md-6">
                          <div class="form-group">
                            <label for="field_name">Search cards by user (email, name)</label>
                            <input type="text" class="form-control" name="user_search" onkeyup="filter_data_user()" />
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="field_name">Package</label>
                        <select class="form-control" name="package" onchange="select_price()">
                          <option value="">Select package</option>
                          <?php for ($i=0; $i < sizeof($card_package_all); $i++) { ?> 
                            <option value="<?php echo $card_package_all[$i]->id; ?>,<?php echo $card_package_all[$i]->price; ?>"><?php echo $card_package_all[$i]->name; ?> - <?php echo $card_package_all[$i]->number_of_passes; ?> passes</option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="field_name">Price (change if you need)</label>
                        <input type="text" class="form-control" disabled="disabled" name="price"/>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </form>
                </div>
                <!-- /.box -->
              </div>
              <!--/.col (left) -->
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
</div>

<div class="modal fade" id="modal-delete-post-office-payment">
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
        <button type="button" class="btn btn-danger" 
        onclick="delete_post_office_payment()">Obriši</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<style type="text/css">
  .table i{
    border-radius: 5px;
    border: 1px solid #3c8dbc;
    padding: 5px;
  }

  .table i:hover{
    color:#fff;
    background-color: #3c8dbc;
  }
</style>
<script type="text/javascript">
    function approve_post_office(id){
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
    }

    function  delete_post_office_payment(){
        alert('Uplata obrisana');
        $('#modal-delete-post-office-payment').modal('hide');
    }



    function get_list_of_postoffice_payments(){
      var data={};
          data.id=$('[name="id"]').val();

      var call_url='get_list_of_postoffice_payments';
      var call_data={data:data}
      var callback = function(response){
        $('.list_of_postoffice_payments_holder').html(response);
      }
      ajax_call(call_url, call_data, callback);

    }

    $(function(){
      get_list_of_postoffice_payments()
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
<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php'; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <input type="hidden" name="id" value="0">
      <h1>
        Company Profile
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile"> 
              <h3 class="profile-username text-center"><i class="fa fa-building"></i> Prasad & Sons</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>PIB</b> <a class="pull-right">123456</a>
                </li>
                <li class="list-group-item">
                  <b>Matični broj</b> <a class="pull-right">246810121416</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">prasad@gmail.com</a>
                </li>
                <li class="list-group-item">
                  <b>Adress</b> <a class="pull-right">Gornje pruge bb</a>
                </li>
              </ul>
                <a href="#" class="btn btn-danger btn-block" data-toggle="modal"
                data-target="#modal-user-delete"
                ><b>Obriši korisnika</b></a>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            
          <!-- About Me Box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Izmeni podatke</a></li>
              <li><a href="#cards_all" data-toggle="tab">Kartice</a></li>
              <li><a href="#bills" data-toggle="tab">Računi</a></li>
              <li><a href="#settings" data-toggle="tab">Transakcije</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="company_name">Naziv preduzeća:</label>
                      <input type="text" name="company_name" class="form-control" value="Prasad & Sons">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="adress">Adresa:</label>
                      <input type="text" name="adress" class="form-control" value="Gornje pruge bb">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="pib">PIB:</label>
                      <input type="text" name="pib" class="form-control" value="123456">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="personal_nr">Matični:</label>
                      <input type="text" name="personal_nr" class="form-control" value="246810121416">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="text" name="email" class="form-control" value="prasad@gmail.com">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="pass">Lozinka:</label>
                      <input type="password" name="pass" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="confirm_pass">Ponovi Lozinku:</label>
                      <input type="password" name="confirm_pass" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <a href="javascript:void(0)" onclick="save_legal_user_data()" class="btn btn-primary pull-right" 
                    >
                      Sačuvaj
                    </a>
                    <a href="users_all/">
                      <div class="btn btn-default">Nazad</div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="cards_all">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search by card number:</label>
                        <input type="text" class="form-control" value="example 000022">
                    </div>
                  </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Search by user name:</label>
                        <input type="text" name="search_user_name" class="form-control">
                      </div>
                    </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Search by email:</label>
                          <input type="text" class="form-control" value="Email" name="search_email">
                      </div>
                    </div>
                  </div><br>
                <div class="company_cards_holder">
                  
                </div>
              </div>
              <div class="tab-pane" id="bills">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search by email:</label>
                        <input type="text" class="form-control" value="Email" name="mail_search" onkeyup="get_company_billings()">
                    </div>
                  </div>
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search card number:</label>
                        <input type="text" class="form-control" value="br kartice 000022" name="card_search" onkeyup="get_company_billings()">
                    </div>
                  </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Transaction number</label>
                        <input type="text" name="transactio_number" class="form-control">
                      </div>
                    </div>
                </div><br>
                <div class="company_billings_holder">
                  
                </div>
              </div>
              <div class="tab-pane" id="settings">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <label>Date From:</label> 
                    <input type="date" class="form-control" value="2019-04-02" name="date_from" onchange="get_company_transactions()">
                  </div>
                  <div class="col-12 col-xs-3">
                    <label>Date to:</label>
                    <input type="date" class="form-control" name="date_to" onchange="get_company_transactions()">
                  </div>
                  <div class="col-12 col-xs-3">
                    <label for="card_number">Search by card number</label>
                    <input type="text" name="card_number" class="form-control" value="example 000022">
                  </div>
                  <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Payments</label>
                        <select  class="form-control">
                          <option>Sve</option>
                          <option>Uplate</option>
                          <option>Potrošnja</option>
                        </select>
                      </div>
                    </div>
                </div><br>
                <div class="company_transactions_holder">
                  
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

  <style type="text/css">
    
    .pic-frame{
       background-size: cover;
    }

    img {
    max-width: 100%;
    }

  </style>

<script type="text/javascript">
  
  function save_legal_user_data(){

    var podaci = {};
        podaci.ime = $('[name="company_name"]').val();
        podaci.adresa = $('[name = "adress"]').val();
        podaci.pib = $('[name = "pib"]').val();
        podaci.maticni_broj = $('[name = "personal_nr"]').val();
        podaci.mejl = $('[name = "email"]').val();

    var call_url = "save_legal_user_data"

    var call_data = {
      data:podaci
    }

    var callback = function(response){
      if(response.success){
        alert(response.message);
      } else {
        alert(response.message);
      }
    }

    ajax_json_call(call_url, call_data, callback);

  }

function get_company_transactions(){

  var data={};
      data.date_from = $('[name="date_from"]').val();
      data.date_to = $('[name="date_to"]').val();

  var call_url = 'get_company_transactions';
  var call_data = {data:data};

  var call_back = function(odgovor){
    $('.company_transactions_holder').html(odgovor);
  }
  ajax_call(call_url, call_data, call_back);
}

$(function(){
  get_company_transactions();
});



function  get_company_billings(){
  var data={};
      data.id = $('[name = "id"]').val();

  var call_url='get_company_billings';
  var call_data={data:data};
  var callback = function(response){
    $('.company_billings_holder').html(response);
  }

  ajax_call(call_url, call_data, callback);
}

$(function(){
    get_company_billings();
  });


function get_company_cards(){
  var data={};
      data.id = $('[name="id"]').val();
  

  var call_url = "get_company_cards";
  var call_data ={data:data}
  var callback = function(response){
    $('.company_cards_holder').html(response);
  }
  ajax_call(call_url, call_data, callback);
}

$(function(){
  get_company_cards();
});
</script>
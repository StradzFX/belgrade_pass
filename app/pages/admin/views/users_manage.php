d<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_user_add_card_credit.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal-change-card.php';?>

<div class="content-wrapper">
  <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> <?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Tip Korisnika</b> <a class="pull-right">Fizičko lice</a>
                </li>
                <li class="list-group-item" style="height: 50px">
                  <b>Email</b> <a class="" ><?php echo $user->email; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Kartica br:</b> <a class="pull-right"><?php echo $user_card->card_number; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Preostalo kredita</b> <a class="pull-right"><?php echo $user_balance; ?> din</a>
                </li>
                <li class="list-group-item">
                  <div class="pic-frame">
                      <img src="../files/qr_codes/<?php echo $user_card->card_number; ?>.png">
                  </div>
                </li>
              </ul>

              <a href="card_info/<?php echo $user_card->id; ?>" class="btn btn-primary btn-block"><b>Pogledaj karticu</b></a>

              <a href="javascript:void(0)" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal-change-card"><b>Promeni karticu</b></a>
              <a href="javascript:void(0)" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-user-delete"><b>Obriši korisnika</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Izmeni podatke</a></li>
              <li><a href="#deposits" data-toggle="tab">Uplate</a></li>
              <li><a href="#charges" data-toggle="tab">Potrošnja</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="name">Ime:</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php echo $user->first_name; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="surname">Prezime:</label>
                      <input type="text" name="surname" id="surname" class="form-control" value="<?php echo $user->last_name; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group list-group-item-email">
                      <label for="mail">Email</label>
                      <input type="text" name="mail" id="mail" class="form-control" value="<?php echo $user->email; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="password_one">Lozinka</label>
                      <input type="password" name="password_one" class="form-control" id="password_one" value="">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="password_two">Ponovi Lozinku</label>
                      <input type="password" name="password_two" id="password_two" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <a href="javascript:void(0)" class="btn btn-primary pull-right" onclick="save_user_data()">
                      Sačuvaj
                    </a>
                    <a href="users_all/">
                      <div class="btn btn-default">Nazad</div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="deposits">
                  <div class="row">
                    <div class="col-12 col-xs-12 user_deposits_holder">
                      
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="charges">
                <div class="row">
                  <div class="col col-xs-3">
                    <label>Date From:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d',strtotime('-1 year')); ?>" name="charges_date_from" onchange="get_user_charges()">
                  </div>
                  <div class="col col-xs-3">
                    <label>Date to:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="charges_date_to" onchange="get_user_charges()">
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12 user_charges_holder">
                    
                  </div>
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

    .list-group-item-email{
       height: 50px;
    }
    
    .pic-frame{
       background-size: cover;
    }

    img {
    max-width: 100%;
    }

  </style>


<script type="text/javascript">
  
  //FUKCIJA AJAX JSON KOJA CUVA PODATKE
  function save_user_data(){

    //podaci koji se prosledjuju u PHP
    var data = {};
        data.id = $('[name="user_id"]').val();
        data.name = $('[name="name"]').val();
        data.surname = $('[name="surname"]').val();//name se odnosi na atribut name, ne na naziv varijabile 
        data.email = $('[name="mail"]').val();
        data.password_one = $('[name="password_one"]').val();
        data.password_two = $('[name="password_two"]').val();

    // PHP stranica koja se poziva putem ajaxa
    var call_url = "save_user_data"; 
  
    // ovde prosledjujemo podatke iz funkcije u ajax tj u php 
    var call_data = { //gde je prva data naziv varijabile u php fajlu, a druga data naziv varijbile u java scriptu
      data:data 
    }  

    // ovde pisemo sta se radi nakon zavrsenog poziva PHP stranice
    var callback = function(response){  
      //response im po defaultu dva podatka, success i message
      //success moze da bude true ili false, message je poruka definisana u PHP

      if(response.success){  
          //napisemo sta radimo kada je sve ok
          alert(response.message);
          location.reload();
      }else{  
          //napisemo sta radimo kada postoji problem
          alert(response.message);
      }  

    }  
    ajax_json_call(call_url, call_data, callback); 
  }


  function get_user_charges(){

    var data = {};
        data.id = $('[name="user_id"]').val();
        data.date_from = $('[name="charges_date_from"]').val();
        data.date_to = $('[name="charges_date_to"]').val();

    var call_url = "get_user_charges";

    var call_data = {data:data}

    var callback = function(response){
      $('.user_charges_holder').html(response);
    }

    ajax_call(call_url, call_data, callback); 

  }

  //on document load - kada se ucita ceo HTML, onda pokreni automatski ovu funkciju
  $(function(){
    get_user_charges();
  });


  function get_user_deposits(){
    var data = {};
        data.id = $('[name="user_id"]').val();

    var call_url = "get_user_deposits";
    var call_data = {
      data:data
    }
    var callback = function(response){
      $('.user_deposits_holder').html(response);
      }
    ajax_call(call_url, call_data, callback);
  }

  function approve_purchase(id){

    var data = {};
        data.id = id;

    var call_url = "approve_post_office"; 

    var call_data = {
      data:data 
    }  

    var callback = function(response){  
      if(response.success){  
          get_user_deposits();
      }else{  
          alert(response.message);
      }  
    }  
    ajax_json_call(call_url, call_data, callback); 
  }

  

  $(function(){
    get_user_deposits();
  });

</script>
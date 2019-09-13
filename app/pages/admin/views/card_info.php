<?php include_once 'app/pages/admin/views/elements/company_manage/modal-change-card.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_user_add_card_credit.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_user_send_pin.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_card_deactivate.php';?>

<div class="content-wrapper">
    <input type="hidden" name="card_id" value="<?php echo $user_card->id; ?>">
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> Podaci o kartici</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Tip Kartice</b> <a class="pull-right">
                    <?php echo $card_type; ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Tip Korisnika</b> <a class="pull-right">
                    <?php echo $user->user_type == 'fizicko' ? 'Fizičko lice' : 'Pravno lice'; ?>
                  </a>
                </li>
                <li class="list-group-item list-group-item-email">
                  <b>Email</b> <a class=""><?php echo $user_card->email; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Kartica br:</b> <a class="pull-right"><?php echo $user_card->card_number; ?></a>
                </li>
                <li class="list-group-item">
                  <b>PIN</b> <a class="pull-right"><?php echo $user_card->card_password; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Preostalo kredita</b> <a class="pull-right user_balance_info"><?php echo $user_balance; ?> din</a>
                </li>
                <li class="list-group-item">
                  <div class="pic-frame">
                      <img src="../files/qr_codes/<?php echo $user_card->card_number; ?>.png">
                  </div>
                </li>
              </ul>
              <a href="users_manage/<?php echo $user_card->user; ?>/" class="btn btn-warning btn-block"><b>Pogledaj korisnika</b></a>
              <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_user_add_card_credit"><b>Uplati kredit</b></a>
              <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_user_send_pin"><b>Pošalji PIN na Email</b></a>
              <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal_card_deactivate"><b>Deaktiviraj karticu</b></a>
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
              <li><a href="#payments" data-toggle="tab">Uplate</a></li>
              <li><a href="#charges" data-toggle="tab">Potrošnja</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="name">Ime:</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $user_card->parent_first_name; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="surname">Prezime:</label>
                      <input type="text" name="surname" class="form-control" value="<?php echo $user_card->parent_last_name; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="mail">Email</label>
                      <input type="text" name="mail" class="form-control" value="<?php echo $user_card->email; ?>">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <a href="javascript:void" onclick="save">
                      <div class="btn btn-primary pull-right" onclick="save_card_user_data()">Sačuvaj</div>
                    </a>
                    <a href="users_all/">
                      <div class="btn btn-default">Nazad</div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="payments">
                <div class="get_card_payments_holder">
                  
                </div>
              </div>
              <div class="tab-pane" id="charges">
                <div class="row">
                  <div class="col col-xs-3">
                    <label>Date From:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d',strtotime('-1 year')); ?>" name="date_from" onchange="get_card_usage()">
                  </div>
                  <div class="col col-xs-3">
                    <label>Date to:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date_from" onchange="get_card_usage()">
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12 get_report_card_usage_holder">

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
    
    function save_card_user_data(){

    //podaci koji se prosledjuju u PHP
    var data = {};
        data.id = $('[name="card_id"]').val();
        data.name = $('[name="name"]').val();
        data.surname = $('[name="surname"]').val();
        data.mail = $('[name="mail"]').val();

    var call_url = "save_card_user_data"; 
    var call_data = {data:data }  
    var callback = function(response){  
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


  function get_card_usage(){

    var filters = {};
        filters.card_id = $('[name="card_id"]').val();
        filters.date_from = $('[name="date_from"]').val();
        filters.date_to = $('[name="date_to"]').val();
        filters.company = $('[name="company"]').val();
        filters.user_search = $('[name="user_search"]').val();

    var call_url = "get_report_card_usage";  
    var call_data = { 
      data:filters 
    }  
    var callback = function(response){  
      $('.get_report_card_usage_holder').html(response);
    }  
    ajax_call(call_url, call_data, callback); 
  }




  function get_card_payments(){
    var data = {};
        data.id = $('[name="card_id"]').val();

    var call_url = "get_card_payments";  
    var call_data = { 
      data:data 
    }  
    var callback = function(response){  
      $('.get_card_payments_holder').html(response);
    }  
    ajax_call(call_url, call_data, callback); 
  }

  $(function(){
    get_card_payments();
    get_card_usage();
  });


  </script>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_repeat_transaction.php';?>


<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post office payment detail
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> Podaci o uplati</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item" id="pass_amount">
                  <b>Uplaćeno passova</b> <a class="pull-right">2000</a>
                </li>
                <li class="list-group-item" id="payment_date">
                  <b>Datum uplate</b> <a class="pull-right">21.08.2019</a>
                </li>
                <li class="list-group-item" id="number_to_call">
                  <b>Poziv na broj</b> <a class="pull-right">22/2019</a>
                </li>
                <li class="list-group-item" id="card_number">
                  <b>Broj Kartice</b> <a class="pull-right">0022</a>
                </li>
                <li class="list-group-item" id="user">
                  <b>Korisnik</b> <a class="pull-right">Marko Markovic</a>
                </li>
                <li class="list-group-item" id="email">
                  <b>Email</b> <a class="pull-right">pavle_car@gmail.com</a>
                </li>
                <li class="list-group-item" id="phone_nr">
                  <b>Telefon</b> <a class="pull-right"></a>
                </li>
                <li class="list-group-item" id="invoice_pic">
                  <a target="_blank" href="/belgrade_pass/pictures/uplatnica-1">
                    <img src="/belgrade_pass/pictures/uplatnica-1">
                  </a>
                </li>
              </ul>
              <a href="javascript:void(0)" class="btn btn-warning btn-block"><b>Ukloni kopiju uplatnice</b></a>
              <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_delete_invoice_copy"><b>Postavi kopiju uplatnice</b></a><br>
              <div class="row">
                <div class="col-12 col-xs-6">
                  <a href="post_office/" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Nazad</a>
                </div>
                <div class="col-12 col-xs-6 pull-right">
                  <a href="javascript:void(0)" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_repeat_transaction">Ponovi uplatu <i class="fas fa-redo-alt"></i></a>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body">
              <input type="hidden" name="id" value="0">
              
              <div class="row">
                <div class="col-12 col-xs-12">
                  <h4 class="box-title">Ostale transakcije za izabranu karticu</h4>
                </div>
                <div class="col-12 col-xs-12 same_card_payments_holder">    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<div class="modal fade in" id="modal_delete_invoice_copy">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">...</button>
          <h4 class="modal-title">Odaberite datoteku</h4>
        </div>
        <div class="modal-body">
          <input type="file" name="new_image" 
          onchange="readURL(this);">
        </div>
        <div class="image-previewe"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left"
          data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" 
          onclick="add_image()">Upload</button>
        </div>
      </div>
    </div>
  </div>

<style type="text/css">

  img{max-width: 100%;}

  .all_items a.action{
    display: inline-block;
    border-radius: 3px;
      
    
    text-align: center;
    color: #fff;
  }


  .all_items a.stats{
    display: inline-block;
    border-radius: 3px;
    
    text-align: center;
    
   
  }

  .all_items a.stats:hover{
    background-color: #c0eaff;
  }

  .red{
    color: gold;
  }


  .silver{
    color: gray;
  }
</style>

<script type="text/javascript">
    function get_same_card_payments(){
      var data={};
          data.id=$('[name="id"]').val();

      var call_url='get_same_card_payments';
      var call_data={data:data}
      var call_back=function(response){
        $('.same_card_payments_holder').html(response);
      }
      ajax_call(call_url, call_data, call_back);
    }

$(function(){
  get_same_card_payments();
});
</script>
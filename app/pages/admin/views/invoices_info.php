<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_repeat_transaction.php';?>


<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoice payment detail
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> Podaci o fakturi</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Broj fakture:</b> <a class="pull-right" name="invocie_number">000022</a>
                </li>
                <li class="list-group-item">
                  <b>Račun broj</b> <a class="pull-right" name="account_number">123456</a>
                </li>
                <li class="list-group-item">
                  <b>Iznos</b> <a class="pull-right" name="invocie_value">2150 din</a>
                </li>
                <li class="list-group-item">
                  <b>Datum izdavanja</b> <a class="pull-right" name="invocie_date">20.08.2019</a>
                </li>
                <li class="list-group-item">
                  <b>Poziv na broj</b> <a class="pull-right" name="invoice_call_number">01/01-003-19</a>
                </li>
                <li class="list-group-item">
                  <b>PIB</b> <a class="pull-right" name="company_personal_number">108895725</a>
                </li>
                <li class="list-group-item" id="invoice_pic">
                  <a target="_blank" href="/belgrade_pass/pictures/0001">
                    <img src="/belgrade_pass/pictures/0001">
                  </a>
                </li>
              </ul>
              <a href="javascript:void(0)" class="btn btn-warning btn-block"><b>Ukloni kopiju fakture</b></a>
              <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_delete_invoice_copy"><b>Postavi kopiju fakture</b></a>
              <a href="invoices/" class="btn btn-primary btn-block"><b>Nazad</b></a>
              
              
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
                  <h4 class="box-title">Fakture za datu firmu</h4>
                </div>
                <div class="col-12 col-xs-12 same_card_payments_holder">
                      
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>  
    <div>
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
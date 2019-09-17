<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_repeat_transaction.php';?>


<div class="content-wrapper" style="min-height: 960px;">
  <input type="hidden" name="single_payment_id" value="<?php echo $id ?>">
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
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> Podaci o uplati</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Id transakcije</b> <a class="pull-right">
                    <?php echo $list->id ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Iznos transakcije</b> <a class="pull-right">
                    <?php echo $list->price ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Datum transakcije</b> <a class="pull-right">
                    <?php echo $list->po_payment_date ?>
                  </a>
                </li>
                <li class="list-group-item list-group-item-email">
                  <b>Ime i prezime</b> <a class="pull-right"><?php echo $list->po_payment_name; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Kartica br:</b> <a class="pull-right"><?php echo $list->user_card; ?></a>
                </li>
              </ul>
              <div>
                
              </div>
              <a href="users_manage/<?php echo $list->user; ?>/" class="btn btn-warning btn-block"><b>Pogledaj korisnika</b></a>

            
             
  <!--<?php if ($list[$i]->status != 'Approved'){ ?>
                <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_approve_post_office_payment" onclick="set_approve_id(<?php echo $list[$i]->id; ?>)"><b>Odobri transakciju</b></a>
              <?php }else{ ?>
                 <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal_recall_post_office_transaction" onclick="set_post_office_transaction_id(
                <?php echo $list[$i]->id;?>)"><b>Opozovi transakciju</b></a>
               <?php } ?>
            -->
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-12 col-xs-12">
                  <h4 class="box-title">View image</h4>
                </div>
                <div class="col-12 col-xs-12 single_payment_picture_holder">
                      
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /.col -->
      </div>
          
    <div>
    </section>
    <!-- /.content -->
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

function get_single_payment_picture(){
      var data={};
          data.id=$('[name="single_payment_id"]').val();


      var call_url='get_single_payment_picture';
      var call_data={data:data}
      var call_back=function(response){
        $('.single_payment_picture_holder').html(response);
      }
      ajax_call(call_url, call_data, call_back);
    }

$(function(){
  get_single_payment_picture();
});


</script>



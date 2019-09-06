<?php include_once 'app/pages/admin/views/elements/company_manage/modal_make_internal_card_reservation.php'; ?>
<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List of cards for internal usage
      </h1>
    </section>
<input type="hidden" name="reservation_id" value="0">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>

              <a href="javascript:void(0)" class="btn btn-warning pull-right"  data-toggle="modal" 
              data-target="#modal_make_internal_card_reservation">Make reservations</a>
              <a class="btn btn-success pull-right" style="margin-right: 10px;" href="internal_card_assign/">Assign new card</a>


            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <input type="hidden" name="id" value="0">
              <div class="internal_cards_all_holder">
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">


  function get_internal_cards_all(){
    var data={};
        data.id=$('[name="id"]').val();

    var call_url='get_internal_cards_all';
    var call_data={data:data};
    var callback=function(response){
      $('.internal_cards_all_holder').html(response);
    }
    ajax_call(call_url, call_data, callback);
  }

  $(function(){
    get_internal_cards_all();
  });
</script>

<style type="text/css">
  .table i{
    border-radius: 5px;
  }

  .table i:hover{
    color:#fff;
    background-color: #3c8dbc;
  }
</style>
<?php include_once 'app/pages/admin/views/elements/company_manage/modal_print_invoice_pdf.php';?>

<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoices
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Pretraga</h3>
        </div>
        <div class="col-12 col-xs-4">
          <div class="form-group">
            <label>Broj fakture</label>
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
          <label>Datum(od)</label> 
          <input type="date" class="form-control" value="2019-04-02" name="date_from" onchange="get_company_transactions()">
        </div>
        <div class="col-12 col-xs-4">
          <label>Datum(do)</label>
          <input type="date" class="form-control" name="date_to" onchange="get_company_transactions()">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        </div>
        <!-- /.box-body -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Sve Fakture</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <input type="hidden" name="id" value="0">
              <div class="invoices_holder">
                
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
<style type="text/css">

</style>
<script type="text/javascript">

    
    function get_invoices(){
      var data={};
          data.id=$('[name="id"]').val();

      var call_url='get_invoices';
      var call_data={data:data}
      var callback=function(response){
        $('.invoices_holder').html(response);
       }
       ajax_call(call_url, call_data, callback)
      }

      $(function(){
        get_invoices()
      });

</script>
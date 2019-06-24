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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of payments</h3>

              <a class="btn btn-success pull-right" href="admin_payments_create/">Create new payment</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 100px;">Purchase no.</th>
                  
                  <th>Card number</th>
                  <th>User</th>
                  <th>Package</th>
                  <th>Number of passes</th>
                  <th>Price</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $list[$i]->id; ?></td>
                    
                    <td><?php echo $list[$i]->user_card->card_number; ?></td>
                    <td><?php echo $list[$i]->user->email; ?></td>
                    <td><?php echo $list[$i]->card_package->name; ?></td>
                    <td><?php echo $list[$i]->number_of_passes; ?></td>
                    <td><?php echo $list[$i]->price; ?> RSD</td>
                  </tr>
                <?php } ?>
                
              </tbody></table>
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
</script>
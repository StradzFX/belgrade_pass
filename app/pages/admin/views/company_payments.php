<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Partner payments
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 100px;">Purchase no.</th>
                  <th>Partner</th>
                  <th>User</th>
                  <th>Status</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $list[$i]->id; ?>.</td>
                    <td><?php echo $list[$i]->company->name; ?></td>
                    <td><?php echo $list[$i]->user->email; ?></td>
                    <td><?php echo $list[$i]->status; ?></td>
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

<script type="text/javascript">
    function remove_item(id){
      var confirm_result = confirm('Are you sure you want to delete this item?');

      var delete_data = {};
          delete_data.section = 'coaches';
          delete_data.id = id;

      if(confirm_result){
        var call_url = "delete_item";  
        var call_data = { 
          delete_data:delete_data 
        }  
        var callback = function(response){  
        if(response.success){  
            valid_selector = "success"; 
            document.location = master_data.base_url+'categories_all/';
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }
</script>
<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transactions with companies
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>
              <div class="pull-right">
                <a href="company_transaction_manage/" class="btn btn-success">New transaction</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped all_items">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Trn. Date</th>
                  <th>Company</th>
                  <th>Trn. Type</th>
                  <th>Value</th>
                  <th style="width: 150px">Actions</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $i+1; ?>.</td>
                    <td><?php echo date('d.m.Y.',strtotime($list[$i]->transaction_date)); ?></td>
                    <td><?php echo $list[$i]->company->name; ?></td>
                    <td><?php echo $list[$i]->transaction_type; ?></td>
                    <td><?php echo $list[$i]->transaction_value; ?></td>
                    <td>
                        <a href="company_transaction_manage/<?php echo $list[$i]->id; ?>">
                          <i class="fa fa-pencil" title="Edit"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="remove_item(<?php echo $list[$i]->id; ?>)">
                          <i class="fa fa-trash" title="delete"></i>
                        </a>
                    </td>
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
  .all_items a{
    display: inline-block;
    border-radius: 3px;
    background-color: #bbbfc1;
    width: 20px;
    text-align: center;
    color: #000;
  }
  .red{
    color: gold;
  }


  .silver{
    color: gray;
  }
</style>

<script type="text/javascript">
    function remove_item(id){
      var confirm_result = confirm('Are you sure you want to delete this item?');

      var delete_data = {};
          delete_data.section = 'company_transaction';
          delete_data.id = id;

      if(confirm_result){
        var call_url = "delete_item";  
        var call_data = { 
          delete_data:delete_data 
        }  
        var callback = function(response){  
        if(response.success){  
            valid_selector = "success"; 
            document.location = master_data.base_url+'company_transactions/';
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }
</script>
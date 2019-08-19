<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List of companies
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
              <table class="table table-striped all_items">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Card Usage (Passes)</th>
                  <th style="width: 150px">Actions</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $list[$i]->id; ?>.</td>
                    <td><?php echo $list[$i]->name; ?></td>
                    <td><?php echo $list[$i]->category_name; ?></td>
                    <td>
                      <a href="report_card_usage/?company=<?php echo $list[$i]->id; ?>" class="stats">
                        <?php echo $list[$i]->card_usage_total; ?> times used
                      </a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="action" onclick="promote_school(<?php echo $list[$i]->id; ?>)">
                          <div class="btn btn-primary">
                            <i class="fa fa-star <?php if($list[$i]->promoted){ ?>red<?php }else{ ?>silver<?php } ?>" title="Edit"></i>
                          </div>
                        </a>

                        <a href="company_manage/<?php echo $list[$i]->id; ?>" class="action">
                          <div class="btn btn-primary">
                            <i class="fas fa-edit" title="Edit"></i>
                          </div>
                        </a>
                        <a href="javascript:void(0)" class="action" onclick="remove_item(<?php echo $list[$i]->id; ?>)">
                          <div class="btn btn-primary">
                            <i class="fa fa-trash" title="delete"></i>
                          </div>
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
  .all_items a.action{
    display: inline-block;
    border-radius: 3px;
    background-color: #bbbfc1;
    text-align: center;
    color: #000;
  }


  .all_items a.stats{
    display: inline-block;
    border-radius: 3px;
    background-color: #bbbfc1;
    text-align: center;
    padding: 2px 5px;
    color: #000;
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
    function promote_school(id){
      var data = {};
          data.id = id;

      var call_url = "school_promote";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          document.location = master_data.base_url+'company_all/';
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }

    function remove_item(id){
      var confirm_result = confirm('Are you sure you want to delete this item?');

      var delete_data = {};
          delete_data.section = 'schools';
          delete_data.id = id;

      if(confirm_result){
        var call_url = "delete_item";  
        var call_data = { 
          delete_data:delete_data 
        }  
        var callback = function(response){  
        if(response.success){  
            valid_selector = "success"; 
            document.location = master_data.base_url+'company_all/';
        }else{  
            valid_selector = "error";
            alert(response.message);
        }  

        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }
</script>
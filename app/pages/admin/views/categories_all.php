<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List categories
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
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Icon</th>
                  <th>Popularity</th>
                  <th style="width: 150px">Actions</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $list[$i]->id; ?>.</td>
                    <td><?php echo $list[$i]->name; ?></td>
                    <td><img src="../public/images/icons/<?php echo $list[$i]->logo; ?>"></td>
                    <td><?php echo $list[$i]->popularity; ?> points</td>
                    <td>
                      
                        <a href="categories_manage/<?php echo $list[$i]->id; ?>">
                          <div class="btn btn-primary">
                            <i class="fas fa-edit" title="Edit"></i>
                          </div>
                        </a>
                        <a href="javascript:void(0)" onclick="remove_item(<?php echo $list[$i]->id; ?>)">
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

<script type="text/javascript">
    function remove_item(id){
      var confirm_result = confirm('Are you sure you want to delete this item?');

      var delete_data = {};
          delete_data.section = 'categories';
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
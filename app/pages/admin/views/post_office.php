<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Office Payments
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
                  <th>Price</th>
                  <th>Card number</th>
                  <th>User</th>
                  <th style="width: 150px">Actions</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $list[$i]->id; ?></td>
                    <td><?php echo $list[$i]->price; ?> RSD</td>
                    <td><?php echo $list[$i]->user_card->card_number; ?></td>
                    <td><?php echo $list[$i]->user->email; ?></td>
                    <td>

                      <?php if($list[$i]->status != 'Approved'){ ?>
                      <a href="javascript:void(0)" onclick="approve_post_office(<?php echo $list[$i]->id; ?>)">
                        <div class="btn btn-default">
                          <i class="fa fa-thumbs-up" title="Approve"></i>
                        </div>
                      </a>
                      <?php }else{ ?>
                      <div class="btn btn-primary" disabled>
                        <i class="fa fa-thumbs-up" title="Approved"></i>
                      </div>
                      <?php } ?>
                      

                      <?php /*<a href="categories_manage/<?php echo $list[$i]->id; ?>">
                        <i class="fa fa-pencil" title="Edit data"></i>
                      </a>*/ ?>

                        
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
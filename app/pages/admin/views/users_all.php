<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>

<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="row">
            		<div class="col-12 col-xs-3">
		            	<div class="form-group">
		            		<label>Search card number:</label>
		                	<input type="text" class="form-control" value="example 000022">
		            	</div>
		            </div>
            		<div class="col-12 col-xs-3">
		            	<div class="form-group">
		            		<label>Search by name:</label>
		                	<input type="text" class="form-control" value="Name">
		            	</div>
		            </div>
		            <div class="col-12 col-xs-3">
		            	<div class="form-group">
		            		<label>Search by email:</label>
		                	<input type="text" class="form-control" value="Email">
		            	</div>
		            </div>
	              	<div class="col-12 col-xs-3">
		              	<div class="form-group">
		                  <label>User type</label>
		                  <select class="form-control">
		                    <option>All</option>
		                    <option>Pravna lica</option>
		                    <option>Fizička lica</option>
		                  </select>
		              	</div>
	              	</div>
	            </div><br>
	            <div class="row">
	            	<div class="col-12 col-xs-12">
	            		<table class="table table-striped all_items">
			                <tbody>
				                <tr>
				                  <th style="width: 10px">#</th>
				                  <th>User type</th>
				                  <th>Name</th>
				                  <th>Email</th>
				                  <th style="width: 150px">Actions</th>
				                </tr>
				                <tr>
				                	<td>1.</td>
				                	<td><i class="fa fa-user"></i> Fizičko lice</td>
				                	<td>Pavle Jovanovic</td>
				                	<td>nikola@weblab.co.rs</td>
				                	<input type="hidden" name="id" value="0">
				                	<td>
				                		<div class="btn btn-primary">
				                			<a href="javascript:void(0)" class="action">
				                          	<i class="fa fa-star" title="Edit"></i>
				                        	</a>
				                		</div>
				                        <div class="btn btn-primary">
					                        <a href="users_manage/" class="action">
					                          <i class="fas fa-edit"></i>
					                        </a>
				                        </div>
				                        <div class="btn btn-primary">
					                        <a href="javascript:void(0)" class="action" data-toggle="modal" data-target="#modal-user-delete">
					                          <i class="fa fa-trash" title="delete">
					                          </i>
					                        </a>
				                    	</div>
				                    </td>
				                </tr>
				                <tr>
				                	<td>2.</td>
				                	<td><i class="fa fa-building"></i> Pravno lice</td>
				                	<td>Prasad & Sons</td>
				                	<td>office@weblab.co.rs</td>
				                	<input type="hidden" name="id" value="0">
				                	<td>
				                		<div class="btn btn-primary">
				                			<a href="javascript:void(0)" class="action">
				                          	<i class="fa fa-star" title="Edit"></i>
				                        	</a>
				                		</div>
				                        <div class="btn btn-primary">
					                        <a href="users_manage_legal/" class="action">
					                          <i class="fas fa-edit"></i>
					                        </a>
				                        </div>
				                        <div class="btn btn-primary">
					                        <a href="javascript:void(0)" class="action" data-toggle="modal" 
					                       data-target="#modal-user-delete">
					                          <i class="fa fa-trash" title="delete">
					                          </i>
					                        </a>
				                    	</div>
				                    </td>
				                </tr>
			              	</tbody>
			            </table>
	            	</div>
	            </div>
            </div>
            <div class="modal fade" id="modal-default">
	          <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Brisanje Korisnika</h4>
	              </div>
	              <div class="modal-body">
	                <p>Da li ste sigurni da želite da obrišete korisnika</p>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Nazad</button>
	                <button type="button" class="btn btn-danger">Obriši</button>
	              </div>
	            </div>
	            <!-- /.modal-content -->
	          </div>
	          <!-- /.modal-dialog -->
	        </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
        <!-- /.col -->
 
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>

<style type="text/css">
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

  function user_delete(){
  
    var data={};
        data.id = $('[name="id"]').val();


    var call_url = "user_delete";

    var call_data = {
        data:data
    }



    var call_back = function(odgovor){
      if(odgovor.success){
          alert(odgovor.message);
          $('#modal-user-delete').modal('hide');
      }
    }
    ajax_json_call(call_url, call_data, call_back);
}


</script>
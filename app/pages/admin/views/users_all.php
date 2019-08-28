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
		                	<input type="text" name="card_number" class="form-control" placeholder="example 000022" value="" onkeyup="get_users()">
		            	</div>
		            </div>
            		<div class="col-12 col-xs-3">
		            	<div class="form-group">
		            		<label>Search by name:</label>
		                	<input type="text" name="name" class="form-control" placeholder="Name" value="" onkeyup="get_users()">
		            	</div>
		            </div>
		            <div class="col-12 col-xs-3">
		            	<div class="form-group">
		            		<label>Search by email:</label>
		                	<input type="text" name="email" class="form-control" placeholder="Email" value="" onkeyup="get_users()">
		            	</div>
		            </div>
	              	<div class="col-12 col-xs-3">
		              	<div class="form-group">
		                  <label>User type</label>
		                  <select name="user_type" class="form-control" onchange="get_users()">
		                    <option value="">All</option>
		                    <option value="pravno">Pravna lica</option>
		                    <option value="fizicko">Fizička lica</option>
		                  </select>
		              	</div>
	              	</div>
	            </div><br>
	            <div class="row">
	            	<div class="col-12 col-xs-12 users_holder">
	            		
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
  
    var data = {};
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


function get_users(){

	var data = {};
		data.card_number = $('[name="card_number"]').val();
		data.name = $('[name="name"]').val();
		data.email = $('[name="email"]').val();
		data.user_type = $('[name="user_type"]').val();

  	var call_url = "get_users";  
	var call_data = { 
	  data:data 
	}  
	var callback = function(response){  
		$('.users_holder').html(response);
	}  
	ajax_call(call_url, call_data, callback); 
}


$(function(){
	get_users();
});

</script>
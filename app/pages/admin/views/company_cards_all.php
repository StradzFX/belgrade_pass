<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List companies with reserved cards
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>

              
              <a class="btn btn-success pull-right" href="company_cards_manage/">Assign cards to partner</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
            </div>
            <input type="hidden" name="id" value="0">
            <div class="company_cards_all_holder">
              
            </div>
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

  function get_company_cards_all(){
    var data={};
        data.id=$('[name="id"]').val();

    var call_url='get_company_cards_all';
    var call_data={data:data};
    var callback=function(response){
      $('.company_cards_all_holder').html(response);
    }
    ajax_call(call_url, call_data, callback);
  }

  $(function(){
    get_company_cards_all();
  })
</script>
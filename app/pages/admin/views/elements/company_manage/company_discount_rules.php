<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Discount rules</h3>
		<a href="javascript:void(0)" data-toggle="modal" data-target="#modal_company_discount_rules" onclick="get_discount_rules_data(0)" class="btn btn-success pull-right">
			Add special discount
		</a>
	</div>
	<!-- /.box-header -->
	<form role="form" class="discount_rules_holder">

	</form>
</div>
<!-- /.box -->

<script type="text/javascript">
	function get_company_discount_rules(){
      var data = {};
          data.id = $('[name="id"]').val();

      var call_url = "get_company_discount_rules";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.discount_rules_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }



    function save_company_discount_rule(){
      var data = {};
          data.company_id = $('[name="id"]').val();
          data.cdr_id = $('[name="cdr_id"]').val();

          data.cdr_day_from = $('[name="cdr_day_from"]').val();
          data.cdr_day_to = $('[name="cdr_day_to"]').val();
          data.cdr_hours_from = $('[name="cdr_hours_from"]').val();
          data.cdr_hours_to = $('[name="cdr_hours_to"]').val();
          data.cdr_discount = $('[name="cdr_discount"]').val();

      var call_url = "save_company_discount_rule";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        if(response.success){
          alert(response.message);
          get_company_discount_rules();
          $('#modal_company_discount_rules').modal('hide');
        }else{
          alert(response.message);
        }
      }  
      ajax_json_call(call_url, call_data, callback); 
    }


    function remove_company_discount_rule(cdr_id){
      var confirm_response = confirm('Are you sure you want to delete this rule?');

      if(confirm_response){
        var data = {};
            data.cdr_id = cdr_id;

        var call_url = "remove_company_discount_rule";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
          if(response.success){
            alert(response.message);
            get_company_discount_rules();
          }else{
            alert(response.message);
          }
        }  
        ajax_json_call(call_url, call_data, callback); 
      }
    }


    


    function get_discount_rules_data(id){
      $('[name="cdr_id"]').val(id);
    	if(id == 0){

    	}else{
        var data = {};
            data.cdr_id = $('[name="cdr_id"]').val();

        var call_url = "get_discount_rules_data";  
        var call_data = { 
          data:data 
        }  
        var callback = function(response){  
          if(response.success){
            console.log(response);
            $('[name="cdr_day_from"]').val(response.day_from);
            $('[name="cdr_day_to"]').val(response.day_to);
            $('[name="cdr_hours_from"]').val(response.hours_from);
            $('[name="cdr_hours_to"]').val(response.hours_to);
            $('[name="cdr_discount"]').val(response.discount);
          }else{
            alert(response.message);
          }
        }  
        ajax_json_call(call_url, call_data, callback); 
    	}
    }
</script>
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


    function get_discount_rules_data(id){
    	if(id == 0){

    	}else{

    	}
    }
</script>
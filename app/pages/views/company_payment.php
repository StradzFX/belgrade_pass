<div class="page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Uplatite paket na karticu</div>
					<div class="personal_data">
						<div>
							<div>
								<div>
									Broj kartice
								</div>
								<div>
									<input type="text" name="card_number">
								</div>
								<a href="javascript:void(0)" onclick="validate_card()" class="btn">Proverite karticu</a>
							</div>
						</div>

						<div class="card_data_holder">
							
						</div>
					</div>
				</div>
			</div>
				<!-- /. -->	
		</div>
			<!-- /.wrapper-main -->


		</div>
		<!-- /.container -->
	</div>
	<!-- /.form-content -->	
</div>
<!-- /.form-content -->	




<script>
	function validate_card(){
		var card_data = {};
			card_data.card_number = $('[name="card_number"]').val();

		start_global_call_loader(); 
	    var call_url = "validate_card_fill_with_package";  
	    var call_data = { 
	        card_data:card_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        $('.card_data_holder').html(odgovor); 
	         
	    }  
	    ajax_call(call_url, call_data, callback); 
	}

	function create_company_payment(){

		var confirm_response = confirm('Da li ste sigurni da hocete da uplatite paket?');

		if(confirm_response){
			var payment_data = {};
				payment_data.card_number = $('[name="card_number"]').val();
				payment_data.selected_package = $('[name="package"]').val();

			start_global_call_loader(); 
		    var call_url = "create_company_payment";  
		    var call_data = { 
		        payment_data:payment_data 
		    }  
		    var callback = function(response){  
		      finish_global_call_loader();
		      if(response.success){
		        var valid_selector = 'success';
		        setTimeout(function(){
		        	document.location = master_data.base_url+'company_transactions/';
		        });
		      }else{
		        var valid_selector = 'error';
		      }
		      show_user_message(valid_selector,response.message);

		    }   
		    ajax_json_call(call_url, call_data, callback); 
		}
	}

	$('[name="card_number"]').on('keyup', function (e) {
	    if (e.keyCode == 13) {
	        validate_card();
	    }
	});
	
</script>
	
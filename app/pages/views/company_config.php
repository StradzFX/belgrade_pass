<div class="page_content company_page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Podešavanja</div>
					<div class="personal_data">
						<div class="row">
							<div class="col col-xs-12 col-sm-4">
								<div class="config_item">
									<div class="c_title">
										Interne šifre
									</div>

									<?php for ($i=0; $i < sizeof($internal_codes); $i++) { ?> 
									<div class="c_content">
										<div class="form_field">
			                            <div class="field_title"><?php echo $internal_codes[$i]['code_name_display']; ?>:</div>
			                            <div class="field_component">
			                              <input name="<?php echo $internal_codes[$i]['code_name']; ?>" class="internal_codes"  value="<?php echo $internal_codes[$i]['code_value']; ?>" id="new_password" type="text" />
			                            </div>
			                          </div>
									</div>
									<?php } ?>
									
									<div class="form_field">
			                            <div class="btn btn-success" onclick="company_update_internal_codes()">Izmenite vrednosti</div>
			                          </div>
								</div>
							</div>

							<div class="col col-xs-12 col-sm-4">
								<div class="config_item">
									<div class="c_title">
										Promena lozinke
									</div>
									<div class="c_content">
										<div class="form_field">
			                            <div class="field_title">Nova lozinka:</div>
			                            <div class="field_component">
			                              <input name="new_password" id="new_password" type="password" />
			                            </div>
			                          </div>
									</div>

									<div class="c_content">
										<div class="form_field">
			                            <div class="field_title">Ponovite lozinku:</div>
			                            <div class="field_component">
			                              <input name="new_password_again" id="new_password_again" type="password" />
			                            </div>
			                          </div>
									</div>

									<div class="form_field">
			                            <div class="btn btn-success" onclick="company_reset_password()">Promenite lozinku</div>
			                          </div>
								</div>
							</div>

							
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

<script type="text/javascript">
	function company_reset_password(){ 

		var data = {};
			data.new_password = $('[name="new_password"]').val();
			data.new_password_again = $('[name="new_password_again"]').val();

	    start_global_call_loader(); 
	    var call_url = "company_reset_password";  
	    var call_data = { 
	        data:data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	} 

	function company_update_internal_codes(){ 

		var data = {};
			data.nesto = 'nesto';
			data.stat_items = new Array();

			$('.internal_codes').each(function(){
				var stat_item = {};
					stat_item.name = $(this).attr('name');
					stat_item.value = $(this).val();
				data.stat_items.push(stat_item);
			});

			console.log(data);

	    start_global_call_loader(); 
	    var call_url = "company_update_internal_codes";  
	    var call_data = { 
	        data:data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  


	
</script>
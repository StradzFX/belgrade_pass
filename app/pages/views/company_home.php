<div class="page_content company_page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account company_home_page">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="hello">Dobrodošli: <span><?php echo $company->name; ?></span></div>
					<?php if($company->type == 'master'){ ?>
					<div class="title">Novčani tok</div>
					<div class="personal_data">
						<div class="row">
							<?php foreach ($statistics_list_money as $stat_item) { ?>
								<div class="col col-sm-12 col-md-4">
									<div class="statistics_item">
										<div class="item_title">
											<?php echo $stat_item['title']; ?>

											<?php if($stat_item['info']){ ?>
											<i class="far fa-question-circle tooltipped" data-position="top" data-tooltip="<?php echo $stat_item['info']; ?>"></i>
											<?php } ?>
										</div>
										<div class="content">
											<?php echo $stat_item['value']; ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<?php if($company->type != 'master'){ ?>
					<div class="location_home_instructions">
						<div class="head_title">
							Da izvršite naplatu računa, molimo Vas da kliknete na opciju "Naplata računa"
						</div>
						<div>
							<a href="company_approval/" class="btn">Naplata računa</a>
						</div>
					</div>
					<?php } ?>
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
	function editProfile(){
		$('#edit_account').slideToggle(400);
	}


	function create_card(){
		var card_data = {};
			card_data.parent_name = $('[name="parent_name"]').val();
			card_data.child_name = $('[name="child_name"]').val();
			card_data.child_birthdate = $('[name="child_birthdate"]').val();

		start_global_call_loader(); 
	    var call_url = "create_card";  
	    var call_data = { 
	        card_data:card_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	            location.reload();
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }  
	         
	    }  
	    ajax_json_call(call_url, call_data, callback); 
	}
</script>
	
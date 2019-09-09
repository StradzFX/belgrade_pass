<div class="page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="personal_data">
						<div>
							<div class="title">Naplata usluge</div>
							<div>
								<div class="card_data_holder">
									
								</div>
								<div class="btn_validate_card">
									<div class="row">
										<div class="col-12 col-sm-3">

										</div>
										<div class="col-12 col-sm-6">
											<div>
												<div>
													Unesite iznos računa sa popustom
												</div>
												<div>
													<input type="number" name="purchase_value" value="">
												</div>
											</div>

											<div style="display: none;">
												<div>
													Prikaz kredita koji će se naplatiti
												</div>
												<div>
													<input type="number" disabled="disabled" name="purchase_value_total" onkeyup="calculate_credit_price()" value="0" style="background-color: #d0d0d0">
												</div>
											</div>

											<div class="purchase_card_number" <?php if($_GET['card']){ ?>style="display:none"<?php } ?>>
												<div>
													<b>Broj kartice</b>
												</div>
												<div>
													<input type="text" name="purchase_card_number" autocomplete="off" value="<?php echo $_GET['card']; ?>">
												</div>
											</div>

											<div class="purchase_card_password"  <?php if($_GET['card']){ ?>style="display:none"<?php } ?>>
												<div>
													<b>Šifra kartice</b>
												</div>
												<div>
													<input type="password" name="purchase_card_password" autocomplete="new-password" value="<?php echo $_GET['approval_code']; ?>">
												</div>
											</div>

											<br/>
											<a href="javascript:void(0)" onclick="validate_card()" class="btn btn-full">Naplati</a>

										</div>
										<div class="col-12 col-sm-6">
											
										</div>
									</div>
									

									
									<div>
										
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




<script>

	function calculate_credit_price(){
		var total = $('[name="purchase_value_total"]').val();
		total = total * <?php echo $credit_ponder; ?>;
		$('[name="purchase_value"]').val(total);
	}

	function editProfile(){
		$('#edit_account').slideToggle(400);
	}

	$(function(){
		$('[name="purchase_value"]').focus();
	});

	function reset_form(){
		$('.btn_validate_card').show();
		$('.card_data_holder').hide();
		$('[name="purchase_value"]').val('');
		$('[name="purchase_ext_number"]').val('');
		$('[name="purchase_card_number"]').val('');
		$('[name="purchase_card_password"]').val('');
		$('[name="purchase_value"]').focus();
	}


	function validate_card(){
		var card_data = {};
			card_data.purchase_value = $('[name="purchase_value"]').val();
			card_data.purchase_ext_number = $('[name="purchase_ext_number"]').val();
			card_data.purchase_card_number = $('[name="purchase_card_number"]').val();
			card_data.purchase_card_password = $('[name="purchase_card_password"]').val();

		start_global_call_loader(); 
	    var call_url = "validate_card";  
	    var call_data = { 
	        card_data:card_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        $('.card_data_holder').html(odgovor); 
  			$('.card_data_holder').show();

	    }  
	    ajax_call(call_url, call_data, callback); 
	}

	$('[name="card_number"]').on('keyup', function (e) {
	    if (e.keyCode == 13) {
	        validate_card();
	    }
	});
</script>
	
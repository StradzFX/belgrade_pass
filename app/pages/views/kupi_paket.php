<input type="hidden" name="selected_package" value="">
<input type="hidden" name="selected_user_card" value="">
<div class="page_content purchase_page">
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="purchase_page">
					<div class="content">
						<div class="col col-sm-12">
							<div class="row select_packages">
								<div class="step_title">
									<b>Korak 1:</b> Odaberite paket
								</div>

								<?php for ($i=0; $i < sizeof($card_package_all); $i++) { ?> 
									<div class="col col-sm-4">
										<div class="package_item <?php if($has_best_value == 1){ ?>has_best_value<?php } ?>  <?php if($card_package_all[$i]->best_value == 1){ ?>best_value<?php } ?> package_item_<?php echo $card_package_all[$i]->id; ?>">

											<div class="row card_details">
												<div class="col col-xs-6 col-sm-12">
													<div class="package_title">
													<?php echo $card_package_all[$i]->name; ?>
													</div>
													<div class="package_image">
														<img src="<?php echo $card_package_all[$i]->picture; ?>" />
													</div>
													<?php if($card_package_all[$i]->best_value == 1){ ?>
													<div class="best_offer">
														Najbolja ponuda
													</div>
													<?php } ?>
												</div>
												<div class="col col-xs-6 col-sm-12">
													<div>
														<div>
															<b>Cena:</b> 
															<?php echo $card_package_all[$i]->price; ?> RSD
														</div>
														<div>
															<b>Trajanje:</b> 
															<?php echo $card_package_all[$i]->duration_days; ?> dana
														</div>
														<div>
															<b>Broj passova:</b> 
															<?php echo $card_package_all[$i]->number_of_passes; ?>
														</div>
													</div>
													<div>
														<a href="javascript:void(0)" onclick="select_package(<?php echo $card_package_all[$i]->id; ?>)" class="btn" >Odaberi paket</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			
			<?php if($reg_user){ ?>
			<div class="col col-sm-12 step_2" style="display: none;">
				<div class="purchase_page">
					<div class="content card_selection">
						<div class="col col-sm-12">
							<div class="row select_packages">
								<div class="step_title">
									<b>Korak 2:</b> Odaberite karticu
								</div>

								<?php if(sizeof($user_card_all) > 0){ ?>
								<div>
									<select name="user_card" class="browser-default">
										<?php if(sizeof($user_card_all) > 1){ ?>
										<option value="">Odaberite karticu</option>
										<?php } ?>
										<?php for ($i=0; $i < sizeof($user_card_all); $i++) { ?> 
											<option value="<?php echo $user_card_all[$i]->id; ?>">
												<?php echo $user_card_all[$i]->card_number; ?>
											</option>
										<?php } ?>
									</select>
									<br/>
								</div>
								<div>
									<a href="javascript:void(0)" onclick="select_card()" class="btn" >Sledeći korak</a>
								</div>
								<?php }else{ ?>
								<div class="error_message">
									Nemate kreiranu ni jednu karticu. Prvo kreirajte karticu <a href="my_card/?redirect=kupi_paket">ovde</a>.
								</div>
								<?php } ?>

								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }else{ ?>
				<?php include_once 'app/pages/views/elements/kupi_paket_neregistrovan_korisnik.php'; ?>
			<?php } ?>



			<div class="col col-sm-12 step_3" style="display: none;">
				<div class="purchase_page">
					<div class="content">
						<div class="col col-sm-12">
							<div class="row select_packages">
								<div class="step_title">
									<b>Korak <?php if($reg_user){ ?>3<?php }else{ ?>4<?php } ?>:</b> Odaberite način plaćanja
								</div>
									<ul class="nav nav-tabs">
										<li role="presentation" class="payment_option pay_card active">
                                            <a href="javascript:void()" onclick="toggle_payment('pay_card')">
                                                <i class="fas fa-money-check"></i> Karticom
                                            </a>
                                        </li>
                                        <li role="presentation" class="payment_option post_office">
                                            <a href="javascript:void()" onclick="toggle_payment('post_office')">
                                                <i class="fas fa-money-check"></i> Uplatnica
                                            </a>
                                        </li>
                                        
                                        <?php /*
                                        <li role="presentation" class="payment_option invoice">
                                            <a href="javascript:void()" onclick="toggle_payment('invoice')">
                                                <i class="fa fa-file"></i> Profaktura
                                            </a>
                                        </li>
                                        */ ?>
                                    </ul>

                                    <?php include_once 'app/pages/views/elements/buy_post_office.php'; ?>
                                    <?php include_once 'app/pages/views/elements/buy_card.php'; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	<?php if($preselected_package){ ?>
		$(function(){
			select_package(<?php echo $preselected_package; ?>);
		});
	<?php } ?>

	function select_package(id){
		$('[name="selected_package"]').val(id);
		$('.step_2').show();
		$('.package_item').removeClass('selected');
		$('.package_item_'+id).addClass('selected');
		$('.specification').hide();
		$('.specification_'+id).show();
		$('html, body').animate({
	        scrollTop: $(".step_2").offset().top
	    }, 1000);
	}

	function select_card(){
		var user_card = $('[name="user_card"]').val();

		if(user_card == ""){
	        var valid_selector = 'error';
	        show_user_message(valid_selector,"Odaberite karticu na koju uplaćujete paket.");
	    }else{
	    	$('[name="selected_user_card"]').val(user_card);
	        $('.step_3').show();
		    $('html, body').animate({
		        scrollTop: $(".step_3").offset().top
		    }, 400);
	    }
	}

	function toggle_payment(option){
        $('.payment_option').removeClass('active');
        $('.'+option).addClass('active');
        $('.paying_option_box').hide();
        $('.payment_option_'+option).show();
    }
</script>
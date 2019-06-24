<div class="page_content">
	<?php include_once 'app/pages/template/user_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Spisak kartica</div>
					<div class="personal_data">
						<?php if(sizeof($card_list) == 0){ ?>
						<div>
							<div class="no_card">
								Trenutno nemate ni jednu kreiranu karticu. Da bi Vam izradili i poslali karticu, morate da popunite formular na dnu ove strane.
							</div>
							<div class="no_card_img">
								<img src="public/images/my_card/no_card.jpg" />
							</div>
						</div>
						<?php }else{ ?>
						<div class="card_info">
							<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
								<div class="row">
									<div class="col s12 m4">
										<div class="card_template">
											<div class="card_number">
												<?php echo $card_list[$i]->card_number; ?>
											</div>
											<div class="child_name">
												<?php echo $card_list[$i]->child_name; ?>
											</div>
										</div>
									</div>
									<div class="col s12 m8">
										<div>
											<div>
												Broj kartice: <?php echo $card_list[$i]->card_number; ?>
											</div>
											<div>
												Dostava: <span><?php echo $card_list[$i]->card_status; ?></span>
											</div>
										</div>
										<div>
											<div>
												Ime deteta: <?php echo $card_list[$i]->child_name; ?>
											</div>
											<div>
												Datum rođenja deteta: <?php echo $card_list[$i]->child_birthdate; ?>
											</div>

											<div>
												
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							
						</div>
						<?php } ?>
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
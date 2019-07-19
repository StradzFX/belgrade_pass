
<?php if($reg_user->user_type == 'fizicko'){ ?>
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Moj profil</div>
				
				<div class="personal_data personal_data_holder">
					<div class="row">
						<div class="col-12 col-sm-4">
							<div class="user_info">
								<div class="item_name">Ime:</div>
								<div><?php echo $reg_user->first_name; ?></div>
							</div>
						</div>
						<div class="col col-sm-4">
							<div class="user_info">
								<div class="item_name">Prezime:</div>
								<div><?php echo $reg_user->last_name; ?></div>
							</div>
						</div>
						<div class="col col-sm-4">
							<div class="user_info">
								<div class="item_name">Email:</div>
								<div><?php echo $reg_user->email; ?></div>
							</div>
						</div>
					</div>
				</div>
		
				
			</div>


			<div class="user_data">
				<div class="title">Moja kartica</div>
				<div class="personal_data">
					<?php if(sizeof($card_list) > 0){ 
						$card = $card_list[0];
					?>

					<div class="row">
						<div class="col-12 col-sm-4">
							<img src="files/qr_codes/<?php echo $card->card_number; ?>.png" />
						</div>
						<div class="col-12 col-sm-8">
							<div class="card_data">
								<div class="item">
									<div class="title">
										Broj kartice
									</div>
									<div class="value">
										<?php echo $card->card_number; ?>
									</div>
								</div>

								<div class="item">
									<div class="title">
										Poslednja uplata ističe
									</div>
									<div class="value">
										<?php echo $card->last_package_date; ?>
									</div>
								</div>

								<div class="item">
									<div class="title">
										Preostalo kredita
									</div>
									<div class="value">
										<?php echo $card->left_passes; ?>
									</div>
								</div>

								<div class="item">
									<a href="javascript:void(0)" onclick="resend_card_data()" class="btn">Zatražite PIN na email</a>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
					<div class="no_transactions">
							<i class="fas fa-credit-card"></i>
							<br/><br/>
							Trenutno nemate ni jednu kreiranu karticu.
						</div>
					<?php } ?>
					
				</div>
			</div>
	
		</div>
			<!-- /. -->	
		<?php } ?>
<?php if($reg_user->user_type == 'pravno'){ ?>
<div class="row">

	
	<div class="col-12 col-sm-6">
		<div class="wrapper-main">
			<div class="user_data">
				<div class="title">Kompanijska kartica</div>
				<div class="personal_data">
						<div class="row">
							<div class="col-12 col-sm-4">
								<img src="files/qr_codes/<?php echo $master_card->card_number; ?>.png" />
							</div>
							<div class="col-12 col-sm-8">
								<div class="card_data">
									<div class="item">
										<div class="title">
											Broj kartice
										</div>
										<div class="value">
											<?php echo $master_card->card_number; ?>
										</div>
									</div>

									<div class="item">
										<div class="title">
											Poslednja uplata ističe
										</div>
										<div class="value">
											<?php echo $master_card->last_package_date; ?>
										</div>
									</div>

									<div class="item">
										<div class="title">
											Preostalo kredita
										</div>
										<div class="value">
											<?php echo $master_card->left_passes; ?>
										</div>
									</div>

									<div class="item">
										<a href="javascript:void(0)" onclick="resend_card_data()" class="btn">Zatražite PIN na email</a>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6">
		<div class="row">
			<div class="col-12 col-sm-12">
				<div class="wrapper-main">
					<div class="user_data">
						<div class="title">Računi</div>
						<table class="table">
							<tr>
								<th>Porudžbina</th>
								<th>Datum</th>
								<th>Kredita</th>
								<th>Status</th>
							</tr>
							<?php for ($i=0; $i < sizeof($master_card->transactions); $i++) { ?> 
							<tr>
								<td><?php echo $master_card->transactions[$i]->id; ?></td>
								<td><?php echo date('d.m.Y.',strtotime($master_card->transactions[$i]->makerDate)); ?></td>
								<td><?php echo $master_card->transactions[$i]->price; ?></td>
								<td><?php echo $master_card->transactions[$i]->checker != '' ? 'Placeno' : 'Nije placeno'; ?></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-12">
				<div class="wrapper-main">
					<div class="user_data">
						<div class="title">Potrošnja kartica</div>
						<?php if(false){ ?>
							<table class="table">
								<tr>
									<th>Kartica</th>
									<th>Kredita</th>
									<th>Datum</th>
								</tr>
								<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
								<tr>
									<td><?php echo $card_list[$i]->card_number; ?></td>
									<td>250</td>
									<td><?php echo date('d.m.Y.'); ?></td>
								</tr>
								<?php } ?>
							</table>
						<?php }else{ ?>
						<div>
							Trenutno nema evidencije o prolazima
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
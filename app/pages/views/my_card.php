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
							<table class="table">
								<tr>
									<th>Kartica</th>
									<th>Kredita</th>
									<th>Ime i prezime</th>
									<th>Email</th>
									<th></th>
								</tr>
								<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
								<tr>
									<td><?php echo $card_list[$i]->card_number; ?></td>
									<td>0</td>
									<td><?php echo $card_list[$i]->parent_first_name; ?> <?php echo $card_list[$i]->parent_last_name; ?></td>
									<td><?php echo $card_list[$i]->email; ?></td>
									<td>
										<a class="btn" href="buy_company_credits/">Uplati kredit</a>
									</td>
								</tr>
								<?php } ?>
							</table>
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
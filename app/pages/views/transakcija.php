<?php if($purchase->checker == ''){ ?>
<div class="container payment_page">
	<div class="row">
		<div class="col-12 col-sm-12 payment_title">
			Izvršena je rezervacija za <?php echo $purchase->price; ?> kredita
		</div>
		<div class="col-12 col-sm-6 thank_you">
			<div>
				<b>Hvala Vam na poverenju.</b>
			</div>

			<div>
				Upravo ste porucili <?php echo $purchase->price; ?> kredita na karticu <?php echo $purchase->user_card->card_number; ?>.
			</div>
			<div>
				Iskoristite jednu od opcija placanja opisano sa desne strane kako bi uplatili navedeni iznos i mi odobrili kredit na vaucer.
			</div>
			<div>
				Nakon evidencije uplate i odobravanja kredita, dobijate email sa potvrdom i mozete da krenete da koristite uplaceni kredit.
			</div>
			<?php if($user && $user->user_type == 'fizicko'){ ?>
			<div>
				<a href="profile/" class="btn">Moja kartica</a>
				<a href="my_transactions/" class="btn">Moje transakcije</a>
			</div>
			<?php } ?>
			
		</div>
		<div class="col-12 col-sm-6">
			<div class="payment_option">
				<div class="title">
					Platite e-bankingom nalogom
				</div>
				<div class="content">
					Uplatite navedeni iznos putem Vašeg e-banking naloga i mi ćemo Vam odobriti kredite na vaučer.
				</div>
			</div>

			<div class="payment_option">
				<div class="title">
					Platite u pošti
				</div>
				<div class="content">
					<div>
						Prepišite podatke na uplatnicu i uplatite u Vama najpovoljnijoj banci. U prilogu se nalazi primer uplatnice koji treba da prepišete.
					</div>

					<img src="public/images/post_office/<?php echo $purchase->id; ?>.jpg">
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="container payment_page">
	<div class="row">
		<div class="col-12 col-sm-12 payment_title">
			Transakcija za <?php echo $purchase->price; ?> kredita je uspesno odobrena
		</div>
		<div class="col-12 col-sm-12 thank_you">
			<div>
				<b>Hvala Vam na poverenju.</b>
			</div>

			<div>
				Nakon evidencije uplate i odobravanja kredita, dobijate email sa potvrdom i mozete da krenete da koristite uplaceni kredit.
			</div>
			<?php if($user && $user->user_type == 'fizicko'){ ?>
			<div>
				<a href="profile/" class="btn">Moja kartica</a>
				<a href="my_transactions/" class="btn">Moje transakcije</a>
			</div>
			<?php } ?>
			
		</div>
	</div>
</div>
<?php } ?>
<div class="page_content">
	<div class="container">
		<div class="home_categories">
			<?php for($i=0;$i<sizeof($sport_category_all);$i++){ ?>
			
				<div class="cat_item">
					<a href="companies/category/<?php echo $sport_category_all[$i]->id; ?>">
						<div>
							<img src="<?php echo $sport_category_all[$i]->logo; ?>">
						</div>
						<div>
							<?php echo $sport_category_all[$i]->name; ?>
						</div>
					</a>
				</div>
			<?php } ?>

			<div class="cat_item birthdays">
				<a href="rodjendani/">
					<div>
						<img src="public/images/birthdays/home_icon.png">
					</div>
					<div>
						Rođendani
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="home_teaser">
			<img src="public/images/home/teaser.jpg" class="hide-on-med-and-down" />
			<img src="public/images/home/teaser_mobile.jpg" class="hide-on-large-only" />
		</div>
	</div>

	<div class="container">
		<div class="home_explanation">
			<div class="row">
				<div class="col s12 m4">
					<img src="public/images/home/explanation_1.jpg" />
				</div>
				<div class="col s12 m4">
					<img src="public/images/home/explanation_2.jpg" />
				</div>
				<div class="col s12 m4">
					<img src="public/images/home/explanation_3.jpg" />
				</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="home_packages">
			<div class="section_title">
				PAKETI
			</div>
			<div class="row">
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
										<a href="kupi_paket/<?php echo $card_package_all[$i]->id; ?>/" class="btn" >Odaberi paket</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="home_statistics">
			<div class="row">
				<div class="col s12 m6">
					<div class="statistics_item" style="background:url(public/images/home/companies.jpg) center no-repeat;">
						<div class="details">
							<div class="number">
								<?php echo $training_school_count; ?>
							</div>
							<div class="title">
								AKTIVNOSTI
							</div>
						</div>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="statistics_item" style="background:url(public/images/home/users.jpg) center no-repeat;">
						<div class="details">
							<div class="number">
								<?php echo $user_card_count+1000; ?>
							</div>
							<div class="title">
								ČLANOVA KLUBA
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(sizeof($trending_schools) > 0){ ?>
	<div class="container">
		<div class="section_title">
			Izdvojene aktivnosti
		</div>
		
		<div class="company_list">
			<div class="row">
				<?php for ($i=0;$i<sizeof($featured_schools);$i++) {
					$school_preview = $featured_schools[$i];
					include 'app/pages/template/elements/club_preview.php';
				?>
				<?php } ?>
			</div>
		</div>
		<!-- /.inv-projects-blog-wrapper -->
		<div class="call_to_action">
			<a href="companies/" class="btn">
				POGLEDAJTE SVE AKTIVNOSTI
			</a>
		</div>
	</div>
	<?php } ?>
</div>
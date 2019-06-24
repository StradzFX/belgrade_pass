<div class="consultant-view">
	<?php //======================================== BASIC DATA ====================================== ?>
	<div class="container">
		<div class="row">
			<div class="col s12 m12">
				<div class="basic-information box">
					<div class="col s12 m12 l6">
						<div class="col s12 m5 l4">
							<div class="profile-picture" style="background: url(<?php echo $coach->photo_display; ?>) no-repeat center;"></div>
						<!-- /.picture -->
						</div>
						<div class="col s12 m7 l8">
							<div class="info">
								<div class="name">
									<?php echo $coach->full_name; ?>
								</div>
								<!-- /.name -->
								<div class="position">
									<?php echo $coach->category_display->name; ?> coach
								</div>
								<!-- /.position -->
								<div class="location">
									<?php /* 
									<i class="fa fa-map-marker" aria-hidden="true"></i>
			 						Operating: <?php echo $coach->operating; ?>
			 						*/ ?>
								</div>
							</div>
							<!-- /.info -->
						</div>
					</div>
					<div class="col s12 m12 l6">
						<!-- /.clear -->
						<div class="intro-text">
							<?php echo $coach->short_description; ?>
						</div>
						<!-- /.intro-text -->
					</div>
				</div>
				<!-- /.basic-information -->
			</div>
			<!-- /.col s8 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->

	<?php //======================================== ACTIVE SCHOOLS ====================================== ?>
	<?php if(sizeof($list_schools) > 0){ ?>
	<div class="container">
		<div class="section-headline">
			<h2 class="border-green">Active in schools</h2>
		</div>
		<!-- /.inv-projects-blog-headline -->
		
		<div class="inv-projects-blog-wrapper">
			<div class="row">
				<?php for ($i=0;$i<sizeof($list_schools);$i++) {
					$school_preview = $list_schools[$i];
					include 'app/pages/template/elements/club_preview_by_coach.php';
				?>
				<?php } ?>
			</div>
		</div>
		<!-- /.inv-projects-blog-wrapper -->
	</div>
	<?php } ?>

	<?php //======================================== DETAILS ====================================== ?>
	<div class="container">
		<div class="white_bg">
			<div class="row">
			    <div class="col s12">
			    	<div class="content box">
				    	<ul class="tabs">
				        	<li class="tab col s12 m4"><a class="active" href="#description">Description</a></li>
				        	<li class="tab col s12 m4"><a href="#work-history">Work history</a></li>
				        	<li class="tab col s12 m4"><a href="#reviews">Reviews</a></li>
				      	</ul>
				      	<div class="wrapper">
				      		<div id="description" class="col s12 c-description">
				      			<?php for($i=0;$i<sizeof($coach->description_items);$i++){ ?>
				      				<p>
										<?php echo $coach->description_items[$i]->opis; ?>

										
									</p>

									<hr>
				      			<?php } ?>

				      			Gregg Charles Popovich (born January 28, 1949) is an American professional basketball coach. He is the head coach and President of the San Antonio Spurs of the National Basketball Association (NBA). Taking over as coach of the Spurs in 1996, Popovich is the longest tenured active coach in both the NBA and all major sports leagues in the United States. He is often called "Coach Pop" or simply "Pop."<br/><br/>

										Popovich is considered one of the greatest coaches in NBA history. He has led the Spurs to a winning record in each of his 21 full seasons as head coach, surpassing Phil Jackson for the most consecutive winning seasons in NBA history. He has also led the Spurs to all five of their NBA titles, and is one of only five coaches in NBA history to win five titles—the others being Jackson, Red Auerbach, Pat Riley, and John Kundla.[3]
					      	</div>
						    <div id="work-history" class="col s12 c-work-history">
						    	<?php for($i=0;$i<sizeof($coach->working_history);$i++){ ?>
									<strong><?php echo $coach->working_history[$i]->kompanija_pozicija; ?></strong> <br />
									<?php echo $coach->working_history[$i]->kompanija_naziv; ?> <br />
									<?php echo $coach->working_history[$i]->kompanija_od; ?> – <?php echo $coach->working_history[$i]->kompanija_do; ?><br />
									<?php echo $coach->working_history[$i]->opis; ?>
									<hr>
								<?php } ?>
						    </div>
						    <div id="reviews" class="col s12">
						    	<?php for($i=0;$i<sizeof($coach->reviews);$i++){ ?>
								<p>
									<strong>
										<?php echo $coach->reviews[$i]->ime; ?>
									</strong> <br>
									<?php echo $coach->reviews[$i]->sadrzaj; ?>
								</p>
								<hr>
								<?php } ?>
						    </div>
				      	</div>
				      	<!-- /.wrapper -->
					</div>
					<!-- /.content -->		
				</div>
				<!-- /.col s12 -->		    
		    </div>
		</div>
	</div>

	<?php //======================================== GALLERY ====================================== ?>
	<?php if(sizeof($coach->gallery) > 0){ ?>
	<div class="slider variable-width">
		<?php for($i=0;$i<sizeof($coach->gallery);$i++){ ?>
		<img src="<?php echo $coach->gallery[$i]->display_picture; ?>" style="height: 250px">
		<?php } ?>
	</div>
	<?php } ?>	



	<?php //======================================== CONTACT FORM ====================================== ?>
	<div class="container">
		<div class="row">
			<div class="col s12 m12">
				<div class="box">
					<?php include_once 'app/pages/template/elements/coach_contact_form.php'; ?>
				</div>
			</div>
		</div>
	</div>

	

	

	

</div>
<!-- /.consultant-view -->
<script>
	$(document).ready(function(){
		$('ul.tabs').tabs();

		$('.variable-width').slick({
		  dots: true,
		  arrows: false,
		  infinite: true,
		  speed: 300,
		  adaptiveHeight: true,
		  slidesToShow: 1,
		  centerMode: true,
		  variableWidth: true
		});
	});
        
</script>
<style type="text/css">
	.slider {
	   height:250px!important;
	}
</style>

<link rel="stylesheet" type="text/css" href="public/css/slick.css"/>
<link rel="stylesheet" type="text/css" href="public/css/slick-theme.css"/>
<script type="text/javascript" src="public/js/slick.min.js"></script>
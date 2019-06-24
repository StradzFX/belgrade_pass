<div class="school-preview">
	<div class="school_name">
		<div class="container">
			<div class="title">
				<?php echo $school->name; ?>
			</div>
		</div>
	</div>

	<div class="school_description">
		<div class="container">
			<?php echo $school->short_description; ?>
		</div>
	</div>

	<?php if(sizeof($school->gallery) > 0){ ?>
	
	<div class="school_gallery">
		<div class="container">
			<div class="slider variable-width">
				<?php for($i=0;$i<sizeof($school->gallery);$i++){ ?>
				<img src="<?php echo $school->gallery[$i]->display_picture; ?>" style="height: 400px">
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	

	<div class="section_divider"></div>

	<div class="project-details">
		<div class="menu">
			<div class="item">
				<span class="item-details selected" onclick="get_section('details')">
					OPIS
				</span>
			</div>
			<div class="item">
				<span class="item-offer" onclick="get_section('offer')">
					TERMINI
				</span>
			</div>
			<?php if($school->birthday_options == 1){ ?>
			<div class="item">
				<span class="item-birthdays" onclick="get_section('birthdays')">
					ROĐENDANI
				</span>
			</div>
			<?php } ?>
			
		</div>
		<div class="content">
			<div class="content-item content-details">
				<div class="container">
					<?php echo $school->main_description; ?>
				</div>
			</div>

			<div class="content-item content-offer" style="display: none;">
				<div class="container">
					Termini
				</div>
			</div>

			<div class="content-item content-birthdays" style="display: none;">
				<div class="container">
					<div class="row">
						<div class="col col-md-2 location_menu">
							<div class="title">
								Lokacije
							</div>
							<?php for($i=0;$i<sizeof($company_birthday_data_all);$i++){ ?>
							<a class="<?php if($i==0){ ?>active<?php } ?> locations_menu locations_menu_<?php echo $i; ?>" href="javascript:void(0)" onclick="change_location_birthdate(<?php echo $i; ?>)">
								<?php echo $company_birthday_data_all[$i]->ts_location->street; ?>
							</a>
							<?php } ?>
						</div>
						<div class="col col-md-10">
							<div class="row">
								<div class="col col-md-6">
									<?php for($i=0;$i<sizeof($company_birthday_data_all);$i++){ ?>
									<div class="locations location_<?php echo $i; ?>"  <?php if($i>=1){ ?>style="display:none"<?php } ?> >
										<div class="title">
											Osnovne informacije
										</div>
										<div class="row">
											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-map-marker-alt"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Lokacija
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->ts_location->street; ?>
														</div>
													</div>
												</div>
											</div>

											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-child"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Maks. broj dece
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->max_kids; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-male"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Maks. broj odraslih
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->max_adults; ?>
														</div>
													</div>
												</div>
											</div>

											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-leaf"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Bašta
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->garden == 1 ? 'Da' : 'Ne'; ?>
														</div>
													</div>
												</div>
											</div>

											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-smoking"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Pušačka zona
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->smoking == 1 ? 'Da' : 'Ne'; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-cookie-bite"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Ketering
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->catering == 1 ? 'Da' : 'Ne'; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-magic"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Animatori
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->animators == 1 ? 'Da' : 'Ne'; ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col col-md-6 b_info_box">
												<div class="row">
													<div class="col col-md-3 sub_icon">
														<i class="fas fa-eye"></i>
													</div>
													<div  class="col col-md-9">
														<div class="sub_title">
															Čuvanje dece
														</div>
														<div class="sub_content">
															<?php echo $company_birthday_data_all[$i]->watching_kids == 1 ? 'Da' : 'Ne'; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>

								<div class="col col-md-6 reservations">
									<div class="title">
										Rezerviši rođendan
									</div>
									<div>
										<div class="cake_icon">
											<i class="fa fa-birthday-cake"></i>
										</div>
										<div class="info">
											Odaberite datum proslave rođendana Vašeg deteta, a mi ćemo Vam pronaći najbolji termin
										</div>

										<div class="row">
											<div class="col col-md-4">
												<div>
													Dan
												</div>
												<div>
													<select class="browser-default" name="b_day">
														<?php for ($i=1; $i <= 31; $i++) { ?>
															<option value="<?php echo $i; ?>" <?php if(date('d') == $i){ ?>selected="selected"<?php } ?>><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="col col-md-4">
												<div>
													Mesec
												</div>
												<div>
													<select class="browser-default" name="b_month">
														<?php for ($i=1; $i <= 12; $i++) { ?>
															<option value="<?php echo $i; ?>" <?php if(date('m') == $i){ ?>selected="selected"<?php } ?>><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="col col-md-4">
												<div>
													Godina
												</div>
												<div>
													<select class="browser-default" name="b_year">
														<?php for ($i=date('Y'); $i <= (date('Y')+1); $i++) { ?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>

										<div style="text-align: center;">
											<div class="btn btn-success" onclick="go_to_birthday_reservation()">
												Pretraži termine
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>


 <script type="text/javascript">
 	function get_section(id){
 		$('.menu').find('.item').find('span').removeClass('selected');
 		$('.item-'+id).addClass('selected');
 		$('.content-item').hide();
 		$('.content-'+id).show();
 	}


 	function change_submenu(id){
 		$('.submenu').find('.item').removeClass('selected');
 		$('.submenu').find('.item_'+id).addClass('selected');

 		/*$('.submenu-arrows').find('.material-icons').addClass('none');
 		$('.submenu-arrows').find('.item_'+id).removeClass('none');*/

 		//$('.submenu-content').find('.item_sub').addClass('none');
 		//$('.submenu-content').find('.item_'+id).removeClass('none');
 		$('html,body').animate({
	        scrollTop: $("#section_content_"+id).offset().top
	    }, 'slow');
 	}

 	function go_to_join_us(){
 		$('html,body').animate({
	        scrollTop: $("#join-us").offset().top
	    }, 'slow');
 	}

 	function change_picture(url){
 		$('.big_picture').css('background','url('+url+') no-repeat center');
 	}

 	$(function(){
 		$('.variable-width').slick({
		  dots: true,
		  arrows: false,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 1,
		  centerMode: true,
		  variableWidth: true
		});

		<?php if($url_params[1] == 'birthdays'){ ?>
			get_section('birthdays');
		<?php } ?>
 	});

 	function change_location_birthdate(index){
 		$('.locations').hide();
 		$('.location_'+index).show();
 		$('.locations_menu').removeClass('active');
 		$('.locations_menu_'+index).addClass('active');
 	}

 	function go_to_birthday_reservation(){
 		var day = $('[name=b_day]').val();
 		var month = $('[name=b_month]').val();
 		var year = $('[name=b_year]').val();

 		var company = <?php echo $school->id; ?>;

 		var link = 'rezervacija-rodjendana/'+year+'-'+month+'-'+day+'/'+company+'/';
 		document.location = master_data.base_url + link;
 	}
 </script>

<link rel="stylesheet" type="text/css" href="public/css/slick.css"/>
<link rel="stylesheet" type="text/css" href="public/css/slick-theme.css"/>
<script type="text/javascript" src="public/js/slick.min.js"></script>
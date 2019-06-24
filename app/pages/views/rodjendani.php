<div class="page_content">
	<div class="schools">
		<div class="container">
			<div class="page-headline border-green">
				<h2>Pretraga rođendana</h2>
			</div>
		</div>

		<div class="container">
			<div class="filters" style="height: 210px;">
				<div class="row">
					<div class="col col-md-6">
						<div class="row">
							<div class="col s12 m4">
								<label>Lokacija</label><br/>
								<select name="location" onchange="search_for_schools()" class="browser-default">
									<option value="">Sve lokacije</option>
									<?php for ($i=0; $i < sizeof($list_cities); $i++) {  ?>
										<option value="<?php echo $list_cities[$i]['name']; ?>"><?php echo $list_cities[$i]['name']; ?></option>
										<?php for ($j=0; $j < sizeof($list_cities[$i]['parts']); $j++) {  ?>
										<option value="<?php echo $list_cities[$i]['name']; ?>,<?php echo $list_cities[$i]['parts'][$j]['part_of_city']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $list_cities[$i]['parts'][$j]['part_of_city']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>

							<div class="col s12 m4">
								<label>Broj dece</label><br/>
								<select name="number_of_kids" onchange="search_for_schools()" class="browser-default">
									<option value="">---</option>
									<?php for ($i=1; $i <= 100; $i++) {  ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col s12 m4">
								<label>Broj odraslih</label><br/>
								<select name="number_of_adults" onchange="search_for_schools()" class="browser-default">
									<option value="">---</option>
									<?php for ($i=1; $i <= 100; $i++) {  ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col col-line s12 m12">
								&nbsp;
							</div>

							<div class="col s12 m2">
								<label>Bašta</label><br/>
								<input type="checkbox" class="form-check-input" name="garden">
								<div class="c_search c_garden" onclick="c_check('garden')">
									<i class="far fa-square"></i>
									<i class="far fa-check-square"></i>
								</div>
							</div>
							
							<div class="col s12 m2">
								<label>Ketering</label><br/>
								<input type="checkbox" name="catering">
								<div class="c_search c_catering" onclick="c_check('catering')">
									<i class="far fa-square"></i>
									<i class="far fa-check-square"></i>
								</div>
							</div>
							<div class="col s12 m2">
								<label>Animatori</label><br/>
								<input type="checkbox" name="animators">
								<div class="c_search c_animators" onclick="c_check('animators')">
									<i class="far fa-square"></i>
									<i class="far fa-check-square"></i>
								</div>
							</div>
							<div class="col s12 m2">
								<label>Pušači</label><br/>
								<input type="checkbox" name="smoking">
								<div class="c_search c_smoking" onclick="c_check('smoking')">
									<i class="far fa-square"></i>
									<i class="far fa-check-square"></i>
								</div>
							</div>
							<div class="col s12 m2">
								<label>Čuvanje dece</label><br/>
								<input type="checkbox" name="watching_kids">
								<div class="c_search c_watching_kids" onclick="c_check('watching_kids')">
									<i class="far fa-square"></i>
									<i class="far fa-check-square"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col col-md-6 filters_birthdays">
						<div class="row">
							<div class="col col-md-12">
								<div class="title">
									Rezervišite rođendan
								</div>
								<div>
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

		<div class="container">
			<div class="search_content">
				<div>
					<div class="search_option search_list">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.top-cover -->

<script type="text/javascript">
	function change_search_option(){
		var is_checked = $('[name="search_option"]').is(':checked');
		if(is_checked){
			$('.search_map').addClass('none');
			$('.search_list').removeClass('none');
		}else{
			$('.search_map').removeClass('none');
			$('.search_list').addClass('none');
		}
	}
</script>

<script type="text/javascript">
	function get_search_list_birthdays(){
		var filters = get_search_filters();

        var call_url = "get_search_list_birthdays";  
        var call_data = { 
          filters:filters 
        }  
        var callback = function(response){  
        	$('.search_list').html(response);
        }  
        ajax_call(call_url, call_data, callback);
	}

	function get_search_filters(){
		var filters = {};
			filters.location = $('[name="location"]').val();
			filters.number_of_kids = $('[name="number_of_kids"]').val();
			filters.number_of_adults = $('[name="number_of_adults"]').val();

			filters.garden = $('[name="garden"]').is(':checked') ? '1' : '0';
			filters.catering = $('[name="catering"]').is(':checked') ? '1' : '0';
			filters.animators = $('[name="animators"]').is(':checked') ? '1' : '0';
			filters.smoking = $('[name="smoking"]').is(':checked') ? '1' : '0';
			filters.watching_kids = $('[name="watching_kids"]').is(':checked') ? '1' : '0';
		return filters;
	}

	function get_redirect_filters(){
		var filters = get_search_filters();
		
		var fp = '?';
		fp += 'location='+filters.location+'&';
		fp += 'number_of_kids='+filters.number_of_kids+'&';
		fp += 'number_of_adults='+filters.number_of_adults+'&';
		fp += 'garden='+filters.garden+'&';
		fp += 'catering='+filters.catering+'&';
		fp += 'animators='+filters.animators+'&';
		fp += 'smoking='+filters.smoking+'&';
		fp += 'watching_kids='+filters.watching_kids;

		return fp;
	}


	function search_for_schools(){
		get_search_list_birthdays();
	}

	$(function(){
		search_for_schools();
	});


	 function c_check(type){
	 	var is_checked = $('[name="'+type+'"]').is(':checked');
	 	if(is_checked){
	 		$('[name="'+type+'"]').attr('checked',null);
	 		$('.c_'+type).removeClass('checked');
	 	}else{
	 		$('[name="'+type+'"]').attr('checked','checked');
	 		$('.c_'+type).addClass('checked');
	 	}
	 	get_search_list_birthdays();
	 }


	 function go_to_birthday_reservation(){
 		var day = $('[name=b_day]').val();
 		var month = $('[name=b_month]').val();
 		var year = $('[name=b_year]').val();
 		var fp = get_redirect_filters();

 		var link = 'rezervacija-rodjendana/'+year+'-'+month+'-'+day+'/'+fp;
 		document.location = master_data.base_url + link;
 	}

</script>
<style type="text/css" href="public/js/nouislider/nouislider.min.css"></style>
<script type="text/javascript" src="public/js/nouislider/nouislider.min.js"></script>

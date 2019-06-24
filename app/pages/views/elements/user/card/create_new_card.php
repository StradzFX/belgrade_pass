<div class="title">Kreirajte novu karticu</div>
<div>
	<div class="row">
		<?php /* ======================== BASIC DETAILS ====================== */ ?>
		<div class="col col-sm-6 new_user_card">
			<div class="title">Osnovni podaci</div>
			<div class="row">
				<div class="col col-sm-6">
					<div>Ime roditelja</div>
					<div><input type="text" name="parent_first_name"></div>
				</div>
				<div class="col col-sm-6">
					<div>Prezime roditelja</div>
					<div><input type="text" name="parent_last_name"></div>
				</div>
				<div class="col col-sm-3">
					<div>Broj dece</div>
					<div><input type="text" name="number_of_kids"></div>
				</div>
				<div class="col col-sm-9">
					<div>Uzrast dece (datum rođenja)</div>
					<div><input type="text" name="child_birthdate"></div>
				</div>
				<div class="col col-sm-6">
					<div>Grad/Mesto</div>
					<div><input type="text" name="city"></div>
				</div>
				<div class="col col-sm-6">
					<div>Telefon</div>
					<div><input type="text" name="phone"></div>
				</div>
				<div class="col col-sm-12">
					<div>Email</div>
					<div><input type="text" name="email"></div>
				</div>
			</div>
		</div>

		<?php /* ======================== DELIVERY ====================== */ ?>
		<div class="col col-sm-6 new_user_card">
			<div class="title">Preuzimanje kartice</div>
			<div class="row">
				<div class="col s12">
					<form action="#">
						<div class="form_field">
							<div class="field_title">Metod preuzimanja:</div>
							<div class="field_component">
								<div class="delivery_item delivery_post" onclick="select_delivery('post')">
									<i class="far fa-circle"></i> Poštom na kućnu adresu
								</div>
								<?php if(sizeof($company_list) > 0){ ?>
								<div class="delivery_item delivery_partner" onclick="select_delivery('partner')">
								<i class="far fa-circle"></i> U prostorijama partnera
								</div>
								<?php } ?>

								<?php /* ======================== DELIVERY BY POST suboptions ====================== */ ?>
								<div class="delivery_content delivery_content_post" style="display: none;">
									<div class="row">
										<div class="col s6">
											<div class="form_field">
												<div class="field_title">Ulica:</div>
												<div class="field_component">
													<input name="post_street" id="post_street" type="text" />
												</div>
											</div>
										</div>
										<div class="col s6">
											<div class="form_field">
												<div class="field_title">Grad:</div>
												<div class="field_component">
													<input name="post_city" id="post_city" type="text" />
												</div>
											</div>
										</div>
										<div class="col s6">
											<div class="form_field">
												<div class="field_title">Poštanski broj:</div>
												<div class="field_component">
													<input name="post_postal" id="post_postal" type="text" />
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="delivery_content delivery_content_partner" style="display: none;">
									<div class="form_field">
										<div class="field_title">Odaberite partnera:</div>
										<div class="field_component">
											<select name="partner_id" class="browser-default" onchange="fill_company_locations()">
												<option value="">Partner</option>
												<?php for ($i=0; $i < sizeof($company_list); $i++) {  ?> 
												<option value="<?php echo $company_list[$i]->id; ?>">
												<?php echo $company_list[$i]->name; ?> (<?php echo $company_list[$i]->number_of_locations; ?>)
												</option>
												<?php } ?>
											</select>
									</div>
								</div>

								<div class="form_field company_location" style="display: none;">
									<div class="field_title">Odaberite lokaciju:</div>
										<div class="field_component">
											<select name="partner_location" class="browser-default">
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<a href="javascript:void(0)" onclick="create_card()" class="btn" >Kreiraj karticu</a>
</div>





<script>

	var company_locations = new Array();

	<?php for ($i=0; $i < sizeof($company_list); $i++) {  ?>
		var company = {};
			company.id = '<?php echo $company_list[$i]->id; ?>';
			company.locations = new Array();

			<?php for ($j=0; $j < sizeof($company_list[$i]->locations); $j++) {  ?>
			var c_location = {};
				c_location.id = '<?php echo $company_list[$i]->locations[$j]->id; ?>';
				c_location.name = '<?php echo $company_list[$i]->locations[$j]->street; ?>, <?php echo $company_list[$i]->locations[$j]->part_of_city; ?>';
				company.locations.push(c_location);
			<?php } ?>

		company_locations.push(company);
	<?php } ?>

	function fill_company_locations(){
		var selected_company = $('[name="partner_id"]').val();
		if(selected_company == ''){
			$('.company_location').hide();
		}else{
			$('[name="partner_location"]').html('');
			$('.company_location').show();

			for (var i = company_locations.length - 1; i >= 0; i--) {
				if(company_locations[i].id == selected_company){
					if(company_locations[i].locations.length > 1){
						$('[name="partner_location"]').append('<option value="">Odaberite lokaciju</option>');
					}
					for (var j = company_locations[i].locations.length - 1; j >= 0; j--) {
						var c_location = company_locations[i].locations[j];
						$('[name="partner_location"]').append('<option value="'+c_location.id+'">'+c_location.name+'</option>');
						
					}
				}
			}
			
		}
	}

	function editProfile(){
		$('#edit_account').slideToggle(400);
	}

	var delivery_method = null;

	function select_delivery(id){
		$('.delivery_item').find('i').removeClass('fas');
		$('.delivery_item').find('i').addClass('far');
		$('.delivery_item').removeClass('active');

		$('.delivery_'+id).find('i').removeClass('far');
		$('.delivery_'+id).find('i').addClass('fas');
		$('.delivery_'+id).addClass('active');

		delivery_method = id;

		$('.delivery_content').hide();
		$('.delivery_content_'+id).show();

	}

	function create_card(){
		var card_data = {};
	      	card_data.parent_first_name = $('[name="parent_first_name"]').val();
	      	card_data.parent_last_name = $('[name="parent_last_name"]').val();
	      	card_data.number_of_kids = $('[name="number_of_kids"]').val();
	      	card_data.child_birthdate = $('[name="child_birthdate"]').val();
	      	card_data.city = $('[name="city"]').val();
	      	card_data.phone = $('[name="phone"]').val();
	      	card_data.email = $('[name="email"]').val();
			card_data.delivery_method = delivery_method;

			card_data.post_street = $('[name="post_street"]').val();
			card_data.post_city = $('[name="post_city"]').val();
			card_data.post_postal = $('[name="post_postal"]').val();

			card_data.partner_id = $('[name="partner_id"]').val();

		start_global_call_loader(); 
	    var call_url = "create_card";  
	    var call_data = { 
	        card_data:card_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){ 
	        	location.reload();
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }
	    }  
	    ajax_json_call(call_url, call_data, callback); 
	}
</script>

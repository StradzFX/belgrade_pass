
<div class="page_content">
	<div class="schools">
		<div class="container">
			<div class="page-headline border-green">
				<h2>Rezervacija rođendana za dan <?php echo date('d.m.Y.',strtotime($selected_date)); ?></h2>
			</div>
		</div>

		<?php if($reg_user){ ?>
		<div class="container reservations_panels reservation_timetable">

			<div class="terms_title">
				Termini za sve objekte
			</div>

			<?php if(sizeof($company_list) > 0){ ?>
				<div class="slots">
					<div class="row">
						<?php for ($i=0; $i < sizeof($company_list); $i++) { ?> 
							<div class="col col-sm-6">
								<div class="location_name">
									<?php echo $company_list[$i]['data']['location_name']; ?>
								</div>
								<div class="location_data">
									<div class="row">
										<div class="col col-sm-2">
											<div class="data_important">
												<i class="fas fa-child active"></i> <?php echo $company_list[$i]['data']['location']['max_kids']; ?>
											</div>
										</div>
										<div class="col col-sm-2">
											<div class="data_important">
												<i class="fas fa-male active"></i> <?php echo $company_list[$i]['data']['location']['max_adults']; ?>
											</div>
										</div>
										<div class="col col-sm-1">
											<i class="fas fa-leaf <?php if($company_list[$i]['data']['location']['garden'] == 1){ ?>active<?php } ?>" title="Bašta"></i>
										</div>
										<div class="col col-sm-1">
											<i class="fas fa-smoking <?php if($company_list[$i]['data']['location']['smoking'] == 1){ ?>active<?php } ?>" title="Pušačka zona"></i>
										</div>
										<div class="col col-sm-1">
											<i class="fas fa-cookie-bite <?php if($company_list[$i]['data']['location']['catering'] == 1){ ?>active<?php } ?>" data-toggle="tooltip" data-placement="top" title="Ketering"></i>
										</div>
										<div class="col col-sm-1">
											<i class="fas fa-magic <?php if($company_list[$i]['data']['location']['animators'] == 1){ ?>active<?php } ?>" title="Animatori"></i>
										</div>
										<div class="col col-sm-1">
											<i class="fas fa-eye <?php if($company_list[$i]['data']['location']['watching_kids'] == 1){ ?>active<?php } ?>" title="Čuvanje dece"></i>
										</div>

									</div>
								</div>
								<div class="row">
									<?php foreach ($company_list[$i]['slots'] as $slot) { ?>
										<div class="col col-sm-4">
											<div class="slot">
												<div class="time">
													<?php echo $slot['time']; ?>
												</div>
												<div class="price">
													<?php echo $slot['price']; ?> RSD
												</div>
												<div class="reservation_btn">
													<a href="javascript:void(0)" onclick="set_reservation_time(<?php echo $slot['id']; ?>,'<?php echo $slot['time']; ?>','<?php echo $slot['price']; ?>')">Rezervišite</a>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>

							<?php if(($i+1)%2 == 0){ ?>
							<div class="col col-sm-12">
								&nbsp;
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			<?php }else{ ?>
				<div class="terms_content">
					<div class="no-results">
							<i class="fas fa-compass"></i><br/>
							Nema termina za ostale kompanije
					</div>
				</div>
					
			<?php } ?>
		</div>

		<div class="container reservations_panels reservation_form" style="display: none;">
			<input type="hidden" name="slot_id" value="">
			<div class="terms_title">
				Rezervacija termina za rođendan
			</div>
			<div class="terms_content">
				<div class="row">
					<div class="col col-sm-3">
						<div class="rf_item">
							<div class="title">Rođendaonica</div>
							<div class="value lg-value company_name">
								
							</div>
						</div>
					</div>

					<div class="col col-sm-3">
						<div class="rf_item">
							<div class="title">Datum</div>
							<div class="value lg-value">
								<?php echo date('d.m.Y.',strtotime($selected_date)); ?>
							</div>
						</div>
					</div>

					<div class="col col-sm-3">
						<div class="rf_item">
							<div class="title">Vreme početka</div>
							<div class="value lg-value seleted_time">
								0
							</div>
						</div>
					</div>

					<div class="col col-sm-3">
						<div class="rf_item">
							<div class="title">Cena</div>
							<div class="value lg-value seleted_price">
								0
							</div>
						</div>
					</div>

					<div class="col col-sm-12">
						&nbsp;
					</div>

					<div class="col col-sm-6">
						<div class="rf_item">
							<div class="title">Broj kartice za rezervaciju</div>
							<div class="value">
								<select class="browser-default" name="user_card">
									<?php for ($i=0; $i < sizeof($card_list); $i++) { ?> 
										<option value="<?php echo $card_list[$i]->id; ?>"><?php echo $card_list[$i]->card_number; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>

					<div class="col col-sm-6">
						<div class="rf_item">
							<div class="title">NAPOMENA</div>
							<div class="value">
								<div class="notice">
									Svaka rezervacija zahteva skidanje jednog prolaza sa Vaše kartice. Ne možete izvršiti više od jedne rezervacije za istu kompaniju u roku od mesec dana. 
								</div>
							</div>
						</div>
					</div>

					<div class="col col-sm-12">
						&nbsp;
					</div>

					<div class="col col-sm-4">
						<div class="rf_item">
							<div class="title">Broj dece (opciono)</div>
							<div class="value">
								<input type="text" class="form-control" name="number_of_kids" />
							</div>
						</div>
					</div>

					<div class="col col-sm-4">
						<div class="rf_item">
							<div class="title">Broj odraslih (opciono)</div>
							<div class="value">
								<input type="text" class="form-control" name="number_of_adults" />
							</div>
						</div>
					</div>

					<div class="col col-sm-12">
						<div class="rf_item">
							<div class="title">Dodatne napomene (opciono)</div>
							<div class="value">
								<textarea class="form-control" name="comments"></textarea>
							</div>
						</div>
					</div>

					<div class="col col-sm-12">
						<a href="javascript:void(0)" onclick="make_birthday_reservation()" class="btn btn-success">Rezervišite termin</a>
						<a href="javascript:void(0)" onclick="go_to_slots()" class="btn btn-warning pull-right">Vratite se na termine</a>
					</div>
				</div>
			</div>

		</div>
		<?php }else{ ?>
		<div class="container">
			<div class="no-registration">
				<div class="icon">
					<i class="fas fa-search-location"></i>
				</div>

				<div class="warning_block_one">
					Pre nego što krenete u pretragu
				</div>
				<div class="warning_block_two">
					Morate da budete registrovani da biste mogli da vršite pretragu termina.
				</div>

			</div>
		</div>
		<?php } ?>

		
	</div>
</div>
<!-- /.top-cover -->

<style type="text/css">
	.reservation_table{

	}

	.reservation_item{
		padding: 3px;
		border-left: 1px solid #ccc;
		border-right: 1px solid #ccc;
		border-top: 1px solid #ccc;
		background-color: #fff;
		color: #ccc;
		font-size: 8px;
	}

	.reservation_item.working{
		background-color: #65b265;
		color: #fff;
		cursor: pointer;
	}
	.reservation_item.working:hover{
		background-color: #000;
	}

	.reservation_item.busy{
		background-color: #ce1919;
		color: #fff;
	}

	.reservation_item.no_reservation{
		background-color: #f5f4f8;
		color: #ccc;
	}
	

	.reservation_table .reservation_item:last-child{
		border-bottom: 1px solid #ccc;
	}
</style>

<script type="text/javascript">

	var locations = new Array();
	<?php for ($i=0; $i < sizeof($company_list); $i++) { ?> 
	<?php foreach ($company_list[$i]['slots'] as $slot) { ?>
		var c_location = {};
			c_location.name = '<?php echo $company_list[$i]['data']['location_name']; ?>';

		locations[<?php echo $slot['id']; ?>] = c_location;
	<?php }} ?>

	function set_reservation_time(slot_id,time,price){
		$('.reservation_timetable').fadeOut(400,function(){
			$('.seleted_time').html(time);
			$('.seleted_price').html(price+' RSD');
			$('.company_name').html(locations[slot_id].name);
			$('[name="slot_id"]').val(slot_id);
			$('.reservation_form').fadeIn(300);
		});
	}

	function go_to_slots(){
		$('.reservation_form').fadeOut(400,function(){
			$('.reservation_timetable').fadeIn(300);
		});
	}

	function make_birthday_reservation(){
		var data = {};
			data.selected_date = '<?php echo $selected_date; ?>';
			data.slot_id = $('[name="slot_id"]').val();
			data.user_card = $('[name="user_card"]').val();
			data.number_of_kids = $('[name="number_of_kids"]').val();
			data.number_of_adults = $('[name="number_of_adults"]').val();
			data.comments = $('[name="comments"]').val();

		var call_url = "make_birthday_reservation";  

	    var call_data = { 
	        data:data 
	    }  

	    var callback = function(response){  
	      if(response.success){
	        var valid_selector = 'success';
	        document.location = master_data.base_url+'uspesna_rezervacija/'+response.id;
	      }else{
	        var valid_selector = 'error';
	        show_user_message(valid_selector,response.message);
	      }
	    }  
	    ajax_json_call(call_url, call_data, callback);
	}
</script>
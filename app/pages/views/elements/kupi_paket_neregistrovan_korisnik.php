<div class="col col-sm-12 step_2" style="display: none;">
	<div class="purchase_page">
		<div class="content card_selection">
			<div class="col col-sm-12">
				<div>
					<div class="step_title">
						<b>Korak 2:</b> Popunite lične podatke
					</div>

					<div class="reg_login">
						<div class="row">
					    <div class="col s12">
					      <ul class="tabs">
					        <li class="tab col s3"><a class="active" href="#novi_korisnik">Novi korisnik</a></li>
					        <li class="tab col s3"><a href="#postojeci_korisnik">Postojeći korisnik</a></li>
					      </ul>
					    </div>
					    <div id="novi_korisnik" class="col s12 korisnik_tab">
					    	<div class="row">
					    		<div class="col s6">
					    			<div class="form_field">
					                  <div class="field_title">Ime:</div>
					                  <div class="field_component">
					                    <input name="ime" id="ime" type="text" />
					                  </div>
					                </div>
					    		</div>

					    		<div class="col s6">
					    			<div class="form_field">
					                  <div class="field_title">Prezime:</div>
					                  <div class="field_component">
					                    <input name="prezime" id="prezime" type="text" />
					                  </div>
					                </div>
					    		</div>

					    		<div class="col s6">
					    			<div class="form_field">
					                  <div class="field_title">Email:</div>
					                  <div class="field_component">
					                    <input name="email" id="email" type="text" />
					                  </div>
					                </div>
					    		</div>
					    	</div>
					    	<div>
								<a href="javascript:void(0)" onclick="registracija()" class="btn" >Sledeći korak</a>
							</div>
					    </div>
					    <div id="postojeci_korisnik" class="col s12 korisnik_tab">
					    	<div class="row">
					    		<div class="col s6">
					    			<div class="form_field">
					                  <div class="field_title">Email:</div>
					                  <div class="field_component">
					                    <input name="email" id="email" type="text" />
					                  </div>
					                </div>
					    		</div>

					    		<div class="col s6">
					    			<div class="form_field">
					                  <div class="field_title">Lozinka:</div>
					                  <div class="field_component">
					                    <input name="password" id="password" type="password" />
					                  </div>
					                </div>
					    		</div>
					    	</div>
					    	<a href="javascript:void(0)" onclick="login()" class="btn" >Uloguj se</a>
					    </div>
					  </div>
					</div>
					<div class="logged_user" style="display: none;">
						Dobrodošli <span class="user_full_name">Strahinja Krstic</span>!
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col col-sm-12 step_3_1" style="display: none;">
	<div class="purchase_page">
		<div class="content card_selection">
			<div class="col col-sm-12">
				<div>
					<div class="step_title">
						<b>Korak 3:</b> Kreirajte karticu
					</div>

					<div>
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
							                    <select name="partner_id" class="browser-default">
													<option value="">Partner</option>
													<?php for ($i=0; $i < sizeof($company_list); $i++) {  ?> 
														<option value="<?php echo $company_list[$i]->id; ?>">
															<?php echo $company_list[$i]->name; ?>
														</option>
													<?php } ?>
												</select>
							                  </div>
							                </div>
					                  	</div>
					                  </div>
					                </div>
					            </form>
				    		</div>
				    	</div>
				    	<a href="javascript:void(0)" onclick="create_card()" class="btn" >Kreiraj karticu</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col col-sm-12 step_3_2" style="display: none;">
	<div class="purchase_page">
		<div class="content card_selection">
			<div class="col col-sm-12">
				<div class="row select_packages">
					<div class="step_title">
						<b>Korak 3:</b> Odaberite karticu
					</div>
					<div>
						<select name="user_card" class="browser-default">
						</select>
						<br/>
					</div>
					<div>
						<a href="javascript:void(0)" onclick="select_card()" class="btn" >Sledeći korak</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function(){
	    $('.tabs').tabs();
	  });

	var user = {};
		user.id = null;

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

	function registracija(){

	    var user_data = {};
	        user_data.ime = $('#novi_korisnik').find('[name="ime"]').val();
	        user_data.prezime = $('#novi_korisnik').find('[name="prezime"]').val();
	        user_data.email = $('#novi_korisnik').find('[name="email"]').val();

	    start_global_call_loader(); 
	    var call_url = "website_registration_wihout_pass";  
	    var call_data = { 
	        user_data:user_data
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            user = odgovor.user;
	            $('.user_full_name').html(user.first_name+' '+user.last_name);
	            $('.reg_login').hide();
	            $('.logged_user').show();
	            $('.step_3_1').show();
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }  
	        
	    }  
	    ajax_json_call(call_url, call_data, callback);    
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
	        	console.log(odgovor);
	        	$('[name="user_card"]').append('<option value="'+odgovor.card.id+'">'+odgovor.card.card_number+'</option>');
	        	$('.step_3_2').show();
	        	$('.step_3_1').hide();
	        	select_card();
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }
	    }  
	    ajax_json_call(call_url, call_data, callback); 
	}

	function login(){ 

		var user_data = {};
			user_data.email = $('#postojeci_korisnik').find('[name="email"]').val();
			user_data.password = $('#postojeci_korisnik').find('[name="password"]').val();

	    start_global_call_loader(); 
	    var call_url = "website_login";  
	    var call_data = { 
	        user_data:user_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            user = odgovor.user;
	            console.log(user.cards.length);
	            $('.user_full_name').html(user.first_name+' '+user.last_name);
	            $('.reg_login').hide();
	            $('.logged_user').show();
	            if(user.cards.length > 0){
	            	$('[name="user_card"]').append('<option value="">Odaberite karticu</option>');
	            	for (var i=0;i<user.cards.length;i++) {
	            		$('[name="user_card"]').append('<option value="'+user.cards[i].id+'">'+user.cards[i].card_number+'</option>');
	            	}
	            	$('.step_3_2').show();
	            }else{
	            	$('.step_3_1').show();
	            }
	            
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }  
	        
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  
</script>
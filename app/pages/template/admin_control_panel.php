<?php 
	$admin_user = $_SESSION['admin'];


	if(!$_SESSION['company']){
		$admin_company = new training_school();
		$admin_company->add_condition('recordStatus','=','O');
		$admin_company->set_order_by('pozicija','DESC');
		$admin_company = $broker->get_all_data_condition($admin_company);

		for($i=0;$i<sizeof($admin_company);$i++){
			$admin_location = new ts_location();
			$admin_location->add_condition('recordStatus','=','O');
			$admin_location->add_condition('training_school','=',$admin_company[$i]->id);
			$admin_location->set_order_by('pozicija','DESC');
			$admin_company[$i]->locations = $broker->get_all_data_condition($admin_location);
		}
		$admin_user_session = null;
	}else{
		$admin_user_session = $broker->get_session('company');
	}


	$test_cards = AdminControlPanelModule::get_testing_cards();
	$random_registration_user = AdminControlPanelModule::get_randon_user_registration_data();


	if(!$_SESSION['user']){
		$retail_user = null;
		$retail_users_list = AdminControlPanelModule::get_retail_users_list();
	}else{
		$retail_user = $broker->get_session('user');
	}

	
?>


<?php if($admin_user){ ?>

<div class="admin_control_panel">
	<div class="title">
		Admin control panel
	</div>
	<div class="options">
		<div class="row">
			<div class="col-12 col-sm-2">
				<div class="option_item">
					<div class="title">
						Partner login
					</div>
					<div class="content">
						<?php if(!$admin_user_session){ ?>
						<div class="form-content">
							<div class="form-group">
								<label>Select partner</label>
								<select name="admin_company_login_id" class="">
									<option value="">---</option>
									<?php for($i=0;$i<sizeof($admin_company);$i++){ ?>
										<option value="company-<?php echo $admin_company[$i]->id; ?>">Owner - <?php echo $admin_company[$i]->name; ?></option>
										<?php for($j=0;$j<sizeof($admin_company[$i]->locations);$j++){ ?>
										<option value="location-<?php echo $admin_company[$i]->locations[$j]->id; ?>">&nbsp;&nbsp;&nbsp;Location - <?php echo $admin_company[$i]->locations[$j]->username; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<div class="btn btn-success btn-xs" onclick="admin_company_login()">
									Login
								</div>
							</div>
						</div>
						<?php }else{ ?>
						<div class="form-content">
							<div class="form-group">
								You are logged as: <b><?php echo $admin_user_session->name; ?> (<?php echo $admin_user_session->type; ?>)</b>
							</div>
							<div class="form-group">
								<a class="btn btn-success btn-xs" href="company_home/">View profile</a>
								<div class="btn btn-success btn-xs" onclick="admin_company_logout()">
									Logout
								</div>
							</div>
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-2">
				<div class="option_item">
					<div class="title">
						Test cards
					</div>
					<div class="content">
						<div class="form-content">
							<div class="form-group">
								<label>Testing cards</label>
								<select name="test_card" onchange="get_test_card_data()" class="">
									<?php for ($i=0; $i < sizeof($test_cards); $i++) { ?>
										<option value="<?php echo $test_cards[$i]->id; ?>,<?php echo $test_cards[$i]->card_password; ?>,<?php echo $test_cards[$i]->total_credits; ?>,<?php echo $test_cards[$i]->card_number; ?>"><?php echo $test_cards[$i]->card_number; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="test_card_data">
								
							</div>
							<div>
								<a href="admin/admin_payments_create/" class="admin_payment_btn btn btn-success" target="_blank">Uplati kredit</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-2">
				<div class="option_item">
					<div class="title">
						Retail users
					</div>
					<div class="content">
						<?php if(!$retail_user){ ?>
						<div class="form-content">
							<div class="form-group">
								<label>Retail users</label>
								<select name="retail_user" class="">
									<?php for ($i=0; $i < sizeof($retail_users_list); $i++) { ?>
										<option value="<?php echo $retail_users_list[$i]->id; ?>"><?php echo $retail_users_list[$i]->email; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<div class="btn btn-success btn-xs" onclick="retail_user_login()">
									Login
								</div>
							</div>		
						</div>
						<?php }else{ ?>
						<div class="form-content">
							<div class="form-group">
								You are logged as: <b><?php echo $retail_user->email; ?> (retail)</b>
							</div>
							<div class="form-group">
								<a class="btn btn-success btn-xs" href="profile/">View profile</a>
								<div class="btn btn-success btn-xs" onclick="retail_user_logout()">
									Logout
								</div>
							</div>
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script type='text/javascript' src='public/js/admin_control_panel.js'></script>
<script type="text/javascript">
	$(function(){
		get_test_card_data();


		//RANDOM USER REGISTRATION
		$('[name="ime"]').val('<?php echo $random_registration_user["first_name"]; ?>');
		$('[name="prezime"]').val('<?php echo $random_registration_user["last_name"]; ?>');
		$('[name="email"]').val('<?php echo $random_registration_user["email"]; ?>');
		$('[name="lozinka"]').val('<?php echo $random_registration_user["password"]; ?>');
		$('[name="potvrdi_lozinku"]').val('<?php echo $random_registration_user["password"]; ?>');
	});
</script>
<?php } ?>
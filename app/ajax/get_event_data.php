<?php
if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$company = $broker->get_session('company');


$data = $_POST['data'];

$id = $data['id'];
if($id <= 0 || !is_numeric($id) || !$broker->does_key_exists(new company_events($id))){
	$company_event = new company_events($id);
	$company_event->event_name_b = 'Rođendan';
	$company_event->event_global_type = 'none';
	$company_event->company_birthday_data = 'none';
}else{
	$company_event = $broker->get_data(new company_events($id));
	$company_event->event_name_b = $company_event->event_name;
	if($company_event->event_global_type == ''){
		$company_event->event_global_type = 'free';
	}

	if($company_event->company_birthday_data == ''){
		$company_event->company_birthday_data = 'none';
	}
}

$company_birthday_data_all = new company_birthday_data();
$company_birthday_data_all->set_condition('checker','!=','');
$company_birthday_data_all->add_condition('recordStatus','=','O');
$company_birthday_data_all->add_condition('ts_location','=',$company->location->id);
$company_birthday_data_all->set_order_by('pozicija','DESC');
$cbd = $broker->get_all_data_condition($company_birthday_data_all);

$selected_date = $data['selected_date'];
$sddow = date('N',strtotime($selected_date));

for($i=0;$i<sizeof($cbd);$i++){
	$clbs = new company_location_birthday_slots();
	$clbs->set_condition('checker','!=','');
	$clbs->add_condition('recordStatus','=','O');
	$clbs->add_condition('company_birthday_data','=',$cbd[$i]->id);
	$clbs->add_condition('day_of_week','=',$sddow);
	$clbs->set_order_by('pozicija','DESC');
	$clbs = $broker->get_all_data_condition($clbs);

	for ($j=0; $j < sizeof($clbs); $j++) { 
		$clbs[$j]->hours_from = $clbs[$j]->hours_from < 10 ? '0'.$clbs[$j]->hours_from : $clbs[$j]->hours_from;
		$clbs[$j]->minutes_from = $clbs[$j]->minutes_from < 10 ? '0'.$clbs[$j]->minutes_from : $clbs[$j]->minutes_from;
		$clbs[$j]->hours_to = $clbs[$j]->hours_to < 10 ? '0'.$clbs[$j]->hours_to : $clbs[$j]->hours_to;
		$clbs[$j]->minutes_to = $clbs[$j]->minutes_to < 10 ? '0'.$clbs[$j]->minutes_to : $clbs[$j]->minutes_to;

		$clbs[$j]->display_time = $clbs[$j]->hours_from.':'.$clbs[$j]->minutes_from.' - '.$clbs[$j]->hours_to.':'.$clbs[$j]->minutes_to;
	}

	$cbd[$i]->clbs = $clbs;
}

?>
<input type="hidden" name="event_id" value="<?php echo $company_event->id; ?>">
<div class="row">
	<div class="col col-xs-12 col-sm-12" style="    background-color: #f0f0f0;border-radius: 10px;margin-bottom: 20px;padding: 20px;<?php if(sizeof($cbd) == 0){ ?>display:none;<?php } ?>">
		<div><b>Tip unosa</b></div>
		<select name="event_global_type" class="form-control" onchange="change_event_global_type()">
			<option value="none" <?php if($company_event->event_global_type == 'none'){ ?>selected="selected"<?php } ?>>Odaberite tip termina</option>
			<option value="birthday" <?php if($company_event->event_global_type == 'birthday'){ ?>selected="selected"<?php } ?>>Rođendan</option>
			<option value="free" <?php if($company_event->event_global_type == 'free'){ ?>selected="selected"<?php } ?> <?php if(sizeof($cbd) == 0){ ?>selected="selected"<?php } ?>>Slobodni unos</option>
		</select>
	</div>



	<div class="event_global_type egt_birthday" style="display: none;">

		

		<div class="col col-xs-12 col-sm-4"<?php if(sizeof($cbd) <= 1){ ?>style="display:none"<?php } ?>>
			<div><b>Prostorija</b></div>
			<div>
				<select name="b_data" onchange="change_b_data()" class="form-control">
					<?php if(sizeof($cbd) > 1){ ?><option value="none">Odaberite prostoriju</option><?php } ?>
					<?php for($i=0;$i<sizeof($cbd);$i++){ ?>
						<option value="<?php echo $cbd[$i]->id; ?>"><?php echo $cbd[$i]->name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="col col-xs-12 col-sm-4">
			<div><b>Vreme</b></div>
			<div>
				<div class="periods period_none">
					Odaberite prostoriju
				</div>
				<?php for($i=0;$i<sizeof($cbd);$i++){ ?>
				<div class="periods period_<?php echo $cbd[$i]->id; ?>" style="display:none">
					<select name="b_slot" class="form-control ">
						<option value="">Odaberite vreme</option>
						<?php for($j=0;$j<sizeof($cbd[$i]->clbs);$j++){ ?>
							<option value="<?php echo $cbd[$i]->clbs[$j]->id; ?>"><?php echo $cbd[$i]->clbs[$j]->display_time; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<?php } ?>
			</div>
		</div>

		<div class="col col-xs-12 col-sm-4">
			<div><b>Tip događaja</b></div>
			<div>
				<select name="event_type" class="form-control">
					<option value="">Odaberite tip događaja</option>
					<option <?php if($company_event->event_type == 'closed_event'){ ?>selected="selected"<?php } ?> value="closed_event">Zatvoreni tip (prikazuje nedostupno vreme)</option>
					<option <?php if($company_event->event_type == 'opened_event'){ ?>selected="selected"<?php } ?> value="opened_event">Otvoreni tip (prikazuje dostupno vreme)</option>
				</select>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12" style="margin-top: 10px;">
			<div><b>Naslov</b></div>
			<div>
				<input type="text" class="form-control" name="event_name" value="<?php echo $company_event->event_name_b; ?>" >
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12">
			<a href="javascript:void(0)" onclick="insert_event()" class="btn btn-success">Sačuvaj</a>
		</div>
	</div>






	<div class="event_global_type egt_free" style="<?php if(sizeof($cbd) > 0){ ?>display:none;<?php } ?>">
		<div class="col col-xs-12 col-sm-6">
			<div><b>Vreme od</b></div>
			<div class="row">
				<div class="col col-xs-6 col-sm-6">
					<select name="event_horus_from" class="form-control">
						<option value="">--</option>
						<?php for ($i=0; $i <= 23; $i++) { 
							$i_d = $i < 10 ? '0'.$i : $i;
						?>
							<option value="<?php echo $i; ?>" <?php if($company_event->event_horus_from == $i){ ?>selected="selected"<?php } ?>><?php echo $i_d; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-xs-6 col-sm-6">
					<select name="event_minutes_from" class="form-control">
						<option value="">--</option>
						<?php for ($i=0; $i <= 55; $i+=5) { 
							$i_d = $i < 10 ? '0'.$i : $i;
						?>
							<option value="<?php echo $i; ?>" <?php if($company_event->event_minutes_from == $i){ ?>selected="selected"<?php } ?>><?php echo $i_d; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-6">
			<div><b>Vreme do</b></div>
			<div class="row">
				<div class="col col-xs-6 col-sm-6">
					<select name="event_hours_to" class="form-control">
						<option value="">--</option>
						<?php for ($i=0; $i <= 23; $i++) { 
							$i_d = $i < 10 ? '0'.$i : $i;
						?>
							<option value="<?php echo $i; ?>" <?php if($company_event->event_hours_to == $i){ ?>selected="selected"<?php } ?>><?php echo $i_d; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-xs-6 col-sm-6">
					<select name="event_minutes_to" class="form-control">
						<option value="">--</option>
						<?php for ($i=0; $i <= 55; $i+=5) { 
							$i_d = $i < 10 ? '0'.$i : $i;
						?>
							<option value="<?php echo $i; ?>" <?php if($company_event->event_minutes_to == $i){ ?>selected="selected"<?php } ?>><?php echo $i_d; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-6" <?php if(sizeof($cbd) <= 1){ ?>style="display:none"<?php } ?>>
			<div><b>Prostorija</b></div>
			<div>
				<select name="b_data" class="form-control">
					<?php if(sizeof($cbd) == 0){ ?>
						<option value="0">Nema</option>
					<?php }else{ ?>
						<?php for($i=0;$i<sizeof($cbd);$i++){ ?>
							<option value="<?php echo $cbd[$i]->id; ?>"><?php echo $cbd[$i]->name; ?></option>
						<?php } ?>
					<?php } ?>
					
				</select>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-6">
			<div><b>Tip događaja</b></div>
			<div>
				<select name="event_type" class="form-control">
					<option value="">Odaberite tip događaja</option>
					<option <?php if($company_event->event_type == 'closed_event'){ ?>selected="selected"<?php } ?> value="closed_event">Zatvoreni tip (prikazuje nedostupno vreme)</option>
					<option <?php if($company_event->event_type == 'opened_event'){ ?>selected="selected"<?php } ?> value="opened_event">Otvoreni tip (prikazuje dostupno vreme)</option>
					<option <?php if($company_event->event_type == 'other_event'){ ?>selected="selected"<?php } ?> value="other_event">Ostalo (prikazuje nedostupno vreme)</option>
				</select>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12">
			<div><b>Naslov</b></div>
			<div>
				<input type="text" class="form-control" name="event_name" value="<?php echo $company_event->event_name; ?>" >
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12">
			<a href="javascript:void(0)" onclick="insert_event()" class="btn btn-success">Sačuvaj</a>
		</div>
	</div>

	<div class="col col-xs-12 col-sm-12" style="margin-top: 20px;">
		<a href="javascript:void(0)" onclick="go_back_to_list()" class="btn btn-success">Nazad na listu</a>
	</div>

	
</div>
	

	<script type="text/javascript">
		function insert_event(){
			var event_data = {};
				event_data.event_global_type = $('[name="event_global_type"]').val();

				if(event_data.event_global_type != 'none'){
					event_data.event_id = $('[name="event_id"]').val();
					event_data.event_date = $('[name="event_date"]').val();

					if(event_data.event_global_type == 'free'){
						event_data.event_name = $('.egt_free').find('[name="event_name"]').val();
						event_data.event_horus_from = $('[name="event_horus_from"]').val();
						event_data.event_minutes_from = $('[name="event_minutes_from"]').val();
						event_data.event_hours_to = $('[name="event_hours_to"]').val();
						event_data.event_minutes_to = $('[name="event_minutes_to"]').val();
						event_data.event_type = $('.egt_free').find('[name="event_type"]').val();
						event_data.event_b_data = $('.egt_free').find('[name="b_data"]').val();
						insert_event_ajax(event_data);
					}else{
						event_data.event_b_data = $('.egt_birthday').find('[name="b_data"]').val();

						if(event_data.event_b_data != 'none'){
							event_data.event_name = $('.egt_birthday').find('[name="event_name"]').val();
							event_data.event_type = $('.egt_birthday').find('[name="event_type"]').val();
							event_data.event_b_slot = $('.egt_birthday').find('.period_'+event_data.event_b_data).find('[name="b_slot"]').val();
							insert_event_ajax(event_data);
						}else{
							var valid_selector = 'error';
		        			show_user_message(valid_selector,'Molimo Vas da odaberete prostoriju.');
						}
					}
				}else{
					var valid_selector = 'error';
		        	show_user_message(valid_selector,'Molimo Vas da odaberete tip unosa.');
				}
		}



		function insert_event_ajax(event_data){
			console.log(event_data);
			var call_url = "insert_event";  

		    var call_data = { 
		        event_data:event_data 
		    }  

		    var callback = function(response){  
		      if(response.success){
		      	var valid_selector = 'success';
		        show_user_message(valid_selector,response.message);

		        get_calendar_day_list_start($('[name="event_date"]').val());
		        
		      }else{
		        var valid_selector = 'error';
		        show_user_message(valid_selector,response.message);
		      }

		    }  
		    ajax_json_call(call_url, call_data, callback);
		}

		function change_event_global_type(){
			var event_global_type = $('[name="event_global_type"]').val();
			$('.event_global_type').hide();
			$('.egt_'+event_global_type).show();
		}


		function change_b_data(){
			var b_data = $('[name="b_data"]').val();
			$('.periods').hide();
			$('.period_'+b_data).show();
		}


		$(function(){
			change_event_global_type();
			
			
			<?php if($company_event->event_global_type == 'birthday'){ ?>
				$('[name="b_data"]').val(<?php echo $company_event->company_birthday_data; ?>);
				$('.egt_birthday').find('.period_'+<?php echo $company_event->company_birthday_data; ?>).find('[name="b_slot"]').val(<?php echo $company_event->company_location_birthday_slots; ?>);
			<?php } ?>
			change_b_data();
		});
	</script>
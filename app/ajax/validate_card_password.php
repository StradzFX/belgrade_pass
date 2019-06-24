<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$last_card = null;

$company = $broker->get_session('company');


$validation_message = "";
if($card_data["card_number"] == ""){$validation_message = "Unesite broj kartice.";}
if($card_data["card_password"] == ""){$validation_message = "Unesite broj sigurnosni kod.";}
if($company->type != "location"){$validation_message = "Morate biti ulogovani kao administrator za lokaciju.";}

if($validation_message == ""){

	$card_number = HelperModule::translate_card_number_format($card_data["card_number"]);

	$last_card = new user_card();
	$last_card->set_condition('checker','!=','');
	$last_card->add_condition('recordStatus','=','O');
	$last_card->add_condition('card_number','=',$card_number);
	$last_card->set_order_by('pozicija','DESC');
	$last_card->set_limit(1);
	$last_card->set_order_by('id','DESC');
	$last_card = $broker->get_all_data_condition_limited($last_card);

	if(sizeof($last_card) > 0){
		$last_card = $last_card[0];

		if($last_card->card_password == $card_data["card_password"]){
			$success = true;
			$message = "All OK";

			$pass_per_kid = 1;
			$location_rules = null;
			$company_location_pass_rules_all = new company_location_pass_rules();
			$company_location_pass_rules_all->set_condition('checker','!=','');
			$company_location_pass_rules_all->add_condition('recordStatus','=','O');
			$sql_from = "(hours_from*60 + minutes_from < ".(date('H')*60+date('m')).")";
			$company_location_pass_rules_all->add_condition('','',$sql_from);
			$sql_to = "(hours_to*60 + minutes_to >= ".(date('H')*60+date('m')).")";
			$company_location_pass_rules_all->add_condition('','',$sql_to);
			$company_location_pass_rules_all->add_condition('ts_location','=',$company->location->id);
			$company_location_pass_rules_all->set_order_by('pozicija','DESC');
			$location_rules_all = $broker->get_all_data_condition($company_location_pass_rules_all);

			if(sizeof($location_rules_all) > 0){
				$location_rules = $location_rules_all[0];
				$pass_per_kid = $location_rules->pass_per_kid;
			}


		}else{
			$message = 'Sigurnosni kod nije ispravan.';
		}
	}else{
		$message = 'Kartica sa ovim brojem ne postoji.';
	}

}else{
	$message = $validation_message;
} 

?>

<?php if($success){ ?>
	<div>
		<div>
			<b>Broj Kartice: </b> <?php echo $last_card->card_number; ?>
		</div>
	</div>

	<div>
		<div>
			Odaberite broj dece
		</div>
		<div>
			<select name="number_of_kids" class="browser-default" onchange="display_kids_per_pass()">
				<option value="">Broj dece</option>
				<?php for ($i=1; $i <= 6; $i++) { ?> 
					<option value="<?php echo $i; ?>">
						<?php echo $i; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="display_kids_per_pass">
			
		</div>
	</div>
	
	<div>
		<a href="javascript:void(0)" onclick="save_passes()" class="btn">Upiši prolaze</a>
	</div>

	<script type="text/javascript">
		$('.card_data_holder').hide();
		$('[name="card_password"]').attr('disabled','disabled');

		$('[name="number_of_passes"]').focus();

		function display_kids_per_pass(){
			var number_of_kids = $('[name="number_of_kids"]').val();
			pass_validation
			if(number_of_kids == ''){
				$('.display_kids_per_pass').hide();
			}else{
				pass_validation.set_number_of_kids(number_of_kids);
				
				var kids_per_pass_template = '\
				<div class="row">\
					<div class="col col-xs-12 col-sm-6">\
						{company_disclaimer}<br/>\
						<b>Odnos:</b> 1 dete = {pass_per_kid} prolaz<br/>\
					</div>\
					<div class="col col-xs-12 col-sm-6">\
						&nbsp;<br/>\
						<b>Ukupno:</b> {number_of_kids} {kids_verb} = {pass_per_kid_total} {pass_verb}\
					</div>\
				</div>\
				';

				kids_per_pass_template = kids_per_pass_template.replace('{pass_per_kid}',pass_validation.pass_per_kid);
				kids_per_pass_template = kids_per_pass_template.replace('{number_of_kids}',number_of_kids);
				kids_per_pass_template = kids_per_pass_template.replace('{company_disclaimer}',pass_validation.company_disclaimer);
				kids_per_pass_template = kids_per_pass_template.replace('{pass_per_kid_total}',pass_validation.pass_per_kid_total);
				kids_per_pass_template = kids_per_pass_template.replace('{pass_verb}',pass_validation.pass_verb);
				kids_per_pass_template = kids_per_pass_template.replace('{kids_verb}',pass_validation.kids_verb);
				$('.display_kids_per_pass').html(kids_per_pass_template);
				$('.display_kids_per_pass').show();
			}
		}

		var pass_validation = {};
			pass_validation.number_of_kids = 0;
			pass_validation.pass_per_kid = <?php echo $pass_per_kid; ?>;
			<?php if($location_rules){ ?>
				pass_validation.company_disclaimer = '<span style="color:red">Napomena: U periodu od \
				<?php echo $location_rules->hours_from < 10 ? '0'.$location_rules->hours_from : $location_rules->hours_from; ?>:\
<?php echo $location_rules->minutes_from < 10 ? '0'.$location_rules->minutes_from : $location_rules->minutes_from; ?> \
				do \
<?php echo $location_rules->hours_to; ?>:\
<?php echo $location_rules->minutes_to; ?> važi sledeći odnos</span>';
			<?php }else{ ?>
				pass_validation.company_disclaimer = '&nbsp;';
			<?php } ?>
			
			pass_validation.set_number_of_kids = function(number_of_kids){
				this.number_of_kids = number_of_kids;
				this.pass_per_kid_total = this.number_of_kids * this.pass_per_kid;
				this.pass_verb =  this.pass_per_kid_total >= 1 && this.pass_per_kid_total < 2 ? 'prolaz' : 'prolaza';
				this.kids_verb = this.number_of_kids == 1 ? 'dete' : 'deteta';
				this.kids_verb = this.pass_per_kid_total < 5 ? this.kids_verb : 'dece';
			}
	</script>
<?php }else{ ?>
 <div class="row">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">Greška</span>
          <p><?php echo $message; ?></p>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
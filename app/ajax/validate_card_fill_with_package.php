<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$last_card = null;

$validation_message = "";
if($card_data["card_number"] == ""){$validation_message = "Unesite broj kartice";}

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


		$card_package_all = new card_package();
		$card_package_all->set_condition('checker','!=','');
		$card_package_all->add_condition('recordStatus','=','O');
		$card_package_all->set_order_by('pozicija','DESC');
		$card_package_all = $broker->get_all_data_condition($card_package_all);
		$has_best_value = false;
		for($i=0;$i<sizeof($card_package_all);$i++){
			$card_package_all[$i]->picture = 'pictures/card_package/picture/'.$card_package_all[$i]->picture;
			if($card_package_all[$i]->best_value == 1){
				$has_best_value = true;
			}
		}
		$success = true;

	}else{
		$last_card = null;
	}
}else{
	$message = $validation_message;
} 

?>

<?php if($success){ ?>
	<?php if($last_card){ ?>
		<div class="row">
			<div class="col col-xs-12 col-sm-4">
				<b>Broj Kartice: </b><br/>
				<?php echo $last_card->card_number; ?>
			</div>
			<div class="col col-xs-12  col-sm-4">
				<b>Ime roditelja: </b><br/>
				<?php echo $last_card->parent_first_name; ?> <?php echo $last_card->parent_last_name; ?>
			</div>
			<div class="col col-xs-12  col-sm-4">
				<b>Datum rođenja deteta: </b><br/>
				<?php echo $last_card->child_birthdate; ?>
			</div>

			<div class="col col-xs-12  col-sm-12">
				<b>Odaberite paket: </b><br/>
				<select class="browser-default" name="package">
					<option value="">---</option>
					<?php for ($i=0; $i < sizeof($card_package_all); $i++) { ?> 
						<option value="<?php echo $card_package_all[$i]->id; ?>"><?php echo $card_package_all[$i]->name; ?> / <?php echo $card_package_all[$i]->price; ?> RSD / <?php echo $card_package_all[$i]->number_of_passes; ?> pasova</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div>
			<a href="javascript:void(0)" onclick="create_company_payment()" class="btn">Uplati paket na karticu</a>
		</div>
	<?php }else{ ?>
	<div class="row">
	    <div class="col s12 m6">
	      <div class="card blue-grey darken-1">
	        <div class="card-content white-text">
	          <span class="card-title">Greška</span>
	          <p>Kartica koju ste uneli se ne nalazi u sistemu</p>
	        </div>
	      </div>
	    </div>
	  </div>
	<?php } ?>
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
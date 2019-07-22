<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$card_data = $post_data['card_data'];

$last_card = null;

$company = $broker->get_session('company');

$validation_message = "";
if(!$company){$validation_message = "Niste ulogovani";}
if($card_data["purchase_card_password"] == ""){$validation_message = "Unesite šifru kartice";}
if($card_data["purchase_card_number"] == ""){$validation_message = "Unesite broj kartice";}
//if($card_data["purchase_ext_number"] == ""){$validation_message = "Unesite broj računa";}
if($card_data["purchase_value"] == ""){$validation_message = "Unesite iznos";}

if($validation_message == ""){

	$card_number = HelperModule::translate_card_number_format($card_data["purchase_card_number"]);

	$card = CardModule::get_card($card_number);
	if($card){
		$card = CardModule::validate_card_password($card,$card_data["purchase_card_password"]);
		if($card){
			$card_credits = CardModule::get_card_credits($card);
			if($card_credits >= $card_data["purchase_value"]){
				CardModule::save_passes($card,$card_data["purchase_value"],$company);
				$success = true;
				$message = 'Uspešno ste procesirali transakciju';
			}else{
				$diff = $card_data["purchase_value"] - $card_credits;
				$message = 'Nemate dovoljno kredita. Nedostaje Vam jos '.$diff.' kredita';
			}
		}else{
			$message = 'Sifra za karticu nije validna';
		}
	}else{
		$message = 'Kartica nije pronadjena u sistemu';
	}
}else{
	$message = $validation_message;
} 

?>

<?php if($success){ ?>
<div class="success_holder">
  <div class="row">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
      	  <div class="success_content">
      		  
            <div class="row">
              <div class="col-12 col-sm-12">
                  <div class="row">
                    <div class="col-12 col-sm-3">
                    </div>
                    <div class="col-12 col-sm-6">
                      <span class="card-title"><?php echo $message; ?></span>
                    </div>
                    <div class="col-12 col-sm-3">
                    </div>
                  </div>
                
              </div>
              <div class="col-12 col-sm-12">
                <div class="row">
                  <div class="col-12 col-sm-3">
                  </div>
                  <div class="col-12 col-sm-6">
                    <div>
                      Unesite broj računa za izvršenu transakciju
                    </div>
                    <div>
                      <input type="text" name="purchase_value" value="<?php echo $_GET['card']; ?>">
                    </div>
                    <div>
                      <br/>
                      <a href="javascript:void(0)" onclick="reset_form()" class="btn btn-full">Sačuvajte broj računa</a>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3">
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-12">
                <div class="row">
                  <div class="col-12 col-sm-3">
                  </div>
                  <div class="col-12 col-sm-6">
                    <div>
                      <div>
                        <br/>
                        ili započnite novu transakciju
                      </div>
                      <div>
                        <br/>
                        <a href="javascript:void(0)" onclick="reset_form()" class="btn btn-full">Nova transakcija</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-3">
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
	$('.btn_validate_card').hide();


  
  $('[name="purchase_value"]').val('');
  $('[name="purchase_card_number"]').val('');
  $('[name="purchase_card_password"]').val('');
  $('.purchase_card_number').show();
  $('.purchase_card_password').show();
</script>

<?php }else{ ?>
<div class="error_holder">
  <div class="row">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
    	  <div class="error_content">
    		<span class="card-title">Greška</span>
      		<p><?php echo $message; ?></p>
    	  </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php } ?>
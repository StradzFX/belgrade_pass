<div class="page_content">
	<?php include_once 'app/pages/template/user_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Dodaj kredite na karticu: <?php echo $card->card_number; ?></div>
					<div class="personal_data">
						<div class="row">
							<div class="col-12 col-sm-6">
								<input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
								<div>
									<div>
										Trenutno stanje na kompanijskoj kartici
									</div>
									<div>
										<?php echo $reg_user->card->balance; ?>
									</div>
								</div>

								<div>
									<div>
										Broj kredita
									</div>
									<div>
										<input id="ex2" data-slider-id='ex2Slider' type="text" data-slider-min="0" data-slider-max="<?php echo $slider_max; ?>" data-slider-step="50" data-slider-value="0"/>
                                       	<span id="ex6CurrentSliderValLabel">Uplata: <span id="ex2SliderVal">0</span> RSD</span>
									</div>
								</div>

								<br/>
								<a href="javascript:void(0)" onclick="assign_company_credits()" class="btn btn-full">Dodaj na karticu</a>
							</div>
							<div class="col-12 col-sm-6">
								
							</div>
						</div>
									
					</div>
				</div>
			</div>
				<!-- /. -->	
		</div>
			<!-- /.wrapper-main -->


		</div>
		<!-- /.container -->
	</div>
	<!-- /.form-content -->	
</div>
<!-- /.form-content -->	
<link rel='stylesheet'  href='public/js/bootstrap-slider-master/css/bootstrap-slider.css' type='text/css' media='all' />
<script type='text/javascript' src='public/js/bootstrap-slider-master/bootstrap-slider.js'></script>
<script>


function assign_company_credits(){
	var card_data = {};
		card_data.card_id = $('[name="card_id"]').val();
		card_data.selected_amount = selected_amount;

	start_global_call_loader(); 
    var call_url = "assign_company_credits_to_user";  
    var call_data = { 
        card_data:card_data 
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){
        	show_user_message('success',odgovor.message);
        	setTimeout(function(){
        		document.location = master_data.base_url + 'my_card/';
        	},1500);
        }else{
        	show_user_message('error',odgovor.message);
        }

    }  
    ajax_json_call(call_url, call_data, callback); 
}
var selected_amount = 0;
   // With JQuery
$(function(){
  $('#ex2').bootstrapSlider({
    formatter: function(value) {
      return value + ' RSD';
    }
  });

  $("#ex2").on("slide", function(slideEvt) {
    $("#ex2SliderVal").text(slideEvt.value);
    selected_amount = slideEvt.value;
  });
});

</script>
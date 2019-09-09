<div class="page_content">
	<?php include_once 'app/pages/template/user_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Kupi kredit</div>

					<div>
						<div class="field_title">
							Odaberite koliko kredita želite da uplatite:<br/><br/>
						</div>
                        <div class="field_component">
                           <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="500" data-slider-max="10000" data-slider-step="500" data-slider-value="2500"/>
                           <span id="ex6CurrentSliderValLabel">Uplata: <span id="ex1SliderVal">2500</span> RSD</span>
                        </div>
					</div>

					<div class="form_field">
						<br/>
                      <div class="btn" onclick="buy_credits_personal()">Kupi kredit</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>


<link rel='stylesheet'  href='public/js/bootstrap-slider-master/css/bootstrap-slider.css' type='text/css' media='all' />
<script type='text/javascript' src='public/js/bootstrap-slider-master/bootstrap-slider.js'></script>
<script>
   // With JQuery
$(function(){
  $('#ex1').bootstrapSlider({
    formatter: function(value) {
      return value + ' RSD';
    }
  });

  $("#ex1").on("slide", function(slideEvt) {
    $("#ex1SliderVal").text(slideEvt.value);
    selected_amount = slideEvt.value;
  });

  $("#ex1").on("slideStop", function(slideEvt) {
    $("#ex1SliderVal").text(slideEvt.value);
    selected_amount = slideEvt.value;
  });
});

var selected_amount = 2500;
function buy_credits_personal(){ 

		var user_data = {};
			user_data.selected_amount = selected_amount;

	    start_global_call_loader(); 
	    var call_url = "buy_credits_personal";  
	    var call_data = { 
	        user_data:user_data
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	            setTimeout(function(){
	            	document.location = master_data.base_url+'transakcija/'+odgovor.id;
	            },1500); 
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  

</script>
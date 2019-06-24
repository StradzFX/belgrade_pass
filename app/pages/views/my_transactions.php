  <!-- Modal Structure -->
  <div id="transaction_modal" class="modal">
    <div class="modal-content">
      <h5>Detalji transakcije</h5>
      <p class="transaction_modal_holder">A bunch of text</p>
    </div>
  </div>

<div class="page_content">
	<?php include_once 'app/pages/template/user_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Moje transakcije</div>
					<div class="personal_data">
						<?php if($any_transaction){ ?>
						<div>
							<ul class="nav nav-tabs">
								<li role="presentation" class="payment_option package_payments <?php if($selected_tab == 'package_payments'){ ?>active<?php } ?>">
                                    <a href="javascript:void()" onclick="toggle_transaction_card('package_payments')">
                                       Uplate
                                    </a>
                                </li>
                                <li role="presentation" class="payment_option approved_passes <?php if($selected_tab == 'approved_passes'){ ?>active<?php } ?>">
                                    <a href="javascript:void()" onclick="toggle_transaction_card('approved_passes')">
                                       Potrošnja kredita
                                    </a>
                                </li>
                            </ul>
                            <?php include_once 'app/pages/views/elements/user/transactions/package_payments.php'; ?>
                            <?php include_once 'app/pages/views/elements/user/transactions/approved_passes.php'; ?>
						</div>
						<?php }else{ ?>
						<div class="no_transactions">
							
							<i class="fas fa-credit-card"></i>
							<br/><br/>
							Trenutno nemate nikakve transakcije
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function toggle_transaction_card(option){
        $('.payment_option').removeClass('active');
        $('.'+option).addClass('active');
        $('.paying_option_box').hide();
        $('.payment_option_'+option).show();
    }

	function see_transaction_details(id){
		var data = {};
	        data.id = id;

	    var call_url = "transaction_details";  

	    var call_data = { 
	        data:data 
	    }  

	    var callback = function(response){ 
	    	$('.transaction_modal_holder').html(response);
	      	$('#transaction_modal').modal('open');
	    }  
	    ajax_call(call_url, call_data, callback); 
		


	}

	$(function(){
		$('#transaction_modal').modal();
	});



	function registracija(){

     
  }
</script>
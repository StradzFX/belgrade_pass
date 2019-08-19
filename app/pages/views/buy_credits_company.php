<div class="page_content">
	<?php include_once 'app/pages/template/user_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="personal_data">
						<div class="title">Dodajte kredite na karticu</div>
						<div>
							<div>
								<a href="javascript:void(0)" onclick="add_row()" class="btn">Dodaj novu karticu</a>
							</div>

							<div class="new_card_holder">
								<div class="row">
									<div class="col-12 col-sm-2">
										Kartica
									</div>
									<div class="col-12 col-sm-2">
										Kredita na kartici
									</div>
									<div class="col-12 col-sm-2">
										&nbsp;
									</div>
								</div>
							</div>

							<div>
								<a href="javascript:void(0)" onclick="create_cards()" class="btn">Dodaj kredite</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link rel='stylesheet'  href='public/js/bootstrap-slider-master/css/bootstrap-slider.css' type='text/css' media='all' />
<script type='text/javascript' src='public/js/bootstrap-slider-master/bootstrap-slider.js'></script>
<script>


var row_template = '<div class="row new_user_row row_{id}">\
						<div class="col-12 col-sm-2">\
							<select class="form-control card_select">\
								<option value="">Odaberite karticu</option>\
								<?php for($i=0;$i<sizeof($card_list);$i++){ ?>\
									<option value="<?php echo $card_list[$i]->id; ?>"><?php echo $card_list[$i]->card_number; ?></option>\
								<?php } ?>\
							</select>\
						</div>\
						<div class="col-12 col-sm-2">\
							<input type="text" class="form-control" id="credit_{id}" placeholder="Kredit" name="credits" data-slider-id="credit_{id}" type="text" data-slider-min="500" data-slider-max="10000" data-slider-step="500" data-slider-value="2500">\
						</div>\
						<div class="col-12 col-sm-2">\
							<a href="javascript:void(0)" onclick="remove_row({id})" class="btn">\
								<i class="fa fa-trash"></i>\
							</a>\
						</div>\
					</div>';

var row_counter = 1000;
function add_row(){
	var row_data = row_template;
	row_data = row_data.replace('{id}',row_counter);
	row_data = row_data.replace('{id}',row_counter);
	row_data = row_data.replace('{id}',row_counter);
	row_data = row_data.replace('{id}',row_counter);
	$('.new_card_holder').append(row_data);
	  $('#credit_'+row_counter).bootstrapSlider({
	    formatter: function(value) {
	      return value + ' RSD';
	    }
	  });

	  $("#credit_"+row_counter).on("slide", function(slideEvt) {
	    $("#credit_"+row_counter).text(slideEvt.value);
	    selected_amount = slideEvt.value;
	    $('.row_'+row_counter).find('[name="credits"]').val(slideEvt.value);
	  });

	
	row_counter++;
}

function remove_row(id){
	if($('.new_user_row').length > 1){
		$('.row_'+id).remove();
	}
}

function create_cards(){
	var users = new Array();

	$('.new_user_row').each(function(){
		var user = {};
			user.first_name = $(this).find('[name="first_name"]').val();
			user.last_name = $(this).find('[name="last_name"]').val();
			user.email = $(this).find('[name="email"]').val();
			user.credits = $(this).find('[name="credits"]').val();

			users[users.length] = user;
	});

	if(users.length > 0){
		start_global_call_loader(); 
	    var call_url = "create_cards";  
	    var call_data = { 
	        users:users 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){ 
	        	document.location = 'my_card/';
	        }else{  
	            valid_selector = "error";
	            show_user_message(valid_selector,odgovor.message);
	        }
	    }  
	    ajax_json_call(call_url, call_data, callback); 
	}else{
		valid_selector = "error";
	    show_user_message(valid_selector,'Morate imati barem jednog korisnika');
	}

	

	console.log(users);
}

$(function(){
	add_row();
});


var company_locations = new Array();

<?php for ($i=0; $i < sizeof($company_list); $i++) {  ?>
	var company = {};
		company.id = '<?php echo $company_list[$i]->id; ?>';
		company.locations = new Array();

		<?php for ($j=0; $j < sizeof($company_list[$i]->locations); $j++) {  ?>
		var c_location = {};
			c_location.id = '<?php echo $company_list[$i]->locations[$j]->id; ?>';
			c_location.name = '<?php echo $company_list[$i]->locations[$j]->street; ?>, <?php echo $company_list[$i]->locations[$j]->part_of_city; ?>';
			company.locations.push(c_location);
		<?php } ?>

	company_locations.push(company);
<?php } ?>

function fill_company_locations(){
	var selected_company = $('[name="partner_id"]').val();
	if(selected_company == ''){
		$('.company_location').hide();
	}else{
		$('[name="partner_location"]').html('');
		$('.company_location').show();

		for (var i = company_locations.length - 1; i >= 0; i--) {
			if(company_locations[i].id == selected_company){
				if(company_locations[i].locations.length > 1){
					$('[name="partner_location"]').append('<option value="">Odaberite lokaciju</option>');
				}
				for (var j = company_locations[i].locations.length - 1; j >= 0; j--) {
					var c_location = company_locations[i].locations[j];
					$('[name="partner_location"]').append('<option value="'+c_location.id+'">'+c_location.name+'</option>');
					
				}
			}
		}
		
	}
}

function editProfile(){
	$('#edit_account').slideToggle(400);
}

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
        	location.reload();
        }else{  
            valid_selector = "error";
            show_user_message(valid_selector,odgovor.message);
        }
    }  
    ajax_json_call(call_url, call_data, callback); 
}
</script>

<style type="text/css">
	.card_select{
		padding: 0;
	}
</style>
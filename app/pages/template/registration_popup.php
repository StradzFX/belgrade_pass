<script>

	function facebook_registration(facebook_user){ 
	    start_global_call_loader(); 
	    var call_url = "facebook_registration";  
	    var call_data = { 
	        facebook_user:facebook_user
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success"; 
	            setTimeout(function(){
	            	location.reload();
	            },1500); 
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  

	function website_login(){ 

		var user_data = {};
			user_data.email = $('[name="email_login"]').val();
			user_data.password = $('[name="lozinka_login"]').val();

	    start_global_call_loader(); 
	    var call_url = "website_login";  
	    var call_data = { 
	        user_data:user_data 
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	            setTimeout(function(){
	            	location.reload();
	            },1500); 
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  


	function website_registration(){ 

		var user_data = {};
			user_data.user_type = user_type;
			user_data.selected_amount = selected_amount;
			user_data.selected_amount_legal = selected_amount_legal;
			
			user_data.first_name = $('[name="ime"]').val();
			user_data.last_name = $('[name="prezime"]').val();
			user_data.email = $('.tab_box_'+user_type).find('[name="email"]').val();
			user_data.password = $('.tab_box_'+user_type).find('[name="lozinka"]').val();
			user_data.password_again = $('.tab_box_'+user_type).find('[name="potvrdi_lozinku"]').val();

			user_data.naziv = $('[name="naziv"]').val();
			user_data.adresa = $('[name="adresa"]').val();
			user_data.pib = $('[name="pib"]').val();
			user_data.maticni = $('[name="maticni"]').val();

	    start_global_call_loader(); 
	    var call_url = "website_registration";  
	    var call_data = { 
	        user_data:user_data
	    }  
	    var callback = function(odgovor){  
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success";
	            setTimeout(function(){
	            	if(user_type == 'fizicko'){
	            		document.location = master_data.base_url+'transakcija/'+odgovor.id;
	            	}

	            	if(user_type == 'pravno'){
	            		location.reload();
	            	}


	            	
	            },1500); 
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);      
	}  
</script>
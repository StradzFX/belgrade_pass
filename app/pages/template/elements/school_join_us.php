	<div class="join_us_2">
		<div class="title">
			JOIN US
		</div>

		<div class="col s12 personal_info_holder">
			<div class="row">
				<div class="col s12">
					<div class="message-form">
						Please fill in personal information
					</div>
					<!-- /.message-form -->
				</div>
				<!-- /.col s12 -->
			</div>
			<!-- /.row -->
			<?php include 'app/pages/template/elements/personal_info_no_registration.php'; ?>

		</div>

		<div class="detailed_form">
			<?php include_once 'app/pages/template/elements/school_details.php'; ?>
		</div>

	</div>


	
<?php if($selected_interest){ ?>
	<script>
		$(function(){
			$('#second_step_<?php echo $selected_interest->tag; ?>').show(); 
		});
	</script>
<?php } ?>

<script>  
function save_project_choice_one(){ 

	var selected_option = $('[name="join_us_as"]:checked').length;

	if(selected_option > 0){

		selected_option = $('[name="join_us_as"]:checked').val();

		var selected_option_id = selected_option.split('-');
		var selected_option = selected_option_id[0];
			selected_option_id = selected_option_id[1];

		var project_data = {};
			project_data.project_interest_id = selected_option_id;
			project_data.project_id = '<?php echo $view_project->id; ?>';
			project_data.user_id = '<?php echo $reg_user->id; ?>';

		

		start_global_call_loader(); 
	    var call_url = "save_project_choice_one";  
	    var call_data = { 
	        project_data:project_data
	    }  
	    var callback = function(odgovor){ 
	        finish_global_call_loader(); 
	        if(odgovor.success){  
	            valid_selector = "success"; 
	            $('#first_step').hide(); 
	            $('#second_step_'+selected_option).show(); 
	        }else{  
	            valid_selector = "error";  
	        }  
	        show_user_message(valid_selector,odgovor.message)  
	    }  
	    ajax_json_call(call_url, call_data, callback);  
	}else{
		show_user_message("error","Please choose one interest.");
	}

        
}  


function choose_one(selected_option){
	var is_checked = $('#'+selected_option).is(':checked');

	$('.second_step').addClass('none');
	if(is_checked){
		$('#second_step_'+selected_option).removeClass('none');
		$('.personal_info_holder').removeClass('none');
	}else{
		$('.personal_info_holder').addClass('none');
	}

	$('[name="join_us_as"]:not(#'+selected_option+')').prop('checked',false);
}


function send_email_for_project(tag_name,form_data){ 
    start_global_call_loader(); 
    var project_data = {};
    	project_data.tag_name = tag_name;
    	project_data.form_data = form_data;
    	project_data.project_id = '<?php echo $view_project->id; ?>';
		project_data.user_id = $('[name="user_id"]').val();

		project_data.first_name = $('[name="user_first_name"]').val();
		project_data.last_name = $('[name="user_last_name"]').val();
		project_data.email = $('[name="user_email"]').val();
		project_data.create_account = $('[name="create_account"]').is(':checked');
		project_data.password = $('[name="user_password"]').val();

    var call_url = "send_email_for_project";  
    var call_data = { 
        project_data:project_data
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){  
            valid_selector = "success";
	        $('#second_step_'+tag_name).hide();  
	        $('#first_step').show();  
        }else{  
            valid_selector = "error";  
        }  
        show_user_message(valid_selector,odgovor.message)  
    }  
    ajax_json_call(call_url, call_data, callback);      
}  

</script> 
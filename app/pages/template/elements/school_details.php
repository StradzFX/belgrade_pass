
<div class="wrapper second_step" id="second_step_client">
	<div class="row">
		<div class="col s12">
			<div class="row">
				
				<div class="col s12">
					<div class="headline">
						Additional details
					</div>
					<!-- /.headline -->

					<div class="item-form">
						<div class="input-field">
							<label for="client_description">Select location</label><br/><br/><br/>
				          <select class="browser-default">
				          	<?php for ($i=0; $i < sizeof($school->locations); $i++) { ?> 
				          		<option><?php echo $school->locations[$i]->full_location_display; ?></option>
				          	<?php } ?>
				          	
				          </select>
				        </div>
				        <div class="input-field">
				          <textarea id="client_description" name="client_description" class="materialize-textarea"></textarea>
				          <label for="client_description">Short resume</label>
				        </div>											
				    </div>
				</div>
				<!-- /.col s12 -->
				

				
				<div class="col s12">
					<div class="waves-effect waves-light btn  red darken-1 btn-large send" onclick="send_email_client()">
						Send
					</div>
					<!-- /.button -->
				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.col s9 -->
	</div>
	<!-- /.row -->
</div>
<!-- /.wrapper -->
<script>

	function send_email_client(){
		var form_data = {};
			form_data.tag = 'client';
			form_data.phone = $('[name="client_phone"]').val();
			form_data.company = $('[name="client_company"]').val();
			form_data.website = $('[name="client_website"]').val();
			form_data.country = $('[name="client_country"]').val();
			form_data.description = $('[name="client_description"]').val();
		send_email_for_project('client',form_data);
	}

</script>
<link rel="stylesheet" href="js/wlfileupload/css/config.css">
<link rel="stylesheet" href="js/wlfileupload/css/jquery.fileupload-ui.css">

<script src="js/wlfileupload/vendor/jquery.ui.widget.js"></script>
<script src="js/wlfileupload/jquery.iframe-transport.js"></script>
<script src="js/wlfileupload/jquery.fileupload.js"></script>
<script src="js/wlfileupload/wl_file_upload_production.js"></script>


<script>
	var upload_counter = 0;
  window.onload = function(){

  	

    var file_selector = '#fileupload3';
    var success_callback = function(file){
    	upload_counter++;
    	var uploaded_content = '<div class="uploaded_content_item uploaded_'+upload_counter+'">\
    	<span>'+file.name+'</span><span><i class="fa fa-times" onclick="remove_doc('+upload_counter+')"></i></span>\
    	</div>';
      $('#uploaded_content').append(uploaded_content);
    };
    var add_callback = function(data){};
    set_wl_file_upload(file_selector,success_callback,add_callback);
  }


  function remove_doc(id){
  	$('.uploaded_'+id).remove();
  }

</script>
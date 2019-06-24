<input type="hidden" name="consultant_id" value="<?php echo $konsultant->id; ?>" />

<div class="col s12 m12">
  <div class="message-to-user">
  	Feel free to ask <?php echo $konsultant->ime_prezime; ?> to do services
  	for you by submiting your questions below.
  </div>
</div>
<!-- /.message-to-user -->
<?php /*

<i class="material-icons prefix">work</i>
<i class="material-icons prefix">person_pin_circle</i>
<i class="material-icons prefix">local_phone</i>
<i class="material-icons prefix">mode_edit</i>
*/ ?>
<div class="col s12 m6">
    <div class="input-field">
      <input id="type_of_business" name="type_of_business" type="text"  >
      <label for="type_of_business">
        Full name
      </label>
    </div>
    <div class="input-field">
      <input id="country" name="country" type="text" >
      <label for="country">
         Email
      </label>
    </div>
    <div class="input-field">
      <input id="phone_number" name="phone_number" type="text">
      <label for="phone_number">
         Phone number
      </label>
    </div>
</div>

<div class="col s12 m6">
  <div class="input-field">
    
    <textarea id="message" name="message" class="materialize-textarea">MESSAGE...
Hi <?php echo $coaoch->full_name; ?>, i would like to be part of your team...</textarea>
  </div>
</div>
<div class="col s12 m12 bottom_padding">
  <div align="center">
    <div class="waves-effect waves-light btn  yellow darken-1" onclick="send_message_to_consultant()">
      Send message
    </div>
    <!-- /.button -->
  </div>
</div>


<script>  
function send_message_to_consultant(){ 

	var message_to_consultant_data = {};
		message_to_consultant_data.consultant_id = $('[name="consultant_id"]').val();
		message_to_consultant_data.type_of_business = $('[name="type_of_business"]').val();
		message_to_consultant_data.country = $('[name="country"]').val();
		message_to_consultant_data.phone_number = $('[name="phone_number"]').val();
		message_to_consultant_data.message = $('[name="message"]').val();

    start_global_call_loader(); 
    var call_url = "send_message_to_consultant";  
    var call_data = { 
        message_to_consultant_data:message_to_consultant_data
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){  
            valid_selector = "success";  
        }else{  
            valid_selector = "error";  
        }  
        show_user_message(valid_selector,odgovor.message)  
    }  
    ajax_json_call(call_url, call_data, callback);      
}  
</script> 
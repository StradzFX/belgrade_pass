<div class="row">
	<input type="hidden" name="user_id" value="<?php echo $reg_user ? $reg_user->id: '0'; ?>">
				<div class="col s12">
					<div class="headline">
						Personal Information
					</div>
					<!-- /.headline -->
					<div class="item-form">
						<div class="input-field">
					      <input id="user_first_name" name="user_first_name" type="text" value="<?php echo $reg_user ? $reg_user->first_name : ''; ?>">
					      <label class="active" for="user_first_name">First name</label>
					    </div>
					</div>
					
					<div class="item-form">
						<div class="input-field">
					      <input value="<?php echo $reg_user ? $reg_user->last_name : ''; ?>" id="user_last_name" name="user_last_name" type="text">
					      <label class="active" for="user_last_name">Last name</label>
					    </div>
					</div>
					<div class="item-form">
						<div class="input-field">
					      <input value="<?php echo $reg_user ? $reg_user->email : ''; ?>" id="user_email" name="user_email" type="text">
					      <label class="active" for="user_email">Email</label>
					    </div>
					</div>	
					<div class="item-form">
						<div class="input-field">
					      <input value="<?php echo $reg_user ? $reg_user->email : ''; ?>" id="user_phone" name="user_phone" type="text">
					      <label class="active" for="user_phone">Phone number</label>
					    </div>
					</div>	
				</div>
				<!-- /.col s12 -->
			</div>
			<!-- /.row -->


<script type="text/javascript">
	function wants_account(){
		var is_checked = $('#create_account').is(':checked');
		if(is_checked){
			$('.wants_account').show();
		}else{
			$('.wants_account').hide();
		}
	}
</script>
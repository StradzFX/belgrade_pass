<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Options</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<?php for ($i=0; $i < sizeof($options); $i++) { ?> 
				<div class="col-12 col-sm-3">
					<div class="options_item">
						<div>
							<input type="checkbox" name="company_options" <?php if(in_array($options[$i]['tag'], $company_options_array)){ ?>checked="checked"<?php } ?> id="option_item_<?php echo $i; ?>" value="<?php echo $options[$i]['tag']; ?>">
						</div>
						<label for="option_item_<?php echo $i; ?>">
							<div class="icon">
								<img src="../public/images/options/<?php echo $options[$i]['tag']; ?>.svg">
							</div>
							<div class="name">
								<?php echo $options[$i]['name']; ?>
							</div>
						</label>
						
						
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>
	<div class="box-footer">
      <button type="button" class="btn btn-primary" onclick="save_company_options()">Save options</button>
    </div>
</div>
<!-- /.box -->

<style type="text/css">
	.options_item{
		height: 80px;
		margin-bottom: 10px;
		text-align: center;
		cursor:pointer;
	}

	.options_item:hover .name{
		color: red;
	}
</style>

<script type="text/javascript">
	function save_company_options(){

		var options_data = {};
		var options = new Array();

		$('[name="company_options"]:checked').each(function(){
			options[options.length] = $(this).val();
		});

		options_data.options = options;
		options_data.company = $('[name="id"]').val();
		console.log(options);


      var call_url = "save_company_options";  
      var call_data = { 
        options_data:options_data 
      }  
      var callback = function(response){  
      if(response.success){  
          valid_selector = "success"; 
          alert('You have changed company options');
      }else{  
          valid_selector = "error";
          alert(response.message);
      }  

      }  
      ajax_json_call(call_url, call_data, callback); 
    }
</script>
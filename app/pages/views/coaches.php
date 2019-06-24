<div class="schools">
	<div class="container">
		<div class="page-headline border-green">
			<h2>Coaches</h2>
		</div>
	</div>

	<div class="container">
		<div class="filters">
			<div class="row">
				<div class="col s12 m6">
					<input type="text" name="search_text" onkeyup="search()" class="browser-default" placeholder="Pretraga po ključnim recima" />
				</div>
				<div class="col s12 m2">
					<select name="category" onchange="search()" class="browser-default">
						<option value="">All categories</option>
						<?php for ($i=0; $i < sizeof($list_categories); $i++) { ?>
							<option value="<?php echo $list_categories[$i]->id; ?>">
								<?php echo $list_categories[$i]->name; ?>
							</option>
						<?php } ?>
					</select>
				</div>
				<div class="col s12  m6">
					Age:<br/>
					 <div id="test-slider"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="search_content">
			<div>
				<div class="search_list coaches">
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.top-cover -->

<script type="text/javascript">

	function search_for_coahces(){
		var filters = get_search_filters();

        var call_url = "get_coaches_list";  
        var call_data = { 
          filters:filters 
        }  
        var callback = function(response){  
        	$('.search_list').html(response);
        }  
        ajax_call(call_url, call_data, callback);
	}

	

	function get_search_filters(){
		var filters = {};
			filters.search_text = $('[name="search_text"]').val();
			filters.category = $('[name="category"]').val();
			filters.location = $('[name="location"]').val();
			

		return filters;
	}

	function search(){
		search_for_coahces();
	}


	$(function(){
		search();
	});


	 

</script>
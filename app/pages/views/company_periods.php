<div class="page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Termini</div>
					<br/>
					<div class="personal_data">
						<div class="calendar_items calendar_js" id="wrap">
							<div id="calendar"></div>
							<div style="clear:both"></div>
							<div id="calendar_js"></div>
						</div>
						<div class="calendar_items calendar_manage_day" style="display: none;">
							
						</div>
					</div>
				</div>
			</div>
				<!-- /. -->	
		</div>
			<!-- /.wrapper-main -->


		</div>
		<!-- /.container -->
	</div>
	<!-- /.form-content -->	
</div>
<!-- /.form-content -->	

<div id='wrap'>

<div id='calendar'></div>

<div style='clear:both'></div>
</div><div id='wrap'>

<div id='calendar'></div>

<div style='clear:both'></div>
</div>
<link rel="stylesheet" href="public/js/fullcalendar-3.10.0/fullcalendar.min.css" type="text/css" media="screen" />
<script src="public/js/moment.js"></script>
<script src="public/js/fullcalendar-3.10.0/fullcalendar.min.js"></script>
<style type="text/css">
	.fc-highlight-skeleton td{
		cursor: pointer;
	}

	.fc-content-skeleton td{
		cursor: pointer;
	}
</style>
<script>
	var calendar = null;
	function get_calendar_view(){

	    var call_url = "get_calendar_view";  

	    var call_data = { 
	        data:'data' 
	    }  

	    var callback = function(response){
	    	calendar = null;
	    	

	      	$('.calendar_items').hide();
	      	$('.calendar_js').show();

	      	$('#calendar').html('');
	      	$('#calendar_js').html(response);

	    }  

	    ajax_call(call_url, call_data, callback); 
	}

	function go_back_to_calndar(){
		get_calendar_view();
		//$('.calendar_items').hide();
	    //$('.calendar_js').show();
	}

	function get_calendar_day_list(start,end,allDay){
		var call_url = "get_calendar_day_list";  

		var data = {};
			data.start = formatDate(start);
			data.end = formatDate(end);
			data.all_day = allDay;

	    var call_data = { 
	        data:data 
	    }  

	    var callback = function(response){
	      	$('.calendar_manage_day').html(response);

	      	$('.calendar_items').hide();
	      	$('.calendar_manage_day').show();

	    }  

	    ajax_call(call_url, call_data, callback); 
	}

	function get_calendar_day_list_start(start){
		var call_url = "get_calendar_day_list";  

		var data = {};
			data.start = start;
			data.end = start;
			data.all_day = false;

	    var call_data = { 
	        data:data 
	    }  

	    var callback = function(response){
	      	$('.calendar_manage_day').html(response);

	      	$('.calendar_items').hide();
	      	$('.calendar_manage_day').show();

	    }  

	    ajax_call(call_url, call_data, callback); 
	}

	$(function(){
		get_calendar_view();
	});

	function formatDate(date) {
    var d = new Date(date),
	        month = '' + (d.getMonth() + 1),
	        day = '' + d.getDate(),
	        year = d.getFullYear();

	    if (month.length < 2) month = '0' + month;
	    if (day.length < 2) day = '0' + day;

	    return [year, month, day].join('-');
	}
</script>
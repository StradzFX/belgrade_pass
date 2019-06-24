// JavaScript Document
var ajax_debugger = false;

function start_debugger(){
	ajax_debugger = true;
	ajax_command_number = 0;
	$("body").prepend('<div class="website_debugger">\
	<div class="website_debugger_title">AJAX DEBUGGER</div>\
	<div class="website_debugger_content"></div>\
	<div class="website_debugger_close"><a href="javascript:void(0)" onclick="clear_debugger()">Clear debugger</a> | <a href="javascript:void(0)" onclick="close_debugger()">Close</a></div>\
	</div>')
}
var ajax_command_number = 0;
function clear_debugger(){
	$(".website_debugger_content").html("");
	
}

function close_debugger(){
	$(".website_debugger").fadeOut(300);
}

function debugg_command_echo(call_url,call_data,output,ajax_type,callback){
	ajax_command_number++;
	$(".website_debugger").fadeIn(300);
	$(".website_debugger_content").append('<div class="debugg_command" id="debugg_command_'+ajax_command_number+'"></div>');
	$('#debugg_command_'+ajax_command_number).append('CALL NUMBER: '+ajax_command_number+' <br/><br/><b>CALL URL</b>: php/ajax/'+call_url+'<br /><br />');
	$('#debugg_command_'+ajax_command_number).append('<div class="debugg_data"><b>CALL DATA</b>: <br />{<div id="debugg_content_data"></div>}');
	for(var key in call_data) {
		$('#debugg_command_'+ajax_command_number).find('#debugg_content_data').append('<li>'+key+' : '+call_data[key]+'</li>');
	}
	$('#debugg_command_'+ajax_command_number).append('<div><b>OUTPUT:</b><br /><br /><div id="debugger_output_content"></div></div>');
	if(ajax_type == 'ajax_json_call'){
		$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> AJAX JSON CALL is called<br/>');
		if(typeof(output) == 'object'){
			$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> <span style="color:#009900">Output is JSON object</span><br/>');
			$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> Output data: <br/>{<br/>');
			for(var key in output) {
				$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<li>'+key+' : '+output[key]+'</li>');
			}
			$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('}');
		}else{
			$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> <span style="color:#900">Output is NOT an JSON object</span><br/>');
			$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> OUTPUT IS: <br />'+output);
		}
	}
	if(ajax_type == 'ajax_call'){
		$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> AJAX CALL is called<br/>');
		$('#debugg_command_'+ajax_command_number).find('#debugger_output_content').append('<b>Status:</b> OUTPUT IS: <br />'+output);
	}
	
}

function ajax_call(call_url,call_data,callback){
	
	$.ajax({
	  type: "POST",
	  url: call_url,
	  data:call_data,
	  cache: false,
	  success:function(d,t,h){callback(d);debugg_command_echo(call_url,call_data,d,"ajax_call",callback);},
	  error:function(jqXHR){
		if (jqXHR.status === 0) {
			//alert('URL Address is not with www parameter.');
		} else if (jqXHR.status == 403) {
			//alert('PHP File is not implemented in .htaccess file. [403]');
		} else if (jqXHR.status == 404) {
			//alert('Requested page not found. [404]');
		} else if (jqXHR.status == 500) {
			//alert('Internal Server Error [500].');
		} else if (exception === 'parsererror') {
			//alert('Requested JSON parse failed.');
		} else if (exception === 'timeout') {
			//alert('Time out error.');
		} else if (exception === 'abort') {
			//alert('Ajax request aborted.');
		} else {
			//alert('Uncaught Error.\n' + jqXHR.responseText);
		}
	  }
	});
}

function ajax_json_call(call_url,call_data,callback){
	$.ajax({
	  type: "POST",
	  dataType: "json",
	  url: call_url,
	  data:call_data,
	  cache: false,
	  success:function(d,t,h){callback(d);debugg_command_echo(call_url,call_data,d,"ajax_json_call",callback);},
	  error:function(jqXHR){
		  debugg_command_echo(call_url,call_data,jqXHR.responseText,"ajax_json_call",callback);
		if (jqXHR.status === 0) {
		} else if (jqXHR.status == 403) {
		} else if (jqXHR.status == 404) {
		} else if (jqXHR.status == 500) {
		}
	  }
	});
}

/* ================================= LOADER ==================================================== */
function change_loader_dimensions(){

	var size = {
		width: window.innerWidth,
		height: window.innerHeight
	}
	
	$('#loader').css(size);
	
	var position = {
		top: (window.innerHeight*0.50)-(($("#loader_position").height()+22.5)/2)
	}
	
	$('#loader_position').css({marginTop:position.top});

};

$(document).ready(change_loader_dimensions);
$(window).resize(change_loader_dimensions);
$(document).scroll(function() {
	var scrool_top = $(window).scrollTop();
	var position = {
		top: (window.innerHeight*0.50)-(($("#loader_position").height()+22.5)/2)
	}
	$('#loader_position').css({marginTop:position.top});	
});


var global_call_time_out = '';

function start_global_call_loader(){
	global_call_time_out = setTimeout(function(){
		if(global_call_time_out != ''){
			$('#loader').fadeIn(300);
		}
	},500); 
}

function finish_global_call_loader(){
	clearTimeout(global_call_time_out);
	global_call_time_out = '';
	$('#loader').fadeOut(300);
}

/* ================================= SHOW USER MESSAGE ==================================================== */
var global_user_message_time_out = '';
function show_user_message(message_type,message_content){
	
	if(global_user_message_time_out != ''){
		clearTimeout(global_user_message_time_out);
		global_user_message_time_out = '';
	}
	
	$('.website_system_message').slideUp(0);
	$('.website_system_message').html(message_content);
	
	$('.website_system_message').removeClass('info');
	$('.website_system_message').removeClass('error');
	$('.website_system_message').removeClass('warning');
	$('.website_system_message').removeClass('success');

	$('.website_system_message').addClass(message_type);
	
	$('.website_system_message').slideDown(300);
	$('.website_system_message').animate({top:"0"}, 500);
	
	global_user_message_time_out = setTimeout(function(){
		$('.website_system_message').slideUp(300);
	},3500);				 
}

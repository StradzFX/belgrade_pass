// JavaScript Document
var _master_facebook_page_url = "https://www.facebook.com/"+facebook_page+"/";
var _app_url = 'app_'+facebook_app;

function cl_ajax_start(function_name,stage){
	console.log('f('+function_name+') => Ajax stage: '+stage);
}

function share_application(){
	var share_box = {};
		share_box.url = _master_facebook_page_url+_app_url;
		share_box.picture = master_data.base_url+'images/ogp/app_share.jpg';
		share_box.name = "Title :: Facebook";
		share_box.caption = "Opis share box";
		facebook_share_box(share_box);
}

//======================== AJAX CALLBACKS ===========================================

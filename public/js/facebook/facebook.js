// JavaScript Document
function load_facebook(app_id){
	FB.init({appId: app_id, status: true, cookie: true});
}

function set_canvas(f_height){
	FB.Canvas.setSize({ width: 810, height: f_height});
}

function facebook_login(f_callback,f_scope) {
	FB.login(f_callback,{scope:f_scope});
}	
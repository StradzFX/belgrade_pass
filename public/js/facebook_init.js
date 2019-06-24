// VARIBLES TO CHAGE
	//FB ID
	var facebook_app_id = facebook_app;

	// CANVAS VARIABLES FOR PAGE TAB
	var _to_set_canvas_height = false;
	var _default_canvas_height = facebook_canvas;

	// CANVAS HEIGTH INTERVAL
	var _set_interval_canvas = false;
	var _set_interval_canvas_time = 200;

// DO NOT CHAGE THESE VARIALBLES
var _tab_canvas_selector = "";

$(function(){
	if(_to_set_canvas_height){
		if(_set_interval_canvas){
			setInterval(function(){
				set_tab_canvas(_tab_canvas_selector);
			},_set_interval_canvas_time);
		}else{
			set_canvas(_default_canvas_height);
		}
	}
});

if(facebook_app_id != ''){
	load_facebook(facebook_app_id);
	/*
	if(_to_set_canvas_height){
		set_canvas(_default_canvas_height);
		console.log("Canvas height is set to "+_default_canvas_height+"px");
	}*/
}

function set_tab_canvas_selector(selector){
	_tab_canvas_selector = selector;
}

function set_tab_canvas(selector){
	if(_tab_canvas_selector != ""){
		if(facebook_app_id != ''){
			set_canvas($(selector).height());
		}else{
			console.log("Facebook App ID is not defined");
		}
	}else{
		console.log("Set tab canvas selector is not defined.");
	}
}

function fb_login(){
	var fb_login_obj = {};
	fb_login_obj.success = false;
	fb_login_obj.data = null;
	fb_login_obj.message = "Facebook App ID is not defined.";
	if(facebook_app_id != ''){
		var f_scope = 'email'; 
		var f_callback = function(response){
			if (response.authResponse) {
				FB.api('/me?fields=id,name,first_name,last_name,email', function(response) {
					fb_login_obj.success = true;
					fb_login_obj.data = response;
					fb_login_obj.message = "User has give us data";
					var facebook_user = {};
					facebook_user.fb_id = response['id'];
				    facebook_user.name = response['name'];
				    facebook_user.email = response['email'];
				    facebook_user.first_name = response['first_name'];
				    facebook_user.last_name = response['last_name'];
				    facebook_registration(facebook_user);
				});
			}else{
				fb_login_obj.message = "Facebook User does not applies with rules of application.";
			}
		}
		facebook_login(f_callback,f_scope)
	}else{
		alert(fb_login_obj.message);
	}
	return fb_login_obj;
}

function facebook_share_box(share_box_obj,feed_callback_custom){
	var feed_callback = function(){
		
	};
	if(!feed_callback_custom){
		feed_callback = feed_callback_custom;
	}
	var obj = {
		method: 'feed',
		link: share_box_obj.url,
		picture: share_box_obj.picture,
		name: share_box_obj.title,
		caption: share_box_obj.caption,
		description: share_box_obj.description
	};
	FB.ui(obj, feed_callback);
}
// JavaScript Document
function change_scene(scene_name){
	$('.scene').hide();
	$('.'+scene_name).show();
}

function go_to_register(){
	if(facebook_user.id == 0){
		fb_login('register_scene');
	}else{
		$(".scene").hide();
    	$(".register_scene").show();
	}
}

function go_to_gallery(){
	get_gallery();
	if(facebook_user.id == 0){
		fb_login('gallery_scene');
	}else{
		$(".scene").hide();
    	$(".gallery_scene").show();
	}
}

function go_to_home(){
	$(".scene").hide();
    $(".home_scene").show();
}

function go_to_upload(){
	$(".scene").hide();
    $(".upload_photo_scene").show();
}

function go_to_top_list(){
	$(".scene").hide();
    $(".top_list_scene").show();
}

// JavaScript Document
$(function(){
	var development = false;
	var facebook_simulation = true;
	var set_cookie = false;

	var do_insert_facebook_user = false;
	var do_insert_facebook_contestant = false;
	

	//===================== COOKIE SETUP ==================================
	var cookie_name = master_data.website_name;
	if(check_cookie(cookie_name+'_seed_cookie')){
		set_cookie(cookie_name+'_seed_cookie','development_value',10);
	}
	
	//===================== SEED ACTION ==================================
	if(development){

		//====================== FACEBOOK USER ===========================
		if(do_insert_facebook_user){
			facebook_user = {};
			if(facebook_simulation){
				facebook_user.id = 0;
			}else{
				facebook_user.id = 1;
			}
			facebook_user.fb_id = '10153194385936680';
			facebook_user.name = 'Strahinja Krstic';
			facebook_user.email = 'strahinja.krstic@gmail.com';
			insert_facebook_user('');


				//====================== FACEBOOK COTESTANT ======================
				if(do_insert_facebook_contestant){
					var contestant_interval = "";
					contestant_interval = setInterval(function(){
						if(facebook_user.id != 0){

							facebook_contestant = {};
							facebook_contestant.id = 0;
						    facebook_contestant.facebook_user = facebook_user;
						    
						    insert_facebook_contestant();
							clearInterval(contestant_interval);
						}
					},200);
				}
		}

		//================== SEED COOKIE CUSTOM ACTION =====================
		if(check_cookie(cookie_name+'_seed_cookie')){
			$(".scene").hide();
            $(".home_scene").show();
		}


		//====================== CUSTOM ACTIONS ============================
		$('.code_alert').hide();
	}
});
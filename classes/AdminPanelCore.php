<?php

class AdminPanelCore{
	public static function run(){
		self::validate_admin_access();
		self::show_page();
	}

	public static function validate_admin_access(){
		global $page,$url_params;
		$page = $url_params[0];
		array_shift($url_params);
		if(!$_SESSION['admin']){
			if(!in_array($page,array('login','login_user'))){
				$page = 'login';
			}
		}
	}


	public static function show_page(){
		global $page,$url_params,$broker;
		$page = $page == '' ? 'home' : $page;
		self::run_root_page($page);
		self::run_ajax_page($page);
		self::run_error_page($page);
		
	}


	public static function run_root_page($page){
		global $url_params,$page,$base_url,$broker;
		include 'app/pages/logic/inc/wp_svg_icons.php';
		if($page == 'login'){
			include_once 'app/pages/admin/logic/'.$page.'.php';
			include_once 'app/pages/template/admin/header_login.php';
			include_once 'app/pages/admin/views/'.$page.'.php';
			include_once 'app/pages/template/admin/footer_login.php';
			die();
		}else{
			if(is_file('app/pages/admin/views/'.$page.'.php')){
				include_once 'app/pages/admin/logic/'.$page.'.php';
				include_once 'app/pages/template/admin/header.php';
				include_once 'app/pages/admin/views/'.$page.'.php';
				include_once 'app/pages/template/admin/footer.php';
				die();
			}
		}
		
	}

	public static function run_ajax_page($page){

		$ajax_folders = array('','users_manage/','card_info/','company_manage/');

		global $url_params,$page,$base_url;
		include 'app/pages/logic/inc/wp_svg_icons.php';

		for ($i=0; $i < sizeof($ajax_folders); $i++) {
			$ajax_folder = $ajax_folders[$i]; 
			if(is_file('app/ajax/admin/'.$ajax_folder.$page.'.php')){
				$post_data = self::prepare_post_data($_POST);
				if($_POST){
					include_once 'app/ajax/admin/'.$ajax_folder.$page.'.php';
				}else{
					echo "No such POST was made against this page.";
				}
				die();
			}
		}

		
		
	}

	public static function run_error_page($page){

	}

	public static function prepare_post_data($input){
		$post_data = array();

		foreach($input as $item=>$value){
			if(is_array($value)){
				$post_data[$item] = self::addslashes_recursive($value);
			}else{
				$post_data[$item] = addslashes($value);
			}
		}

		return $post_data;
	}

	public static function addslashes_recursive($input){
		if(is_array($input)){
			return array_map('self::addslashes_recursive', $input );
		}else{
			return addslashes( $input );
		}
	}
}
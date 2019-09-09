<?php

class CoreConfig{

	public static $configuration_folder = 'php/core/config/';
	public static $development = false;

	public static function run(){
		self::load_enviroment();
		self::load_configuration(self::$configuration_folder);
		self::load_server_settings();
		self::load_database();
		self::load_seo();
		self::load_base_url();
		self::load_app();

		self::load_default_js_and_css();
		self::load_page();
	}

	public static function load_enviroment(){
		global $_CORE;

		$_CORE = array();

		$_CORE['env']['enviroment'] = 'production';
		if(getenv('xenon_env')){
			$_CORE['env']['enviroment'] = getenv('xenon_env');
		}
	}

	public static function load_configuration($_CONFIGURATION_FOLDER){
		global $_CORE;

        $configurations = scandir($_CONFIGURATION_FOLDER);
        array_shift($configurations);
        array_shift($configurations);

        for($i=0;$i<sizeof($configurations);$i++){
            $file = $configurations[$i];
            $configuration_name = explode('.', $file);
            $configuration_name = $configuration_name[0];

            $configuration_json = file_get_contents($_CONFIGURATION_FOLDER.$file);
            $configuration_json = json_decode($configuration_json,true);
            $configuration_json = $configuration_json[$_CORE['env']['enviroment']];

            if(!$configuration_json){
               //error_log('Could not find "'.$configuration_name.'" configuration for enviroment: '.$_CORE['env']['enviroment']);
            }
            $_CORE[$configuration_name] = $configuration_json;
        }

	}

	public static function load_server_settings(){
		mb_internal_encoding("UTF-8");
		date_default_timezone_set("Europe/Belgrade");
	}

	public static function load_database(){
		global $broker,$_CORE;
		require_once "classes/database/db_broker.php";
		$broker = new db_broker($_CORE['database']);
	}

	public static function load_seo(){
		global $seo;
		require_once "classes/controller/seo/seo_generator.class.php";
		$seo = new seo_generator();
	}

	public static function load_base_url(){
		global $base,$base_url;
		$http_host = $_SERVER["HTTP_HOST"];
		$script_name = $_SERVER["SCRIPT_NAME"];
		$script_name = str_replace("index.php","",$script_name);

		if(isset($_SERVER["HTTPS"])){
			$http_prefix = "https://";	
		}else{
			$http_prefix = "http://";	
		}

		$base = $script_name;
		$base_url = $http_prefix.$http_host.$script_name;
	}

	public static function load_app(){
		self::load_domain_classes();
		self::load_controllers();
		self::load_modules();
	}

	public static function load_domain_classes(){
		$class_path = "classes/domain/";
		$spisak_fajlova = scandir($class_path);
		array_shift($spisak_fajlova);
		array_shift($spisak_fajlova);
		for($i=0;$i<sizeof($spisak_fajlova);$i++){
			if($spisak_fajlova[$i] != "base_domain_object.php"){
				require_once $class_path.$spisak_fajlova[$i];
			}
		}
	}

	public static function load_controllers(){
		$modules_path = "app/controllers/";
		$list_modules = scandir($modules_path);
		array_shift($list_modules);
		array_shift($list_modules);
		for($i=0;$i<sizeof($list_modules);$i++){
			require_once $modules_path.$list_modules[$i];
		}

	}

	public static function load_modules(){
		$modules_path = "app/modules/";
		$list_modules = scandir($modules_path);
		array_shift($list_modules);
		array_shift($list_modules);
		for($i=0;$i<sizeof($list_modules);$i++){
			require_once $modules_path.$list_modules[$i];
		}
	}

	public static function load_default_js_and_css(){

		global $default_css_files,$default_js_files;

		$default_js_files = array();
		$default_js_files[] = "public/js/facebook_config.js";
		$default_js_files[] = "public/js/ajax_call.js";
		$default_js_files[] = "public/js/cookie.js";
		$default_js_files[] = "public/js/draggable.js";
		$default_js_files[] = "public/js/master.js";
		$default_js_files[] = "public/js/jquery_ui/jquery-ui.min.js";
		$default_js_files[] = "https://connect.facebook.net/en_US/all.js";
		$default_js_files[] = "public/js/facebook/facebook.js";
		$default_js_files[] = "public/js/facebook_init.js";
		$default_js_files[] = "public/js/html2canvas.js";
		$default_js_files[] = "public/js/facebook_app/scenes.js";
		$default_js_files[] = "public/js/facebook_app/buttons.js";
		$default_js_files[] = "public/js/facebook_app/seed.js";

		$valid_js_files = array();
		for($i=0;$i<sizeof($default_js_files);$i++){
			if(file_exists($default_js_files[$i]) || 
				strpos($default_js_files[$i],"http") !== false  || 
				strpos($default_js_files[$i],"https") !== false  || 
				strpos($default_js_files[$i],"//") !== false){
				$valid_js_files[] = $default_js_files[$i];
			}
		}
		$default_js_files = $valid_js_files;

		$default_css_files = array();
		$default_css_files[] = "public/css/collector.css";

		$valid_css_files = array();
		for($i=0;$i<sizeof($default_css_files);$i++){
			if(file_exists($default_css_files[$i]) || 
				strpos($default_css_files[$i],"http") !== false || 
				strpos($default_css_files[$i],"https") !== false|| 
				strpos($default_css_files[$i],"//") !== false){
				$valid_css_files[] = $default_css_files[$i];
			}
		}
		$default_css_files = $valid_css_files;

	}


	public static function load_page(){
		global $page,$url_params,$base,$seo,$base_url,$default_css_files,$default_js_files,$broker;

		$tr_types = array();
		$tr_types['purchase_post_office'] = 'Uplatnica';
		$tr_types['purchase_card'] = 'Platna kartica';
		$tr_types['purchase_company'] = 'Uplata kod parttnera';

		$_SERVER["REQUEST_URI"] = explode("?",$_SERVER["REQUEST_URI"]);
		$_SERVER["REQUEST_URI"] = $_SERVER["REQUEST_URI"][0];

		$url_params = array_slice(explode($base,$_SERVER["REQUEST_URI"]),1);
		if($base != "/")
		    $url_params = explode("/",$url_params[0]);
		$page = $url_params[0];


		$url_params = array_slice($url_params,1);

		$system_page = false;
		include_once "php/pages.php";
	}
}
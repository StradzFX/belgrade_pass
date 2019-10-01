<?php

class MasterController{

	public static $seo_data = null;

	public static function validate_user_session(){
		global $broker;

		$reg_user = $broker->get_session('user');
		if($reg_user){
			header('Location:'.$base_url.'profile/');
			die();
		}

	}

	public static function set_seo($title,$keywords,$description,$picture,$url){
		$seo_data = array(
			'title' => $title,
			'keywords' => $keywords,
			'description' => $description,
			'picture' => $picture,
			'url' => $url,
		);

		self::$seo_data = $seo_data;
	}


	public static function display($page_name,$data=array()){
		include_once 'app/website/template/header.php';
		include_once 'app/website/views/'.$page_name.'.php';
		include_once 'app/website/template/footer.php';
	}
}
<?php

class xenon_functions{

	private $page;

	public function __construct($page){
		$this->page = $page;
	}

	public function validate_user(){
		if(!$this->has_user_all_right() || !$this->has_user_right_to_create_record()){
			header ("Location: ".$_SERVER["PHP_SELF"]);
		}
	}

	private function has_user_all_right(){
		if($_SESSION[ADMINAUTHDC][0] == "All"){
			return true;
		}else{
			$this->has_user_right_to_access_page();
		}
	}

	private function has_user_right_to_access_page(){
		return in_array($this->page,$_SESSION[ADMINAUTHDC]);
	}

	private function has_user_right_to_create_record(){
		return $_SESSION[ADMINMAKER] == 1;
	}
}
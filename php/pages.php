<?php

function prepare_post_data($input){
	$post_data = array();

	foreach($input as $item=>$value){
		if(is_array($value)){
			$post_data[$item] = addslashes_recursive($value);
		}else{
			$post_data[$item] = addslashes($value);
		}
	}

	return $post_data;
}

function addslashes_recursive($input){
	if(is_array($input)){
		return array_map('addslashes_recursive', $input );
	}else{
		return addslashes( $input );
	}
}

$post_data = prepare_post_data($_POST);

$page = $page != '' ? $page : 'home';

$page_folders = array();
$page_folders[] = 'app/pages/views/';
$page_folders[] = 'app/ajax/';
$page_folders[] = 'app/ajax/admin_control_panel/';
$page_folders[] = 'php/';
$page_folders[] = 'php/ajax/';

$root_page_folder = 'app/pages/views/';

include_once 'app/pages/logic/inc/wp_svg_icons.php';

if($page == 'home'){
	include_once 'app/pages/logic/'.$page.'.php';
		include_once 'app/pages/template/header_home.php';
		include_once 'app/pages/views/'.$page.'.php';
		include_once 'app/pages/template/footer_home.php';
}else{
	if(is_file($root_page_folder.$page.'.php')){
		include_once 'app/pages/logic/'.$page.'.php';
		include_once 'app/pages/template/header.php';
		include_once 'app/pages/views/'.$page.'.php';
		include_once 'app/pages/template/footer.php';
	}else{
		for($i=0;$i<sizeof($page_folders);$i++){
			if (is_file($page_folders[$i].$page.'.php')) {
				include_once $page_folders[$i].$page.'.php';
				$system_page = true;
				break;
			}
		}
	}
}
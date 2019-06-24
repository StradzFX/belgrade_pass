<?php
/*
Plugin Name: Transiz Routes
Plugin URI: http://plugins.transiz.com/
Description: Plugin for showing your offers from Transiz on your company website.
Author: Transiz
Version: 1.0
*/
	function transizroutes_func($atts) {
		$a = shortcode_atts(array(
			'company' => '0',
			'lang' => 'en',
			'theme' => 'belizehole',
			'height' => '500px',
			'width' => '100%'
		), $atts);

		$a['height'] = preg_replace( '/[^0-9%px]/', '', $a['height']);
		$a['width'] = preg_replace( '/[^0-9%px]/', '', $a['width']);

		return '<iframe src="http://plug.transiz.com/routes/?lang='.$a['lang'].'&company='.$a['company'].'&theme='.$a['theme'].'" frameBorder="0" width="'.$a['width'].'" height="'.$a['height'].'"></iframe>';
	}

	function register_transizroutes() {
		add_shortcode('transizroutes', 'transizroutes_func');
	}

	add_action('init', 'register_transizroutes');
?>
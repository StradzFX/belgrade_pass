<?php

class RegistracijaController extends MasterController{

	public static function index(){

		self::validate_user_session();

		self::set_seo(
			"Belgrade Pass - Registracija",
			'registracija, moj nalog, nalog, belgrade pass',
			'Registrujte svoj nalog na BelgradePass-u i odmah krenite da koristite naše pogodnosti.',
			$base_url.'public/images/default.jpg',
			$base_url.'registracija'
		);
		self::display('registracija');
	}
}
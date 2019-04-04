<?php 
	session_start();
	$GLOBALS['config']=array(
		'mysql' => array(
			'host' => 'mysql.hostinger.web.tr',
			'kullanici_adi' => 'u874667569_test',
			'sifre' => '>ruh5>Jpq$VgpjE^9o',
			'db' =>'u874667569_test'
			),
		'hatirla' => array(
			'cookie_ismi' => 'hash',
			'cookie_bitis' => 604800
			),
		'session' =>array(
			'session_ismi' => 'kullanici',
			'token_ismi' => 'token'
			)
	);
	spl_autoload_register(function($class){
		require_once 'class/'.$class.'.php';
	});
	require_once 'fonksiyon/filtrele.php';
	if (Cookie::varsa(Config::getir('hatirla/cookie_ismi')) && !Session::varsa(Config::getir('session/session_ismi'))) {
		$hash = Cookie::getir(Config::getir('hatirla/cookie_ismi'));
		$hashKontrol = DB::baglan()->getir('uye_session', array('hash','=',$hash));
		if ($hashKontrol->sayac()) {
			$kullanici = new Kullanici($hashKontrol->ilk()->kullanici_id);
			$kullanici->giris();
		}
	}
?>
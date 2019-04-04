<?php 
	class Token{
		public static function olustur(){
			$tokenIsmi = Config::getir('session/token_ismi');
			if (Session::varsa($tokenIsmi) && Session::getir($tokenIsmi)=="token") {
				Session::sil($tokenIsmi);
				return true;
			}
			return Session::yerlestir(Config::getir('session/token_ismi'),md5(uniqid()));
		}
		public static function kontrol($token){
			$tokenIsmi = Config::getir('session/token_ismi');
			if (Session::varsa($tokenIsmi) && $token==Session::getir($tokenIsmi)) {
				return true;
			}
			return false;
		}
	}
?>
<?php 
	class Session{
		public static function yerlestir($isim,$deger){
			return $_SESSION[$isim]=$deger;
		}
		public static function varsa($isim){
			return isset($_SESSION[$isim])?true:false;
		}
		public static function getir($isim){
			return $_SESSION[$isim];
		}
		public static function sil($isim){
			if (self::varsa($isim)) {
				unset($_SESSION[$isim]);
			}
		}
		public static function flash($isim, $string=null){
			if (self::varsa($isim)) {
				$session = self::getir($isim);
				self::sil($isim);
				return $session;
			}else{
				self::yerlestir($isim,$string);
			}
			return '';
		}
	}
?>
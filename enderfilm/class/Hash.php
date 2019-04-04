<?php 
	class Hash{
		public static function yap($string,$salt=''){
			return hash('sha256',$string.$salt);
		}
		public static function salt($uzunluk){
			return mcrypt_create_iv($uzunluk);
		}
		public static function unique(){
			return self::yap(uniqid());
		}
	}
?>
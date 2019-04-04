<?php 
	class Config{
		public static function getir($yol=null){
			if($yol){
				$config = $GLOBALS['config'];
				$yol = explode("/",$yol);
				foreach ($yol as $bit) {
					if(isset($config[$bit])){
						$config=$config[$bit];
					}
				}
			return $config;
			}
		return false;
		}
	}
 ?>
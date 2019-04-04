<?php 
	class Input{
		public static function varsa($tur='post'){
			switch ($tur) {
				case 'post':
					return (!empty($_POST))?true:false;
					break;
				case 'get':
					return (!empty($_GET))?true:false;
					break;
				case 'files':
					return (!empty($_FILES))?true:false;
					break;
				default:
					return false;
					break;
			}
		}
		public static function getir($alan){
			if (isset($_POST[$alan])) {
				return $_POST[$alan];
			}else if (isset($_GET[$alan])) {
				return $_GET[$alan];
			}else if (isset($_FILES[$alan]['name'])){
				return $_FILES[$alan]['name'];
			}
			return '';
		}
	}
?>
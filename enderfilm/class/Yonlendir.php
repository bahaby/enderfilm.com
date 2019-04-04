<?php 
	class Yonlendir{
		public static function git($konum=null){
			if ($konum) {
				if (is_numeric($konum)) {
					switch ($konum) {
						case 404:
							header('HTTP/1.0 404 Not Found');
							include('include/hatalar/404.php');
							exit();
							break;
						
						default:
							# code...
							break;
					}
				}
			}
			header('location: '.$konum);
			exit();
		}
	}
?>
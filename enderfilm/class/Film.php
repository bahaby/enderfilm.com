<?php 
	include 'SimpleImage.php';
	class Film extends SimpleImage{
		private $_db;
		public function __construct(){
			$this->_db=DB::baglan();
		}
		public function guncelle($alanlar =array(),$id,$resim_bot){
			$ekle=array('ham_resim','b_resim','k_resim','a_resim');
			if ($this->_db->guncelle('film',$id,$alanlar)) {
				if ($_FILES["resim"]["name"]!="") {
					$resim=$_FILES["resim"];
					$tmp=$resim['tmp_name'];
					$resim_adi=$alanlar["resim"];
					$img=new SimpleImage($tmp);
				}else if ($_FILES["resim"]["size"]==0&&$resim_bot!="") {
					$resim_adi=$alanlar["resim"];
					$tmpfname = tempnam("/tmp", "UL_IMAGE");
					$img_x = file_get_contents($resim_bot);
					file_put_contents($tmpfname, $img_x);
					$img=new SimpleImage($tmpfname);
				}else if($_FILES["resim"]["size"]==0&&$resim_bot==""){
					$resim_adi=$alanlar["resim"];
					$img=new SimpleImage('img/ham_resim/'.$resim_adi);
				}
				foreach ($ekle as $key) {
					$dosyaYol='img/'.$key.'/'.$resim_adi;
					if ($key==='ham_resim'&&($_FILES["resim"]["name"]!=""||$resim_adi!="")) {
						$img->save($dosyaYol);
					}else if ($key==='b_resim') {
						$img->thumbnail(145,220)->save($dosyaYol);
					}else if ($key==='k_resim') {
						$img->thumbnail(90,130)->save($dosyaYol);
					}else if ($key==='a_resim') {
						$img->thumbnail(45,65)->save($dosyaYol);
					}
				}
			}
		}
		public function ekle($alanlar =array(),$resim_bot){
			$ekle=array('ham_resim','b_resim','k_resim','a_resim');
			if ($this->_db->ekle('film',$alanlar)) {
				if ($_FILES["resim"]||$resim!="") {
					$resim=$_FILES["resim"];
					$tmp=$resim['tmp_name'];
					$resim_adi=$alanlar["resim"];
					if ($resim["name"]!="") {
						$img=new SimpleImage($tmp);
					}else if ($resim["size"]==0&&$resim_bot!="") {
						$tmpfname = tempnam("/tmp", "UL_IMAGE");
						$img_x = file_get_contents($resim_bot);
						file_put_contents($tmpfname, $img_x);
						$img=new SimpleImage($tmpfname);
					}
					foreach ($ekle as $key) {
						$dosyaYol='img/'.$key.'/'.$resim_adi;
						if ($key==='ham_resim') {
							$img->save($dosyaYol);
						}else if ($key==='b_resim') {
							$img->thumbnail(145,220)->save($dosyaYol);
						}else if ($key==='k_resim') {
							$img->thumbnail(90,130)->save($dosyaYol);
						}else if ($key==='a_resim') {
							$img->thumbnail(45,65)->save($dosyaYol);
						}
					}
				}
			}
		}
		public function sil($deger){
			$veri=$this->_db->sil('film',array('id','=',$deger));
			return $veri;
		}
		public function getir($deger){
			if (is_numeric($deger)) {
				$veri = $this->_db->getir('film',array('id','=',$deger));
			}else{
				$veri = $this->_db->getir('film',array('seo_adi','=',$deger));
			}
			return $veri;
		}
		public function getirFilm($limit='order by id DESC',$deger=array()){
			$veri=$this->_db->getirAll('film',$limit,$deger);
			return $veri;
		}
		public function getirSon($limit='order by id DESC limit 1'){
			$veri=$this->_db->getirAll('film',$limit);
			return $veri[0];
		}
		public function sayac(){
			$veri=$this->_db->getir('film',array('id','>',0));
			return $veri->sayac();
		}
		public function izlendi($id){
			if (strpos(Cookie::getir("izlenme"), $id)===false) {
				$veri = $this->_db->getir('film',array('id','=',$id))->ilk();
				$izle=$veri->izlenme + 1;
				$this->_db->guncelle('film',$id,array("izlenme"=>$izle));
				Cookie::yerlestir("izlenme",Cookie::getir("izlenme")."-".$id,10800);
			}
		}
		public static function ip(){
			if(getenv("HTTP_CLIENT_IP")) {
		 		$ip = getenv("HTTP_CLIENT_IP");
		 	}elseif(getenv("HTTP_X_FORWARDED_FOR")) {
		 		$ip = getenv("HTTP_X_FORWARDED_FOR");
		 		if (strstr($ip, ',')) {
		 			$tmp = explode (',', $ip);
		 			$ip = trim($tmp[0]);
		 		}
		 	}else {
		 	$ip = getenv("REMOTE_ADDR");
		 	}
			return $ip;
		}
		public static function yap_tr($str){
	        $preg = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#', '.','\'');
	        $match = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp', ' ',' ');
	        $perma = strtolower(str_replace($preg, $match, $str));
	        $perma = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $perma);
	        $perma = trim(preg_replace('/\s+/', ' ', $perma));
	        $perma = str_replace(' ', '-', $perma);
        	return $perma;
  	  	}
		public function seo_id($seo) {
			$veri = $this->_db->getir('film',array('seo_adi','=',$seo))->ilk();
			if (count($veri)==="0") {
				return false;
			}
			return $veri->id;
		}
	}
?>
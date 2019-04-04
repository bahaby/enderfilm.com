<?php 
	class Kullanici{
		private $_db,
				$_veri,
				$_sessionIsmi,
				$_cookieIsmi,
				$_girisYapti;
		public function __construct($kullanici = null){
			$this->_db=DB::baglan();
			$this->_sessionIsmi = Config::getir('session/session_ismi');
			$this->_cookieIsmi = Config::getir('hatirla/cookie_ismi');
			if (!$kullanici) {
				if (Session::varsa($this->_sessionIsmi)) {
					$kullanici=Session::getir($this->_sessionIsmi);
					if ($this->bul($kullanici)) {
						$this->_girisYapti = true;
					}else{
						//cikis
					}
				}
			}else{
				$this->bul($kullanici);
			}
		}
		public function yetki($anahtar){
			$grup = $this->_db->getir('grup',array('id','=',$this->veri()->grup));
			if ($grup->sayac()) {
				$izinler = json_decode($grup->ilk()->izin, true);
				if ($izinler[$anahtar] == true) {
					return true;
				}
			}
			return false;
		}
		public function guncelle($alanlar = array(),$id=null){
			if (!$id && $this->girisYapti()) {
				$id=$this->veri()->id;
			}
			if (!$this->_db->guncelle('uye',$id,$alanlar)) {
				throw new Exception("Güncellenme işlemi tamamlanmadı");
				
			}
		}
		public function olustur($alanlar =array()){
			if (!$this->_db->ekle('uye',$alanlar)) {
				throw new Expception('Hesabınız oluşturulamadı!');
			}
		}
		public function bul($kullanici = null){
			if ($kullanici) {
				$alan = (is_numeric($kullanici))?'id':'kullanici_adi';
				$veri = $this->_db->getir('uye',array($alan,'=',$kullanici));
				if ($veri->sayac()) {
					$this->_veri = $veri->ilk();
					return true;
				}
			}
			return false;
		}
		public function giris($kullanici_adi = null, $sifre = null){
			if (!$kullanici_adi && !$sifre && $this->varsa()) {
				Session::yerlestir($this->_sessionIsmi,$this->veri()->id);
			}else{
				$kullanici = $this->bul($kullanici_adi);
				if ($kullanici) {
					if ($this->veri()->sifre === Hash::yap($sifre,$this->veri()->salt)) {
						Session::yerlestir($this->_sessionIsmi, $this->veri()->id);
						$hash = Hash::unique();
						$hashKontrol=$this->_db->getir('uye_session',array('kullanici_id','=',$this->veri()->id));
						if (!$hashKontrol->sayac()) {
							$this->_db->ekle('uye_session',array(
								'kullanici_id' => $this->veri()->id,
								'hash' => $hash
								));
						}else{
							$hash=$hashKontrol->ilk()->hash;
						}
						Cookie::yerlestir($this->_cookieIsmi,$hash,Config::getir('hatirla/cookie_bitis'));
						return true;
					}
				}
			}
			return false;
		}
		public function veri(){
			return $this->_veri;
		}
		public function varsa(){
			return(!empty($this->_veri))?true:false;
		}
		public function girisYapti(){
			return $this->_girisYapti;
		}
		public function cikisYap(){
			$this->_db->sil('uye_session',array('kullanici_id','=',$this->veri()->id));
			Session::sil($this->_sessionIsmi);
			Cookie::sil($this->_cookieIsmi);
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
		public static function email($kime,$konu,$mesaj){
			$konu ='=?UTF-8?B?'.base64_encode($konu).'?=';
			ini_set('default_charset','utf-8');
			mail($kime, $konu, $mesaj , 'From: destek@enderfilm.com');
		}
	}
?>
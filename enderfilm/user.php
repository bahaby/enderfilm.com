<?php 
require_once 'core/init.php';
if (Input::varsa()) {
	if (Token::kontrol(Input::getir('token'))) {
		if (isset($_POST['giris'])) {
			$kadi=mb_strtolower(Input::getir('kullanici_adi_g'));
			$sifre=Input::getir('sifre_g');
			try {
				$db=DB::baglan();
				$veri=$db->getirAll("uye","where kullanici_adi=?",array($kadi));
				$uye=$veri[0];
				$salt=$uye['salt'];
				$g_sifre=$uye['sifre'];
				if (Hash::yap($sifre, $salt)==$g_sifre) {
					echo "ok";
					$kullanici= new Kullanici();
					$giris = $kullanici->giris($kadi,$sifre);
				}else{
					echo "Hatalı kullanıcı adı ve/veya şifre girdiniz!";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}else if(isset($_POST['y_sifre'])){
			$id=Input::getir('id');
			$onaylama = new Onaylama();
			$onaylama = $onaylama->kontrol($_POST,array(
				'sifre' => array(
					'zorunlu' => true,
					'min' => 6,
					'max' =>20
					),
				'sifre_t' => array(
					'zorunlu' => true,
					'eslesme' => 'sifre'
					)
				));
			if ($onaylama->tamam()) {
				$kullanici=new Kullanici();
				$salt = utf8_encode(Hash::salt(32));
				try {
					$kullanici->guncelle(array(
						'sifre' => Hash::yap(Input::getir('sifre'),$salt),
						'salt' => $salt
						),$id);
						echo "ok";
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
			}else{
				foreach ($onaylama->hatalar() as $hata) {
					echo "İşlem Başarısız";
				}
			}
		}else if (isset($_POST['hatir'])) {
			$email=mb_strtolower(Input::getir('email'));
			$kadi=mb_strtolower(Input::getir('kullanici_adi'));
			try {
				$db=DB::baglan();
				if ($veri=$db->getirAll("uye","where email=? and kullanici_adi=?",array($email,$kadi))) {
					$uye=$veri[0];
					$hatirla_kod=Hash::yap($email,$uye['salt']);
					echo "ok";
					Kullanici::email($email,'Yeni Şifre',"Merhaba ".$uye['isim']."
						\n Kullanıcı adınız: ".$uye['kullanici_adi']."
						\n Yeni şifrenizi almak için aşagıdaki linke tıklayınız
						\n http://".$_SERVER["HTTP_HOST"]."/?email=".$email."&sifre_al=".$hatirla_kod
					);
				}else{
					echo "Girdiğiniz bilgileri kontrol ediniz";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}else if (isset($_POST['kayit'])) {
			$onaylama = new Onaylama();
			$onaylama = $onaylama->kontrol($_POST,array(
				'kullanici_adi' => array(
					'zorunlu' => true,
					'min' => 4,
					'max' => 20,
					'benzersiz' => 'uye'
					),
				'sifre' => array(
					'zorunlu' => true,
					'min' => 6,
					'max' =>20
					),
				'sifre_tekrar' => array(
					'zorunlu' => true,
					'eslesme' => 'sifre'
					),
				'email' => array(
					'zorunlu' => true,
					'benzersiz' => 'uye'
					)
				));
			if ($onaylama->tamam()) {
				$kullanici = new Kullanici();
				$kadi=mb_strtolower(Input::getir('kullanici_adi'));
				$email=mb_strtolower(Input::getir('email'));
				$salt = utf8_encode(Hash::salt(32));
				$email_kodu = Hash::yap(microtime(),$salt);
				try{
					$kullanici->olustur(array(
						'kullanici_adi' => $kadi,
						'sifre' => Hash::yap(Input::getir('sifre'),$salt),
						'salt' => $salt,
						'email' => $email,
						'kullanici_ip' => Kullanici::ip(),
						'uyelik_tarihi' => date('Y-m-d H:i:s'),
						'email_kodu'=> $email_kodu
						));
					echo "ok";
					$kullanici->email($email,"Email Aktivasyon","Merhaba, 
			    	\n Hesabınızı aktifleştirmek için aşagıdaki linke tıklayınız.
					\n http://".$_SERVER["HTTP_HOST"]."/onay.php?email=".$email."&email_kodu=".$email_kodu."
					\n EnderFilm.com
					");
				}catch (Exception $e) {
					die($e->getMessage());
				}
			}else{
				echo "Kayıt başarısız";
			}
		}
	}
}
?>
<?php require_once 'core/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/css/a_style.css">
</head>
<body>
	<?php 
	$kullanici= new Kullanici();
	if ($kullanici->girisYapti()) {
		if ($kullanici->yetki('admin')) {
			$film=new Film();
			$veriler=$film->getirSon();
			$id=$veriler['id'];
			$veri=$film->getir($id)->ilk();
			if (Input::varsa('get')&&Input::getir('s')==='sil') {
				$id=Input::getir('id');
				$veri=$film->getir($id)->ilk();
				try {
					unlink('img/ham_resim/'.$veri->resim) or die("Silinemiyor");
					unlink('img/b_resim/'.$veri->resim) or die("Silinemiyor");
					unlink('img/k_resim/'.$veri->resim) or die("Silinemiyor");
					unlink('img/a_resim/'.$veri->resim) or die("Silinemiyor");
					$film->sil($id);
					Input::getir('id')?header('location:duzenle.php'):header('location:ekle.php');
				} catch (Exception $e) {
					die($e->getMessage());
				}
			}else if (Input::varsa('get')&&Input::getir('s')==='guncelle') {
				if (Input::varsa()) {
					if (Token::kontrol(Input::getir('token'))) {
						$onaylama = new Onaylama();
						$onaylama = $onaylama->kontrol($_POST,array(
							'film_adi' => array(
								'zorunlu' => true
								),
							'imdb_puan' => array(
								'zorunlu' => true
								),
							'sure' => array(
								'zorunlu' => true
								),
							'vizyon' => array(
								'zorunlu' => true
								),
							'ulke' => array(
								'zorunlu' => true
								),
							'yapim' => array(
								'zorunlu' => true
								),
							'film_dil' => array(
								'zorunlu' => true
								),
							'film_konu' => array(
								'zorunlu' => true
								)
							));
						if ($onaylama->tamam()) {
							Input::getir('id')?$id=Input::getir('id'):$id=$veriler['id'];
							$veri=$film->getir($id)->ilk();
							for ($i=1; $i < 6 ; $i++) { 
								if (Input::getir("film_tur".$i)!="") {
									$film_tur_a[]=Input::getir("film_tur".$i);
								}
							}
							$parca_tr=Film::yap_tr(Input::getir('film_adi'));
							if (Input::getir("link_baslik1")!=""&&Input::getir("link_baslika1")=="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-dublaj-film-izle";
							}else if (Input::getir("link_baslik1")==""&&Input::getir("link_baslika1")!="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-altyazi-film-izle";
							}else if (Input::getir("link_baslik1")!=""&&Input::getir("link_baslika1")!="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-dublaj-altyazi-film-izle";
							}
							$film_tur=implode(", ", $film_tur_a);
							try{
								$film->guncelle(array(
									'resim' => $veri->resim,
									'fragman' => trim(Input::getir('fragman')),
									'film_link' => trim(Input::getir('link_baslik1'))."----".trim(Input::getir('film_link1'))."||||".trim(Input::getir('link_baslik2'))."----".trim(Input::getir('film_link2'))."||||".trim(Input::getir('link_baslik3'))."----".trim(Input::getir('film_link3'))."||||".trim(Input::getir('link_baslik4'))."----".trim(Input::getir('film_link4'))."||||".trim(Input::getir('link_baslik5'))."----".trim(Input::getir('film_link5')),
									'film_link_a' => trim(Input::getir('link_baslika1'))."----".trim(Input::getir('film_linka1'))."||||".trim(Input::getir('link_baslika2'))."----".trim(Input::getir('film_linka2'))."||||".trim(Input::getir('link_baslika3'))."----".trim(Input::getir('film_linka3'))."||||".trim(Input::getir('link_baslika4'))."----".trim(Input::getir('film_linka4'))."||||".trim(Input::getir('link_baslika5'))."----".trim(Input::getir('film_linka5')),
									'imdb_puan' => trim(Input::getir('imdb_puan')),
									'meta_puan' => trim(Input::getir('meta_puan')),
									'tomato_puan' => trim(Input::getir('tomato_puan')),
									'imdb_id' => trim(Input::getir('bot_imdb')),
									'tomato_link' => trim(Input::getir('tomato_link')),
									'vizyon' => trim(Input::getir('vizyon')),
									'sure' => trim(Input::getir('sure')),
									'yonetmen' => trim(Input::getir('yonetmen')),
									'senaryo' => trim(Input::getir('senaryo')),
									'ulke' => trim(Input::getir('ulke')),
									'yapim' => Input::getir('yapim'),
									'film_adi' => trim(Input::getir('film_adi')),
									'seo_adi' => $seo_adi,
									'arama' => $parca_tr,
									'film_dil' => Input::getir('film_dil'),
									'durum' => Input::getir("durum"),
									'film_tur' => $film_tur,
									'film_konu' => trim(Input::getir('film_konu'))
									),$id,Input::getir("bot_resim"));
								if (Input::getir('id')) {
									header('location:duzenle.php');
								}
							}catch (Exception $e) {
								die($e->getMessage());
							}
						}else{
							echo "hata";
						}
						$veriler=$film->getirSon();
						Input::getir('id')?$id=Input::getir('id'):$id=$veriler['id'];
						$veri=$film->getir($id)->ilk();
						$link_ham=$veri->film_link;
						$link_ham_a=$veri->film_link_a;
						$linkler=explode("||||", $link_ham);
						$linkler_a=explode("||||", $link_ham_a);
						foreach ($linkler as $key) {
							$link[]=explode("----", $key);
						}
						foreach ($linkler_a as $key) {
							$link_a[]=explode("----", $key);
						}
						if ($veri->yapim=="1") {
							$c='Yerli';
						}else if ($veri->yapim=="2") {
							$c='Yabancı';
						}
				 		if ($veri->film_dil=='1') {
				 			$b='Dublaj';
				 		}else if ($veri->film_dil=='2') {
				 			$b='Altyazı';
				 		}else if ($veri->film_dil=='3') {
				 			$b='Multi';
				 		}
						?>
						<div id="header">
							<ul class="ilk">
								<li><a href="/">Anasayfa</a></li>
								<li><a href="admin.php">Admin Paneli</a></li>
								<li><a href="duzenle.php">Düzenleme Sayfası</a></li>
						 		<li><a href="ekle.php">Yeni Ekle</a></li>
						 		<li><a href="?s=sil&id=<?php echo $id ?>">Sil</a></li>
								<li><a href="?s=guncelle">Güncelle</a></li>
							</ul>
							<ul class="son">
								<li><a href="cikis.php">Çıkış</a></li>
								<li><a href="profil.php?kullanici=<?php echo $kullanici->veri()->kullanici_adi; ?>"><?php echo $kullanici->veri()->isim." ".$kullanici->veri()->soyisim; ?></a></li>
							</ul>
						</div>
						<div class="izleust">
							<img class="ustarka" src="img/b_resim/<?php echo $veri->resim; ?>" alt="">
							<div class="ust">
								<div class="ustic">
									<div class="izlebaslik">
										<div class="izlebresim"><img src="img/b_resim/<?php echo $veri->resim; ?>" alt=""></div>
										<div class="baslikorta">
											<h1><?php echo $veri->film_adi ?></h1>
											<ul class="baslikust">
												<li>Süre: <b><?php echo $veri->sure ?> Dk</b></li>
												<li>Vizyon Tarihi: <b><?php echo $veri->vizyon ?></b></li>
												<li>Ülke: <b><?php echo $veri->ulke ?></b></li>
											</ul>
											<div class="baslikaciklama">
												<?php echo $veri->film_konu ?>
											</div>
											<ul class="basliktur">
												<li>Tür: <b><?php echo $veri->film_tur ?></b></li>
											</ul>
										</div>
										<div class="baslikbilgi">
											<p><b><?php echo $veri->izlenme ?></b><span>İZLENME</span></p>
											<p><b><?php echo $veri->begenme ?></b><span>BEĞENİ</span></p>
											<p><b><?php echo $veri->imdb_puan/10 ?></b><span>IMDB</span></p>
											<p><b><a target="_blank" href="<?php echo $veri->imdb_link; ?>" style="color: #bf360c;">IMDB</a></b></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div><?php echo $veri->seo_adi; ?></div>
						<div class="iframe">
							<ul>
							<?php  
							for ($w=0; $w < 5 ; $w++) { 
								if ($link[$w][0]!="") {
								?>
									<li><p><?php echo $link[$w][0]; ?> Dublaj</p><iframe src="<?php echo $link[$w][1]; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
									
								<?php
								}
							}
							?>
							</ul>
						</div>
						<div class="iframe">
							<ul>
							<?php  
							for ($j=0; $j < 5 ; $j++) { 
								if ($link_a[$j][0]!="") {
								?>
									<li><p><?php echo $link_a[$j][0]; ?> Altyazı</p><iframe src="<?php echo $link_a[$j][1]; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
								<?php
								}
							}
							?>
							</ul>
						</div>
						<div class="iframe">
							<ul>
								<li><p>Fragman</p><iframe src="<?php echo $veri->fragman; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
							</ul>
						</div>
						<?php
					}
				}else{
					$veriler=$film->getirSon();
					Input::getir('id')?$id=Input::getir('id'):$id=$veriler['id'];
					$veri=$film->getir($id)->ilk();
			 		$a=explode(', ', $veri->film_tur);
					$link_ham=$veri->film_link;
					$link_ham_a=$veri->film_link_a;
					$linkler=explode("||||", $link_ham);
					$linkler_a=explode("||||", $link_ham_a);
					if ($veri->yapim=="1") {
						$c='Yerli';
					}else if ($veri->yapim=="2") {
						$c='Yabancı';
					}
					if ($veri->durum=="0") {
						$ft='Yayınlama';
					}else if ($veri->durum=="1") {
						$ft='Yayınla';
					}else if ($veri->durum=="2") {
						$ft='Editör';
					}
			 		if ($veri->film_dil=='1') {
			 			$b='Dublaj';
			 		}else if ($veri->film_dil=='2') {
			 			$b='Altyazı';
			 		}else if ($veri->film_dil=='3') {
			 			$b='Multi';
			 		}
					foreach ($linkler as $key) {
						$link[]=explode("----", $key);
					}
					foreach ($linkler_a as $key) {
						$link_a[]=explode("----", $key);
					}

				 ?>
			 	<div id="header">
					<ul class="ilk">
						<li><a href="/">Anasayfa</a></li>
						<li><a href="admin.php">Admin Paneli</a></li>
						<li><a href="duzenle.php">Düzenleme Sayfası</a></li>
				 		<li><a href="ekle.php">Yeni Ekle</a></li>
				 		<li><a href="?s=sil&id=<?php echo $id ?>">Sil</a></li>
					</ul>
					<ul class="son">
						<li><a href="cikis.php">Çıkış</a></li>
						<li><a href="profil.php?kullanici=<?php echo $kullanici->veri()->kullanici_adi; ?>"><?php echo $kullanici->veri()->isim." ".$kullanici->veri()->soyisim; ?></a></li>
					</ul>
				</div>
				<form action="" method="post" enctype="multipart/form-data">
					<ul class="bot_link">
						<li><input type="text" name="bot_film" id="bot_film" value="<?php echo $veri->bot_film; ?>" placeholder="Bot için Filmakinesi.org Linki"></li>
						<li><input type="text" name="bot_sinema" id="bot_sinema" value="<?php echo $veri->bot_sinema; ?>" placeholder="Bot için Sinemalar Linki"></li>
						<li><input type="text" name="bot_imdb" id="bot_imdb" value="<?php echo $veri->imdb_id; ?>" placeholder="Bot için Imdb ID"></li>
						<li><button name="bot_tus" id="bot_tus" onclick="return false;">Veri Çek</button></li>
					</ul>
					<ul class="resim">
					 	<li><input type="file" name='resim' id="resim"></li>
					 	<input type="hidden" name="bot_resim" id="bot_resim" value="">
					 	<li><input type="text" name="film_adi" id="film_adi" placeholder="Film Adı" value="<?php echo $veri->film_adi; ?>" required></li>
					 </ul>
					 <ul class="film_tur">
					 	<li>
						 	<select name="durum" id="durum" required>
						 		<option hidden value="<?php echo $veri->durum ?>"><?php echo $ft ?></option>
						 		<option value="0">Yayınlama</option>
						 		<option value="1">Yayınla</option>
						 		<option value="2">Editör</option>
						 	</select>
						 	<select name="film_dil" id="film_dil" required>
						 		<option hidden value="<?php echo $veri->film_dil ?>"><?php echo $b ?></option>
						 		<option value="1">Dublaj</option>	
						 		<option value="2">Altyazı</option>	
						 		<option value="3">Multi</option>	
						 	</select>
						 	<select name="yapim" id="yapim" required>
						 		<option hidden value="<?php echo $veri->yapim ?>"><?php echo $c ?></option>
						 		<option value="1">Yerli</option>	
						 		<option value="2">Yabancı</option>
						 	</select>
						 	<?php 
						 	for ($t=1; $t < 6 ; $t++) { 
					 		?>
								<select name="film_tur<?php echo $t; ?>" id="film_tur<?php echo $t; ?>">
									<option hidden selected value="<?php echo $a[($t-1)]; ?>"><?php echo $a[($t-1)]; ?></option>
							 		<option value=""></option>
							 		<option value="Aile">Aile</option>
							 		<option value="Animasyon">Animasyon</option>
							 		<option value="Aksiyon">Aksiyon</option>	
							 		<option value="Belgesel">Belgesel</option>
							 		<option value="Bilim Kurgu">Bilim Kurgu</option>
							 		<option value="Biyografi">Biyografi</option>
							 		<option value="Dram">Dram</option>	
							 		<option value="Fantastik">Fantastik</option>	
							 		<option value="Gerilim">Gerilim</option>	
							 		<option value="Gizem">Gizem</option>	
							 		<option value="Komedi">Komedi</option>	
							 		<option value="Korku">Korku</option>	
							 		<option value="Macera">Macera</option>	
							 		<option value="Müzikal">Müzikal</option>	
							 		<option value="Polisiye">Polisiye</option>	
							 		<option value="Romantik">Romantik</option>	
							 		<option value="Savaş">Savaş</option>
							 		<option value="Spor">Spor</option>
							 		<option value="Suç">Suç</option>
							 		<option value="Tarih">Tarih</option>
							 	</select>
					 		<?php
						 	}
						 	?>
					 	</li>
					 </ul>
					 <ul class="film_bilgi">
					 	<li><label class="f_bilgi" for="ulke">Ülke:</label><input type="text" name="ulke" id="ulke" placeholder="Ülke" value="<?php echo $veri->ulke; ?>" required></li>
					 	<li><label class="f_bilgi" for="vizyon">Yıl:</label><input type="number" name="vizyon" id="vizyon" min="1900" max="2020" placeholder="Vizyon Tarihi" value="<?php echo $veri->vizyon; ?>" required></li>
					 	<li><label class="f_bilgi" for="sure">Süre:</label><input type="number" name="sure" id="sure" min="0" max="999" placeholder="Süre" value="<?php echo $veri->sure; ?>" required></li>
					 	<li><label class="f_bilgi" for="imdb_puan">Imdb:</label><input type="number" name="imdb_puan" id="imdb_puan" min="0" max="99" placeholder="IMDB Puan" value="<?php echo $veri->imdb_puan; ?>" required></li>
					 	<li><label class="f_bilgi" for="meta_puan">Meta:</label><input type="number" name="meta_puan" id="meta_puan" min="0" max="99" placeholder="Meta Puan" value="<?php echo $veri->meta_puan; ?>"></li>
					 	<li><label class="f_bilgi" for="tomato_puan">Tomato:</label><input type="number" name="tomato_puan" id="tomato_puan" min="0" max="99" placeholder="Tomato Puan" value="<?php echo $veri->tomato_puan; ?>"></li>
					 </ul>
					 <ul class="film_konu">
					 	<li><textarea name="film_konu" id="film_konu" cols="30" rows="10" placeholder="Konu, Açıklama, Özet...." required><?php echo $veri->film_konu; ?></textarea></li>
					 </ul>
					 <ul class="link">
					 	<li><input type="text" name="fragman" id="fragman" placeholder="Fragman Link" value="<?php echo $veri->fragman; ?>"></li>
					 	<li><input type="text" id="tomato_link" name="tomato_link" placeholder="Tomato Link" value="<?php echo $veri->tomato_link; ?>"></li>
					 </ul>
					 <ul class="yapimci">
					 	<li><input type="text" id="senaryo" name="senaryo" placeholder="Senaryo" value="<?php echo $veri->senaryo; ?>"></li>
					 	<li><input type="text" id="yonetmen" name="yonetmen" placeholder="Yönetmen" value="<?php echo $veri->yonetmen; ?>"></li>
					 </ul>
					 <ul class="dublaj_link">
					 <?php  
					 	for ($i=1; $i < 6 ; $i++) { 
					 	?>
							<li>
							<select name="link_baslik<?php echo $i; ?>" id="link_baslik<?php echo $i; ?>">
								<option value="<?php echo $link[($i-1)][0]; ?>" selected hidden><?php echo $link[($i-1)][0]; ?></option>
								<option value=""></option>
								<option value="VidZi.tv">VidZi.tv</option>
								<option value="Netu">Netu</option>
								<option value="FlashX">FlashX</option>
								<option value="Plus Player">Plus Player</option>
								<option value="Openload">Openload</option>
								<option value="Movshare">Movshare</option>
								<option value="Mail.ru">Mail.Ru</option>
								<option value="Ok.Ru">Ok.Ru</option>
								<option value="Stream">Stream</option>
								<option value="Raj">Raj</option>
								<option value="Videome">Videome</option>
							</select>
							<input type="text" name="film_link<?php echo $i; ?>" id="film_link<?php echo $i; ?>" placeholder="Film Link <?php echo $i; ?>" value="<?php echo $link[($i-1)][1]; ?>">
							</li>	
					 	<?php
					 	}
					 ?>
					 </ul>
					 <ul class="altyazi_link">
					 <?php  
					 	for ($i=1; $i < 6 ; $i++) { 
					 	?>
							<li>
							<select name="link_baslika<?php echo $i; ?>" id="link_baslika<?php echo $i; ?>">
								<option value="<?php echo $link_a[($i-1)][0]; ?>" selected hidden><?php echo $link_a[($i-1)][0]; ?></option>
								<option value=""></option>
								<option value="VidZi.tv">VidZi.tv</option>
								<option value="Netu">Netu</option>
								<option value="FlashX">FlashX</option>
								<option value="Plus Player">Plus Player</option>
								<option value="Openload">Openload</option>
								<option value="Movshare">Movshare</option>
								<option value="Mail.ru">Mail.Ru</option>
								<option value="Ok.Ru">Ok.Ru</option>
								<option value="Stream">Stream</option>
								<option value="Raj">Raj</option>
								<option value="Videome">Videome</option>
							</select>
							<input type="text" name="film_linka<?php echo $i; ?>" id="film_linka<?php echo $i; ?>" placeholder="Film Link (Altyazı) <?php echo $i; ?>" value="<?php echo $link_a[($i-1)][1]; ?>">
							</li>	
					 	<?php
					 	}
					 ?>
					 </ul>
					 <ul class="gonder">
					 	<li><input type="hidden" name="token" value="<?php echo Token::olustur(); ?>"></li>
					 	<li><input type="submit" value="Kaydet"></li>
				 	</ul>
				 </form>
				<script src="/js/jquery.js"></script>
				<script src="/js/jquery.validate.js"></script>	
				<script src="/js/fancybox.js"></script>
				<script src="/js/a_script.js"></script>
			<?php }
			}else{
			$veriler=$film->getirSon();
			$id=$veriler['id'];
			$veri=$film->getir($id)->ilk();
				if (Input::varsa()) {
					if (Token::kontrol(Input::getir('token'))) {
						$onaylama = new Onaylama();
						$onaylama = $onaylama->kontrol($_POST,array(
							'film_adi' => array(
								'zorunlu' => true
								),
							'imdb_puan' => array(
								'zorunlu' => true
								),
							'sure' => array(
								'zorunlu' => true
								),
							'vizyon' => array(
								'zorunlu' => true
								),
							'ulke' => array(
								'zorunlu' => true
								),
							'yapim' => array(
								'zorunlu' => true
								),
							'film_dil' => array(
								'zorunlu' => true
								),
							'film_konu' => array(
								'zorunlu' => true
								)
							));
						if ($onaylama->tamam()) {
							for ($i=1; $i < 6 ; $i++) { 
								if (Input::getir("film_tur".$i)!=="") {
									$film_tur_a[]=Input::getir("film_tur".$i);
								}
							}
							$parca_tr=Film::yap_tr(Input::getir('film_adi'));
							if (Input::getir("link_baslik1")!=""&&Input::getir("link_baslika1")=="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-dublaj-film-izle";
							}else if (Input::getir("link_baslik1")==""&&Input::getir("link_baslika1")!="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-altyazi-film-izle";
							}else if (Input::getir("link_baslik1")!=""&&Input::getir("link_baslika1")!="") {
								$seo_adi=$parca_tr."-".Input::getir('vizyon')."-turkce-dublaj-altyazi-film-izle";
							}
							$film_tur=implode(", ", $film_tur_a);
							try{
								$film->ekle(array(
									'resim' => date('Ymd-His',time()).'-'.substr(md5(rand(999,99999)),0,10).'.jpg',
									'bot_film'=>trim(Input::getir("bot_film")),
									'bot_sinema'=>trim(Input::getir("bot_sinema")),
									'fragman' => trim(Input::getir('fragman')),
									'film_link' => trim(Input::getir('link_baslik1'))."----".trim(Input::getir('film_link1'))."||||".trim(Input::getir('link_baslik2'))."----".trim(Input::getir('film_link2'))."||||".trim(Input::getir('link_baslik3'))."----".trim(Input::getir('film_link3'))."||||".trim(Input::getir('link_baslik4'))."----".trim(Input::getir('film_link4'))."||||".trim(Input::getir('link_baslik5'))."----".trim(Input::getir('film_link5')),
									'film_link_a' => trim(Input::getir('link_baslika1'))."----".trim(Input::getir('film_linka1'))."||||".trim(Input::getir('link_baslika2'))."----".trim(Input::getir('film_linka2'))."||||".trim(Input::getir('link_baslika3'))."----".trim(Input::getir('film_linka3'))."||||".trim(Input::getir('link_baslika4'))."----".trim(Input::getir('film_linka4'))."||||".trim(Input::getir('link_baslika5'))."----".trim(Input::getir('film_linka5')),
									'imdb_puan' => trim(Input::getir('imdb_puan')),
									'meta_puan' => trim(Input::getir('meta_puan')),
									'tomato_puan' => trim(Input::getir('tomato_puan')),
									'imdb_id' => trim(Input::getir('bot_imdb')),
									'tomato_link' => trim(Input::getir('tomato_link')),
									'vizyon' => trim(Input::getir('vizyon')),
									'sure' => trim(Input::getir('sure')),
									'yonetmen' => trim(Input::getir('yonetmen')),
									'senaryo' => trim(Input::getir('senaryo')),
									'ulke' => trim(Input::getir('ulke')),
									'yapim' => Input::getir('yapim'),
									'film_adi' => trim(Input::getir('film_adi')),
									'seo_adi' => $seo_adi,
									'arama' => $parca_tr,
									'film_dil' => Input::getir('film_dil'),
									'eklenme' => date('Y-m-d H:i:s'),
									'durum' => Input::getir("durum"),
									'film_tur' => $film_tur,
									'film_konu' => trim(Input::getir('film_konu'))
									),Input::getir("bot_resim"));
								Session::flash('basari','Sorun Yok Eklendi!');
							}catch (Exception $e) {
								die($e->getMessage());
							}
						}else{
							echo "hata";
						}
						$veriler=$film->getirSon();
						$id=$veriler['id'];
						$veri=$film->getir($id)->ilk();
						$link_ham=$veri->film_link;
						$link_ham_a=$veri->film_link_a;
						$linkler=explode("||||", $link_ham);
						$linkler_a=explode("||||", $link_ham_a);
						foreach ($linkler as $key) {
							$link[]=explode("----", $key);
						}
						foreach ($linkler_a as $key) {
							$link_a[]=explode("----", $key);
						}
						if ($veri->yapim=="1") {
							$c='Yerli';
						}else if ($veri->yapim=="2") {
							$c='Yabancı';
						}
				 		if ($veri->film_dil=='1') {
				 			$b='Dublaj';
				 		}else if ($veri->film_dil=='2') {
				 			$b='Altyazı';
				 		}else if ($veri->film_dil=='3') {
				 			$b='Multi';
				 		}
						?>
						<div id="header">
							<ul class="ilk">
								<li><a href="/">Anasayfa</a></li>
								<li><a href="admin.php">Admin Paneli</a></li>
								<li><a href="duzenle.php">Düzenleme Sayfası</a></li>
						 		<li><a href="ekle.php">Yeni Ekle</a></li>
						 		<li><a href="?s=sil&id=<?php echo $id ?>">Sil</a></li>
								<li><a href="?s=guncelle">Güncelle</a></li>
							</ul>
							<ul class="son">
								<li><a href="cikis.php">Çıkış</a></li>
								<li><a href="profil.php?kullanici=<?php echo $kullanici->veri()->kullanici_adi; ?>"><?php echo $kullanici->veri()->isim." ".$kullanici->veri()->soyisim; ?></a></li>
							</ul>
						</div>
						<div class="izleust">
							<img class="ustarka" src="img/b_resim/<?php echo $veri->resim; ?>" alt="">
							<div class="ust">
								<div class="ustic">
									<div class="izlebaslik">
										<div class="izlebresim"><img src="img/b_resim/<?php echo $veri->resim; ?>" alt=""></div>
										<div class="baslikorta">
											<h1><?php echo $veri->film_adi ?></h1>
											<ul class="baslikust">
												<li>Süre: <b><?php echo $veri->sure ?> Dk</b></li>
												<li>Vizyon Tarihi: <b><?php echo $veri->vizyon ?></b></li>
												<li>Ülke: <b><?php echo $veri->ulke ?></b></li>
											</ul>
											<div class="baslikaciklama">
												<?php echo $veri->film_konu ?>
											</div>
											<ul class="basliktur">
												<li>Tür: <b><?php echo $veri->film_tur ?></b></li>
											</ul>
										</div>
										<div class="baslikbilgi">
											<p><b><?php echo $veri->izlenme ?></b><span>İZLENME</span></p>
											<p><b><?php echo $veri->begenme ?></b><span>BEĞENİ</span></p>
											<p><b><?php echo $veri->imdb_puan/10 ?></b><span>IMDB</span></p>
											<p><b><a target="_blank" href="<?php echo $veri->imdb_link; ?>" style="color: #bf360c;">IMDB</a></b></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="iframe">
							<ul>
							<?php  
							for ($w=0; $w < 5 ; $w++) { 
								if ($link[$w][0]!="") {
								?>
									<li><p><?php echo $link[$w][0]; ?></p><iframe src="<?php echo $link[$w][1]; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
									
								<?php
								}
							}
							?>
							</ul>
						</div>
						<div class="iframe">
							<ul>
							<?php  
							for ($j=0; $j < 5 ; $j++) { 
								if ($link_a[$j][0]!="") {
								?>
									<li><p><?php echo $link_a[$j][0]; ?></p><iframe src="<?php echo $link_a[$j][1]; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
								<?php
								}
							}
							?>
							</ul>
						</div>
						<div class="iframe">
							<ul>
								<li><p>Fragman</p><iframe src="<?php echo $veri->fragman; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe></li>
							</ul>
						</div>
						<?php
					}
				}else{
				 ?>
				<div id="header">
					<ul class="ilk">
						<li><a href="/">Anasayfa</a></li>
						<li><a href="admin.php">Admin Paneli</a></li>
						<li><a href="duzenle.php">Düzenleme Sayfası</a></li>
						<li><a href="?s=guncelle">Son Ekleneni Güncelle</a></li>
					</ul>
					<ul class="son">
						<li><a href="cikis.php">Çıkış</a></li>
						<li><a href="profil.php?kullanici=<?php echo $kullanici->veri()->kullanici_adi; ?>"><?php echo $kullanici->veri()->isim." ".$kullanici->veri()->soyisim; ?></a></li>
					</ul>
				</div>
				<form action="" method="post" id="ekle_form" enctype="multipart/form-data">
					<ul class="bot_link">
						<li><input type="text" name="bot_film" id="bot_film" placeholder="Bot için Filmakinesi.org Linki"></li>
						<li><input type="text" name="bot_sinema" id="bot_sinema" placeholder="Bot için Sinemalar Linki"></li>
						<li><input type="text" name="bot_imdb" id="bot_imdb" placeholder="Bot için Imdb ID"></li>
						<li><button name="bot_tus" id="bot_tus" onclick="return false;">Veri Çek</button></li>
					</ul>
				 	<ul class="resim">
					 	<li><input type="file" name='resim' id="resim"></li>
					 	<input type="hidden" name="bot_resim" id="bot_resim" value="">
					 	<li><input type="text" name="film_adi" id="film_adi" placeholder="Film Adı" required></li>
					 </ul>
					 <ul class="film_tur">
					 	<li>
						 	<select name="durum" id="durum" required>
						 		<option value="0">Yayınlama</option>
						 		<option selected value="1">Yayınla</option>
						 		<option value="2">Editör</option>
						 	</select>
						 	<select name="film_dil" id="film_dil" required>
						 		<option hidden>Dil</option>
						 		<option value="1">Dublaj</option>	
						 		<option value="2">Altyazı</option>	
						 		<option value="3">Multi</option>	
						 	</select>
						 	<select name="yapim" id="yapim" required>
						 		<option hidden>Yapım</option>
						 		<option value="1">Yerli</option>	
						 		<option value="2">Yabancı</option>
						 	</select>
						 	<?php 
						 	for ($i=1; $i < 6 ; $i++) { 
					 		?>
								<select name="film_tur<?php echo $i; ?>" id="film_tur<?php echo $i; ?>">
							 		<option hidden selected value="">Tür Seç</option>
							 		<option value=""></option>
							 		<option value="Aile">Aile</option>
							 		<option value="Animasyon">Animasyon</option>
							 		<option value="Aksiyon">Aksiyon</option>	
							 		<option value="Belgesel">Belgesel</option>
							 		<option value="Bilim Kurgu">Bilim Kurgu</option>
							 		<option value="Biyografi">Biyografi</option>
							 		<option value="Dram">Dram</option>	
							 		<option value="Fantastik">Fantastik</option>	
							 		<option value="Gerilim">Gerilim</option>	
							 		<option value="Gizem">Gizem</option>	
							 		<option value="Komedi">Komedi</option>	
							 		<option value="Korku">Korku</option>	
							 		<option value="Macera">Macera</option>	
							 		<option value="Müzikal">Müzikal</option>	
							 		<option value="Polisiye">Polisiye</option>	
							 		<option value="Romantik">Romantik</option>	
							 		<option value="Savaş">Savaş</option>
							 		<option value="Spor">Spor</option>
							 		<option value="Suç">Suç</option>
							 		<option value="Tarih">Tarih</option>
							 	</select>
					 		<?php
						 	}
						 	?>
					 	</li>
					 </ul>
					 <ul class="film_bilgi">
					 	<li><label class="f_bilgi" for="ulke">Ülke:</label><input type="text" name="ulke" id="ulke" placeholder="Ülke" required></li>
					 	<li><label class="f_bilgi" for="vizyon">Yıl:</label><input type="number" name="vizyon" id="vizyon" min="1900" max="2020" placeholder="Vizyon Tarihi" required></li>
					 	<li><label class="f_bilgi" for="sure">Süre:</label><input type="number" name="sure" id="sure" min="0" max="999" placeholder="Süre"></li>
					 	<li><label class="f_bilgi" for="imdb_puan">Imdb:</label><input type="number" name="imdb_puan" id="imdb_puan" min="0" max="99" placeholder="IMDB Puan" required></li>
					 	<li><label class="f_bilgi" for="meta_puan">Meta:</label><input type="number" name="meta_puan" id="meta_puan" min="0" max="99" placeholder="Meta Puan"></li>
					 	<li><label class="f_bilgi" for="tomato_puan">Tomato:</label><input type="number" name="tomato_puan" id="tomato_puan" min="0" max="99" placeholder="Tomato Puan"></li>
					 </ul>
					 <ul class="film_konu">
					 	<li><textarea name="film_konu" id="film_konu" cols="30" rows="10" placeholder="Konu, Açıklama, Özet...." required></textarea></li>
					 </ul>
					 <ul class="link">
					 	<li><input type="text" id="fragman" name="fragman" placeholder="Fragman Link"></li>
					 	<li><input type="text" id="tomato_link" name="tomato_link" placeholder="Tomato Link"></li>
					 </ul>
					 <ul class="yapimci">
					 	<li><input type="text" id="senaryo" name="senaryo" placeholder="Senaryo"></li>
					 	<li><input type="text" id="yonetmen" name="yonetmen" placeholder="Yönetmen"></li>
					 </ul>
					 <ul class="dublaj_link">
					 <?php  
					 	for ($i=1; $i < 6 ; $i++) { 
					 	?>
							<li>
							<select name="link_baslik<?php echo $i; ?>" id="link_baslik<?php echo $i; ?>">
								<option value="" selected hidden>Link Başlık <?php echo $i; ?></option>
								<option value=""></option>
								<option value="VidZi.tv">VidZi.tv</option>
								<option value="Netu">Netu</option>
								<option value="FlashX">FlashX</option>
								<option value="Plus Player">Plus Player</option>
								<option value="Openload">Openload</option>
								<option value="Movshare">Movshare</option>
								<option value="Mail.ru">Mail.Ru</option>
								<option value="Ok.Ru">Ok.Ru</option>
								<option value="Stream">Stream</option>
								<option value="Raj">Raj</option>
								<option value="Videome">Videome</option>
							</select>
							<input type="text" name="film_link<?php echo $i; ?>" id="film_link<?php echo $i; ?>" placeholder="Film Link <?php echo $i; ?>">
							</li>	
					 	<?php
					 	}
					 ?>
					 </ul>
					 <ul class="altyazi_link">
					 <?php  
					 	for ($i=1; $i < 6 ; $i++) { 
					 	?>
							<li>
							<select name="link_baslika<?php echo $i; ?>" id="link_baslika<?php echo $i; ?>">
								<option value="" selected hidden>Link Başlık (Altyazı) <?php echo $i; ?></option>
								<option value=""></option>
								<option value="VidZi.tv">VidZi.tv</option>
								<option value="Netu">Netu</option>
								<option value="FlashX">FlashX</option>
								<option value="Plus Player">Plus Player</option>
								<option value="Openload">Openload</option>
								<option value="Movshare">Movshare</option>
								<option value="Mail.ru">Mail.Ru</option>
								<option value="Ok.Ru">Ok.Ru</option>
								<option value="Stream">Stream</option>
								<option value="Raj">Raj</option>
								<option value="Videome">Videome</option>
							</select>
							<input type="text" name="film_linka<?php echo $i; ?>" id="film_linka<?php echo $i; ?>" placeholder="Film Link (Altyazı) <?php echo $i; ?>">
							</li>	
					 	<?php
					 	}
					 ?>
					 </ul>
					 <ul class="gonder">
					 	<li><input type="hidden" name="token" value="<?php echo Token::olustur(); ?>"></li>
					 	<li><input type="submit" value="Kaydet"></li>
				 	</ul>
				</form>
				<script src="/js/jquery.js"></script>
				<script src="/js/jquery.validate.js"></script>	
				<script src="/js/fancybox.js"></script>
				<script src="/js/a_script.js"></script>
			<?php }
			}
		}else{
			echo 'sadece admin';
		}
	}else{
		Yonlendir::git("/");
	}
	?>
</body>
</html>
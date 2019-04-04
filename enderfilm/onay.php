<?php require_once 'core/init.php';
	if (Input::varsa()) {
		if (isset($_POST['kullanici_adi'])) {
			$db=DB::baglan();
			$kadi=mb_strtolower(Input::getir('kullanici_adi'));
			$veri=$db->getirAll("uye","where kullanici_adi=?",array($kadi));
			if ($veri!==false) {
				echo "false";
			}else{
				echo "true";
			}
		}else if (isset($_POST['email'])) {
			$db=DB::baglan();
			$email=mb_strtolower(Input::getir('email'));
			$veri=$db->getirAll("uye","where email=?",array($email));
			if ($veri!==false) {
				echo "false";
			}else{
				echo "true";
			}
		}else if (isset($_POST['bot_imdb'])) {
			$db=DB::baglan();
			$bot_imdb=Input::getir('bot_imdb');
			$veri=$db->getirAll("film","where imdb_id=?",array($bot_imdb));
			if ($veri!==false) {
				echo "false";
			}else{
				echo "true";
			}
		}else if (isset($_POST['film_adi'])) {
			$db=DB::baglan();
			$film_adi=Input::getir('film_adi');
			$veri=$db->getirAll("film","where film_adi=?",array($film_adi));
			if ($veri!==false) {
				echo "false";
			}else{
				echo "true";
			}
		}else if (isset($_POST['link'])&&isset($_POST['id'])) {
			$film=new Film();
			$seo_h=Input::getir('id');
			$id=substr($seo_h, 6,-5);
			$linkg=Input::getir('link');
			$veri=$film->getir($id)->ilk();
			if (isset($_POST['dil'])) {
				$dil=Input::getir('dil');
				if ($dil=="dublajFilm") {
					$link_ham=$veri->film_link;
				}else if ($dil=="altyaziFilm") {
					$link_ham=$veri->film_link_a;
				}
				$linkler=explode("||||", $link_ham);
				foreach ($linkler as $key) {
					$link[]=explode("----", $key);
				}
				for ($i=0; $i < 5 ; $i++) { 
					if ($link[$i][0]==$linkg) {
						$flink=$link[$i][1];
					}
				}
				echo $flink;
			}else if (!isset($_POST['dil'])) {
				echo $veri->fragman;
			}
		}
	}else if(Input::varsa('get')){
		if (isset($_GET['email'])&&isset($_GET['email_kodu'])) {
			$email=mb_strtolower(Input::getir('email'));
			$email_kodu=Input::getir('email_kodu');
			$db=DB::baglan();
			if ($veri=$db->getirAll("uye","where email=? and email_kodu=? and grup=?",array($email,$email_kodu,0))) {
				$uye=$veri[0];
				$kullanici = new Kullanici();
				try{
					$kullanici->guncelle(array(
						'grup' => 1
						),$uye['id']);
					Session::flash("onay","Aktifleştirme başarılı");
					Yonlendir::git("/");
				}catch (Exception $e) {
					die($e->getMessage());
				}
			}else{
				Session::flash("onay","Aktifleştirme sırasında bi sorun oluştu");
				Yonlendir::git("/");
			}
		}else if (isset($_GET['ara'])) {
			$db=DB::baglan();
			$veri=Film::yap_tr(Input::getir('ara'));
			$ara_a=explode('+', $veri);
			$say=count($ara_a);
			for ($i=0; $i < $say ; $i++) { 
				$where_a[]=" arama like ?";
				$ara[]="%".$ara_a[$i]."%";
			}
			$where="where".implode(" or", $where_a)."order by izlenme desc limit 6";
			$bul=$db->getirAll("film",$where,$ara);
			?>
			<ul>
				<?php
				if (empty($bul[0])) {
					?>
					<li><p>Aradığınız film yok malesef :(</p></li>
					<?php
				}else{
					foreach ($bul as $key) {
						?>
						<li>
							<a href="izle/<?php echo $key['seo_adi']; ?>.html">
								<div><img src="/img/a_resim/<?php echo $key['resim']; ?>" alt="icon"></div>
								<div>
									<span><?php echo $key['film_adi'] ?></span>
									<span><?php echo $key['film_tur'] ?></span>
									<span><?php echo $key['vizyon'] ?></span>
								</div>
							</a>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
		}
	}
 ?>
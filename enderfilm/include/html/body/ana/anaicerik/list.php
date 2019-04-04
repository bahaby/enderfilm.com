<div id="list">
	<div class="list">
		<?php include 'include/html/body/ana/anaicerik/list/robot.php'; ?>
		<?php
			if (count($_GET)>=2) {
				$sirala=filtrele(Input::getir("l"));
				$yapim=filtrele(Input::getir("y"));
				$tur=filtrele(Input::getir("t"));
				$imdb=filtrele(Input::getir("i"));
				$dil=filtrele(Input::getir("d"));
				$yil_min=filtrele(Input::getir("min"));
				$yil_max=filtrele(Input::getir("max"));
				$get_yol="l=".$sirala."&y=".$yapim."&t=".$tur."&i=".$imdb."&d=".$dil."&min=".$yil_min."&max=".$yil_max;
			}
			switch ($sirala) {
				case '1':
					$a="order by eklenme DESC";
					break;
				case '2':
					$a="order by izlenme DESC";
					break;
				case '3':
					$a="order by imdb_puan DESC";
					break;
				case '4':
					$a="order by film_adi ASC";
					break;
				case '5':
					$a="order by film_adi DESC";
					break;
				case '6':
					$a="order by vizyon DESC";
					break;
				case '7':
					$a="order by vizyon ASC";
					break;
				default:
					$a="order by eklenme DESC";
					break;
			}
			switch ($yapim) {
				case '1':
					$b="";
					break;
				case '2':
					$b="yapim = 1 and ";
					break;
				case '3':
					$b="yapim = 2 and ";
					break;
				default:
					$b="";
					break;
			}
			switch ($dil) {
				case '1':
					$c="";
					break;
				case '2':
					$c="(film_dil = 1 or film_dil = 3) and ";
					break;
				case '3':
					$c="(film_dil = 2 or film_dil = 3) and ";
					break;
				default:
					$c="";
					break;
			}
			switch ($tur) {
				case '1':
					$d="";
					break;
				case '2':
					$d="film_tur like '%Aile%' and ";
					break;
				case '3':
					$d="film_tur like '%Animasyon%' and ";
					break;
				case '4':
					$d="film_tur like '%Aksiyon%' and ";
					break;
				case '5':
					$d="film_tur like '%Belgesel%' and ";
					break;
				case '6':
					$d="film_tur like '%Bilim Kurgu%' and ";
					break;
				case '7':
					$d="film_tur like '%Biyografi%' and ";
					break;
				case '8':
					$d="film_tur like '%Dram%' and ";
					break;
				case '9':
					$d="film_tur like '%Fantastik%' and ";
					break;
				case '10':
					$d="film_tur like '%Gerilim%' and ";
					break;
				case '11':
					$d="film_tur like '%Gizem%' and ";
					break;
				case '12':
					$d="film_tur like '%Komedi%' and ";
					break;
				case '13':
					$d="film_tur like '%Korku%' and ";
					break;
				case '14':
					$d="film_tur like '%Macera%' and ";
					break;
				case '15':
					$d="film_tur like '%Müzikal%' and ";
					break;
				case '16':
					$d="film_tur like '%Polisiye%' and ";
					break;
				case '17':
					$d="film_tur like '%Romantik%' and ";
					break;
				case '18':
					$d="film_tur like '%Savaş%' and ";
					break;
				case '19':
					$d="film_tur like '%Suç%' and ";
					break;
				case '20':
					$d="film_tur like '%Tarih%' and ";
					break;
				case '21':
					$d="film_tur like '%Spor%' and ";
					break;
				default:
					$d="";
					break;
			}
			$imdb_a=array("3","4","5","6","7","8","9");
			if ($imdb=="1") {
				$f="";
			}else if(in_array($imdb, $imdb_a)){
				$f="imdb_puan >= ".($imdb*10)." and ";
			}else{
				$f="";
			}
			if ($yil_min>="1930"&&$yil_min<="2017"&&$yil_max>="1930"&&$yil_max<="2017") {
				$g="(vizyon BETWEEN ".$yil_min." AND ".$yil_max.") ";
			}else{
				$g="(vizyon BETWEEN 1930 AND 2017) ";
			}
			$sorgu="where (durum = 1 or durum = 2) and ".$b.$c.$d.$f.$g.$a;
			$film=new Film();
			$sfilm=$film->getirFilm($sorgu);
			$tfilm=count($sfilm);
			$sayfa=1;
			$kfilm=20;
			$goster=3;
			$tsayfa = ceil($tfilm / $kfilm);
			$t = Input::getir('s');
			if (filtrele($t)>1&&filtrele($t)!==null&&is_numeric(filtrele($t))) {
				$sayfa = filtrele($t);
				if (filtrele($t)>$tsayfa) {
					Yonlendir::git('/'.$tsayfa.($get_yol?'?'.$get_yol:''));
				}
			}else{
				if (!empty(filtrele($t))) {
					Yonlendir::git(($get_yol?'/?'.$get_yol:'/'));
				}
			}
			$limit=($sayfa-1)*$kfilm;
			$veriler=$film->getirFilm($sorgu.' limit '.$limit.' ,'.$kfilm);
		?>
		<?php include 'include/html/body/ana/anaicerik/list/sayfa.php'; ?>
		<ul>
			<?php
				if ($veriler===false) {
					echo "film yok";
				}else{
					foreach ($veriler as $veri) {
					?>
						<li class="film"><a href="izle/<?php echo $veri['seo_adi']; ?>.html"><img class="filmresim" src="img/b_resim/<?php echo $veri['resim']; ?>"><img class="play" src="img/play.png" alt=""><p class="star"><img src="img/star.png" alt=""><br><?php echo $veri['imdb_puan']/10; ?> / 10</p><p class="eye"><img src="img/eye.png"></p><p class="izlenme"><?php echo $veri['izlenme']; ?></p></a><div class="fragman"><a class="fancy fancybox.iframe" href="<?php echo $veri['fragman']; ?>"><img src="img/fragman.png" alt=""><p>Fragman</p></a></div><div class="aciklama"><div class="ok"></div><h2 class="baslik"><?php echo $veri['film_adi']; ?></h2><p class="turler"><?php echo $veri['film_tur']; ?></p><p class="ozet"><?php echo $veri['film_konu']; ?></p></div></li>
					<?php
					}
				}
			?>
		</ul>
	</div>
	<?php include 'include/html/body/ana/anaicerik/list/sayfa.php'; ?>
</div>
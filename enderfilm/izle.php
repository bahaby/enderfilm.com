<?php require_once 'core/init.php';
	if (!Input::varsa('get') && empty(Input::getir('f'))) {
		Yonlendir::git("/");
	}
	$film=new Film();
	$t = Input::getir('f');
	if (filtrele($t)!==null) {
		$seo = filtrele($t);
		if ($film->seo_id($seo)!==false) {
			$id=$film->seo_id($seo);
		}else{
			Yonlendir::git("/");
		}
	}
	$veri=$film->getir($id)->ilk();
	$film->izlendi($id);
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
	if ($veri->id===null) {
		Yonlendir::git("/");
	}
	$x=explode(" (", $veri->film_adi); 
	$kwd=mb_strtolower($x[0]);
	$keywords=$kwd.",".$kwd." izle,".$kwd." imdb,".$kwd." ".$veri->vizyon.",".$kwd." fragman,".$kwd." ".$veri->vizyon." imdb,".$kwd." ekşi,".$kwd." izle ".$veri->vizyon.",".$kwd." full izle";
	if (empty($link[0][0])&&!empty($link_a[0][0])) {//altyazılı ise
		$title=$veri->film_adi." ".$veri->vizyon." Türkçe Altyazılı Film İzle";
		$keywords.=",".$kwd." altyazılı izle";
	}else if (empty($link_a[0][0])&&!empty($link[0][0])) {//dublaj ise
		$title=$veri->film_adi." ".$veri->vizyon." Türkçe Dublaj Film İzle";
		$keywords.=",".$kwd." dublaj izle";
	}else {//dublaj ise
		$title=$veri->film_adi." ".$veri->vizyon." Türkçe Altyazılı Dublaj Film İzle";
		$keywords.=",".$kwd." dublaj altyazılı izle";
	}
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
		<meta http-equiv="content-language" content="tr-TR">
		<meta name="country" content="Turkey">
		<meta name="robots" content="index,follow">
		<meta name="description" content="<?php echo mb_substr($veri->film_konu,'0','170'); ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta property="og:title" content="<?php echo $title ?>">
		<meta property="og:description" content="<?php echo mb_substr($veri->film_konu,'0','170'); ?>">
		<meta property="og:type" content="video.movie">
		<meta property="og:image" content="http://<?php echo $_SERVER["HTTP_HOST"] ?>/img/b_resim/<?php echo $veri->resim; ?>">
		<meta property="og:url" content="http://<?php echo $_SERVER["HTTP_HOST"] ?>/izle/<?php echo $veri->seo_adi ?>.html">
		<link rel="image_src" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/img/b_resim/<?php echo $veri->resim; ?>">
		<link rel="canonical" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/izle/<?php echo $veri->seo_adi ?>.html">
		<link rel="canonical" href="http://enderfilm.com/">
		<link rel="stylesheet" href="/css/style.css">
		<link rel="stylesheet" href="/css/fancybox.css" media="screen">
		<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
	</head>
	<body>
		<div id="ana">
			<?php include 'include/html/body/ana/header.php'; ?>
			<div class="izleust">
				<img class="ustarka" src="/img/b_resim/<?php echo $veri->resim; ?>" alt="">
				<div class="ust">
					<div class="ustic">
						<div class="izlebaslik">
							<div class="izlebresim"><img src="/img/b_resim/<?php echo $veri->resim; ?>" alt=""></div>
							<div class="baslikorta">
								<h1><?php echo $veri->film_adi ?></h1>
								<ul class="baslikust">
									<li><span>Süre:</span> <b><?php echo $veri->sure ?> Dk</b></li>
									<li><span>Vizyon Tarihi:</span> <b><?php echo $veri->vizyon ?></b></li>
									<li><span>Ülke:</span> <b><?php echo $veri->ulke ?></b></li>
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
								<ul>
									<li>
										<i class="fa fa-thumbs-o-up fa-2x fa-flip-horizontal" aria-hidden="true"></i>
										<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="anaicerik">
				<div id="list">
					<div class="videomenu">
						<ul class="videodugme">
							<?php  
							if (!empty($link[0][0])) {
							?>
							<li>
								<div class="menu link_i" id="dublajFilm">Dublaj</div>
								<ul class="secenek">
									<?php  
									foreach ($link as $key) {
										if ($key[0]!="") {
										?>
											<li><?php echo $key[0]; ?></li>
										<?php
										}
									}
									?>
								</ul>
							</li>
							<?php
							}
							if (!empty($link_a[0][0])) {
							?>
							<li>
								<div class="menu link_i" id="altyaziFilm">Altyazı</div>
									<ul class="secenek">
										<?php  
										foreach ($link_a as $key) {
											if ($key[0]!="") {
											?>
												<li><?php echo $key[0]; ?></li>
											<?php
											}
										}
										?>
									</ul>
							</li>
							<?php
							}
							?>
							<li>
								<div class="menu link_f">Fragman</div>
							</li>
						</ul>
						<div class="tiklaBos"></div>
					</div>
					<div class="video">
						<iframe src="<?php echo empty($link[0][1])?$link_a[0][1]:$link[0][1]; ?>" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" width="100%" height="100%" frameborder="0"></iframe>
					</div>
				</div>
				<div id="side">
					<div class="rklm"></div>
				</div>
			</div>
			<?php include 'include/html/body/ana/footer.php'; ?>
			<?php include 'include/html/body/ana/form.php'; ?>
		</div>
		<?php include 'include/html/body/script.php'; ?>
	</body>
</html>
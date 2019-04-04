<?php require_once 'core/init.php'; ?>
<!DOCTYPE html>
<html>
	<?php include 'include/html/head.php'; ?>
	<body>
		<div id="ana">
			<?php include 'include/html/body/ana/header.php'; ?>
			<div id="anaicerik">
				<?php 
					if (!$kullanici = Input::getir('kullanici')) {
						Yonlendir::git('index.php');
					}else{
						$kullanici = new Kullanici($kullanici);
						if (!$kullanici->varsa()) {
							Yonlendir::git('404');
						}else{
							$veri = $kullanici->veri();
						}
						?>
							<h3>Kullanıcı Adınız: <?php echo filtrele($veri->kullanici_adi); ?></h3>
							<h3>Adınız: <?php echo filtrele($veri->isim); ?></h3>
						<?php
					}
				?>
			</div>
			<?php include 'include/html/body/ana/footer.php'; ?>
			<?php include 'include/html/body/ana/form.php'; ?>
		</div>
		<?php include 'include/html/body/script.php'; ?>
	</body>
</html>
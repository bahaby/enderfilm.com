<?php require_once 'core/init.php'; ?>
<!DOCTYPE html>
<html>
	<?php include 'include/html/head.php'; ?>
	<body>
		<div id="ana">
			<?php include 'include/html/body/ana/header.php'; ?>
				<div id="anaicerik">
				<div class="sabit-tablo">
			<div class="baslik"><i class="fa fa-envelope-o"></i> Film İstek Sayfası</div>
			<div class="ic">
				<div class="istek_form">
					<form method="post">
						<p>
							<label><i class="fa fa-user"></i> Ad Soyad</label>
							<input type="text" name="istek_isim" value="" placeholder="Adınızı Yazınız" required="">
						</p>
						<p>
							<label><i class="fa fa-envelope"></i> E-Posta Adresiniz</label>
							<input type="text" name="istek_email" placeholder="örn : deneme@mail.com" required>
						</p>
						<p>
							<label><i class="fa fa-film"></i> Filmin Adı</label>
							<input name="istek_kadi" type="text" placeholder="Filmin adını yazınız.">
						</p>
						<p>
							<label><i class="fa fa-align-center"></i> Filmin Konusu</label>
							<textarea name="istek_mesaj" class="textarea" required ></textarea>
						</p>
						<p>
							<input type="submit" value="Gönder">
						</p>
					</form>
				</div>
				<div class="ikonlar">
					<i class="fa fa-film fa-5x"></i>
					<i class="fa fa-ellipsis-v fa-5x"></i>
				</div>
			</div>
		</div>
				</div>
			<?php include 'include/html/body/ana/footer.php'; ?>
			<?php include 'include/html/body/ana/form.php'; ?>
		</div>
		<?php include 'include/html/body/script.php'; ?>
	</body>
</html>
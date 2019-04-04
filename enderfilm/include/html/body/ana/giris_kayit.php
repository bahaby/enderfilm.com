<?php $token=Token::olustur(); ?>
<div id="giris" style="display: none;">
	<form class="girisol" action="form.php" method="post" onsubmit="return false">
		<div class="alan">
			<label for="kullanici_adi">Kullanıcı Adı:</label>
			<input type="text" name="kullanici_adi" id="kullanici_adi" autocomplete="off">
		</div>
		<div class="alan">
			<label for="sifre">Şifre:</label>
			<input type="password" name="sifre" id="sifre" autocomplete="off">
		</div>
		<div class="alan">
			<label for="hatirla">Beni Hatırla:</label>
			<input type="checkbox" name="hatirla" id="hatirla" autocomplete="off">
		</div>
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
		<div class="alan">
			<input class="girisyap" type="submit" name="giris" value="Üye Ol">
		</div>
		<div class="hata"></div>
	</form>
</div>
<div id="kayit" style="display: none;">
	<form class="kayitol" action="form.php" method="post" onsubmit="return false">
		<div class="alan">
			<label for="kullanici_adi">Kullanıcı Adı</label>
			<input type="text" name="kullanici_adi" id="kullanici_adi" value="<?php echo filtrele(Input::getir('kullanici_adi'));?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="sifre">Şifre</label>
			<input type="password" name="sifre" id="sifre" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="sifre_tekrar">Şifre Tekrar</label>
			<input type="password" name="sifre_tekrar" id="sifre_tekrar" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="email">Eposta</label>
			<input type="text" name="email" id="email" value="<?php echo filtrele(Input::getir('email'));?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="isim">İsim</label>
			<input type="text" name="isim" id="isim" value="<?php echo filtrele(Input::getir('isim'));?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="soyisim">Soyisim</label>
			<input type="text" name="soyisim" id="soyisim" value="<?php echo filtrele(Input::getir('soyisim'));?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off">
		</div>
		<div class="alan">
			<label for="cinsiyet">Cinsiyet</label>
			<select name="cinsiyet" id="cinsiyet">
				<option selected hidden>Cinsiyet</option>
				<option value="1">Bay</option>
				<option value="2">Bayan</option>
			</select>
		</div>
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
		<div class="alan">
			<input class="uyeol" type="submit" name="kayit" value="Üye Ol">
		</div>
		<div class="hata"></div>
	</form>
</div>
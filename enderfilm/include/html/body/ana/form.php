<?php
$token=Token::olustur();
?>
<div class="kullanici">
	<div id="giris" class="k_form">
		<form action="/user.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" autofill="off" id="girisForm">
			<div class="alan">
				<label for="kullanici_adi_g" class="fa fa-user"></label>
				<input type="text" name="kullanici_adi_g" id="kullanici_adi_g" placeholder="Kullanıcı Adı">
			</div>
			<div class="a_hata"><label for="kullanici_adi_g" generated="true" class="error"></label></div>
			<div class="alan">
				<label for="sifre_g" class="fa fa-unlock-alt"></label>
				<input type="password" name="sifre_g" id="sifre_g" placeholder="Şifreniz">
			</div>
			<div class="a_hata"><label for="sifre_g" generated="true" class="error"></label></div>
			<div class="a_hata"><div id="giris_hata" class="h_form"></div></div>
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<div class="alan_s">
				<span class="s_unuttum">Şifremi Unuttum</span>
				<button name="giris" id="girisTus">Giriş</button>
			</div>
		</form>
	</div>
	<div id="hatirla" class="k_form">
		<form action="/user.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" autofill="off" id="hatirlaForm">
			<div class="alan">
				<label for="kullanici_adi" class="fa fa-user"></label>
				<input type="text" name="kullanici_adi" id="kullanici_adi" placeholder="Kullanıcı Adı">
			</div>
			<div class="a_hata"><label for="kullanici_adi" generated="true" class="error"></label></div>
			<div class="alan">
				<label for="email" class="fa fa-envelope"></label>
				<input type="email" name="email" id="email" placeholder="Email adresi">
			</div>
			<div class="a_hata"><label for="email" generated="true" class="error"></label></div>
			<div class="a_hata"><div id="hatirla_hata" class="h_form"></div></div>
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<div class="alan_s">
				<button name="hatir" id="hatirlaTus">Onayla</button>
			</div>
		</form>
	</div>
	<div id="kayit" class="k_form">
		<form action="/user.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" autofill="off" id="kayitForm">
			<div class="alan">
				<label for="kullanici_adi_k" class="fa fa-user"></label>
				<input type="text" name="kullanici_adi" id="kullanici_adi_k" value="<?php echo filtrele(Input::getir('kullanici_adi_k'));?>" placeholder="Kullanıcı Adı">
			</div>
			<div class="a_hata"><label for="kullanici_adi_k" generated="true" class="error"></label></div>
			<div class="alan">
				<label for="sifre_k" class="fa fa-unlock-alt"></label>
				<input type="password" name="sifre" id="sifre_k" placeholder="Şifre">
			</div>
			<div class="a_hata"><label for="sifre_k" generated="true" class="error"></label></div>
			<div class="alan">
				<label for="sifre_tekrar" class="fa fa-lock"></label>
				<input type="password" name="sifre_tekrar" id="sifre_tekrar" placeholder="Şifre Onayı">
			</div>
			<div class="a_hata"><label for="sifre_tekrar" generated="true" class="error"></label></div>
			<div class="alan">
				<label for="email_k" class="fa fa-envelope"></label>
				<input type="text" name="email" id="email_k" value="<?php echo filtrele(Input::getir('email'));?>" placeholder="Email Adresi">
			</div>
			<div class="a_hata"><label for="email_k" generated="true" class="error"></label></div>
			<div class="a_hata"><div id="kayit_hata" class="h_form"></div></div>
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<div class="alan_s">
				<button name="kayit" id="kayitTus">Kaydol</button>
			</div>
		</form>
	</div>
		<?php
		if(isset($_GET['email'])&&isset($_GET['sifre_al'])){
			$email=Input::getir('email');
			$sifre_al=Input::getir('sifre_al');
			$db=DB::baglan();
			if ($veri=$db->getirAll("uye","where email=?",array($email))) {
				$uye=$veri[0];
				if (Hash::yap($email,$uye['salt'])==$sifre_al) {
				?>
					<div id="y_sifre" class="k_form">
						<form action="/user.php" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" autofill="off" id="y_sifreForm">
							<div class="alan">
								<label for="sifre_y" class="fa fa-unlock-alt"></label>
								<input type="password" name="sifre" id="sifre_y" placeholder="Şifreniz">
							</div>
							<div class="a_hata"><label for="sifre_y" generated="true" class="error"></label></div>
							<div class="alan">
								<label for="sifre_t_y" class="fa fa-lock"></label>
								<input type="password" name="sifre_t" id="sifre_t_y" placeholder="Şifre Onayı">
							</div>
							<div class="a_hata"><label for="sifre_t_y" generated="true" class="error"></label></div>
							<div class="a_hata"><div id="y_sifre_hata" class="h_form"></div></div>
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							<input type="hidden" name="id" value="<?php echo $uye['id']; ?>">
							<div class="alan_s">
								<button name="y_sifre" id="y_sifreTus">Şifreni Değiştir</button>
							</div>
						</form>
					</div>	
				<?php
				}else{
					Yonlendir::git('/');
				}
			}
		}
		?>
		<?php 
			if (Session::varsa('onay')) {
				?>
				<div id="hataKutu" style="padding:30px; ">
				<?php
					echo Session::flash('onay');
				?>
				</div>
				<?php
			}
		?>
</div>
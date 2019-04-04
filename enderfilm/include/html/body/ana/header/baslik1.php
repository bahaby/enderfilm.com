<div id="ust_header">
	<div class="ust">
		<ul class="sag">
			<li><a href="/istek.php">Film İstek</a></li>
			<li><a href="/oneri.php">Öneri</a></li>
			<li><a href="/iletisim.php">İletişim</a></li>
		</ul>
		<?php
			$kullanici= new Kullanici();
			if ($kullanici->girisYapti()){
			?>
				<ul class="sol">
					<li><a href="/cikis.php">Çıkış</a></li>
					<li><a href="/profil.php?kullanici=<?php echo filtrele($kullanici->veri()->kullanici_adi); ?>"><?php echo filtrele($kullanici->veri()->kullanici_adi); ?></a></li>
					<?php 
						if ($kullanici->yetki('admin')){
						?>
							<li><a href="/admin.php">Admin Paneli</a></li>
						<?php
						}
					?>
				</ul>
			<?php
			}else{
			?>
				<ul class="sol">
					<li><a class="girisYap">Giriş</a></li>
					<li><a class="kayitYap">Kayıt</a></li>
				</ul>
			<?php
			}
		?>
	</div>
</div>
<?php require_once 'core/init.php'; ?>
<style>	
*{
	margin: 0;
	padding:0;
	font-size: 14px;
	font-family: arial;
}
.orta{
	position: absolute;
	top: 50%;
	left: 50%;
	display: table;
	width: auto;
	height: auto;
	margin-left: -100px;
	margin-top: -140px;
}
ul li{
	list-style: none;
	background-color: black;
	border-radius: 5px;
	text-align: center;
	margin-bottom: 10px;
	line-height: 30px;
}
ul li a{
	color: white;
	text-decoration: none;
	width: 200px;
	height: 30px;
	display: table;
}
ul li p{
	color: white;
}
</style>
<?php 
	$kullanici= new Kullanici();
	if ($kullanici->girisYapti()) {
		if ($kullanici->yetki('admin')) {
			?>
				<div class="orta">	
					<ul>
						<li><a href="/">Anasayfa</a></li>
						<li><a href="ekle.php">Film Ekle</a></li>
						<li><a href="duzenle.php">Film Düzenle</a></li>
						<li><a href="cikis.php">Çıkış</a></li>
					</ul>
				</div>
			<?php
		}else{
			if ($kullanici->yetki('aktif')) {
				echo 'sadece admin';
			}else{
				echo 'hesabınız aktif değil';
			}
		}
	}else{
		Yonlendir::git("/");
	}
	?>

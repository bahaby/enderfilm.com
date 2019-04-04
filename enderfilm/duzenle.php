<?php require_once 'core/init.php'; ?>
<style>	
	*{
		margin: 0;
		padding:0;
		font-size: 14px;
		font-family: arial;
		text-decoration: none;
	}
	ul li{
		list-style: none;
	}
	body{
		width: 960px;
		margin:0 auto;
	}
	#header{
		width: 100%;
		height: 40px;
		background-color: black;
		border-radius:0 0 5px 5px;
	}
	#header ul li a{
		background-color: white;
		height: 26px;
		line-height: 26px;
		display: table;
		padding: 0 10px;
		border-radius: 5px;
		color: black;
		font-weight: bold;
	}
	#header .son li{
		float: right;
		margin:7px 10px 0 0;
	}
	#header .ilk li{
		float: left;
		margin:7px 0 0 10px;
	}
	#duzen_list {
		width: 960px;
		height: 30px;
		margin-top: 5px;
		background-color: #0d47a1;
		border-radius: 5px;
	}
	#duzen_list:hover{
		background-color: #D73D32;
	}
	#duzen_list ul li{
		float: left;
	}
	#duzen_list .son li{
		float: right;
		margin:5px 10px 0 0;
	}
	#duzen_list .ilk li{
		float: left;
		margin:5px 0 0 10px;
	}
	#duzen_list ul li a{
		padding: 0 10px;
		background-color: black;
		color: white;
		height: 20px;
		line-height: 20px;
		display: table;
		border-radius: 5px;
	}
</style>
<?php 
	$kullanici= new Kullanici();
	if ($kullanici->girisYapti()) {
		if ($kullanici->yetki('admin')) {
			?>
			<div id="header">
				<ul class="ilk">
					<li><a href="/">Anasayfa</a></li>
					<li><a href="admin.php">Admin Paneli</a></li>
			 		<li><a href="ekle.php">Yeni Ekle</a></li>
				</ul>
				<ul class="son">
					<li><a href="cikis.php">Çıkış</a></li>
					<li><a href="profil.php?kullanici=<?php echo $kullanici->veri()->kullanici_adi; ?>"><?php echo $kullanici->veri()->isim." ".$kullanici->veri()->soyisim; ?></a></li>
				</ul>
			</div>
			<?php
			$film=new Film();
			$veriler=$film->getirFilm();
			foreach ($veriler as $veri) {
			?>
				<div id="duzen_list">
					<ul class="ilk">
						<li><a href="izle.php?f=<?php echo $veri['id']; ?>"><?php echo $veri['film_adi']; ?></a></li>
					</ul>
					<ul class="son">
						<li><a href="ekle.php?s=guncelle&id=<?php echo $veri['id'] ?>">Güncelle</a></li>
					</ul>
				</div>
			<?php
			}
		}else{
			echo 'sadece admin';
		}
	}else{
		Yonlendir::git("/");
	}
?>
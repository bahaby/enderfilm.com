<?php 
	$film=new Film(); 
	$rasgele=$film->getirFilm('order by rand() limit 1');
?>
<div id="alt_header">
	<div class="alt">
		<ul class="sag">
			<li><a href="/"><i class="fa fa-home"></i></a></li>
			<li><a href="#">POPULER FİLMLER</a></li>
			<li><a href="/izle/<?php echo $rasgele[0]['seo_adi']; ?>.html">RASTGELE İZLE</a></li>
		</ul>
		<div class="logo"></div>
		<ul class="sol">
			<form id="ara_form" method="post" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" autofill="off" onsubmit="return false;">
				<li>
					<input id="ara_k" type="text" placeholder="Aramak için Yazınız">
				</li>
				<li><button></button><i id="ara_tus" class="fa fa-search"></i></li>
			</form>
			<div id="sonuc_k"></div>
		</ul>
	</div>
</div>
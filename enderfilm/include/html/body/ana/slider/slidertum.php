	<div class="slidertum">
		<?php $film=new Film();?>
		<div id="slider1" class="slider">
			<ul>
			<?php
				$veriler=$film->getirFilm('where (durum = 1 or durum = 2) order by izlenme DESC limit 9');
				foreach ($veriler as $veri) {
					?>
						<li class="slidericerik"><a href="izle/<?php echo $veri['seo_adi']; ?>.html"><img class="filmresim" src="/img/k_resim/<?php echo $veri['resim']; ?>" alt=""><img class="play" src="/img/play.png" alt=""></a></li>
					<?php
					}
				?>
			</ul>
		</div>
		<div id="slider2" class="slider aktif">
			<ul>
			<?php
				$veriler=$film->getirFilm('where durum = 2 order by eklenme DESC limit 9');
				foreach ($veriler as $veri) {
					?>
						<li class="slidericerik"><a href="izle/<?php echo $veri['seo_adi']; ?>.html"><img class="filmresim" src="/img/k_resim/<?php echo $veri['resim']; ?>" alt=""><img class="play" src="/img/play.png" alt=""></a></li>
					<?php
					}
				?>
			</ul>
		</div>
		<div id="slider3" class="slider">
			<ul>
			<?php
				$veriler=$film->getirFilm('where (durum = 1 or durum = 2) order by eklenme DESC limit 9');
				foreach ($veriler as $veri) {
					?>
						<li class="slidericerik"><a href="izle/<?php echo $veri['seo_adi']; ?>.html"><img class="filmresim" src="/img/k_resim/<?php echo $veri['resim']; ?>" alt=""><img class="play" src="/img/play.png" alt=""></a></li>
					<?php
					}
				?>
			</ul>
		</div>
	</div>
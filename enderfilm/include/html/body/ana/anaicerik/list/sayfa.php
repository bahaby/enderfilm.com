<div class="sayfa">
	<ul>
		<?php
		if ($sayfa>1) {
			$q=($sayfa==2)?($get_yol?'/?'.$get_yol:'/'):"/".($sayfa-1).($get_yol?'?'.$get_yol:'');
			echo '<li><a href="'.$q.'"><i class="fa fa-angle-left fa-3x" aria-hidden="true"></i></a></li>';
		}
		if ($sayfa>3&&$tsayfa>6) {
			echo '<li><div><a href="'.($get_yol?'/?'.$get_yol:'/').'">1</a></div></li>';
		}
		if ($sayfa>4&&$tsayfa>7) {
			echo '<li><i class="fa fa-ellipsis-h nokta" aria-hidden="true"></i></li>';
		}
		$x=0;
		if ($sayfa==1||$sayfa==$tsayfa) {
			$x=2;
		}else if($sayfa==2||$sayfa==$tsayfa-1){
			$x=1;
		}else if($sayfa==3||$sayfa==$tsayfa-2){
			$x=0;
		}else{
			$goster=2;
		}
		for ($i=$sayfa-$goster-$x; $i < $sayfa + $goster + $x+1; $i++) { 
			if ($i>0&&$i<=$tsayfa) {
				if ($i == $sayfa) {
					echo '<li><div><p class="aktif">'.$i.'</p></div></li>';
				}else{
					$y=($i===1)?($get_yol?'/?'.$get_yol:'/'):"/".$i.($get_yol?'?'.$get_yol:'');
					echo '<li><div><a href="'.$y.'">'.$i.'</a></div></li>';
				}
			}
		}
		if ($sayfa<$tsayfa-3&&$tsayfa>7) {
			echo '<li><i class="fa fa-ellipsis-h nokta" aria-hidden="true"></i></li>';
		}
		if ($sayfa<$tsayfa-2&&$tsayfa>6) {
			echo '<li><div><a href="/'.$tsayfa.($get_yol?"?".$get_yol:"").'">'.$tsayfa.'</a></div></li>';
		}
		if ($sayfa<$tsayfa) {
			echo '<li><a href="/'.($sayfa+1).($get_yol?"?".$get_yol:"").'"><i class="fa fa-angle-right fa-3x" aria-hidden="true"></i></a></li>';
		}
		?>
	</ul>
</div>
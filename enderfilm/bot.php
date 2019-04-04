<?php 
	require_once 'core/init.php';
	include 'araclar/html_get/simple_html_dom.php';
	$kullanici= new Kullanici();
	if ($kullanici->girisYapti()) {
		if ($kullanici->yetki('admin')) {
			if (Input::varsa()) {
				if (Isset($_POST["film"],$_POST["sinema"])) {
					$link=trim(Input::getir("film"));
					$link_sinemalar=trim(Input::getir("sinema"));
		//film sitesinden linkler//
					$html = file_get_html($link);
					$test=$html->find("div.film_part a");
					$say=count($test);
					$x=trim((string)$html->find(".film_part + span",1));
					$y=(string)$html->find("div#film p iframe",0)->src;
					$link_array = array($x => $y);
					for ($i=2; $i <= $say ; $i++) { 
						$cek=file_get_html($link."/".$i);
						$t=trim((string)$test[($i-2)]->find("span",0)->plaintext);
						$u=(string)$cek->find("div#film p iframe",0)->src;
						$link_array[$t]=$u;
					}
					$link_ne=$html->find("a.category_link");
					foreach ($link_ne as $key) {
						if (preg_match("/Türkçe Dublaj/", (string)$key->plaintext)) {
							$if_dublaj=true;
						}
						if (preg_match("/Türkçe Altyazılı/", (string)$key->plaintext)) {
							$if_altyazi=true;
						}
					}
					foreach ($link_array as $key => $value) {
						$b=explode(" ", $key);
						$c=explode(".org/player", $value);
						if ($c[0]!="http://filmakinesi"&&$key!=""&&$value!="") {
							if ($b[0]=="Tek"&&$if_dublaj===true) {
								$dublaj[]=array($b[1],$value);
							}else if ($b[0]=="Tek"&&$if_altyazi===true) {
								$altyazi[]=array($b[1],$value);
							}else if ($b[0]=="Altyazılı"&&$if_altyazi===true) {
								$altyazi[]=array($b[1],$value);
							}else if ($b[0]=="Fragman") {
								$fragman=$value;
							}
						}
					}
					if (count($dublaj)>0&&count($altyazi)==0) {
						$dil="Dublaj";
					}else if (count($dublaj)==0&&count($altyazi)>0) {
						$dil="Altyazı";
					}else if (count($dublaj)>0&&count($altyazi)>0) {
						$dil="Multi";
					}
		//film sitesinden linkler bitiş//

		//sinemalar//
					$html2=file_get_html($link_sinemalar);
					$resim_link_s=$html2->find("head link[rel=image_src]",0)->href;
					$konu_x=trim((string)$html2->find("div#dscMore p",0)->plaintext);//Film Konu
					$konu = preg_replace('~[\r\n\t]+~', '', $konu_x);
					$film_a1=trim((string)$html2->find("hgroup h1",0)->plaintext);
					$film_a2=trim((string)$html2->find("hgroup h2",0)->plaintext);
					$film_adi=$film_a1.(($film_a2=="")?"":" (".$film_a2.")");
					$icerik=$html2->find(".film-detail .mh335 p");
					foreach ($icerik as $key) {
						$x=explode(":", (string)$key->find("label",0)->plaintext);
						$baslik=trim($x[0]);
						if ($baslik=="Yapımı") {
							$t=explode(" - ", $key->find("span",1)->plaintext);
							$ulke_x=trim((string)$t[1]);
							$y_x=explode(",&nbsp;", $ulke_x);
							foreach ($y_x as $key) {
								$kl[]=trim((string)$key);
							}
							$ulke=implode(", ", $kl);
							$yil=trim($t[0]);
						}else if ($baslik=="Tür") {
							$x=explode(",&nbsp;", $key->find("span",1)->plaintext);
							$tur=array_map('trim', $x);
						}else if ($baslik=="Yönetmen") {
							$x=explode(":", $key->plaintext);
							$y_p=str_replace(array("&nbsp;","-"), array("",""), $x[1]);
							$y=@array_map("trim", $y_p);
							$y_x=explode(",", $y);
							$yonetmen_s=implode(", ", $y_x);
						}else if ($baslik=="Senaryo") {
							$x=explode(":", $key->plaintext);
							$y_p=str_replace(array("&nbsp;","-"), array("",""), $x[1]);
							$y=@array_map("trim", $y_p);
							$y_x=explode(",", $y);
							$senaryo_s=implode(", ", $y_x);
						}else if ($baslik=="Süre") {
							$sure_s=trim((string)$key->find("span",1)->plaintext);
						}
					}
		//sinemalar bitiş//

		//omdb//
					if (Input::getir("imdb")!="") {
						$omdb_veri=file_get_contents("http://www.omdbapi.com/?i=".(string)Input::getir("imdb")."&tomatoes=true&r=json");
						$imdb_j=json_decode($omdb_veri, true);
					}else if (Input::getir("imdb")=="") {
						$film_a_link1=str_replace(" ", "%20", $film_a1);
						$film_a_link2=str_replace(" ", "%20", $film_a2);
						$omdb_veri2=file_get_contents("http://www.omdbapi.com/?t=".$film_a_link2."&y=".$yil."&tomatoes=true&r=json");
						$omdb_veri1=file_get_contents("http://www.omdbapi.com/?t=".$film_a_link1."&y=".$yil."&tomatoes=true&r=json");
						if ($json1["Response"]=="False") {
							$imdb_j=json_decode($omdb_veri2, true);
						}else if($json1["Response"]!="False"){
							$imdb_j=json_decode($omdb_veri1, true);
						}else{
							$imdb_j=false;
						}
					}
					foreach ($imdb_j as $key => $value) {
						if ($value=="N/A") {
							$imdb_j[$key]=null;
						}
					}
					$x_sure=explode(" ", $imdb_j["Runtime"]);
					$sure_i=$x_sure[0];
					($sure_i!="")?($sure=$sure_i):($sure=$sure_s);
					$resim_link_i=$imdb_j["Poster"];
					@$resim_s = getimagesize($resim_link_s);
					@$resim_i = getimagesize($resim_link_i);
					if ($resim_s[0]>200) {
						$resim=$resim_link_s;
					}else if($resim_link_i===null){
						$resim=$resim_link_s;
					}else{
						$resim=$resim_link_i;
					}
					if (preg_match("/Türkiye/", $ulke)) {
						$yapim="Yerli";
					}else{
						$yapim="Yabancı";
					}
					$yonetmen_i_X=$imdb_j["Director"];
					$yonetmen_i=preg_replace('/ \((.*?)\)/', "", $yonetmen_i_X);
					$senaryo_i_x=$imdb_j["Writer"];
					$senaryo_i=preg_replace('/ \((.*?)\)/', "", $senaryo_i_x);
					if ($senaryo_s==""&&$senaryo_i!="") {
						$senaryo=$senaryo_i;
					}else if ($senaryo_s!="") {
						$senaryo=$senaryo_s;
					}else if ($senaryo_s==""&&$senaryo_i=="") {
						$senaryo="";
					}
					if ($yonetmen_s==""&&$yonetmen_i!="") {
						$yonetmen=$yonetmen_i;
					}else if ($yonetmen_s!="") {
						$yonetmen=$yonetmen_s;
					}else if ($yonetmen_s==""&&$yonetmen_i=="") {
						$yonetmen="";
					}
					$meta=$imdb_j["Metascore"];
					$imdb=$imdb_j["imdbRating"]*10;
					$imdb_id=$imdb_j["imdbID"];
					$tomato_link=$imdb_j["tomatoURL"];
					$tomato=$imdb_j["tomatoMeter"];
					$f_ayrinti=array("konu"=>$konu,"film_adi"=>$film_adi,"ulke"=>$ulke,"vizyon"=>$yil,"tur"=>$tur,"yonetmen"=>$yonetmen,"senaryo"=>$senaryo,"sure"=>$sure,"resim_link"=>$resim,"meta"=>$meta,"imdb"=>$imdb,"imdb_id"=>$imdb_id,"tomato_link"=>$tomato_link,"tomato"=>$tomato,"dil"=>$dil,"yapim"=>$yapim);
					$td=array("altyazi"=>$altyazi,"dublaj"=>$dublaj,"fragman"=>$fragman,"f_ayrinti"=>$f_ayrinti);
					$cikti=json_encode($td);
		//omdb bitiş//
					echo $cikti;
				}
			 }
		}else{
				echo 'sadece admin';
		}
	}else{
		Yonlendir::git("/");
	}
?>

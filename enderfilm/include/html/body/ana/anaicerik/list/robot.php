<ul class="robot">
	<form action="/" method="get">
		<li class="sirala">
			<select name="l" id="">
				<option value="1" hidden selected >Sıralama</option>
				<option value="1">↓ Eklenme</option>
				<option value="2">↓ İzlenme</option>
				<option value="3">↓ IMDB</option>
				<option value="4">↓ İsim</option>
				<option value="5">↑ İsim</option>
				<option value="6">↓ Yıl</option>
				<option value="7">↑ Yıl</option>
			</select>
		</li>
		<li class="yapim">
			<select name="y" id="">
				<option value="1" hidden selected >Yapım</option>
				<option value="1">Hepsi</option>
				<option value="2">Yerli</option>
				<option value="3">Yabancı</option>
			</select>
		</li>
		<li class="tur">
			<select name="t" id="">
				<option value="1" hidden selected>Tür</option>
		 		<option value="1">Hepsi</option>
		 		<option value="2">Aile</option>
		 		<option value="3">Animasyon</option>
		 		<option value="4">Aksiyon</option>	
		 		<option value="5">Belgesel</option>
		 		<option value="6">Bilim Kurgu</option>
		 		<option value="7">Biyografi</option>
		 		<option value="8">Dram</option>	
		 		<option value="9">Fantastik</option>	
		 		<option value="10">Gerilim</option>	
		 		<option value="11">Gizem</option>	
		 		<option value="12">Komedi</option>	
		 		<option value="13">Korku</option>	
		 		<option value="14">Macera</option>	
		 		<option value="15">Müzikal</option>	
		 		<option value="16">Polisiye</option>	
		 		<option value="17">Romantik</option>	
		 		<option value="18">Savaş</option>
		 		<option value="19">Suç</option>	
		 		<option value="20">Tarih</option>
				<option value="21">Spor</option>	
			</select>
		</li>
		<li class="imdb">
			<select name="i" id="">
				<option value="1" hidden selected>IMDB</option>
				<option value="1">Hepsi</option>
				<option value="9">9 ve üzeri</option>
				<option value="8">8 ve üzeri</option>
				<option value="7">7 ve üzeri</option>
				<option value="6">6 ve üzeri</option>
				<option value="5">5 ve üzeri</option>
				<option value="4">4 ve üzeri</option>
				<option value="3">3 ve üzeri</option>
			</select>
		</li>
		<li class="dil">
			<select name="d" id="">
				<option value="1" hidden selected>Dil</option>
				<option value="1">Hepsi</option>
				<option value="2">Dublaj</option>
				<option value="3">Altyazı</option>
			</select>
		</li>
		<li class="yil">
			<input name="min" type="number" value="1930" min="1930" max="2017">
			<input name="max" type="number" value="2017" min="1930" max="2017">
		</li>
		<li class="yolla"><input type="submit" value="Listele"></li>
	</form>
</ul>
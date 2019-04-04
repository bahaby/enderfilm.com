<?php 
	class Onaylama{
		private $_tamam = false,
				$_hatalar = null,
				$_db = null;
		public function __construct(){
			$this->_db = DB::baglan();
		}
		public function kontrol($kaynak,$bolumler=array()){
			foreach ($bolumler as $bolum => $kurallar) {
				$bolum=filtrele($bolum);
				foreach ($kurallar as $kural => $kural_deger) {
					$deger=trim($kaynak[$bolum]);
					if ($kural ==='zorunlu' && empty($deger)) {
						$this -> hataEkle();
					}else if(!empty($deger)){
						switch ($kural) {
							case 'min':
								if (strlen($deger)<$kural_deger) {
									$this->hataEkle();
								}
								break;
							case 'max':
								if (strlen($deger)>$kural_deger) {
									$this->hataEkle();
								}
								break;
							case 'eslesme':
								if ($deger!=$kaynak[$kural_deger]) {
									$this->hataEkle();
								}
								break;
							case 'benzersiz':
								$kontrol =$this->_db->getir($kural_deger, array("$bolum","=","$deger"));
								if ($kontrol->sayac()) {
									$this->hataEkle();
								}
								break;
							case 'varsa':
								$kontrol =$this->_db->getir($kural_deger, array("$bolum","=","$deger"));
								if (!$kontrol->sayac()) {
									$this->hataEkle();
								}
								break;
							default:

								break;
						}
					}
				}
			}
			if ($this->_hatalar!==false) {
				$this->_tamam = true;
			}
			return $this;
		}
		public function hataEkle(){
			$this->_hatalar = false;
		}
		public function tamam(){
			return $this->_tamam;
		}
	}
?>
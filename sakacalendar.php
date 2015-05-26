<?php
class SakaCalendar{

	// Wewukon
    public $angkaWuku;
	public $noWuku;
	public $uripWuku;
	public $uripPancawara;
	public $uripSaptawara;
	public $noEkawara;
	public $noDwiwara;
	public $noTriwara;
	public $noCaturwara;
	public $noPancawara;
	public $noSadwara;
	public $noSaptawara;
	public $noAstawara;
	public $noSangawara;
	public $noDasawara;
	
	// Kalender Saka
	public $tahunSaka;
	public $penanggal;
	public $isPangelong;
	public $isNgunaratri;
	public $noNgunaratri; //Jumlah hari sejak nemugelang pengalantaka 
	public $noSasih;
	public $isNampih;
	public $pivot;

	public $tgl;

	function __construct($tgl) {
		$this->tgl = new DateTime($tgl);
       	$this->setPivot();
       	$this->hitungWuku();
       	$this->hitungWewaran();
       	$this->hitungSaka();
		// echo '<pre>';
		// 	var_dump($this);
		// echo '</pre>';
   	}


	private function setPivot() {
		
		$pivots = array ();

		$pivotTemp = array();
        $pivotTemp['date'] = new DateTime('1991-01-01');
        $pivotTemp['noWuku'] = 1; $pivotTemp['angkaWuku'] = 143;
        $pivotTemp['tahunSaka'] = 1; $pivotTemp['noSasih'] = 1; $pivotTemp['penanggal'] = 15; $pivotTemp['isPangelong'] = false; $pivotTemp['noNgunaratri'] = 916; $pivotTemp['isNgunaratri'] = false;
        $pivots[]=$pivotTemp;


        $pivotTemp['date'] = new DateTime('1991-1-1');//01-01-1991
		$pivotTemp['noWuku'] = 21; $pivotTemp['angkaWuku']= 143;
 		$pivotTemp['angkaWuku'] = 1912; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 15; $pivotTemp['isPangelong'] = false; $pivotTemp['noNgunaratri'] = 916; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;

		$pivotTemp['date'] = new DateTime('1992-1-1');//01-01-1992
		$pivotTemp['noWuku'] = 13; $pivotTemp['angkaWuku']= 88;
		$pivotTemp['tahunSaka'] = 1913; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 11; $pivotTemp['isPangelong'] = true; $pivotTemp['noNgunaratri'] = 1281; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('1999-1-1');//01-01-1999
		$pivotTemp['noWuku'] = 18; $pivotTemp['angkaWuku']= 125;
		$pivotTemp['tahunSaka'] = 1920; $pivotTemp['noSasih'] = 8; $pivotTemp['penanggal'] = 13; $pivotTemp['isPangelong'] = false; $pivotTemp['noNgunaratri'] = 58; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('2000-1-1');//01-01-2000
		$pivotTemp['noWuku'] = 10; $pivotTemp['angkaWuku']= 70;
		$pivotTemp['tahunSaka'] = 1921; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 10; $pivotTemp['isPangelong'] = true; $pivotTemp['noNgunaratri'] = 424; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('2002-1-1');//01-01-2002
		$pivotTemp['noWuku'] = 25 ;$pivotTemp['angkaWuku']= 171;
		$pivotTemp['tahunSaka'] = 1923; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 3; $pivotTemp['isPangelong'] = true; $pivotTemp['noNgunaratri'] = 1155; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('2003-1-1');//01-01-2003
		$pivotTemp['noWuku'] = 17 ;$pivotTemp['angkaWuku']= 116;
		$pivotTemp['tahunSaka'] = 1924; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 14; $pivotTemp['isPangelong'] = true; $pivotTemp['noNgunaratri'] = 1520; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('2012-6-17');//17-05-2012
		$pivotTemp['noWuku'] = 1;$pivotTemp['angkaWuku']= 1;
		$pivotTemp['tahunSaka'] = 1934; $pivotTemp['noSasih'] = 12; $pivotTemp['penanggal'] = 13; $pivotTemp['isPangelong'] = true; $pivotTemp['noNgunaratri'] = 1195; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;
		
		$pivotTemp['date'] = new DateTime('2101-1-1');//01-01-2101
		$pivotTemp['noWuku'] = 30;$pivotTemp['angkaWuku']= 210;
		$pivotTemp['tahunSaka'] = 2022; $pivotTemp['noSasih'] = 7; $pivotTemp['penanggal'] = 1; $pivotTemp['isPangelong'] = false; $pivotTemp['noNgunaratri'] = 1404; $pivotTemp['isNgunaratri'] = false;
		$pivots[]=$pivotTemp;

		$pivotTerdekat = null;
		foreach ($pivots as $item){
			$year = $item['date']->format('Y');
			if($pivotTerdekat == null || abs($this->tgl->format('Y') - $closestYear) > abs($year - $this->tgl->format('Y'))) {
         		$pivotTerdekat = $item;
				$closestYear = $item['date']->format('Y');
	      	}
		}
		
		$this->pivot = $pivotTerdekat;
	}


	/*** Fungsi menghitung perbedaan hari antara 2 SakaCalendar ***/
	function getDateDiff($d1, $d2) { //Gunakan parameter DateTime
		$interval = date_diff($d1, $d2, false);
		if($interval->invert){
			$diff = -$interval->days;
		}else{
			$diff = $interval->days;
		}
		return $diff ;
	}
	

	/*** Fungsi menghitung pawukon ***/
	function hitungWuku() { //Gunakan parameter DateTime
		$pivot = $this->pivot;
		$tgl = $this->tgl;
		$bedaHari = $this->getDateDiff($pivot['date'],$tgl); 

		if ($bedaHari >= 0){
			$this->angkaWuku = ($pivot['angkaWuku'] + $bedaHari)%210 ;
		}else{
			$this->angkaWuku = 210 - ((-($pivot['angkaWuku'] + $bedaHari))%210) ;
		}
		if ($this->angkaWuku == 0){ $this->angkaWuku = 210; }
		$this->noWuku = (int) ceil($this->angkaWuku /7.0);
		if ($this->noWuku > 30) { $this->noWuku %=30; } 
		if ($this->noWuku == 0) { $this->noWuku =30; }

		switch ($this->noWuku) {
		case 1: //Sinta
			$this->uripWuku = 7;
			break;
		case 2: //Landep
			$this->uripWuku = 1;
			break;
		case 3: //Ukir
			$this->uripWuku = 4;
			break;
		case 4: //Kulantir
			$this->uripWuku = 6;
			break;
		case 5: //Tolu
			$this->uripWuku = 5;
			break;
		case 6: //Gumbreg
			$this->uripWuku = 8;
			break;
		case 7: //Wariga 
			$this->uripWuku = 9;
			break;
		case 8: //Warigadean
			$this->uripWuku = 3;
			break;
		case 9: //Julungwangi
			$this->uripWuku = 7;
			break;
		case 10: //Sungsang
			$this->uripWuku = 1;
			break;
		case 11: //Dunggulan
			$this->uripWuku = 4;
			break;
		case 12: //Kuningan
			$this->uripWuku = 6;
			break;
		case 13: //Langkir
			$this->uripWuku = 5;
			break;
		case 14: //Medangsia
			$this->uripWuku = 8;
			break;
		case 15: //Pujut
			$this->uripWuku = 9;
			break;
		case 16: //Pahang
			$this->uripWuku = 3;
			break;
		case 17: //Krulut
			$this->uripWuku = 7;
			break;
		case 18: //Merakih
			$this->uripWuku = 1;
			break;
		case 19: //Tambir
			$this->uripWuku = 4;
			break;
		case 20: //Medangkungan
			$this->uripWuku = 6;
			break;
		case 21: //Matal
			$this->uripWuku = 5;
			break;
		case 22: //Uye
			$this->uripWuku = 8;
			break;
		case 23: //Menail
			$this->uripWuku = 9;
			break;
		case 24: //Perangbakat
			$this->uripWuku = 3;
			break;
		case 25: //Bala
			$this->uripWuku = 7;
			break;
		case 26: //Ugu
			$this->uripWuku = 1;
			break;
		case 27: //Wayang
			$this->uripWuku = 4;
			break;
		case 28: //kelawu
			$this->uripWuku = 6;
			break;
		case 29: //Dukut
			$this->uripWuku = 5;
			break;
		case 30: //Watugunung
			$this->uripWuku = 8;
			break;
		default:
			break;
		}

	}

	/*** Fungsi menghitung wewaran ***/
	public function hitungWewaran(){
		$pivot = $this->pivot;
		$tgl = $this->tgl;


		/*
		* Perhitungan saptawara hanya mengecek day of week, pada PHP (minggu-sabtu -> 0-6)
		*/
		switch ($tgl->format('w')) {
		case 0: //Redite
			$this->noSaptawara = 0;
			$this->uripSaptawara = 5;
			break;
		case 1: //Soma
			$this->noSaptawara = 1;
			$this->uripSaptawara = 4;
			break;
		case 2: //Anggara
			$this->noSaptawara = 2;
			$this->uripSaptawara = 3;
			break;
		case 3: //Buda
			$this->noSaptawara = 3;
			$this->uripSaptawara = 7;
			break;
		case 4: //Wrespati
			$this->noSaptawara = 4;
			$this->uripSaptawara = 8;
			break;
		case 5: //Sukra
			$this->noSaptawara = 5;
			$this->uripSaptawara = 6;
			break;
		case 6: //Saniscara
			$this->noSaptawara = 6;
			$this->uripSaptawara = 9;
			break;
		default:
			break;
		}


		/*
		* Perhitungan pancawara 
		* Menggunakan rumus dari babadbali.com : "Murni aritmatika, modulus 5 dari angka pawukon menghasilkan 0=Umanis, 1=Paing, 2=Pon, 3=Wage, 4=Kliwon.
		* Pada SakaCalendar menjadi : 
		* 0 + 1 = 1 Umanis
		* 1 + 1 = 2 Paing
		* 2 + 1 = 3 Pon
		* 3 + 1 = 4 Wage	
		* 4 + 1 = 5 Kliwon
		*/
		$hasil = ($this->angkaWuku % 5) + 1 ;
		$this->noPancawara = $hasil;
		// mendapatkan urip pancawara
		switch ($this->noPancawara) {
		case 1:
			$this->uripPancawara = 5;break;
		case 2:
			$this->uripPancawara = 9;break;
		case 3:
			$this->uripPancawara = 7;break;
		case 4:
			$this->uripPancawara = 4;break;
		case 5:
			$this->uripPancawara = 8;break;
		default:break;
		}


		/*
		* Perhitungan triwara
		* Menggunakan rumus dari babadbali.com : "Perhitungan triwara murni aritmatika, berdaur dari ketiganya. Angka Pawukon dibagi 3, jika sisanya (modulus) 1 adalah Pasah, 2 adalah Beteng, 0 adalah Kajeng"
		* Pada SakaCalendar menjadi : 
		* 1 Pasah
		* 2 Beteng
		* 0 -> 3 kajeng
		*/
		$hasil = $this->angkaWuku % 3;
		if ($hasil == 0){$hasil = 3;}
		$this->noTriwara=$hasil;


		/*
		* Perhitungan ekawara
		* Pada SakaCalendar : 
		* 1 Luang
		* 2 Bukan luang (kosong)
		*/
		$hasil = ($this->uripPancawara + $this->uripSaptawara) % 2;
		if ($hasil!=0){
			$this->noEkawara = 1; //Jika tidak habis dibagi 2 maka luang
		}else{
			$this->noEkawara = 0; //Jika habis dibagi 2 maka bukan luang 
		}


		/*
		* Perhitungan dwiwara
		* Pada SakaCalendar : 
		* 1 Menga
		* 2 Pepet
		*/
		$hasil = ($this->uripPancawara + $this->uripSaptawara) % 2;
		if ($hasil==0){
			$this->noDwiwara = 1; //Jika habis dibagi 2 maka menga
		}else{
			$this->noDwiwara = 2; //Jika tidak habis dibagi 2 maka pepet
		}
		

		/*
		* Perhitungan caturwara
		* Pada wuku dengan angka wuku 71,72,73 caturwara tetap jaya yang disebut dengan Jayatiga
		* Pada SakaCalendar : 
		* 1 Sri
		* 2 Laba
		* 3 Jaya
		* 0 -> Menala
		*/
		if ($this->angkaWuku == 71 || $this->angkaWuku == 72 || $this->angkaWuku == 73){	
			$hasil = 3;
		}else if ($this->angkaWuku <= 70){
			$hasil = $this->angkaWuku % 4;
		}else{
			$hasil = ($this->angkaWuku + 2) % 4;
		}
		if ($hasil == 0){$hasil = 4;}
		$this->noCaturwara = $hasil;


		/*
		* Perhitungan sadwara
		* Pada SakaCalendar : 
		* 1 Tungleh
		* 2 Aryang
		* 3 Urukung
		* 4 Paniron
		* 5 Was
		* 0 -> 6 Maulu
		*/
		$hasil = $this->angkaWuku % 6;
		if ($hasil == 0){$hasil = 6;}
		$this->noSadwara = $hasil;


		/*
		* Perhitungan astawara
		* Pada wuku dengan angka wuku 71,72,73 astawara tetap kala yang disebut dengan Kalatiga
		* Pada SakaCalendar : 
		* 1 Sri
		* 2 Indra
		* 3 Guru
		* 4 Yama
		* 5 Ludra
		* 6 Brahma
		* 7 kala
		* 0 -> 8 Uma
		*/
		if ($this->angkaWuku == 71 || $this->angkaWuku == 72 || $this->angkaWuku == 73){	
			$hasil = 7;
		}else if ($this->angkaWuku <= 70){
			$hasil = $this->angkaWuku % 8;
		}else{
			$hasil = ($this->angkaWuku + 6) % 8;
		}
		if ($hasil == 0){$hasil = 8;}
		$this->noAstawara = $hasil;


		/*
		* Perhitungan sangawara
		* Pada wuku dengan angka wuku 1-4 sangawara tetap dangu yang disebut dengan Caturdangu
		* Pada SakaCalendar : 
		* 1 Dangu
		* 2 Jangur
		* 3 Gigis
		* 4 Nohan
		* 5 Ogan
		* 6 Erangan
		* 7 Urungan
		* 8 Tulus
		* 0 -> 9 Dadi
		*/
		if ($this->angkaWuku <= 4){
			$hasil = 1 ;
		}else{
			$hasil = ($this->angkaWuku + 6) % 9;
		}
		if ($hasil == 0){$hasil = 9;}
		$this->noSangawara = $hasil;


		/*
		* Perhitungan dasawara 
		* Pada SakaCalendar menjadi : 
		* 0 + 1 = 1 Pandita
		* 1 + 1 = 2 Pati
		* 2 + 1 = 3 Suka
		* 3 + 1 = 4 Duka	
		* 4 + 1 = 5 Sri
		* 5 + 1 = 6 Manuh
		* 6 + 1 = 7 Manusa
		* 7 + 1 = 8 Raja
		* 8 + 1 = 9 Dewa
		* 9 + 1 = 10 Raksasa
		*/
		$hasil = ((($this->uripPancawara + $this->uripSaptawara) % 10)+1);
		$this->noDasawara = $hasil;

	}

	/*** Fungsi menghitung jejepan ***/
	public function hitungJejepan(){
		/*
		* Pada SakaCalendar : 
		* 1 Mina
		* 2 taru
		* 3 Sato
		* 4 Patra
		* 5 Wong
		* 0 -> 6 Paksi
		*/
		$noJejepan = $this->angkaWuku % 6;
		if ($noJejepan == 0){$noJejepan = 6;}
		return $noJejepan;
	}

	/*** Fungsi menghitung pewatekan alit ***/
	public function hitungWatekAlit(){
		
		/*
		* Pada SakaCalendar : 
		* 1 Uler
		* 2 Gajah
		* 3 Lembu
		* 0 -> 4 Lintah
		*/
		$noWatekAlit = ($this->uripPancawara + $this->uripSaptawara) % 4;
		if ($noWatekAlit == 0){$noWatekAlit = 4;}
		
		return $noWatekAlit;
	}

	/*** Fungsi menghitung pewatekan madya ***/
	public function hitungWatekMadya(){
		
		/*
		* Pada SakaCalendar : 
		* 1 Gajah
		* 2 Watu
		* 3 Buta
		* 4 Suku
		* 0 ->5 Wong
		*/
		$noWatekMadya = ($this->uripPancawara + $this->uripSaptawara) % 5;
		if ($noWatekMadya == 0){$noWatekMadya = 5;}
		
		return $noWatekMadya;
	}

	/*** Fungsi menghitung eka jala rsi ***/
	public function hitungEkaJalaRsi(){
	
		/*
		* Pada SakaCalendar : 
		* 1	Bagna mapasah
		* 2	Bahu putra
		* 3	Buat astawa
		* 4	Buat lara
		* 5	Buat merang
		* 6	Buat sebet
		* 7	Buat kingking
		* 8	Buat suka
		* 9	Dahat kingking
		* 10 Kamaranan
		* 11 Kamretaan
		* 12 Kasobagian
		* 13 Kinasihan amreta
		* 14 Kinasihan jana
		* 15 Langgeng kayohanaan
		* 16 Lewih bagia
		* 17 Manggih bagia
		* 18 Manggih suka
		* 19 Patining amreta
		* 20 Rahayu
		* 21 Sidha kasobagian
		* 22 Subagia
		* 23 Suka kapanggih
		* 24 Suka pinanggih
		* 25 Suka rahayu
		* 26 Tininggaling suka
		* 27 Wredhi putra
		* 28 Wredhi sarwa mule
		*/
		
		$noEkaJalaRsi=0;
		switch($this->noWuku){
		case 1:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 24;break;
			case 1 : $noEkaJalaRsi = 8;break;
			case 2 : $noEkaJalaRsi = 18;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 24;break;
			case 5 : $noEkaJalaRsi = 24;break;
			case 6 : $noEkaJalaRsi = 18;break;
			}
			break;
			
		case 2:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 10;break;
			case 1 : $noEkaJalaRsi = 8;break;
			case 2 : $noEkaJalaRsi = 14;break;
			case 3 : $noEkaJalaRsi = 27;break;
			case 4 : $noEkaJalaRsi = 25;break; 
			case 5 : $noEkaJalaRsi = 24;break;
			case 6 : $noEkaJalaRsi = 21;break;
			}
			break;
			
		case 3:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 14;break;
			case 1 : $noEkaJalaRsi = 8;break;
			case 2 : $noEkaJalaRsi = 14;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 20;break;
			case 5 : $noEkaJalaRsi = 6;break;
			case 6 : $noEkaJalaRsi = 3;break;
			}
			break;
			
		case 4:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 15;break;
			case 1 : $noEkaJalaRsi = 27;break;
			case 2 : $noEkaJalaRsi = 18;break;
			case 3 : $noEkaJalaRsi = 21;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 23;break;
			case 6 : $noEkaJalaRsi = 1;break;
			}
			break;
			
		case 5:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 11;break;
			case 1 : $noEkaJalaRsi = 6;break;
			case 2 : $noEkaJalaRsi = 16;break;
			case 3 : $noEkaJalaRsi = 24;break;
			case 4 : $noEkaJalaRsi = 8;break;
			case 5 : $noEkaJalaRsi = 18;break;
			case 6 : $noEkaJalaRsi = 24;break;
			}
			break;
			
			
		case 6:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 18;break;
			case 1 : $noEkaJalaRsi = 26;break;
			case 2 : $noEkaJalaRsi = 5;break;
			case 3 : $noEkaJalaRsi = 24;break;
			case 4 : $noEkaJalaRsi = 3;break;
			case 5 : $noEkaJalaRsi = 3;break;
			case 6 : $noEkaJalaRsi = 3;break;
			}
			break;
			
			
		case 7:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 13;break;
			case 1 : $noEkaJalaRsi = 13;break;
			case 2 : $noEkaJalaRsi = 5;break;
			case 3 : $noEkaJalaRsi = 15;break;
			case 4 : $noEkaJalaRsi = 13;break;
			case 5 : $noEkaJalaRsi = 27;break;
			case 6 : $noEkaJalaRsi = 27;break;
			}
			break;
			
			
		case 8:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 2;break;
			case 1 : $noEkaJalaRsi = 24;break;
			case 2 : $noEkaJalaRsi = 24;break;
			case 3 : $noEkaJalaRsi = 16;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 16;break;
			case 6 : $noEkaJalaRsi = 6;break;
			}
			break;
			
		case 9:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 10;break;
			case 1 : $noEkaJalaRsi = 26;break;
			case 2 : $noEkaJalaRsi = 19;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 12;break;
			case 5 : $noEkaJalaRsi = 16;break;
			case 6 : $noEkaJalaRsi = 22;break;
			}
			break;
		
		case 10:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 26;break;
			case 1 : $noEkaJalaRsi = 26;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 1;break;
			case 4 : $noEkaJalaRsi = 18;break;
			case 5 : $noEkaJalaRsi = 14;break;
			case 6 : $noEkaJalaRsi = 1;break;
			}
			break;
			
		case 11:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 16;break;
			case 1 : $noEkaJalaRsi = 24;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 17;break;
			case 5 : $noEkaJalaRsi = 26;break;
			case 6 : $noEkaJalaRsi = 19;break;
			}
			break;
			
		case 12:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 25;break;
			case 1 : $noEkaJalaRsi = 13;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 6;break;
			case 4 : $noEkaJalaRsi = 8;break;
			case 5 : $noEkaJalaRsi = 6;break;
			case 6 : $noEkaJalaRsi = 27;break;
			}
			break;
			
		case 13:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 8;break;
			case 1 : $noEkaJalaRsi = 6;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 3;break;
			case 6 : $noEkaJalaRsi = 13;break;
			}
			break;
			
		
		case 14:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 26;break;
			case 1 : $noEkaJalaRsi = 26;break;
			case 2 : $noEkaJalaRsi = 15;break;
			case 3 : $noEkaJalaRsi = 16;break;
			case 4 : $noEkaJalaRsi = 27;break;
			case 5 : $noEkaJalaRsi = 8;break;
			case 6 : $noEkaJalaRsi = 13;break;
			}
			break;
			
		case 15:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 21;break;
			case 1 : $noEkaJalaRsi = 8;break;
			case 2 : $noEkaJalaRsi = 6;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 6;break;
			case 6 : $noEkaJalaRsi = 14;break;
			}
			break;
			
		case 16:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 26;break;
			case 1 : $noEkaJalaRsi = 18;break;
			case 2 : $noEkaJalaRsi = 14;break;
			case 3 : $noEkaJalaRsi = 24;break;
			case 4 : $noEkaJalaRsi = 6;break;
			case 5 : $noEkaJalaRsi = 27;break;
			case 6 : $noEkaJalaRsi = 21;break;
			}
			break;
			
		case 17:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 26;break;
			case 1 : $noEkaJalaRsi = 26;break;
			case 2 : $noEkaJalaRsi = 24;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 19;break;
			case 5 : $noEkaJalaRsi = 19;break;
			case 6 : $noEkaJalaRsi = 18;break;
			}
			break;
			
		case 18:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 8;break;
			case 1 : $noEkaJalaRsi = 18;break;
			case 2 : $noEkaJalaRsi = 8;break;
			case 3 : $noEkaJalaRsi = 5;break;
			case 4 : $noEkaJalaRsi = 27;break;
			case 5 : $noEkaJalaRsi = 18;break;
			case 6 : $noEkaJalaRsi = 6;break;
			}
			break;
		
		case 19:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 10;break;
			case 1 : $noEkaJalaRsi = 13;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 14;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 19;break;
			case 6 : $noEkaJalaRsi = 19;break;
			}
			break;
			
		case 20:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 6;break;
			case 1 : $noEkaJalaRsi = 3;break;
			case 2 : $noEkaJalaRsi = 26;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 3;break;
			case 5 : $noEkaJalaRsi = 26;break;
			case 6 : $noEkaJalaRsi = 18;break;
			}
			break;
			
		case 21:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 21;break;
			case 1 : $noEkaJalaRsi = 15;break;
			case 2 : $noEkaJalaRsi = 28;break;
			case 3 : $noEkaJalaRsi = 24;break;
			case 4 : $noEkaJalaRsi = 18;break;
			case 5 : $noEkaJalaRsi = 9;break;
			case 6 : $noEkaJalaRsi = 26;break;
			}
			break;
			
		case 22:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 18;break;
			case 1 : $noEkaJalaRsi = 6;break;
			case 2 : $noEkaJalaRsi = 18;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 7;break;
			case 5 : $noEkaJalaRsi = 16;break;
			case 6 : $noEkaJalaRsi = 19;break;
			}
			break;
		
		case 23:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 26;break;
			case 1 : $noEkaJalaRsi = 3;break;
			case 2 : $noEkaJalaRsi = 8;break;
			case 3 : $noEkaJalaRsi = 14;break;
			case 4 : $noEkaJalaRsi = 26;break;
			case 5 : $noEkaJalaRsi = 21;break;
			case 6 : $noEkaJalaRsi = 8;break;
			}
			break;
			
		case 24:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 16;break;
			case 1 : $noEkaJalaRsi = 16;break;
			case 2 : $noEkaJalaRsi = 24;break;
			case 3 : $noEkaJalaRsi = 8;break;
			case 4 : $noEkaJalaRsi = 9;break;
			case 5 : $noEkaJalaRsi = 25;break;
			case 6 : $noEkaJalaRsi = 3;break;
			}
			break;
			
		case 25:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 13;break;
			case 1 : $noEkaJalaRsi = 10;break;
			case 2 : $noEkaJalaRsi = 25;break;
			case 3 : $noEkaJalaRsi = 25;break;
			case 4 : $noEkaJalaRsi = 18;break;
			case 5 : $noEkaJalaRsi = 25;break;
			case 6 : $noEkaJalaRsi = 21;break;
			}
			break;
			
		case 26:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 8;break;
			case 1 : $noEkaJalaRsi = 13;break;
			case 2 : $noEkaJalaRsi = 13;break;
			case 3 : $noEkaJalaRsi = 15;break;
			case 4 : $noEkaJalaRsi = 19;break;
			case 5 : $noEkaJalaRsi = 26;break;
			case 6 : $noEkaJalaRsi = 21;break;
			}
			break;
			
		case 27:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 5;break;
			case 1 : $noEkaJalaRsi = 19;break;
			case 2 : $noEkaJalaRsi = 5;break;
			case 3 : $noEkaJalaRsi = 21;break;
			case 4 : $noEkaJalaRsi = 27;break;
			case 5 : $noEkaJalaRsi = 13;break;
			case 6 : $noEkaJalaRsi = 24;break;
			}
			break;
			
		case 28:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 19;break;
			case 1 : $noEkaJalaRsi = 18;break;
			case 2 : $noEkaJalaRsi = 18;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 16;break;
			case 5 : $noEkaJalaRsi = 3;break;
			case 6 : $noEkaJalaRsi = 25;break;
			}
			break;
			
		case 29:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 4;break;
			case 1 : $noEkaJalaRsi = 3;break;
			case 2 : $noEkaJalaRsi = 24;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 19;break;
			case 5 : $noEkaJalaRsi = 26;break;
			case 6 : $noEkaJalaRsi = 21;break;
			}
			break;
			
		case 30:
			switch($this->noSaptawara){
			case 0 : $noEkaJalaRsi = 15;break;
			case 1 : $noEkaJalaRsi = 4;break;
			case 2 : $noEkaJalaRsi = 3;break;
			case 3 : $noEkaJalaRsi = 26;break;
			case 4 : $noEkaJalaRsi = 8;break;
			case 5 : $noEkaJalaRsi = 26;break;
			case 6 : $noEkaJalaRsi = 18;break;
			}
			break;
		}
		
		return $noEkaJalaRsi;
	}

	/*** Fungsi menghitung palalintangan ***/
	public function hitungLintang(){
		
		/*
		* Pada SakaCalendar : 
		* 1 Gajah
		* 2 Kiriman
		* 3 Jong Sarat
		* 4 Atiwa-tiwa
		* 5 Sangka Tikel
		* 6 Bubu Bolong
		* 7 Sugenge
		* 8 Uluku/Tenggala
		* 9 Pedati
		* 10 Kuda
		* 11 Gajah Mina
		* 12 Bade
		* 13 Magelut
		* 14 Pagelangan
		* 15 Kala Sungsang
		* 16 Kukus
		* 17 Asu
		* 18 Kartika
		* 19 Naga
		* 20 Banak Angerem
		* 21 Hru/Panah
		* 22 Patrem
		* 23 Lembu
		* 24 Depat/Sidamalung
		* 25 Tangis
		* 26 Salah Ukur
		* 27 Perahu Pegat
		* 28 Puwuh Atarung
		* 29 Lawean/Goang
		* 30 Kelapa
		* 31 Yuyu
		* 32 Lumbung
		* 33 Kumbha
		* 34 Udang
		* 35 Begoong
		*/
		
		$noLintang=0;
		switch($this->noSaptawara){
		case 0:
			switch($this->noPancawara){
			case 1 : $noLintang = 15;break;
			case 2 : $noLintang = 1;break;
			case 3 : $noLintang = 22;break;
			case 4 : $noLintang = 8;break;
			case 5 : $noLintang = 29;break;
			}
			break;
		case 1:
			switch($this->noPancawara){
			case 1 : $noLintang = 30;break;
			case 2 : $noLintang = 16;break;
			case 3 : $noLintang = 2;break;
			case 4 : $noLintang = 23;break;
			case 5 : $noLintang = 9;break;
			}
			break;
		case 2:
			switch($this->noPancawara){
			case 1 : $noLintang = 10;break;
			case 2 : $noLintang = 31;break;
			case 3 : $noLintang = 17;break;
			case 4 : $noLintang = 23;break;
			case 5 : $noLintang = 24;break;
			}
			break;
		case 3:
			switch($this->noPancawara){
			case 1 : $noLintang = 25;break;
			case 2 : $noLintang = 11;break;
			case 3 : $noLintang = 32;break;
			case 4 : $noLintang = 18;break;
			case 5 : $noLintang = 4;break;
			}
			break;
		case 4:
			switch($this->noPancawara){
			case 1 : $noLintang = 5;break;
			case 2 : $noLintang = 26;break;
			case 3 : $noLintang = 12;break;
			case 4 : $noLintang = 33;break;
			case 5 : $noLintang = 19;break;
			}
			break;
		case 5:
			switch($this->noPancawara){
			case 1 : $noLintang = 20;break;
			case 2 : $noLintang = 6;break;
			case 3 : $noLintang = 27;break;
			case 4 : $noLintang = 13;break;
			case 5 : $noLintang = 34;break;
			}
			break;
		case 6:
			switch($this->noPancawara){
			case 1 : $noLintang = 35;break;
			case 2 : $noLintang = 21;break;
			case 3 : $noLintang = 7;break;
			case 4 : $noLintang = 28;break;
			case 5 : $noLintang = 15;break;
			}
			break;
		}
		return $noLintang;
	
	}

	/*** Fungsi menghitung panca sudha ***/
	public function hitungPancasudha(){
	
		/*
		* Pada SakaCalendar : 
		* 1 Wisesa segara
		* 2 Tunggak semi
		* 3 Satria wibhawa
		* 4 Sumur sinaba
		* 5 Bumi kapetak
		* 6 Satria wirang
		* 7 Lebu katiup angin
		*/
		
		$noPancasudha = 0;
		if ($this->noSaptawara==0 && $this->noPancawara==2 || $this->noSaptawara==3 && $this->noPancawara==2 || $this->noSaptawara==1 && $this->noPancawara==4 || $this->noSaptawara==5 && $this->noPancawara==5 || $this->noSaptawara==2 && $this->noPancawara==1 ||$this->noSaptawara==6 && $this->noPancawara==3){
			$noPancasudha = 1;
		} else if ($this->noSaptawara==1 && $this->noPancawara==1 || $this->noSaptawara==4 && $this->noPancawara==4 || $this->noSaptawara==5 && $this->noPancawara==2 || $this->noSaptawara==6 && $this->noPancawara==5){ 
			$noPancasudha = 2;
		} else if ($this->noSaptawara==0 && $this->noPancawara==4 || $this->noSaptawara==2 && $this->noPancawara==3 || $this->noSaptawara==3 && $this->noPancawara==4 || $this->noSaptawara==4 && $this->noPancawara==1 || $this->noSaptawara==6 && $this->noPancawara==2){
			$noPancasudha = 3;
		} else if ($this->noSaptawara==0 && $this->noPancawara==1 || $this->noSaptawara==1 && $this->noPancawara==3 || $this->noSaptawara==2 && $this->noPancawara==5 || $this->noSaptawara==3 && $this->noPancawara==1 || $this->noSaptawara==5 && $this->noPancawara==4){
			$noPancasudha = 4;
		} else if ($this->noSaptawara==0 && $this->noPancawara==3 || $this->noSaptawara==1 && $this->noPancawara==2 || $this->noSaptawara==3 && $this->noPancawara==3 || $this->noSaptawara==4 && $this->noPancawara==5 || $this->noSaptawara==6 && $this->noPancawara==1){
			$noPancasudha = 5;
		} else if ($this->noSaptawara==1 && $this->noPancawara==5 || $this->noSaptawara==2 && $this->noPancawara==2 || $this->noSaptawara==4 && $this->noPancawara==3 || $this->noSaptawara==5 && $this->noPancawara==1 || $this->noSaptawara==6 && $this->noPancawara==4){
			$noPancasudha = 6;
		} else if ($this->noSaptawara==0 && $this->noPancawara==5 || $this->noSaptawara==2 && $this->noPancawara==4 || $this->noSaptawara==3 && $this->noPancawara==5 || $this->noSaptawara==4 && $this->noPancawara==2 || $this->noSaptawara==5 && $this->noPancawara==3){
			$noPancasudha = 7;
		}
		return $noPancasudha;
	}

	/*** Fungsi menghitung pararasan ***/
	public function hitungPararasan(){
	
		/*
		* Pada SakaCalendar : 
		* 1 Laku bumi
		* 2 Laku api
		* 3 Laku angin
		* 4 Laku pandita sakti
		* 5 Aras tuding
		* 6 Aras kembang
		* 7 Laku bintang
		* 8 Laku bulan
		* 9 Laku surya
		* 10 Laku air/toya
		* 11 Laku pretiwi
		* 12 Laku agni agung
		*/
		
		$noPararasan = 0;
		if ($this->noSaptawara==2 && $this->noPancawara==4){
			$noPararasan = 1;
		} else if ($this->noSaptawara==1 && $this->noPancawara==4 || $this->noSaptawara==2 && $this->noPancawara==1){
			$noPararasan = 2;
		} else if ($this->noSaptawara==0 && $this->noPancawara==4 || $this->noSaptawara==1 && $this->noPancawara==1){
			$noPararasan = 3;
		} else if ($this->noSaptawara==0 && $this->noPancawara==1 || $this->noSaptawara==2 && $this->noPancawara==3 || $this->noSaptawara==5 && $this->noPancawara==4){
			$noPararasan = 4;
		} else if ($this->noSaptawara==1 && $this->noPancawara==3 || $this->noSaptawara==2 && $this->noPancawara==5 || $this->noSaptawara==3 && $this->noPancawara==4 || $this->noSaptawara==5 && $this->noPancawara==1){
			$noPararasan = 5;
		} else if ($this->noSaptawara==0 && $this->noPancawara==3 || $this->noSaptawara==2 && $this->noPancawara==2 || $this->noSaptawara==1 && $this->noPancawara==5 || $this->noSaptawara==3 && $this->noPancawara==1 || $this->noSaptawara==4 && $this->noPancawara==4){
			$noPararasan = 6;
		} else if ($this->noSaptawara==0 && $this->noPancawara==5 || $this->noSaptawara==1 && $this->noPancawara==2 || $this->noSaptawara==4 && $this->noPancawara==1 || $this->noSaptawara==5 && $this->noPancawara==3 || $this->noSaptawara==6 && $this->noPancawara==4){
			$noPararasan = 7;
		} else if ($this->noSaptawara==0 && $this->noPancawara==2 || $this->noSaptawara==3 && $this->noPancawara==3 || $this->noSaptawara==5 && $this->noPancawara==5 || $this->noSaptawara==6 && $this->noPancawara==1){
			$noPararasan = 8;
		} else if ($this->noSaptawara==3 && $this->noPancawara==5 || $this->noSaptawara==4 && $this->noPancawara==3 || $this->noSaptawara==5 && $this->noPancawara==2){
			$noPararasan = 9;
		} else if ($this->noSaptawara==3 && $this->noPancawara==2 || $this->noSaptawara==4 && $this->noPancawara==5 || $this->noSaptawara==6 && $this->noPancawara==3){
			$noPararasan = 10;
		} else if ($this->noSaptawara==4 && $this->noPancawara==2 || $this->noSaptawara==6 && $this->noPancawara==5){
			$noPararasan = 11;
		} else if ($this->noSaptawara==6 && $this->noPancawara==2){
			$noPararasan = 12;
		}
		return $noPararasan;
	}

	/*** Fungsi menghitung rakam ***/
	public function hitungRakam(){
		
		/*
		* Menggunakan rumus dari babadbali.com : "Dari hari Sukra diberi angka urut 1 sampai Wrespati - kemudian dari Kliwon juga diberi angka urut sampai Wage. Angka urutan itu dibagi dengan 6, sisanya mencerminkan sifat pimpinan yang akan dinobatkan nanti."
		* Pada SakaCalendar menjadi : 
		* 1 Kala tinatang
		* 2 Demang kandhuruwan
		* 3 Sanggar waringin
		* 4 Mantri sinaroja
		* 5 Macam katawan
		* 0 -> 6 Nuju pati
		*/
		
		$noRakam = 0;
		$saptawara = 0;
		$pancawara = 0;
		
		switch ($this->noSaptawara){
		case 0:$saptawara = 3;break;
		case 1:$saptawara = 4;break;
		case 2:$saptawara = 5;break;
		case 3:$saptawara = 6;break;
		case 4:$saptawara = 7;break;
		case 5:$saptawara = 1;break;
		case 6:$saptawara = 2;break;
		}
		
		switch ($this->noPancawara){
		case 1:$pancawara = 2;break;
		case 2:$pancawara = 3;break;
		case 3:$pancawara = 4;break;
		case 4:$pancawara = 5;break;
		case 5:$pancawara = 1;break;
		}
		
		$noRakam = ($pancawara + $saptawara) % 6;
		if ($noRakam == 0){$noRakam = 6;}
		
		return $noRakam;
	}

	/*** Fungsi menghitung zodiak ***/
	public function hitungZodiak(){
	
		/*
		* Pada SakaCalendar : 
		* 1 Aries
		* 2 Taurus
		* 3 Gemini
		* 4 Cancer
		* 5 Leo
		* 6 Virgo
		* 7 Libra
		* 8 Scorpio
		* 9 Sagitarius
		* 10 Capricon
		* 11 Aquarius
		* 12 Pisces
		*/
		
		
		$noZodiak = 0;
		$M = $this->format('n');
        $D = $this->format('j');
        
		if (($M == 12 && $D >= 22 && $D <= 31) || ($M ==  1 && $D >= 1 && $D <= 19))
        	$noZodiak = 10;
        else if (($M ==  1 && $D >= 20 && $D <= 31) || ($M ==  2 && $D >= 1 && $D <= 17))
        	$noZodiak = 11;
        else if (($M ==  2 && $D >= 18 && $D <= 29) || ($M ==  3 && $D >= 1 && $D <= 19))
        	$noZodiak = 12;
        else if (($M ==  3 && $D >= 20 && $D <= 31) || ($M ==  4 && $D >= 1 && $D <= 19))
        	$noZodiak = 1;
        else if (($M ==  4 && $D >= 20 && $D <= 30) || ($M ==  5 && $D >= 1 && $D <= 20))
        	$noZodiak = 2;
        else if (($M ==  5 && $D >= 21 && $D <= 31) || ($M ==  6 && $D >= 1 && $D <= 20))
        	$noZodiak = 3;
        else if (($M ==  6 && $D >= 21 && $D <= 30) || ($M ==  7 && $D >= 1 && $D <= 22))
        	$noZodiak = 4;
        else if (($M ==  7 && $D >= 23 && $D <= 31) || ($M ==  8 && $D >= 1 && $D <= 22))
        	$noZodiak = 5;
        else if (($M ==  8 && $D >= 23 && $D <= 31) || ($M ==  9 && $D >= 1 && $D <= 22))
        	$noZodiak = 6;
        else if (($M ==  9 && $D >= 23 && $D <= 30) || ($M == 10 && $D >= 1 && $D <= 22))
        	$noZodiak = 7;
        else if (($M == 10 && $D >= 23 && $D <= 31) || ($M == 11 && $D >= 1 && $D <= 21))
        	$noZodiak = 8;
        else if (($M == 11 && $D >= 22 && $D <= 30) || ($M == 12 && $D >= 1 && $D <= 21))
        	$noZodiak = 9;
        
		return $noZodiak;
	}

	/*** Fungsi menghitung kalender saka ***/
	public function hitungSaka(){
		
		$pivot = $this->pivot;
		$tgl = $this->tgl;
		$bedaHari = $this->getDateDiff($pivot['date'],$tgl);		

		/*** MENGHITUNG PENANGGAL PANGELONG ***/
		$hasilNgunaratri=0;
		$jumlahNgunaratri = 0;
		$mulai=0;

		if ($bedaHari >= 0){
		
			//mengetahui jumlah ngunaratri
			
			if ($pivot['noNgunaratri'] > 63){
				if ($pivot['noNgunaratri'] % 63 == 0){
					$mulai = $pivot['noNgunaratri']-63;
				} else {
					$mulai = $pivot['noNgunaratri'] - ($pivot['noNgunaratri'] % 63);
				}
			}
			
			$this->noNgunaratri = $pivot['noNgunaratri'] + $bedaHari; //Masukkan no ngunaratri
			
			if ($this->noNgunaratri > ($mulai + 63)){
				$jumlahNgunaratri = (($this->noNgunaratri - ($mulai + 63))/63) + 1;
				if (($this->noNgunaratri - ($mulai + 63))%63==0){$jumlahNgunaratri--;}
			}
			
			
			if ($pivot['isNgunaratri']){$jumlahNgunaratri++;} //Jika pivot adalah ngunaratri, tambah jumlah ngunaratri
			// Menghitung angka penanggal/pangelong, jika 0 maka diubah ke 15
			$hasilNgunaratri = ($bedaHari + $pivot['penanggal'] + $jumlahNgunaratri) % 15;
			if ($hasilNgunaratri == 0) { $hasilNgunaratri =15; }
			$this->penanggal=$hasilNgunaratri;
			// Menghitung apakah penanggal atau pangelong
			$this->isPangelong = (((($bedaHari + $pivot['penanggal'] + $jumlahNgunaratri - 1) / 15) % 2) == 0) ? $pivot['isPangelong'] : !$pivot['isPangelong'] ;
			
		}else{ // Jika tanggal yang dihitung sebelum tanggal pivot
		
			//mengetahui jumlah ngunaratri
			if (($pivot['noNgunaratri']+63) > 63){
				if (($pivot['noNgunaratri']+63) % 63 == 0){
					$mulai = ($pivot['noNgunaratri']+63)-63;
				} else {
					$mulai = ($pivot['noNgunaratri']+63) - (($pivot['noNgunaratri']+63) % 63);
				}
			}
			
			$this->noNgunaratri = $pivot['noNgunaratri'] + $bedaHari; //Masukkan no ngunaratri
			
			if ($this->noNgunaratri < ($mulai - 63)){
				$jumlahNgunaratri = ((-($this->noNgunaratri - ($mulai - 63)))/63) + 1;
				if ((-($this->noNgunaratri - ($mulai - 63)))%63==0){$jumlahNgunaratri--;}
			}
			
			// Menghitung angka penanggal/pangelong, jika 0 maka diubah ke 15
			$hasilNgunaratri = $bedaHari + $pivot['penanggal'] - $jumlahNgunaratri;
			
			$hasilNgunaratri = 15 - (-$hasilNgunaratri%15) ;
			
			$this->penanggal=$hasilNgunaratri;
			// Menghitung apakah penanggal atau pangelong
			$this->isPangelong = ((((-$bedaHari + $this->penanggal + $jumlahNgunaratri - 1) / 15) % 2) == 0) ? $pivot['isPangelong'] : !$pivot['isPangelong'] ;
		}


		/*** MENENTUKAN APAKAH NGUNARATRI ATAU TIDAK ***/
		$this->isNgunaratri = false;
		if ($tgl->format('Y')  > 1999 ){
			// Pengalantaka Eka Sungsang ke Pahing
			if ($this->noSaptawara == 2){
				
				if ($bedaHari > 0){
				
					if (($this->noWuku==10 && $this->noPancawara==2 && ($this->penanggal==14||$this->penanggal==9||$this->penanggal==4)) || 
						($this->noWuku==19 && $this->noPancawara==5 && ($this->penanggal==3||$this->penanggal==13||$this->penanggal==8)) || 
						($this->noWuku==28 && $this->noPancawara==3 && ($this->penanggal==7||$this->penanggal==2||$this->penanggal==12)) || 
						($this->noWuku==7 && $this->noPancawara==1  && ($this->penanggal==11||$this->penanggal==6||$this->penanggal==1)) || 
						($this->noWuku==16 && $this->noPancawara==4 && ($this->penanggal==15||$this->penanggal==10||$this->penanggal==5)) || 
						($this->noWuku==25 && $this->noPancawara==2 && ($this->penanggal==4||$this->penanggal==14||$this->penanggal==9))  || 
						($this->noWuku==4 && $this->noPancawara==5  && ($this->penanggal==8||$this->penanggal==3||$this->penanggal==13)) || 
						($this->noWuku==13 && $this->noPancawara==3 && ($this->penanggal==12||$this->penanggal==7||$this->penanggal==2)) || 
						($this->noWuku==22 && $this->noPancawara==1 && ($this->penanggal==1||$this->penanggal==11||$this->penanggal==6)) || 
						($this->noWuku==1 && $this->noPancawara==4  && ($this->penanggal==5||$this->penanggal==15||$this->penanggal==10))){
								
						$this->isNgunaratri = true;

					}
				}else{
					if (($this->noWuku==10 && $this->noPancawara==2 && ($this->penanggal==15||$this->penanggal==10||$this->penanggal==5)) || 
						($this->noWuku==19 && $this->noPancawara==5 && ($this->penanggal==4||$this->penanggal==14||$this->penanggal==9)) || 
						($this->noWuku==28 && $this->noPancawara==3 && ($this->penanggal==8||$this->penanggal==3||$this->penanggal==13)) || 
						($this->noWuku==7 && $this->noPancawara==1  && ($this->penanggal==12||$this->penanggal==7||$this->penanggal==2)) || 
						($this->noWuku==16 && $this->noPancawara==4 && ($this->penanggal==1||$this->penanggal==11||$this->penanggal==6)) || 
						($this->noWuku==25 && $this->noPancawara==2 && ($this->penanggal==5||$this->penanggal==15||$this->penanggal==10))  || 
						($this->noWuku==4 && $this->noPancawara==5  && ($this->penanggal==9||$this->penanggal==4||$this->penanggal==14)) || 
						($this->noWuku==13 && $this->noPancawara==3 && ($this->penanggal==13||$this->penanggal==8||$this->penanggal==3)) || 
						($this->noWuku==22 && $this->noPancawara==1 && ($this->penanggal==2||$this->penanggal==12||$this->penanggal==7)) || 
						($this->noWuku==1 && $this->noPancawara==4  && ($this->penanggal==6||$this->penanggal==1||$this->penanggal==11))){
								
						$this->isNgunaratri = true;
						$this->penanggal = $this->penanggal -1; //Jika ngunaratri mundur satu hari
						if ($this->penanggal == 0 && $this->isPangelong == false) {$this->isPangelong = true;} // Ubah pangelong menjadi true apabila mundur dari penanggal 1
						if ($this->penanggal == 0) {$this->penanggal = 15;} //Ubah penanggal jadi 15 jika pengurangan akibat ngunaratri menjadi 0
					}
				}
			}
		}else{
			// Pengalantaka Eka Sungsang ke Pon
			if ($this->noSaptawara == 3){
				if ($bedaHari > 0){
				
					if (($this->noWuku==10 && $this->noPancawara==3 && ($this->penanggal==14||$this->penanggal==9||$this->penanggal==4)) || 
						($this->noWuku==19 && $this->noPancawara==1 && ($this->penanggal==3||$this->penanggal==13||$this->penanggal==8)) || 
						($this->noWuku==28 && $this->noPancawara==4 && ($this->penanggal==7||$this->penanggal==2||$this->penanggal==12)) || 
						($this->noWuku==7 && $this->noPancawara==2  && ($this->penanggal==11||$this->penanggal==6||$this->penanggal==1)) || 
						($this->noWuku==16 && $this->noPancawara==5 && ($this->penanggal==15||$this->penanggal==10||$this->penanggal==5)) || 
						($this->noWuku==25 && $this->noPancawara==3 && ($this->penanggal==4||$this->penanggal==14||$this->penanggal==9))  || 
						($this->noWuku==4 && $this->noPancawara==1  && ($this->penanggal==8||$this->penanggal==3||$this->penanggal==13)) || 
						($this->noWuku==13 && $this->noPancawara==4 && ($this->penanggal==12||$this->penanggal==7||$this->penanggal==2)) || 
						($this->noWuku==22 && $this->noPancawara==2 && ($this->penanggal==1||$this->penanggal==11||$this->penanggal==6)) || 
						($this->noWuku==1 && $this->noPancawara==5  && ($this->penanggal==5||$this->penanggal==15||$this->penanggal==10))){
								
						$this->isNgunaratri = true;

					}
				}else{
					if (($this->noWuku==10 && $this->noPancawara==3 && ($this->penanggal==15||$this->penanggal==10||$this->penanggal==5)) || 
						($this->noWuku==19 && $this->noPancawara==1 && ($this->penanggal==4||$this->penanggal==14||$this->penanggal==9)) || 
						($this->noWuku==28 && $this->noPancawara==4 && ($this->penanggal==8||$this->penanggal==3||$this->penanggal==13)) || 
						($this->noWuku==7 && $this->noPancawara==2  && ($this->penanggal==12||$this->penanggal==7||$this->penanggal==2)) || 
						($this->noWuku==16 && $this->noPancawara==5 && ($this->penanggal==1||$this->penanggal==11||$this->penanggal==6)) || 
						($this->noWuku==25 && $this->noPancawara==3 && ($this->penanggal==5||$this->penanggal==15||$this->penanggal==10))  || 
						($this->noWuku==4 && $this->noPancawara==1  && ($this->penanggal==9||$this->penanggal==4||$this->penanggal==14)) || 
						($this->noWuku==13 && $this->noPancawara==4 && ($this->penanggal==13||$this->penanggal==8||$this->penanggal==3)) || 
						($this->noWuku==22 && $this->noPancawara==2 && ($this->penanggal==2||$this->penanggal==12||$this->penanggal==7)) || 
						($this->noWuku==1 && $this->noPancawara==5  && ($this->penanggal==6||$this->penanggal==1||$this->penanggal==11))){
								
						$this->isNgunaratri = true;
						$this->penanggal = $this->penanggal -1; //Jika ngunaratri mundur satu hari
						if ($this->penanggal == 0 && $this->isPangelong == false) {$this->isPangelong = true;} // Ubah pangelong menjadi true apabila mundur dari penanggal 1
						if ($this->penanggal == 0) {$this->penanggal = 15;} //Ubah penanggal jadi 15 jika pengurangan akibat ngunaratri menjadi 0
					}
				}
			}
		}

		/*** MENGHITUNG SASIH ***/
		/*
		* Pada SakaCalendar : 
		* 1 Kasa
		* 2 Karo
		* 3 Katiga
		* 4 Kapat
		* 5 Kalima
		* 6 Kanem
		* 7 Kapitu
		* 8 Kawolu
		* 9 Kasanga
		* 10 Kadasa
		* 11 Destha
		* 12 Sadha
		*/
		
		$hasilSasih =0;
		$jumlahNampih = 0;
		
		$tahunSaka = $pivot['tahunSaka'];
		$perulangan1 = 0;
		$perulangan2 = $pivot['noSasih'];
		$isNampih=false;
		
		if ($tgl->format('Y') > 2002 || $tgl->format('Y') < 1992 ){
			// Sistem nampih sasih
			if ($bedaHari >= 0){
			
				if ($pivot['isPangelong']){
					$bedaHari = $bedaHari + 15 + ($pivot['penanggal'] - 1);
					$hasilSasih = ($bedaHari + $jumlahNgunaratri ) / 30 ;	
				}else{
					$bedaHari = $bedaHari + ($pivot['penanggal'] - 1);
					$hasilSasih = ($bedaHari + $jumlahNgunaratri ) / 30 ;	
				}
				
				// menghitung tahun saka dan jumlah nampih sasih
				while ($perulangan1 < $hasilSasih){				
					$perulangan1++;
					$perulangan2++;
					$perulangan2 = $perulangan2 % 12;
					if ($perulangan2 == 0) { $perulangan2 = 12;}
					
					
					if ($perulangan2 == 10){
						$tahunSaka++;
					}
					
					if ($isNampih) {
						$isNampih = false;
					}else{
						if ((($tahunSaka % 19) == 0)||(($tahunSaka % 19) == 6)||(($tahunSaka % 19) == 11)){
								$this->isNampih = ($perulangan2==12) ? true : false;
								if ($perulangan2==1){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 3)||(($tahunSaka % 19) == 8)||(($tahunSaka % 19) == 14)||(($tahunSaka % 19) == 16)) {
								$this->isNampih = ($perulangan2==1) ? true : false;
								if ($perulangan2==2){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}
					}				
				}
				
				$this->noSasih = ($hasilSasih - $jumlahNampih + $pivot['noSasih'])%12  ;
				if ($this->isNampih){$this->noSasih--;}
				
				if ($this->noSasih < 0){
					$this->noSasih = 12 - (-$this->noSasih%12);
				}
				if ($this->noSasih == 0 ){$this->noSasih = 12;}
				
				$this->tahunSaka = $tahunSaka;
			
			}else{ //Mundur
				
				if ($pivot['isPangelong']){
					$bedaHari = $bedaHari - (15 - $pivot['penanggal']);
					$hasilSasih = -($bedaHari - $jumlahNgunaratri ) / 30 ;	
				}else{
					$bedaHari = $bedaHari - 15 - (15 - $pivot['penanggal']);
					$hasilSasih = -($bedaHari - $jumlahNgunaratri ) / 30 ;	
				}
				
				
				
				while ($perulangan1 < $hasilSasih){				
					$perulangan1++;
					$perulangan2--;
					$perulangan2 = $perulangan2 % 12;
					if ($perulangan2 == 0) { $perulangan2 = 12;}
					
					
					if ($perulangan2 == 9){
						$tahunSaka--;
					}
					
					if ($isNampih) {
						$isNampih = false;
					}else{
						if ((($tahunSaka % 19) == 0)||(($tahunSaka % 19) == 6)||(($tahunSaka % 19) == 11)){
								$this->isNampih = ($perulangan2==11) ? true : false;
								if ($perulangan2==10){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 3)||(($tahunSaka % 19) == 8)||(($tahunSaka % 19) == 14)||(($tahunSaka % 19) == 16)) {
								$this->isNampih = ($perulangan2==12) ? true : false;
								if ($perulangan2==11){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}
					}				
				}
				
				$this->noSasih = $pivot['noSasih'] - $hasilSasih + $jumlahNampih;
				
				if ($this->noSasih < 0){
					$this->noSasih = 12 - (-$this->noSasih%12);
				}
				if ($this->noSasih == 0 ){$this->noSasih = 12;}
				
				$this->tahunSaka = $tahunSaka;
				if ($this->isPangelong && $this->penanggal == 15 && $this->isNgunaratri && $this->isNampih){$this->isNampih = false;} // Ubah isnampih menjadi false apabila berada di ngunaratri di awal penanggal
			}
		}else{
			// Nampih Sasih berkesinambungan
			if ($bedaHari >= 0){
			
				if ($pivot['isPangelong']){
					$bedaHari = $bedaHari + 15 + ($pivot['penanggal'] - 1);
					$hasilSasih = ($bedaHari + $jumlahNgunaratri ) / 30 ;	
				}else{
					$bedaHari = $bedaHari + ($pivot['penanggal'] - 1);
					$hasilSasih = ($bedaHari + $jumlahNgunaratri ) / 30 ;	
				}
				
				// menghitung tahun saka dan jumlah nampih sasih
				while ($perulangan1 < $hasilSasih){				
					$perulangan1++;
					$perulangan2++;
					$perulangan2 = $perulangan2 % 12;
					if ($perulangan2 == 0) { $perulangan2 = 12;}
					
					
					if ($perulangan2 == 10){
						$tahunSaka++;
					}
					
					if ($isNampih) {
						$isNampih = false;
					}else{
						if ((($tahunSaka % 19) == 2)||(($tahunSaka % 19) == 10)){
								$this->isNampih = ($perulangan2==12) ? true : false;
								if ($perulangan2==1){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 4)) {
								$this->isNampih = ($perulangan2==4) ? true : false;
								if ($perulangan2==5){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 7)) {
								$this->isNampih = ($perulangan2==2) ? true : false;
								if ($perulangan2==3){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 13)) {
								$this->isNampih = ($perulangan2==11) ? true : false;
								if ($perulangan2==12){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 15)) {
								$this->isNampih = ($perulangan2==3) ? true : false;
								if ($perulangan2==4){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 18)) {
								$this->isNampih = ($perulangan2==1) ? true : false;
								if ($perulangan2==2){$perulangan2--;$jumlahNampih++;$isNampih=true;}
						}
					}				
				}
				
				$this->noSasih = ($hasilSasih - $jumlahNampih + $pivot['noSasih'])%12  ;
				if ($this->isNampih){$this->noSasih--;}
				
				if ($this->noSasih < 0){
					$this->noSasih = 12 - (-$this->noSasih%12);
				}
				if ($this->noSasih == 0 ){$this->noSasih = 12;}
				
				$this->tahunSaka = $tahunSaka;
			
			}else{ //Mundur
				
				
				if ($pivot['isPangelong']){
					$bedaHari = $bedaHari - (15 - $pivot['penanggal']);
					$hasilSasih = -($bedaHari - $jumlahNgunaratri ) / 30 ;	
				}else{
					$bedaHari = $bedaHari - 15 - (15 - $pivot['penanggal']);
					$hasilSasih = -($bedaHari - $jumlahNgunaratri ) / 30 ;	
				}
				
				
				
				while ($perulangan1 < $hasilSasih){				
					$perulangan1++;
					$perulangan2--;
					$perulangan2 = $perulangan2 % 12;
					if ($perulangan2 == 0) { $perulangan2 = 12;}
										
					if ($perulangan2 == 9){
						$tahunSaka--;
					}
					
					if ($isNampih) {
						$isNampih = false;
					}else{
						if ((($tahunSaka % 19) == 2)||(($tahunSaka % 19) == 10)){
								$this->isNampih = ($perulangan2==11) ? true : false;
								if ($perulangan2==10){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 4)) {
								$this->isNampih = ($perulangan2==3) ? true : false;
								if ($perulangan2==2){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 7)) {
								$this->isNampih = ($perulangan2==1) ? true : false;
								if ($perulangan2==12){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 13)) {
								$this->isNampih = ($perulangan2==10) ? true : false;
								if ($perulangan2==9){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 15)) {
								$this->isNampih = ($perulangan2==2) ? true : false;
								if ($perulangan2==1){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}else if ((($tahunSaka % 19) == 18)) {
								$this->isNampih = ($perulangan2==12) ? true : false;
								if ($perulangan2==11){$perulangan2++;$jumlahNampih++;$isNampih=true;}
						}
					}				
				}
				
				$this->noSasih = $pivot['noSasih'] - $hasilSasih + $jumlahNampih;
				
				if ($this->noSasih < 0){
					$this->noSasih = 12 - (-$this->noSasih%12);
				}
				if ($this->noSasih == 0 ){$this->noSasih = 12;}
				
				
				$this->tahunSaka = $tahunSaka;
				if ($this->isPangelong && $this->penanggal == 15 && $this->isNgunaratri && $this->isNampih){$this->isNampih = false;} // Ubah is nampih menjadi false apabila berada di ngunaratri di awal penanggal
			}
		}	


		/*----------*/
	}


}
?>
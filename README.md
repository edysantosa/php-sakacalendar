#php-sakacalendar 0.1

Copyright (c) 2012 - 2015 Edy Santosa Putra

php-sakacalendar is licensed under the GNU General Public License, version 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)

php-sakacalendar adalah php class untuk melakukan perhitungan sistem penanggalan Saka.
class ini dapat melakukan perhitungan penanggalan Saka antara lain :
- Pawukon
- Wewaran
- Tanggalan-Pangelong
- Sasih
- Ingkel
- Ingkel Jejepan
- Watek Catur/Watek Panca
- Pararasan
- Panca Sudha
- Eka Jala Rsi
- Palalintangan



## Penggunaan Dasar

Setelah menginclude sakacalendar.php inisialisasi instance SakaCalendar dengan parameter tanggal yang diinginkan dengan format 'Y-m-d'

```php
$tanggal = new SakaCalendar('2015-05-26');
```
apabila tidak diberikan parameter, maka instance yang dibuat adalah tanggal pada hari ini.



Hasil yang didapat setelah membuat sebuah instance antara lain:

### Wuku

Informasi tentang wuku terdapat pada variabel:

- $noWuku
- $uripWuku

Variabel $noWuku berurutan dari 1-30 adalah wuku Sinta - Watugunung, sedangkan variabel $uripWuku adalah urip dari wuku yang bersangkutan.
 

###  Wewaran

Informasi tentang wewaran terdapat pada variabel:

- $uripPancawara
- $uripSaptawara
- $noEkawara
- $noDwiwara
- $noTriwara
- $noCaturwara
- $noPancawara
- $noSadwara
- $noSaptawara
- $noAstawara
- $noSangawara
- $noDasawara


Variabel $uripPancawara & $uripSaptawara berisikan urip dari wara yang bersangkutan, sedangkan variabel dari $noEkawara - $noDasawara berisikan informasi sebagai berikut (nilai variabel = nama wara):

#### Ekawara

- 1 = Pasah
- 2 = Beteng
- 3 = kajeng

#### Dwiwara

- 1 = Luang
- 2 = Bukan luang (kosong)

#### Triwara

- 1 = Menga
- 2 = Pepet

#### Caturwara

- 1 = Sri
- 2 = Laba
- 3 = Jaya
- 4 = Menala


#### Pancawara

- 1 = Umanis
- 2 = Paing
- 3 = Pon
- 4 = Wage	
- 5 = Kliwon

#### Sadwara

- 1 = Tungleh
- 2 = Aryang
- 3 = Urukung
- 4 = Paniron
- 5 = Was
- 6 = Maulu

#### Saptawara

- 0 = Redite
- 1 = Soma
- 2 = Anggara
- 3 = Buda
- 4 = Wraspati
- 5 = Sukra
- 6 = Saniscara

#### Astawara

- 1 = Sri
- 2 = Indra
- 3 = Guru
- 4 = Yama
- 5 = Ludra
- 6 = Brahma
- 7 = kala
- 8 = Uma

#### Sangawara

- 1 = Dangu
- 2 = Jangur
- 3 = Gigis
- 4 = Nohan
- 5 = Ogan
- 6 = Erangan
- 7 = Urungan
- 8 = Tulus
- 9 = Dadi

#### Dasawara

- 1 = Pandita
- 2 = Pati
- 3 = Suka
- 4 = Duka	
- 5 = Sri
- 6 = Manuh
- 7 = Manusa
- 8 = Raja
- 9 = Dewa
- 10 =  Raksasa



### Penanggalan Saka

Informasi tentang penanggalan Saka terdapat pada variabel:

- $tahunSaka
- $noSasih
- $penanggal
- $isPangelong
- $isNgunaratri
- $isNampih


Variabel $tahunSaka berisikan nilai dari tahun saka pada saat itu, variabel $noSasih memberikan nilai yang merepresentasikan sasih dengan (nilai variabel = nama sasih):

- 1 = Kasa
- 2 = Karo
- 3 = Katiga
- 4 = Kapat
- 5 = Kalima
- 6 = Kanem
- 7 = Kapitu
- 8 = Kawolu
- 9 = Kasanga
- 10 = Kadasa
- 11 = Destha/jiyestha
- 12 = Sadha

$penanggal memberikan angka dari penanggalan tanpa memperdulikan apakah angka tersebut Pangelong atau Penanggal. Untuk menentukannya digunakan variabel boolean $isPangelong dimana jika true variabel penanggal tersebut adalah Pangelong dan sebaliknya.

$isNgunaratri memberikan value boolean yang menentukan apakah penanggal tersebut adalah penganggal yang Ngunaratri(Pengalantaka) dimana jika variabel $isNgunaratri memberikan nilai true maka ex. jika penanggal pada hari tersebut adalah 9 maka hasil yang akan didapat pada hari selanjutnya adalah 11. Variabel ini berguna untuk menampilkan penanggal pada user interface (ex. Pangelong 10/11).

$isNampih memberikan value boolean yang menentukan apakah sasih pada saat tersebut adalah sasih nampih atau tidak. Jika true makah sasih pada saat itu adalah nampih sasih pada sasih sesuai dengan noSasih. Ex. Jika noSasih adalah 11 dan $isNampih adalah true maka sasih tersebut adalah nampih Destha(Jyestha).



## Fungsi-fungsi lain

Semua fungsi-fungsi lain dari sakacalendar versi Java telah diport ke php namun belum dilakukan testing.
Karena kesibukan saya, akan diupdate beberapa waktu kedepan.

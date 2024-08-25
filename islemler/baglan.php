<?php 

date_default_timezone_set('Europe/Istanbul');
if (!session_start()): # eğer otorum açılma işlemi başlamdıysa
        session_start(); #  başlat dedik

endif;

$host= "localhost";
$veritabani_isim ="kursdomaintakip"; ## burasını değiştirdik farklı veri tabanı adı olduğu için
$kullanici_adi="root";
$sifre="1234";

try { 
    $db = new PDO("mysql:host=$host;dbname=$veritabani_isim;charset=utf8", $kullanici_adi, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı Başarısız";
    echo $e->getMessage(); #"die" yaparsak başka hatayı başka bir sayfada gösteriyor. echo yaparsak ana sayfada gösteriyor
}




$sorgu=$db->prepare("SELECT * FROM ayarlar"); #   "prepare"ile veri tabanından veri çektik
$sorgu->execute();
$ayarcheck=$sorgu->fetch(PDO::FETCH_ASSOC); # ve aşağıda  "value"lara burdaki değişkeni veriyoruz ve verileri eklemiş oluyoruz





?>
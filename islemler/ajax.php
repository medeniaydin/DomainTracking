<?php
// veri güncelleme silmeyi buradan gerçekleştireceğiz
include("baglan.php");

if (isset($_POST["ayarkaydet"])):

    $sorgu = $db->prepare("UPDATE ayarlar SET
        site_baslik = :site_baslik,
        site_aciklama = :site_aciklama,
        site_link = :site_link,
        site_sahip_mail = :site_sahip_mail,
        site_mail_host = :site_mail_host,  /* Bu satırdaki hata düzeltildi */
        site_mail_mail = :site_mail_mail,
        site_mail_port = :site_mail_port,
        site_mail_sifre = :site_mail_sifre
        WHERE id = 1");

    $sorgu->execute(array(
        "site_baslik" => $_POST["site_baslik"],
        "site_aciklama" => $_POST["site_aciklama"],
        "site_link" => $_POST["site_link"],
        "site_sahip_mail" => $_POST["site_sahip_mail"],
        "site_mail_host" => $_POST["site_mail_host"],
        "site_mail_mail" => $_POST["site_mail_mail"],
        "site_mail_port" => $_POST["site_mail_port"],
        "site_mail_sifre" => $_POST["site_mail_sifre"]
    ));

/* Logo ekleme*/

if ($_FILES["site_logo"]["error"]=="0"):  # sitede sadece isim değişikli vs. yaptığımızda logomuz gitmesin diye 
    # code...

$gecici_isim = $_FILES["site_logo"]["tmp_name"];             # "site_logo" ismini html'deki "name=" e koyduğumuz isimden aldık
                                                            # yanına "["tmp_name"]" bundan koyuyoz. Buda yüklediğimiz resmin geçici ismi oluyor
$dosya_ismi= rand(100000,999999).$_FILES["site_logo"]["name"];  # başına "rand()" koyduk güvenlik için. her fotorafın başına tasgele sayı koyucak
move_uploaded_file($gecici_isim,"../dosyalar/$dosya_ismi");         # Admin panalini altında dosyalar adında bir klasör oluşturduk
                
              # ".." bu bir klasör geri git demek.Bir klasör geri gdip dosyalar klasörüne ulaşıyoz
            # "../dosyalar/$dosya_ismi"  /dosyalardan sonra oluşturduğumuz değişkeni yazıyoz.
         # ve son olarak ayarlardaki forma dosya ekleme özelliği ekliyoz


            $sorgu = $db->prepare("UPDATE ayarlar SET
                site_logo = :site_logo
                WHERE id = 1");
        
            $sorgu->execute(array(
                "site_logo" =>$dosya_ismi
            ));
endif;





if ($sorgu){   # eğer işlem başarılı olursa ayarlar sayfasına gönder dedik ve "ok" yazsın dedik
    header("location:../ayarlar.php?durum=ok");
}else {
    header("location:../ayarlar.php?durum=no"); # işlem gerçekleşmezse yine ayarlar sayfasına gönder ama "no" yazsın
}

exit; #  hasta olmasın diye bundan sonraki kodlarım çalıştırma dedik  

endif;


/*******************************************************************************/

if (isset($_POST["oturumacma"])):
    
    $sorgu=$db->prepare(" SELECT * FROM kullanicilar WHERE kul_mail=:kul_mail AND kul_sifre=:kul_sifre ");  # e psota ve şifre uyuşuyors giriş yap demek
    $sorgu->execute(array(
        "kul_mail" => $_POST["kul_mail"],
        "kul_sifre" => md5($_POST["kul_sifre"]) # "md5()"le şifrelenmiş paswordümüüz okuyabiliyoz. psw yi internetten öylesine şifreledik özel bi func eklemedik
    ));
    $sonuc=$sorgu->rowCount(); # buradan dönen satır sayısını bul demek
   /* echo $sonuc; # bunu giriş yapıldığında "1" yazıyor onu görmek için geçici koyduk */

$kullanici=$sorgu->fetch(PDO::FETCH_ASSOC);

   if ($sonuc==0) {
    echo "Başarısız";

   }else{
    $_SESSION["kul_isim"] = $kullanici["kul_isim"]; # böylece kullannıcı giriş yaptısa diyoruz ve güvenliği arttırıyoruz
    $_SESSION["kul_mail"] = $kullanici["kul_mail"];
    $_SESSION["kul_id"] = $kullanici["kul_id"];
    header("location:../ayarlar.php");


   }

   exit;
endif;


/*******************************************************************************/

if (isset($_POST["profilkaydet"])):
    $sorgu=$db->prepare("UPDATE kullanicilar SET 
    kul_isim=:kul_isim,
    kul_mail=:kul_mail,
    kul_telefon=:kul_telefon WHERE kul_id=:kul_id");

  $sonuc= $sorgu->execute(array(
    "kul_isim" => $_POST["kul_isim"],
    "kul_mail" => $_POST["kul_mail"],
    "kul_telefon" => $_POST["kul_telefon"],
    "kul_id" => $_SESSION["kul_id"] ));



if (strlen($_POST["kul_sifre"])>0) {  # str (string) ile eğer şifre sıfırdan küçükse yani şifre alanı boşsa yenile dedik. yani şifre alanına bişe yazmazsa şifre değişmez
    $sorgu=$db->prepare("UPDATE kullanicilar SET 
    kul_sifre=:kul_sifre WHERE kul_id=:kul_id");

  $sonuc= $sorgu->execute(array(
    "kul_sifre" => md5($_POST["kul_sifre"]), # md5le passwordlerimi şifreleyerek kaydediyoz databaseye
    "kul_id" => $_SESSION["kul_id"] ));

}

if ($sonuc){
  header("location:../profil.php?durum=ok");
}else{
    header("location:../profil.php?durum=no");
}
exit;
endif;

 
/*******************************************************************************/

# soldaki "musteri_isim" vs veritabanındaki isimler. Bu isimleri sağdaki geçici isimlere eşitliyoz
if (isset($_POST["musteriekle"])):
    $sorgu=$db->prepare("INSERT INTO musteri SET
        musteri_isim=:musteri_isim,
        musteri_mail=:musteri_mail,
        musteri_telefon=:musteri_telefon,
        musteri_detay=:musteri_detay
        ");
        # yukarıda sağdaki eşitlediğmiz geçici isimleri sola yazıp, " $_POST[]"la form'daki "name"lere eşitliyoz
           # böylece veri tabanını forma bağlamış oluyoz
         # NOT bütün isimleri aynı yaptık karışmasın diye
    $sonuc =$sorgu->execute(array(
        "musteri_isim" => $_POST["musteri_isim"],
        "musteri_mail" => $_POST["musteri_mail"],
        "musteri_telefon" => $_POST["musteri_telefon"],
        "musteri_detay" => $_POST["musteri_detay"]

    ));
    if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
        header("location:../musteriler.php?durum=ok");
      }else{
          header("location:../musteriler.php?durum=no");
      }

      exit;
endif;


/*******************************************************************************/

 
if (isset($_POST["musteriguncelle"])):
    $sorgu=$db->prepare("UPDATE musteri SET
        musteri_isim=:musteri_isim,
        musteri_mail=:musteri_mail,
        musteri_telefon=:musteri_telefon,
        musteri_detay=:musteri_detay WHERE musteri_id=:musteri_id
        ");
        # yukarıda sağdaki eşitlediğmiz geçici isimleri sola yazıp, " $_POST[]"la form'daki "name"lere eşitliyoz
           # böylece veri tabanını forma bağlamış oluyoz
         # NOT bütün isimleri aynı yaptık karışmasın diye
    $sonuc =$sorgu->execute(array(
        "musteri_isim" => $_POST["musteri_isim"],
        "musteri_mail" => $_POST["musteri_mail"],
        "musteri_telefon" => $_POST["musteri_telefon"],
        "musteri_detay" => $_POST["musteri_detay"],
        "musteri_id" => $_POST["musteri_id"]

    ));
    
    if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
        header("location:../musteriler.php?durum=ok");
      }else{
          header("location:../musteriler.php?durum=no");
      }

      exit;
endif;

/*******************************************************************************/
# "musteriler.php"de silme buttonuna "name="e "musterisilme" yazdık

if (isset($_POST["musterisilme"])):
    $sorgu=$db->prepare("DELETE FROM musteri WHERE musteri_id=:musteri_id");
     $sonuc=$sorgu->execute(array(
        "musteri_id" => $_POST["musteri_id"]
    ));

    if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
        header("location:../musteriler.php?durum=ok");
      }else{
          header("location:../musteriler.php?durum=no");
      }

      exit;
endif;


/*******************************************************************************/

if (isset($_POST["domainekle"])):
    $sorgu=$db->prepare("INSERT INTO domain SET 
        domain_adi=:domain_adi,
        domain_musteri=:domain_musteri,
        domain_baslangic=:domain_baslangic,
        domain_kayit_firmasi=:domain_kayit_firmasi,
        domain_bitis=:domain_bitis,
        domain_fiyat=:domain_fiyat
        ");
        $sonuc=$sorgu->execute(array(
        "domain_adi" => $_POST["domain_adi"],
        "domain_musteri" => $_POST["domain_musteri"],
        "domain_baslangic" => $_POST["domain_baslangic"],
        "domain_kayit_firmasi" => $_POST["domain_kayit_firmasi"],
        "domain_bitis" => $_POST["domain_bitis"],
        "domain_fiyat" => $_POST["domain_fiyat"]

        ));

        if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
            header("location:../domainler.php?durum=ok");
          }else{
              header("location:../domainler.php?durum=no");
          }
    
          exit;

endif;



/*******************************************************************************/

if (isset($_POST["domainguncelle"])):
    $sorgu=$db->prepare("UPDATE domain SET 
        domain_adi=:domain_adi,
        domain_musteri=:domain_musteri,
        domain_baslangic=:domain_baslangic,
        domain_kayit_firmasi=:domain_kayit_firmasi,
        domain_bitis=:domain_bitis,
        domain_fiyat=:domain_fiyat WHERE domain_id=:domain_id
        ");
        $sonuc=$sorgu->execute(array(
        "domain_adi" => $_POST["domain_adi"],
        "domain_musteri" => $_POST["domain_musteri"],
        "domain_baslangic" => $_POST["domain_baslangic"],
        "domain_kayit_firmasi" => $_POST["domain_kayit_firmasi"],
        "domain_bitis" => $_POST["domain_bitis"],
        "domain_fiyat" => $_POST["domain_fiyat"],
        "domain_id" => $_POST["domain_id"]

        ));

       /* hatayı yazdırmak için kullanılır    print_r($sorgu->errorInfo()); */
        
        if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
            header("location:../domainler.php?durum=ok");
          }else{
              header("location:../domainler.php?durum=no");
          }
          exit; 

endif;


/*******************************************************************************/




if (isset($_POST["domainyenile"])):  # domain yenile formundan geliyorsan demek
    $eklenecekYil=$_POST["eklenecek_yil"];
    $yeniTarih=strtotime("$eklenecekYil years", strtotime($_POST["domain_bitis"])); # domain bitiş tarihine benim girdiğim veriyi "years" yıl oalrak ekle dedim 
    $domainBitisTarihi= date("Y-m-d",$yeniTarih); # veri tabanındaki (yıl,ay,gün) sırasına göre yazmamız lazım
                                                     # "$yeniTarih"i "Y-m-d" formatıne çevir dedik
     $sorgu=$db->prepare("UPDATE domain SET  
        domain_bitis=:domain_bitis WHERE domain_id=:domain_id
        ");
        $sonuc=$sorgu->execute(array(
        "domain_bitis" => $domainBitisTarihi, # post olarak değil yukarıda atadığımız değer yolluyoz  
        "domain_id" => $_POST["domain_id"]

        ));

       /* hatayı yazdırmak için kullanılır    print_r($sorgu->errorInfo()); */
        
        if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
            header("location:../domainler.php?durum=ok");
          }else{
              header("location:../domainler.php?durum=no");
          }
          exit; 

                                                 
                                                     
endif;





/*******************************************************************************/

if (isset($_POST["domainsilme"])):
    $sorgu=$db->prepare("DELETE FROM domain WHERE domain_id=:domain_id");
     $sonuc=$sorgu->execute(array(
        "domain_id" => $_POST["domain_id"]
    ));

    if ($sonuc){ # işlem başarılı olurs veya olmazsa şartları
        header("location:../domainler.php?durum=ok");
      }else{
          header("location:../domainler.php?durum=no");
      }

      exit;
endif;







?>

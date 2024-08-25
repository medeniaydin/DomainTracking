<?php include "baglan.php"; ?>


<?php
$host_adresi = $ayarcheck["site_mail_host"];
$mail_adresiniz = $ayarcheck["site_mail_mail"];
$port_numarasi = $ayarcheck["site_mail_port"];
$mail_sifreniz = $ayarcheck["site_mail_sifre"];

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";
require_once "PHPMailer/SMTP.php";


$mailbasligi = "Domain Hatırlatma Maili";
$isim = $ayarcheck["site_baslik"];

/**  iletimerkezi api bilgileri **/
$api_key = 'your_api_key';
$api_hash = 'your_api_hash';
$sender = 'APITEST';


/*****************   SMS Func   *****************************/
function sendRequest($url, $xml) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: text/xml');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    return curl_exec($ch);
}


/********************************************************/
/*** STANDART SMTP KODU ***/

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = $host_adresi;
$mail->Port = $port_numarasi;    # yukarıda belirlediğmiz değişkenleri buradaki yerlere giriyoz
$mail->IsHTML(true);
$mail->Username = $mail_adresiniz;
$mail->Password = $mail_sifreniz;
$mail->SetFrom($mail->Username, $isim);
$mail->Subject = $mailbasligi;
$mail->CharSet = 'UTF-8';

/********************************************************/


$sorgu = $db->prepare("SELECT * FROM domain");
$sorgu->execute();

while ($domainchech = $sorgu->fetch(PDO::FETCH_ASSOC)) {
    $tarih1 = strtotime(date("d.m.Y"));
    $tarih2 = strtotime($domainchech["domain_bitis"]);
    $fark = $tarih2 - $tarih1;
    $sonuc = floor($fark / (60 * 60 * 24));

    if ($sonuc == "-3" or $sonuc == "-1" or $sonuc == 2 or $sonuc == 3 or $sonuc == 4 or $sonuc == 5 or $sonuc == 6 or $sonuc == 7 or $sonuc == 15 or $sonuc == 30):
        $domain_id = $domainchech["domain_id"];
        $bitis_tarihi = $domainchech["domain_bitis"];
        $kalanGun = $sonuc;

        $sorgu = $db->prepare("SELECT * FROM musteri WHERE musteri_id=:musteri_id");
        $sorgu->execute(array(
            "musteri_id" => $domainchech["domain_id "]
        ));
        $musterichech = $sorgu->fetch(PDO::FETCH_ASSOC);
        $musteri_mail = $musterichech["musteri_mail"];
        $musteri_telefon = $musterichech["musteri_telefon"];
        $mailicerigi = "Sayın " . $musterichech["musteri_isim"] . " " . $domainchech["domain_adi"] . " isimli alan adınızın kullanım süresi " . $kalanGun . " 
    gün içerisinde dolacaktır. Alan adınızı kullanmak istiyorsanız yenilemeyi unutmayın!";

        $mail->Body = $mailicerigi;

        $mail->AddAddress($ayarcheck['site_sahip_mail']);
        $mail->AddAddress($mustericheck['musteri_mail']);

        if ($mail->send()) {
            echo "Başarılı";
        } else {
            echo "Başarsız<br>";
            echo $mail->ErrorInfo();
        }


    endif;

    if ($sonuc == "-1" or $sonuc == 1 or $sonuc == 7 or $sonuc == 15): # Sms gönderme işlemi
    $numara=$mustericheck["musteri_telefon"]; 
    $msjDetayi="Sayın " . $musterichech["musteri_isim"] . " " . $domainchech["domain_adi"] . "domaininizin kullanım süresi " . $kalanGun . " 
    gün içerisinde dolacaktır. Yenilemeyi unutmayın!";   

        $xml = <<<EOS
      <request>
        <authentication>
          <key>{$api_key}</key>
          <hash>{$api_hash}</hash>
        </authentication>
        <order>
          <sender>{$sender}</sender>
          <message>
            <text>{$msjDetayi}</text>
            <receipents>
              <number>{$numara}</number>
            </receipents>
          </message>
        </order>
      </request>
      EOS;


        $result = sendRequest(
            'http://api.iletimerkezi.com/v1/send-sms',
            $xml
        );

        die('<pre>' . var_export($result, 1) . '</pre>');


    endif;

}

?>
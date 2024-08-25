<?php
        # "isset()" eğer varsa demek. başına ünlem konulunca yoksa demek
function oturumkontrol(){  # eğer kullanıcı girişi yoksa izni sil dedik
    if (!isset($_SESSION["kul_mail"]) or !isset($_SESSION["kul_isim"])  or !isset($_SESSION["kul_id"])) {
        session_destroy();
        header("location:login.php");
        exit;
    } else {
        # code...
    }
    



}












?>
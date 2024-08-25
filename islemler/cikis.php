<?php

session_start();   # session başlar dedik
session_destroy();  # çıkış yap dedil
header("location:../login.php"); # login sayfasına yönlendir dedik
exit;


?>
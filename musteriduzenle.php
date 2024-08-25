<?php include "header.php"; 
                        # "musteriler.php"de veri gönderirken "name="e "musteri_id" yazdık o 
 
    if (isset($_POST["musteri_id"])) {
        $sorgu=$db->prepare("SELECT * FROM musteri WHERE musteri_id=:musteri_id");
        $sorgu->execute(array(
            "musteri_id" => $_POST["musteri_id"]
        )); 
        $musteribilgisi=$sorgu->fetch(PDO::FETCH_ASSOC); 
    } else {
        header("location:musteriler.php");
        exit;
    }
    


?>


<div class="container-flued">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-wight-bold text-primary">Müşteri Düzenle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Müşteri İsim </label>
                                <input required="" type="text" name="musteri_isim" class="form-control" value="<?php echo $musteribilgisi["musteri_isim"];?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="">Müşteri Mail </label>
                                <input required="" type="email" name="musteri_mail" class="form-control" value="<?php echo $musteribilgisi["musteri_mail"];?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Müşteri Telefon </label>
                                <input type="text" name="musteri_telefon" class="form-control" value="<?php echo $musteribilgisi["musteri_telefon"];?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="">Müşteri Detay </label>
                                <textarea id="editor" name="musteri_detay" class="form-control" style="height: auto ;"><?php echo $musteribilgisi["musteri_detay"];?></textarea>
                            </div>
                            <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi["musteri_id"];?>">
                        </div>
                        <button type="submit" class="btn btn-primary" name="musteriguncelle">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "footer.php" ?>

<!-- TEXT EDİTOR -->

<!--yukarıda "textarea"nın "id"sine ne yazdıysak "replace()"ede onu yazmamız lazım  -->
<!-- CKEditor ana kütüphanesi -->
<script src="vendor/ckeditor/ckeditor.js"></script>

<!-- CKEditor konfigürasyon dosyası -->
<script src="vendor/ckeditor/config.js"></script>

<!-- CKEditor'u belirli bir textarea ile bağlama -->
<script type="text/javascript">  
    CKEDITOR.replace("editor");
</script>

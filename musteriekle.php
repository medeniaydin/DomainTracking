<?php include "header.php"; ?>

<div class="container-flued">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-wight-bold text-primary">Müşteri Ekle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Müşteri İsim </label>
                                <input required="" type="text" name="musteri_isim" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label >Müşteri Mail </label>
                                <input required="" type="email" name="musteri_mail" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label >Müşteri Telefon </label>
                                <input type="text" name="musteri_telefon" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Müşteri Detay </label>
                                <textarea id="editor" name="musteri_detay" class="form-control" style="height: auto ;"></textarea>
                            </div> 
                        </div>
                        <button type="submit" class="btn btn-primary" name="musteriekle">Kaydet</button>
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

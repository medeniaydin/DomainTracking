<?php include("header.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary">Ayarlar</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                        <!--  enctype="multipart/form-data" bu nu form'a ekleyince dosyada gödnerebiliyoz artık  -->

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Site Logo</label>
                                <input type="file" name="site_logo" class="form-control">
                                <small id="helpId" class="text-muted">Logo Yükle</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Site Başlık</label>
                                <input type="text" name="site_baslik" class="form-control"
                                    value="<?php echo $ayarcheck['site_baslik'] ?>">
                                <!-- burada "$ayarcheck['']"  içine veritabanındaki isimleri yazdık-->
                                <small id="helpId" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Site Açıklama</label>
                                <input type="text" name="site_aciklama" class="form-control"
                                    value="<?php echo $ayarcheck['site_aciklama'] ?>">
                                <small id="helpId" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Site Link</label>
                                <input type="text" name="site_link" class="form-control"
                                    value="<?php echo $ayarcheck['site_link'] ?>">
                                <small id="helpId" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Site Sahibi Mail Adresi</label>
                                <input type="text" name="site_sahip_mail" class="form-control"
                                    value="<?php echo $ayarcheck['site_sahip_mail'] ?>">
                                <small id="helpId" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Mail Host Adresi</label>
                                <input type="text" name="site_mail_host" class="form-control"
                                    value="<?php echo $ayarcheck['site_mail_host'] ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mail Adresi</label>
                                <input type="text" name="site_mail_mail" class="form-control"
                                    value="<?php echo $ayarcheck['site_mail_mail'] ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Mail Post Adresi</label>
                                <input type="text" name="site_mail_port" class="form-control"
                                    value="<?php echo $ayarcheck['site_mail_port'] ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mail Şifresi</label>
                                <input type="text" name="site_mail_sifre" class="form-control"
                                    value="<?php echo $ayarcheck['site_mail_sifre'] ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <button type="submit" class="btn btn-primary" name="ayarkaydet">Kaydet</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php"); ?>



<?php
#  "url"de "durum" diye bir değer varsa
if (@$_GET["durum"] == "ok"): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: "success",
            title: "İşlem Başarılı",
            text: "İşleminiz Başarıyla Gerçekleşti!",
            confirmButtonText: "Tamam"
        });
    </script>
<?php endif; ?>


<?php
#  "url"de "durum" diye bir değer varsa
if (@$_GET["durum"] == "no"): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: "error",
            title: "Hata!",
            text: "İşleminiz Başarısız, Lütfen Tekrar Deneyiniz!",
            confirmButtonText: "Tamam"
        });
    </script>
<?php endif; ?>
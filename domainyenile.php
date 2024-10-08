<?php include "header.php"; 
$sorgu = $db->prepare("SELECT * FROM domain WHERE domain_id=:domain_id");
$sorgu->execute(array(
    "domain_id" => $_POST["domain_id"]
));
$domain=$sorgu->fetch(PDO::FETCH_ASSOC);


?>

<div class="container-flued">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-wight-bold text-primary">Domain Yenile</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Domain Adı </label>
                                <input disabled="" type="text" name="domain_adi" class="form-control" placeholder="Domain Adı"  value="<?php echo $domain['domain_adi']?>">
                            </div>

                           
                            <div class="col-md-6 form-group">
                                <label for="">Domain Başlangıç Tarihi</label>
                                <input disabled="" type="date" name="domain_baslangic" class="form-control" placeholder="Domain Başlangıç Tarihi"  value="<?php echo $domain['domain_baslangic']?>">
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Domain Bitiş Tarihi </label>
                             <input type="date" name="domain_bitis" class="form-control" placeholder="Domain Bitiş Tarihi "  value="<?php echo $domain['domain_bitis']?>">
                         </div>
                         <div class="col-md-6 form-group">
                            <label for="">Kaç Yıl Eklenecek </label>
                             <input type="text" name="eklenecek_yil" class="form-control" placeholder="Kaç Yıl Eklenecek" >
                         </div>

                        </div>
                        <input type="hidden" name="domain_id" value="<?php echo $_POST['domain_id']?>">
                        <button type="submit" class="btn btn-primary" name="domainyenile">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include "footer.php" ?>
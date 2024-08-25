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
                    <h5 class="font-wight-bold text-primary">Domain Güncelle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="post">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Domain Adı </label>
                                <input type="text" name="domain_adi" class="form-control" placeholder="Domain Adı"  value="<?php echo $domain['domain_adi']?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="">Domain Müşteri</label>
                                  <select class="form-control" name="domain_musteri">
                                    
                                  <?php 
                                  
                                  $sorgu=$db->prepare("SELECT * FROM musteri");
                                  $sorgu->execute();
                                  while ($musteri=$sorgu->fetch(PDO::FETCH_ASSOC)) {?>
                                      <option <?php if ($domain['domain_musteri'] == $musteri["musteri_id"]){ echo "Selected";}  ?> value="<?php echo $musteri["musteri_id"]?>" ><?php echo $musteri["musteri_isim"]?></option>
                                <?php }?>


                                    
                                  </select>
                                
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">Domain Başlangıç Tarihi</label>
                                <input type="date" name="domain_baslangic" class="form-control" placeholder="Domain Başlangıç Tarihi"  value="<?php echo $domain['domain_baslangic']?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Kayıt Firması</label>
                                <input type="text" name="domain_kayit_firmasi" class="form-control" placeholder="Kayıt Firması"  value="<?php echo $domain['domain_kayit_firmasi']?>">
                            </div>
                        <div class="col-md-4 form-group">
                            <label for="">Domain Bitiş Tarihi </label>
                             <input type="date" name="domain_bitis" class="form-control" placeholder="Domain Bitiş Tarihi "  value="<?php echo $domain['domain_bitis']?>">
                         </div>
                         <div class="col-md-4 form-group">
                            <label for="">Domain Fiyat </label>
                             <input type="text" name="domain_fiyat" class="form-control" placeholder="Domain Fiyat"  value="<?php echo $domain['domain_fiyat']?>">
                         </div>

                        </div>
                        <input type="hidden" name="domain_adi" value="<?php echo $_POST['domain_id']?>">
                        <button type="submit" class="btn btn-primary" name="domainguncelle">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include "footer.php" ?>
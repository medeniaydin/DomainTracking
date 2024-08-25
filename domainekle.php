<?php include "header.php"; ?>

<div class="container-flued">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-wight-bold text-primary">Domain Ekle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/ajax.php" method="post">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Domain Adı </label>
                                <input type="text" name="domain_adi" class="form-control" placeholder="Domain Adı">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="">Domain Müşteri</label>
                                  <select class="form-control" name="domain_musteri" id="musteriListesi" onchange="musterisecme()">
                                    
                                  <?php 
                                  
                                  $sorgu=$db->prepare("SELECT * FROM musteri");
                                  $sorgu->execute();
                                  while ($musteri=$sorgu->fetch(PDO::FETCH_ASSOC)) {?>
                                      <option value="<?php echo $musteri["musteri_id"]?>" ><?php echo $musteri["musteri_isim"]?></option>
                                <?php }?>

                                <option value="musteri_ekle">MÜŞTERİ EKLE</option>
            
                                    
                                  </select>
                                
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">Domain Başlangıç Tarihi</label>
                                <input type="date" name="domain_baslangic" class="form-control" placeholder="Domain Başlangıç Tarihi">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Kayıt Firması</label>
                                <input type="text" name="domain_kayit_firmasi" class="form-control" placeholder="Kayıt Firması">
                            </div>
                        <div class="col-md-4 form-group">
                            <label for="">Domain Bitiş Tarihi </label>
                             <input type="date" name="domain_bitis" class="form-control" placeholder="Domain Bitiş Tarihi ">
                         </div>
                         <div class="col-md-4 form-group">
                            <label for="">Domain Fiyat </label>
                             <input type="text" name="domain_fiyat" class="form-control" placeholder="Domain Fiyat">
                         </div>

                        </div>
                        <button type="submit" class="btn btn-primary" name="domainekle">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include "footer.php" ?>

<script type="text/javascript">  
    function musterisecme() {
        var musteriListesi = document.getElementById("musteriListesi");
        var secilenDeger = musteriListesi.options[musteriListesi.selectedIndex].value;
        
        if (secilenDeger=="musteri_ekle") {
            Swal.fire({
            title:" Emin Misiniz?",   
            text:"Müşteri Ekleme Sayfasına Yönlendiriliyorsunuz. Bu Sayfada ki Veriler Kaybolacaktır!",
            icon: "warning",
            showCancelButton:true,
            confirmButtonColor:"green",
            cancelButtonColor:"red",
            confirmButtonText:"Evet Yönlendir!",
            cancelButtonText:"Hayır Bekle!"

            }).then((result) => {
                if (result.value) {
                    window.location="musteriekle.php"
                }
            }


            )
            
        }
    }
</script>

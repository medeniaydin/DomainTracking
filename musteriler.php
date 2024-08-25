<?php include "header.php"; ?>
<link rel="stylesheet"  type="text/css" href="vendor/datatables/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title font-weight-bold">Müşteriler</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="musteritablosu">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Müşteri İsmi</th>
                            <th>Müşteri Mail</th>
                            <th>Müşteri Telefon</th>
                            <th>Müşteri İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sayi = 0;
                        $sorgu = $db->prepare("SELECT * FROM musteri ");
                        $sorgu->execute();

                        while ($musteribilgisi = $sorgu->fetch(PDO::FETCH_ASSOC)):
                            $sayi++;
                            ?>
                            <tr>
                                <td><?php echo $sayi; ?></td>
                                <td><?php echo $musteribilgisi["musteri_isim"]; ?></td>
                                <td><?php echo $musteribilgisi["musteri_mail"]; ?></td>
                                <td><?php echo $musteribilgisi["musteri_telefon"]; ?></td>
                                <td>
                                    <div class="row justify-content-center">
                                        <form action="musteriduzenle.php" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi["musteri_id"];?>">
                                            <button type="submit" class="btn btn-success btn-sm btn-icon-split">
                                                <span class="icon text-white-60">
                                                    <i class="fas fa-edit"></i> 
                                                </span>
                                            </button>
                                        </form>

                                        <form class="mx-1" action="islemler/ajax.php" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi["musteri_id"];?>">
                                            <button type="submit" name="musterisilme" class="btn btn-danger btn-sm btn-icon-split">
                                                <span class="icon text-white-60">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </button>
                                        </form>

                                        <form action="musteri.php" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="musteri_id" value="<?php echo $musteribilgisi["musteri_id"];?>">
                                            <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
                                                <span class="icon text-white-60">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include "footer.php" ?>

<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    $("#musteritablosu").DataTable();
</script>



<?php  
        #  "url"de "durum" diye bir değer varsa
if (@$_GET["durum"]=="ok") :?> 
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
if (@$_GET["durum"]=="no") :?> 
    <script type="text/javascript"> 
        Swal.fire({
            icon: "error",
            title: "Hata!",
            text: "İşleminiz Başarısız, Lütfen Tekrar Deneyiniz!",
            confirmButtonText: "Tamam"
        });
    </script>
<?php endif; ?>

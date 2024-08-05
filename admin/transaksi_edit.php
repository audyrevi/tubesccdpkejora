<?php
$title = 'transaksi';
require 'functions.php';

$id = $_GET['nonota'];
$queryedit = "SELECT nonota,tglsls,kg,hargalaundry.harga*kg as ttlharga,ket FROM transaksi LEFT JOIN hargalaundry on transaksi.kodelaundry=hargalaundry.kodelaundry WHERE nonota='$id'";
$edit = ambilsatubaris($conn,$queryedit);
var_dump($edit);

if(isset($_POST['btn-simpan'])){
    $tgl = date("Y-m-d");
    $tgl     = $_POST['tglbayar'];
    $status     = $_POST['ket'];
    $query = "UPDATE transaksi SET ket = '$status', tglsls ='$tgl' WHERE nonota ='$id' ";
    $execute = bisa($conn,$query);
    if($execute == 1){
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil mengubah status transaksi';
        $type = 'success';
        header('location: transaksi.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
    }else{
        echo "Gagal Tambah Data";
    }
}

require 'layout_header.php';

?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master Transaksi</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php">Transaksi</a></li>
                <li><a href="#">Tambah Transaksi</a></li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-6">
                          <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-primary box-title"><i class="fa fa-arrow-left fa-fw"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <form method="post" action="">
                <div class="form-group">
                    <label>No Nota</label>
                    <input type="text" name="nonota" class="form-control" readonly="" value="<?= $edit['nonota'] ?>">
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input readonly=""   type="text" name="kg" class="form-control" value="<?= $edit['kg'] ?>"> 
                </div>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input readonly=""   type="text" name="ttlharga" class="form-control" value="<?= $edit['ttlharga'] ?>"> 
                </div>
                    <div class="form-group">
                        <label>Tgl Selesai</label>
                        <input type="date"   type="text" name="tglbayar" class="form-control" value="<?= $edit['tglsls'] ?>"> 
                    </div>
                    <div class="form-group">
                        <label>Ket</label>
                        <select name="ket" class="form-control" value="<?= $edit['ket'] ?>">
                        <option>Dibayar</option>
                        <option>Belum</option>
                        </select>
                    </div>
                <div class="text-right">
                    <button type="submit" name="btn-simpan" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout_footer.php';
?> 
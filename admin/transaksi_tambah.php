<?php
$title = 'transaksi';
function dbConnect(){
	$db=new mysqli("localhost","root","","laundry");
	return $db;
}
function getListLaundry(){
    $db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
						 FROM hargalaundry
						 ORDER BY kodelaundry");
		if($res){
			$data=$res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;}}}
            function getListPegawai(){
                $db=dbConnect();
                if($db->connect_errno==0){
                    $res=$db->query("SELECT * 
                                     FROM pegawai
                                     ORDER BY idpegawai");
                    if($res){
                        $data=$res->fetch_all(MYSQLI_ASSOC);
                        $res->free();
                        return $data;
                    }
                    else
                        return FALSE; 
                }
                else
                    return FALSE;
            }
            
            function getListPelanggan(){
                $db=dbConnect();
                if($db->connect_errno==0){
                    $res=$db->query("SELECT * 
                                     FROM pelanggan
                                     ORDER BY idpelanggan");
                    if($res){
                        $data=$res->fetch_all(MYSQLI_ASSOC);
                        $res->free();
                        return $data;
                    }
                    else
                        return FALSE; 
                }
                else
                    return FALSE;
            }
$db=dbConnect();
if(isset($_POST['btn-simpan'])){
	$db=dbConnect();
        $id = $_POST['nonota'];
        $idpegawai = $_POST['idpegawai'];
        $nama     = $_POST['idpelanggan'];
        $jenis    = $_POST['kodelaundry'];
        $tglmsk    = date("Y-m-d");
        $tglmsk = $_POST['tglmasuk'];
        $tglsls    = date("Y-m-d");
        $tglsls = $_POST['tglbayar'];
        $jmlh = $_POST['qty'];
        $ket = $_POST['ket'];
		// Susun query insert
		$sql="INSERT INTO transaksi (nonota,tglmsk,tglsls,idpegawai,idpelanggan,kodelaundry,kg,totalharga,ket) values ('$id','$tglmsk','$tglsls','$idpegawai','$nama','$jenis','$jmlh',0,'$ket')";
		// Eksekusi query insert
		$res=$db->query($sql);
		if($res){
                $success = 'true';
                $title = 'Berhasil';
                $message = 'Berhasil menambahkan ' .$role. ' baru';
                $type = 'success';
                header('location: transaksi.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
            }else{
                echo "Gagal Tambah Data";
            }
            }
        
/*require 'functions.php';
if(isset($_POST['btn-simpan'])){
    $id = $_POST['nonota'];
    $idpegawai = $_POST['idpegawai'];
    $nama     = $_POST['nama'];
    $jenis    = $_POST['jenis_laundry'];
    $tglmsk = $_POST['tglmasuk'];
    $tglmsk    = date("Y-m-d", strtotime($tglmsk));
    $tglsls = $_POST['tglbayar'];
    $tglsls    = date("Y-m-d", strtotime($tglsls));
    $jmlh = $_POST['qty'];
    $ttlharga = 0;
    $ket = $_POST['ket'];
    $query = "INSERT INTO transaksi (nonota,tglmsk,tglsls,idpegawai,idpelanggan,kodelaundry,kg,ttlharga,ket) values ('$id','$tglmsk','$tglsls','$idpegawai','$nama','$jenis','$jmlh','$ttlharga','$ket')";
    $execute = bisa($conn,$query);
    if($execute == 1){
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil menambahkan ' .$role. ' baru';
        $type = 'success';
        header('location: transaksi.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
    }else{
        echo "Gagal Tambah Data";
    }
}*/
require 'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Transaksi</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
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
                    <div class="col-md-6 text-right">
                        <button id="btn-refresh" class="btn btn-primary box-title text-right" title="Refresh Data"><i class="fa fa-refresh" id="ic-refresh"></i></button>
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
                    <input type="text" name="nonota" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pegawai</label>
                    <select name="idpegawai" class="form-control">
                    <option>-Pilih-</option>
                        <?php
                 $datapegawai = getListPegawai(); // ambil data kategori, kemudian susun menjadi combobox
                 foreach ($datapegawai as $data) {
                  echo "<option value=\"" . $data["idpegawai"] . "\">" . $data["nama"] . "</option>"; }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pelanggan</label>
                    <select name="idpelanggan" class="form-control">
                    <option>-Pilih-</option>
                        <?php
                 $datapelanggan = getListPelanggan(); // ambil data kategori, kemudian susun menjadi combobox
                 foreach ($datapelanggan as $data) {
                  echo "<option value=\"" . $data["idpelanggan"] . "\">" . $data["nama"] . "</option>"; }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Laundry</label>
                    <select name="kodelaundry" class="form-control">
                        <option>-Pilih-</option>
                        <?php
                 $datalaundry = getListLaundry(); // ambil data kategori, kemudian susun menjadi combobox
                 foreach ($datalaundry as $data) {
                  echo "<option value=\"" . $data["kodelaundry"] . "\">" . $data["jenislaundry"] . "</option>"; }
                  ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tgl Masuk</label>
                    <input type="date" name="tglmasuk" class="form-control">
                </div>
                <div class="form-group">
                    <label>Tgl Selesai</label>
                    <input type="date" name="tglbayar" class="form-control">
                </div>
                <div class="form-group">
                    <label>Jumlah(kg)</label>
                    <input type="text" name="qty" class="form-control" value="0"> 
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <select name="ket" class="form-control">
                        <option>-Pilih-</option>
                        <option value="lunas">Dibayar</option>
                        <option value="belum">Belum</option>
                 </select>
                </div>
                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" name="btn-simpan" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout_footer.php';
?> 
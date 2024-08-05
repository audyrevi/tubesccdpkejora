<?php
$title = 'pengguna';
require 'functions.php';
$id_user = stripslashes($_GET['idpegawai']);
$queryedit = "SELECT * FROM pegawai WHERE idpegawai = '$id_user'";
$edit = ambilsatubaris($conn,$queryedit);
var_dump($edit);
if(isset($_POST['btn-simpan'])){
    $nama     = stripslashes($_POST['nama']);
    $telp     = stripslashes($_POST['telp']);
    $username = stripslashes($_POST['username']);
    $pass     = md5($_POST['password']);
    if($_POST['password'] != null || $_POST['password'] == ''){
        $query = "UPDATE pegawai SET nama = '$nama' , telp = '$telp', username = '$username' , password ='$pass' WHERE idpegawai = '$id_user'";    
    }else{
        $query = "UPDATE pegawai SET nama = '$nama' , telp = '$telp', username = '$username' , WHERE idpegawai = '$id_user'";
    }
    
    
    $execute = bisa($conn,$query);
    if($execute == 1){
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil mengubah ' .$role;
        $type = 'success';
        header('location: pengguna.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
    }else{
        echo "Gagal Tambah Data";
    }
}


require'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master Pegawai</h4> </div>
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
                    <label>Nama Pegawai</label>
                    <input type="text" name="nama" class="form-control" value="<?= $edit['nama'] ?>">
                </div>
                <div class="form-group">
                    <label>Telp</label>
                    <input type="text" name="telp" class="form-control" value="<?= $edit['telp'] ?>">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $edit['username'] ?>">
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control">
                    <small class="text-danger">Kosongkan saja jika tidak akan mengubah password</small>
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
require'layout_footer.php';
?> 
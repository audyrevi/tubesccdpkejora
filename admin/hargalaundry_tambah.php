<?php
$title = 'hargalaundry';
require 'functions.php';
require 'DataProcessor.php';

// Fetch data
$query = 'SELECT * FROM hargalaundry';
$data = ambildata($conn, $query);

// Process form submission
if (isset($_POST['btn-simpan'])) {
    $kode = $_POST['kode_laundry'];
    $jenis_laundry = $_POST['jenis_laundry'];
    $harga = $_POST['harga'];

    $processor = new DataProcessor($conn, $kode, $jenis_laundry, $harga);
    $processor->process();
}

require 'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master <?= htmlspecialchars($title); ?></h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php"><?= htmlspecialchars($title); ?></a></li>
                <li><a href="#">Tambah <?= htmlspecialchars($title); ?></a></li>
            </ol>
        </div>
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
                    <label>Kode Laundry</label>
                    <input type="text" name="kode_laundry" class="form-control">
                </div>
                <div class="form-group">
                    <label>Jenis Laundry</label>
                    <input type="text" name="jenis_laundry" class="form-control">
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control">
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

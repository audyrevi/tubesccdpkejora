<?php
$title = 'hargalaundry';
require 'functions.php';

// Kelas Memento
class Memento {
    private $state;

    public function __construct($state) {
        $this->state = $state;
    }

    public function getState() {
        return $this->state;
    }
}

// Kelas Originator
class Originator {
    private $state;

    public function __construct($state) {
        $this->state = $state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function saveStateToMemento() {
        return new Memento($this->state);
    }

    public function getStateFromMemento(Memento $memento) {
        $this->state = $memento->getState();
    }

    public function getState() {
        return $this->state;
    }
}

// Kelas Caretaker
class Caretaker {
    private $memento;

    public function saveMemento(Memento $memento) {
        $this->memento = $memento;
    }

    public function getMemento() {
        return $this->memento;
    }
}

// Ambil data untuk diedit
$kode = stripslashes($_GET['kodelaundry']);
$queryedit = "SELECT * FROM hargalaundry WHERE kodelaundry = '$kode'";
$edit = ambilsatubaris($conn, $queryedit);

// Buat objek Originator dengan data yang ada
$originator = new Originator($edit);
$caretaker = new Caretaker();
$caretaker->saveMemento($originator->saveStateToMemento());

if (isset($_POST['btn-simpan'])) {
    $jenis_laundry = stripslashes($_POST['jenislaundry']);
    $harga = stripslashes($_POST['harga']);

    // Set state baru
    $originator->setState(['kodelaundry' => $kode, 'jenislaundry' => $jenis_laundry, 'harga' => $harga]);

    $query = "UPDATE hargalaundry SET jenislaundry='$jenis_laundry', harga='$harga' WHERE kodelaundry = '$kode'";
    $execute = bisa($conn, $query);

    if ($execute == 1) {
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil Ubah Data';
        $type = 'success';
        header('location: hargalaundry.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
    } else {
        echo "Gagal Tambah Data";
    }
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
                    <label>Jenis Laundry</label>
                    <input type="text" name="jenislaundry" class="form-control" value="<?= htmlspecialchars($edit['jenislaundry']); ?>">
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" value="<?= htmlspecialchars($edit['harga']); ?>">
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

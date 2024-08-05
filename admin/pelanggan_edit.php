<?php
$title = 'pelanggan';
require 'functions.php';

// Kelas Handler
abstract class Handler {
    protected $nextHandler;

    public function setNext(Handler $handler) {
        $this->nextHandler = $handler;
        return $handler;
    }

    abstract public function handle($request);
}

// Kelas ConcreteHandler untuk Validasi
class ValidateRequestHandler extends Handler {
    public function handle($request) {
        if (isset($request['nama_member']) && isset($request['telp_member'])) {
            if ($this->nextHandler) {
                return $this->nextHandler->handle($request);
            }
        } else {
            echo "Validasi gagal: Data tidak lengkap.";
            return false;
        }
    }
}

// Kelas ConcreteHandler untuk Update Database
class UpdateDatabaseHandler extends Handler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handle($request) {
        $id_member = $request['idpelanggan'];
        $nama = $request['nama_member'];
        $telp_member = $request['telp_member'];

        $query = "UPDATE pelanggan SET nama = '$nama', telp = '$telp_member' WHERE idpelanggan ='$id_member'";
        $execute = bisa($this->conn, $query);

        if ($execute == 1) {
            $success = 'true';
            $title = 'Berhasil';
            $message = 'Berhasil mengubah pelanggan';
            $type = 'success';
            header('location: pelanggan.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
            exit(); // Pastikan script berhenti setelah redirect
        } else {
            echo "Gagal Tambah Data";
        }
    }
}

// Main Logic
$id_member = $_GET['idpelanggan'];
$queryedit = "SELECT * FROM pelanggan WHERE idpelanggan = '$id_member'";
$edit = ambilsatubaris($conn, $queryedit);

// Setup Chain of Responsibility
$validateHandler = new ValidateRequestHandler();
$updateHandler = new UpdateDatabaseHandler($conn);

$validateHandler->setNext($updateHandler);

if (isset($_POST['btn-simpan'])) {
    $request = [
        'idpelanggan' => $id_member,
        'nama_member' => $_POST['nama_member'],
        'telp_member' => $_POST['telp_member']
    ];
    $validateHandler->handle($request);
}

require 'layout_header.php';
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Pelanggan</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php">Pelanggan</a></li>
                <li><a href="#">Tambah Pelanggan</a></li>
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
                    <label>Nama Member</label>
                    <input type="text" name="nama_member" class="form-control" value="<?= htmlspecialchars($edit['nama']) ?>">
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="telp_member" class="form-control" value="<?= htmlspecialchars($edit['telp']) ?>">
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

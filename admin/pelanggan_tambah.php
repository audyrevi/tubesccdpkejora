<?php
// Flyweight class for form elements
class FormElement {
    private $type;
    private $label;
    private $name;

    public function __construct($type, $label, $name) {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
    }

    public function render() {
        return '
        <div class="form-group">
            <label>' . $this->label . '</label>
            <input type="' . $this->type . '" name="' . $this->name . '" class="form-control">
        </div>';
    }
}

// Flyweight Factory for form elements
class FormElementFactory {
    private $elements = [];

    public function getElement($type, $label, $name) {
        $key = md5($type . $label . $name);
        if (!isset($this->elements[$key])) {
            $this->elements[$key] = new FormElement($type, $label, $name);
        }
        return $this->elements[$key];
    }
}

// Initialize Flyweight Factory
$formElementFactory = new FormElementFactory();

$title = 'pelanggan';
require 'functions.php';

if (isset($_POST['btn-simpan'])) {
    $id_member = $_POST['id_member'];
    $nama = $_POST['nama_member'];
    $telp_member = $_POST['telp_member'];
    $query = "INSERT INTO pelanggan (idpelanggan, nama, telp) values ('$id_member', '$nama', '$telp_member')";

    $execute = bisa($conn, $query);
    if ($execute == 1) {
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil menambahkan ' . $role . ' baru';
        $type = 'success';
        header('location: pelanggan.php?crud=' . $success . '&msg=' . $message . '&type=' . $type . '&title=' . $title);
    } else {
        echo "Gagal Tambah Data";
    }
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
                    <?= $formElementFactory->getElement('text', 'Kode Pelanggan', 'id_member')->render(); ?>
                    <?= $formElementFactory->getElement('text', 'Nama Pelanggan', 'nama_member')->render(); ?>
                    <?= $formElementFactory->getElement('text', 'No Telepon', 'telp_member')->render(); ?>
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

<?php
// Interface FormComponent
interface FormComponent {
    public function render();
}

// Kelas dasar Form yang mengimplementasikan interface FormComponent
class Form implements FormComponent {
    protected $action;
    protected $method;

    public function __construct($action, $method = "post") {
        $this->action = $action;
        $this->method = $method;
    }

    public function render() {
        return '<form method="' . $this->method . '" action="' . $this->action . '">';
    }
}

// Kelas decorator dasar yang mengimplementasikan interface FormComponent
class FormDecorator implements FormComponent {
    protected $form;

    public function __construct(FormComponent $form) {
        $this->form = $form;
    }

    public function render() {
        return $this->form->render();
    }
}

// Kelas decorator konkret untuk menambahkan input field
class InputFieldDecorator extends FormDecorator {
    private $name;
    private $type;
    private $label;
    private $class;

    public function __construct(FormComponent $form, $name, $type, $label, $class = "form-control") {
        parent::__construct($form);
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->class = $class;
    }

    public function render() {
        return $this->form->render() . '
        <div class="form-group">
            <label>' . $this->label . '</label>
            <input type="' . $this->type . '" name="' . $this->name . '" class="' . $this->class . '">
        </div>';
    }
}

// Kelas decorator konkret untuk menambahkan tombol submit
class SubmitButtonDecorator extends FormDecorator {
    private $label;
    private $class;

    public function __construct(FormComponent $form, $label, $class = "btn btn-primary") {
        parent::__construct($form);
        $this->label = $label;
        $this->class = $class;
    }

    public function render() {
        return $this->form->render() . '
        <div class="text-right">
            <button type="submit" class="' . $this->class . '">' . $this->label . '</button>
        </div>
        </form>';
    }
}

// Kelas decorator konkret untuk menambahkan tombol reset
class ResetButtonDecorator extends FormDecorator {
    private $label;
    private $class;

    public function __construct(FormComponent $form, $label, $class = "btn btn-danger") {
        parent::__construct($form);
        $this->label = $label;
        $this->class = $class;
    }

    public function render() {
        return $this->form->render() . '
        <div class="text-right">
            <button type="reset" class="' . $this->class . '">' . $this->label . '</button>
        </div>';
    }
}

// Implementasi form dengan decorator
$form = new Form("");
$form = new InputFieldDecorator($form, "idpegawai", "text", "Kode Pegawai");
$form = new InputFieldDecorator($form, "nama", "text", "Nama Pegawai");
$form = new InputFieldDecorator($form, "telp", "text", "Telp");
$form = new InputFieldDecorator($form, "username", "text", "Username");
$form = new InputFieldDecorator($form, "password", "password", "Password");
$form = new ResetButtonDecorator($form, "Reset");
$form = new SubmitButtonDecorator($form, "Simpan");

$title = 'pengguna';
require 'functions.php';
if (isset($_POST['btn-simpan'])) {
    $id = $_POST['idpegawai'];
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $username = $_POST['username'];
    $pass = md5($_POST['password']);
    $query = "INSERT INTO pegawai (idpegawai, nama, telp, username, password) values ('$id', '$nama', '$telp', '$username', '$pass')";
    $execute = bisa($conn, $query);
    if ($execute == 1) {
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil menambahkan ' . $role . ' baru';
        $type = 'success';
        header('location: pengguna.php?crud=' . $success . '&msg=' . $message . '&type=' . $type . '&title=' . $title);
    } else {
        echo "Gagal Tambah Data";
    }
}

require 'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master Pengguna</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php">Pengguna</a></li>
                <li><a href="#">Tambah Pengguna</a></li>
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
                <?= $form->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout_footer.php';
?>

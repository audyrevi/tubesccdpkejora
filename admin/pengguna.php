<?php
$title = 'pengguna';
require 'functions.php';
require 'layout_header.php';

class EmployeePrototype {
    private $id;
    private $name;
    private $phone;
    private $username;
    private $password;

    public function __construct($id, $name, $phone, $username, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
}

// Kelas Builder untuk tabel pegawai
class EmployeeBuilder {
    private $employees;

    public function __construct($employees) {
        $this->employees = $employees;
    }

    public function buildTable() {
        $tableHtml = '<div class="table-responsive">';
        $tableHtml .= '<table class="table table-bordered thead-dark" id="table">';
        $tableHtml .= '<thead class="thead-dark">';
        $tableHtml .= '<tr><th width="5%">No</th><th>Kode Pegawai</th><th>Nama</th><th>Telp</th><th>Username</th><th>Password</th><th width="15%">Aksi</th></tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody>';

        foreach ($this->employees as $index => $employee) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . ($index + 1) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($employee->getId()) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($employee->getName()) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($employee->getPhone()) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($employee->getUsername()) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($employee->getPassword()) . '</td>';
            $tableHtml .= '<td align="center">';
            $tableHtml .= '<div class="btn-group" role="group" aria-label="Basic example">';
            $tableHtml .= '<a href="pengguna_edit.php?idpegawai=' . htmlspecialchars($employee->getId()) . '" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-success"><i class="fa fa-edit"></i></a>';
            $tableHtml .= '<a href="pengguna_hapus.php?idpegawai=' . htmlspecialchars($employee->getId()) . '" onclick="return confirm(\'Yakin hapus data ? \');" data-toggle="tooltip" data-placement="bottom" title="Hapus" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
            $tableHtml .= '</div></td></tr>';
        }

        $tableHtml .= '</tbody></table></div>';

        return $tableHtml;
    }
}

// Main Script
$title = 'pengguna';

// Koneksi ke database
$db = dbConnect();
$sql = 'SELECT * FROM pegawai ORDER BY idpegawai';
$res = $db->query($sql);

// Fetch data
$data = $res->fetch_all(MYSQLI_ASSOC);
$employees = [];
foreach ($data as $row) {
    $employee = new EmployeePrototype($row['idpegawai'], $row['nama'], $row['telp'], $row['username'], $row['password']);
    $employees[] = $employee;
}

// Create the builder
$builder = new EmployeeBuilder($employees);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link rel="stylesheet" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/login/css/util.css">
    <link rel="stylesheet" href="assets/login/css/main.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Data Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                <li><a href="#">Pegawai</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="pengguna_tambah.php" class="btn btn-primary box-title"><i class="fa fa-plus fa-fw"></i> Tambah</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <button id="btn-refresh" class="btn btn-primary box-title text-right" title="Refresh Data"><i class="fa fa-refresh" id="ic-refresh"></i></button>
                        </div>
                    </div>
                    <?php echo $builder->buildTable(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php require 'layout_footer.php'; ?>
</body>
</html>

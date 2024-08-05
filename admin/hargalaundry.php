<?php
require 'functions.php';
require 'layout_header.php';

// Antarmuka Produk
interface Table {
    public function buildTable(): string;
}

// Kelas Produk Konkret
class LaundryTable implements Table {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function buildTable(): string {
        $tableHtml = '<div class="table-responsive">';
        $tableHtml .= '<table class="table table-bordered thead-dark" id="table">';
        $tableHtml .= '<thead class="thead-dark">';
        $tableHtml .= '<tr><th>No</th><th>Kode Laundry</th><th>Jenis Laundry</th><th>Harga</th><th width="15%">Aksi</th></tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody>';

        foreach ($this->data as $index => $paket) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . ($index + 1) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($paket['kodelaundry']) . '</td>';
            $tableHtml .= '<td>' . htmlspecialchars($paket['jenislaundry']) . '</td>';
            $tableHtml .= '<td>' . 'Rp' . htmlspecialchars($paket['harga']) . '</td>';
            $tableHtml .= '<td align="center">';
            $tableHtml .= '<div class="btn-group" role="group" aria-label="Basic example">';
            $tableHtml .= '<a href="hargalaundry_edit.php?kodelaundry=' . htmlspecialchars($paket['kodelaundry']) . '" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-success"><i class="fa fa-edit"></i></a>';
            $tableHtml .= '<a href="hargalaundry_hapus.php?kodelaundry=' . htmlspecialchars($paket['kodelaundry']) . '" onclick="return confirm(\'Yakin hapus data ? \');" data-toggle="tooltip" data-placement="bottom" title="Hapus" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
            $tableHtml .= '</div></td></tr>';
        }

        $tableHtml .= '</tbody></table></div>';

        return $tableHtml;
    }
}

// Antarmuka Factory
interface TableFactory {
    public function createTable($data): Table;
}

// Kelas Factory Konkret
class LaundryTableFactory implements TableFactory {
    public function createTable($data): Table {
        return new LaundryTable($data);
    }
}

// Main Script
$title = 'hargalaundry';

// Koneksi ke database
$db = dbConnect();
$sql = 'SELECT * FROM hargalaundry';
$res = $db->query($sql);
$data = $res->fetch_all(MYSQLI_ASSOC);

// Buat instance Factory dan Table
$factory = new LaundryTableFactory();
$table = $factory->createTable($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master <?= htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/login/css/util.css">
    <link rel="stylesheet" href="assets/login/css/main.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Data Harga Laundry</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="#">Jenis Laundry</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="hargalaundry_tambah.php" class="btn btn-primary box-title"><i class="fa fa-plus fa-fw"></i> Tambah</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <button id="btn-refresh" class="btn btn-primary box-title text-right" title="Refresh Data"><i class="fa fa-refresh" id="ic-refresh"></i></button>
                        </div>
                    </div>
                    <?php echo $table->buildTable(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php require 'layout_footer.php'; ?>
</body>
</html>

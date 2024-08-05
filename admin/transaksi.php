<?php
$title = 'transaksi';
require 'layout_header.php';

// Subject interface
interface DatabaseInterface {
    public function query($sql);
}

// RealSubject
class RealDatabase implements DatabaseInterface {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "laundry");
    }

    public function query($sql) {
        return $this->db->query($sql);
    }
}

// Proxy
class DatabaseProxy implements DatabaseInterface {
    private $realDatabase;

    public function query($sql) {
        if ($this->realDatabase == null) {
            $this->realDatabase = new RealDatabase();
        }
        return $this->realDatabase->query($sql);
    }
}

// Function to get the database connection via proxy
function dbConnect() {
    return new DatabaseProxy();
}

$db = dbConnect();
$sql = "SELECT transaksi.nonota, transaksi.tglmsk, transaksi.tglsls, transaksi.kg, hargalaundry.harga * kg as ttlharga, transaksi.ket, pelanggan.nama, hargalaundry.jenislaundry FROM transaksi LEFT JOIN pelanggan ON transaksi.idpelanggan = pelanggan.idpelanggan LEFT JOIN hargalaundry ON transaksi.kodelaundry = hargalaundry.kodelaundry";
$res = $db->query($sql);
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master <?= $title ?></h4> 
        </div>
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
                        <a href="transaksi_tambah.php" class="btn btn-primary box-title"><i class="fa fa-plus fa-fw"></i> Tambah</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button id="btn-refresh" class="btn btn-primary box-title text-right" title="Refresh Data"><i class="fa fa-refresh" id="ic-refresh"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered thead-dark" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>No Nota</th>
                                <th>Tgl Msk</th>
                                <th>Tgl Selesai</th>
                                <th>Nama Pelanggan</th>
                                <th>Jenis Laundry</th>
                                <th>Kg</th>
                                <th>Total Harga</th>
                                <th>Ket</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $data = $res->fetch_all(MYSQLI_ASSOC);
                        foreach ($data as $transaksi): ?>
                            <tr>
                                <td></td>
                                <td><?php echo $transaksi['nonota'] ?></td>
                                <td><?php echo $transaksi['tglmsk'] ?></td>
                                <td><?php echo $transaksi['tglsls'] ?></td>
                                <td><?php echo $transaksi['nama'] ?></td>
                                <td><?php echo $transaksi['jenislaundry'] ?></td>
                                <td><?php echo $transaksi['kg'] ?></td>
                                <td><?php echo "Rp".$transaksi['ttlharga'] ?></td>
                                <td><?php echo $transaksi['ket'] ?></td>
                                <td align="center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="transaksi_edit.php?nonota=<?php echo $transaksi['nonota']; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout_footer.php';
?>

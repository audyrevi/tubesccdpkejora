<?php
$title = 'pelanggan';
require 'layout_header.php';

// Object Pool for Database Connections
class DatabasePool {
    private static $instance;
    private $pool;
    private $maxPoolSize = 5;

    private function __construct() {
        $this->pool = new SplQueue();
        for ($i = 0; $i < $this->maxPoolSize; $i++) {
            $this->pool->enqueue(new mysqli("localhost", "root", "", "laundry"));
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabasePool();
        }
        return self::$instance;
    }

    public function getConnection() {
        if ($this->pool->isEmpty()) {
            return new mysqli("localhost", "root", "", "laundry");
        } else {
            return $this->pool->dequeue();
        }
    }

    public function releaseConnection($connection) {
        if ($this->pool->count() < $this->maxPoolSize) {
            $this->pool->enqueue($connection);
        } else {
            $connection->close();
        }
    }
}

function dbConnect() {
    $dbPool = DatabasePool::getInstance();
    return $dbPool->getConnection();
}

$db = dbConnect();
$sql = 'SELECT * FROM pelanggan';
$res = $db->query($sql);
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Pelanggan</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Pelanggan</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-6">
                        <a href="pelanggan_tambah.php" class="btn btn-primary box-title"><i class="fa fa-plus fa-fw"></i> Tambah</a>
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
                                <th width="5%">Kode Pelanggan</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $data = $res->fetch_all(MYSQLI_ASSOC);
                        foreach ($data as $member): ?>
                            <tr>
                                <td></td>
                                <td><?php echo $member['idpelanggan'] ?></td>
                                <td><?php echo $member['nama'] ?></td>
                                <td><?php echo $member['telp'] ?></td>
                                <td align="center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="pelanggan_edit.php?idpelanggan=<?php echo $member['idpelanggan']; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="pelanggan_hapus.php?idpelanggan=<?php echo $member['idpelanggan']; ?>" onclick="return confirm('Yakin hapus data ? ');" data-toggle="tooltip" data-placement="bottom" title="Hapus" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
// Release the database connection back to the pool
DatabasePool::getInstance()->releaseConnection($db);
require 'layout_footer.php';
?>

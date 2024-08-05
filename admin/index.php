<?php
$title = 'dashboard';
require 'functions.php';
require 'layout_header.php';
require 'component.php'; // File yang berisi interface dan kelas-kelas di atas

$jTransaksi = ambilsatubaris($conn, 'SELECT COUNT(nonota) as jumlahtransaksi FROM transaksi');
$jPelanggan = ambilsatubaris($conn, 'SELECT COUNT(idpelanggan) as jumlahmember FROM pelanggan');
$query = "SELECT transaksi.nonota, pelanggan.nama, transaksi.totalharga, transaksi.ket FROM transaksi LEFT JOIN pelanggan ON transaksi.idpelanggan=pelanggan.idpelanggan LEFT JOIN hargalaundry ON transaksi.kodelaundry=hargalaundry.kodelaundry ORDER BY transaksi.nonota DESC LIMIT 10";
$data = ambildata($conn, $query);

// Create Leaf instances
$pelanggan = new Pelanggan($jPelanggan['jumlahmember']);
$transaksi = new Transaksi($jTransaksi['jumlahtransaksi']);

// Create Composite instance
$dashboard = new Dashboard();
$dashboard->add($pelanggan);
$dashboard->add($transaksi);
?>

<?= $dashboard->render(); ?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <h3 class="box-title">10 Transaksi Terbaru</h3>
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Nota</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Harga</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $transaksi): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($transaksi['nonota']); ?></td>
                                <td><?= htmlspecialchars($transaksi['nama']); ?></td>
                                <td><?= "Rp".htmlspecialchars($transaksi['totalharga']); ?></td>
                                <td><?= htmlspecialchars($transaksi['ket']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
require 'layout_footer.php';
?>

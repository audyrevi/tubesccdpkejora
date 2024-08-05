<?php
// hargalaundry_hapus.php

// Interface Strategi
interface DatabaseStrategy {
    public function execute($db, $query);
}

// Implementasi Strategi Konkrit untuk Hapus
class DeleteStrategy implements DatabaseStrategy {
    public function execute($db, $query) {
        $res = $db->query($query);
        if ($res) {
            return $db->affected_rows > 0;
        }
        return false;
    }
}

// Kelas Context untuk Strategi
class DatabaseContext {
    private $strategy;

    public function __construct(DatabaseStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy(DatabaseStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function performOperation($db, $query) {
        return $this->strategy->execute($db, $query);
    }
}

// Fungsi untuk koneksi database
function dbConnect() {
    $db = new mysqli("localhost", "root", "", "laundry");
    if ($db->connect_error) {
        die("Koneksi gagal: " . $db->connect_error);
    }
    return $db;
}

// Koneksi database
$db = dbConnect();
$kode = $db->escape_string($_GET["kodelaundry"]);

// Susun query delete
$sql = "DELETE FROM hargalaundry WHERE kodelaundry='$kode'";

// Buat objek strategi dan konteks
$strategy = new DeleteStrategy();
$context = new DatabaseContext($strategy);

// Eksekusi operasi
if ($context->performOperation($db, $sql)) {
    $success = 'true';
    $title = 'Berhasil';
    $message = 'Menghapus Data';
    $type = 'success';
    header('location: hargalaundry.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
} else {
    echo "Gagal Menghapus Data";
}
?>
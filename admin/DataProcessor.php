<?php
// DataProcessor.php
require_once 'AbstractDataProcessor.php';

class DataProcessor extends AbstractDataProcessor {
    private $kode;
    private $jenis_laundry;
    private $harga;

    public function __construct($conn, $kode, $jenis_laundry, $harga) {
        parent::__construct($conn);
        $this->kode = stripslashes($kode);
        $this->jenis_laundry = stripslashes($jenis_laundry);
        $this->harga = stripslashes($harga);
    }

    // Overriding validate method if needed
    protected function validate() {
        // Perform custom validation if needed
        return !empty($this->kode) && !empty($this->jenis_laundry) && !empty($this->harga);
    }

    // Implement the save method
    protected function save() {
        $query = "INSERT INTO hargalaundry (kodelaundry, jenislaundry, harga) VALUES ('$this->kode', '$this->jenis_laundry', '$this->harga')";
        return bisa($this->conn, $query);
    }
}
?>
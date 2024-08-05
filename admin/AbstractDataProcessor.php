<?php
// AbstractDataProcessor.php

abstract class AbstractDataProcessor {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Template method
    public function process() {
        if ($this->validate()) {
            if ($this->save()) {
                $this->onSuccess();
            } else {
                $this->onFailure();
            }
        } else {
            $this->onValidationFailure();
        }
    }

    // Step 1: Validation - Can be overridden
    protected function validate() {
        return true;
    }

    // Step 2: Save - To be implemented by concrete class
    abstract protected function save();

    // Step 3: Success handler
    protected function onSuccess() {
        header('location: hargalaundry.php?crud=true&msg=Berhasil Simpan Data&type=success&title=Berhasil');
        exit;
    }

    // Step 4: Failure handler
    protected function onFailure() {
        echo "Gagal Tambah Data";
        exit;
    }

    // Step 5: Validation failure handler
    protected function onValidationFailure() {
        echo "Validation Failed";
        exit;
    }
}
?>
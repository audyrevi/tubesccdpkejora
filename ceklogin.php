<?php
function dbConnect(){
	$db=new mysqli("localhost","root","","laundry");
	return $db;
}
$db = dbConnect();
$username = stripslashes($_POST['username']);
$password = md5($_POST['password']);
$sql = "SELECT * FROM pegawai where username='$username' AND password = '$password'";

$res = $db->query($sql);
if ($res) {
if ($res->num_rows == 1) {
$data = $res->fetch_assoc();
session_start();
        $_SESSION['username'] = $data['username'];
        $_SESSION['idpegawai'] = $data['idpegawai'];
        $_SESSION['nama'] = $data['nama'];
        header('location:admin');
    }
else{
    $msg = 'Username Atau Password Salah';
    header('location:index.php?msg='.$msg);
}
}
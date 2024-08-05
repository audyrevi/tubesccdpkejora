<?php 
function dbConnect(){
	$db=new mysqli("localhost","root","","laundry");
	return $db;
}
$db = dbConnect();
$kode  =$db->escape_string($_GET["idpegawai"]);
		// Susun query delete
		$sql="DELETE FROM pegawai WHERE idpegawai='$kode'";
		// Eksekusi query delete
		$res=$db->query($sql);
        if($res){
			if($db->affected_rows>0)
	$success = 'true';
    $title = 'Berhasil';
    $message = 'Menghapus Data';
    $type = 'success';
    header('location: pengguna.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
}


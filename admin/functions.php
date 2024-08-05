<?php 

$conn = mysqli_connect('localhost','root','','laundry');

function dbConnect(){
	$db=new mysqli("localhost","root","","laundry");
	return $db;
}

function ambildata($conn,$query){
    $data = mysqli_query($conn,$query);
    if (mysqli_num_rows($data) > 0) {
        while($row = mysqli_fetch_assoc($data)){
        $hasil[] = $row;
    }

    return $hasil;
    }
}

function bisa($conn,$query){
    $db = mysqli_query($conn,$query);

    if($db){
        return 1;
    }else{
        return 0;
    }
}

function totalharga(){
    $db=dbConnect();
	if($db->connect_errno==0){
        $res=$db->query("SELECT totalharga * kg as total_harga from transaksi");}
}

function ambilsatubaris($conn,$query){
    $db = mysqli_query($conn,$query);
    return mysqli_fetch_assoc($db);
}

function hapus($where,$table,$redirect){
    $query = 'DELETE FROM ' . $table . ' WHERE ' . $where;
    echo $query;
}

function getListLaundry(){
    $db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
						 FROM hargalaundry
						 ORDER BY kodelaundry");
		if($res){
			$data=$res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}

function getListPegawai(){
    $db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
						 FROM pegawai
						 ORDER BY idpegawai");
		if($res){
			$data=$res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}

function getListPelanggan(){
    $db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
						 FROM pelanggan
						 ORDER BY idpelanggan");
		if($res){
			$data=$res->fetch_all(MYSQLI_ASSOC);
			$res->free();
			return $data;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}
?>
<?php
    include "koneksi.php";

    if (isset($_POST['nim'])) {
    
    $nim = $_POST['nim'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE nim='$nim'");
    if($row = mysqli_fetch_assoc($query)){
        $data['nim'] = $row['nim'];
        $data['nama'] = $row['nama'];   
        $data['email'] = $row['email'];
        $data['nohp'] = $row['no_hp'];
        $data['alamat'] = $row['alamat'];
        if($row['jenis_kelamin']=='l') $data['jenis_kelamin'] = "Laki-laki";
        else $data['jenis_kelamin'] = "Perempuan";
        $data['pic'] = $row['pic'];
        echo json_encode($data);
    }else{
        echo "<script>swal('JSON ERROR', '', 'error')</script>";
    }
    }
?>
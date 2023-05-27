<?php
    include "koneksi.php";

    if (isset($_POST['id_peminjaman'])) {
    
    $id_peminjaman = $_POST['id_peminjaman'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM peminjaman JOIN buku ON peminjaman.id_buku = buku.id_buku JOIN anggota ON peminjaman.nim=anggota.nim WHERE id_peminjaman='$id_peminjaman'");
    if($row = mysqli_fetch_assoc($query)){
        $data['id_peminjaman'] = $row['id_peminjaman'];
        $data['buku'] = $row['id_buku']." - ".$row['judul'];   
        $data['anggota'] = $row['nim']." - ".$row['nama'];   
        $data['tanggal_pinjam'] = $row['tanggal_pinjam'];
        $data['tanggal_kembali'] = $row['tanggal_kembali'];
        $data['denda'] = $row['denda'];
        $data['status'] = $row['status'];
        if($data['status']=="done"){
            $data['badge'] = "badge badge-success";
        }elseif($data['status']=="process"){
            $data['badge']="badge badge-primary";
        }else{
            $data['badge']="badge badge-warning";
        }
        echo json_encode($data);
    }else{
        echo "<script>swal('JSON ERROR', '', 'error')</script>";
    }
    }
?>
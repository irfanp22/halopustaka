<?php
    include "koneksi.php";

    if (isset($_POST['id_buku'])) {
    
    $id_buku = $_POST['id_buku'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM buku JOIN kategori ON buku.id_kategori = kategori.id_kategori JOIN rak ON buku.id_rak = rak.id_rak WHERE id_buku='$id_buku'");
    if($row = mysqli_fetch_assoc($query)){
        $data['id_buku'] = $row['id_buku'];
        $data['isbn'] = $row['isbn'];   
        $data['judul'] = $row['judul'];
        $data['kategori'] = $row['id_kategori']." - ".$row['nama_kategori'];
        $data['rak'] = $row['id_rak']." - ".$row['nama_rak'];
        $data['pengarang'] = $row['pengarang'];
        $data['penerbit'] = $row['penerbit'];
        $data['thnterbit'] = $row['tahun_terbit'];
        $data['stok'] = $row['stok'];
        $sedia = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_buku) AS sedia FROM peminjaman WHERE status != 'done'"));
        $data['sedia'] = $row['stok'] - $sedia['sedia'];
        $data['keterangan'] = $row['keterangan'];
        $data['jilid'] = $row['pic'];
        echo json_encode($data);
    }else{
        echo "<script>swal('JSON ERROR', '', 'error')</script>";
    }
    }
?>
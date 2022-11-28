<?php
    include "koneksi.php";

    if (isset($_POST['id_buku'])) {
    
    $id_buku = $_POST['id_buku'];
    $nim = $_POST['nim'];

    $query = mysqli_query($koneksi, "INSERT INTO peminjaman(id_buku, nim, tanggal_pinjam, status) VALUES('$id_buku', '$nim', CURRENT_DATE, 'book')");
    if(mysqli_affected_rows($koneksi)){
        echo "fin";
    }else{
        echo "<script>swal('ERROR', '', 'error')</script>";
    }
    }
?>
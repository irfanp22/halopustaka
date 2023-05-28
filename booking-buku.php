<?php
include "koneksi.php";

include "trigger.php";
if (isset($_POST['id_buku'])) {

    $id = before_insert_peminjaman();
    $id_buku = $_POST['id_buku'];
    $nim = $_POST['nim'];

    $tgl = date('Y-m-d H:i:s');
    $query = mysqli_query($koneksi, "INSERT INTO peminjaman(id_peminjaman, id_buku, nim, tanggal_pinjam, status) VALUES('$id', '$id_buku', '$nim', '$tgl', 'book')");
    if (mysqli_affected_rows($koneksi)) {
        echo "fin";
    } else {
        echo "<script>swal('ERROR', '', 'error')</script>";
    }
}
?>
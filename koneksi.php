<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_hp";

$koneksi = mysqli_connect($host, $user, $password, $database);
error_reporting(E_ALL ^ E_DEPRECATED && E_NOTICE);
date_default_timezone_set("Asia/Jakarta");

$query = mysqli_query($koneksi, "SELECT id_peminjaman, tanggal_pinjam, tanggal_kembali FROM peminjaman WHERE status ='book'");
while ($row = mysqli_fetch_array($query)) {
    $tgl1 = date_create($row['tanggal_pinjam']);
    $tgl2 = date_create($row['tanggal_kembali']);
    $range = date_diff($tgl1, $tgl2);
    if ($range->format('%a') == 1) {
        $id = $row['id_peminjaman'];
        mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id_peminjaman='$id'");
    }
}
?>
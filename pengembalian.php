<?php
include "koneksi.php";

if(isset($_POST['id_kem'])){
    $id = $_POST['id_kem'];
    $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman='$id'"));
    $denda = $_POST['dendaplus'];
    $kembali = date_create(date("Y-m-d"));
    $pinjam = date_create($data['tanggal_pinjam']);
    $rentang = date_diff($kembali, $pinjam);
    if(($rentang->format("%a"))>7){
        $denda = $denda + ($rentang->format("%a") * 1000);
    }
    $respone['msg'] = mysqli_query($koneksi, "UPDATE peminjaman SET tanggal_kembali = CURRENT_DATE, status = 'done', denda = '$denda' WHERE id_peminjaman = '$id'");

    echo json_encode($respone);
}
?>
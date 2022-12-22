<?php
include "koneksi.php";

if(isset($_GET['tahun'])){
    $tahun = $_GET['tahun'];
    for($i=1; $i<=12; $i++){
        $query = mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjam, SUM(denda) AS denda FROM peminjaman WHERE MONTH(tanggal_pinjam) = $i AND YEAR(tanggal_pinjam) = $tahun");
        if($row = mysqli_fetch_assoc($query)){
            $data['bulan'.$i] = $row['pinjam'];
            $data['denda'.$i] = $row['denda'];
        }
    }
    echo json_encode($data);
}
?>
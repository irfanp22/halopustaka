<?php
function id_buku_auto($num)
{
    $kodebaru = '';
    $urut = 0;

    $urut = $num === null ? 1 : $num + 1;
    $kodebaru = "BK" . str_pad($urut, 3, '0', STR_PAD_LEFT);

    return $kodebaru;
}

function id_kategori_auto($num)
{
    $kodebaru = '';
    $urut = 0;

    $urut = $num === null ? 1 : $num + 1;
    $kodebaru = "KT" . str_pad($urut, 3, '0', STR_PAD_LEFT);

    return $kodebaru;
}

function id_peminjaman_auto($num)
{
    $kodebaru = '';
    $urut = 0;

    $urut = $num === null ? 1 : $num + 1;
    $kodebaru = "PJ" . str_pad($urut, 5, '0', STR_PAD_LEFT);

    return $kodebaru;
}

function id_pengurus_auto($num)
{
    $kodebaru = '';
    $urut = 0;

    $urut = $num === null ? 1 : $num + 1;
    $kodebaru = "PG" . str_pad($urut, 3, '0', STR_PAD_LEFT);

    return $kodebaru;
}

function before_insert_buku()
{
    $s = '';
    $i = 0;

    include "koneksi.php";
    $query = "SELECT SUBSTRING(id_buku, 3, 3) AS num FROM buku ORDER BY num DESC LIMIT 1";
    $i = mysqli_query($koneksi, $query);
    $i = mysqli_fetch_array($i);

    $s = id_buku_auto($i['num']);

    $newIdBuku = $s;

    return $newIdBuku;
}

function before_insert_kategori()
{
    $s = '';
    $i = 0;

    include "koneksi.php";
    $query = "SELECT SUBSTRING(id_kategori, 3, 3) AS num FROM kategori ORDER BY num DESC LIMIT 1";
    $i = mysqli_query($koneksi, $query);
    $i = mysqli_fetch_array($i);

    $s = id_kategori_auto($i['num']);

    $newIdKategori = $s;

    return $newIdKategori;
}

function before_insert_peminjaman()
{
    $s = '';
    $i = 0;

    include "koneksi.php";
    $query = "SELECT SUBSTRING(id_peminjaman, 3, 5) AS num FROM peminjaman ORDER BY num DESC LIMIT 1";
    $i = mysqli_query($koneksi, $query);
    $i = mysqli_fetch_array($i);

    $s = id_peminjaman_auto($i['num']);

    $newIdPeminjaman = $s;

    return $newIdPeminjaman;
}

function before_insert_pengurus()
{
    $s = '';
    $i = 0;

    include "koneksi.php";
    $query = "SELECT SUBSTRING(id_pengurus, 3, 3) AS num FROM pengurus ORDER BY num DESC LIMIT 1";
    $i = mysqli_query($koneksi, $query);
    $i = mysqli_fetch_array($i);

    $s = id_pengurus_auto($i['num']);

    $newIdPengurus = $s;

    return $newIdPengurus;
}


?>
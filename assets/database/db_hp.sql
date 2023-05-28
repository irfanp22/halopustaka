-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 28 Bulan Mei 2023 pada 07.36
-- Versi server: 10.11.3-MariaDB
-- Versi PHP: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `nim` char(9) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `pic` varchar(50) NOT NULL DEFAULT 'anggota/mhs.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`nim`, `nama`, `password`, `email`, `no_hp`, `alamat`, `jenis_kelamin`, `pic`) VALUES
('H1D021043', 'Irfan Priatna', '$2y$10$ghjaMzFBi0EqOeytCUEvh.j4LWL1OXGt0jlF80raA64x8Xw0bTgte', 'irfan.priatna@mhs.unsoed.ac.id', '0895375115609', 'Ciamis', 'l', 'anggota/H1D021043.jpg'),
('H1D021111', 'djoko sasana', '$2y$10$0qTCuvDRF8shufJVKfO9Fe4A7Dh5.eEYltpsHkD4hVGHrSnDYkiam', 'irfanpriatna22@gmail.com', '081223224225', 'Jalan In Aja No.333', 'l', 'anggota/H1D021111.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` char(5) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_kategori` char(5) NOT NULL,
  `id_rak` char(5) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `stok` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pic` varchar(50) NOT NULL DEFAULT 'buku/buku.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `id_kategori`, `id_rak`, `isbn`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `keterangan`, `pic`) VALUES
('BK001', 'Membuat berbagai DVD-Video dengan Ulead Video Studio 9', 'KT002', 'NF001', '979-20-8027-9', 'Ian Chandra K', 'Elex Media Komputindo', '2006', 2, 'vii, 252 hlm. : ilus. ; 21 cm.', 'buku/BK001.jpg'),
('BK002', 'Manusia stoik : sebuah obat depresi dan penawar ekspektasi yang terlalu tinggi', 'KT002', 'NF001', '978-623-400-185-3', 'Dewi Indra P. (penulis) Herman Adamson (penyunting)', 'Psikologi Corner', '2022', 5, 'xxv, 230 halaman : ilustrasi 20 cm', 'buku/BK002.jpg'),
('BK003', 'Suluh-suluh revolusi', 'KT001', 'NV001', '978-623-95424-7-4', 'Ridjaluddin Shar (penulis) Damhuri Muhammad (editor)', 'Beranda', '2022', 4, 'x, 458 halaman : ilustrasi ; 23 cm', 'buku/BK003.jpg'),
('BK004', 'Algoritma dan pemrograman dalam bahasa Java', 'KT002', 'NF001', '978-979-756-576-3', 'F.X. Wisnu Yudo Untoro', 'Graha Ilmu', '2010', 1, 'xv, 278 hlm. ; 22 cm.', 'buku/buku.jpg'),
('BK005', 'Modul Pembelajaran Pemrograman Berorientasi Objek : dengan bahasa pemrograman C++, PHP, dan Java', 'KT002', 'NF001', '978-602-8759-07-6', 'Rosa A.S., M. Shalahuddin', 'Modula', '2016', 3, 'xii, 290 halaman : ilustrasi ; 23 cm', 'buku/buku.jpg'),
('BK006', 'Dasar pemrograman web dengan PHP', 'KT002', 'NF001', '978-602-453-396-0', 'Canggih Ajika Pamungkas', 'Deepublish', '2017', 4, 'x, 92 halaman : ilustrasi ; 20 cm', 'buku/BK006.jpg'),
('BK007', 'Esok bersamamu', 'KT003', 'FK001', '978-623-306-432-3', 'Artsymiia. 1992- (penulis) Lulu Latifah (editor)', 'AE Publishing', '2021', 6, 'ii, 322 halaman ; 20 cm', 'buku/buku.jpg'),
('BK008', 'Hujan tanpa suara : ketika aku merindukanmu, dengan kerinduan yang meremas-remas kalbu', 'KT001', 'NV001', '978-623-6439-96-8', 'Nailin RA (penulis) Tim CMG (editor)', 'Catur Media Gemilang', '2022', 3, '204 hal Ilustrasi 2022', 'buku/BK008.jpg'),
('BK009', 'Juru kunci makam', 'KT003', 'FK001', '-', 'Sinta Yudisia, 1974- (pengarang) Ayu Wulan (penyunting bahasa)', 'Indiva Media Kreasi', '2020', 2, '133 halaman : ilustrasi ; 19 cm', 'buku/buku.jpg'),
('BK010', 'Kartun Kalkulus', 'KT002', 'NF001', '978-602-481-620-9', 'Gonick, Larry (pengarang) Mharta Adji Wardana (penerjemah) Andya Primanda (penyunting)', 'Kepustakaan Populer Gramedia', '2021', 3, 'Xii, 243 halaman : ilustrasi : 23 cm', 'buku/BK010.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` char(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KT001', 'Novel'),
('KT002', 'Non-Fiksi'),
('KT003', 'Fiksi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` char(7) NOT NULL,
  `id_buku` char(5) NOT NULL,
  `nim` char(9) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `denda` int(5) NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `nim`, `tanggal_pinjam`, `tanggal_kembali`, `denda`, `status`) VALUES
('PJ00002', 'BK001', 'H1D021111', '2022-10-02 12:44:33', '2022-10-13 14:05:53', 34000, 'done'),
('PJ00004', 'BK009', 'H1D021043', '2022-10-15 07:15:45', '2022-10-16 08:56:54', 0, 'done'),
('PJ00007', 'BK001', 'H1D021043', '2022-11-02 17:51:59', '2022-11-04 14:52:10', 0, 'done'),
('PJ00009', 'BK002', 'H1D021043', '2022-11-12 10:49:41', '2022-11-24 11:52:25', 5000, 'done'),
('PJ00014', 'BK009', 'H1D021043', '2022-11-28 15:51:36', '2022-12-02 10:53:03', 0, 'done'),
('PJ00015', 'BK002', 'H1D021111', '2023-05-28 11:38:39', NULL, 0, 'process'),
('PJ00016', 'BK010', 'H1D021043', '2023-05-28 11:54:23', NULL, 0, 'process'),
('PJ00017', 'BK001', 'H1D021111', '2023-05-28 12:29:50', NULL, 0, 'process');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengurus`
--

CREATE TABLE `pengurus` (
  `id_pengurus` char(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL,
  `pic` varchar(50) NOT NULL DEFAULT 'pengurus/admin.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengurus`
--

INSERT INTO `pengurus` (`id_pengurus`, `nama`, `password`, `level`, `pic`) VALUES
('PG001', 'Prijatno', '$2y$10$EOCmFf3z4mVqGIddpokmyeb4plfn4Je2be0LUj7LXxFOFxfCiBCve', 'owner', 'pengurus/admin.png'),
('PG002', 'Djoko', '$2y$10$/flqnrdWAWqsWKYNz8nGSeiSilr63/IyP98IpA7sdfck4sH67maJq', 'petugas', 'pengurus/admin.png'),
('PG003', 'zambo', '$2y$10$EK0MAa0SKGBa1tsyLpZEx.sH6BEiqM/magYFxJxwmoQP/Rlns7y/e', 'owner', 'pengurus/PG003.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rak`
--

CREATE TABLE `rak` (
  `id_rak` char(5) NOT NULL,
  `nama_rak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rak`
--

INSERT INTO `rak` (`id_rak`, `nama_rak`) VALUES
('FK001', 'Fiksi 1-100'),
('NF001', 'NonFiksi 1-100'),
('NV001', 'Novel 1-100');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_kategori` (`id_kategori`),
  ADD KEY `fk_rak` (`id_rak`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_buku` (`id_buku`),
  ADD KEY `fk_anggota` (`nim`);

--
-- Indeks untuk tabel `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id_pengurus`);

--
-- Indeks untuk tabel `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2022 at 02:23 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `id_buku_auto` (`num` INT) RETURNS CHAR(5) CHARSET utf8mb4  BEGIN
DECLARE kodebaru CHAR(5);
DECLARE urut INT;
 
SET urut = IF(num IS NULL, 1, num + 1);
SET kodebaru = CONCAT("BK", LPAD(urut, 3, 0));
 
RETURN kodebaru;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `id_kategori_auto` (`num` INT) RETURNS CHAR(5) CHARSET utf8mb4  BEGIN
DECLARE kodebaru CHAR(5);
DECLARE urut INT;
 
SET urut = IF(num IS NULL, 1, num + 1);
SET kodebaru = CONCAT("KT", LPAD(urut, 3, 0));
 
RETURN kodebaru;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `id_peminjaman_auto` (`num` INT) RETURNS CHAR(7) CHARSET utf8mb4  BEGIN
DECLARE kodebaru CHAR(7);
DECLARE urut INT;
 
SET urut = IF(num IS NULL, 1, num + 1);
SET kodebaru = CONCAT("PJ", LPAD(urut, 5, 0));
 
RETURN kodebaru;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `id_pengurus_auto` (`num` INT) RETURNS CHAR(5) CHARSET utf8mb4  BEGIN
DECLARE kodebaru CHAR(5);
DECLARE urut INT;
 
SET urut = IF(num IS NULL, 1, num + 1);
SET kodebaru = CONCAT("PG", LPAD(urut, 3, 0));
 
RETURN kodebaru;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`nim`, `nama`, `password`, `email`, `no_hp`, `alamat`, `jenis_kelamin`, `pic`) VALUES
('H1D021005', 'Alifa Iftithah Z', '$2y$10$d5wvOZ53kSBOz5SPPJjcHOFJrd0uB1DARrJc72vI3vTgxsiw.JOTG', '', '', '', 'p', 'anggota/mhs.png'),
('H1D021008', 'Mila Amelia', '$2y$10$Vk1giW19HR5iX2FOdejuTetIbZ9akfd7y1ZUVaD/rG5gFc1zMG6fK', '', '', '', 'p', 'anggota/mhs.png'),
('H1D021021', 'Annisa Raihan D', '$2y$10$aU30sFKOhVj/fR6PEz9.x.xmrYfZD72tKLQ9YfxBoAHW/4Z8hF1.C', '', '', '', 'p', 'anggota/mhs.png'),
('H1D021043', 'Irfan Priatna', '$2y$10$jVJuRnPvr6/UjWGEuZI94.Nk.mvnOPkmDg1tD4hA8bx4s7XyfolnG', 'irfan.priatna@mhs.unsoed.ac.id', '0895375115609', 'Ciamis', 'l', 'anggota/h1d021043.jpg'),
('H1D021111', 'djoko sasana', '$2y$10$CrBRVpGSM7V5Z2lkTBo5J.z4iJbHvkTfUWXjrK.kkXjws/yHK1E6i', 'irfanpriatna22@gmail.com', '081223224225', 'Jalan In Aja No.333', 'l', 'anggota/H1D021111.png');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
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
) ;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `id_kategori`, `id_rak`, `isbn`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `keterangan`, `pic`) VALUES
('BK001', 'Membuat berbagai DVD-Video dengan Ulead Video Studio 9', 'KT002', 'NF001', '979-20-8027-9', 'Ian Chandra K', 'Elex Media Komputindo', 2006, 2, 'vii, 252 hlm. : ilus. ; 21 cm.', 'buku/BK001.jpg'),
('BK002', 'Manusia stoik : sebuah obat depresi dan penawar ekspektasi yang terlalu tinggi', 'KT002', 'NF001', '978-623-400-185-3', 'Dewi Indra P. (penulis) Herman Adamson (penyunting)', 'Psikologi Corner', 2022, 5, 'xxv, 230 halaman : ilustrasi 20 cm', 'buku/BK002.jpg'),
('BK003', 'Suluh-suluh revolusi', 'KT001', 'NV001', '978-623-95424-7-4', 'Ridjaluddin Shar (penulis) Damhuri Muhammad (editor)', 'Beranda', 2022, 4, 'x, 458 halaman : ilustrasi ; 23 cm', 'buku/BK003.jpg'),
('BK004', 'Algoritma dan pemrograman dalam bahasa Java', 'KT002', 'NF001', '978-979-756-576-3', 'F.X. Wisnu Yudo Untoro', 'Graha Ilmu', 2010, 1, 'xv, 278 hlm. ; 22 cm.', 'buku/buku.jpg'),
('BK005', 'Modul Pembelajaran Pemrograman Berorientasi Objek : dengan bahasa pemrograman C++, PHP, dan Java', 'KT002', 'NF001', '978-602-8759-07-6', 'Rosa A.S., M. Shalahuddin', 'Modula', 2016, 3, 'xii, 290 halaman : ilustrasi ; 23 cm', 'buku/buku.jpg'),
('BK006', 'Dasar pemrograman web dengan PHP', 'KT002', 'NF001', '978-602-453-396-0', 'Canggih Ajika Pamungkas', 'Deepublish', 2017, 4, 'x, 92 halaman : ilustrasi ; 20 cm', 'buku/BK006.jpg'),
('BK007', 'Esok bersamamu', 'KT003', 'FK001', '978-623-306-432-3', 'Artsymiia. 1992- (penulis) Lulu Latifah (editor)', 'AE Publishing', 2021, 6, 'ii, 322 halaman ; 20 cm', 'buku/buku.jpg'),
('BK008', 'Hujan tanpa suara : ketika aku merindukanmu, dengan kerinduan yang meremas-remas kalbu', 'KT001', 'NV001', '978-623-6439-96-8', 'Nailin RA (penulis) Tim CMG (editor)', 'Catur Media Gemilang', 2022, 3, '204 hal Ilustrasi 2022', 'buku/BK008.jpg'),
('BK009', 'Juru kunci makam', 'KT003', 'FK001', '-', 'Sinta Yudisia, 1974- (pengarang) Ayu Wulan (penyunting bahasa)', 'Indiva Media Kreasi', 2020, 2, '133 halaman : ilustrasi ; 19 cm', 'buku/buku.jpg'),
('BK010', 'Kartun Kalkulus', 'KT002', 'NF001', '978-602-481-620-9', 'Gonick, Larry (pengarang) Mharta Adji Wardana (penerjemah) Andya Primanda (penyunting)', 'Kepustakaan Populer Gramedia', 2021, 3, 'Xii, 243 halaman : ilustrasi : 23 cm', 'buku/BK010.jpg');

--
-- Triggers `buku`
--
DELIMITER $$
CREATE TRIGGER `before_insert_buku` BEFORE INSERT ON `buku` FOR EACH ROW BEGIN
DECLARE s VARCHAR(5);
DECLARE i INT;
 
SET i = (SELECT SUBSTRING(id_buku,3,3) AS num
FROM buku ORDER BY num DESC LIMIT 1);
 
SET s = (SELECT id_buku_auto(i));
 
IF(NEW.id_buku IS NULL OR NEW.id_buku = '')
 THEN SET NEW.id_buku = s;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` char(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KT001', 'Novel'),
('KT002', 'Non-Fiksi'),
('KT003', 'Fiksi');

--
-- Triggers `kategori`
--
DELIMITER $$
CREATE TRIGGER `before_insert_kategori` BEFORE INSERT ON `kategori` FOR EACH ROW BEGIN
DECLARE s VARCHAR(5);
DECLARE i INT;
 
SET i = (SELECT SUBSTRING(id_kategori,3,3) AS num
FROM kategori ORDER BY num DESC LIMIT 1);
 
SET s = (SELECT id_kategori_auto(i));
 
IF(NEW.id_kategori IS NULL OR NEW.id_kategori = '')
 THEN SET NEW.id_kategori = s;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` char(7) NOT NULL,
  `id_buku` char(5) NOT NULL,
  `nim` char(9) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `denda` int(5) NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `nim`, `tanggal_pinjam`, `tanggal_kembali`, `denda`, `status`) VALUES
('PJ00002', 'BK001', 'H1D021111', '2022-10-02 12:44:33', '2022-10-13 14:05:53', 34000, 'done'),
('PJ00003', 'BK004', 'H1D021005', '2022-10-09 08:45:27', '2022-10-18 10:06:22', 2000, 'done'),
('PJ00004', 'BK009', 'H1D021043', '2022-10-15 07:15:45', '2022-10-16 08:56:54', 0, 'done'),
('PJ00005', 'BK003', 'H1D021021', '2022-10-21 12:28:56', '2022-10-29 13:44:21', 1000, 'done'),
('PJ00006', 'BK002', 'H1D021008', '2022-10-28 16:02:55', '2022-10-31 17:50:02', 0, 'done'),
('PJ00007', 'BK001', 'H1D021043', '2022-11-02 17:51:59', '2022-11-04 14:52:10', 0, 'done'),
('PJ00008', 'BK004', 'H1D021005', '2022-11-04 08:13:08', '2022-11-09 12:32:17', 0, 'done'),
('PJ00009', 'BK002', 'H1D021043', '2022-11-12 10:49:41', '2022-11-24 11:52:25', 5000, 'done'),
('PJ00010', 'BK005', 'H1D021008', '2022-11-14 14:50:27', '2022-11-22 09:42:32', 0, 'done'),
('PJ00011', 'BK008', 'H1D021021', '2022-11-24 13:20:58', '2022-11-29 17:52:39', 0, 'done'),
('PJ00012', 'BK006', 'H1D021005', '2022-11-26 09:51:12', '2022-12-09 10:22:47', 6000, 'done'),
('PJ00013', 'BK007', 'H1D021008', '2022-11-26 10:21:24', '2022-12-04 12:52:55', 1000, 'done'),
('PJ00014', 'BK009', 'H1D021043', '2022-11-28 15:51:36', '2022-12-02 10:53:03', 0, 'done'),
('PJ00015', 'BK010', 'H1D021021', '2022-11-30 11:31:47', '2022-12-12 08:53:11', 4000, 'done'),
('PJ00016', 'BK004', 'H1D021021', '2022-12-05 09:31:38', '2022-12-12 12:34:46', 0, 'done'),
('PJ00017', 'BK007', 'H1D021005', '2022-12-07 11:52:28', '2022-12-16 09:24:54', 1000, 'done'),
('PJ00018', 'BK008', 'H1D021008', '2022-12-14 14:33:55', '2022-12-24 17:35:02', 3000, 'done'),
('PJ00019', 'BK010', 'H1D021005', '2022-12-22 15:33:49', NULL, 0, 'process'),
('PJ00020', 'BK006', 'H1D021021', '2022-12-24 09:26:14', NULL, 0, 'process');

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `before_insert_peminjaman` BEFORE INSERT ON `peminjaman` FOR EACH ROW BEGIN
DECLARE s VARCHAR(7);
DECLARE i INT;
 
SET i = (SELECT SUBSTRING(id_peminjaman,3,5) AS num
FROM peminjaman ORDER BY num DESC LIMIT 1);
 
SET s = (SELECT id_peminjaman_auto(i));
 
IF(NEW.id_peminjaman IS NULL OR NEW.id_peminjaman = '')
 THEN SET NEW.id_peminjaman = s;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id_pengurus` char(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL,
  `pic` varchar(50) NOT NULL DEFAULT 'pengurus/admin.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id_pengurus`, `nama`, `password`, `level`, `pic`) VALUES
('PG001', 'Prijatno', '$2y$10$Ulu44Z/XAIlRR88qjwt4UOKbC1yhz.K49lgcbJdD4edY7YOFJ4y8G', 'owner', 'pengurus/admin.png'),
('PG002', 'Djoko', '$2y$10$a/yQZA37NeI4yQ54dQ0qrObAskTflk2Qesv17OSJXJUVgyLwIzpou', 'petugas', 'pengurus/admin.png'),
('PG003', 'zambo', '$2y$10$UHjWq1MelyrqOAFBQuMs5OsZbug3AdDwE7voTNGaOMsW5PFWQvqcu', 'owner', 'pengurus/PG003.jpg');

--
-- Triggers `pengurus`
--
DELIMITER $$
CREATE TRIGGER `before_insert_pengurus` BEFORE INSERT ON `pengurus` FOR EACH ROW BEGIN
DECLARE s VARCHAR(5);
DECLARE i INT;
 
SET i = (SELECT SUBSTRING(id_pengurus,3,3) AS num
FROM pengurus ORDER BY num DESC LIMIT 1);
 
SET s = (SELECT id_pengurus_auto(i));
 
IF(NEW.id_pengurus IS NULL OR NEW.id_pengurus = '')
 THEN SET NEW.id_pengurus = s;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `id_rak` char(5) NOT NULL,
  `nama_rak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id_rak`, `nama_rak`) VALUES
('FK001', 'Fiksi 1-100'),
('NF001', 'NonFiksi 1-100'),
('NV001', 'Novel 1-100');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_kategori` (`id_kategori`),
  ADD KEY `fk_rak` (`id_rak`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_buku` (`id_buku`),
  ADD KEY `fk_anggota` (`nim`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id_pengurus`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `fk_rak` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id_rak`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_anggota` FOREIGN KEY (`nim`) REFERENCES `anggota` (`nim`),
  ADD CONSTRAINT `fk_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

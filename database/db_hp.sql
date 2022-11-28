-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 04:18 AM
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
('H1D021043', 'Irfan Priatna', '$2y$10$8lQQu/ehbbIYn7XUvDhlbOp6Fc7SxCM2QqnTq2uiJuj1a32MNbz76', 'irfan.priatna@mhs.unsoed.ac.id', '0895375115609', 'Ciamis', 'l', 'anggota/h1d021043.jpg'),
('H1D021111', 'djoko sasana', '$2y$10$/9gbCNaJR1Xx4wzZ7kh4T.k6YKUdWqpz.pzhC2i53X.2Hg0/qcSvu', 'irfanpriatna22@gmail.com', '081223224225', 'Jalan In Aja No.333', 'l', 'anggota/H1D021111.jpg');

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
('BK001', 'Membuat berbagai DVD-Video dengan Ulead Video Studio 9', 'KT002', 'NF001', '979-20-8027-9', 'Ian Chandra K', 'Elex Media Komputindo', 2006, 2, 'vii, 252 hlm. : ilus. ; 21 cm.', 'buku/BK001.jpg');

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
('KT002', 'Non-Fiksi');

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
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `denda` int(5) NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `nim`, `tanggal_pinjam`, `tanggal_kembali`, `denda`, `status`) VALUES
('PJ00002', 'BK001', 'H1D021111', '2022-11-26', '2022-11-27', 40000, 'done'),
('PJ00003', 'BK001', 'H1D021043', '2022-11-27', NULL, 0, 'process');

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
('PG001', 'Prijatno', '$2y$10$.DJ3TLz8F7kMMQjEm1PWtuK13de2z70AovDbL4ua2TdwcrZ2nAw2K', 'owner', 'pengurus/admin.png'),
('PG002', 'Djoko', '$2y$10$SDMNcyqzYPTJcmIqagocoeDKudSj0BYW9LXIGID2uhKcZIPiQSAJq', 'petugas', 'pengurus/admin.png');

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

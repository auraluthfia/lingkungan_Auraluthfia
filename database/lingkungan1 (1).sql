-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 07:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lingkungan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `IDjadwal` int(11) NOT NULL,
  `waktu` time NOT NULL,
  `hari` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`IDjadwal`, `waktu`, `hari`) VALUES
(3, '08:00:00', 'Senin'),
(4, '10:00:00', 'Senin'),
(5, '12:00:00', 'Senin'),
(6, '08:00:00', 'Selasa'),
(7, '10:00:00', 'Selasa'),
(8, '12:00:00', 'Selasa'),
(9, '08:00:00', 'Rabu'),
(10, '10:00:00', 'Rabu'),
(11, '12:00:00', 'Rabu'),
(12, '08:00:00', 'Kamis'),
(13, '10:00:00', 'Kamis'),
(14, '12:00:00', 'Kamis');

-- --------------------------------------------------------

--
-- Table structure for table `pengambilan`
--

CREATE TABLE `pengambilan` (
  `IDpengambilan` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `IDpenjadwalan` int(11) NOT NULL,
  `total_gaji` int(11) NOT NULL,
  `status` enum('successful','canceled') DEFAULT 'successful'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjadwalan`
--

CREATE TABLE `penjadwalan` (
  `IDpenjadwalan` int(11) NOT NULL,
  `IDjadwal` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `IDpesanan` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `IDproduk` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('pending','successful') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `IDproduk` int(11) NOT NULL,
  `nama_produk` varchar(150) DEFAULT NULL,
  `deskripsi_produk` varchar(150) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `gambar` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`IDproduk`, `nama_produk`, `deskripsi_produk`, `harga`, `gambar`) VALUES
(1, 'Lilin Aroma Terapi ', 'lilin aroma terapi dengan berbagai manfaat, Menenangkan pikiran dan meredakan stres, Menghilangkan bau tidak sedap.', 35000, 'lilin_aroma.jpeg'),
(2, 'Sabun Batang', 'sabun biasanya dipakai untuk mandi ', 20000, 'sabun.jpeg'),
(3, 'Lilin', 'lilin terbaik ini tahan lama ', 15000, 'lilin.jpeg'),
(4, 'produk percobaan', 'ini produk abal abal ', 900000, '17-a8fbe2d84f7e066b636b54d560058839.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rating_pengelola`
--

CREATE TABLE `rating_pengelola` (
  `IDratingolah` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `IDpengambilan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating_produk`
--

CREATE TABLE `rating_produk` (
  `IDratingproduk` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `IDproduk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nomorHP` int(15) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `nama`, `email`, `password`, `nomorHP`, `role`) VALUES
(1, '', '', '', 0, ''),
(2, 'aura', 'rara@gmail.com', 'rara123', 98765467, 'admin'),
(11, 'kiko', 'kiko@gmail.com', '123', 928302833, 'user'),
(16, 'lion', 'lion@gmail.com', 'lion', 2147483647, 'admin'),
(21, 'coba', 'coba@gmail.com', 'coba', 2147483647, 'user'),
(24, 'saya', 'saya@gmail.com', 'saya', 987654321, 'admin'),
(25, 'halo', 'halo@gmail.com', 'halo', 98765423, 'user'),
(27, 'jojo', 'jojo@gmail.com', 'jojo', 987654273, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`IDjadwal`);

--
-- Indexes for table `pengambilan`
--
ALTER TABLE `pengambilan`
  ADD PRIMARY KEY (`IDpengambilan`),
  ADD KEY `ID` (`ID`),
  ADD KEY `IDpenjadwalan` (`IDpenjadwalan`);

--
-- Indexes for table `penjadwalan`
--
ALTER TABLE `penjadwalan`
  ADD PRIMARY KEY (`IDpenjadwalan`),
  ADD KEY `IDjadwal` (`IDjadwal`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`IDpesanan`),
  ADD KEY `ID` (`ID`,`IDproduk`),
  ADD KEY `IDproduk` (`IDproduk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`IDproduk`);

--
-- Indexes for table `rating_pengelola`
--
ALTER TABLE `rating_pengelola`
  ADD PRIMARY KEY (`IDratingolah`),
  ADD KEY `ID` (`ID`),
  ADD KEY `IDpengambilan` (`IDpengambilan`);

--
-- Indexes for table `rating_produk`
--
ALTER TABLE `rating_produk`
  ADD PRIMARY KEY (`IDratingproduk`),
  ADD KEY `ID` (`ID`),
  ADD KEY `IDproduk` (`IDproduk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `IDjadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pengambilan`
--
ALTER TABLE `pengambilan`
  MODIFY `IDpengambilan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjadwalan`
--
ALTER TABLE `penjadwalan`
  MODIFY `IDpenjadwalan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `IDproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rating_produk`
--
ALTER TABLE `rating_produk`
  MODIFY `IDratingproduk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengambilan`
--
ALTER TABLE `pengambilan`
  ADD CONSTRAINT `pengambilan_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `pengambilan_ibfk_2` FOREIGN KEY (`IDpenjadwalan`) REFERENCES `penjadwalan` (`IDpenjadwalan`);

--
-- Constraints for table `penjadwalan`
--
ALTER TABLE `penjadwalan`
  ADD CONSTRAINT `penjadwalan_ibfk_1` FOREIGN KEY (`IDjadwal`) REFERENCES `jadwal` (`IDjadwal`),
  ADD CONSTRAINT `penjadwalan_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`IDproduk`) REFERENCES `produk` (`IDproduk`);

--
-- Constraints for table `rating_pengelola`
--
ALTER TABLE `rating_pengelola`
  ADD CONSTRAINT `rating_pengelola_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `rating_pengelola_ibfk_2` FOREIGN KEY (`IDpengambilan`) REFERENCES `pengambilan` (`IDpengambilan`);

--
-- Constraints for table `rating_produk`
--
ALTER TABLE `rating_produk`
  ADD CONSTRAINT `rating_produk_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `rating_produk_ibfk_2` FOREIGN KEY (`IDproduk`) REFERENCES `produk` (`IDproduk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

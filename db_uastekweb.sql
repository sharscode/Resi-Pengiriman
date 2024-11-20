-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 09:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uastekweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_log_pengiriman`
--

CREATE TABLE `detail_log_pengiriman` (
  `id` int(11) NOT NULL,
  `nomor_resi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `kota` varchar(20) NOT NULL,
  `keterangan` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_log_pengiriman`
--

INSERT INTO `detail_log_pengiriman` (`id`, `nomor_resi`, `tanggal`, `kota`, `keterangan`) VALUES
(1, 'RS-001', '2023-11-27', 'Jakarta', 'Deposit pengiriman'),
(2, 'RS-001', '2023-11-27', 'Mojokerto', 'Transit'),
(4, 'SH-025', '2023-06-12', 'Surabaya', 'Kurir sedang tersesat'),
(5, 'SH-025', '2023-06-12', 'Toronto', 'Sedang diantar kurir'),
(6, 'DS-012', '2004-07-29', 'Seoul', 'Jalanan terlalu jauh'),
(7, 'DS-012', '2004-07-29', 'Busan', 'Kurir sedang istirahat makan siang'),
(8, 'FR-123', '2023-11-26', 'Tokyo', 'Penerima sedang menunggu sambil memakan ramen'),
(9, 'FR-123', '2023-11-26', 'Kyoto', 'Kurir bertemu penerima'),
(10, 'FR-123', '2023-11-26', 'Kyoto', 'Penerima merasa senang dan mereka makan bersama');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_resi_pengiriman`
--

CREATE TABLE `transaksi_resi_pengiriman` (
  `id` int(11) NOT NULL,
  `nomor_resi` varchar(50) NOT NULL,
  `tanggal_resi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_resi_pengiriman`
--

INSERT INTO `transaksi_resi_pengiriman` (`id`, `nomor_resi`, `tanggal_resi`) VALUES
(1, 'RS-001', '2023-11-27'),
(2, 'RS-002', '2023-12-05'),
(4, 'DS-012', '2004-07-29'),
(5, 'SH-025', '2023-06-12'),
(6, 'FR-123', '2023-11-26'),
(8, 'VR-073', '2022-04-07');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(30) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `username`, `password`, `nama_admin`, `status_aktif`) VALUES
(1, 'admin', 'admin', 'Admin', 1),
(4, 'user123', 'user', 'userBaru', 1),
(5, 'sudahEdit', 'coba', 'coba edit', 1),
(6, 'nonAktif', 'nonaktif', 'dinonaktif', 0),
(7, 'akunBaru', 'adayangbaru', 'new account', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_log_pengiriman`
--
ALTER TABLE `detail_log_pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_resi` (`nomor_resi`);

--
-- Indexes for table `transaksi_resi_pengiriman`
--
ALTER TABLE `transaksi_resi_pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_resi` (`nomor_resi`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_log_pengiriman`
--
ALTER TABLE `detail_log_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi_resi_pengiriman`
--
ALTER TABLE `transaksi_resi_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_log_pengiriman`
--
ALTER TABLE `detail_log_pengiriman`
  ADD CONSTRAINT `detail_log_pengiriman_ibfk_1` FOREIGN KEY (`nomor_resi`) REFERENCES `transaksi_resi_pengiriman` (`nomor_resi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

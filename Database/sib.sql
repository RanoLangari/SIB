-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 03, 2023 at 10:36 PM
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
-- Database: `sib`
--

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_order` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_barang`, `jumlah_order`) VALUES
(22, 5, 4, '1'),
(36, 13, 4, '1'),
(37, 13, 6, '1'),
(38, 13, 7, '1');

-- --------------------------------------------------------

--
-- Table structure for table `orderan`
--

CREATE TABLE `orderan` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `gambar` varchar(256) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `harga` int(255) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderan`
--

INSERT INTO `orderan` (`id_produk`, `nama`, `gambar`, `jumlah`, `harga`, `kategori`) VALUES
(4, 'new', '644c4ff08b837.png', 100, 100, 'serum'),
(5, 'Belanjaaan', '6450e40a06eef.jpeg', 200, 100, 'toner'),
(6, 'Lifeboy', '6450eb9c50f40.png', 200, 200000, 'pelembab'),
(7, 'a', '6450f5e6f3d46.png', 200, 200, 'Pilih jenis'),
(8, 'a', '6450f618c7a75.jpeg', 300, 300, 'toner');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah_pesanan` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `tgl_pesanan` varchar(255) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `token_pesanan` varchar(30) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` varchar(50) NOT NULL,
  `status_pengiriman` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_produk`, `id_user`, `jumlah_pesanan`, `nama_penerima`, `alamat`, `no_hp`, `tgl_pesanan`, `metode_pembayaran`, `token_pesanan`, `bukti_pembayaran`, `status_pembayaran`, `status_pengiriman`) VALUES
(142, 3, 13, '2100000', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:04:09', 'Pilih Metode Pembayaran', 'SVilzDfbszE9lDalPPVS', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(143, 7, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:04:09', 'Pilih Metode Pembayaran', 'SVilzDfbszE9lDalPPVS', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(144, 3, 13, '2100000', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:05:41', 'Pilih Metode Pembayaran', 'NuLJCIPYQVir9rc0TKNo', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(145, 7, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:05:41', 'Pilih Metode Pembayaran', 'NuLJCIPYQVir9rc0TKNo', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(146, 3, 13, '2100000', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:06:10', 'Pilih Metode Pembayaran', 'yBZoTDkPe9oYFDc2Y6Ck', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(147, 7, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:06:10', 'Pilih Metode Pembayaran', 'yBZoTDkPe9oYFDc2Y6Ck', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(148, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:06:32', 'Pilih Metode Pembayaran', 'w83k6K319rffbPmp7S1K', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(149, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:06:32', 'Pilih Metode Pembayaran', 'w83k6K319rffbPmp7S1K', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(150, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:09:02', 'Pilih Metode Pembayaran', 'EzXbxnKMjgRc0fjIHV8K', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(151, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:09:02', 'Pilih Metode Pembayaran', 'EzXbxnKMjgRc0fjIHV8K', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(152, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:09:39', 'Pilih Metode Pembayaran', 'omiy6rWI9lQE5aZir7UG', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(153, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:09:39', 'Pilih Metode Pembayaran', 'omiy6rWI9lQE5aZir7UG', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(154, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:10:16', 'Pilih Metode Pembayaran', 'uK7lND25pzjhZVL0ktBp', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(155, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:10:16', 'Pilih Metode Pembayaran', 'uK7lND25pzjhZVL0ktBp', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(156, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:10:32', 'bank', 'pngkhLyhTOtVlULcw3uU', '6452c02b2f220.jpeg', 'Belum Dibayar', 'Menunggu Pembayaran'),
(157, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:10:32', 'bank', 'pngkhLyhTOtVlULcw3uU', '6452c02b2f220.jpeg', 'Belum Dibayar', 'Menunggu Pembayaran'),
(158, 3, 13, '2100000', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:11:57', 'bank', '2FhggUdQYexHxouK0QcL', '6452c03c82448.png', 'Belum Dibayar', 'Belum Dikirim'),
(159, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:11:57', 'bank', '2FhggUdQYexHxouK0QcL', '6452c03c82448.png', 'Belum Dibayar', 'Belum Dikirim'),
(160, 7, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:22:02', 'bank', 'SWqXsUMCVooAt6GmGMXO', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(161, 4, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:22:02', 'bank', 'SWqXsUMCVooAt6GmGMXO', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(162, 5, 13, '2', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:22:02', 'bank', 'SWqXsUMCVooAt6GmGMXO', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(163, 4, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:24:17', 'bank', 'tBaaDbRSzR0ZewkXOfRJ', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(164, 6, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:24:17', 'bank', 'tBaaDbRSzR0ZewkXOfRJ', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(165, 7, 13, '1', 'Yosep Ngari', 'R.W. MONGENSIDI', '+6285158688761', '2023-05-03 22:24:17', 'bank', 'tBaaDbRSzR0ZewkXOfRJ', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(166, 4, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:24:36', 'dana', '0IVotJi4OpHgE4jHBc61', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(167, 6, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:24:36', 'dana', '0IVotJi4OpHgE4jHBc61', '', 'Belum Dibayar', 'Menunggu Pembayaran'),
(168, 7, 13, '1', 'Yosef Firano La Ngari', 'R.W. MONGENSIDI', '0813-3718-4538', '2023-05-03 22:24:36', 'dana', '0IVotJi4OpHgE4jHBc61', '', 'Belum Dibayar', 'Menunggu Pembayaran');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `gambar`, `pass`, `role`) VALUES
(1, 'ranolangari24', 'langarirano@gmail.com', '', '$2y$10$oxR8gh3T.H/a2/XMh96iuOoX.8gbwAY55TOf/jhONpdmBhlD6NlSe', 0),
(4, 'ranolangari56', 'Admin@gmail.com', '', '$2y$10$PezoEVhA07C2rhejNuobI.worzisvzaN31kfEtrMrTfnofe3OmZGi', 0),
(5, 'test', 'test2@gmail.com', '', '$2y$10$PezoEVhA07C2rhejNuobI.worzisvzaN31kfEtrMrTfnofe3OmZGi', 0),
(6, 'test23', 'yayayakalah@gmail.com', '', '$2y$10$2kr.SmQ5Zgpqmarjlzlt2eKahUfviH.XvlxoRcWaP3hPzYlYFNsTy', 0),
(7, 'testapk', 'testapk@gmail.com', '', '$2y$10$mkALUJWPvfYg.2ZKfZFgP.T5m5fiJHZY/IykX9E5kXkq8yllC8zFy', 0),
(8, 'toni', 'test20@gmail.com', '', '$2y$10$14RshSkVuTTcixLok/6kTO7Zp9cV1gOY2Sbeuv2As3Fq5VhbNLPOW', 0),
(9, 'Administrator', 'admin@gmail.com', '644ce05134b8d.jpeg', '$2y$10$LYgCPh9vOQgkVHR0gIjr3OPzAjKBri.VfxeZ7g9EhJd/spJL814YK', 1),
(10, 'jr', 'jr@mail.com', '', '$2y$10$NVlOMyOBg1T36SKB4far5.4QWhiCk6wsxR/5z2/uDsfHGMw2Ibwui', 0),
(11, 'ranolangari230603', 'ranolangari@gmail.com', '644c48ace9264.png', '$2y$10$xUnLPTaOc6WiYFd1wsZP8eXmqXlkWiRtJDfnU9dbGNp7UUOIIUzQq', 0),
(12, 'a', 'a@mail.com', '', '$2y$10$rn33Uq7yhB8NuiziwZARtOOUSj7.IaQAAye.Cf5s.TtznWswu7yNi', 0),
(13, 'ranolangari', 'ranongari23@gmail.com', '6452c175c2298.png', '$2y$10$EoY3G8piO2yHo/0R8pFZmulMV8Jv/w0ovrvaPvkHQgD/TsG0iOohK', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `orderan`
--
ALTER TABLE `orderan`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orderan`
--
ALTER TABLE `orderan`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `orderan` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

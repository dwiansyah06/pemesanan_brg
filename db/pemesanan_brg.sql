-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2018 at 04:48 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemesanan_brg`
--

-- --------------------------------------------------------

--
-- Table structure for table `approve`
--

CREATE TABLE `approve` (
  `id` int(15) NOT NULL,
  `id_transaksi` char(10) NOT NULL,
  `product_code` varchar(155) NOT NULL,
  `product_name` varchar(155) NOT NULL,
  `units` int(5) NOT NULL,
  `price` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL,
  `level` varchar(255) NOT NULL,
  `level2` varchar(255) NOT NULL,
  `action` enum('B','Y','N') NOT NULL,
  `keteranganmgr` varchar(500) NOT NULL,
  `keteranganti` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approve`
--

INSERT INTO `approve` (`id`, `id_transaksi`, `product_code`, `product_name`, `units`, `price`, `date`, `user`, `level`, `level2`, `action`, `keteranganmgr`, `keteranganti`) VALUES
(1, 'T01', 'FD1', 'Flashdisk', 5, 120000, '2018-10-26 02:03:18', 'user1', 'Manager user1', 'user1', 'Y', 'jadikan 3', 'oke siap'),
(2, 'T02', 'PR1', 'printer', 2, 2400000, '2018-10-26 02:15:14', 'user1', 'Manager user1', 'user1', 'Y', 'jadikan 1', 'oke');

-- --------------------------------------------------------

--
-- Table structure for table `approve_it`
--

CREATE TABLE `approve_it` (
  `id` int(5) NOT NULL,
  `id_transaksi` char(10) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `units` int(5) NOT NULL,
  `price` bigint(20) NOT NULL,
  `total` bigint(30) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL,
  `level` varchar(255) NOT NULL,
  `level2` varchar(255) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `keteranganti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approve_it`
--

INSERT INTO `approve_it` (`id`, `id_transaksi`, `product_code`, `product_name`, `units`, `price`, `total`, `date`, `user`, `level`, `level2`, `keterangan`, `keteranganti`) VALUES
(1, 'T01', 'FD1', 'Flashdisk', 3, 120000, 360000, '2018-10-26 02:03:18', 'user1', 'Manager user1', 'user1', 'jadikan 3', 'oke siap'),
(2, 'T02', 'PR1', 'printer', 1, 2400000, 2400000, '2018-10-26 02:15:14', 'user1', 'Manager user1', 'user1', 'jadikan 1', 'oke');

-- --------------------------------------------------------

--
-- Table structure for table `history_product`
--

CREATE TABLE `history_product` (
  `id` int(11) NOT NULL,
  `product_code` varchar(550) NOT NULL,
  `product_name` varchar(550) NOT NULL,
  `masuk` int(10) NOT NULL,
  `keluar` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `price` bigint(20) NOT NULL,
  `cocok` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `level` varchar(550) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history_product`
--

INSERT INTO `history_product` (`id`, `product_code`, `product_name`, `masuk`, `keluar`, `qty`, `price`, `cocok`, `gambar`, `username`, `level`, `keterangan`, `tanggal`) VALUES
(1, 'FD1', 'Flashdisk', 0, 3, 69, 120000, '-', '-', 'user1', 'Manager user1', 'disetujui oleh admin gudang dengan id admin', '2018-10-26'),
(2, 'PR2', 'Flashdisk 2', 100, 0, 100, 100000, 'all', 'item-1540519505.jpg', 'admin', 'Admin', 'Penambahan barang', '2018-10-26'),
(3, 'PR1', 'printer', 0, 1, 7, 2400000, '-', '-', 'user1', 'Manager user1', 'disetujui oleh admin gudang dengan id admin', '2018-10-26'),
(4, 'PR1', 'printer', 4, 0, 10, 2400000, 'all', 'item-1540453512.jpg', 'admin', 'Admin', 'Penambahan stok barang', '2018-10-26'),
(5, 'TN1', 'flashdisk 3', 19, 0, 19, 100000, 'all', 'item-1540520251.jpg', 'admin', 'Admin', 'Penambahan barang', '2018-10-26'),
(6, 'TN1', 'flashdisk 3', 0, 0, 0, 200000, 'all', 'item-1540520251.jpg', 'admin', 'Admin', 'Perubahan harga product', '2018-10-26'),
(7, 'TN1', 'flashdisk 3', 0, 0, 0, 200000, 'all', 'item-1540520251.jpg', 'admin', 'Admin', 'Menghapus produk', '2018-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(5) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `kode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`, `kode`) VALUES
(1, 'Toner', 'TN'),
(2, 'Catridge', 'CTR'),
(3, 'Scanner', 'SCN'),
(4, 'Printer', 'PR'),
(5, 'Flashdisk', 'FD'),
(6, 'Personal_Computer', 'PC'),
(7, 'Laptop', 'LP');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_code` varchar(550) NOT NULL,
  `product_name` varchar(550) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `cocok` varchar(255) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_img_name` varchar(100) NOT NULL,
  `qty` int(5) NOT NULL,
  `price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_code`, `product_name`, `kategori`, `cocok`, `product_desc`, `product_img_name`, `qty`, `price`) VALUES
(3, 'PR1', 'printer', 'Printer', 'all', '', 'item-1540453512.jpg', 10, 2400000),
(4, 'FD1', 'Flashdisk', 'Flashdisk', 'all', '', 'item-1540453550.jpg', 66, 120000),
(5, 'SCN1', 'scanner', 'Scanner', 'all', '', 'item-1540453577.jpg', 17, 3000000),
(6, 'PR2', 'Flashdisk 2', 'Printer', 'all', '', 'item-1540519505.jpg', 100, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `trash`
--

CREATE TABLE `trash` (
  `id` int(3) NOT NULL,
  `id_transaksi` char(3) NOT NULL,
  `product_code` varchar(5) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `units` int(5) NOT NULL,
  `price` bigint(6) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL,
  `level` varchar(100) NOT NULL,
  `level2` varchar(100) NOT NULL,
  `action` enum('B','Y','N') NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `trash`
--

INSERT INTO `trash` (`id`, `id_transaksi`, `product_code`, `product_name`, `units`, `price`, `date`, `user`, `level`, `level2`, `action`, `keterangan`) VALUES
(1, 'T01', 'FD1', 'Flashdisk', 5, 120000, '2018-10-26 02:02:16', 'user1', 'Manager user1', 'user1', 'Y', ''),
(2, 'T02', 'PR1', 'printer', 2, 2400000, '2018-10-26 02:14:33', 'user1', 'Manager user1', 'user1', 'Y', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` enum('Admin','Super Admin','user1','manager user1') NOT NULL,
  `level2` enum('user','manager','admin','superadmin') NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`, `level2`, `status`) VALUES
(1, 'admin', '123', 'Admin', 'admin', 0),
(2, 'superadmin', '123', 'Super Admin', 'superadmin', 0),
(3, 'user1', '123', 'user1', 'user', 0),
(4, 'manager_user1', '123', 'manager user1', 'manager', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approve`
--
ALTER TABLE `approve`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approve_it`
--
ALTER TABLE `approve_it`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_product`
--
ALTER TABLE `history_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approve`
--
ALTER TABLE `approve`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `approve_it`
--
ALTER TABLE `approve_it`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `history_product`
--
ALTER TABLE `history_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `trash`
--
ALTER TABLE `trash`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

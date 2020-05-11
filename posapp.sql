-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 10:36 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id` int(11) NOT NULL,
  `nm_app` varchar(255) DEFAULT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `home_txt` text,
  `footer_txt` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aplikasi`
--

INSERT INTO `aplikasi` (`id`, `nm_app`, `nama_toko`, `alamat_toko`, `home_txt`, `footer_txt`) VALUES
(1, 'POS(Point Of Sales) BJ Home', 'BJ Home', 'Jl. Janti', '<strong>BJ Home</strong> ', 'BJ Home');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` bigint(20) NOT NULL,
  `kode_barang` varchar(255) DEFAULT NULL,
  `kategori_barang` int(11) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga_beli` bigint(20) DEFAULT NULL,
  `harga_jual` bigint(20) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `waktu_masuk` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `kategori_barang`, `nama_barang`, `satuan`, `harga_beli`, `harga_jual`, `tanggal_masuk`, `waktu_masuk`) VALUES
(1, 'MAK2019121811', 1, 'Mie Rebus', '1', 2500, 5000, '2019-12-18', '07:41:06'),
(2, 'MAK2019121812', 1, 'Mie Goreng', '1', 2500, 5000, '2019-12-18', '07:41:32'),
(3, 'MIN2019121823', 2, 'Cafe Latte', '1', 3000, 5000, '2019-12-18', '07:46:02'),
(4, 'MIN2019121824', 2, 'Espresso', '1', 10000, 12000, '2019-12-18', '07:46:29'),
(5, 'MIN2019121825', 2, 'Cappucino', '1', 8000, 10000, '2019-12-18', '07:47:07'),
(7, 'MAK2019121817', 1, 'Spaghetti', '1', 6500, 10000, '2019-12-18', '07:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `barang_master`
--

CREATE TABLE `barang_master` (
  `id_bmaster` bigint(20) NOT NULL,
  `id_br` bigint(20) DEFAULT NULL,
  `stok` bigint(20) DEFAULT NULL,
  `tglup` date DEFAULT NULL,
  `wktup` time DEFAULT NULL,
  `tipe` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_master`
--

INSERT INTO `barang_master` (`id_bmaster`, `id_br`, `stok`, `tglup`, `wktup`, `tipe`) VALUES
(1, 1, 50, '2019-12-18', '07:41:06', 'masuk'),
(2, 2, 50, '2019-12-18', '07:41:32', 'masuk'),
(3, 3, 5, '2019-12-18', '07:46:02', 'masuk'),
(4, 4, 10, '2019-12-18', '07:46:29', 'masuk'),
(5, 5, 20, '2019-12-18', '07:47:07', 'masuk'),
(6, 6, 10, '2019-12-18', '07:47:31', 'masuk'),
(7, 6, -1, '2019-12-18', '07:48:02', 'keluar'),
(8, 7, 22, '2019-12-18', '07:52:15', 'masuk'),
(9, 3, -1, '2019-12-20', '06:36:41', 'keluar'),
(10, 5, -1, '2019-12-20', '07:50:34', 'keluar'),
(11, 7, -1, '2020-04-07', '10:06:41', 'keluar');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `kode_kategori` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`, `kode_kategori`) VALUES
(1, 'Makanan', 'MAK'),
(2, 'Minuman', 'MIN');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_master` bigint(20) DEFAULT NULL,
  `id_brg` bigint(20) DEFAULT NULL,
  `jml_jual` bigint(20) DEFAULT NULL,
  `sub_total` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_master`, `id_brg`, `jml_jual`, `sub_total`) VALUES
(1, 1, 6, 1, 7500),
(2, 2, 3, 1, 5000),
(3, 3, 5, 1, 10000),
(4, 4, 7, 1, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_master`
--

CREATE TABLE `penjualan_master` (
  `id_pjmaster` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `no_trx` bigint(20) DEFAULT NULL,
  `grand_total` bigint(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  `bayar` bigint(20) DEFAULT NULL,
  `kembalian` bigint(20) DEFAULT NULL,
  `keterangan` text,
  `tgl_trx` date DEFAULT NULL,
  `waktu_trx` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_master`
--

INSERT INTO `penjualan_master` (`id_pjmaster`, `id_user`, `no_trx`, `grand_total`, `diskon`, `total`, `bayar`, `kembalian`, `keterangan`, `tgl_trx`, `waktu_trx`) VALUES
(1, 1, 201912181, 7500, 0, 7500, 10000, 2500, '', '2019-12-18', '07:48:02'),
(2, 1, 201912182, 5000, 0, 5000, 6000, 1000, '', '2019-12-20', '06:36:41'),
(3, 1, 201912183, 10000, 0, 10000, 10000, 0, '', '2019-12-20', '07:50:34'),
(4, 2, 201912184, 10000, 0, 10000, 10000, 0, '', '2020-04-07', '10:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `satuan`) VALUES
(1, 'Pcs'),
(2, 'Kilo'),
(3, 'Unit');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `akses_user` int(11) DEFAULT NULL,
  `status_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `akses_user`, `status_user`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 1, 1),
(2, 'kasir', '8691e4fc53b99da544ce86e22acba62d13352eff', 'Togune', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_master`
--
ALTER TABLE `barang_master`
  ADD PRIMARY KEY (`id_bmaster`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `penjualan_master`
--
ALTER TABLE `penjualan_master`
  ADD PRIMARY KEY (`id_pjmaster`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `barang_master`
--
ALTER TABLE `barang_master`
  MODIFY `id_bmaster` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `penjualan_master`
--
ALTER TABLE `penjualan_master`
  MODIFY `id_pjmaster` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

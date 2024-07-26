-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 11:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kepegawaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kode_jabatan` varchar(3) NOT NULL,
  `nama_jabatan` varchar(40) NOT NULL,
  `gapok` int(10) NOT NULL,
  `tunjangan_jabatan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode_jabatan`, `nama_jabatan`, `gapok`, `tunjangan_jabatan`) VALUES
('J01', 'Direktur', 8000000, 1500000),
('J02', 'Manager', 7500000, 1000000),
('J03', 'administrasi', 7800000, 1000000),
('J04', 'Promotor', 4000000, 2000000),
('J05', 'test', 4000000, 250000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_golongan`
--

CREATE TABLE `tb_golongan` (
  `kode_golongan` varchar(3) NOT NULL,
  `nama_golongan` varchar(10) NOT NULL,
  `tunjangan_si` int(10) NOT NULL,
  `tunjangan_anak` int(10) NOT NULL,
  `uang_makan` int(10) NOT NULL,
  `askes` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_golongan`
--

INSERT INTO `tb_golongan` (`kode_golongan`, `nama_golongan`, `tunjangan_si`, `tunjangan_anak`, `uang_makan`, `askes`) VALUES
('G01', '1A', 250000, 200000, 300000, 200000),
('G05', '5E', 150000, 250000, 300000, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_keuangan`
--

CREATE TABLE `tb_keuangan` (
  `id` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pemasukan` int(18) NOT NULL,
  `pengeluaran` int(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_keuangan`
--

INSERT INTO `tb_keuangan` (`id`, `tanggal`, `keterangan`, `pemasukan`, `pengeluaran`) VALUES
(3, '2023-10-10', 'jual batu', 250000, 0),
(5, '2023-10-15', 'project 1 selesai', 500000, 0),
(8, '2023-10-22', 'Projec perusahaan selesai', 2500000, 0),
(9, '2023-10-22', 'perawatan alat', 0, 1000000),
(10, '2023-10-23', 'final project', 150000, 0),
(12, '2024-06-04', 'Jual Akun ML', 400000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_lokasi`
--

CREATE TABLE `tb_lokasi` (
  `kode_lokasi` varchar(3) NOT NULL,
  `nama_lokasi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_lokasi`
--

INSERT INTO `tb_lokasi` (`kode_lokasi`, `nama_lokasi`) VALUES
('LK1', 'Pekanbaru'),
('LK2', 'Jakarta'),
('LK3', 'Bali');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `id` int(10) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `kode_golongan` varchar(3) DEFAULT NULL,
  `kode_jabatan` varchar(3) DEFAULT NULL,
  `jumlah_anak` int(3) NOT NULL,
  `kode_lokasi` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id`, `nama`, `nip`, `status`, `foto`, `kode_golongan`, `kode_jabatan`, `jumlah_anak`, `kode_lokasi`) VALUES
(46, 'fixed', '10001', 'belum_menikah', 'catcouple1.jpg', 'G05', 'J04', 0, 'LK2'),
(48, 'Raju', '13991', 'menikah', 'def.jpg', 'G05', 'J02', 1, 'LK2'),
(50, 'test', '45612', 'belum_menikah', 'def.jpg', 'G05', 'J04', 0, 'LK3'),
(52, 'Rahsya Ganteng', '12309', 'belum_menikah', 'default.jpg', 'G01', 'J01', 0, NULL),
(53, 'Rahsya Ganteng', '22222', 'belum_menikah', 'default.jpg', 'G01', 'J01', 0, NULL),
(54, 'Rahsya Imoet', '11111', 'menikah', 'punya pros.png', 'G05', 'J01', 1, 'LK3'),
(55, 'rawaw', '31211', 'menikah', 'default.jpg', 'G01', 'J02', 2, NULL),
(56, 'Rahsyaa', '12111', 'belum_menikah', '2.png', 'G05', 'J01', 0, 'LK3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(225) NOT NULL,
  `level` enum('superadmin','operator','common_user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `level`) VALUES
(1, 'rahsya', 'admin', '12345', 'superadmin'),
(2, 'ganteng', 'pegawai', '12345', 'operator'),
(13, 'test24', 'test24', '12345', 'operator'),
(43, 'register', 'register', '123', 'operator'),
(44, 'operator', 'operator', '12345', 'operator'),
(45, 'fin', 'fin', '123', 'operator'),
(47, 'wew', 'wew', '123', 'common_user'),
(48, 'demo', 'demo', '123', 'operator'),
(49, 'usermum', 'usermum', '123', 'common_user'),
(52, 'pdo', 'pdo', '123', 'superadmin'),
(54, 'pdo', 'pdo2', '123', 'superadmin'),
(55, 'opd', 'opd', '123', 'superadmin'),
(56, 'opd', 'opd', '123', 'superadmin'),
(57, 'login', 'login', '123', 'common_user'),
(58, 'login2', 'login2', '123', 'common_user'),
(59, 'tcuy', 'tcuy', '$2y$10$gzUIr2yaqCWH65s2oB', 'common_user'),
(78, 'kor', 'kor', '$2y$10$ZksPcGWJf51DUaPWQE', 'common_user'),
(79, 'wir', 'wir', '$2y$10$r3J7be8o8u.jzTrpBj', 'common_user'),
(80, 'bub', 'bub', '$2y$10$vKNMq.wmBxptPUUSc4', 'common_user'),
(81, 'qwerty', 'qwerty', '$2y$10$8Ntfzdq66/x1DaK7zZ', 'common_user'),
(82, 'on', 'on', '$2y$10$In2RpJqnDOIJHedSXF', 'common_user'),
(83, 'no', 'no', '$2y$10$4wMM49ZvnvA6CV7/tn', 'common_user'),
(84, 'ot', 'ot', '$2y$10$Y5EdfT5CfvXmKWLgB0', 'common_user'),
(85, 'ker', 'ker', '$2y$10$3rzaklEdoBfqjdnVJ3', 'common_user'),
(86, 'wil', 'wil', '$2y$10$gYoVeS/.glHvRyf7k8', 'common_user'),
(87, 'lo', 'lo', '$2y$10$2v4MuELUXRNljX38/z', 'common_user'),
(88, 'wak', 'wak', '$2y$10$8/Myhrtx5QIo7eZTwD', 'common_user'),
(89, 'mow', 'mow', '$2y$10$SCSH.LCZeP.tWXPZomT.fuIf9lLV3WCx/0LxIk6VdOZiv9pw0FYdG', 'superadmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode_jabatan`);

--
-- Indexes for table `tb_golongan`
--
ALTER TABLE `tb_golongan`
  ADD PRIMARY KEY (`kode_golongan`);

--
-- Indexes for table `tb_keuangan`
--
ALTER TABLE `tb_keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_lokasi`
--
ALTER TABLE `tb_lokasi`
  ADD PRIMARY KEY (`kode_lokasi`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_golonganpegawai` (`kode_golongan`),
  ADD KEY `fk_jabatanpegawai` (`kode_jabatan`),
  ADD KEY `fk_lokasipegawai` (`kode_lokasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_keuangan`
--
ALTER TABLE `tb_keuangan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD CONSTRAINT `fk_golonganpegawai` FOREIGN KEY (`kode_golongan`) REFERENCES `tb_golongan` (`kode_golongan`),
  ADD CONSTRAINT `fk_jabatanpegawai` FOREIGN KEY (`kode_jabatan`) REFERENCES `jabatan` (`kode_jabatan`),
  ADD CONSTRAINT `fk_lokasipegawai` FOREIGN KEY (`kode_lokasi`) REFERENCES `tb_lokasi` (`kode_lokasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

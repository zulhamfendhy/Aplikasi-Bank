-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2018 pada 21.46
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `USEERN` varchar(255) COLLATE utf8_bin NOT NULL,
  `PASS` varchar(255) COLLATE utf8_bin NOT NULL,
  `ID` varchar(9) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`USEERN`, `PASS`, `ID`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `NO_REK` varchar(10) COLLATE utf8_bin NOT NULL,
  `NAMA` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `ALAMAT` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `EMAIL` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `NO_HP` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `USERNAME_CUS` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `PASSWORD` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`NO_REK`, `NAMA`, `ALAMAT`, `EMAIL`, `NO_HP`, `USERNAME_CUS`, `PASSWORD`) VALUES
('001', 'Ini Bank', 'Ini Bank', 'admin@inibank.com', '085791721334', 'admin', '394901510ad8113970c3fd3bfa53b3e66733637ae32f7733603b2be52d4a1a98'),
('002', 'Moh. Zulham Effendy', 'Sidoarjo', 'zulhameffendy14@gmail.com', '085791721334', 'zulhamfendhy', '00e9a9e6f4dac0f2c2c76566eae323b7c957c4385cd81f8de294361578f4776d');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `ID_RIWAYAT` int(10) NOT NULL,
  `NO_REK` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `ID_TRANSFER` int(11) DEFAULT NULL,
  `DEBET` float DEFAULT NULL,
  `KREDIT` float DEFAULT NULL,
  `SALDO` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`ID_RIWAYAT`, `NO_REK`, `ID_TRANSFER`, `DEBET`, `KREDIT`, `SALDO`) VALUES
(18, '002', 15, 890000, NULL, 890000),
(20, '002', 17, NULL, 65000, 825000),
(23, '002', 18, 80000, NULL, 905000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transfer`
--

CREATE TABLE `transfer` (
  `ID_TRANSFER` int(10) NOT NULL,
  `NO_REK` varchar(10) COLLATE utf8_bin NOT NULL,
  `CUS_NO_REK` varchar(10) COLLATE utf8_bin NOT NULL,
  `WAKTU` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `transfer`
--

INSERT INTO `transfer` (`ID_TRANSFER`, `NO_REK`, `CUS_NO_REK`, `WAKTU`) VALUES
(15, '001', '002', '2018-12-01 16:37:52'),
(16, '001', '001', '2018-12-01 16:42:54'),
(17, '002', '001', '2018-12-01 16:42:54'),
(18, '001', '002', '2018-12-01 16:42:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`NO_REK`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`ID_RIWAYAT`),
  ADD KEY `FK_RELATIONSHIP_5` (`ID_TRANSFER`),
  ADD KEY `FK_USER_MEMILIKI_RIWAYAT` (`NO_REK`);

--
-- Indeks untuk tabel `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`ID_TRANSFER`),
  ADD KEY `FK_RELATIONSHIP_4` (`NO_REK`),
  ADD KEY `FK_TRANSFER` (`CUS_NO_REK`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `ID_RIWAYAT` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `transfer`
--
ALTER TABLE `transfer`
  MODIFY `ID_TRANSFER` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_TRANSFER`) REFERENCES `transfer` (`ID_TRANSFER`),
  ADD CONSTRAINT `FK_USER_MEMILIKI_RIWAYAT` FOREIGN KEY (`NO_REK`) REFERENCES `customer` (`NO_REK`);

--
-- Ketidakleluasaan untuk tabel `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`NO_REK`) REFERENCES `customer` (`NO_REK`),
  ADD CONSTRAINT `FK_TRANSFER` FOREIGN KEY (`CUS_NO_REK`) REFERENCES `customer` (`NO_REK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

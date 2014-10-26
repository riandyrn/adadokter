-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 26 Okt 2014 pada 11.46
-- Versi Server: 5.6.11
-- Versi PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `db_adadokter`
--
CREATE DATABASE IF NOT EXISTS `db_adadokter` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_adadokter`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'dumadmin', 'dum12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointment_status`
--

CREATE TABLE IF NOT EXISTS `appointment_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(255) NOT NULL DEFAULT '0' COMMENT '0 - not selected, 1 - confirmed, 2 - canceled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data untuk tabel `appointment_status`
--

INSERT INTO `appointment_status` (`id`, `status`) VALUES
(28, 0),
(29, 1),
(31, 0),
(32, 0),
(33, 1),
(35, 1),
(37, 2),
(38, 1),
(42, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `doctor`
--

INSERT INTO `doctor` (`id`, `username`, `password`) VALUES
(3, 'dr_budi', 'budi123'),
(4, 'dr_hendy', 'hendy123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctor_available_schedule`
--

CREATE TABLE IF NOT EXISTS `doctor_available_schedule` (
  `id` int(11) NOT NULL COMMENT 'ini id_doctor',
  `start_hour` int(11) DEFAULT '2',
  `finish_hour` int(11) DEFAULT '32',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `doctor_available_schedule`
--

INSERT INTO `doctor_available_schedule` (`id`, `start_hour`, `finish_hour`) VALUES
(3, 3, 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_doctor` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_doctor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `patient`
--

INSERT INTO `patient` (`id`, `id_doctor`, `name`, `telephone_number`) VALUES
(6, 2, 'Yo1', '3456'),
(7, 3, 'Riandy Rahman Nugraha', '0857931747xx'),
(8, 4, 'Michael Dwianto Nirwan', '343545453'),
(11, 3, 'Yahoo', '12345'),
(12, 4, 'Yuhu', '123456');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) NOT NULL,
  `schedule_date` date NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `id_doctor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data untuk tabel `schedule`
--

INSERT INTO `schedule` (`id`, `patient_name`, `schedule_date`, `start_time`, `end_time`, `id_doctor`) VALUES
(6, 'Yahoo', '2014-08-18', 5, 6, '3'),
(8, 'Riandy Rahman Nugraha', '2014-08-18', 3, 7, '3'),
(13, 'Michael Dwianto Nirwan', '2014-09-25', 0, 3, '4'),
(14, 'Yuhu', '2014-09-25', 4, 7, '4'),
(28, 'Riandy Rahman Nugraha', '2014-10-11', 7, 9, '3'),
(29, 'Riandy Rahman Nugraha', '2014-10-16', 5, 7, '3'),
(31, 'Yahoo', '2014-10-16', 15, 19, '3'),
(32, 'Riandy Rahman Nugraha', '2014-10-23', 4, 6, '3'),
(33, 'Riandy Rahman Nugraha', '2014-10-24', 4, 5, '3'),
(35, 'Yahoo', '2014-10-24', 99, 99, '3'),
(37, 'Riandy Rahman Nugraha', '2014-10-24', 3, 4, '3'),
(38, 'Riandy Rahman Nugraha', '2014-10-24', 99, 99, '3'),
(42, 'Riandy Rahman Nugraha', '2014-10-26', 99, 99, '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `time_convert`
--

CREATE TABLE IF NOT EXISTS `time_convert` (
  `id` int(11) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `time_convert`
--

INSERT INTO `time_convert` (`id`, `time`) VALUES
(0, '06:00'),
(1, '06:30'),
(2, '07:00'),
(3, '07:30'),
(4, '08:00'),
(5, '08:30'),
(6, '09:00'),
(8, '10:00'),
(7, '09:30'),
(9, '10:30'),
(10, '11:00'),
(11, '11:30'),
(12, '12:00'),
(13, '12:30'),
(14, '13:00'),
(15, '13:30'),
(16, '14:00'),
(17, '14:30'),
(18, '15:00'),
(19, '15:30'),
(20, '16:00'),
(21, '16:30'),
(22, '17:00'),
(23, '17:30'),
(24, '18:00'),
(25, '18:30'),
(26, '19:00'),
(27, '19:30'),
(28, '20:00'),
(29, '20:30'),
(30, '21:00'),
(31, '21:30'),
(32, '22:00'),
(33, '22:30'),
(34, '23:00'),
(35, '23:30'),
(36, '00:00'),
(37, '00:30'),
(38, '01:00'),
(39, '01:30'),
(40, '02:00'),
(41, '02:30'),
(42, '03:00'),
(43, '03:30'),
(44, '04:00'),
(45, '04:30'),
(46, '05:00'),
(47, '05:30'),
(99, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_patient` int(255) NOT NULL,
  `date` date NOT NULL,
  `treatment` text,
  `diagnosis` text,
  PRIMARY KEY (`id`,`id_patient`,`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `treatment`
--

INSERT INTO `treatment` (`id`, `id_patient`, `date`, `treatment`, `diagnosis`) VALUES
(1, 8, '2014-09-25', 'Yuhu', NULL),
(6, 11, '2014-10-24', 'wer', 'ser'),
(7, 7, '2014-10-24', 'RR', 'RRR'),
(8, 11, '2014-10-24', 'aeew', 'aeew'),
(9, 11, '2014-10-24', 'we', 'we'),
(10, 11, '2014-10-24', 'we', 'we'),
(11, 11, '2014-10-24', 'asassa', 'ddadadda'),
(12, 7, '2014-10-24', 'eee', 'eee'),
(13, 7, '2014-10-27', 'od;sao;dko;sakd;okasodk', 'dsajdiasdjiajdpisapjda123'),
(14, 7, '2014-10-26', 'klajedjawijdiwa', 'wokw;oarkoawkr');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

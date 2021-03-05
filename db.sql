-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table prodistikdenanyar_db.config
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) DEFAULT NULL,
  `periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table prodistikdenanyar_db.matkul
CREATE TABLE IF NOT EXISTS `matkul` (
  `mkode` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  PRIMARY KEY (`mkode`),
  KEY `semester` (`semester`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table prodistikdenanyar_db.nilai
CREATE TABLE IF NOT EXISTS `nilai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` int(11) NOT NULL,
  `mkode` int(11) NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `periode` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis_mkode` (`nis`,`mkode`),
  KEY `FK_nilai_matkul` (`mkode`),
  CONSTRAINT `FK_nilai_matkul` FOREIGN KEY (`mkode`) REFERENCES `matkul` (`mkode`),
  CONSTRAINT `FK_nilai_siswa` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table prodistikdenanyar_db.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `nis` int(11) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `thn_masuk` int(11) DEFAULT NULL,
  `tugas_akhir` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nis`),
  KEY `kelas` (`kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table prodistikdenanyar_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

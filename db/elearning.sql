-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2024 pada 14.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `course`
--

CREATE TABLE `course` (
  `id_course` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `link` varchar(256) NOT NULL,
  `pertemuan` int(10) NOT NULL,
  `kelas` varchar(30) NOT NULL,
  `guru` varchar(50) NOT NULL,
  `course` enum('Materi','Tugas') NOT NULL DEFAULT 'Materi',
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `course`
--

INSERT INTO `course` (`id_course`, `judul`, `deskripsi`, `link`, `pertemuan`, `kelas`, `guru`, `course`, `deadline`) VALUES
(26, 'Materi 1', 'Materi 1 untuk kelas 10A', '', 1, '10A', 'Guru1', 'Materi', '0000-00-00'),
(27, 'Tugas 1', 'Membuat presentasi simpel', '', 1, '10A', 'Guru1', 'Tugas', '2024-11-12'),
(28, 'Materi 2', 'Materi 2 pembelajaran presentasi', '', 2, '10A', 'Guru1', 'Materi', '0000-00-00'),
(29, 'Materi 3', 'Pembelajaran presentasi ', '', 3, '10A', 'Guru1', 'Materi', '0000-00-00'),
(30, 'Tugas 2', 'Membuat presentasi dengan gerakan', '', 2, '10A', 'Guru1', 'Tugas', '2024-11-20'),
(31, 'Materi 1', 'Materi 1 untuk kelas 11A', '', 1, '11A', 'Guru2', 'Materi', '0000-00-00'),
(32, 'Tugas 1', 'Membuat presentasi simpel', '', 1, '11A', 'Guru2', 'Tugas', '2024-11-12'),
(33, 'Materi 2', 'Materi 2 presentasi dasar', '', 2, '11A', 'Guru2', 'Materi', '0000-00-00'),
(34, 'Tugas 2', 'Membuat presentasi dengan gerakan', '', 2, '11A', 'Guru2', 'Tugas', '2024-11-21'),
(35, 'Materi 3', 'Materi 3 lebih dalam presentasi', '', 3, '11A', 'Guru2', 'Materi', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama`) VALUES
(9, '10A'),
(10, '11A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `komentar` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_course` int(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `link` varchar(256) NOT NULL,
  `grade` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `id_course`, `id_user`, `link`, `grade`, `date_created`) VALUES
(37, 27, 26, 'sl', 0, '2024-11-14 15:12:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level` enum('Murid','Guru','Admin') NOT NULL DEFAULT 'Murid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `kelas`, `email`, `password`, `level`) VALUES
(16, 'Admin', '9A', 'admin@gmail.com', '$2y$10$kkIvtZoJcYoTPfHUbHyKxu2aNNRusKbjqm/eGhnhDzOfhvfRbhBIa', 'Admin'),
(21, 'Guru1', '10A', 'guru1@gmail.com', '$2y$10$1jM1VvO9jlzTjFtkUUv3t.c3HnJxZppU5K2AF4WrTad2olIbD9Ey6', 'Guru'),
(24, 'Guru2', '11A', 'guru2@gmail.com', '$2y$10$uJCBw4bOnoZ0TRqopcEPEeyMENNNV9wwwil9Bf7TDU/u013MWJG3O', 'Guru'),
(25, 'Student1', '10A', 'murid1@gmail.com', '$2y$10$/jCncq0h0B9nWGDFGvX9Eutfwnl2dY1m4MNNtix7H0lP1OUgik8f6', 'Murid'),
(26, 'Student2', '11A', 'murid2@gmail.com', '$2y$10$qb5kQgJ4v6Gx.Dwep6pn5OAuFUBdGuXWFsTwp.N3w8unvBWGTRBJq', 'Murid');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `course`
--
ALTER TABLE `course`
  MODIFY `id_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

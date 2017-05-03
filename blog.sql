-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 03 Maj 2017, 15:56
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `artykuly`
--

CREATE TABLE `artykuly` (
  `id_artykulu` int(10) NOT NULL,
  `nazwa` text COLLATE armscii8_bin NOT NULL,
  `artykul` text COLLATE armscii8_bin NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id_komentarza` int(10) NOT NULL,
  `id_art` int(10) NOT NULL,
  `id_konta` int(10) NOT NULL,
  `id_kom` int(10) DEFAULT NULL,
  `data` date NOT NULL,
  `komentarz` text COLLATE armscii8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

CREATE TABLE `konta` (
  `id_konta` int(10) NOT NULL,
  `nick` varchar(25) COLLATE armscii8_bin NOT NULL,
  `email` varchar(25) COLLATE armscii8_bin NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `haslo` varchar(25) COLLATE armscii8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `artykuly`
--
ALTER TABLE `artykuly`
  ADD PRIMARY KEY (`id_artykulu`);

--
-- Indexes for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id_komentarza`),
  ADD KEY `id_art` (`id_art`),
  ADD KEY `id_konta` (`id_konta`),
  ADD KEY `id_kom` (`id_kom`);

--
-- Indexes for table `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`id_konta`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `artykuly`
--
ALTER TABLE `artykuly`
  MODIFY `id_artykulu` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `id_konta` int(10) NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD CONSTRAINT `komentarze_ibfk_1` FOREIGN KEY (`id_kom`) REFERENCES `komentarze` (`id_komentarza`),
  ADD CONSTRAINT `komentarze_ibfk_2` FOREIGN KEY (`id_art`) REFERENCES `artykuly` (`id_artykulu`),
  ADD CONSTRAINT `komentarze_ibfk_3` FOREIGN KEY (`id_konta`) REFERENCES `konta` (`id_konta`),
  ADD CONSTRAINT `komentarze_ibfk_4` FOREIGN KEY (`id_komentarza`) REFERENCES `komentarze` (`id_kom`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

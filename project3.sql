-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 28 jun 2024 om 00:05
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project3`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `berichten`
--

CREATE TABLE `berichten` (
  `bericht_ID` int(11) NOT NULL,
  `inhoud` text NOT NULL,
  `publicatiedatum` datetime DEFAULT current_timestamp(),
  `gebruiker_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `berichten`
--

INSERT INTO `berichten` (`bericht_ID`, `inhoud`, `publicatiedatum`, `gebruiker_ID`) VALUES
(1, 'yo yo', '2024-06-27 17:34:42', 1),
(2, 'heyy', '2024-06-27 17:36:42', 2),
(6, 'ik ben max!!!', '2024-06-27 23:57:03', 3),
(8, 'sdfjklsdjf', '2024-06-27 23:59:49', 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `gebruikers_ID` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`gebruikers_ID`, `naam`, `email`, `wachtwoord`) VALUES
(1, 'Enes', 'e.salimoski@gmail.com', '$2y$10$KooEP3YrGKRY99Nc76jpL.NKXezNYK8suv7J1KDmpL1u4pE0Yf0em'),
(2, 'John', 'dudealbino@gmail.com', '$2y$10$Yq9nkFKZ5d6SgR7ib4LO4O1QjGdt2CD4DwwH4ypurHADswQR7oy16'),
(3, 'Max', 'curiousinil@code-gmail.com', '$2y$10$C6uCwpeWPNy469jcbfqJ6u3Rf2Kte9bQVuTGLC7pDsJysJ0pvd8P6'),
(4, 'Joost', '9021645@student.tcrmbo.nl', '$2y$10$kZ8Dq1pe.e.xxM55/09wh.oOt3f0mmnVUPMzk19Am43cBIMqWQDzK');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reacties`
--

CREATE TABLE `reacties` (
  `reactie_ID` int(11) NOT NULL,
  `bericht_ID` int(11) DEFAULT NULL,
  `gebruiker_ID` int(11) DEFAULT NULL,
  `inhoud` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reacties`
--

INSERT INTO `reacties` (`reactie_ID`, `bericht_ID`, `gebruiker_ID`, `inhoud`) VALUES
(1, 1, 1, 'hey!'),
(4, 1, 4, 'esfdsiufkdsfds');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vrienden`
--

CREATE TABLE `vrienden` (
  `vriend_ID` int(11) NOT NULL,
  `gebruiker1_ID` int(11) DEFAULT NULL,
  `gebruiker2_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vrienden`
--

INSERT INTO `vrienden` (`vriend_ID`, `gebruiker1_ID`, `gebruiker2_ID`) VALUES
(1, 2, 1),
(2, 4, 1),
(3, 4, 3);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `berichten`
--
ALTER TABLE `berichten`
  ADD PRIMARY KEY (`bericht_ID`),
  ADD KEY `gebruiker_ID` (`gebruiker_ID`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`gebruikers_ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `reacties`
--
ALTER TABLE `reacties`
  ADD PRIMARY KEY (`reactie_ID`),
  ADD KEY `bericht_ID` (`bericht_ID`),
  ADD KEY `gebruiker_ID` (`gebruiker_ID`);

--
-- Indexen voor tabel `vrienden`
--
ALTER TABLE `vrienden`
  ADD PRIMARY KEY (`vriend_ID`),
  ADD KEY `gebruiker1_ID` (`gebruiker1_ID`),
  ADD KEY `gebruiker2_ID` (`gebruiker2_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `berichten`
--
ALTER TABLE `berichten`
  MODIFY `bericht_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `gebruikers_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `reacties`
--
ALTER TABLE `reacties`
  MODIFY `reactie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `vrienden`
--
ALTER TABLE `vrienden`
  MODIFY `vriend_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `berichten`
--
ALTER TABLE `berichten`
  ADD CONSTRAINT `berichten_ibfk_1` FOREIGN KEY (`gebruiker_ID`) REFERENCES `gebruikers` (`gebruikers_ID`);

--
-- Beperkingen voor tabel `reacties`
--
ALTER TABLE `reacties`
  ADD CONSTRAINT `reacties_ibfk_1` FOREIGN KEY (`bericht_ID`) REFERENCES `berichten` (`bericht_ID`),
  ADD CONSTRAINT `reacties_ibfk_2` FOREIGN KEY (`gebruiker_ID`) REFERENCES `gebruikers` (`gebruikers_ID`);

--
-- Beperkingen voor tabel `vrienden`
--
ALTER TABLE `vrienden`
  ADD CONSTRAINT `vrienden_ibfk_1` FOREIGN KEY (`gebruiker1_ID`) REFERENCES `gebruikers` (`gebruikers_ID`),
  ADD CONSTRAINT `vrienden_ibfk_2` FOREIGN KEY (`gebruiker2_ID`) REFERENCES `gebruikers` (`gebruikers_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

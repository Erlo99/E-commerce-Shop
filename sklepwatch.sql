-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Czas generowania: 24 Cze 2020, 16:19
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklepwatch`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `send` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_product`, `quantity`, `send`) VALUES
(1, 1, 1, 3, 1),
(1, 1, 3, 4, 1),
(1, 1, 1, 3, 1),
(1, 1, 3, 4, 1),
(2, 2, 1, 1, 1),
(2, 2, 2, 4, 1),
(3, 4, 1, 1, 1),
(3, 4, 2, 4, 1),
(4, 6, 2, 11, 1),
(4, 6, 3, 4, 1),
(5, 9, 1, 1, 0),
(6, 9, 1, 1, 1),
(7, 9, 1, 1, 0),
(8, 9, 1, 1, 0),
(9, 9, 1, 1, 0),
(10, 9, 1, 1, 1),
(11, 9, 1, 1, 0),
(11, 9, 2, 1, 0),
(12, 9, 1, 1, 0),
(12, 9, 2, 1, 0),
(13, 9, 2, 1, 0),
(14, 9, 1, 1, 0),
(14, 9, 2, 1, 0),
(15, 9, 1, 1, 0),
(15, 9, 2, 1, 0),
(16, 9, 1, 1, 0),
(16, 9, 2, 1, 0),
(17, 9, 1, 1, 0),
(17, 9, 2, 1, 0),
(18, 9, 1, 1, 0),
(18, 9, 2, 1, 0),
(19, 9, 1, 1, 0),
(19, 9, 2, 1, 0),
(20, 9, 1, 1, 0),
(20, 9, 2, 1, 0),
(21, 9, 1, 1, 0),
(21, 9, 2, 1, 0),
(22, 9, 1, 1, 1),
(22, 9, 2, 1, 1),
(23, 9, 1, 1, 0),
(24, 9, 1, 1, 0),
(25, 9, 1, 1, 0),
(26, 9, 1, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `Price` varchar(10) NOT NULL,
  `Stock` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id_product`, `title`, `description`, `Price`, `Stock`, `img`) VALUES
(1, 'Zegarek fajny', 'Seamlessly empower fully researched growth strategies and interoperable internal or “organic” sources. Credibly innovate granular internal or “organic” sources whereas high standards in web-readiness. Credibly innovate granular internal or organic sources whereas high standards in web-readiness. Energistically scale future-proof core competencies vis-a-vis impactful experiences. Dramatically synthesize integrated schemas. with optimal networks.123', '19.99', 48, 'https://i.imgur.com/52EyMd1.png'),
(2, 'Zegarek super', 'Seamlessly empower fully researched growth strategies and interoperable internal or “organic” sources. Credibly innovate granular internal or “organic” sources whereas high standards in web-readiness. Credibly innovate granular internal or organic sources whereas high standards in web-readiness. Energistically scale future-proof core competencies vis-a-vis impactful experiences. Dramatically synthesize integrated schemas. with optimal networks.123', '99.99', 5, 'https://i.imgur.com/ofLAWH8.png'),
(3, 'Zegarek 123', 'Seamlessly empower fully researched growth strategies and interoperable internal or “organic” sources. Credibly innovate granular internal or “organic” sources whereas high standards in web-readiness. Credibly innovate granular internal or organic sources whereas high standards in web-readiness. Energistically scale future-proof core competencies vis-a-vis impactful experiences. Dramatically synthesize integrated schemas. with optimal networks.', '199.99', 50, 'https://i.imgur.com/qOC4feS.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_user` int(20) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `country` varchar(20) DEFAULT NULL,
  `adress1` varchar(50) DEFAULT NULL,
  `adress2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `phone` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_user`, `first`, `last`, `password`, `email`, `country`, `adress1`, `adress2`, `city`, `district`, `zip`, `phone`) VALUES
(1, 'Eryk', 'Mikroas', '123456789', 'eryk@wp.pl', 'Poland', 'zlota', NULL, 'warsaw', 'mazovia', '00000', '789456123'),
(2, 'Robert', 'Mikroas', '123456789', 'email@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '789458923'),
(3, 'Joachim', 'Pitos', 'qwerty123', 'jojo@wp.pl', 'Poland', 'new world 2/74', NULL, 'Wroclaw', NULL, '00000', '789578123'),
(4, 'Kacper', 'Siegiej', 'espass123', 'kacsie@onet.pl', 'poland', 'kalinoska 3/54', 'floor 4', 'Poznan', NULL, '45986', '476456123'),
(5, 'Kamila', 'Kalinowska', 'jhsdgjasas', 'faryn@giga.es', NULL, NULL, NULL, NULL, NULL, NULL, '682456123'),
(6, 'Magdalena', 'Krakuska', 'dasdsadas', 'magkra@poczta.fm', NULL, NULL, NULL, NULL, NULL, NULL, '785756123'),
(7, 'Marek', 'Kowalski', 'asdasdas', 'mareczek@hotline.com', NULL, NULL, NULL, NULL, NULL, NULL, '725656123'),
(8, 'Jakub', 'Ostasz', 'fasfasf', 'jakub@ostasz.pl', NULL, NULL, NULL, NULL, NULL, NULL, '789885123'),
(9, 'Leonidas', 'Spartarian', '$2y$10$pO.3QrnBfL6cY9eYgYj5Iut3J3q6pTwQJMheq5y.FijhGdUQbYyIO', '123@123', 'Poland', 'new world 2/74', 'osiedle', 'Warszawa', 'Mazovia', NULL, '789542165'),
(11, 'qweqweqwe', 'qweqweqwe', '$2y$10$p1ReKnZiztQOlxGF.1I23.PuWHxI1OvzFfD0WDjjrbGtQpT0GzIh.', 'qwe@qwe.com', NULL, NULL, NULL, NULL, NULL, NULL, '123123123'),
(12, 'qweqweqwe', 'qwed', '$2y$10$PPd/1wUpCdxP/lkqrAak/.NhKWUnz4QOXI.pDrQ7u9GJnMhvYGI8W', 'ewq@ewq.pl', NULL, NULL, NULL, NULL, NULL, NULL, '321321321'),
(13, 'yuoi', 'yui', '$2y$10$gKAZ1BjfilJgWTGTBDWL4.JnqH4Yl51htLgE29/ubPFlvtPPrpElu', 'yuiyui@rty.com', NULL, NULL, NULL, NULL, NULL, NULL, '678678678'),
(14, 'hbdfgdf', 'dfgdfg', '$2y$10$LD.dkQTnyksfQ2PQaBNeQOELEQCflt.ueiK5xCjTMDbVXd7q1py.C', '789@fdsfs.com', NULL, NULL, NULL, NULL, NULL, NULL, '789789789');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `workers`
--

CREATE TABLE `workers` (
  `id_worker` int(11) NOT NULL,
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `workers`
--

INSERT INTO `workers` (`id_worker`, `first`, `last`, `role`, `login`, `password`) VALUES
(1, 'Kacper', 'Szapałów', 'admin', 'admin', '$2y$10$7lmry13qV0Gj1VMwwDERx.bJbwbNp5JF8M.4969cRmnnK1k/AMZCy'),
(6, 'qweqweqwe', '234', 'pracownik', '234', '$2y$10$mP7Ulx6pzaQO7iYfIISMmOtIB4SdJC9KzuqZW0p7xoKz9qPuFBLNm'),
(8, 'qweqweqwe', '234', 'pracownik', '234', '$2y$10$XXt3E/Df7SoeeoHGvYgGpevv/U6S6TqKjB.1dONN1foBhV8Adhak2'),
(10, 'Daniel', 'Naumczak', 'pracownik', 'dwork', '$2y$10$w7Q54d7I/jhPLNP7K9JhQO7WVqbGXtwjpZsRHN49yreb67CEb8de.');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id_users` (`id_user`) USING BTREE;

--
-- Indeksy dla tabeli `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id_worker`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `workers`
--
ALTER TABLE `workers`
  MODIFY `id_worker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 17-Jan-2016 às 00:01
-- Versão do servidor: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdg_foz_todo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `category`, `path_icon`, `path_thumb`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Trabalho', '/uploads/categories/trabalho.jpg', '/uploads/categories/trabalho-icon.png', '#3F51B5', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Lazer', '/uploads/categories/lazer.jpg', '/uploads/categories/lazer-icon.png', '#43A047', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Família', '/uploads/categories/familia.jpg', '/uploads/categories/familia-icon.png', '#E57373', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Estudos', '/uploads/categories/estudos.jpg', '/uploads/categories/estudos-icon.png', '#9C27B0', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Viagem', '/uploads/categories/viagem.jpg', '/uploads/categories/viagem-icon.png', '#FFC107', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Projetos pessoais', '/uploads/categories/projetos-pessoais.jpg', '/uploads/categories/projetos-pessoais-icon.png', '#F06292', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

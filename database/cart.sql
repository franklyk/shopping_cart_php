-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29-Abr-2021 às 22:48
-- Versão do servidor: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_temporary`
--

CREATE TABLE `cart_temporary` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_cover` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `cart_value` decimal(10,2) NOT NULL,
  `cart_quantity` int(11) NOT NULL,
  `cart_total` decimal(10,2) NOT NULL,
  `cart_status` int(11) NOT NULL,
  `cart_session` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_cover` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_headline` varchar(255) NOT NULL,
  `product_link` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`product_id`, `product_cover`, `product_name`, `product_headline`, `product_link`, `product_price`, `product_stock`, `product_status`) VALUES
(1, 'camiseta-vermelha.png', 'Camiseta Vermelha', 'Aliquam egestas tristique nunc sed vestibulum. Nulla aliquam ex at sapien condimentum molestie', 'camiseta-vermelha', '25.00', 80, 1),
(2, 'camiseta-verde.png', 'Camiseta Verde', 'Aliquam egestas tristique nunc sed vestibulum. Nulla aliquam ex at sapien condimentum molestie', 'camiseta-verde', '29.97', 0, 1),
(3, 'camiseta-azul.png', 'Camiseta Azul', 'Aliquam egestas tristique nunc sed vestibulum. Nulla aliquam ex at sapien condimentum molestie', 'camiseta-azul', '35.00', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_temporary`
--
ALTER TABLE `cart_temporary`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `Cart_ProdId` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `ProdtId` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_temporary`
--
ALTER TABLE `cart_temporary`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cart_temporary`
--
ALTER TABLE `cart_temporary`
  ADD CONSTRAINT `fk_cart_prod` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2023 a las 01:57:53
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soporteit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocurrencias`
--

CREATE TABLE `ocurrencias` (
  `idocurrencias` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `equipo` varchar(200) DEFAULT NULL,
  `lugar` varchar(200) DEFAULT NULL,
  `suceso` varchar(200) DEFAULT NULL,
  `estado` varchar(200) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `urlfile` varchar(200) DEFAULT NULL,
  `extfile` varchar(200) DEFAULT NULL,
  `idusers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ocurrencias`
--

INSERT INTO `ocurrencias` (`idocurrencias`, `nombre`, `equipo`, `lugar`, `suceso`, `estado`, `fecha`, `urlfile`, `extfile`, `idusers`) VALUES
(17, 'user@it.com', 'Laptop', 'Aula 315', 'Pantalla en blanco', 'PROCESO', '2023-01-28', 'files/17id7bjsu_1674955185.jpg', 'jpg', 2),
(18, 'user@it.com', 'Equipo celular', 'Coordinacion Inicial', 'pantalla rota', 'PENDIENTE', '2023-01-28', 'files/18idbne2s_1674955232.jpg', 'jpg', 2),
(19, 'user2@it.com', 'Impresora', 'Aula 210', 'Se acabo la tinta', 'CERRADO', '2023-01-28', 'files/19idr3i0g_1674955384.jpg', 'jpg', 8),
(20, 'admin@it.com', 'LAPTOP', 'OFICINA', 'MANTENIMIENTO', 'CERRADO', '2023-03-20', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idusers` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nivel` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`idusers`, `email`, `password`, `nivel`) VALUES
(1, 'admin@it.com', 'admin123', '01'),
(2, 'user@it.com', 'user123', '02'),
(8, 'user2@it.com', 'user2', '02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ocurrencias`
--
ALTER TABLE `ocurrencias`
  ADD PRIMARY KEY (`idocurrencias`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idusers`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ocurrencias`
--
ALTER TABLE `ocurrencias`
  MODIFY `idocurrencias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idusers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

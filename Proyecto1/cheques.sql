-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2024 a las 03:29:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `conciliacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheques`
--

CREATE TABLE `cheques` (
  `numero_cheque` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `beneficiario` varchar(5) NOT NULL,
  `monto` varchar(10) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `fecha_anulado` date DEFAULT NULL,
  `detalle_anulado` varchar(200) DEFAULT NULL,
  `fecha_circulacion` date DEFAULT NULL,
  `fecha_reintegro` date DEFAULT NULL,
  `codigo_objeto1` varchar(3) NOT NULL,
  `monto_objeto1` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cheques`
--

INSERT INTO `cheques` (`numero_cheque`, `fecha`, `beneficiario`, `monto`, `descripcion`, `fecha_anulado`, `detalle_anulado`, `fecha_circulacion`, `fecha_reintegro`, `codigo_objeto1`, `monto_objeto1`) VALUES
('629', '2023-01-19', '00014', '267.50', '', '0000-00-00', '', '2023-02-28', '0000-00-00', '180', 267.50),
('630', '2023-02-14', '00015', '801.59', 'Compra de una laptop.', '0000-00-00', ' ', '2023-07-31', '0000-00-00', '380', 801.59),
('631', '2023-02-14', '00016', '8938.41', 'Materiales y mano de obra para confeccionar piso.', '0000-00-00', ' ', '2023-03-17', '0000-00-00', '180', 8938.41),
('632', '2023-02-14', '00016', '1059.30', 'Materiales y mano de obra para la reparación de muro.', '0000-00-00', ' ', '2023-03-03', '0000-00-00', '180', 1059.30),
('633', '2023-02-14', '00000', '0.00', '', '2023-02-14', 'Error en escritura de nombre.', '0000-00-00', '0000-00-00', '', 0.00),
('634', '2023-02-14', '00000', '0.00', '', '2023-02-14', 'Error en escritura de valor.', '0000-00-00', '0000-00-00', '', 0.00),
('635', '2023-02-14', '00016', '230.05', 'Adquisición de mesa', '0000-00-00', ' ', '2023-03-17', '0000-00-00', '320', 230.05),
('636', '2023-02-14', '00000', '0.00', '', '2023-02-14', 'Se eliminó el trámite.', '0000-00-00', '0000-00-00', '', 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cheques`
--
ALTER TABLE `cheques`
  ADD UNIQUE KEY `indice` (`numero_cheque`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

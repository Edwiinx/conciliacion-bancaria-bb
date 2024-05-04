-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2024 a las 03:30:30
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
-- Estructura de tabla para la tabla `objeto_gasto`
--

CREATE TABLE `objeto_gasto` (
  `codigo` varchar(3) NOT NULL,
  `detalle` varchar(150) NOT NULL,
  `objeto` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `objeto_gasto`
--

INSERT INTO `objeto_gasto` (`codigo`, `detalle`, `objeto`) VALUES
('120', 'Impresión, Encuadernación y otros', '1'),
('130', 'Información y Publicidad', '1'),
('141', 'Viáticos dentro del país', '1'),
('151', 'Transporte dentro del país', '1'),
('169', 'Otros Servicios', '1'),
('180', 'Mantenimiento y Reparación', '1'),
('181', 'Mantenimiento y Reparación de Edificios', '1'),
('182', 'Mantenimiento de Maquinarias y Otros Equipos', '1'),
('183', 'Mantenimiento de Mobiliario y Equipo de Oficina', '1'),
('185', 'Mantenimiento de Equipos de Computación', '1'),
('189', 'Otros Mantenimientos y Reparaciones', '1'),
('200', 'Alimentos y Bebidas', '2'),
('210', 'Textiles y Vestuarios', '2'),
('220', 'Combustibles y Lubricantes', '2'),
('230', 'Productos de Papel y Cartón ', '2'),
('240', 'Productos Químicos y Conexos', '2'),
('250', 'Otros Materiales de Construcción', '2'),
('260', 'Productos Varios', '2'),
('262', 'Herramientas', '2'),
('265', 'Materiales, Accesorios y Suministros de Computación', '2'),
('270', 'Útiles y Materiales Diversos', '2'),
('280', 'Repuestos', '2'),
('320', 'Equipo Educacional y Recreativo', '3'),
('340', 'Equipo de Oficina', '3'),
('350', 'Mobiliario de Oficina', '3'),
('370', 'Maquinarias y Equipos Varios', '3'),
('380', 'Equipo de Computación', '3');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `objeto_gasto`
--
ALTER TABLE `objeto_gasto`
  ADD UNIQUE KEY `codigo` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

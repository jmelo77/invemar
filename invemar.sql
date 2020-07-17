-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2020 a las 11:06:06
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `invemar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especies`
--

CREATE TABLE `especies` (
  `id` int(11) NOT NULL,
  `especie` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `familia` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_comun` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proyecto` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `base_del_registro` text COLLATE utf8_unicode_ci,
  `identificador` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ano_identificacion` int(11) DEFAULT NULL,
  `departamento` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipio` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitud` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitud` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_captura` date DEFAULT NULL,
  `ecorregion` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `especies`
--

INSERT INTO `especies` (`id`, `especie`, `familia`, `nombre_comun`, `proyecto`, `base_del_registro`, `identificador`, `ano_identificacion`, `departamento`, `municipio`, `localidad`, `latitud`, `longitud`, `autor`, `fecha_captura`, `ecorregion`) VALUES
(2, 'Cardinalis', 'Fringllidae', 'Cardenal Norteño', 'Sggfsgd', 'gsdsgsdf', 'dgdsgd', 2020, 'Gdgsdgds', 'Eesrew', 'dgdgsgf', '2452', '45354', 'fdgfgsd', '2020-07-23', 'fadsafssadf'),
(3, 'sample', 'dadfsf', 'dfsdsds', 'Fdsdfsf', 'sfasasfds', 'dsadf', 2009, 'Dfssdd', 'Dsdds', 'dfsdsa', '45234', '5443', 'dsdsds', '2020-07-30', 'dsasd'),
(4, 'teterwter', 'rwwe', 'fasf', 'dsfssaf', 'fadsdaf', 'wqrq', 2012, 'wrew', 'tewr', 'rere', '3425', '432', 'adsafd', '2020-07-31', 'asffad');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `especies`
--
ALTER TABLE `especies`
  ADD UNIQUE KEY `identificador` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `especies`
--
ALTER TABLE `especies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

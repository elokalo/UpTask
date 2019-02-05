-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-02-2019 a las 11:50:40
-- Versión del servidor: 5.7.23
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `uptask`
--
CREATE DATABASE IF NOT EXISTS `uptask` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `uptask`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre`) VALUES
(1, 'Tienda Virtual'),
(2, 'Blog de  Música'),
(3, 'Página Hospital'),
(4, 'Plataforma Educativa'),
(5, 'Diseño Página Web'),
(6, 'Página de Cine'),
(7, 'Copia de Facebook'),
(8, 'Copia de Instagram'),
(9, 'Blog para Cocina'),
(10, 'Copia YouTube'),
(11, 'Platillas de Wordpress'),
(12, 'Pagina de Manualidades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

DROP TABLE IF EXISTS `tareas`;
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '0',
  `id_proyecto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proyecto` (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `nombre`, `estado`, `id_proyecto`) VALUES
(1, 'Agregar Productos', 1, 1),
(2, 'Agregar Discos', 0, 2),
(3, 'Lista de Precios', 1, 1),
(4, 'Agregar Médicos', 0, 3),
(5, 'Agregar Directores', 0, 6),
(6, 'Agregar Pacientes', 0, 3),
(9, 'Agregar Géneros', 0, 2),
(15, 'Agregar Menú del Día', 0, 9),
(16, 'Eliminar Productos', 1, 1),
(17, 'Actualizar Productos', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
(1, '1', '$2y$12$zhrF.FoNQqRd.e9W3a.kvu1wrUOdTcFGDvk2VJocbIyj6OBHszcWm'),
(2, '1', '$2y$12$qQbfvYQcy0T.4wukbVyvY.mg1xvDl2FUuelP64ZGWe.cvQXG2g6p.'),
(3, 'elokalo', '$2y$12$Ff4e1WZ0UQil5WlYxdNmAekAKYjjtYr.W8HsWuoUCsZwkxzAWrFcC'),
(4, 'lacy', '$2y$12$ncNAN9DFlkwxRrbdnFQkPOkcnzeZgiz8LmdLVZFHOTfiUgIbSfViC'),
(5, 'lacy', '$2y$12$duPi7NvwVxSOaqz2oWq2hOi5fItmizjb7.giARs84IzynRwIbns1G'),
(6, 'admin', '$2y$12$yz0PSF8mV/vM0lDtTvcoA.J9gFugNCMwgsyvnPzey1gmwsyAgz3wK');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

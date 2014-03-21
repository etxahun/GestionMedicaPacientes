-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-03-2014 a las 20:44:33
-- Versión del servidor: 5.5.33
-- Versión de PHP: 5.4.4-14+deb7u7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `hamabide`
--
CREATE DATABASE `hamabide` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hamabide`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultasucesivas`
--

CREATE TABLE IF NOT EXISTS `consultasucesivas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechas_sucesivas` varchar(200) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evolutivos`
--

CREATE TABLE IF NOT EXISTS `evolutivos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `fecha_evolutivo` text NOT NULL,
  `evolutivo` text NOT NULL,
  `paciente_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Volcado de datos para la tabla `evolutivos`
--

INSERT INTO `evolutivos` (`id`, `fecha_evolutivo`, `evolutivo`, `paciente_id`) VALUES
(46, 'MjAxNC0wMy0xMg==', 'QWl0b3IgaGEgbGxlZ2FkbyBiYXN0YW50ZSBsb2thdGlzLg==', 'MzI='),
(48, 'MjAxNC0wMy0xMQ==', 'QWl0b3Igc2UgZW5jdWVudHJhIGV4dHJhw7FhbWVudGUgY2FsbWFkby4=', 'MzI='),
(49, 'MjAxNC0wMy0xMA==', 'S2FrYSBkZSBsYSB2YWNhLg==', 'MzI='),
(50, 'MjAxNC0wMy0wOA==', 'T3RyYSB2YWNhIGxvY2Eu', 'MzI='),
(61, 'MjAxNC0wMy0xMw==', 'RWwgcGFjaWVudGUgc2UgZW5jdWVudHJhIHBlcmZlY3RhbWVudGUuIFByb2NlZGVtb3MgYSBzdSBBbHRhIG3DqWRpY2Eu', 'MzI='),
(62, 'MjAxNC0wMy0xMg==', 'aXVhZ2RpdWFzaXVzYWdpdXNhZ2ZpdWFzZ2ZpdQ==', 'MzM='),
(63, 'MjAxNC0wMy0xMg==', 'b2lkZ29peWRzb2dpeQ==', 'MzM=');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiaclinica`
--

CREATE TABLE IF NOT EXISTS `historiaclinica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `motivo_consulta` text NOT NULL,
  `anteced_pers` text NOT NULL,
  `anteced_fam` text NOT NULL,
  `expl_psico` text NOT NULL,
  `pruebas_compl` text NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento_farma` text NOT NULL,
  `alergias` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `historiaclinica`
--

INSERT INTO `historiaclinica` (`id`, `paciente_id`, `motivo_consulta`, `anteced_pers`, `anteced_fam`, `expl_psico`, `pruebas_compl`, `diagnostico`, `tratamiento_farma`, `alergias`) VALUES
(26, 30, 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg=='),
(27, 33, 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==', 'Tm8gcGFyZWNlIG11eSBlc3RhYmxlLg==');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientedatos`
--

CREATE TABLE IF NOT EXISTS `pacientedatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL,
  `direccion` text NOT NULL,
  `dni` varchar(20) NOT NULL,
  `telefono_habitual` varchar(20) NOT NULL,
  `telefono_alternativo` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `derivacion` text NOT NULL,
  `fecha_prim_consulta` date NOT NULL,
  `estado_alta` varchar(20) NOT NULL DEFAULT 'En Tratamiento',
  `fecha_alta` date NOT NULL,
  `facultativo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `pacientedatos`
--

INSERT INTO `pacientedatos` (`id`, `nombre`, `apellidos`, `fecha_nac`, `direccion`, `dni`, `telefono_habitual`, `telefono_alternativo`, `email`, `derivacion`, `fecha_prim_consulta`, `estado_alta`, `fecha_alta`, `facultativo`) VALUES
(32, 'QWl0b3I=', 'VXJraWRp', '1981-12-10', 'U2FudGEgQW5hIEV0b3JiaWRlYQ==', 'OTg2OTg2MDk4Ng==', 'MDk4NjA5MDk4Nw==', 'NTM2MzYzNjM2MzY=', 'YXVya2lkaUBtYWlsLm5ldA==', 'SG9zcGl0YWwgZGUgQ3J1Y2VzLg==', '2014-01-09', 'Alta', '2014-03-13', 'QW1haWE='),
(33, 'TWlrZWw=', 'R29ycm90eGF0ZWdp', '1981-12-10', 'U2FudGEgQW5hIGthbGVh', 'MTYwNzY5NDE=', 'Njg1NzAwODg4', 'OTQ0MDIyOTk5', 'bWdvcnJvQGdtYWlsLmNvbQ==', 'QXJlZXRha28gQW5idWxhdG9yaWEu', '2014-01-12', 'En Tratamiento', '0000-00-00', 'QW1haWE=');
--
-- Base de datos: `loginhamabide`
--
CREATE DATABASE `loginhamabide` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `loginhamabide`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `active_guests`
--

CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `active_guests`
--

INSERT INTO `active_guests` (`ip`, `timestamp`) VALUES
('192.168.0.6', 1395430778);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `active_users`
--

INSERT INTO `active_users` (`username`, `timestamp`) VALUES
('amaia', 1395430748);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banned_users`
--

CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `config_name` varchar(20) NOT NULL,
  `config_value` varchar(50) NOT NULL,
  KEY `config_name` (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`config_name`, `config_value`) VALUES
('ACCOUNT_ACTIVATION', '1'),
('TRACK_VISITORS', '1'),
('max_user_chars', '30'),
('min_user_chars', '5'),
('max_pass_chars', '100'),
('min_pass_chars', '6'),
('EMAIL_FROM_NAME', 'Hamabide Base de Datos'),
('EMAIL_FROM_ADDR', 'etxahun.sanchez@hamabide.com'),
('EMAIL_WELCOME', '0'),
('SITE_NAME', 'Hamabide'),
('SITE_DESC', 'Hamabide Base de Datos'),
('WEB_ROOT', 'https://192.168.0.205/hamabide11/'),
('ENABLE_CAPTCHA', '0'),
('COOKIE_EXPIRE', '100'),
('COOKIE_PATH', '/'),
('home_page', 'main.php'),
('ALL_LOWERCASE', '0'),
('Version', '3.2'),
('USER_TIMEOUT', '10'),
('GUEST_TIMEOUT', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `usersalt` varchar(8) NOT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `actkey` varchar(35) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `regdate` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `password`, `usersalt`, `userid`, `userlevel`, `email`, `timestamp`, `actkey`, `ip`, `regdate`) VALUES
('admin', '7724c6cecd7fc9dcf3db8f0be335552cbe6f167c', 'GTFb19bi', '1127a1e36daffbe48b7c8b82e8dcef33', 9, 'etxahun.sanchez@gmail.com', 1394139843, 'iaCg7HbB1LHlHtKD', '::1', 1393794157),
('amaia', 'b4372f01b720f389f5655d626fa3e43a7e6ca9d3', 'FfENcEdL', 'e9c76d25a12088c19ba74a03c90556ef', 9, 'amaia@amaia.eu', 1395430748, 'a8x77NP87dCmNp1w', '::1', 1393968766),
('mirari', 'ff36ccc3cf563f68ae58a87bcc0dd6577aca6f19', 'qqGQYTdS', 'ce178f9bf074c54704bbddaf1135d239', 3, 'mirari@mirari.es', 1395424991, 'mfxoP6CpWqrq4iX8', '::1', 1393968803);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

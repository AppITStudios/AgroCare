-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-04-2015 a las 22:24:58
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: '840159'
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'admins'
--

CREATE TABLE IF NOT EXISTS admins (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  lastname varchar(45) NOT NULL,
  email varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'credenciales'
--

CREATE TABLE IF NOT EXISTS credenciales (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'crop'
--

CREATE TABLE IF NOT EXISTS crop (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  size double NOT NULL,
  season date NOT NULL,
  `user` varchar(60) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'crop_alert'
--

CREATE TABLE IF NOT EXISTS crop_alert (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_crop int(11) NOT NULL,
  lat double NOT NULL,
  lon double NOT NULL,
  `type` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL,
  description varchar(100) NOT NULL,
  img varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'test_markers'
--

CREATE TABLE IF NOT EXISTS test_markers (
  lat double DEFAULT NULL,
  lng double DEFAULT NULL,
  dats varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'usuarios'
--

CREATE TABLE IF NOT EXISTS usuarios (
  email varchar(60) NOT NULL,
  `name` varchar(45) NOT NULL,
  lastname varchar(45) DEFAULT NULL,
  active varchar(2) NOT NULL,
  enabled varchar(2) NOT NULL,
  signup_fb varchar(2) NOT NULL,
  userpic_path varchar(300) DEFAULT NULL,
  country varchar(50) DEFAULT NULL,
  city varchar(50) DEFAULT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2023 a las 18:54:24
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `atletismo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'luis', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbitros`
--

CREATE TABLE `arbitros` (
  `arbitro_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `nivel` varchar(100) NOT NULL,
  `hora_inicio_personalizada` datetime DEFAULT NULL,
  `hora_fin_personalizada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arbitros`
--

INSERT INTO `arbitros` (`arbitro_id`, `nombre`, `apellido`, `dni`, `usuario`, `contrasena`, `nivel`, `hora_inicio_personalizada`, `hora_fin_personalizada`) VALUES
(7, 'juanito ', 'Ramírez  días ', '75902205', '1000001', '$2y$10$010tYSYnXNFz8ZLFwgXPYu19GkNUL1EBK8swxR7DE1JSIBAKV1b5S', '21', '2023-11-17 07:42:00', '2023-11-17 13:42:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atletas`
--

CREATE TABLE `atletas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `dni` int(8) NOT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `distrito` varchar(100) NOT NULL,
  `nacimiento` date DEFAULT NULL,
  `institucion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `atletas`
--

INSERT INTO `atletas` (`id`, `nombre`, `apellido`, `genero`, `dni`, `pais`, `departamento`, `provincia`, `distrito`, `nacimiento`, `institucion`) VALUES
(1, 'luis', 'diaz salu', 'M', 65747731, 'PERU', 'Huánuco', 'Huánuco', 'AMARILIS ', '2000-01-01', 'ISAAC NEWTON '),
(2, 'juan', 'diaz maiz', 'M', 65747732, 'PERU', 'Huánuco', 'Huánuco', 'AMARILIS ', '2000-02-02', 'ISAAC NEWTON '),
(5, 'fisher', 'saluj diaz', 'M', 65747735, 'PERU', 'Huánuco', 'Huánuco', 'AMARILIS ', '2001-05-05', 'ISAAC NEWTON '),
(7, 'ericka', 'verde ojeda', 'F', 65747737, 'PERU', 'Huánuco', 'Huánuco', 'AMARILIS ', '2001-07-07', 'ISAAC NEWTON '),
(8, 'anabel', 'santa cruz  davila', 'F', 65747738, 'PERU', 'Huánuco', 'Huánuco', 'AMARILIS ', '2002-08-08', 'ISAAC NEWTON '),
(11, 'hugo ', 'juanante ', 'M', 34544453, 'PERU', 'HUANUCO', 'HUANUCO', 'AMARILIS', '2014-11-14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_3kmmarcha_cb`
--

CREATE TABLE `resultados_3kmmarcha_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_5kmmarcha_cb`
--

CREATE TABLE `resultados_5kmmarcha_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_5kmmarcha_cc`
--

CREATE TABLE `resultados_5kmmarcha_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_10kmmarcha_cc`
--

CREATE TABLE `resultados_10kmmarcha_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_60metrosvallas_ca`
--

CREATE TABLE `resultados_60metrosvallas_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_60metrosvallas_ca`
--

INSERT INTO `resultados_60metrosvallas_ca` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(5, 65747735, 0, 0, 0, '', 'DISTRITAL'),
(5, 65747735, 0, 0, 0, '', 'DISTRITAL'),
(5, 65747735, 0, 0, 0, '', 'DISTRITAL'),
(5, 65747735, 0, 0, 0, '', 'DISTRITAL'),
(5, 65747735, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_60metros_ca`
--

CREATE TABLE `resultados_60metros_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_80metrosplanos_cb`
--

CREATE TABLE `resultados_80metrosplanos_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_80metrosplanos_cb`
--

INSERT INTO `resultados_80metrosplanos_cb` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'PROVINCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_80metrosvallas_cb`
--

CREATE TABLE `resultados_80metrosvallas_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_100metrosconvallas_cc`
--

CREATE TABLE `resultados_100metrosconvallas_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_100metrosplanos_cc`
--

CREATE TABLE `resultados_100metrosplanos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_100metrosplanos_cc`
--

INSERT INTO `resultados_100metrosplanos_cc` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_100metrosvallas_cb`
--

CREATE TABLE `resultados_100metrosvallas_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_110metrosconvallas_cc`
--

CREATE TABLE `resultados_110metrosconvallas_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_150metrosplanos_cb`
--

CREATE TABLE `resultados_150metrosplanos_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_200metrosplanos_cc`
--

CREATE TABLE `resultados_200metrosplanos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_400metrosplanos_cc`
--

CREATE TABLE `resultados_400metrosplanos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_600metrosplanos_ca`
--

CREATE TABLE `resultados_600metrosplanos_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_600metrosplanos_ca`
--

INSERT INTO `resultados_600metrosplanos_ca` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(5, 65747735, 0, 0, 0, '', 'PROVINCIAL'),
(1, 65747731, 0, 0, 0, '', 'PROVINCIAL'),
(1, 65747731, 0, 0, 0, '', 'REGIONAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_800metrosplanos_cb`
--

CREATE TABLE `resultados_800metrosplanos_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_1500metrosplanos_cc`
--

CREATE TABLE `resultados_1500metrosplanos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_2000mconobstaculos_cc`
--

CREATE TABLE `resultados_2000mconobstaculos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_2000mconobstaculos_cc`
--

INSERT INTO `resultados_2000mconobstaculos_cc` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_2000metrosplanos_cb`
--

CREATE TABLE `resultados_2000metrosplanos_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_2000metrosplanos_cb`
--

INSERT INTO `resultados_2000metrosplanos_cb` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_3000metrosplanos_cc`
--

CREATE TABLE `resultados_3000metrosplanos_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_hexatlon_cb`
--

CREATE TABLE `resultados_hexatlon_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `100mConVallas_Dia1` float DEFAULT NULL,
  `ImpulsionBala_Dia1` float DEFAULT NULL,
  `SaltoLargo_Dia1` float DEFAULT NULL,
  `LanzamientoJabalina_Dia2` float DEFAULT NULL,
  `SaltoAlto_Dia2` float DEFAULT NULL,
  `Distancia_800m_Dia2` float DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_hexatlon_cb`
--

INSERT INTO `resultados_hexatlon_cb` (`ID_Atleta`, `DNI_Atleta`, `100mConVallas_Dia1`, `ImpulsionBala_Dia1`, `SaltoLargo_Dia1`, `LanzamientoJabalina_Dia2`, `SaltoAlto_Dia2`, `Distancia_800m_Dia2`, `Nivel`) VALUES
(8, 65747738, 0, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 0, 'DISTRITAL'),
(7, 65747737, 0, 0, 0, 0, 0, 0, 'DISTRITAL'),
(1, 65747731, 0, 0, 0, 0, 0, 0, 'REGIONAL'),
(1, 65747731, 0, 0, 0, 0, 0, 0, 'REGIONAL'),
(1, 65747731, 0, 0, 0, 0, 0, 0, 'REGIONAL'),
(1, 65747731, 0, 0, 0, 0, 0, 0, 'REGIONAL'),
(1, 65747731, 0, 0, 0, 0, 0, 0, 'PROVINCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_hexatlon_cc`
--

CREATE TABLE `resultados_hexatlon_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `CienMetrosVallas_Dia1` float DEFAULT NULL,
  `ImpulsionBala_Dia1` float DEFAULT NULL,
  `SaltoLargo_Dia1` float DEFAULT NULL,
  `LanzamientoJabalina_Dia2` float DEFAULT NULL,
  `SaltoAlto_Dia2` float DEFAULT NULL,
  `Distancia_800m_Dia2` float DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_impulsionbala3kg_cb`
--

CREATE TABLE `resultados_impulsionbala3kg_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_impulsionbala3kg_cc`
--

CREATE TABLE `resultados_impulsionbala3kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_impulsionbala4kg_cb`
--

CREATE TABLE `resultados_impulsionbala4kg_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_impulsionbala5kg_cc`
--

CREATE TABLE `resultados_impulsionbala5kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientodisco1.5kg_cc`
--

CREATE TABLE `resultados_lanzamientodisco1.5kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientodisco1kg_cb`
--

CREATE TABLE `resultados_lanzamientodisco1kg_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientodisco1kg_cc`
--

CREATE TABLE `resultados_lanzamientodisco1kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientodisco750g_cb`
--

CREATE TABLE `resultados_lanzamientodisco750g_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientojabalina500gr_cc`
--

CREATE TABLE `resultados_lanzamientojabalina500gr_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientojabalina500g_cb`
--

CREATE TABLE `resultados_lanzamientojabalina500g_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientojabalina600g_cb`
--

CREATE TABLE `resultados_lanzamientojabalina600g_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_lanzamientojabalina600g_cb`
--

INSERT INTO `resultados_lanzamientojabalina600g_cb` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientojabalina700gr_cc`
--

CREATE TABLE `resultados_lanzamientojabalina700gr_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientomartillo3kg_cb`
--

CREATE TABLE `resultados_lanzamientomartillo3kg_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_lanzamientomartillo3kg_cb`
--

INSERT INTO `resultados_lanzamientomartillo3kg_cb` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientomartillo3kg_cc`
--

CREATE TABLE `resultados_lanzamientomartillo3kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientomartillo4kg_cb`
--

CREATE TABLE `resultados_lanzamientomartillo4kg_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientomartillo5kg_cc`
--

CREATE TABLE `resultados_lanzamientomartillo5kg_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_lanzamientopelota_ca`
--

CREATE TABLE `resultados_lanzamientopelota_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_pentatlon_cb`
--

CREATE TABLE `resultados_pentatlon_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `80mConVallas_Dia1` float DEFAULT NULL,
  `ImpulsionBala_Dia1` float DEFAULT NULL,
  `SaltoLargo_Dia1` float DEFAULT NULL,
  `SaltoAlto_Dia2` float DEFAULT NULL,
  `Distancia_600m_Dia2` float DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_pentatlon_cb`
--

INSERT INTO `resultados_pentatlon_cb` (`ID_Atleta`, `DNI_Atleta`, `80mConVallas_Dia1`, `ImpulsionBala_Dia1`, `SaltoLargo_Dia1`, `SaltoAlto_Dia2`, `Distancia_600m_Dia2`, `Nivel`) VALUES
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(8, 65747738, 0, 0, 0, 0, 0, 'DISTRITAL'),
(7, 65747737, 0, 0, 0, 0, 0, 'REGIONAL'),
(5, 65747735, 0, 0, 0, 0, 0, 'DISTRITAL'),
(5, 65747735, 0, 0, 0, 0, 0, 'DISTRITAL'),
(5, 65747735, 0, 0, 0, 0, 0, 'DISTRITAL'),
(11, 34544453, 0, 0, 0, 0, 0, 'DISTRITAL'),
(1, 65747731, 0, 0, 0, 0, 0, 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_pentatlon_cc`
--

CREATE TABLE `resultados_pentatlon_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `CienMetrosVallas_Dia1` float DEFAULT NULL,
  `ImpulsionBala_Dia1` float DEFAULT NULL,
  `SaltoLargo_Dia1` float DEFAULT NULL,
  `SaltoAlto_Dia2` float DEFAULT NULL,
  `Distancia_600m_Dia2` float DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_pentatlon_cc`
--

INSERT INTO `resultados_pentatlon_cc` (`ID_Atleta`, `DNI_Atleta`, `CienMetrosVallas_Dia1`, `ImpulsionBala_Dia1`, `SaltoLargo_Dia1`, `SaltoAlto_Dia2`, `Distancia_600m_Dia2`, `Nivel`) VALUES
(NULL, 65747731, 0, 0, 0, 0, 0, 'distrital'),
(NULL, 0, NULL, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 0, NULL, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 0, NULL, NULL, NULL, NULL, NULL, 'distrital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_relevo4x50metros_ca`
--

CREATE TABLE `resultados_relevo4x50metros_ca` (
  `ID_Atleta1` int(11) DEFAULT NULL,
  `DNI_Atleta1` int(11) DEFAULT NULL,
  `ID_Atleta2` int(11) DEFAULT NULL,
  `DNI_Atleta2` int(11) DEFAULT NULL,
  `ID_Atleta3` int(11) DEFAULT NULL,
  `DNI_Atleta3` int(11) DEFAULT NULL,
  `ID_Atleta4` int(11) DEFAULT NULL,
  `DNI_Atleta4` int(11) DEFAULT NULL,
  `Resultado` varchar(255) DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_relevo4x50metros_ca`
--

INSERT INTO `resultados_relevo4x50metros_ca` (`ID_Atleta1`, `DNI_Atleta1`, `ID_Atleta2`, `DNI_Atleta2`, `ID_Atleta3`, `DNI_Atleta3`, `ID_Atleta4`, `DNI_Atleta4`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 2, 65747732, 5, 65747735, 7, 65747737, '0.0', 0, 0, '', 'DISTRITAL'),
(1, 65747731, 2, 65747732, 5, 65747735, 7, 65747737, '0.0', 0, 0, '', 'REGIONAL'),
(1, 65747731, 2, 65747732, 5, 65747735, 7, 65747737, '0.0', 0, 0, '', 'PROVINCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_relevo4x100metros_cc`
--

CREATE TABLE `resultados_relevo4x100metros_cc` (
  `ID_Atleta1` int(11) DEFAULT NULL,
  `DNI_Atleta1` int(11) DEFAULT NULL,
  `ID_Atleta2` int(11) DEFAULT NULL,
  `DNI_Atleta2` int(11) DEFAULT NULL,
  `ID_Atleta3` int(11) DEFAULT NULL,
  `DNI_Atleta3` int(11) DEFAULT NULL,
  `ID_Atleta4` int(11) DEFAULT NULL,
  `DNI_Atleta4` int(11) DEFAULT NULL,
  `Resultado` varchar(255) DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_relevo4x100metros_cc`
--

INSERT INTO `resultados_relevo4x100metros_cc` (`ID_Atleta1`, `DNI_Atleta1`, `ID_Atleta2`, `DNI_Atleta2`, `ID_Atleta3`, `DNI_Atleta3`, `ID_Atleta4`, `DNI_Atleta4`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(NULL, 65747731, NULL, 65747731, NULL, 65747731, NULL, 65747731, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, NULL, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 0, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 0, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 0, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 0, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 0, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 432423, NULL, NULL, NULL, NULL, 'distrital'),
(NULL, 2147483647, NULL, 23232, NULL, 323232, NULL, 432423, NULL, NULL, NULL, NULL, 'distrital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_relevo5x80metros_cb`
--

CREATE TABLE `resultados_relevo5x80metros_cb` (
  `ID_Atleta1` int(11) DEFAULT NULL,
  `DNI_Atleta1` int(11) DEFAULT NULL,
  `ID_Atleta2` int(11) DEFAULT NULL,
  `DNI_Atleta2` int(11) DEFAULT NULL,
  `ID_Atleta3` int(11) DEFAULT NULL,
  `DNI_Atleta3` int(11) DEFAULT NULL,
  `ID_Atleta4` int(11) DEFAULT NULL,
  `DNI_Atleta4` int(11) DEFAULT NULL,
  `ID_Atleta5` int(11) DEFAULT NULL,
  `DNI_Atleta5` int(11) DEFAULT NULL,
  `Resultado` varchar(255) DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltoalto_ca`
--

CREATE TABLE `resultados_saltoalto_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltoalto_cb`
--

CREATE TABLE `resultados_saltoalto_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltoalto_cc`
--

CREATE TABLE `resultados_saltoalto_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltocongarrocha_cc`
--

CREATE TABLE `resultados_saltocongarrocha_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltogarrocha_cb`
--

CREATE TABLE `resultados_saltogarrocha_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_saltogarrocha_cb`
--

INSERT INTO `resultados_saltogarrocha_cb` (`ID_Atleta`, `DNI_Atleta`, `Resultado`, `Lugar`, `Serie`, `Pista`, `Nivel`) VALUES
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(1, 65747731, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL'),
(7, 65747737, 0, 0, 0, '', 'DISTRITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltolargoconimpulso_cc`
--

CREATE TABLE `resultados_saltolargoconimpulso_cc` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltolargoimpulso_cb`
--

CREATE TABLE `resultados_saltolargoimpulso_cb` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_saltolargo_ca`
--

CREATE TABLE `resultados_saltolargo_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `Resultado` float DEFAULT NULL,
  `Lugar` int(11) DEFAULT NULL,
  `Serie` int(11) DEFAULT NULL,
  `Pista` varchar(255) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_tetratlon_ca`
--

CREATE TABLE `resultados_tetratlon_ca` (
  `ID_Atleta` int(11) DEFAULT NULL,
  `DNI_Atleta` int(11) DEFAULT NULL,
  `LanzamientoPelota_Dia1` float DEFAULT NULL,
  `LanzamientoPelota_Lugar_Dia1` int(11) DEFAULT NULL,
  `Vallas_60m_Dia1` float DEFAULT NULL,
  `Vallas_60m_Lugar_Dia1` int(11) DEFAULT NULL,
  `SaltoLargo_Dia2` float DEFAULT NULL,
  `SaltoLargo_Lugar_Dia2` int(11) DEFAULT NULL,
  `Distancia_600m_Dia2` float DEFAULT NULL,
  `Distancia_600m_Lugar_Dia2` int(11) DEFAULT NULL,
  `Nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_tetratlon_ca`
--

INSERT INTO `resultados_tetratlon_ca` (`ID_Atleta`, `DNI_Atleta`, `LanzamientoPelota_Dia1`, `LanzamientoPelota_Lugar_Dia1`, `Vallas_60m_Dia1`, `Vallas_60m_Lugar_Dia1`, `SaltoLargo_Dia2`, `SaltoLargo_Lugar_Dia2`, `Distancia_600m_Dia2`, `Distancia_600m_Lugar_Dia2`, `Nivel`) VALUES
(1, 65747731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DISTRITAL'),
(1, 65747731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PROVINCIAL'),
(1, 65747731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'REGIONAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_reset`
--

CREATE TABLE `solicitud_reset` (
  `solicitud_id` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `dni` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_reset`
--

INSERT INTO `solicitud_reset` (`solicitud_id`, `telefono`, `fecha_solicitud`, `dni`) VALUES
(3, '921567261', '2023-11-15 15:55:07', 75902205);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `arbitros`
--
ALTER TABLE `arbitros`
  ADD PRIMARY KEY (`arbitro_id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `atletas`
--
ALTER TABLE `atletas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultados_3kmmarcha_cb`
--
ALTER TABLE `resultados_3kmmarcha_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_5kmmarcha_cb`
--
ALTER TABLE `resultados_5kmmarcha_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_5kmmarcha_cc`
--
ALTER TABLE `resultados_5kmmarcha_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_10kmmarcha_cc`
--
ALTER TABLE `resultados_10kmmarcha_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_60metrosvallas_ca`
--
ALTER TABLE `resultados_60metrosvallas_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_60metros_ca`
--
ALTER TABLE `resultados_60metros_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_80metrosplanos_cb`
--
ALTER TABLE `resultados_80metrosplanos_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_80metrosvallas_cb`
--
ALTER TABLE `resultados_80metrosvallas_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_100metrosconvallas_cc`
--
ALTER TABLE `resultados_100metrosconvallas_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_100metrosplanos_cc`
--
ALTER TABLE `resultados_100metrosplanos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_100metrosvallas_cb`
--
ALTER TABLE `resultados_100metrosvallas_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_110metrosconvallas_cc`
--
ALTER TABLE `resultados_110metrosconvallas_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_150metrosplanos_cb`
--
ALTER TABLE `resultados_150metrosplanos_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_200metrosplanos_cc`
--
ALTER TABLE `resultados_200metrosplanos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_400metrosplanos_cc`
--
ALTER TABLE `resultados_400metrosplanos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_600metrosplanos_ca`
--
ALTER TABLE `resultados_600metrosplanos_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_800metrosplanos_cb`
--
ALTER TABLE `resultados_800metrosplanos_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_1500metrosplanos_cc`
--
ALTER TABLE `resultados_1500metrosplanos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_2000mconobstaculos_cc`
--
ALTER TABLE `resultados_2000mconobstaculos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_2000metrosplanos_cb`
--
ALTER TABLE `resultados_2000metrosplanos_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_3000metrosplanos_cc`
--
ALTER TABLE `resultados_3000metrosplanos_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_hexatlon_cb`
--
ALTER TABLE `resultados_hexatlon_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_hexatlon_cc`
--
ALTER TABLE `resultados_hexatlon_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_impulsionbala3kg_cb`
--
ALTER TABLE `resultados_impulsionbala3kg_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_impulsionbala3kg_cc`
--
ALTER TABLE `resultados_impulsionbala3kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_impulsionbala4kg_cb`
--
ALTER TABLE `resultados_impulsionbala4kg_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_impulsionbala5kg_cc`
--
ALTER TABLE `resultados_impulsionbala5kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientodisco1.5kg_cc`
--
ALTER TABLE `resultados_lanzamientodisco1.5kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientodisco1kg_cb`
--
ALTER TABLE `resultados_lanzamientodisco1kg_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientodisco1kg_cc`
--
ALTER TABLE `resultados_lanzamientodisco1kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientodisco750g_cb`
--
ALTER TABLE `resultados_lanzamientodisco750g_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientojabalina500gr_cc`
--
ALTER TABLE `resultados_lanzamientojabalina500gr_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientojabalina500g_cb`
--
ALTER TABLE `resultados_lanzamientojabalina500g_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientojabalina600g_cb`
--
ALTER TABLE `resultados_lanzamientojabalina600g_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientojabalina700gr_cc`
--
ALTER TABLE `resultados_lanzamientojabalina700gr_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientomartillo3kg_cb`
--
ALTER TABLE `resultados_lanzamientomartillo3kg_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientomartillo3kg_cc`
--
ALTER TABLE `resultados_lanzamientomartillo3kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientomartillo4kg_cb`
--
ALTER TABLE `resultados_lanzamientomartillo4kg_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientomartillo5kg_cc`
--
ALTER TABLE `resultados_lanzamientomartillo5kg_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_lanzamientopelota_ca`
--
ALTER TABLE `resultados_lanzamientopelota_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_pentatlon_cb`
--
ALTER TABLE `resultados_pentatlon_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_pentatlon_cc`
--
ALTER TABLE `resultados_pentatlon_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_relevo4x50metros_ca`
--
ALTER TABLE `resultados_relevo4x50metros_ca`
  ADD KEY `ID_Atleta1` (`ID_Atleta1`),
  ADD KEY `ID_Atleta2` (`ID_Atleta2`),
  ADD KEY `ID_Atleta3` (`ID_Atleta3`),
  ADD KEY `ID_Atleta4` (`ID_Atleta4`);

--
-- Indices de la tabla `resultados_relevo4x100metros_cc`
--
ALTER TABLE `resultados_relevo4x100metros_cc`
  ADD KEY `ID_Atleta1` (`ID_Atleta1`),
  ADD KEY `ID_Atleta2` (`ID_Atleta2`),
  ADD KEY `ID_Atleta3` (`ID_Atleta3`),
  ADD KEY `ID_Atleta4` (`ID_Atleta4`);

--
-- Indices de la tabla `resultados_relevo5x80metros_cb`
--
ALTER TABLE `resultados_relevo5x80metros_cb`
  ADD KEY `ID_Atleta1` (`ID_Atleta1`),
  ADD KEY `ID_Atleta2` (`ID_Atleta2`),
  ADD KEY `ID_Atleta3` (`ID_Atleta3`),
  ADD KEY `ID_Atleta4` (`ID_Atleta4`),
  ADD KEY `ID_Atleta5` (`ID_Atleta5`);

--
-- Indices de la tabla `resultados_saltoalto_ca`
--
ALTER TABLE `resultados_saltoalto_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltoalto_cb`
--
ALTER TABLE `resultados_saltoalto_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltoalto_cc`
--
ALTER TABLE `resultados_saltoalto_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltocongarrocha_cc`
--
ALTER TABLE `resultados_saltocongarrocha_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltogarrocha_cb`
--
ALTER TABLE `resultados_saltogarrocha_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltolargoconimpulso_cc`
--
ALTER TABLE `resultados_saltolargoconimpulso_cc`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltolargoimpulso_cb`
--
ALTER TABLE `resultados_saltolargoimpulso_cb`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_saltolargo_ca`
--
ALTER TABLE `resultados_saltolargo_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `resultados_tetratlon_ca`
--
ALTER TABLE `resultados_tetratlon_ca`
  ADD KEY `ID_Atleta` (`ID_Atleta`);

--
-- Indices de la tabla `solicitud_reset`
--
ALTER TABLE `solicitud_reset`
  ADD PRIMARY KEY (`solicitud_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `arbitros`
--
ALTER TABLE `arbitros`
  MODIFY `arbitro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `atletas`
--
ALTER TABLE `atletas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `solicitud_reset`
--
ALTER TABLE `solicitud_reset`
  MODIFY `solicitud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resultados_3kmmarcha_cb`
--
ALTER TABLE `resultados_3kmmarcha_cb`
  ADD CONSTRAINT `resultados_3kmmarcha_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_5kmmarcha_cb`
--
ALTER TABLE `resultados_5kmmarcha_cb`
  ADD CONSTRAINT `resultados_5kmmarcha_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_5kmmarcha_cc`
--
ALTER TABLE `resultados_5kmmarcha_cc`
  ADD CONSTRAINT `resultados_5kmmarcha_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_10kmmarcha_cc`
--
ALTER TABLE `resultados_10kmmarcha_cc`
  ADD CONSTRAINT `resultados_10kmmarcha_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_60metrosvallas_ca`
--
ALTER TABLE `resultados_60metrosvallas_ca`
  ADD CONSTRAINT `resultados_60metrosvallas_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_60metros_ca`
--
ALTER TABLE `resultados_60metros_ca`
  ADD CONSTRAINT `resultados_60metros_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_80metrosplanos_cb`
--
ALTER TABLE `resultados_80metrosplanos_cb`
  ADD CONSTRAINT `resultados_80metrosplanos_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_80metrosvallas_cb`
--
ALTER TABLE `resultados_80metrosvallas_cb`
  ADD CONSTRAINT `resultados_80metrosvallas_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_100metrosconvallas_cc`
--
ALTER TABLE `resultados_100metrosconvallas_cc`
  ADD CONSTRAINT `resultados_100metrosconvallas_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_100metrosplanos_cc`
--
ALTER TABLE `resultados_100metrosplanos_cc`
  ADD CONSTRAINT `resultados_100metrosplanos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_100metrosvallas_cb`
--
ALTER TABLE `resultados_100metrosvallas_cb`
  ADD CONSTRAINT `resultados_100metrosvallas_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_110metrosconvallas_cc`
--
ALTER TABLE `resultados_110metrosconvallas_cc`
  ADD CONSTRAINT `resultados_110metrosconvallas_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_150metrosplanos_cb`
--
ALTER TABLE `resultados_150metrosplanos_cb`
  ADD CONSTRAINT `resultados_150metrosplanos_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_200metrosplanos_cc`
--
ALTER TABLE `resultados_200metrosplanos_cc`
  ADD CONSTRAINT `resultados_200metrosplanos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_400metrosplanos_cc`
--
ALTER TABLE `resultados_400metrosplanos_cc`
  ADD CONSTRAINT `resultados_400metrosplanos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_600metrosplanos_ca`
--
ALTER TABLE `resultados_600metrosplanos_ca`
  ADD CONSTRAINT `resultados_600metrosplanos_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_800metrosplanos_cb`
--
ALTER TABLE `resultados_800metrosplanos_cb`
  ADD CONSTRAINT `resultados_800metrosplanos_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_1500metrosplanos_cc`
--
ALTER TABLE `resultados_1500metrosplanos_cc`
  ADD CONSTRAINT `resultados_1500metrosplanos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_2000mconobstaculos_cc`
--
ALTER TABLE `resultados_2000mconobstaculos_cc`
  ADD CONSTRAINT `resultados_2000mconobstaculos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_2000metrosplanos_cb`
--
ALTER TABLE `resultados_2000metrosplanos_cb`
  ADD CONSTRAINT `resultados_2000metrosplanos_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_3000metrosplanos_cc`
--
ALTER TABLE `resultados_3000metrosplanos_cc`
  ADD CONSTRAINT `resultados_3000metrosplanos_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_hexatlon_cb`
--
ALTER TABLE `resultados_hexatlon_cb`
  ADD CONSTRAINT `resultados_hexatlon_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_hexatlon_cc`
--
ALTER TABLE `resultados_hexatlon_cc`
  ADD CONSTRAINT `resultados_hexatlon_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_impulsionbala3kg_cb`
--
ALTER TABLE `resultados_impulsionbala3kg_cb`
  ADD CONSTRAINT `resultados_impulsionbala3kg_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_impulsionbala3kg_cc`
--
ALTER TABLE `resultados_impulsionbala3kg_cc`
  ADD CONSTRAINT `resultados_impulsionbala3kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_impulsionbala4kg_cb`
--
ALTER TABLE `resultados_impulsionbala4kg_cb`
  ADD CONSTRAINT `resultados_impulsionbala4kg_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_impulsionbala5kg_cc`
--
ALTER TABLE `resultados_impulsionbala5kg_cc`
  ADD CONSTRAINT `resultados_impulsionbala5kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientodisco1.5kg_cc`
--
ALTER TABLE `resultados_lanzamientodisco1.5kg_cc`
  ADD CONSTRAINT `resultados_lanzamientodisco1.5kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientodisco1kg_cb`
--
ALTER TABLE `resultados_lanzamientodisco1kg_cb`
  ADD CONSTRAINT `resultados_lanzamientodisco1kg_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientodisco1kg_cc`
--
ALTER TABLE `resultados_lanzamientodisco1kg_cc`
  ADD CONSTRAINT `resultados_lanzamientodisco1kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientodisco750g_cb`
--
ALTER TABLE `resultados_lanzamientodisco750g_cb`
  ADD CONSTRAINT `resultados_lanzamientodisco750g_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientojabalina500gr_cc`
--
ALTER TABLE `resultados_lanzamientojabalina500gr_cc`
  ADD CONSTRAINT `resultados_lanzamientojabalina500gr_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientojabalina500g_cb`
--
ALTER TABLE `resultados_lanzamientojabalina500g_cb`
  ADD CONSTRAINT `resultados_lanzamientojabalina500g_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientojabalina600g_cb`
--
ALTER TABLE `resultados_lanzamientojabalina600g_cb`
  ADD CONSTRAINT `resultados_lanzamientojabalina600g_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientojabalina700gr_cc`
--
ALTER TABLE `resultados_lanzamientojabalina700gr_cc`
  ADD CONSTRAINT `resultados_lanzamientojabalina700gr_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientomartillo3kg_cb`
--
ALTER TABLE `resultados_lanzamientomartillo3kg_cb`
  ADD CONSTRAINT `resultados_lanzamientomartillo3kg_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientomartillo3kg_cc`
--
ALTER TABLE `resultados_lanzamientomartillo3kg_cc`
  ADD CONSTRAINT `resultados_lanzamientomartillo3kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientomartillo4kg_cb`
--
ALTER TABLE `resultados_lanzamientomartillo4kg_cb`
  ADD CONSTRAINT `resultados_lanzamientomartillo4kg_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientomartillo5kg_cc`
--
ALTER TABLE `resultados_lanzamientomartillo5kg_cc`
  ADD CONSTRAINT `resultados_lanzamientomartillo5kg_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_lanzamientopelota_ca`
--
ALTER TABLE `resultados_lanzamientopelota_ca`
  ADD CONSTRAINT `resultados_lanzamientopelota_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_pentatlon_cb`
--
ALTER TABLE `resultados_pentatlon_cb`
  ADD CONSTRAINT `resultados_pentatlon_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_pentatlon_cc`
--
ALTER TABLE `resultados_pentatlon_cc`
  ADD CONSTRAINT `resultados_pentatlon_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_relevo4x50metros_ca`
--
ALTER TABLE `resultados_relevo4x50metros_ca`
  ADD CONSTRAINT `resultados_relevo4x50metros_ca_ibfk_1` FOREIGN KEY (`ID_Atleta1`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x50metros_ca_ibfk_2` FOREIGN KEY (`ID_Atleta2`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x50metros_ca_ibfk_3` FOREIGN KEY (`ID_Atleta3`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x50metros_ca_ibfk_4` FOREIGN KEY (`ID_Atleta4`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_relevo4x100metros_cc`
--
ALTER TABLE `resultados_relevo4x100metros_cc`
  ADD CONSTRAINT `resultados_relevo4x100metros_cc_ibfk_1` FOREIGN KEY (`ID_Atleta1`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x100metros_cc_ibfk_2` FOREIGN KEY (`ID_Atleta2`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x100metros_cc_ibfk_3` FOREIGN KEY (`ID_Atleta3`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo4x100metros_cc_ibfk_4` FOREIGN KEY (`ID_Atleta4`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_relevo5x80metros_cb`
--
ALTER TABLE `resultados_relevo5x80metros_cb`
  ADD CONSTRAINT `resultados_relevo5x80metros_cb_ibfk_1` FOREIGN KEY (`ID_Atleta1`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo5x80metros_cb_ibfk_2` FOREIGN KEY (`ID_Atleta2`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo5x80metros_cb_ibfk_3` FOREIGN KEY (`ID_Atleta3`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo5x80metros_cb_ibfk_4` FOREIGN KEY (`ID_Atleta4`) REFERENCES `atletas` (`id`),
  ADD CONSTRAINT `resultados_relevo5x80metros_cb_ibfk_5` FOREIGN KEY (`ID_Atleta5`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltoalto_ca`
--
ALTER TABLE `resultados_saltoalto_ca`
  ADD CONSTRAINT `resultados_saltoalto_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltoalto_cb`
--
ALTER TABLE `resultados_saltoalto_cb`
  ADD CONSTRAINT `resultados_saltoalto_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltoalto_cc`
--
ALTER TABLE `resultados_saltoalto_cc`
  ADD CONSTRAINT `resultados_saltoalto_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltocongarrocha_cc`
--
ALTER TABLE `resultados_saltocongarrocha_cc`
  ADD CONSTRAINT `resultados_saltocongarrocha_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltogarrocha_cb`
--
ALTER TABLE `resultados_saltogarrocha_cb`
  ADD CONSTRAINT `resultados_saltogarrocha_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltolargoconimpulso_cc`
--
ALTER TABLE `resultados_saltolargoconimpulso_cc`
  ADD CONSTRAINT `resultados_saltolargoconimpulso_cc_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltolargoimpulso_cb`
--
ALTER TABLE `resultados_saltolargoimpulso_cb`
  ADD CONSTRAINT `resultados_saltolargoimpulso_cb_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_saltolargo_ca`
--
ALTER TABLE `resultados_saltolargo_ca`
  ADD CONSTRAINT `resultados_saltolargo_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);

--
-- Filtros para la tabla `resultados_tetratlon_ca`
--
ALTER TABLE `resultados_tetratlon_ca`
  ADD CONSTRAINT `resultados_tetratlon_ca_ibfk_1` FOREIGN KEY (`ID_Atleta`) REFERENCES `atletas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

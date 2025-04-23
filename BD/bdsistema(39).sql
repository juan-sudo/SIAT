-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2023 a las 19:26:04
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdsistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio`
--

CREATE TABLE `anio` (
  `Id_Anio` int(11) NOT NULL,
  `NomAnio` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anio`
--

INSERT INTO `anio` (`Id_Anio`, `NomAnio`) VALUES
(1, '2023'),
(2, '2022'),
(3, '2021'),
(4, '2020'),
(5, '2019'),
(6, '2018'),
(7, '2017'),
(8, '2016');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_antiguedad`
--

CREATE TABLE `anio_antiguedad` (
  `Id_Anio_Antiguedad` int(11) NOT NULL,
  `Anio_Antiguedad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anio_antiguedad`
--

INSERT INTO `anio_antiguedad` (`Id_Anio_Antiguedad`, `Anio_Antiguedad`) VALUES
(1, 'Hasta 5'),
(2, 'Hasta 10'),
(3, 'Hasta 15'),
(4, 'Hasta 20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arancel`
--

CREATE TABLE `arancel` (
  `Id_Arancel` int(11) NOT NULL,
  `Id_Anio` int(11) DEFAULT NULL,
  `Importe` decimal(10,2) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arancel`
--

INSERT INTO `arancel` (`Id_Arancel`, `Id_Anio`, `Importe`, `Fecha`) VALUES
(1, 1, 12.00, '2023-11-14 02:03:46'),
(2, 1, 20.00, '2023-11-14 02:03:49'),
(3, 2, 70.00, '2023-11-15 01:19:07'),
(4, 2, 90.00, '2023-11-15 01:19:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arancel_rustico`
--

CREATE TABLE `arancel_rustico` (
  `Id_Arancel_Rustico` int(11) NOT NULL,
  `Arancel` decimal(10,2) NOT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `arancel_rustico`
--

INSERT INTO `arancel_rustico` (`Id_Arancel_Rustico`, `Arancel`, `Id_Anio`, `Fecha`) VALUES
(1, 1823.00, 1, '2023-11-14 03:41:12'),
(2, 2000.00, 2, '2023-11-15 01:46:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arancel_rustico_hectarea`
--

CREATE TABLE `arancel_rustico_hectarea` (
  `Id_Arancel_Rustico_Hectarea` int(11) NOT NULL,
  `Id_Arancel_Rustico` int(11) NOT NULL,
  `Id_valores_categoria_x_hectarea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `arancel_rustico_hectarea`
--

INSERT INTO `arancel_rustico_hectarea` (`Id_Arancel_Rustico_Hectarea`, `Id_Arancel_Rustico`, `Id_valores_categoria_x_hectarea`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arancel_vias`
--

CREATE TABLE `arancel_vias` (
  `Id_Arancel_Vias` int(11) NOT NULL,
  `Id_Arancel` int(11) NOT NULL,
  `Id_Ubica_Vias_Urbano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `arancel_vias`
--

INSERT INTO `arancel_vias` (`Id_Arancel_Vias`, `Id_Arancel`, `Id_Ubica_Vias_Urbano`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(11, 3, 1),
(12, 3, 2),
(13, 4, 3),
(14, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbitrios`
--

CREATE TABLE `arbitrios` (
  `Id_Arbitrios` int(11) NOT NULL,
  `Categoria` char(1) DEFAULT NULL,
  `Monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arbitrios`
--

INSERT INTO `arbitrios` (`Id_Arbitrios`, `Categoria`, `Monto`) VALUES
(1, 'A', 10.00),
(2, 'B', 8.00),
(3, 'C', 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `Id_Area` int(11) NOT NULL,
  `Nombre_Area` varchar(200) NOT NULL,
  `Estado_Area` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`Id_Area`, `Nombre_Area`, `Estado_Area`) VALUES
(1, 'Informatica', '1'),
(2, 'Administracion', '1'),
(4, 'Recursos huamanos', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `base_imponible`
--

CREATE TABLE `base_imponible` (
  `Id_Baseimponible` int(11) NOT NULL,
  `Anio` varchar(4) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `Fecha_RM` datetime NOT NULL,
  `Id_Contribuyente` int(11) NOT NULL,
  `Numeo_Predios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ventas` int(11) DEFAULT NULL,
  `egresos` decimal(10,2) DEFAULT NULL,
  `gastos` decimal(10,2) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `monto_inicial`, `fecha_apertura`, `fecha_cierre`, `monto_final`, `total_ventas`, `egresos`, `gastos`, `estado`, `id_usuario`) VALUES
(1, 1000.00, '2023-06-06', NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calidad_agricola`
--

CREATE TABLE `calidad_agricola` (
  `Id_Calidad_Agricola` int(11) NOT NULL,
  `Categoria_Calidad_Agricola` varchar(20) NOT NULL,
  `Nombre_Grupo_Tierra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calidad_agricola`
--

INSERT INTO `calidad_agricola` (`Id_Calidad_Agricola`, `Categoria_Calidad_Agricola`, `Nombre_Grupo_Tierra`) VALUES
(1, 'A1', 'Tierras aptas para cultivo en limpio - Calidad Alta A1'),
(2, 'A2', 'Tierras aptas para cultivo en limpio - Calidad Media A2'),
(3, 'A3', 'Tierras aptas para cultivo en limpio - Calidad Baja A3'),
(4, 'C1', 'Tierras aptas para cultivo permanente - Calidad Alta C1'),
(5, 'C2', 'Tierras aptas para cultivo permanente - Calidad Media C2'),
(6, 'C3', 'Tierras aptas para cultivo permanente - Calidad Baja C3'),
(7, 'P1', 'Tierras aptas para pastos - Calidad Alta P1 '),
(8, 'P1', 'Tierras aptas para pastos - Calidad media P2 '),
(9, 'P3', 'Tierras aptas para pastos - Calidad Baja P3'),
(10, 'E', 'Terreno Eriazo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catastro`
--

CREATE TABLE `catastro` (
  `Id_Catastro` int(11) NOT NULL,
  `Codigo_Catastral` char(20) DEFAULT NULL,
  `Numero_Bloque` char(2) DEFAULT NULL,
  `Numero_Ubicacion` char(10) DEFAULT NULL,
  `Numero_Lote` char(2) DEFAULT NULL,
  `Codigo_COFOPRI` char(9) DEFAULT NULL,
  `Referencia` varchar(250) DEFAULT NULL,
  `Id_Ubica_Vias_Urbano` int(11) DEFAULT NULL,
  `Numero_Departamento` int(11) DEFAULT NULL,
  `Fecha_Registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catastro`
--

INSERT INTO `catastro` (`Id_Catastro`, `Codigo_Catastral`, `Numero_Bloque`, `Numero_Ubicacion`, `Numero_Lote`, `Codigo_COFOPRI`, `Referencia`, `Id_Ubica_Vias_Urbano`, `Numero_Departamento`, `Fecha_Registro`) VALUES
(1, 'U22151113-1', '45', '12', '12', '12', '45', 3, 1263, '2023-11-14 17:16:43'),
(2, 'U22151113-2', '43', '23', '2', '34', 'FREN AL PAQUE', 3, 5, '2023-11-14 17:16:55'),
(8, 'U12191112-8', '33', '33', '33', '33', '33', 2, 33, '2023-11-14 20:21:04'),
(9, 'U12191112-9', '32', '23', '34', '23', 'FRENTE AL PARQUE', 2, 32, '2023-11-14 20:21:16'),
(12, 'U22151114-12', '12', '121', '21', '21', '21', 4, 21, '2023-11-14 20:24:06'),
(13, 'U22151114-13', '12', '121', '21', '21', '21', 4, 21, '2023-11-14 20:24:18'),
(14, 'U22151114-14', '12', '121', '21', '21', '21', 4, 21, '2023-11-14 20:24:30'),
(15, 'U22151114-15', '12', '121', '21', '21', '21', 4, 21, '2023-11-14 20:24:33'),
(16, 'U22151114-16', '12', '121', '21', '21', '21', 4, 21, '2023-11-14 20:25:13'),
(17, 'U22151114-17', '21', '12', '12', '12', '21', 4, 21, '2023-11-14 20:29:58'),
(18, 'U12191112-18', '34', '23', '23', '3', 'FRENTE AL PARQUE', 2, 4, '2023-11-14 20:47:44'),
(25, 'U12191111-25', '21', '12', '12', '21', '21', 1, 21, '2023-11-14 21:03:12'),
(26, 'U22151113-26', '32', '23', '32', '32', '32', 3, 32, '2023-11-14 21:42:02'),
(27, 'U22151114-27', '12', '23', '23', '12', '12', 4, 12, '2023-11-17 12:28:51'),
(28, 'U12191112-28', '33', '33', '33', '33', '33', 2, 33, '2023-11-17 12:31:20'),
(29, 'U12191111-29', '2', '2', '2', '2', '2', 1, 2, '2023-11-17 12:36:33'),
(30, 'U22151113-30', '32', '23', '23', '32', '32', 3, 32, '2023-11-22 20:25:21'),
(31, 'U22151113-31', '32', '23', '23', '32', '32', 3, 32, '2023-11-22 20:25:46'),
(32, 'U22151113-32', '32', '23', '23', '32', '32', 3, 32, '2023-11-22 20:27:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catastro_rural`
--

CREATE TABLE `catastro_rural` (
  `Id_Catastro_Rural` int(11) NOT NULL,
  `Codigo_Catastral` varchar(20) NOT NULL,
  `Id_valores_categoria_x_hectarea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catastro_rural`
--

INSERT INTO `catastro_rural` (`Id_Catastro_Rural`, `Codigo_Catastral`, `Id_valores_categoria_x_hectarea`) VALUES
(23, 'R13271-23', 7),
(31, 'R13131-31', 3),
(32, 'R13131-32', 3),
(33, 'R13131-33', 3),
(34, 'R13131-34', 3),
(35, 'R124141-35', 14),
(36, 'R124141-36', 14),
(37, 'R124141-37', 14),
(38, 'R124141-38', 14),
(39, 'R11391-39', 9),
(40, 'R11251-40', 5),
(41, 'R11251-41', 5),
(42, 'R11251-42', 5),
(43, 'R11251-43', 5),
(44, 'R11251-44', 5),
(45, 'R11391-45', 9),
(46, 'R11391-46', 9),
(47, 'R11391-47', 9),
(48, 'R11391-48', 9),
(49, 'R11391-49', 9),
(50, 'R11251-50', 5),
(51, 'R134151-51', 15),
(52, 'R11391-52', 9),
(53, 'R11391-53', 9),
(54, 'R11391-54', 9),
(55, 'R11391-55', 9),
(56, 'R11391-56', 9),
(57, 'R11391-57', 9),
(58, 'R11391-58', 9),
(59, 'R114131-59', 13),
(60, 'R12121-60', 2),
(61, 'R11111-61', 1),
(62, 'R12121-62', 2),
(63, 'R11111-63', 1),
(64, 'R12121-64', 2),
(65, 'R12121-65', 2),
(66, 'R12121-66', 2),
(67, 'R12121-67', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Id_Categoria` int(11) NOT NULL,
  `Categoria` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Id_Categoria`, `Categoria`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G'),
(8, 'H'),
(9, 'I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(1, 'SERVICIOS', '2021-03-30 10:46:53'),
(2, 'Laptops', '2021-09-18 21:15:17'),
(4, 'BTHTRH', '2023-08-16 23:38:48'),
(5, 'ESA', '2023-08-18 22:30:37'),
(6, 'TGT', '2023-08-18 22:30:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_contribuyente`
--

CREATE TABLE `clasificacion_contribuyente` (
  `Id_Clasificacion_Contribuyente` int(11) NOT NULL,
  `Clasificacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clasificacion_contribuyente`
--

INSERT INTO `clasificacion_contribuyente` (`Id_Clasificacion_Contribuyente`, `Clasificacion`) VALUES
(1, 'CONTRIBUYENTE GRANDE'),
(2, 'CONTRIBUYENTE MEDIANO'),
(3, 'CONTRIBUYENTE PEQUEÑO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_piso`
--

CREATE TABLE `clasificacion_piso` (
  `Id_Clasificacion_Piso` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clasificacion_piso`
--

INSERT INTO `clasificacion_piso` (`Id_Clasificacion_Piso`, `Nombre`, `Estado`) VALUES
(1, 'Casa Habitacion', '1'),
(2, 'Tienda, Deposito, Almacen', '1'),
(3, 'Edificio o Predio en Edificio', '1'),
(4, 'Industria,Taller, Clínica u Hospital', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `documento` varchar(15) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ubigeo` varchar(10) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `compras` int(11) DEFAULT NULL,
  `ultima_compra` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `ruc`, `razon_social`, `email`, `telefono`, `direccion`, `ubigeo`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`) VALUES
(1, 'DNI 00000000 CLIENTES VARIOS', '00000000', '', '', 'soporte@apifacturacion.com', '', '-', NULL, '0000-00-00', NULL, NULL, '2022-03-18 14:21:57'),
(2, '', '', '10416249470', 'VASQUEZ IBERICO GINO', '', '', '-', '-', NULL, NULL, NULL, '2022-07-07 23:29:17'),
(3, '', '', '20601487871', 'ROSLIF CIA S.A.C.', '', '', 'JR. HUAMACHUCO NRO. 1744', '150113', NULL, NULL, NULL, '2022-07-19 16:02:35'),
(4, 'ESTOLCIMO GOMEZ JARRO', '42116576', '', '', '', '', 'Av. Tacna 336', '', NULL, NULL, NULL, '2022-09-15 23:14:40'),
(5, 'EDWAR VASQUEZ IBERICO', '42116570', '', '', '', '', '', '', NULL, NULL, NULL, '2023-05-28 15:20:11'),
(6, 'HANCCO', '76936793', '', '', '', '9151651560', 'PUQUIO', '05050', NULL, NULL, NULL, '2023-08-16 22:49:01'),
(7, 'UJUJYU', '2453563', '', '', '', '7U7', 'U67YU', '6U7U', NULL, NULL, NULL, '2023-08-16 22:50:36'),
(8, 'UJUJYU', '24535630', '', '', '', '7U7', 'U67YU', '6U7U', NULL, NULL, NULL, '2023-08-16 22:50:47'),
(9, 'JYUJ', '123456678', '', '', '', 'UYJ', 'YUJYU', 'JUYJ', NULL, NULL, NULL, '2023-08-16 22:54:24'),
(10, 'JYUJ', '12345678', '', '', '', 'UYJ', 'YUJYU', 'JUYJ', NULL, NULL, NULL, '2023-08-16 22:54:36'),
(11, 'ronald', '76933456', '5353456', '5654656456', '4645@gmail.com', '12345678_', 'ikikuk', NULL, '2012-03-23', NULL, NULL, '2023-09-04 14:09:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colindante_denominacion`
--

CREATE TABLE `colindante_denominacion` (
  `Id_Colindante_Denominacion` int(11) NOT NULL,
  `Denominacion_Rural` varchar(200) NOT NULL,
  `Id_Denominacion_Rural` int(11) DEFAULT NULL,
  `Colindante_Sur_Nombre` varchar(50) DEFAULT NULL,
  `Colindante_Sur_Denominacion` varchar(50) DEFAULT NULL,
  `Colindante_Norte_Nombre` varchar(50) DEFAULT NULL,
  `Colindante_Norte_Denominacion` varchar(50) DEFAULT NULL,
  `Colindante_Este_Nombre` varchar(50) DEFAULT NULL,
  `Colindante_Este_Denominacion` varchar(50) DEFAULT NULL,
  `Colindante_Oeste_Nombre` varchar(50) DEFAULT NULL,
  `Colindante_Oeste_Denominacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colindante_denominacion`
--

INSERT INTO `colindante_denominacion` (`Id_Colindante_Denominacion`, `Denominacion_Rural`, `Id_Denominacion_Rural`, `Colindante_Sur_Nombre`, `Colindante_Sur_Denominacion`, `Colindante_Norte_Nombre`, `Colindante_Norte_Denominacion`, `Colindante_Este_Nombre`, `Colindante_Este_Denominacion`, `Colindante_Oeste_Nombre`, `Colindante_Oeste_Denominacion`) VALUES
(24, 'CHACRA X', 4, 'JOSE', 'CHA4', 'PEPE', 'ASDASF', 'LUIS', 'ASDSAF', 'JAVIER', 'LASDFJLAKDJ'),
(25, 'ronald', NULL, 'afdasfd', 'afdasfd', 'afasdf', 'asfafds', 'afdasdf', 'afdadfs', 'afdasdf', 'asdasdf'),
(26, 'ronald', NULL, 'afdasfd', 'afdasfd', 'afasdf', 'asfafds', 'afdasdf', 'afdadfs', 'afdasdf', 'asdasdf'),
(27, 'chacra h', NULL, 'afdasfd', 'afdasfd', 'afasdf', 'asfafds', 'afdasdf', 'afdadfs', 'afdasdf', 'asdasdf'),
(28, 'fvr', NULL, 'rv', 'rv', 're', 'r', 'rvr', 'vrv', 'rv', 'rv'),
(29, 'CHACRA X', 4, 'JOSE', 'CHACRA', 'JUNA', 'CHACRA', 'LUIS', 'CHACRA', 'ALAN', 'CHACRA'),
(30, 'CHACRA M', NULL, 'JOSE', 'CHACRA', 'JUNA', 'CHACRA', 'LUIS', 'CHACRA', 'ALAN', 'CHACRA'),
(31, 'CHACRA M', NULL, 'JOSE', 'CHACRA', 'JUNA', 'CHACRA', 'LUIS', 'CHACRA', 'ALAN', 'CHACRA'),
(32, 'CHACRA M', NULL, 'JOSE', 'CHACRA', 'JUNA', 'CHACRA', 'LUIS', 'CHACRA', 'ALAN', 'CHACRA'),
(33, 'CHACRA B', NULL, 'JOSE', 'AAA', 'MIGUEL', 'ADSSA', 'JUAN', 'ASDF', 'TOTO', 'ASDASD'),
(34, 'TINTAYA', NULL, 'JUAN', 'FRV', 'RVRVVV', 'RV', 'RVV', 'RV', 'VRRVV', 'VR'),
(35, 'TINTAYA', NULL, 'JUAN', 'FRV', 'RVRVVV', 'RV', 'RVV', 'RV', 'VRRVV', 'VR'),
(36, 'TINTAYA', NULL, 'JUAN', 'FRV', 'RVRVVV', 'RV', 'RVV', 'RV', 'VRRVV', 'VR'),
(37, 'TINTAYA', NULL, 'JUAN', 'FRV', 'RVRVVV', 'RV', 'RVV', 'RV', 'VRRVV', 'VR'),
(38, 'TINTAYA', NULL, 'JUAN', 'FRV', 'RVRVVV', 'RV', 'RVV', 'RV', 'VRRVV', 'VR'),
(39, 'TINTAYA', NULL, 'JUAN', 'TINDVC', 'PEDRO', 'VFBVB', 'HECTOR', '23F3FRF', 'PABLO', 'EFCFR'),
(40, 'DENOMINACION PRUEBA', 5, 'ASDAS', 'FASF', 'ASDAS', 'FDASDF', 'ADASD', 'ASDFASD', 'ADSAS', 'FASDF'),
(41, 'TINTAYA', 6, 'EDGAR', 'TINTAYA SUR', 'PABLO', 'TINTAYA NORTE', 'HECTOR', 'TINTAYA ESTE', 'SANTIAGO', 'TINTAYA OESTE'),
(42, 'CHACRA Y', 7, 'ASDSA', 'ASDF', 'ASDFSA', 'AF', 'ASDF', 'ADSF', 'ADFA', 'ADF'),
(43, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(44, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(45, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(46, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(47, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(48, 'CCAALO BS', 8, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(49, 'CCAALO HJ', 9, 'SFAS', 'ASDFA', 'AFDSA', 'ADSFASD', 'ASDFASD', 'ASF', 'AFDSA', 'ADSFAF'),
(50, 'TOCCTOPAMPA', 10, 'JUAN', 'TOCCTOPAMPA SUR', 'CARLOS', 'TOCCTOPAMPA NORTE', 'PEDRO', 'TOCCTOPAMPA ESTE', 'SANTIAGO', 'TOCCTOPAMPA OESTE'),
(51, 'SADFSAF', 11, 'ASDFASD', 'ADSF', 'ADSFA', 'ADF', 'ADSFA', 'AFD', 'AFD', 'ADF'),
(52, 'TINTAYA', 6, 'JUAN PABLO', 'TINTAUA SUR', 'SANTIAGO HUARATO', 'TINTAYA NORTE', 'PEDRO ROBERTO', 'TINTAYA ESTE', 'JUAN QUISPE', 'TINTAYA OESTE'),
(53, 'TINTAYA', 6, 'JUAN', 'SUR', 'PEDRO', 'NORTE', 'SANTIAGO', 'ESTE', 'PITER', 'OESTE'),
(54, 'TOCCTOPAMPA', 10, 'JUAN', 'SUR', 'PEDRO', 'NORTE', 'SANTI', 'ESTE', 'RONALD', 'OESTE'),
(55, 'rtg', 12, 'trg', 't', 'gt', 'tgtg', 'tr', 'tg', 'tg', 'tg'),
(56, 'PAMPAHUAS', 13, 'ER', 'RV', 'RV', 'RV', 'RV', 'VR', 'VR', 'RV'),
(57, 'CHACRAPUQUIO', 14, 'PEPITO', 'CHACRA1', 'JOSE', 'CHARCA4', 'MARIA', 'CHACRA S', 'PEDRO', 'CHACRAG'),
(58, 'SAN ANDRES', 15, 'JUAN PERCY HUAMAN QUISPE', 'SAN ANDRES SUR', 'RONADL DE LA CRUZ AGUILA', 'SAN ANDRES NORTE', 'ANDRES QUISPE HUAMANI DE LA TORRE', 'SAN ANDRES ESTE', 'LILIANA COTAQUISPE AGUILAR', 'SAN ANDRES OESTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colindante_propietario`
--

CREATE TABLE `colindante_propietario` (
  `Id_Colindante_Propietario` int(11) NOT NULL,
  `Id_Propietario` int(11) DEFAULT NULL,
  `Nombres` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `idemisor` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `serie_correlativo` varchar(15) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fechahora` datetime DEFAULT NULL,
  `codmoneda` char(3) DEFAULT NULL,
  `metodopago` varchar(4) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `subtotal` decimal(11,2) DEFAULT 0.00,
  `total` decimal(11,2) DEFAULT NULL,
  `codproveedor` int(11) DEFAULT NULL,
  `codvendedor` int(11) DEFAULT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `anulado` enum('n','s') NOT NULL DEFAULT 'n',
  `idbaja` int(11) DEFAULT NULL,
  `tipocomp_ref` varchar(4) DEFAULT NULL,
  `serie_ref` varchar(8) DEFAULT NULL,
  `correlativo_ref` int(11) DEFAULT NULL,
  `codmotivo` varchar(5) DEFAULT NULL,
  `fechamodificado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `idemisor`, `tipocomp`, `serie`, `correlativo`, `serie_correlativo`, `fecha_emision`, `fechahora`, `codmoneda`, `metodopago`, `comentario`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `op_gratuitas`, `descuento`, `icbper`, `igv`, `subtotal`, `total`, `codproveedor`, `codvendedor`, `tipodoc`, `anulado`, `idbaja`, `tipocomp_ref`, `serie_ref`, `correlativo_ref`, `codmotivo`, `fechamodificado`) VALUES
(1, NULL, '01', 'F001', 210, 'F001-210', '2022-07-03', '2022-07-03 08:34:56', 'PEN', '009', NULL, 310000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 55800.00, 310000.00, 365800.00, 2, NULL, '6', 'n', NULL, NULL, '', NULL, NULL, '1969-12-31'),
(2, NULL, '01', 'F001', 123, 'F001-123', '2022-08-10', '2022-08-10 13:00:13', 'PEN', '009', NULL, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 36.00, 200.00, 236.00, 1, NULL, '6', 'n', NULL, NULL, '', NULL, NULL, '1969-12-31'),
(3, NULL, '01', 'F001', 35, 'F001-35', '2023-02-11', '2023-02-11 19:03:15', 'PEN', '009', NULL, 17457.65, 0.00, 0.00, 0.00, 0.00, 0.00, 3142.38, 17457.65, 20600.03, 2, NULL, '6', 'n', NULL, NULL, '', NULL, NULL, '1969-12-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalle`
--

CREATE TABLE `compra_detalle` (
  `id` int(11) NOT NULL,
  `idcompra` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cod_producto` varchar(30) DEFAULT NULL,
  `descripcion` varchar(350) DEFAULT NULL,
  `codigo_afectacion` varchar(2) DEFAULT NULL,
  `tipo_precio` varchar(2) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT 0.00,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `compra_detalle`
--

INSERT INTO `compra_detalle` (`id`, `idcompra`, `item`, `idproducto`, `cod_producto`, `descripcion`, `codigo_afectacion`, `tipo_precio`, `cantidad`, `valor_unitario`, `precio_unitario`, `icbper`, `igv`, `porcentaje_igv`, `descuento`, `descuento_factor`, `valor_total`, `importe_total`) VALUES
(1, 1, 1, NULL, '202', 'Laptop DELL ', '10', NULL, 100.00, 3100.00, 3658.00, 0.00, 55800.00, NULL, 0.00, NULL, 310000.00, 365800.00),
(2, 2, 1, NULL, '44T', 'MONITOR ', '10', NULL, 1.00, 200.00, 236.00, 0.00, 36.00, NULL, 0.00, NULL, 200.00, 236.00),
(3, 3, 1, NULL, '203', 'Laptop Lenovo i8', '10', NULL, 5.00, 3491.53, 4120.01, 0.00, 3142.38, NULL, 0.00, NULL, 17457.65, 20600.03);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_catastral`
--

CREATE TABLE `condicion_catastral` (
  `Id_Condicion_Catastral` int(11) NOT NULL,
  `Condicion_Catastral` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicion_catastral`
--

INSERT INTO `condicion_catastral` (`Id_Condicion_Catastral`, `Condicion_Catastral`) VALUES
(1, 'FORMAL'),
(2, 'INFORMAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_contribuyente`
--

CREATE TABLE `condicion_contribuyente` (
  `Id_Condicion_Contribuyente` int(11) NOT NULL,
  `Condicion_Contribuyente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicion_contribuyente`
--

INSERT INTO `condicion_contribuyente` (`Id_Condicion_Contribuyente`, `Condicion_Contribuyente`) VALUES
(1, 'NINGUNO'),
(2, 'GOBIERNO CENTRAL/REGIONAL'),
(3, 'GOBIERNO LOCAL'),
(4, 'BENEFICIENCIA'),
(5, 'ENTIDAD RELIGIOSA NO CATOLICA'),
(6, 'SERVICIOS MEDICOS PUBLICOS'),
(7, 'COMPAÑIA DE BOMBEROS'),
(8, 'UNIVERSIDADES'),
(9, 'CENTROS EDUCATIVOS'),
(10, 'COMUNIDADES CAMPESINAS'),
(11, 'ORGANIZACIONES POLITICAS'),
(12, 'ENT. DISCAP. RECONOCI CONADIS'),
(13, 'ORGANIZACIONES SINDICALES '),
(14, 'GOBIERNOS EXTRANJEROS'),
(15, 'ORGANISMOS INTERNACIONALES'),
(16, 'PENSIONISTAS'),
(17, 'ENTIDAD RELIGIOSA CATOLICA'),
(18, 'INAFECTACION ANT '),
(19, 'ORG. PUB. DESCENTRALIZADO MVL'),
(20, 'ENTIDADES FINANCIERAS EN LIQ.'),
(21, 'CLUB DEPT PROV/DIST/ASOC'),
(22, 'ADULTO MAYOR NO PENSIONISTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_predio`
--

CREATE TABLE `condicion_predio` (
  `Id_Condicion_Predio` int(11) NOT NULL,
  `Condicion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicion_predio`
--

INSERT INTO `condicion_predio` (`Id_Condicion_Predio`, `Condicion`) VALUES
(1, 'PROPIETARIO UNICO'),
(2, 'SUCESION INDIVISA'),
(3, 'POSEEDOR'),
(4, 'SOCIEDAD CONYUGAL'),
(5, 'CONDOMIO'),
(6, 'OTROS'),
(7, 'ASOCIATIVA'),
(8, 'SUCESION INTESTADA'),
(9, 'CONVIVIENTE'),
(10, 'TENEDOR'),
(11, 'COOPROPIETARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_predio_fiscal`
--

CREATE TABLE `condicion_predio_fiscal` (
  `Id_Condicon_Predio_Fiscal` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicion_predio_fiscal`
--

INSERT INTO `condicion_predio_fiscal` (`Id_Condicon_Predio_Fiscal`, `Descripcion`) VALUES
(1, 'ALQUILADO'),
(2, 'PROPIO'),
(3, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `Id_Configuraciones` int(11) NOT NULL,
  `Nombre_Empresa` varchar(50) NOT NULL,
  `RUC_empresa` char(11) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Telefono_uno` char(9) NOT NULL,
  `Telefono_dos` char(9) DEFAULT NULL,
  `IniSis` char(10) NOT NULL,
  `Nombre_Sistema` varchar(250) NOT NULL,
  `Numero_Recibo` int(11) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `plantilla` varchar(100) NOT NULL,
  `Nombre_Comercial` varchar(10) NOT NULL,
  `Version` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`Id_Configuraciones`, `Nombre_Empresa`, `RUC_empresa`, `Direccion`, `Telefono_uno`, `Telefono_dos`, `IniSis`, `Nombre_Sistema`, `Numero_Recibo`, `logo`, `plantilla`, `Nombre_Comercial`, `Version`) VALUES
(1, 'Municipalidad Provincial de Lucanas - Puquio', '10769367930', 'Jr. Ayacucho 116 - Puquio', '066458', '910253114', 'SRM-MPLP', 'SISTEMA DE RECAUDACION MUNICIPAL', 0, 'logo.jpg', 'plantilla.css', 'SRM-MPLP', '0.0.1.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contribuyente`
--

CREATE TABLE `contribuyente` (
  `Id_Contribuyente` int(11) NOT NULL,
  `Documento` char(8) DEFAULT NULL,
  `Nombres` varchar(250) DEFAULT NULL,
  `Apellido_Paterno` varchar(50) DEFAULT NULL,
  `Apellido_Materno` varchar(50) DEFAULT NULL,
  `Id_Ubica_Vias_Urbano` int(11) DEFAULT NULL,
  `Numero_Ubicacion` char(18) DEFAULT NULL,
  `Bloque` char(18) DEFAULT NULL,
  `Numero_Departamento` char(18) DEFAULT NULL,
  `Referencia` char(200) DEFAULT NULL,
  `Telefono` char(9) DEFAULT NULL,
  `Correo` char(50) DEFAULT NULL,
  `Id_Condicion_Contribuyente` int(11) DEFAULT NULL,
  `Observaciones` varchar(250) DEFAULT NULL,
  `Codigo_sa` char(18) DEFAULT NULL,
  `Id_Tipo_Contribuyente` int(11) DEFAULT NULL,
  `Id_Condicion_Predio_Fiscal` int(11) DEFAULT NULL,
  `Id_Clasificacion_Contribuyente` int(11) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL,
  `Coactivo` char(1) DEFAULT NULL,
  `Numero_Luz` varchar(50) DEFAULT NULL,
  `Fecha_Registro` datetime NOT NULL DEFAULT current_timestamp(),
  `Fecha_Modificacion` datetime DEFAULT NULL,
  `Lote` char(2) DEFAULT NULL,
  `Id_Tipo_Documento` int(11) DEFAULT NULL,
  `usuario_Id_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contribuyente`
--

INSERT INTO `contribuyente` (`Id_Contribuyente`, `Documento`, `Nombres`, `Apellido_Paterno`, `Apellido_Materno`, `Id_Ubica_Vias_Urbano`, `Numero_Ubicacion`, `Bloque`, `Numero_Departamento`, `Referencia`, `Telefono`, `Correo`, `Id_Condicion_Contribuyente`, `Observaciones`, `Codigo_sa`, `Id_Tipo_Contribuyente`, `Id_Condicion_Predio_Fiscal`, `Id_Clasificacion_Contribuyente`, `Estado`, `Coactivo`, `Numero_Luz`, `Fecha_Registro`, `Fecha_Modificacion`, `Lote`, `Id_Tipo_Documento`, `usuario_Id_Usuario`) VALUES
(6, '13213212', 'ALAN', 'GARCIA', 'PEREZ', 3, '23', '23', '23', 'SADASD', '1212', 'ASDAF', 1, 'ALAN GARCIA PEREZ', '12312', 1, 1, 1, '1', '0', '23', '2023-11-14 16:34:50', '2023-11-14 16:40:52', '23', 2, 1),
(8, '44386534', 'RONALD', 'TTITO', 'MURIEL', 3, '33', '33', '33', 'SDASDF', '925518357', 'A@HOMAIL.COM', 1, 'PRUEBA 1', '1234', 1, 2, 1, '1', 't', '33', '2023-11-14 16:38:52', NULL, '33', 2, 1),
(9, '76936793', 'STALIN VICTOR', 'HANCCO', 'SUAREZ', 3, '23', '4', '1', 'FRENTE A LA CANTINA', '910253114', '996STALIN@GMAIL.COM', 1, 'SIN OBSERVACIONES', '000456', 1, 1, 1, '1', 't', '134', '2023-11-14 16:58:39', NULL, '2', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `idemisor` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `idserie` int(11) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `serie_correlativo` varchar(15) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fechahora` datetime DEFAULT NULL,
  `codmoneda` char(3) DEFAULT NULL,
  `tipocambio` float DEFAULT NULL,
  `metodopago` varchar(4) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `igv_op` decimal(11,2) DEFAULT 0.00,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `subtotal` decimal(11,2) DEFAULT 0.00,
  `total` decimal(11,2) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `codvendedor` int(11) DEFAULT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `xmlbase64` text DEFAULT NULL,
  `cdrbase64` text DEFAULT NULL,
  `anulado` enum('n','s') NOT NULL DEFAULT 'n',
  `resumen` enum('s','n') DEFAULT 'n',
  `idbaja` int(11) DEFAULT NULL,
  `id_nc` int(11) DEFAULT NULL,
  `id_nd` int(11) DEFAULT NULL,
  `bienesSelva` varchar(4) DEFAULT NULL,
  `serviciosSelva` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadra`
--

CREATE TABLE `cuadra` (
  `Id_cuadra` int(11) NOT NULL,
  `Numero_Cuadra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuadra`
--

INSERT INTO `cuadra` (`Id_cuadra`, `Numero_Cuadra`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas_vencimiento`
--

CREATE TABLE `cuotas_vencimiento` (
  `Id_Cuotas_Vencimiento` int(11) NOT NULL,
  `Periodo` char(2) NOT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Fecha_Vence` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cuotas_vencimiento`
--

INSERT INTO `cuotas_vencimiento` (`Id_Cuotas_Vencimiento`, `Periodo`, `Id_Anio`, `Fecha_Vence`) VALUES
(1, '1', 1, '2023-03-31'),
(2, '2', 1, '2023-06-30'),
(3, '3', 1, '2023-09-30'),
(4, '4', 1, '2023-12-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas_vencimiento_impuesto`
--

CREATE TABLE `cuotas_vencimiento_impuesto` (
  `Id_Cuotas_Vencimiento_Impuesto` int(11) NOT NULL,
  `Periodo` varchar(2) NOT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Fecha_Vence` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuotas_vencimiento_impuesto`
--

INSERT INTO `cuotas_vencimiento_impuesto` (`Id_Cuotas_Vencimiento_Impuesto`, `Periodo`, `Id_Anio`, `Fecha_Vence`) VALUES
(1, '1', 1, '2023-02-28'),
(2, '2', 1, '2023-05-31'),
(3, '3', 1, '2023-08-31'),
(4, '4', 1, '2023-11-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denominacion_rural`
--

CREATE TABLE `denominacion_rural` (
  `Id_Denominacion_Rural` int(11) NOT NULL,
  `Denominacion` varchar(50) NOT NULL,
  `Id_Zona_Rural` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `denominacion_rural`
--

INSERT INTO `denominacion_rural` (`Id_Denominacion_Rural`, `Denominacion`, `Id_Zona_Rural`) VALUES
(1, 'CHACRALLA', 1),
(2, 'MOLLEPATA', 1),
(3, 'TOCCTO', 1),
(4, 'CHACRA X', 1),
(5, 'DENOMINACION PRUEBA', 1),
(6, 'TINTAYA', 1),
(7, 'CHACRA Y', 1),
(8, 'CCAALO BS', 1),
(9, 'CCAALO HJ', 1),
(10, 'TOCCTOPAMPA', 1),
(11, 'SADFSAF', 1),
(12, 'rtg', 1),
(13, 'PAMPAHUAS', 1),
(14, 'CHACRAPUQUIO', 1),
(15, 'SAN ANDRES', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depreciacion`
--

CREATE TABLE `depreciacion` (
  `Id_depreciacion` int(11) NOT NULL,
  `Id_Anio_Antiguedad` int(11) DEFAULT NULL,
  `Id_Material_Piso` int(11) DEFAULT NULL,
  `Id_Clasificacion_Piso` int(11) DEFAULT NULL,
  `Id_Estado_Conservacion` int(11) DEFAULT NULL,
  `Porcentaje` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `depreciacion`
--

INSERT INTO `depreciacion` (`Id_depreciacion`, `Id_Anio_Antiguedad`, `Id_Material_Piso`, `Id_Clasificacion_Piso`, `Id_Estado_Conservacion`, `Porcentaje`) VALUES
(1, 1, 1, 1, 1, 0.00),
(2, 1, 1, 1, 2, 5.00),
(3, 1, 1, 1, 3, 10.00),
(4, 1, 1, 1, 4, 55.00),
(5, 1, 2, 1, 1, 0.00),
(6, 1, 2, 1, 2, 8.00),
(7, 1, 2, 1, 3, 20.00),
(8, 1, 2, 1, 4, 60.00),
(9, 1, 3, 1, 1, 5.00),
(10, 1, 3, 1, 2, 15.00),
(11, 1, 3, 1, 3, 30.00),
(12, 1, 3, 1, 4, 65.00),
(13, 2, 1, 1, 1, 0.00),
(14, 2, 1, 1, 2, 5.00),
(15, 2, 1, 1, 3, 10.00),
(16, 2, 1, 1, 4, 55.00),
(17, 2, 2, 1, 1, 3.00),
(18, 2, 2, 1, 2, 11.00),
(19, 2, 2, 1, 3, 23.00),
(20, 2, 2, 1, 4, 63.00),
(21, 2, 3, 1, 1, 10.00),
(22, 2, 3, 1, 2, 20.00),
(23, 2, 3, 1, 3, 35.00),
(24, 2, 3, 1, 4, 70.00),
(25, 3, 1, 1, 1, 3.00),
(26, 3, 1, 1, 2, 8.00),
(27, 3, 1, 1, 3, 13.00),
(28, 3, 1, 1, 4, 58.00),
(29, 3, 2, 1, 1, 6.00),
(30, 3, 2, 1, 2, 14.00),
(31, 3, 2, 1, 3, 26.00),
(32, 3, 2, 1, 4, 66.00),
(33, 3, 3, 1, 1, 15.00),
(34, 3, 3, 1, 2, 25.00),
(35, 3, 3, 1, 3, 40.00),
(36, 3, 3, 1, 4, 75.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento`
--

CREATE TABLE `descuento` (
  `Id_Descuento` int(11) NOT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Id_Arbitrios` int(11) NOT NULL,
  `Id_Uso_Predio` int(11) NOT NULL,
  `Porcentaje` decimal(10,2) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Documento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `codigo_afectacion` varchar(2) DEFAULT NULL,
  `tipo_precio` varchar(2) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT 0.00,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `idventa`, `item`, `idproducto`, `codigo_afectacion`, `tipo_precio`, `cantidad`, `valor_unitario`, `precio_unitario`, `icbper`, `igv`, `porcentaje_igv`, `descuento`, `descuento_factor`, `valor_total`, `importe_total`) VALUES
(1, 1, 1, 5, '10', '01', 1.00, 254.24, 300.00, 0.00, 45.76, 18.00, 0.00, 0.00000, 254.24, 300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizaciones`
--

CREATE TABLE `detalle_cotizaciones` (
  `id` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `codigo_afectacion` varchar(2) DEFAULT NULL,
  `tipo_precio` varchar(2) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT 0.00,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_eliminar`
--

CREATE TABLE `detalle_eliminar` (
  `Id_Detalle_Eliminar` int(11) NOT NULL,
  `Detalle_Eliminar` varchar(150) NOT NULL,
  `Fecha_Eliminar` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_eliminar`
--

INSERT INTO `detalle_eliminar` (`Id_Detalle_Eliminar`, `Detalle_Eliminar`, `Fecha_Eliminar`) VALUES
(5, '123', '2023-10-09 22:08:01'),
(6, '123', '2023-10-09 22:10:53'),
(7, '123', '2023-10-09 22:11:17'),
(8, '123', '2023-10-09 22:11:23'),
(9, '123', '2023-10-09 22:14:26'),
(10, '123', '2023-10-09 22:14:34'),
(11, '234', '2023-10-09 22:17:41'),
(12, '234', '2023-10-09 22:18:00'),
(13, '123', '2023-10-09 22:18:24'),
(14, 'INFORME 123', '2023-10-09 22:20:23'),
(15, 'WQQ', '2023-10-09 22:22:37'),
(16, '23', '2023-10-09 22:23:43'),
(17, 'YHTH', '2023-10-09 22:24:45'),
(18, 'HGNN', '2023-10-09 22:25:36'),
(19, 'MJK', '2023-10-09 22:26:58'),
(20, '23', '2023-10-09 22:27:43'),
(21, '1332', '2023-10-09 22:32:52'),
(22, '12', '2023-10-09 22:34:42'),
(23, '2334', '2023-10-09 22:36:39'),
(24, '4343', '2023-10-09 23:16:37'),
(25, '212', '2023-10-10 08:19:45'),
(26, 're43r', '2023-10-10 08:24:54'),
(27, '121', '2023-10-10 12:44:06'),
(28, '434', '2023-10-11 17:45:41'),
(29, '23', '2023-10-11 17:48:54'),
(30, '12', '2023-10-11 17:49:34'),
(31, '123', '2023-10-25 17:18:06'),
(32, '34', '2023-11-02 17:05:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_transferencia`
--

CREATE TABLE `detalle_transferencia` (
  `Id_Detalle_Transferencia` int(11) NOT NULL,
  `Id_Documento_Inscripcion` int(11) NOT NULL,
  `Numero_Documento_Inscripcion` varchar(50) NOT NULL,
  `Id_Tipo_Escritura` int(11) NOT NULL,
  `Fecha_Escritura` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_transferencia`
--

INSERT INTO `detalle_transferencia` (`Id_Detalle_Transferencia`, `Id_Documento_Inscripcion`, `Numero_Documento_Inscripcion`, `Id_Tipo_Escritura`, `Fecha_Escritura`) VALUES
(231, 1, '12', 1, '2023-11-14'),
(232, 1, '21', 1, '2023-11-14'),
(234, 1, '23', 1, '2023-11-14'),
(235, 1, '13', 1, '2023-11-14'),
(236, 1, '12', 1, '2023-11-14'),
(237, 1, '324', 1, '2023-11-14'),
(238, 1, '12', 1, '2023-11-14'),
(239, 1, '12', 1, '2023-11-14'),
(240, 1, '23', 1, '0000-00-00'),
(241, 1, '34', 1, '2023-11-14'),
(242, 1, '34', 1, '2023-11-09'),
(243, 1, '23', 1, '2023-11-16'),
(244, 1, '34', 1, '2023-11-16'),
(245, 1, '23', 1, '2023-11-17'),
(246, 12, '45', 6, '2023-11-14'),
(247, 1, '23', 5, '2023-11-15'),
(248, 1, '12', 1, '2023-11-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `Id_Direccion` int(11) NOT NULL,
  `Id_Tipo_Via` int(11) DEFAULT NULL,
  `Id_Zona` int(11) DEFAULT NULL,
  `Id_Nombre_Via` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`Id_Direccion`, `Id_Tipo_Via`, `Id_Zona`, `Id_Nombre_Via`) VALUES
(1, 2, 19, 1),
(2, 2, 15, 1),
(3, 2, 18, 1),
(5, 2, 17, 2),
(6, 2, 18, 2),
(7, 2, 6, 3),
(18, 2, 17, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_inscripcion`
--

CREATE TABLE `documento_inscripcion` (
  `Id_Documento_Inscripcion` int(11) NOT NULL,
  `Documento_Inscripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento_inscripcion`
--

INSERT INTO `documento_inscripcion` (`Id_Documento_Inscripcion`, `Documento_Inscripcion`) VALUES
(1, 'SUNARP - COPIA LITERAL'),
(2, 'ESCRITURA PUBLICA'),
(3, 'CONTRATO DE COMPRA-VENTA'),
(4, 'AUTOVALUO'),
(5, 'TITULO DE COFOPRI'),
(6, 'PETT'),
(7, 'CERTIFICADO DE POSESION'),
(8, 'ACTA NOTARIAL DE LA SUCESION INTESTADA'),
(9, 'TENEDOR'),
(10, 'CONTRATO PRIVADO DE DIVISION Y PARTICION'),
(11, 'ESCRITURA IMPERFECTA'),
(12, 'TESTAMENTO'),
(13, 'MINUTA'),
(14, 'SUBDIVICION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificacion_piso`
--

CREATE TABLE `edificacion_piso` (
  `Id_Edificacion_Piso` int(11) NOT NULL,
  `Id_Valores_Edificacion` int(11) NOT NULL,
  `Id_Piso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `edificacion_piso`
--

INSERT INTO `edificacion_piso` (`Id_Edificacion_Piso`, `Id_Valores_Edificacion`, `Id_Piso`) VALUES
(220, 16, 318),
(221, 16, 318),
(222, 16, 318),
(223, 4, 319),
(224, 4, 319),
(225, 4, 319),
(226, 5, 320),
(227, 10, 320),
(228, 16, 320),
(229, 1, 321),
(230, 6, 321),
(231, 12, 321),
(244, 24, 326),
(245, 24, 326),
(246, 24, 326),
(247, 9, 327),
(248, 14, 327),
(249, 20, 327),
(250, 51, 328),
(251, 52, 328),
(252, 61, 328),
(256, 16, 330),
(257, 16, 330),
(258, 16, 330),
(259, 8, 331),
(260, 8, 331),
(261, 8, 331),
(262, 28, 332),
(263, 28, 332),
(264, 28, 332),
(265, 51, 333),
(266, 59, 333),
(267, 61, 333);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emisor`
--

CREATE TABLE `emisor` (
  `id` int(11) NOT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `ruc` char(11) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `nombre_comercial` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `ubigeo` char(6) DEFAULT NULL,
  `usuario_sol` varchar(20) DEFAULT NULL,
  `clave_sol` varchar(20) DEFAULT NULL,
  `usuario_prueba` varchar(20) DEFAULT NULL,
  `clave_prueba` varchar(100) DEFAULT NULL,
  `clave_certificado` varchar(100) DEFAULT NULL,
  `certificado` varchar(100) DEFAULT NULL,
  `certificado_prueba` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `modo` enum('s','n') NOT NULL DEFAULT 'n',
  `afectoigv` varchar(3) NOT NULL DEFAULT 'n',
  `correo_ventas` varchar(50) DEFAULT NULL,
  `correo_soporte` varchar(50) DEFAULT NULL,
  `servidor` varchar(100) DEFAULT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `puerto` varchar(7) DEFAULT NULL,
  `seguridad` varchar(5) DEFAULT NULL,
  `tipo_envio` varchar(8) DEFAULT NULL,
  `plantilla` varchar(20) DEFAULT NULL,
  `bienesSelva` enum('s','n') DEFAULT 'n',
  `serviciosSelva` enum('s','n') DEFAULT 'n',
  `conexion` enum('s','n') NOT NULL DEFAULT 's',
  `igv` int(11) DEFAULT NULL,
  `client_id` varchar(120) DEFAULT NULL,
  `secret_id` varchar(120) DEFAULT NULL,
  `clavePublica` varchar(120) DEFAULT NULL,
  `clavePrivada` varchar(120) DEFAULT NULL,
  `claveapi` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `emisor`
--

INSERT INTO `emisor` (`id`, `tipodoc`, `ruc`, `razon_social`, `nombre_comercial`, `direccion`, `telefono`, `pais`, `departamento`, `provincia`, `distrito`, `ubigeo`, `usuario_sol`, `clave_sol`, `usuario_prueba`, `clave_prueba`, `clave_certificado`, `certificado`, `certificado_prueba`, `logo`, `modo`, `afectoigv`, `correo_ventas`, `correo_soporte`, `servidor`, `contrasena`, `puerto`, `seguridad`, `tipo_envio`, `plantilla`, `bienesSelva`, `serviciosSelva`, `conexion`, `igv`, `client_id`, `secret_id`, `clavePublica`, `clavePrivada`, `claveapi`) VALUES
(1, '6', '20601284953', 'Municipalidad Provincial de Lucanas - Puquio', 'MPLP SIAT', 'JR AYACUCHO S7N', '925518357', 'PE', 'PUQUIO', 'LUCANAS', 'AYACUCHO', '150136', 'RONALD', '...', 'MODDATOS', 'MODDATOS', '00000', '', 'certificado_prueba.pfx', '', 'n', 's', 'ronniel_55@hotmail.com.com', 'ronniel_55@hotmail.com', 'mboxhosting.com', '1105gviG', '587', 'tls', 'smtp', 'plantilla.css', 'n', 'n', 'n', 18, 'test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==', '6LdTdcggAAAAAPzue7S6tJumtvWlWCS_Pa1kxPVE', '6LdTdcggAAAAAEvl4ZktiKNXSKE3S6B92LeHbeUS', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen`
--

CREATE TABLE `envio_resumen` (
  `idenvio` int(11) NOT NULL,
  `idemisor` int(255) DEFAULT NULL,
  `fecha_envio` date DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `resumen` smallint(6) DEFAULT NULL,
  `baja` smallint(6) DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `ticket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen_detalle`
--

CREATE TABLE `envio_resumen_detalle` (
  `iddetalle` int(255) NOT NULL,
  `idenvio` int(11) DEFAULT NULL,
  `idventa` int(11) DEFAULT NULL,
  `condicion` smallint(6) DEFAULT NULL COMMENT '1->Creacion, 2->Actualizacion, 3->Baja'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie_valorada`
--

CREATE TABLE `especie_valorada` (
  `Id_Especie_Valorada` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Estado` char(1) NOT NULL,
  `Id_Area` int(11) NOT NULL,
  `Id_Presupuesto` int(11) NOT NULL,
  `Nombre_Especie` varchar(500) NOT NULL,
  `Detalle` varchar(60) NOT NULL,
  `Id_Instrumento_Gestion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especie_valorada`
--

INSERT INTO `especie_valorada` (`Id_Especie_Valorada`, `Monto`, `Estado`, `Id_Area`, `Id_Presupuesto`, `Nombre_Especie`, `Detalle`, `Id_Instrumento_Gestion`) VALUES
(3, 3.00, '0', 2, 2, 'COPIAS CERTIFICADAS', 'aasdfafd', 1),
(5, 1.00, '0', 2, 2, 'OTROS', 'aasdfafd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_conservacion`
--

CREATE TABLE `estado_conservacion` (
  `Id_Estado_Conservacion` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_conservacion`
--

INSERT INTO `estado_conservacion` (`Id_Estado_Conservacion`, `Nombre`, `Estado`) VALUES
(1, 'Muy Bueno', '1'),
(2, 'Bueno', '1'),
(3, 'Regular', '1'),
(4, 'Malo', '1'),
(5, 'Muy Malo', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cuenta_corriente`
--

CREATE TABLE `estado_cuenta_corriente` (
  `Id_Estado_Cuenta_Impuesto` int(11) NOT NULL,
  `Id_Predio` int(11) DEFAULT NULL,
  `Codigo_Catastral` varchar(50) DEFAULT NULL,
  `Tipo_Tributo` char(3) DEFAULT NULL,
  `Numero_Recibo` char(10) DEFAULT NULL,
  `Periodo` char(2) DEFAULT NULL,
  `Importe` decimal(10,2) DEFAULT NULL,
  `Gasto_Emision` decimal(10,2) NOT NULL,
  `Saldo` decimal(10,2) DEFAULT NULL,
  `TIM` decimal(10,2) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT current_timestamp(),
  `Fecha_Vencimiento` datetime DEFAULT NULL,
  `User_Pago` varchar(50) DEFAULT NULL,
  `Fecha_pago` datetime DEFAULT NULL,
  `Id_Usuario` int(11) DEFAULT NULL,
  `Fecha_ReCalculo` datetime NOT NULL,
  `Concatenado_idc` varchar(100) NOT NULL,
  `Anio` varchar(4) NOT NULL,
  `Id_Descuento` int(11) DEFAULT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_cuenta_corriente`
--

INSERT INTO `estado_cuenta_corriente` (`Id_Estado_Cuenta_Impuesto`, `Id_Predio`, `Codigo_Catastral`, `Tipo_Tributo`, `Numero_Recibo`, `Periodo`, `Importe`, `Gasto_Emision`, `Saldo`, `TIM`, `Total`, `Estado`, `Fecha_Registro`, `Fecha_Vencimiento`, `User_Pago`, `Fecha_pago`, `Id_Usuario`, `Fecha_ReCalculo`, `Concatenado_idc`, `Anio`, `Id_Descuento`, `Descuento`) VALUES
(1005, NULL, 'U22151114-17', '742', NULL, '1', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1006, NULL, 'U22151114-17', '742', NULL, '2', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1007, NULL, 'U22151114-17', '742', NULL, '3', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1008, NULL, 'U22151114-17', '742', NULL, '4', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1009, NULL, 'U12191111-25', '742', NULL, '1', 30.00, 0.00, 30.00, 0.00, 30.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1010, NULL, 'U12191111-25', '742', NULL, '2', 30.00, 0.00, 30.00, 0.00, 30.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1011, NULL, 'U12191111-25', '742', NULL, '3', 30.00, 0.00, 30.00, 0.00, 30.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1012, NULL, 'U12191111-25', '742', NULL, '4', 30.00, 0.00, 30.00, 0.00, 30.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1013, NULL, 'U22151114-27', '742', NULL, '1', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1014, NULL, 'U22151114-27', '742', NULL, '2', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1015, NULL, 'U22151114-27', '742', NULL, '3', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1016, NULL, 'U22151114-27', '742', NULL, '4', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1017, NULL, 'U12191112-28', '742', NULL, '1', 12.00, 0.00, 12.00, 0.00, 12.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1018, NULL, 'U12191112-28', '742', NULL, '2', 12.00, 0.00, 12.00, 0.00, 12.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1019, NULL, 'U12191112-28', '742', NULL, '3', 12.00, 0.00, 12.00, 0.00, 12.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1020, NULL, 'U12191112-28', '742', NULL, '4', 12.00, 0.00, 12.00, 0.00, 12.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1021, NULL, 'U12191111-29', '742', NULL, '1', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1022, NULL, 'U12191111-29', '742', NULL, '2', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1023, NULL, 'U12191111-29', '742', NULL, '3', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1024, NULL, 'U12191111-29', '742', NULL, '4', 24.00, 0.00, 24.00, 0.00, 24.00, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1025, NULL, NULL, '006', NULL, '1', 207.34, 17.00, 224.34, 0.00, 224.34, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1026, NULL, NULL, '006', NULL, '2', 207.34, 0.00, 207.34, 0.00, 207.34, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1027, NULL, NULL, '006', NULL, '3', 207.34, 0.00, 207.34, 0.00, 207.34, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1028, NULL, NULL, '006', NULL, '4', 207.34, 0.00, 207.34, 0.00, 207.34, 'D', '2023-11-24 12:39:37', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '9', '2023', NULL, 0.00),
(1029, NULL, 'U12191112-18', '742', NULL, '1', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1030, NULL, 'U12191112-18', '742', NULL, '2', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1031, NULL, 'U12191112-18', '742', NULL, '3', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1032, NULL, 'U12191112-18', '742', NULL, '4', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1033, NULL, 'U22151113-32', '742', NULL, '1', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1034, NULL, 'U22151113-32', '742', NULL, '2', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1035, NULL, 'U22151113-32', '742', NULL, '3', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1036, NULL, 'U22151113-32', '742', NULL, '4', 15.00, 0.00, 15.00, 0.00, 15.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1037, NULL, NULL, '006', NULL, '1', 16.00, 11.00, 27.00, 0.00, 27.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1038, NULL, NULL, '006', NULL, '2', 16.00, 0.00, 16.00, 0.00, 16.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1039, NULL, NULL, '006', NULL, '3', 16.00, 0.00, 16.00, 0.00, 16.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00),
(1040, NULL, NULL, '006', NULL, '4', 16.00, 0.00, 16.00, 0.00, 16.00, 'D', '2023-11-24 13:05:30', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '8-9', '2023', NULL, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_predio`
--

CREATE TABLE `estado_predio` (
  `Id_Estado_Predio` int(11) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_predio`
--

INSERT INTO `estado_predio` (`Id_Estado_Predio`, `Estado`) VALUES
(1, 'TERRENO SIN CONSTRUCCION'),
(2, 'EN CONSTRUCCION'),
(3, 'TERMINADO'),
(4, 'EN RUINAS'),
(5, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financiamiento`
--

CREATE TABLE `financiamiento` (
  `Id_financiamiento` int(11) NOT NULL,
  `Financia` char(2) NOT NULL,
  `Nombre_Financiamiento` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `financiamiento`
--

INSERT INTO `financiamiento` (`Id_financiamiento`, `Financia`, `Nombre_Financiamiento`) VALUES
(1, '08', 'IMPUESTOS MUNICIPALES'),
(2, '09', 'RECURSOS DIRECTAMENTE RECAUDADOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formula_impuesto`
--

CREATE TABLE `formula_impuesto` (
  `Id_Formula_Impuesto` int(11) NOT NULL,
  `Codigo_Calculo` int(11) DEFAULT NULL,
  `Id_Anio` int(11) DEFAULT NULL,
  `Id_UIT` int(11) DEFAULT NULL,
  `Base_imponible` decimal(10,2) DEFAULT NULL,
  `Base` varchar(250) DEFAULT NULL,
  `FormulaBase` decimal(10,2) DEFAULT NULL,
  `PorcBase` decimal(10,2) DEFAULT NULL,
  `Autovaluo` decimal(10,2) DEFAULT NULL,
  `Fechabase` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formula_impuesto`
--

INSERT INTO `formula_impuesto` (`Id_Formula_Impuesto`, `Codigo_Calculo`, `Id_Anio`, `Id_UIT`, `Base_imponible`, `Base`, `FormulaBase`, `PorcBase`, `Autovaluo`, `Fechabase`) VALUES
(4, 1, 1, 1, 4950.00, 'De 0 3UIT', 0.00, 0.60, 29.50, '2023-08-27 10:50:45'),
(5, 2, 1, 1, 14850.00, 'De 3 Hasta 15 UIT', 1.00, 0.20, 148.50, '2023-08-27 10:50:45'),
(6, 3, 1, 1, 74250.00, 'De 15 Hasta 60 UIT', 1.00, 0.60, 1336.50, '2023-08-27 10:50:45'),
(7, 4, 1, 1, 297000.00, 'De 60 UIT a Mas', 1.00, 1.00, 1485.00, '2023-08-27 10:50:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_emision`
--

CREATE TABLE `gastos_emision` (
  `Id_Gastos_Emision` int(11) NOT NULL,
  `Gasto_Emision` decimal(10,2) NOT NULL,
  `Incremento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `gastos_emision`
--

INSERT INTO `gastos_emision` (`Id_Gastos_Emision`, `Gasto_Emision`, `Incremento`) VALUES
(1, 5.00, 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `giro_comercial`
--

CREATE TABLE `giro_comercial` (
  `Id_Giro_Comercial` int(11) NOT NULL,
  `Nombre` varchar(250) NOT NULL,
  `Estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `giro_comercial`
--

INSERT INTO `giro_comercial` (`Id_Giro_Comercial`, `Nombre`, `Estado`) VALUES
(1, 'Restaurante', '1'),
(2, 'Grifo', '1'),
(3, 'ferreteria', '0'),
(4, 'Farmacia2', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `giro_establecimiento`
--

CREATE TABLE `giro_establecimiento` (
  `Id_Giro_Establecimiento` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `giro_establecimiento`
--

INSERT INTO `giro_establecimiento` (`Id_Giro_Establecimiento`, `Nombre`) VALUES
(1, 'RESTAURANT'),
(2, 'ZAPATERIA'),
(3, 'FERRETERIA'),
(4, 'CLINICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_tierra`
--

CREATE TABLE `grupo_tierra` (
  `Id_Grupo_Tierra` int(11) NOT NULL,
  `Altura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo_tierra`
--

INSERT INTO `grupo_tierra` (`Id_Grupo_Tierra`, `Altura`) VALUES
(1, 'DE 500 A 2000 m.n.sm'),
(2, 'DE 2001 A 3000 m.s.n.m'),
(3, 'DE 3001 A 4000 m.s.n.m'),
(4, 'MAS DE 4000 m.s.n.m'),
(5, 'TERRENOS ERIAZOS'),
(6, 'PRUEBA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia`
--

CREATE TABLE `guia` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `cli_tipodoc` int(11) DEFAULT NULL,
  `tipodoc` varchar(4) DEFAULT NULL,
  `serie` varchar(15) NOT NULL,
  `correlativo` int(11) NOT NULL,
  `fecha_emision` date DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL,
  `comp_ref` varchar(15) DEFAULT NULL,
  `baja_numdoc` varchar(50) DEFAULT NULL,
  `baja_tipodoc` varchar(6) DEFAULT NULL,
  `rel_numdoc` varchar(100) DEFAULT NULL,
  `rel_tipodoc` varchar(6) DEFAULT NULL,
  `terceros_tipodoc` varchar(6) DEFAULT NULL,
  `terceros_numdoc` varchar(15) DEFAULT NULL,
  `terceros_nombrerazon` varchar(180) DEFAULT NULL,
  `cod_traslado` varchar(5) DEFAULT NULL,
  `uniPeso` varchar(5) DEFAULT NULL,
  `pesoTotal` float DEFAULT NULL,
  `numBultos` int(11) DEFAULT NULL,
  `indTransbordo` varchar(20) DEFAULT NULL,
  `modTraslado` varchar(5) DEFAULT NULL,
  `fechaTraslado` date DEFAULT NULL,
  `transp_tipoDoc` varchar(6) DEFAULT NULL,
  `transp_numDoc` varchar(15) DEFAULT NULL,
  `transp_nombreRazon` varchar(250) DEFAULT NULL,
  `transp_placa` varchar(15) DEFAULT NULL,
  `tipoDocChofer` varchar(6) DEFAULT NULL,
  `numDocChofer` varchar(15) DEFAULT NULL,
  `ubigeoPartida` varchar(15) DEFAULT NULL,
  `direccionPartida` varchar(300) DEFAULT NULL,
  `ubigeoLlegada` varchar(15) DEFAULT NULL,
  `direccionLlegada` varchar(300) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `xmlbase64` text DEFAULT NULL,
  `cdrbase64` text DEFAULT NULL,
  `tipovehiculo` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_detalle`
--

CREATE TABLE `guia_detalle` (
  `id` int(11) NOT NULL,
  `indexg` int(11) DEFAULT NULL,
  `id_guia` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `codSunat` varchar(30) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilitaciones_urbanas`
--

CREATE TABLE `habilitaciones_urbanas` (
  `Id_Habilitacion_Urbana` int(11) NOT NULL,
  `Habilitacion_Urbana` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habilitaciones_urbanas`
--

INSERT INTO `habilitaciones_urbanas` (`Id_Habilitacion_Urbana`, `Habilitacion_Urbana`) VALUES
(1, 'ASETAMIENTO HUMANO'),
(2, 'AGRUPACION'),
(3, 'CONJUNTO HABITACIONAL'),
(4, 'CONJUNTO RESIDENCIAL'),
(5, 'PUEBLO JOVEN'),
(6, 'URBANIZACION'),
(7, 'URBANIZACION POPULAR'),
(8, 'CERCADO'),
(9, 'HACIENDA'),
(10, 'ASOCIACION'),
(11, 'COOPERATIVA'),
(12, 'LOTIZACION'),
(13, 'PARCELA'),
(14, 'VALLE'),
(15, 'CASERIO'),
(16, 'UNIDAD VECINAL'),
(17, 'COMUNIDAD'),
(18, 'BARRIO'),
(19, 'FUNDO'),
(20, 'JUNTA COMPRADORES'),
(21, 'ASOCIACION DE VIVIENDA'),
(22, 'COOPERATIVA DE VIVIENDA'),
(23, 'SOCIEDAD'),
(24, 'ASOCIACION PRO VIVIENDA'),
(25, 'ZONA'),
(26, 'CENTRO POBLADO'),
(27, 'ANEXO'),
(28, 'LUGAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inafecto`
--

CREATE TABLE `inafecto` (
  `Id_inafecto` int(11) NOT NULL,
  `Inafectacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inafecto`
--

INSERT INTO `inafecto` (`Id_inafecto`, `Inafectacion`) VALUES
(1, 'NINGUNO'),
(2, 'PATRIMONIO CULTURAL'),
(3, 'MONUMENTO HISTORICO'),
(4, 'CONCESIONES MINERAS'),
(5, 'CONCESIONES FORESTALES'),
(6, 'PREDIO DESTINADO A AERONAVEGACION'),
(7, 'PATRIMONIO FAMILIAR'),
(8, 'COMISARIA/DELEGACION/CUARTEL'),
(9, 'PREDIO ENTREGADO POR CONCESION'),
(10, 'PREDIO PROPIEDAD DEL ESTADO'),
(11, 'PREDIO ADM POR PROPIETARIO (BENEF SNRP)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_tributos`
--

CREATE TABLE `ingresos_tributos` (
  `Id_Ingresos_Tributos` int(11) NOT NULL,
  `Numeracion_caja` int(11) DEFAULT NULL,
  `Id_Area` int(11) DEFAULT NULL,
  `Id_Presupuesto` int(11) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL,
  `Fecha_Pago` datetime DEFAULT NULL,
  `Anula_Pago` char(1) DEFAULT NULL,
  `Fecha_Anula` datetime NOT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Cierre` char(1) DEFAULT NULL,
  `Id_Estado_Cuenta_Impuesto` int(11) DEFAULT NULL,
  `Id_financiamiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_gestion`
--

CREATE TABLE `instrumento_gestion` (
  `Id_Instrumento_Gestion` int(11) NOT NULL,
  `Instrumento_Gestion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instrumento_gestion`
--

INSERT INTO `instrumento_gestion` (`Id_Instrumento_Gestion`, `Instrumento_Gestion`) VALUES
(1, 'TUPA'),
(2, 'TUSNE'),
(3, 'ORDENANZA MUNICIPAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `movimiento` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_actual` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `movimiento`, `accion`, `cantidad`, `stock_actual`, `fecha`, `id_producto`, `id_usuario`) VALUES
(1, 'Venta N°: 1', 'salida', 1, -1, '2023-06-05 22:44:28', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lado`
--

CREATE TABLE `lado` (
  `Id_Lado` int(11) NOT NULL,
  `Lado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lado`
--

INSERT INTO `lado` (`Id_Lado`, `Lado`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manzana`
--

CREATE TABLE `manzana` (
  `Id_Manzana` int(11) NOT NULL,
  `NumeroManzana` char(3) DEFAULT NULL,
  `Condicion` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `manzana`
--

INSERT INTO `manzana` (`Id_Manzana`, `NumeroManzana`, `Condicion`) VALUES
(1, '1', 'FORMAL'),
(2, '2', 'FORMAL'),
(3, '3', 'FORMAL'),
(4, '4', 'FORMAL'),
(5, '5', 'FORMAL'),
(6, '6', 'FORMAL'),
(7, '7', 'FORMAL'),
(8, '8', 'FORMAL'),
(9, '9', 'FORMAL'),
(10, '10', 'FORMAL'),
(11, '11', 'FORMAL'),
(12, '12', 'FORMAL'),
(13, '13', 'FORMAL'),
(14, '14', 'FORMAL'),
(15, '15', 'FORMAL'),
(16, '16', 'FORMAL'),
(17, '17', 'FORMAL'),
(18, '18', 'FORMAL'),
(19, '19', 'FORMAL'),
(20, '20', 'FORMAL'),
(21, '21', 'FORMAL'),
(22, '22', 'FORMAL'),
(23, '23', 'FORMAL'),
(24, '24', 'FORMAL'),
(25, '25', 'FORMAL'),
(26, '26', 'FORMAL'),
(27, '27', 'FORMAL'),
(28, '28', 'FORMAL'),
(29, '29', 'FORMAL'),
(30, '30', 'FORMAL'),
(31, '31', 'FORMAL'),
(32, '32', 'FORMAL'),
(33, '33', 'FORMAL'),
(34, '34', 'FORMAL'),
(35, '35', 'FORMAL'),
(36, '36', 'FORMAL'),
(37, '37', 'FORMAL'),
(38, '38', 'FORMAL'),
(39, '39', 'FORMAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_piso`
--

CREATE TABLE `material_piso` (
  `Id_Material_Piso` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `material_piso`
--

INSERT INTO `material_piso` (`Id_Material_Piso`, `Nombre`, `Estado`) VALUES
(1, 'Concreto', '1'),
(2, 'Ladrillo', '1'),
(3, 'Adobe y Qunicha', '1'),
(4, 'Manera', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_pago`
--

CREATE TABLE `medio_pago` (
  `codigo` varchar(3) NOT NULL,
  `descripcion` varchar(187) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medio_pago`
--

INSERT INTO `medio_pago` (`codigo`, `descripcion`) VALUES
('001', 'Depósito en cuenta'),
('002', 'Giro'),
('003', 'Transferencia bancaria'),
('004', 'Orden de pago'),
('005', 'Tarjeta de débito'),
('006', 'Tarjeta de crédito'),
('007', 'Cheques con la cláusula de \"NO NEGOCIABLE\", \"INTRANSFERIBLES\", \"NO A LA ORDEN\" u otra equivalente, a que se refiere el inciso g) del artículo 5° de la ley'),
('008', 'Efectivo, por operaciones en las que no existe obligación de utilizar medio de pago'),
('009', 'Efectivo'),
('010', 'Medios de pago usados en comercio exterior'),
('011', 'Documentos emitidos por las EDPYMES y las cooperativas de ahorro y crédito no autorizadas a captar depósitos del público'),
('012', 'Tarjeta de crédito emitida en el país o en el exterior por una empresa no perteneciente al sistema financiero, cuyo objeto principal sea la emisión y administración de tarjetas de crédito'),
('013', 'Tarjetas de crédito emitidas en el exterior por empresas bancarias o financieras no domiciliadas'),
('101', 'Transferencias – Comercio exterior'),
('102', 'Cheques bancarios - Comercio exterior'),
('103', 'Orden de pago simple - Comercio exterior'),
('104', 'Orden de pago documentario - Comercio exterior'),
('105', 'Remesa simple - Comercio exterior'),
('106', 'Remesa documentaria - Comercio exterior'),
('107', 'Carta de crédito simple - Comercio exterior'),
('108', 'Carta de crédito documentario - Comercio exterior'),
('999', 'Otros medios de pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_transporte`
--

CREATE TABLE `modalidad_transporte` (
  `codigo` varchar(2) NOT NULL,
  `descripcion` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modalidad_transporte`
--

INSERT INTO `modalidad_transporte` (`codigo`, `descripcion`) VALUES
('01', 'TRANSPORTE PÚBLICO'),
('02', 'TRANSPORTE PRIVADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_traslado`
--

CREATE TABLE `motivo_traslado` (
  `codigo` varchar(2) NOT NULL,
  `descripcion` varchar(51) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `motivo_traslado`
--

INSERT INTO `motivo_traslado` (`codigo`, `descripcion`) VALUES
('01', 'VENTA'),
('02', 'COMPRA'),
('04', 'TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA'),
('08', 'IMPORTACIÓN'),
('09', 'EXPORTACIÓN'),
('13', 'OTROS'),
('14', 'VENTA SUJETA A CONFIRMACIÓN DEL COMPRADOR'),
('18', 'TRASLADO EMISOR ITINERANTE CP'),
('19', 'TRASLADO A ZONA PRIMARIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `Tipo` char(18) NOT NULL,
  `Id_Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`Tipo`, `Id_Nivel`) VALUES
('Administrador', 1),
('FISCALIZACION', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_arbitrios`
--

CREATE TABLE `nombre_arbitrios` (
  `Id_Nombre_Arbitrio` int(11) NOT NULL,
  `Nombre_Arbitrio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nombre_arbitrios`
--

INSERT INTO `nombre_arbitrios` (`Id_Nombre_Arbitrio`, `Nombre_Arbitrio`) VALUES
(1, 'BARRIDO DE CALLES'),
(2, 'RECOLECCION DE RESIDUOS SOLIDOS'),
(3, 'PARQUES Y JARDINES'),
(4, 'SEGURIDAD CIUDADANA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_via`
--

CREATE TABLE `nombre_via` (
  `Id_Nombre_Via` int(11) NOT NULL,
  `Nombre_Via` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nombre_via`
--

INSERT INTO `nombre_via` (`Id_Nombre_Via`, `Nombre_Via`) VALUES
(1, 'TACNA'),
(2, 'ICA'),
(3, 'SAN JUAN'),
(4, 'TUMBES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE `nota_credito` (
  `id` int(11) NOT NULL,
  `idemisor` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `idserie` int(11) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `codmoneda` char(3) DEFAULT NULL,
  `tipocambio` float DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT 0.00,
  `descuento` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `tipocomp_ref` char(2) DEFAULT NULL,
  `serie_ref` char(4) DEFAULT NULL,
  `correlativo_ref` int(11) DEFAULT NULL,
  `seriecorrelativo_ref` varchar(15) DEFAULT NULL,
  `codmotivo` varchar(5) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito_detalle`
--

CREATE TABLE `nota_credito_detalle` (
  `id` int(11) NOT NULL,
  `idnc` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT 0.00,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_debito`
--

CREATE TABLE `nota_debito` (
  `id` int(11) NOT NULL,
  `idemisor` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `idserie` int(11) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `codmoneda` char(3) DEFAULT NULL,
  `tipocambio` float DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT 0.00,
  `descuento` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `tipocomp_ref` char(2) DEFAULT NULL,
  `serie_ref` char(4) DEFAULT NULL,
  `correlativo_ref` int(11) DEFAULT NULL,
  `seriecorrelativo_ref` varchar(100) DEFAULT NULL,
  `codmotivo` varchar(5) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_debito_detalle`
--

CREATE TABLE `nota_debito_detalle` (
  `id` int(11) NOT NULL,
  `idnd` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT 0.00,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_credito`
--

CREATE TABLE `pago_credito` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `fecha` text DEFAULT NULL,
  `cuota` text DEFAULT NULL,
  `tipopago` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

CREATE TABLE `parametro` (
  `Id_Parametro` int(11) NOT NULL,
  `Parametro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`Id_Parametro`, `Parametro`) VALUES
(1, 'Muros y Columnas'),
(2, 'Techos'),
(3, 'Pisos'),
(4, 'Puertas y Ventanas'),
(5, 'Revestimientos'),
(6, 'Banios'),
(7, 'Instalaciones Eléctricas y Sanitarias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parque_distancia`
--

CREATE TABLE `parque_distancia` (
  `Id_Parque_Distancia` int(11) NOT NULL,
  `Parque_Distancia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parque_distancia`
--

INSERT INTO `parque_distancia` (`Id_Parque_Distancia`, `Parque_Distancia`) VALUES
(1, 'FRENTE AL PARQUE'),
(2, 'MEDIANAMENTE CERCA AL PARQUE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pisos`
--

CREATE TABLE `pisos` (
  `Id_Piso` int(11) NOT NULL,
  `Catastro_Piso` varchar(20) DEFAULT NULL,
  `Numero_Piso` int(11) DEFAULT NULL,
  `Incremento` decimal(10,2) DEFAULT NULL,
  `Fecha_Construccion` date DEFAULT NULL,
  `Cantidad_Anios` int(11) DEFAULT NULL,
  `Valores_Unitarios` decimal(10,2) DEFAULT NULL,
  `Incrementos` decimal(10,2) DEFAULT NULL,
  `Porcentaje_Depreciacion` decimal(10,2) DEFAULT NULL,
  `Valor_Unitario_Depreciado` decimal(10,2) DEFAULT NULL,
  `Area_Construida` decimal(10,2) DEFAULT NULL,
  `Valor_Area_Construida` decimal(10,2) DEFAULT NULL,
  `Areas_Comunes` decimal(10,2) DEFAULT NULL,
  `Valor_Areas_Comunes` decimal(10,2) DEFAULT NULL,
  `Valor_Construida` decimal(10,2) DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT current_timestamp(),
  `Categorias_Edificacion` varchar(10) NOT NULL,
  `Id_Estado_Conservacion` int(11) DEFAULT NULL,
  `Id_Clasificacion_Piso` int(11) DEFAULT NULL,
  `Id_Material_Piso` int(11) DEFAULT NULL,
  `Id_Predio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pisos`
--

INSERT INTO `pisos` (`Id_Piso`, `Catastro_Piso`, `Numero_Piso`, `Incremento`, `Fecha_Construccion`, `Cantidad_Anios`, `Valores_Unitarios`, `Incrementos`, `Porcentaje_Depreciacion`, `Valor_Unitario_Depreciado`, `Area_Construida`, `Valor_Area_Construida`, `Areas_Comunes`, `Valor_Areas_Comunes`, `Valor_Construida`, `Fecha_Registro`, `Categorias_Edificacion`, `Id_Estado_Conservacion`, `Id_Clasificacion_Piso`, `Id_Material_Piso`, `Id_Predio`) VALUES
(318, 'U12191111-25', 1, 0.00, '2015-11-20', 8, 1354.12, 0.00, 3.00, 1313.50, 23.00, 30210.50, 0.00, 0.00, 30210.50, '2023-11-20 21:16:37', 'ABD', 1, 1, 2, 16),
(319, 'U12191111-25', 2, 0.00, '2023-11-07', 0, 1720.48, 0.00, 0.00, 1720.48, 25.00, 43012.00, 0.00, 0.00, 43012.00, '2023-11-20 21:17:33', 'AAA', 1, 1, 1, 16),
(320, 'U12191111-29', 1, 0.00, '2023-11-20', 0, 893.68, 0.00, 0.00, 893.68, 80.00, 71494.40, 0.00, 0.00, 71494.40, '2023-11-20 21:34:16', 'BCD', 1, 1, 1, 21),
(321, 'U12191112-18', 1, 0.00, '2020-10-30', 3, 1448.79, 0.00, 0.00, 1448.79, 60.00, 86927.40, 0.00, 0.00, 86927.40, '2023-11-21 15:55:47', 'ABC', 1, 1, 1, 14),
(326, 'U22151114-17', 1, 0.00, '2023-11-23', 0, 310.54, 0.00, 0.00, 310.54, 50.00, 15527.00, 0.00, 0.00, 15527.00, '2023-11-23 16:22:49', 'FFF', 1, 1, 1, 12),
(327, 'U22151114-17', 2, 0.00, '2023-11-23', 0, 623.96, 0.00, 5.00, 592.76, 50.00, 29638.00, 0.00, 0.00, 29638.00, '2023-11-23 16:30:06', 'CDE', 2, 1, 1, 12),
(328, 'U22151113-26', 1, 0.00, '2023-11-23', 0, 807.97, 0.00, 5.00, 767.57, 70.00, 53729.90, 0.00, 0.00, 53729.90, '2023-11-23 16:32:04', 'CCCDDFF', 2, 1, 1, 17),
(330, 'U12191111-25', 3, 0.00, '2023-11-23', 0, 644.73, 0.00, 5.00, 612.49, 70.00, 42874.30, 0.00, 0.00, 42874.30, '2023-11-23 18:42:55', 'DDD', 2, 1, 1, 16),
(331, 'U22151114-17', 3, 0.00, '2023-11-22', 0, 472.99, 0.00, 5.00, 449.34, 70.00, 31453.80, 0.00, 0.00, 31453.80, '2023-11-23 19:00:51', 'GFB', 2, 1, 1, 12),
(332, 'U22151114-27', 1, 0.00, '2023-11-23', 0, 150.07, 0.00, 5.00, 142.57, 80.00, 11405.60, 0.00, 0.00, 11405.60, '2023-11-23 19:32:59', 'GGG', 2, 1, 1, 19),
(333, 'U22151113-26', 2, 0.00, '2023-11-15', 0, 799.96, 0.00, 5.00, 759.96, 70.00, 75262.60, 0.00, 0.00, 75262.60, '2023-11-23 19:50:18', 'CDDDDDD', 2, 1, 1, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piso_predio`
--

CREATE TABLE `piso_predio` (
  `Id_Piso_Predio` int(11) NOT NULL,
  `Id_Piso` int(11) NOT NULL,
  `Id_Predio` int(11) NOT NULL,
  `Fecha_Registro` datetime NOT NULL DEFAULT current_timestamp(),
  `Fecha_Modificacion` datetime NOT NULL,
  `Estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio`
--

CREATE TABLE `predio` (
  `Id_Predio` int(11) NOT NULL,
  `Fecha_Adquisicion` datetime DEFAULT NULL,
  `Numero_Luz` char(10) DEFAULT NULL,
  `Area_Terreno` decimal(10,2) DEFAULT NULL,
  `Valor_Terreno` decimal(10,2) DEFAULT NULL,
  `Valor_Construccion` decimal(10,2) DEFAULT NULL,
  `Valor_Otras_Instalacions` decimal(10,2) DEFAULT NULL,
  `Valor_predio` decimal(10,2) DEFAULT NULL,
  `Expediente_Tramite` varchar(250) DEFAULT NULL,
  `Observaciones` varchar(250) DEFAULT NULL,
  `predio_UR` varchar(1) DEFAULT NULL,
  `Area_Construccion` decimal(10,2) DEFAULT NULL,
  `Id_Tipo_Predio` int(11) DEFAULT NULL,
  `Id_Giro_Establecimiento` int(11) DEFAULT NULL,
  `Id_Uso_Predio` int(11) DEFAULT NULL,
  `Id_Estado_Predio` int(11) DEFAULT NULL,
  `Id_Regimen_Afecto` int(11) DEFAULT NULL,
  `Id_inafecto` int(11) DEFAULT NULL,
  `Id_Arbitrios` int(11) DEFAULT NULL,
  `Id_Condicion_Predio` int(11) DEFAULT NULL,
  `Fecha_Registro` datetime NOT NULL DEFAULT current_timestamp(),
  `Id_Catastro` int(11) DEFAULT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Id_Sesion` int(11) DEFAULT NULL,
  `Id_Uso_Terreno` int(11) DEFAULT NULL,
  `Id_Tipo_Terreno` int(11) DEFAULT NULL,
  `Id_Colindante_Denominacion` int(11) DEFAULT NULL,
  `Id_Colindante_Propietario` int(11) DEFAULT NULL,
  `Valor_Inaf_Exo` decimal(10,2) DEFAULT NULL,
  `Id_Catastro_Rural` int(11) DEFAULT NULL,
  `Id_Denominacion_Rural` int(11) DEFAULT NULL,
  `Valor_Predio_Aplicar` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predio`
--

INSERT INTO `predio` (`Id_Predio`, `Fecha_Adquisicion`, `Numero_Luz`, `Area_Terreno`, `Valor_Terreno`, `Valor_Construccion`, `Valor_Otras_Instalacions`, `Valor_predio`, `Expediente_Tramite`, `Observaciones`, `predio_UR`, `Area_Construccion`, `Id_Tipo_Predio`, `Id_Giro_Establecimiento`, `Id_Uso_Predio`, `Id_Estado_Predio`, `Id_Regimen_Afecto`, `Id_inafecto`, `Id_Arbitrios`, `Id_Condicion_Predio`, `Fecha_Registro`, `Id_Catastro`, `Id_Anio`, `Id_Sesion`, `Id_Uso_Terreno`, `Id_Tipo_Terreno`, `Id_Colindante_Denominacion`, `Id_Colindante_Propietario`, `Valor_Inaf_Exo`, `Id_Catastro_Rural`, `Id_Denominacion_Rural`, `Valor_Predio_Aplicar`) VALUES
(12, '2023-11-14 00:00:00', '21', 21.00, 420.00, 76618.80, 0.00, 77038.80, '12', '212', 'U', 170.00, 1, 1, 1, 1, 4, 7, 2, 1, '2023-11-14 20:29:58', 17, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(13, '0000-00-00 00:00:00', NULL, 2.00, 3646.00, 0.00, 0.00, 3646.00, '23', '23', 'R', 0.00, 65, NULL, 30, 5, 2, 1, NULL, 1, '2023-11-14 20:44:56', NULL, 1, 1, 3, 1, 53, NULL, 1823.00, 62, 6, 0.00),
(14, '2023-11-14 00:00:00', '2', 34.00, 408.00, 86927.40, 0.00, 87335.40, '34', 'SIN OBSRVACIOENES', 'U', 60.00, 1, 1, 3, 3, 1, 1, 1, 10, '2023-11-14 20:47:44', 18, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(15, '2023-11-14 00:00:00', NULL, 32.00, 58336.00, 0.00, 0.00, 58336.00, '32', 'SIN OBSERVACIONES', 'R', 0.00, 65, NULL, 30, 5, 2, 7, NULL, 1, '2023-11-14 20:49:19', NULL, 1, 1, 2, 1, 54, NULL, 29168.00, 63, 10, 29168.00),
(16, '2023-11-08 00:00:00', '12', 21.00, 252.00, 116096.80, 0.00, 116348.80, '12', '21', 'U', 118.00, 16, 1, 16, 1, 1, 1, 1, 9, '2023-11-14 21:03:12', 25, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(17, '2023-11-14 00:00:00', '32', 23.00, 2070.00, 128992.50, 0.00, 131062.50, '34', 'sin observaciones', 'U', 140.00, 1, 1, 1, 1, 1, 1, 2, 10, '2023-11-14 21:42:02', 26, 2, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(18, '0000-00-00 00:00:00', NULL, 23.00, 46000.00, 0.00, 0.00, 46000.00, 'ger', 'gr', 'R', 0.00, 62, NULL, 30, 5, 2, 1, NULL, 1, '2023-11-14 21:43:27', NULL, 2, 1, 1, 1, 55, NULL, 23000.00, 64, 12, 0.00),
(19, '2023-11-17 00:00:00', '23', 100.00, 2000.00, 11405.60, 0.00, 13405.60, '12', 'stalin', 'U', 80.00, 1, 1, 1, 2, 4, 7, 3, 1, '2023-11-17 12:28:51', 27, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(20, '2023-11-17 00:00:00', '33', 100.00, 1200.00, 0.00, 0.00, 1200.00, '12', 'aa', 'U', 0.00, 1, 1, 1, 2, 4, 7, 2, 1, '2023-11-17 12:31:20', 28, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(21, '2023-11-08 00:00:00', '2', 150.00, 1800.00, 71494.40, 0.00, 73294.40, '3', 'stalin ', 'U', 80.00, 1, 1, 1, 2, 4, 7, 2, 1, '2023-11-17 12:36:33', 29, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 0.00),
(22, '2023-11-17 00:00:00', NULL, 23.00, 41929.00, 0.00, 0.00, 41929.00, '32', '', 'R', 0.00, 65, NULL, 30, 5, 2, 1, NULL, 1, '2023-11-17 12:49:28', NULL, 1, 1, 4, 4, 56, NULL, 20964.50, 65, 13, 0.00),
(23, '2023-11-22 00:00:00', NULL, 0.50, 911.50, 0.00, 0.00, 911.50, '2123', 'PRUEBA VALOR PREDIO A APLICAR', 'R', 0.00, 64, NULL, 30, 5, 2, 1, NULL, 1, '2023-11-22 19:03:44', NULL, 1, 1, 1, 2, 57, NULL, 455.75, 66, 14, 455.75),
(24, '2023-11-15 00:00:00', NULL, 2.00, 3646.00, 0.00, 0.00, 3646.00, '23', 'SIN OBSERVACIONES', 'R', 0.00, 64, NULL, 30, 5, 2, 1, NULL, 1, '2023-11-22 20:15:40', NULL, 1, 1, 1, 2, 58, NULL, 1823.00, 67, 15, 1823.00),
(25, '2023-11-22 00:00:00', '23', 50.00, 1000.00, 0.00, 0.00, 1000.00, '7u', '67u', 'U', 0.00, 15, 1, 18, 2, 4, 7, 1, 9, '2023-11-22 20:27:04', 32, 1, 1, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, 1000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `Id_Presupuesto` int(11) NOT NULL,
  `Codigo` varchar(20) NOT NULL,
  `Descripcion` varchar(250) NOT NULL,
  `Estado` char(1) NOT NULL,
  `Id_financiamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuesto`
--

INSERT INTO `presupuesto` (`Id_Presupuesto`, `Codigo`, `Descripcion`, `Estado`, `Id_financiamiento`) VALUES
(1, '112111', 'IMPUESTO PREDIAL CORRIENTE', '1', 1),
(2, '112112', 'IMPUESTO PREDIAL NO CORRIENTE', '1', 1),
(3, '112121', 'IMPUESTO DE ALCABALA', '0', 1),
(4, '13210111', 'ACCESO A LA INFORMACION PUBLICA', '1', 2),
(9, '11111456', 'CLASFICADOR PRUEBA', '0', 1),
(10, '234r2343', 't3grg', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `serie` varchar(50) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `imagen` text NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo_precio` char(2) DEFAULT NULL,
  `precio_compra` decimal(11,2) DEFAULT 0.00,
  `precio_unitario` decimal(11,2) DEFAULT 0.00,
  `valor_unitario` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT 0.00,
  `ventas` int(11) DEFAULT NULL,
  `codigoafectacion` char(2) DEFAULT NULL,
  `codunidad` char(5) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `serie`, `descripcion`, `imagen`, `stock`, `tipo_precio`, `precio_compra`, `precio_unitario`, `valor_unitario`, `igv`, `ventas`, `codigoafectacion`, `codunidad`, `fecha`) VALUES
(3, 1, '7757811000301', '', 'WORKSHOP OFFICE 2016', 'vistas/img/productos/default/anonymous.png', 82876, '01', 82.60, 118.00, 100.00, 18.00, 0, '10', 'ZZ', '2023-08-16 23:41:18'),
(4, 2, '7750182001809', 'LP0942-S', 'Laptop Lenovo V15 IIL, 15.6\" HD, Core i7, 8GB RAM, 1TB', 'vistas/img/productos/201/414.jpeg', 144128, '01', 2275.00, 3250.00, 2754.24, 495.76, 0, '10', 'NIU', '2023-08-16 23:41:18'),
(5, 1, '103', '', 'WORKSHOP PROGRMACIÓN DE SISTEMA DE FACTURACIÓN', 'vistas/img/productos/default/anonymous.png', 9130, '01', 210.00, 300.00, 254.24, 45.76, 1, '10', 'ZZ', '2023-10-23 20:13:52'),
(6, 2, '201', 'LP4590-DLL', 'Laptop DELL ', 'vistas/img/productos/202/237.jpeg', 157712, '01', 3010.00, 4300.00, 3644.07, 655.93, 0, '10', 'NIU', '2023-08-16 23:41:18'),
(34, 2, '7702031976493', '', 'Laptop Lenovo i8', 'vistas/img/productos/203/847.jpeg', 14, '01', 2884.00, 4120.00, 3491.53, 628.47, 0, '10', 'NIU', '2023-06-08 20:32:12'),
(44, 1, '222', '', 'Matrícula', 'vistas/img/productos/default/anonymous.png', 29, '01', 82.60, 118.00, 100.00, 18.00, 0, '10', 'NIU', '2023-05-28 04:14:01'),
(45, 1, 'MMKKV4O', '', 'gtg', 'vistas/img/productos/default/anonymous.png', 3, '01', 2.10, 3.00, 2.54, 0.46, NULL, '10', 'BO', '2023-08-18 22:30:01'),
(46, 1, 'NCN90UM', '', 'FDWEF', 'vistas/img/productos/default/anonymous.png', 1, '01', 0.70, 1.00, 0.85, 0.15, NULL, '10', 'BG', '2023-08-18 22:58:21'),
(49, 1, 'YS0HFPB', '', '1', 'vistas/img/productos/default/anonymous.png', 1, '01', 0.70, 1.00, 0.85, 0.15, NULL, '10', 'BO', '2023-08-21 21:31:29'),
(50, 1, '8QFI6EH', '', '3243', 'vistas/img/productos/default/anonymous.png', 34, '01', 0.70, 1.00, 0.85, 0.15, NULL, '10', 'BG', '2023-09-12 16:11:45'),
(51, 1, '8QFI6EH', '', '3243', 'vistas/img/productos/default/anonymous.png', 34, '01', 0.70, 1.00, 0.85, 0.15, NULL, '10', 'BG', '2023-09-12 16:11:45'),
(52, 1, 'V1C3ECJ', '', 'IMPRESION', 'vistas/img/productos/default/anonymous.png', 12, '01', 8.40, 12.00, 10.17, 1.83, NULL, '10', 'BG', '2023-09-25 01:05:13'),
(53, 1, 'JFQ4MUH', '', 'IMPRESION', 'vistas/img/productos/default/anonymous.png', 12, '01', 1.40, 2.00, 1.69, 0.31, NULL, '10', 'BG', '2023-09-25 01:05:33'),
(54, 2, '', '', 'Laptop DELL ', 'vistas/img/productos/default/anonymous.png', 12, '01', 14.70, 21.00, 17.80, 3.20, NULL, '10', 'BG', '2023-09-25 01:06:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietario`
--

CREATE TABLE `propietario` (
  `Id_Propietario` int(11) NOT NULL,
  `Id_Predio` int(11) NOT NULL,
  `Id_Contribuyente` int(11) NOT NULL,
  `Fecha_Registro` datetime NOT NULL DEFAULT current_timestamp(),
  `Estado_Transferencia` varchar(1) DEFAULT NULL,
  `Fecha_Transferencia` datetime DEFAULT NULL,
  `Id_Detalle_Transferencia` int(11) DEFAULT NULL,
  `Id_Detalle_Eliminar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietario`
--

INSERT INTO `propietario` (`Id_Propietario`, `Id_Predio`, `Id_Contribuyente`, `Fecha_Registro`, `Estado_Transferencia`, `Fecha_Transferencia`, `Id_Detalle_Transferencia`, `Id_Detalle_Eliminar`) VALUES
(8, 12, 9, '2023-11-14 20:29:58', 'R', NULL, 235, NULL),
(9, 13, 9, '2023-11-14 20:44:56', 'R', NULL, 236, NULL),
(10, 14, 9, '2023-11-14 20:47:44', 'R', NULL, 237, NULL),
(11, 14, 8, '2023-11-14 20:47:44', 'R', NULL, 237, NULL),
(12, 15, 9, '2023-11-14 20:49:19', 'R', NULL, 238, NULL),
(13, 15, 8, '2023-11-14 20:49:19', 'R', NULL, 238, NULL),
(14, 16, 9, '2023-11-14 21:03:12', 'R', NULL, 239, NULL),
(15, 17, 9, '2023-11-14 21:42:02', 'R', NULL, 240, NULL),
(16, 18, 9, '2023-11-14 21:43:27', 'R', NULL, 241, NULL),
(17, 19, 9, '2023-11-17 12:28:51', 'R', NULL, 242, NULL),
(18, 20, 9, '2023-11-17 12:31:20', 'R', NULL, 243, NULL),
(19, 21, 9, '2023-11-17 12:36:33', 'R', NULL, 244, NULL),
(20, 22, 9, '2023-11-17 12:49:28', 'R', NULL, 245, NULL),
(21, 23, 6, '2023-11-22 19:03:44', 'R', NULL, 246, NULL),
(22, 24, 9, '2023-11-22 20:15:40', 'R', NULL, 247, NULL),
(23, 24, 8, '2023-11-22 20:15:40', 'R', NULL, 247, NULL),
(24, 25, 9, '2023-11-22 20:27:04', 'R', NULL, 248, NULL),
(25, 25, 8, '2023-11-22 20:27:04', 'R', NULL, 248, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `documento` varchar(15) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ubigeo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `documento`, `ruc`, `razon_social`, `email`, `telefono`, `direccion`, `ubigeo`) VALUES
(1, '', '', '20552103816', 'AGROLIGHT PERU S.A.C.', NULL, NULL, 'PJ. JORGE BASADRE NRO. 158 URB. POP LA UNIVERSAL 2DA ET.', '150137'),
(2, '', '', '20494100186', '\" IMPORTACIONES FVC EIRL \"', NULL, NULL, 'JR. CORONEL SECADA NRO. 281 URB. MOYOBAMBA', '220101');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimen_afecto`
--

CREATE TABLE `regimen_afecto` (
  `Id_Regimen_Afecto` int(11) NOT NULL,
  `Regimen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `regimen_afecto`
--

INSERT INTO `regimen_afecto` (`Id_Regimen_Afecto`, `Regimen`) VALUES
(1, 'INAFECTO'),
(2, 'EXONERADO PARCIALMENTE'),
(3, 'EXONERADO TOTALMENTE'),
(4, 'AFECTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_financiamiento`
--

CREATE TABLE `reporte_financiamiento` (
  `Id_Reporte_Financiamiento` int(11) NOT NULL,
  `Id_Presupuesto` int(11) DEFAULT NULL,
  `Id_Area` int(11) DEFAULT NULL,
  `Subtotsl` decimal(10,2) DEFAULT NULL,
  `Id_Financia` int(11) DEFAULT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `Inicio_Sesion` datetime NOT NULL DEFAULT current_timestamp(),
  `Fin_Sesion` datetime NOT NULL DEFAULT current_timestamp(),
  `Id_Sesion` int(11) NOT NULL,
  `Id_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`Inicio_Sesion`, `Fin_Sesion`, `Id_Sesion`, `Id_Usuario`) VALUES
('2023-08-02 08:49:51', '2023-08-02 08:49:51', 0, 1),
('0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
('2023-07-31 00:00:00', '2023-07-31 00:00:00', 2, 1),
('2023-07-31 15:38:35', '2023-07-31 15:38:35', 3, 1),
('2023-07-31 16:29:03', '2023-07-31 16:29:03', 4, 1),
('2023-07-31 17:45:39', '2023-07-31 17:45:39', 5, 1),
('2023-07-31 18:06:46', '2023-07-31 18:06:46', 6, 1),
('2023-07-31 20:44:56', '2023-07-31 20:44:56', 7, 1),
('2023-07-31 22:14:27', '2023-07-31 22:14:27', 8, 1),
('2023-08-01 08:20:45', '2023-08-01 08:20:45', 9, 1),
('2023-08-01 16:14:16', '2023-08-01 16:14:16', 10, 1),
('2023-08-01 16:58:30', '2023-08-01 16:58:30', 11, 1),
('2023-08-01 20:33:43', '2023-08-01 20:33:43', 12, 1),
('2023-08-01 21:15:44', '2023-08-01 21:15:44', 13, 1),
('2023-08-01 21:17:59', '2023-08-01 21:17:59', 14, 6),
('2023-08-01 21:18:12', '2023-08-01 21:18:12', 15, 6),
('2023-08-01 21:18:28', '2023-08-01 21:18:28', 16, 6),
('2023-08-01 21:20:29', '2023-08-01 21:20:29', 17, 6),
('2023-08-01 21:21:03', '2023-08-01 21:21:03', 18, 6),
('2023-08-01 21:21:16', '2023-08-01 21:21:16', 19, 6),
('2023-08-01 21:22:30', '2023-08-01 21:22:30', 20, 6),
('2023-08-01 21:22:34', '2023-08-01 21:22:34', 21, 1),
('2023-08-01 21:22:43', '2023-08-01 21:22:43', 22, 6),
('2023-08-01 21:24:32', '2023-08-01 21:24:32', 23, 6),
('2023-08-01 21:24:56', '2023-08-01 21:24:56', 24, 6),
('2023-08-01 21:25:04', '2023-08-01 21:25:04', 25, 6),
('2023-08-01 21:28:29', '2023-08-01 21:28:29', 26, 6),
('2023-08-01 21:29:27', '2023-08-01 21:29:27', 27, 6),
('2023-08-01 21:29:39', '2023-08-01 21:29:39', 28, 6),
('2023-08-01 21:32:20', '2023-08-01 21:32:20', 29, 6),
('2023-08-01 21:34:01', '2023-08-01 21:34:01', 30, 1),
('2023-08-01 21:34:17', '2023-08-01 21:34:17', 31, 1),
('2023-08-01 21:34:22', '2023-08-01 21:34:22', 32, 6),
('2023-08-01 21:36:08', '2023-08-01 21:36:08', 33, 1),
('2023-08-01 21:42:46', '2023-08-01 21:42:46', 34, 1),
('2023-08-01 21:46:12', '2023-08-01 21:46:12', 35, 6),
('2023-08-01 21:48:52', '2023-08-01 21:48:52', 36, 1),
('2023-08-01 22:02:48', '2023-08-01 22:02:48', 37, 6),
('2023-08-01 22:02:59', '2023-08-01 22:02:59', 38, 1),
('2023-08-01 22:03:23', '2023-08-01 22:03:23', 39, 1),
('2023-08-01 22:11:51', '2023-08-01 22:11:51', 40, 1),
('2023-08-01 22:22:36', '2023-08-01 22:22:36', 41, 1),
('2023-08-01 23:37:48', '2023-08-01 23:37:48', 42, 1),
('2023-08-01 23:59:36', '2023-08-01 23:59:36', 43, 1),
('2023-08-02 08:52:50', '2023-08-02 08:52:50', 44, 1),
('2023-08-02 11:20:18', '2023-08-02 11:20:18', 45, 1),
('2023-08-02 18:17:54', '2023-08-02 18:17:54', 46, 1),
('2023-08-02 18:19:18', '2023-08-02 18:19:18', 47, 1),
('2023-08-04 09:23:14', '2023-08-04 09:23:14', 48, 1),
('2023-08-07 08:26:56', '2023-08-07 08:26:56', 49, 1),
('2023-08-07 09:41:35', '2023-08-07 09:41:35', 50, 1),
('2023-08-07 09:44:46', '2023-08-07 09:44:46', 51, 1),
('2023-08-07 11:16:31', '2023-08-07 11:16:31', 52, 1),
('2023-08-08 09:01:05', '2023-08-08 09:01:05', 53, 1),
('2023-08-08 09:01:49', '2023-08-08 09:01:49', 54, 1),
('2023-08-08 09:05:11', '2023-08-08 09:05:11', 55, 1),
('2023-08-08 09:18:14', '2023-08-08 09:18:14', 56, 1),
('2023-08-08 17:54:12', '2023-08-08 17:54:12', 57, 1),
('2023-08-09 16:04:51', '2023-08-09 16:04:51', 58, 1),
('2023-08-09 17:42:44', '2023-08-09 17:42:44', 59, 1),
('2023-08-10 11:44:02', '2023-08-10 11:44:02', 60, 1),
('2023-08-10 15:52:28', '2023-08-10 15:52:28', 61, 1),
('2023-08-11 08:37:55', '2023-08-11 08:37:55', 62, 1),
('2023-08-14 08:48:08', '2023-08-14 08:48:08', 63, 1),
('2023-08-14 10:34:32', '2023-08-14 10:34:32', 64, 1),
('2023-08-15 15:20:41', '2023-08-15 15:20:41', 65, 1),
('2023-08-16 08:27:44', '2023-08-16 08:27:44', 66, 1),
('2023-08-16 09:01:48', '2023-08-16 09:01:48', 67, 1),
('2023-08-16 09:10:58', '2023-08-16 09:10:58', 68, 1),
('2023-08-16 09:56:56', '2023-08-16 09:56:56', 69, 1),
('2023-08-16 10:05:57', '2023-08-16 10:05:57', 70, 1),
('2023-08-16 10:06:25', '2023-08-16 10:06:25', 71, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `situacion_cuadra`
--

CREATE TABLE `situacion_cuadra` (
  `Id_Situacion_Cuadra` int(11) NOT NULL,
  `Situacion_Cuadra` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `situacion_cuadra`
--

INSERT INTO `situacion_cuadra` (`Id_Situacion_Cuadra`, `Situacion_Cuadra`) VALUES
(1, 'PISTA Y VEREDA'),
(2, 'TIERRA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_parametrica`
--

CREATE TABLE `tabla_parametrica` (
  `codigo` varchar(5) NOT NULL,
  `tipo` char(1) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tabla_parametrica`
--

INSERT INTO `tabla_parametrica` (`codigo`, `tipo`, `descripcion`) VALUES
('01', 'C', 'Anulación de la operación'),
('02', 'C', 'Anulación por error en el RUC'),
('03', 'C', 'Corrección por error en la descripción'),
('04', 'C', 'Descuento global'),
('05', 'C', 'Descuento por ítem'),
('06', 'C', 'Devolución total'),
('07', 'C', 'Devolución por ítem'),
('08', 'C', 'Bonificación'),
('09', 'C', 'Disminución en el valor'),
('10', 'C', 'Otros Conceptos'),
('11', 'C', 'Ajustes de operaciones de exportación'),
('12', 'C', 'Ajustes afectos al IVAP'),
('01', 'D', 'Intereses por mora'),
('02', 'D', 'Aumento en el valor'),
('03', 'D', 'Penalidades/ otros conceptos'),
('10', 'D', 'Ajustes de operaciones de exportación'),
('11', 'D', 'Ajustes afectos al IVAP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa_arbitrio`
--

CREATE TABLE `tasa_arbitrio` (
  `Id_Tasa_Arbitrio` int(11) NOT NULL,
  `Id_Arbitrios` int(11) NOT NULL,
  `Id_Nombre_Arbitrio` int(11) NOT NULL,
  `Id_Anio` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tasa_arbitrio`
--

INSERT INTO `tasa_arbitrio` (`Id_Tasa_Arbitrio`, `Id_Arbitrios`, `Id_Nombre_Arbitrio`, `Id_Anio`, `Monto`) VALUES
(1, 1, 1, 1, 2.00),
(2, 1, 2, 1, 3.00),
(3, 1, 3, 1, 2.00),
(4, 1, 4, 1, 3.00),
(5, 2, 1, 1, 2.00),
(6, 2, 2, 1, 3.00),
(7, 2, 3, 1, 1.00),
(8, 2, 4, 1, 2.00),
(9, 3, 1, 1, 1.00),
(10, 3, 2, 1, 2.00),
(11, 3, 3, 1, 0.00),
(12, 3, 4, 1, 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tim`
--

CREATE TABLE `tim` (
  `Id_TIM` int(11) NOT NULL,
  `Anio` varchar(4) DEFAULT NULL,
  `Porcentaje` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tim`
--

INSERT INTO `tim` (`Id_TIM`, `Anio`, `Porcentaje`) VALUES
(5, '2022', 4.00),
(6, '2023', 4.00),
(16, '2020', 14.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id` int(11) NOT NULL,
  `codigo` int(11) DEFAULT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `codigo_afectacion` varchar(11) DEFAULT NULL,
  `nombre_afectacion` char(4) DEFAULT NULL,
  `tipo_afectacion` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_afectacion`
--

INSERT INTO `tipo_afectacion` (`id`, `codigo`, `descripcion`, `codigo_afectacion`, `nombre_afectacion`, `tipo_afectacion`) VALUES
(46, 10, 'Gravado - Operación Onerosa', '1000', 'IGV', 'VAT'),
(47, 11, 'Gravado – Retiro por premio', '9996', 'GRA', 'FRE'),
(48, 12, 'Gravado – Retiro por donación', '9996', 'GRA', 'FRE'),
(49, 13, 'Gravado – Retiro', '9996', 'GRA', 'FRE'),
(50, 14, 'Gravado – Retiro por publicidad', '9996', 'GRA', 'FRE'),
(51, 15, 'Gravado – Bonificaciones', '9996', 'GRA', 'FRE'),
(52, 16, 'Gravado – Retiro por entrega a trabajadores', '9996', 'GRA', 'FRE'),
(53, 17, 'Gravado - IVAP', '1016', 'IVAP', 'VAT'),
(54, 20, 'Exonerado - Operación Onerosa', '9997', 'EXO', 'VAT'),
(55, 21, 'Exonerado - Transferencia gratuita', '9996', 'EXO', 'VAT'),
(56, 30, 'Inafecto - Operación Onerosa', '9998', 'INA', 'FRE'),
(57, 31, 'Inafecto – Retiro por Bonificación', '9996', 'GRA', 'FRE'),
(58, 32, 'Inafecto – Retiro', '9996', 'GRA', 'FRE'),
(59, 33, 'Inafecto – Retiro por Muestras Médicas', '9996', 'GRA', 'FRE'),
(60, 34, 'Inafecto - Retiro por Convenio Colectivo', '9996', 'GRA', 'FRE'),
(61, 35, 'Inafecto – Retiro por premio', '9996', 'GRA', 'FRE'),
(62, 36, 'Inafecto - Retiro por publicidad', '9996', 'GRA', 'FRE'),
(64, 40, 'Exportación de Bienes o Servicios', '9995', 'EXP', 'FRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`codigo`, `descripcion`) VALUES
('01', 'FACTURA'),
('03', 'BOLETA'),
('07', 'NOTA DE CRÉDITO'),
('08', 'NOTA DE DEBITO'),
('09', 'GUIA DE REMISION'),
('02', 'NOTA DE VENTA'),
('00', 'COTIZACIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_contribuyente`
--

CREATE TABLE `tipo_contribuyente` (
  `Id_Tipo_Contribuyente` int(11) NOT NULL,
  `Tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_contribuyente`
--

INSERT INTO `tipo_contribuyente` (`Id_Tipo_Contribuyente`, `Tipo`) VALUES
(1, 'PERSONA NATURAL'),
(2, 'PERSONA NATURAL CON EMP. UNIPERSONAL'),
(3, 'SOCIEDAD CONYUGAL'),
(4, 'SOCIEDAD CONYUGAL CON EMP. UNIPERSONAL'),
(5, 'SUCESION INDIVISA'),
(6, 'SUCESION INDIVISA CON EMP. UNIPERSONAL'),
(7, 'EMPRESA INDIVIDUAL DE RESP. LTDA'),
(8, 'SUCESION CIVIL'),
(9, 'SOCIEDAD HECHO'),
(10, 'ASOCIACION EN PARTICIPACION'),
(11, 'ASOCIACION'),
(12, 'FUNDACION'),
(13, 'SOCIEDAD EN COMANDITA SIMPLE'),
(14, 'SOCIEDAD COLECTIVA'),
(15, 'INSTITUCIONES PUBLICAS'),
(16, 'INSTITUCIONES RELIGIOSAS'),
(17, 'BENEFICIENCIA'),
(18, 'ENTIDADES DE AUXILIO MUTUO'),
(19, 'UNIVERSIDADES , CENTROS EDUCATIVOS Y CULTURALES'),
(20, 'GOBIERNO LOCAL'),
(21, 'GOBIERNO CENTRAL'),
(22, 'COMUNIDAD CAMPESINA NATIVA'),
(23, 'COOPERATIVA , SAIS, CAPS'),
(24, 'EMPRESAS DE PROPIEDAD SOCIAL '),
(25, 'SOCIEDAD ANONIMA'),
(26, 'SOCIEDAD EN COMANDITA POR ACCIONES'),
(27, 'SOCIEDAD DE RESPONSABILIDAD LTDA'),
(28, 'SUCURSALES O AGENCIAS DE EMP. EXTRANJERA'),
(29, 'EMPRESAS DE DERECHO PUBLICO'),
(30, 'EMPRESA ESTATAL DE DERECHO PRIVADO'),
(31, 'EMPRESAS DE ECONOMIA MIXTA'),
(32, 'ACCIONARIOS DEL ESTADO'),
(33, 'EMBAJADAS , CONSULADOS , ORG. INTERNAS Y OTROS'),
(34, 'PERSONA JURIDICA'),
(35, 'CONVIVIENTE'),
(36, 'COOPROPIETARIO'),
(37, 'SUCESION INTESTADO DEFINITIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `codigo` varchar(1) NOT NULL,
  `descripcion` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`codigo`, `descripcion`) VALUES
('0', 'SIN DOCUMENTO'),
('1', 'D.N.I.'),
('4', 'CARNET DE EXTRANJERÍA'),
('6', 'R.U.C.'),
('7', 'PASAPORTE'),
('A', 'CÉDULA DIPLOMÁTICA DE IDENTIDAD'),
('B', 'DOC.IDENT.PAIS.RESIDENCIA-NO.D'),
('C', 'Tax Identification Number - TIN – Doc Trib PP.NN'),
('D', 'Identification Number - IN – Doc Trib PP. JJ'),
('E', 'TAM- Tarjeta Andina de Migración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento_siat`
--

CREATE TABLE `tipo_documento_siat` (
  `Id_Tipo_Documento` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento_siat`
--

INSERT INTO `tipo_documento_siat` (`Id_Tipo_Documento`, `descripcion`) VALUES
(1, 'SIN DOCUMENTO'),
(2, 'D.N.I.'),
(3, 'CARNET DE EXTRANJERÍA'),
(4, 'R.U.C.'),
(5, 'PASAPORTE'),
(6, 'CÉDULA DIPLOMÁTICA DE IDENTIDAD'),
(7, 'DOC.IDENT.PAIS.RESIDENCIA-NO.D'),
(8, 'Tax Identification Number - TIN – Doc Trib PP.NN'),
(9, 'Identification Number - IN – Doc Trib PP. JJ'),
(10, 'TAM- Tarjeta Andina de Migración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_escritura`
--

CREATE TABLE `tipo_escritura` (
  `Id_Tipo_Escritura` int(11) NOT NULL,
  `Tipo_Escritura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_escritura`
--

INSERT INTO `tipo_escritura` (`Id_Tipo_Escritura`, `Tipo_Escritura`) VALUES
(1, 'COMPRAVENTA'),
(2, 'COMPRAVENTA DE BIEN FUTURO'),
(3, 'COMPRA VENTA CON RESERVA DE PROPIEDAD'),
(4, 'ANTICIPO EN LEGITIMA'),
(5, 'DONACION'),
(6, 'TRANSMISION SUCESORIA'),
(7, 'REMATE'),
(8, 'PERMUTA'),
(9, 'SEPARACION DEL REGIMEN PATRIMONIAL'),
(10, 'RESOLUCION DE CONTRATO'),
(11, 'POSESION'),
(12, 'SUCESION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_predio`
--

CREATE TABLE `tipo_predio` (
  `Id_Tipo_Predio` int(11) NOT NULL,
  `Tipo` char(50) DEFAULT NULL,
  `RU` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_predio`
--

INSERT INTO `tipo_predio` (`Id_Tipo_Predio`, `Tipo`, `RU`) VALUES
(1, 'PREDIO INDEPENDIENTE', 'U'),
(2, 'DEPARTAMENTO U OFICINA EN EDIFICIO', 'U'),
(3, 'PREDIO EN QUINTA', 'U'),
(6, 'VIVIENDA EN CASA SOLAR', 'U'),
(7, 'VIVIENDA EN CORRALON', 'U'),
(15, 'VIVIENDA EN CALLEJON', 'U'),
(16, 'OTROS', 'U'),
(62, 'TERRENO INDEPENDIENTE O PRINCIPAL', 'R'),
(63, 'RANCHERA', 'R'),
(64, 'CHOZA CABAÑA', 'R'),
(65, 'OTROS', 'R');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_terreno`
--

CREATE TABLE `tipo_terreno` (
  `Id_Tipo_Terreno` int(11) NOT NULL,
  `Tipo_Terreno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_terreno`
--

INSERT INTO `tipo_terreno` (`Id_Tipo_Terreno`, `Tipo_Terreno`) VALUES
(1, 'HACIENDA O FUNDO'),
(2, 'LOTE,PARCELA,CHACRA'),
(3, 'ESTABLO'),
(4, 'GRANJA'),
(5, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_via`
--

CREATE TABLE `tipo_via` (
  `Id_Tipo_Via` int(11) NOT NULL,
  `Codigo` varchar(5) DEFAULT NULL,
  `Nomenclatura` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_via`
--

INSERT INTO `tipo_via` (`Id_Tipo_Via`, `Codigo`, `Nomenclatura`) VALUES
(1, 'Av.', 'Avenida'),
(2, 'Jr.', 'Jiron'),
(3, 'Psj', 'Pasaje'),
(4, 'Alm.', 'Alameda'),
(5, 'Mal.', 'Malecon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencia_predios`
--

CREATE TABLE `transferencia_predios` (
  `Id_Predio` int(11) NOT NULL,
  `Id_Contribuyente` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Id_Transferencia` int(11) NOT NULL,
  `Id_Sesion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubica_via_urbano`
--

CREATE TABLE `ubica_via_urbano` (
  `Id_Ubica_Vias_Urbano` int(11) NOT NULL,
  `Id_Cuadra` int(11) DEFAULT NULL,
  `Id_Lado` int(11) DEFAULT NULL,
  `Id_Direccion` int(11) DEFAULT NULL,
  `Id_Condicion_Catastral` int(11) NOT NULL,
  `Id_Situacion_Cuadra` int(11) NOT NULL,
  `Id_Parque_Distancia` int(11) NOT NULL,
  `Id_Manzana` int(11) NOT NULL,
  `Id_Zona_Catastro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubica_via_urbano`
--

INSERT INTO `ubica_via_urbano` (`Id_Ubica_Vias_Urbano`, `Id_Cuadra`, `Id_Lado`, `Id_Direccion`, `Id_Condicion_Catastral`, `Id_Situacion_Cuadra`, `Id_Parque_Distancia`, `Id_Manzana`, `Id_Zona_Catastro`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 2, 1, 1, 1, 1, 1, 1),
(3, 2, 1, 2, 1, 1, 2, 1, 1),
(4, 2, 2, 2, 1, 1, 2, 1, 1),
(12, 1, 1, 5, 1, 1, 2, 4, 2),
(13, 1, 2, 5, 1, 1, 2, 4, 2),
(14, 2, 1, 6, 1, 1, 2, 4, 2),
(15, 2, 2, 6, 1, 1, 2, 4, 2),
(16, 1, 1, 7, 1, 2, 2, 5, 4),
(17, 1, 2, 7, 1, 2, 2, 5, 4),
(18, 3, 1, 3, 1, 1, 1, 3, 1),
(19, 3, 2, 3, 1, 1, 1, 3, 1),
(20, 4, 1, 3, 1, 1, 2, 7, 4),
(21, 4, 2, 3, 1, 1, 2, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_departamento`
--

CREATE TABLE `ubigeo_departamento` (
  `id` varchar(2) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_departamento`
--

INSERT INTO `ubigeo_departamento` (`id`, `name`) VALUES
('01', 'AMAZONAS'),
('02', 'ÁNCASH'),
('03', 'APURÍMAC'),
('04', 'AREQUIPA'),
('05', 'AYACUCHO'),
('06', 'CAJAMARCA'),
('07', 'CALLAO'),
('08', 'CUSCO'),
('09', 'HUANCAVELICA'),
('10', 'HUÁNUCO'),
('11', 'ICA'),
('12', 'JUNÍN'),
('13', 'LA LIBERTAD'),
('14', 'LAMBAYEQUE'),
('15', 'LIMA'),
('16', 'LORETO'),
('17', 'MADRE DE DIOS'),
('18', 'MOQUEGUA'),
('19', 'PASCO'),
('20', 'PIURA'),
('21', 'PUNO'),
('22', 'SAN MARTÍN'),
('23', 'TACNA'),
('24', 'TUMBES'),
('25', 'UCAYALI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_departamento_siat`
--

CREATE TABLE `ubigeo_departamento_siat` (
  `Id_Departamento` int(11) NOT NULL,
  `Departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_departamento_siat`
--

INSERT INTO `ubigeo_departamento_siat` (`Id_Departamento`, `Departamento`) VALUES
(1, 'AYACUCHO'),
(2, 'APURIMAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_distrito`
--

CREATE TABLE `ubigeo_distrito` (
  `id` varchar(6) NOT NULL,
  `nombre_distrito` varchar(45) DEFAULT NULL,
  `province_id` varchar(4) DEFAULT NULL,
  `department_id` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_distrito`
--

INSERT INTO `ubigeo_distrito` (`id`, `nombre_distrito`, `province_id`, `department_id`) VALUES
('010101', 'CHACHAPOYAS', '0101', '01'),
('010102', 'ASUNCIÓN', '0101', '01'),
('010103', 'BALSAS', '0101', '01'),
('010104', 'CHETO', '0101', '01'),
('010105', 'CHILIQUIN', '0101', '01'),
('010106', 'CHUQUIBAMBA', '0101', '01'),
('010107', 'GRANADA', '0101', '01'),
('010108', 'HUANCAS', '0101', '01'),
('010109', 'LA JALCA', '0101', '01'),
('010110', 'LEIMEBAMBA', '0101', '01'),
('010111', 'LEVANTO', '0101', '01'),
('010112', 'MAGDALENA', '0101', '01'),
('010113', 'MARISCAL CASTILLA', '0101', '01'),
('010114', 'MOLINOPAMPA', '0101', '01'),
('010115', 'MONTEVIDEO', '0101', '01'),
('010116', 'OLLEROS', '0101', '01'),
('010117', 'QUINJALCA', '0101', '01'),
('010118', 'SAN FRANCISCO DE DAGUAS', '0101', '01'),
('010119', 'SAN ISIDRO DE MAINO', '0101', '01'),
('010120', 'SOLOCO', '0101', '01'),
('010121', 'SONCHE', '0101', '01'),
('010201', 'BAGUA', '0102', '01'),
('010202', 'ARAMANGO', '0102', '01'),
('010203', 'COPALLIN', '0102', '01'),
('010204', 'EL PARCO', '0102', '01'),
('010205', 'IMAZA', '0102', '01'),
('010206', 'LA PECA', '0102', '01'),
('010301', 'JUMBILLA', '0103', '01'),
('010302', 'CHISQUILLA', '0103', '01'),
('010303', 'CHURUJA', '0103', '01'),
('010304', 'COROSHA', '0103', '01'),
('010305', 'CUISPES', '0103', '01'),
('010306', 'FLORIDA', '0103', '01'),
('010307', 'JAZAN', '0103', '01'),
('010308', 'RECTA', '0103', '01'),
('010309', 'SAN CARLOS', '0103', '01'),
('010310', 'SHIPASBAMBA', '0103', '01'),
('010311', 'VALERA', '0103', '01'),
('010312', 'YAMBRASBAMBA', '0103', '01'),
('010401', 'NIEVA', '0104', '01'),
('010402', 'EL CENEPA', '0104', '01'),
('010403', 'RÍO SANTIAGO', '0104', '01'),
('010501', 'LAMUD', '0105', '01'),
('010502', 'CAMPORREDONDO', '0105', '01'),
('010503', 'COCABAMBA', '0105', '01'),
('010504', 'COLCAMAR', '0105', '01'),
('010505', 'CONILA', '0105', '01'),
('010506', 'INGUILPATA', '0105', '01'),
('010507', 'LONGUITA', '0105', '01'),
('010508', 'LONYA CHICO', '0105', '01'),
('010509', 'LUYA', '0105', '01'),
('010510', 'LUYA VIEJO', '0105', '01'),
('010511', 'MARÍA', '0105', '01'),
('010512', 'OCALLI', '0105', '01'),
('010513', 'OCUMAL', '0105', '01'),
('010514', 'PISUQUIA', '0105', '01'),
('010515', 'PROVIDENCIA', '0105', '01'),
('010516', 'SAN CRISTÓBAL', '0105', '01'),
('010517', 'SAN FRANCISCO DE YESO', '0105', '01'),
('010518', 'SAN JERÓNIMO', '0105', '01'),
('010519', 'SAN JUAN DE LOPECANCHA', '0105', '01'),
('010520', 'SANTA CATALINA', '0105', '01'),
('010521', 'SANTO TOMAS', '0105', '01'),
('010522', 'TINGO', '0105', '01'),
('010523', 'TRITA', '0105', '01'),
('010601', 'SAN NICOLÁS', '0106', '01'),
('010602', 'CHIRIMOTO', '0106', '01'),
('010603', 'COCHAMAL', '0106', '01'),
('010604', 'HUAMBO', '0106', '01'),
('010605', 'LIMABAMBA', '0106', '01'),
('010606', 'LONGAR', '0106', '01'),
('010607', 'MARISCAL BENAVIDES', '0106', '01'),
('010608', 'MILPUC', '0106', '01'),
('010609', 'OMIA', '0106', '01'),
('010610', 'SANTA ROSA', '0106', '01'),
('010611', 'TOTORA', '0106', '01'),
('010612', 'VISTA ALEGRE', '0106', '01'),
('010701', 'BAGUA GRANDE', '0107', '01'),
('010702', 'CAJARURO', '0107', '01'),
('010703', 'CUMBA', '0107', '01'),
('010704', 'EL MILAGRO', '0107', '01'),
('010705', 'JAMALCA', '0107', '01'),
('010706', 'LONYA GRANDE', '0107', '01'),
('010707', 'YAMON', '0107', '01'),
('020101', 'HUARAZ', '0201', '02'),
('020102', 'COCHABAMBA', '0201', '02'),
('020103', 'COLCABAMBA', '0201', '02'),
('020104', 'HUANCHAY', '0201', '02'),
('020105', 'INDEPENDENCIA', '0201', '02'),
('020106', 'JANGAS', '0201', '02'),
('020107', 'LA LIBERTAD', '0201', '02'),
('020108', 'OLLEROS', '0201', '02'),
('020109', 'PAMPAS GRANDE', '0201', '02'),
('020110', 'PARIACOTO', '0201', '02'),
('020111', 'PIRA', '0201', '02'),
('020112', 'TARICA', '0201', '02'),
('020201', 'AIJA', '0202', '02'),
('020202', 'CORIS', '0202', '02'),
('020203', 'HUACLLAN', '0202', '02'),
('020204', 'LA MERCED', '0202', '02'),
('020205', 'SUCCHA', '0202', '02'),
('020301', 'LLAMELLIN', '0203', '02'),
('020302', 'ACZO', '0203', '02'),
('020303', 'CHACCHO', '0203', '02'),
('020304', 'CHINGAS', '0203', '02'),
('020305', 'MIRGAS', '0203', '02'),
('020306', 'SAN JUAN DE RONTOY', '0203', '02'),
('020401', 'CHACAS', '0204', '02'),
('020402', 'ACOCHACA', '0204', '02'),
('020501', 'CHIQUIAN', '0205', '02'),
('020502', 'ABELARDO PARDO LEZAMETA', '0205', '02'),
('020503', 'ANTONIO RAYMONDI', '0205', '02'),
('020504', 'AQUIA', '0205', '02'),
('020505', 'CAJACAY', '0205', '02'),
('020506', 'CANIS', '0205', '02'),
('020507', 'COLQUIOC', '0205', '02'),
('020508', 'HUALLANCA', '0205', '02'),
('020509', 'HUASTA', '0205', '02'),
('020510', 'HUAYLLACAYAN', '0205', '02'),
('020511', 'LA PRIMAVERA', '0205', '02'),
('020512', 'MANGAS', '0205', '02'),
('020513', 'PACLLON', '0205', '02'),
('020514', 'SAN MIGUEL DE CORPANQUI', '0205', '02'),
('020515', 'TICLLOS', '0205', '02'),
('020601', 'CARHUAZ', '0206', '02'),
('020602', 'ACOPAMPA', '0206', '02'),
('020603', 'AMASHCA', '0206', '02'),
('020604', 'ANTA', '0206', '02'),
('020605', 'ATAQUERO', '0206', '02'),
('020606', 'MARCARA', '0206', '02'),
('020607', 'PARIAHUANCA', '0206', '02'),
('020608', 'SAN MIGUEL DE ACO', '0206', '02'),
('020609', 'SHILLA', '0206', '02'),
('020610', 'TINCO', '0206', '02'),
('020611', 'YUNGAR', '0206', '02'),
('020701', 'SAN LUIS', '0207', '02'),
('020702', 'SAN NICOLÁS', '0207', '02'),
('020703', 'YAUYA', '0207', '02'),
('020801', 'CASMA', '0208', '02'),
('020802', 'BUENA VISTA ALTA', '0208', '02'),
('020803', 'COMANDANTE NOEL', '0208', '02'),
('020804', 'YAUTAN', '0208', '02'),
('020901', 'CORONGO', '0209', '02'),
('020902', 'ACO', '0209', '02'),
('020903', 'BAMBAS', '0209', '02'),
('020904', 'CUSCA', '0209', '02'),
('020905', 'LA PAMPA', '0209', '02'),
('020906', 'YANAC', '0209', '02'),
('020907', 'YUPAN', '0209', '02'),
('021001', 'HUARI', '0210', '02'),
('021002', 'ANRA', '0210', '02'),
('021003', 'CAJAY', '0210', '02'),
('021004', 'CHAVIN DE HUANTAR', '0210', '02'),
('021005', 'HUACACHI', '0210', '02'),
('021006', 'HUACCHIS', '0210', '02'),
('021007', 'HUACHIS', '0210', '02'),
('021008', 'HUANTAR', '0210', '02'),
('021009', 'MASIN', '0210', '02'),
('021010', 'PAUCAS', '0210', '02'),
('021011', 'PONTO', '0210', '02'),
('021012', 'RAHUAPAMPA', '0210', '02'),
('021013', 'RAPAYAN', '0210', '02'),
('021014', 'SAN MARCOS', '0210', '02'),
('021015', 'SAN PEDRO DE CHANA', '0210', '02'),
('021016', 'UCO', '0210', '02'),
('021101', 'HUARMEY', '0211', '02'),
('021102', 'COCHAPETI', '0211', '02'),
('021103', 'CULEBRAS', '0211', '02'),
('021104', 'HUAYAN', '0211', '02'),
('021105', 'MALVAS', '0211', '02'),
('021201', 'CARAZ', '0212', '02'),
('021202', 'HUALLANCA', '0212', '02'),
('021203', 'HUATA', '0212', '02'),
('021204', 'HUAYLAS', '0212', '02'),
('021205', 'MATO', '0212', '02'),
('021206', 'PAMPAROMAS', '0212', '02'),
('021207', 'PUEBLO LIBRE', '0212', '02'),
('021208', 'SANTA CRUZ', '0212', '02'),
('021209', 'SANTO TORIBIO', '0212', '02'),
('021210', 'YURACMARCA', '0212', '02'),
('021301', 'PISCOBAMBA', '0213', '02'),
('021302', 'CASCA', '0213', '02'),
('021303', 'ELEAZAR GUZMÁN BARRON', '0213', '02'),
('021304', 'FIDEL OLIVAS ESCUDERO', '0213', '02'),
('021305', 'LLAMA', '0213', '02'),
('021306', 'LLUMPA', '0213', '02'),
('021307', 'LUCMA', '0213', '02'),
('021308', 'MUSGA', '0213', '02'),
('021401', 'OCROS', '0214', '02'),
('021402', 'ACAS', '0214', '02'),
('021403', 'CAJAMARQUILLA', '0214', '02'),
('021404', 'CARHUAPAMPA', '0214', '02'),
('021405', 'COCHAS', '0214', '02'),
('021406', 'CONGAS', '0214', '02'),
('021407', 'LLIPA', '0214', '02'),
('021408', 'SAN CRISTÓBAL DE RAJAN', '0214', '02'),
('021409', 'SAN PEDRO', '0214', '02'),
('021410', 'SANTIAGO DE CHILCAS', '0214', '02'),
('021501', 'CABANA', '0215', '02'),
('021502', 'BOLOGNESI', '0215', '02'),
('021503', 'CONCHUCOS', '0215', '02'),
('021504', 'HUACASCHUQUE', '0215', '02'),
('021505', 'HUANDOVAL', '0215', '02'),
('021506', 'LACABAMBA', '0215', '02'),
('021507', 'LLAPO', '0215', '02'),
('021508', 'PALLASCA', '0215', '02'),
('021509', 'PAMPAS', '0215', '02'),
('021510', 'SANTA ROSA', '0215', '02'),
('021511', 'TAUCA', '0215', '02'),
('021601', 'POMABAMBA', '0216', '02'),
('021602', 'HUAYLLAN', '0216', '02'),
('021603', 'PAROBAMBA', '0216', '02'),
('021604', 'QUINUABAMBA', '0216', '02'),
('021701', 'RECUAY', '0217', '02'),
('021702', 'CATAC', '0217', '02'),
('021703', 'COTAPARACO', '0217', '02'),
('021704', 'HUAYLLAPAMPA', '0217', '02'),
('021705', 'LLACLLIN', '0217', '02'),
('021706', 'MARCA', '0217', '02'),
('021707', 'PAMPAS CHICO', '0217', '02'),
('021708', 'PARARIN', '0217', '02'),
('021709', 'TAPACOCHA', '0217', '02'),
('021710', 'TICAPAMPA', '0217', '02'),
('021801', 'CHIMBOTE', '0218', '02'),
('021802', 'CÁCERES DEL PERÚ', '0218', '02'),
('021803', 'COISHCO', '0218', '02'),
('021804', 'MACATE', '0218', '02'),
('021805', 'MORO', '0218', '02'),
('021806', 'NEPEÑA', '0218', '02'),
('021807', 'SAMANCO', '0218', '02'),
('021808', 'SANTA', '0218', '02'),
('021809', 'NUEVO CHIMBOTE', '0218', '02'),
('021901', 'SIHUAS', '0219', '02'),
('021902', 'ACOBAMBA', '0219', '02'),
('021903', 'ALFONSO UGARTE', '0219', '02'),
('021904', 'CASHAPAMPA', '0219', '02'),
('021905', 'CHINGALPO', '0219', '02'),
('021906', 'HUAYLLABAMBA', '0219', '02'),
('021907', 'QUICHES', '0219', '02'),
('021908', 'RAGASH', '0219', '02'),
('021909', 'SAN JUAN', '0219', '02'),
('021910', 'SICSIBAMBA', '0219', '02'),
('022001', 'YUNGAY', '0220', '02'),
('022002', 'CASCAPARA', '0220', '02'),
('022003', 'MANCOS', '0220', '02'),
('022004', 'MATACOTO', '0220', '02'),
('022005', 'QUILLO', '0220', '02'),
('022006', 'RANRAHIRCA', '0220', '02'),
('022007', 'SHUPLUY', '0220', '02'),
('022008', 'YANAMA', '0220', '02'),
('030101', 'ABANCAY', '0301', '03'),
('030102', 'CHACOCHE', '0301', '03'),
('030103', 'CIRCA', '0301', '03'),
('030104', 'CURAHUASI', '0301', '03'),
('030105', 'HUANIPACA', '0301', '03'),
('030106', 'LAMBRAMA', '0301', '03'),
('030107', 'PICHIRHUA', '0301', '03'),
('030108', 'SAN PEDRO DE CACHORA', '0301', '03'),
('030109', 'TAMBURCO', '0301', '03'),
('030201', 'ANDAHUAYLAS', '0302', '03'),
('030202', 'ANDARAPA', '0302', '03'),
('030203', 'CHIARA', '0302', '03'),
('030204', 'HUANCARAMA', '0302', '03'),
('030205', 'HUANCARAY', '0302', '03'),
('030206', 'HUAYANA', '0302', '03'),
('030207', 'KISHUARA', '0302', '03'),
('030208', 'PACOBAMBA', '0302', '03'),
('030209', 'PACUCHA', '0302', '03'),
('030210', 'PAMPACHIRI', '0302', '03'),
('030211', 'POMACOCHA', '0302', '03'),
('030212', 'SAN ANTONIO DE CACHI', '0302', '03'),
('030213', 'SAN JERÓNIMO', '0302', '03'),
('030214', 'SAN MIGUEL DE CHACCRAMPA', '0302', '03'),
('030215', 'SANTA MARÍA DE CHICMO', '0302', '03'),
('030216', 'TALAVERA', '0302', '03'),
('030217', 'TUMAY HUARACA', '0302', '03'),
('030218', 'TURPO', '0302', '03'),
('030219', 'KAQUIABAMBA', '0302', '03'),
('030220', 'JOSÉ MARÍA ARGUEDAS', '0302', '03'),
('030301', 'ANTABAMBA', '0303', '03'),
('030302', 'EL ORO', '0303', '03'),
('030303', 'HUAQUIRCA', '0303', '03'),
('030304', 'JUAN ESPINOZA MEDRANO', '0303', '03'),
('030305', 'OROPESA', '0303', '03'),
('030306', 'PACHACONAS', '0303', '03'),
('030307', 'SABAINO', '0303', '03'),
('030401', 'CHALHUANCA', '0304', '03'),
('030402', 'CAPAYA', '0304', '03'),
('030403', 'CARAYBAMBA', '0304', '03'),
('030404', 'CHAPIMARCA', '0304', '03'),
('030405', 'COLCABAMBA', '0304', '03'),
('030406', 'COTARUSE', '0304', '03'),
('030407', 'IHUAYLLO', '0304', '03'),
('030408', 'JUSTO APU SAHUARAURA', '0304', '03'),
('030409', 'LUCRE', '0304', '03'),
('030410', 'POCOHUANCA', '0304', '03'),
('030411', 'SAN JUAN DE CHACÑA', '0304', '03'),
('030412', 'SAÑAYCA', '0304', '03'),
('030413', 'SORAYA', '0304', '03'),
('030414', 'TAPAIRIHUA', '0304', '03'),
('030415', 'TINTAY', '0304', '03'),
('030416', 'TORAYA', '0304', '03'),
('030417', 'YANACA', '0304', '03'),
('030501', 'TAMBOBAMBA', '0305', '03'),
('030502', 'COTABAMBAS', '0305', '03'),
('030503', 'COYLLURQUI', '0305', '03'),
('030504', 'HAQUIRA', '0305', '03'),
('030505', 'MARA', '0305', '03'),
('030506', 'CHALLHUAHUACHO', '0305', '03'),
('030601', 'CHINCHEROS', '0306', '03'),
('030602', 'ANCO_HUALLO', '0306', '03'),
('030603', 'COCHARCAS', '0306', '03'),
('030604', 'HUACCANA', '0306', '03'),
('030605', 'OCOBAMBA', '0306', '03'),
('030606', 'ONGOY', '0306', '03'),
('030607', 'URANMARCA', '0306', '03'),
('030608', 'RANRACANCHA', '0306', '03'),
('030609', 'ROCCHACC', '0306', '03'),
('030610', 'EL PORVENIR', '0306', '03'),
('030611', 'LOS CHANKAS', '0306', '03'),
('030701', 'CHUQUIBAMBILLA', '0307', '03'),
('030702', 'CURPAHUASI', '0307', '03'),
('030703', 'GAMARRA', '0307', '03'),
('030704', 'HUAYLLATI', '0307', '03'),
('030705', 'MAMARA', '0307', '03'),
('030706', 'MICAELA BASTIDAS', '0307', '03'),
('030707', 'PATAYPAMPA', '0307', '03'),
('030708', 'PROGRESO', '0307', '03'),
('030709', 'SAN ANTONIO', '0307', '03'),
('030710', 'SANTA ROSA', '0307', '03'),
('030711', 'TURPAY', '0307', '03'),
('030712', 'VILCABAMBA', '0307', '03'),
('030713', 'VIRUNDO', '0307', '03'),
('030714', 'CURASCO', '0307', '03'),
('040101', 'AREQUIPA', '0401', '04'),
('040102', 'ALTO SELVA ALEGRE', '0401', '04'),
('040103', 'CAYMA', '0401', '04'),
('040104', 'CERRO COLORADO', '0401', '04'),
('040105', 'CHARACATO', '0401', '04'),
('040106', 'CHIGUATA', '0401', '04'),
('040107', 'JACOBO HUNTER', '0401', '04'),
('040108', 'LA JOYA', '0401', '04'),
('040109', 'MARIANO MELGAR', '0401', '04'),
('040110', 'MIRAFLORES', '0401', '04'),
('040111', 'MOLLEBAYA', '0401', '04'),
('040112', 'PAUCARPATA', '0401', '04'),
('040113', 'POCSI', '0401', '04'),
('040114', 'POLOBAYA', '0401', '04'),
('040115', 'QUEQUEÑA', '0401', '04'),
('040116', 'SABANDIA', '0401', '04'),
('040117', 'SACHACA', '0401', '04'),
('040118', 'SAN JUAN DE SIGUAS', '0401', '04'),
('040119', 'SAN JUAN DE TARUCANI', '0401', '04'),
('040120', 'SANTA ISABEL DE SIGUAS', '0401', '04'),
('040121', 'SANTA RITA DE SIGUAS', '0401', '04'),
('040122', 'SOCABAYA', '0401', '04'),
('040123', 'TIABAYA', '0401', '04'),
('040124', 'UCHUMAYO', '0401', '04'),
('040125', 'VITOR', '0401', '04'),
('040126', 'YANAHUARA', '0401', '04'),
('040127', 'YARABAMBA', '0401', '04'),
('040128', 'YURA', '0401', '04'),
('040129', 'JOSÉ LUIS BUSTAMANTE Y RIVERO', '0401', '04'),
('040201', 'CAMANÁ', '0402', '04'),
('040202', 'JOSÉ MARÍA QUIMPER', '0402', '04'),
('040203', 'MARIANO NICOLÁS VALCÁRCEL', '0402', '04'),
('040204', 'MARISCAL CÁCERES', '0402', '04'),
('040205', 'NICOLÁS DE PIEROLA', '0402', '04'),
('040206', 'OCOÑA', '0402', '04'),
('040207', 'QUILCA', '0402', '04'),
('040208', 'SAMUEL PASTOR', '0402', '04'),
('040301', 'CARAVELÍ', '0403', '04'),
('040302', 'ACARÍ', '0403', '04'),
('040303', 'ATICO', '0403', '04'),
('040304', 'ATIQUIPA', '0403', '04'),
('040305', 'BELLA UNIÓN', '0403', '04'),
('040306', 'CAHUACHO', '0403', '04'),
('040307', 'CHALA', '0403', '04'),
('040308', 'CHAPARRA', '0403', '04'),
('040309', 'HUANUHUANU', '0403', '04'),
('040310', 'JAQUI', '0403', '04'),
('040311', 'LOMAS', '0403', '04'),
('040312', 'QUICACHA', '0403', '04'),
('040313', 'YAUCA', '0403', '04'),
('040401', 'APLAO', '0404', '04'),
('040402', 'ANDAGUA', '0404', '04'),
('040403', 'AYO', '0404', '04'),
('040404', 'CHACHAS', '0404', '04'),
('040405', 'CHILCAYMARCA', '0404', '04'),
('040406', 'CHOCO', '0404', '04'),
('040407', 'HUANCARQUI', '0404', '04'),
('040408', 'MACHAGUAY', '0404', '04'),
('040409', 'ORCOPAMPA', '0404', '04'),
('040410', 'PAMPACOLCA', '0404', '04'),
('040411', 'TIPAN', '0404', '04'),
('040412', 'UÑON', '0404', '04'),
('040413', 'URACA', '0404', '04'),
('040414', 'VIRACO', '0404', '04'),
('040501', 'CHIVAY', '0405', '04'),
('040502', 'ACHOMA', '0405', '04'),
('040503', 'CABANACONDE', '0405', '04'),
('040504', 'CALLALLI', '0405', '04'),
('040505', 'CAYLLOMA', '0405', '04'),
('040506', 'COPORAQUE', '0405', '04'),
('040507', 'HUAMBO', '0405', '04'),
('040508', 'HUANCA', '0405', '04'),
('040509', 'ICHUPAMPA', '0405', '04'),
('040510', 'LARI', '0405', '04'),
('040511', 'LLUTA', '0405', '04'),
('040512', 'MACA', '0405', '04'),
('040513', 'MADRIGAL', '0405', '04'),
('040514', 'SAN ANTONIO DE CHUCA', '0405', '04'),
('040515', 'SIBAYO', '0405', '04'),
('040516', 'TAPAY', '0405', '04'),
('040517', 'TISCO', '0405', '04'),
('040518', 'TUTI', '0405', '04'),
('040519', 'YANQUE', '0405', '04'),
('040520', 'MAJES', '0405', '04'),
('040601', 'CHUQUIBAMBA', '0406', '04'),
('040602', 'ANDARAY', '0406', '04'),
('040603', 'CAYARANI', '0406', '04'),
('040604', 'CHICHAS', '0406', '04'),
('040605', 'IRAY', '0406', '04'),
('040606', 'RÍO GRANDE', '0406', '04'),
('040607', 'SALAMANCA', '0406', '04'),
('040608', 'YANAQUIHUA', '0406', '04'),
('040701', 'MOLLENDO', '0407', '04'),
('040702', 'COCACHACRA', '0407', '04'),
('040703', 'DEAN VALDIVIA', '0407', '04'),
('040704', 'ISLAY', '0407', '04'),
('040705', 'MEJIA', '0407', '04'),
('040706', 'PUNTA DE BOMBÓN', '0407', '04'),
('040801', 'COTAHUASI', '0408', '04'),
('040802', 'ALCA', '0408', '04'),
('040803', 'CHARCANA', '0408', '04'),
('040804', 'HUAYNACOTAS', '0408', '04'),
('040805', 'PAMPAMARCA', '0408', '04'),
('040806', 'PUYCA', '0408', '04'),
('040807', 'QUECHUALLA', '0408', '04'),
('040808', 'SAYLA', '0408', '04'),
('040809', 'TAURIA', '0408', '04'),
('040810', 'TOMEPAMPA', '0408', '04'),
('040811', 'TORO', '0408', '04'),
('050101', 'AYACUCHO', '0501', '05'),
('050102', 'ACOCRO', '0501', '05'),
('050103', 'ACOS VINCHOS', '0501', '05'),
('050104', 'CARMEN ALTO', '0501', '05'),
('050105', 'CHIARA', '0501', '05'),
('050106', 'OCROS', '0501', '05'),
('050107', 'PACAYCASA', '0501', '05'),
('050108', 'QUINUA', '0501', '05'),
('050109', 'SAN JOSÉ DE TICLLAS', '0501', '05'),
('050110', 'SAN JUAN BAUTISTA', '0501', '05'),
('050111', 'SANTIAGO DE PISCHA', '0501', '05'),
('050112', 'SOCOS', '0501', '05'),
('050113', 'TAMBILLO', '0501', '05'),
('050114', 'VINCHOS', '0501', '05'),
('050115', 'JESÚS NAZARENO', '0501', '05'),
('050116', 'ANDRÉS AVELINO CÁCERES DORREGARAY', '0501', '05'),
('050201', 'CANGALLO', '0502', '05'),
('050202', 'CHUSCHI', '0502', '05'),
('050203', 'LOS MOROCHUCOS', '0502', '05'),
('050204', 'MARÍA PARADO DE BELLIDO', '0502', '05'),
('050205', 'PARAS', '0502', '05'),
('050206', 'TOTOS', '0502', '05'),
('050301', 'SANCOS', '0503', '05'),
('050302', 'CARAPO', '0503', '05'),
('050303', 'SACSAMARCA', '0503', '05'),
('050304', 'SANTIAGO DE LUCANAMARCA', '0503', '05'),
('050401', 'HUANTA', '0504', '05'),
('050402', 'AYAHUANCO', '0504', '05'),
('050403', 'HUAMANGUILLA', '0504', '05'),
('050404', 'IGUAIN', '0504', '05'),
('050405', 'LURICOCHA', '0504', '05'),
('050406', 'SANTILLANA', '0504', '05'),
('050407', 'SIVIA', '0504', '05'),
('050408', 'LLOCHEGUA', '0504', '05'),
('050409', 'CANAYRE', '0504', '05'),
('050410', 'UCHURACCAY', '0504', '05'),
('050411', 'PUCACOLPA', '0504', '05'),
('050412', 'CHACA', '0504', '05'),
('050501', 'SAN MIGUEL', '0505', '05'),
('050502', 'ANCO', '0505', '05'),
('050503', 'AYNA', '0505', '05'),
('050504', 'CHILCAS', '0505', '05'),
('050505', 'CHUNGUI', '0505', '05'),
('050506', 'LUIS CARRANZA', '0505', '05'),
('050507', 'SANTA ROSA', '0505', '05'),
('050508', 'TAMBO', '0505', '05'),
('050509', 'SAMUGARI', '0505', '05'),
('050510', 'ANCHIHUAY', '0505', '05'),
('050511', 'ORONCCOY', '0505', '05'),
('050601', 'PUQUIO', '0506', '05'),
('050602', 'AUCARA', '0506', '05'),
('050603', 'CABANA', '0506', '05'),
('050604', 'CARMEN SALCEDO', '0506', '05'),
('050605', 'CHAVIÑA', '0506', '05'),
('050606', 'CHIPAO', '0506', '05'),
('050607', 'HUAC-HUAS', '0506', '05'),
('050608', 'LARAMATE', '0506', '05'),
('050609', 'LEONCIO PRADO', '0506', '05'),
('050610', 'LLAUTA', '0506', '05'),
('050611', 'LUCANAS', '0506', '05'),
('050612', 'OCAÑA', '0506', '05'),
('050613', 'OTOCA', '0506', '05'),
('050614', 'SAISA', '0506', '05'),
('050615', 'SAN CRISTÓBAL', '0506', '05'),
('050616', 'SAN JUAN', '0506', '05'),
('050617', 'SAN PEDRO', '0506', '05'),
('050618', 'SAN PEDRO DE PALCO', '0506', '05'),
('050619', 'SANCOS', '0506', '05'),
('050620', 'SANTA ANA DE HUAYCAHUACHO', '0506', '05'),
('050621', 'SANTA LUCIA', '0506', '05'),
('050701', 'CORACORA', '0507', '05'),
('050702', 'CHUMPI', '0507', '05'),
('050703', 'CORONEL CASTAÑEDA', '0507', '05'),
('050704', 'PACAPAUSA', '0507', '05'),
('050705', 'PULLO', '0507', '05'),
('050706', 'PUYUSCA', '0507', '05'),
('050707', 'SAN FRANCISCO DE RAVACAYCO', '0507', '05'),
('050708', 'UPAHUACHO', '0507', '05'),
('050801', 'PAUSA', '0508', '05'),
('050802', 'COLTA', '0508', '05'),
('050803', 'CORCULLA', '0508', '05'),
('050804', 'LAMPA', '0508', '05'),
('050805', 'MARCABAMBA', '0508', '05'),
('050806', 'OYOLO', '0508', '05'),
('050807', 'PARARCA', '0508', '05'),
('050808', 'SAN JAVIER DE ALPABAMBA', '0508', '05'),
('050809', 'SAN JOSÉ DE USHUA', '0508', '05'),
('050810', 'SARA SARA', '0508', '05'),
('050901', 'QUEROBAMBA', '0509', '05'),
('050902', 'BELÉN', '0509', '05'),
('050903', 'CHALCOS', '0509', '05'),
('050904', 'CHILCAYOC', '0509', '05'),
('050905', 'HUACAÑA', '0509', '05'),
('050906', 'MORCOLLA', '0509', '05'),
('050907', 'PAICO', '0509', '05'),
('050908', 'SAN PEDRO DE LARCAY', '0509', '05'),
('050909', 'SAN SALVADOR DE QUIJE', '0509', '05'),
('050910', 'SANTIAGO DE PAUCARAY', '0509', '05'),
('050911', 'SORAS', '0509', '05'),
('051001', 'HUANCAPI', '0510', '05'),
('051002', 'ALCAMENCA', '0510', '05'),
('051003', 'APONGO', '0510', '05'),
('051004', 'ASQUIPATA', '0510', '05'),
('051005', 'CANARIA', '0510', '05'),
('051006', 'CAYARA', '0510', '05'),
('051007', 'COLCA', '0510', '05'),
('051008', 'HUAMANQUIQUIA', '0510', '05'),
('051009', 'HUANCARAYLLA', '0510', '05'),
('051010', 'HUALLA', '0510', '05'),
('051011', 'SARHUA', '0510', '05'),
('051012', 'VILCANCHOS', '0510', '05'),
('051101', 'VILCAS HUAMAN', '0511', '05'),
('051102', 'ACCOMARCA', '0511', '05'),
('051103', 'CARHUANCA', '0511', '05'),
('051104', 'CONCEPCIÓN', '0511', '05'),
('051105', 'HUAMBALPA', '0511', '05'),
('051106', 'INDEPENDENCIA', '0511', '05'),
('051107', 'SAURAMA', '0511', '05'),
('051108', 'VISCHONGO', '0511', '05'),
('060101', 'CAJAMARCA', '0601', '06'),
('060102', 'ASUNCIÓN', '0601', '06'),
('060103', 'CHETILLA', '0601', '06'),
('060104', 'COSPAN', '0601', '06'),
('060105', 'ENCAÑADA', '0601', '06'),
('060106', 'JESÚS', '0601', '06'),
('060107', 'LLACANORA', '0601', '06'),
('060108', 'LOS BAÑOS DEL INCA', '0601', '06'),
('060109', 'MAGDALENA', '0601', '06'),
('060110', 'MATARA', '0601', '06'),
('060111', 'NAMORA', '0601', '06'),
('060112', 'SAN JUAN', '0601', '06'),
('060201', 'CAJABAMBA', '0602', '06'),
('060202', 'CACHACHI', '0602', '06'),
('060203', 'CONDEBAMBA', '0602', '06'),
('060204', 'SITACOCHA', '0602', '06'),
('060301', 'CELENDÍN', '0603', '06'),
('060302', 'CHUMUCH', '0603', '06'),
('060303', 'CORTEGANA', '0603', '06'),
('060304', 'HUASMIN', '0603', '06'),
('060305', 'JORGE CHÁVEZ', '0603', '06'),
('060306', 'JOSÉ GÁLVEZ', '0603', '06'),
('060307', 'MIGUEL IGLESIAS', '0603', '06'),
('060308', 'OXAMARCA', '0603', '06'),
('060309', 'SOROCHUCO', '0603', '06'),
('060310', 'SUCRE', '0603', '06'),
('060311', 'UTCO', '0603', '06'),
('060312', 'LA LIBERTAD DE PALLAN', '0603', '06'),
('060401', 'CHOTA', '0604', '06'),
('060402', 'ANGUIA', '0604', '06'),
('060403', 'CHADIN', '0604', '06'),
('060404', 'CHIGUIRIP', '0604', '06'),
('060405', 'CHIMBAN', '0604', '06'),
('060406', 'CHOROPAMPA', '0604', '06'),
('060407', 'COCHABAMBA', '0604', '06'),
('060408', 'CONCHAN', '0604', '06'),
('060409', 'HUAMBOS', '0604', '06'),
('060410', 'LAJAS', '0604', '06'),
('060411', 'LLAMA', '0604', '06'),
('060412', 'MIRACOSTA', '0604', '06'),
('060413', 'PACCHA', '0604', '06'),
('060414', 'PION', '0604', '06'),
('060415', 'QUEROCOTO', '0604', '06'),
('060416', 'SAN JUAN DE LICUPIS', '0604', '06'),
('060417', 'TACABAMBA', '0604', '06'),
('060418', 'TOCMOCHE', '0604', '06'),
('060419', 'CHALAMARCA', '0604', '06'),
('060501', 'CONTUMAZA', '0605', '06'),
('060502', 'CHILETE', '0605', '06'),
('060503', 'CUPISNIQUE', '0605', '06'),
('060504', 'GUZMANGO', '0605', '06'),
('060505', 'SAN BENITO', '0605', '06'),
('060506', 'SANTA CRUZ DE TOLEDO', '0605', '06'),
('060507', 'TANTARICA', '0605', '06'),
('060508', 'YONAN', '0605', '06'),
('060601', 'CUTERVO', '0606', '06'),
('060602', 'CALLAYUC', '0606', '06'),
('060603', 'CHOROS', '0606', '06'),
('060604', 'CUJILLO', '0606', '06'),
('060605', 'LA RAMADA', '0606', '06'),
('060606', 'PIMPINGOS', '0606', '06'),
('060607', 'QUEROCOTILLO', '0606', '06'),
('060608', 'SAN ANDRÉS DE CUTERVO', '0606', '06'),
('060609', 'SAN JUAN DE CUTERVO', '0606', '06'),
('060610', 'SAN LUIS DE LUCMA', '0606', '06'),
('060611', 'SANTA CRUZ', '0606', '06'),
('060612', 'SANTO DOMINGO DE LA CAPILLA', '0606', '06'),
('060613', 'SANTO TOMAS', '0606', '06'),
('060614', 'SOCOTA', '0606', '06'),
('060615', 'TORIBIO CASANOVA', '0606', '06'),
('060701', 'BAMBAMARCA', '0607', '06'),
('060702', 'CHUGUR', '0607', '06'),
('060703', 'HUALGAYOC', '0607', '06'),
('060801', 'JAÉN', '0608', '06'),
('060802', 'BELLAVISTA', '0608', '06'),
('060803', 'CHONTALI', '0608', '06'),
('060804', 'COLASAY', '0608', '06'),
('060805', 'HUABAL', '0608', '06'),
('060806', 'LAS PIRIAS', '0608', '06'),
('060807', 'POMAHUACA', '0608', '06'),
('060808', 'PUCARA', '0608', '06'),
('060809', 'SALLIQUE', '0608', '06'),
('060810', 'SAN FELIPE', '0608', '06'),
('060811', 'SAN JOSÉ DEL ALTO', '0608', '06'),
('060812', 'SANTA ROSA', '0608', '06'),
('060901', 'SAN IGNACIO', '0609', '06'),
('060902', 'CHIRINOS', '0609', '06'),
('060903', 'HUARANGO', '0609', '06'),
('060904', 'LA COIPA', '0609', '06'),
('060905', 'NAMBALLE', '0609', '06'),
('060906', 'SAN JOSÉ DE LOURDES', '0609', '06'),
('060907', 'TABACONAS', '0609', '06'),
('061001', 'PEDRO GÁLVEZ', '0610', '06'),
('061002', 'CHANCAY', '0610', '06'),
('061003', 'EDUARDO VILLANUEVA', '0610', '06'),
('061004', 'GREGORIO PITA', '0610', '06'),
('061005', 'ICHOCAN', '0610', '06'),
('061006', 'JOSÉ MANUEL QUIROZ', '0610', '06'),
('061007', 'JOSÉ SABOGAL', '0610', '06'),
('061101', 'SAN MIGUEL', '0611', '06'),
('061102', 'BOLÍVAR', '0611', '06'),
('061103', 'CALQUIS', '0611', '06'),
('061104', 'CATILLUC', '0611', '06'),
('061105', 'EL PRADO', '0611', '06'),
('061106', 'LA FLORIDA', '0611', '06'),
('061107', 'LLAPA', '0611', '06'),
('061108', 'NANCHOC', '0611', '06'),
('061109', 'NIEPOS', '0611', '06'),
('061110', 'SAN GREGORIO', '0611', '06'),
('061111', 'SAN SILVESTRE DE COCHAN', '0611', '06'),
('061112', 'TONGOD', '0611', '06'),
('061113', 'UNIÓN AGUA BLANCA', '0611', '06'),
('061201', 'SAN PABLO', '0612', '06'),
('061202', 'SAN BERNARDINO', '0612', '06'),
('061203', 'SAN LUIS', '0612', '06'),
('061204', 'TUMBADEN', '0612', '06'),
('061301', 'SANTA CRUZ', '0613', '06'),
('061302', 'ANDABAMBA', '0613', '06'),
('061303', 'CATACHE', '0613', '06'),
('061304', 'CHANCAYBAÑOS', '0613', '06'),
('061305', 'LA ESPERANZA', '0613', '06'),
('061306', 'NINABAMBA', '0613', '06'),
('061307', 'PULAN', '0613', '06'),
('061308', 'SAUCEPAMPA', '0613', '06'),
('061309', 'SEXI', '0613', '06'),
('061310', 'UTICYACU', '0613', '06'),
('061311', 'YAUYUCAN', '0613', '06'),
('070101', 'CALLAO', '0701', '07'),
('070102', 'BELLAVISTA', '0701', '07'),
('070103', 'CARMEN DE LA LEGUA REYNOSO', '0701', '07'),
('070104', 'LA PERLA', '0701', '07'),
('070105', 'LA PUNTA', '0701', '07'),
('070106', 'VENTANILLA', '0701', '07'),
('070107', 'MI PERÚ', '0701', '07'),
('080101', 'CUSCO', '0801', '08'),
('080102', 'CCORCA', '0801', '08'),
('080103', 'POROY', '0801', '08'),
('080104', 'SAN JERÓNIMO', '0801', '08'),
('080105', 'SAN SEBASTIAN', '0801', '08'),
('080106', 'SANTIAGO', '0801', '08'),
('080107', 'SAYLLA', '0801', '08'),
('080108', 'WANCHAQ', '0801', '08'),
('080201', 'ACOMAYO', '0802', '08'),
('080202', 'ACOPIA', '0802', '08'),
('080203', 'ACOS', '0802', '08'),
('080204', 'MOSOC LLACTA', '0802', '08'),
('080205', 'POMACANCHI', '0802', '08'),
('080206', 'RONDOCAN', '0802', '08'),
('080207', 'SANGARARA', '0802', '08'),
('080301', 'ANTA', '0803', '08'),
('080302', 'ANCAHUASI', '0803', '08'),
('080303', 'CACHIMAYO', '0803', '08'),
('080304', 'CHINCHAYPUJIO', '0803', '08'),
('080305', 'HUAROCONDO', '0803', '08'),
('080306', 'LIMATAMBO', '0803', '08'),
('080307', 'MOLLEPATA', '0803', '08'),
('080308', 'PUCYURA', '0803', '08'),
('080309', 'ZURITE', '0803', '08'),
('080401', 'CALCA', '0804', '08'),
('080402', 'COYA', '0804', '08'),
('080403', 'LAMAY', '0804', '08'),
('080404', 'LARES', '0804', '08'),
('080405', 'PISAC', '0804', '08'),
('080406', 'SAN SALVADOR', '0804', '08'),
('080407', 'TARAY', '0804', '08'),
('080408', 'YANATILE', '0804', '08'),
('080501', 'YANAOCA', '0805', '08'),
('080502', 'CHECCA', '0805', '08'),
('080503', 'KUNTURKANKI', '0805', '08'),
('080504', 'LANGUI', '0805', '08'),
('080505', 'LAYO', '0805', '08'),
('080506', 'PAMPAMARCA', '0805', '08'),
('080507', 'QUEHUE', '0805', '08'),
('080508', 'TUPAC AMARU', '0805', '08'),
('080601', 'SICUANI', '0806', '08'),
('080602', 'CHECACUPE', '0806', '08'),
('080603', 'COMBAPATA', '0806', '08'),
('080604', 'MARANGANI', '0806', '08'),
('080605', 'PITUMARCA', '0806', '08'),
('080606', 'SAN PABLO', '0806', '08'),
('080607', 'SAN PEDRO', '0806', '08'),
('080608', 'TINTA', '0806', '08'),
('080701', 'SANTO TOMAS', '0807', '08'),
('080702', 'CAPACMARCA', '0807', '08'),
('080703', 'CHAMACA', '0807', '08'),
('080704', 'COLQUEMARCA', '0807', '08'),
('080705', 'LIVITACA', '0807', '08'),
('080706', 'LLUSCO', '0807', '08'),
('080707', 'QUIÑOTA', '0807', '08'),
('080708', 'VELILLE', '0807', '08'),
('080801', 'ESPINAR', '0808', '08'),
('080802', 'CONDOROMA', '0808', '08'),
('080803', 'COPORAQUE', '0808', '08'),
('080804', 'OCORURO', '0808', '08'),
('080805', 'PALLPATA', '0808', '08'),
('080806', 'PICHIGUA', '0808', '08'),
('080807', 'SUYCKUTAMBO', '0808', '08'),
('080808', 'ALTO PICHIGUA', '0808', '08'),
('080901', 'SANTA ANA', '0809', '08'),
('080902', 'ECHARATE', '0809', '08'),
('080903', 'HUAYOPATA', '0809', '08'),
('080904', 'MARANURA', '0809', '08'),
('080905', 'OCOBAMBA', '0809', '08'),
('080906', 'QUELLOUNO', '0809', '08'),
('080907', 'KIMBIRI', '0809', '08'),
('080908', 'SANTA TERESA', '0809', '08'),
('080909', 'VILCABAMBA', '0809', '08'),
('080910', 'PICHARI', '0809', '08'),
('080911', 'INKAWASI', '0809', '08'),
('080912', 'VILLA VIRGEN', '0809', '08'),
('080913', 'VILLA KINTIARINA', '0809', '08'),
('080914', 'MEGANTONI', '0809', '08'),
('081001', 'PARURO', '0810', '08'),
('081002', 'ACCHA', '0810', '08'),
('081003', 'CCAPI', '0810', '08'),
('081004', 'COLCHA', '0810', '08'),
('081005', 'HUANOQUITE', '0810', '08'),
('081006', 'OMACHAÇ', '0810', '08'),
('081007', 'PACCARITAMBO', '0810', '08'),
('081008', 'PILLPINTO', '0810', '08'),
('081009', 'YAURISQUE', '0810', '08'),
('081101', 'PAUCARTAMBO', '0811', '08'),
('081102', 'CAICAY', '0811', '08'),
('081103', 'CHALLABAMBA', '0811', '08'),
('081104', 'COLQUEPATA', '0811', '08'),
('081105', 'HUANCARANI', '0811', '08'),
('081106', 'KOSÑIPATA', '0811', '08'),
('081201', 'URCOS', '0812', '08'),
('081202', 'ANDAHUAYLILLAS', '0812', '08'),
('081203', 'CAMANTI', '0812', '08'),
('081204', 'CCARHUAYO', '0812', '08'),
('081205', 'CCATCA', '0812', '08'),
('081206', 'CUSIPATA', '0812', '08'),
('081207', 'HUARO', '0812', '08'),
('081208', 'LUCRE', '0812', '08'),
('081209', 'MARCAPATA', '0812', '08'),
('081210', 'OCONGATE', '0812', '08'),
('081211', 'OROPESA', '0812', '08'),
('081212', 'QUIQUIJANA', '0812', '08'),
('081301', 'URUBAMBA', '0813', '08'),
('081302', 'CHINCHERO', '0813', '08'),
('081303', 'HUAYLLABAMBA', '0813', '08'),
('081304', 'MACHUPICCHU', '0813', '08'),
('081305', 'MARAS', '0813', '08'),
('081306', 'OLLANTAYTAMBO', '0813', '08'),
('081307', 'YUCAY', '0813', '08'),
('090101', 'HUANCAVELICA', '0901', '09'),
('090102', 'ACOBAMBILLA', '0901', '09'),
('090103', 'ACORIA', '0901', '09'),
('090104', 'CONAYCA', '0901', '09'),
('090105', 'CUENCA', '0901', '09'),
('090106', 'HUACHOCOLPA', '0901', '09'),
('090107', 'HUAYLLAHUARA', '0901', '09'),
('090108', 'IZCUCHACA', '0901', '09'),
('090109', 'LARIA', '0901', '09'),
('090110', 'MANTA', '0901', '09'),
('090111', 'MARISCAL CÁCERES', '0901', '09'),
('090112', 'MOYA', '0901', '09'),
('090113', 'NUEVO OCCORO', '0901', '09'),
('090114', 'PALCA', '0901', '09'),
('090115', 'PILCHACA', '0901', '09'),
('090116', 'VILCA', '0901', '09'),
('090117', 'YAULI', '0901', '09'),
('090118', 'ASCENSIÓN', '0901', '09'),
('090119', 'HUANDO', '0901', '09'),
('090201', 'ACOBAMBA', '0902', '09'),
('090202', 'ANDABAMBA', '0902', '09'),
('090203', 'ANTA', '0902', '09'),
('090204', 'CAJA', '0902', '09'),
('090205', 'MARCAS', '0902', '09'),
('090206', 'PAUCARA', '0902', '09'),
('090207', 'POMACOCHA', '0902', '09'),
('090208', 'ROSARIO', '0902', '09'),
('090301', 'LIRCAY', '0903', '09'),
('090302', 'ANCHONGA', '0903', '09'),
('090303', 'CALLANMARCA', '0903', '09'),
('090304', 'CCOCHACCASA', '0903', '09'),
('090305', 'CHINCHO', '0903', '09'),
('090306', 'CONGALLA', '0903', '09'),
('090307', 'HUANCA-HUANCA', '0903', '09'),
('090308', 'HUAYLLAY GRANDE', '0903', '09'),
('090309', 'JULCAMARCA', '0903', '09'),
('090310', 'SAN ANTONIO DE ANTAPARCO', '0903', '09'),
('090311', 'SANTO TOMAS DE PATA', '0903', '09'),
('090312', 'SECCLLA', '0903', '09'),
('090401', 'CASTROVIRREYNA', '0904', '09'),
('090402', 'ARMA', '0904', '09'),
('090403', 'AURAHUA', '0904', '09'),
('090404', 'CAPILLAS', '0904', '09'),
('090405', 'CHUPAMARCA', '0904', '09'),
('090406', 'COCAS', '0904', '09'),
('090407', 'HUACHOS', '0904', '09'),
('090408', 'HUAMATAMBO', '0904', '09'),
('090409', 'MOLLEPAMPA', '0904', '09'),
('090410', 'SAN JUAN', '0904', '09'),
('090411', 'SANTA ANA', '0904', '09'),
('090412', 'TANTARA', '0904', '09'),
('090413', 'TICRAPO', '0904', '09'),
('090501', 'CHURCAMPA', '0905', '09'),
('090502', 'ANCO', '0905', '09'),
('090503', 'CHINCHIHUASI', '0905', '09'),
('090504', 'EL CARMEN', '0905', '09'),
('090505', 'LA MERCED', '0905', '09'),
('090506', 'LOCROJA', '0905', '09'),
('090507', 'PAUCARBAMBA', '0905', '09'),
('090508', 'SAN MIGUEL DE MAYOCC', '0905', '09'),
('090509', 'SAN PEDRO DE CORIS', '0905', '09'),
('090510', 'PACHAMARCA', '0905', '09'),
('090511', 'COSME', '0905', '09'),
('090601', 'HUAYTARA', '0906', '09'),
('090602', 'AYAVI', '0906', '09'),
('090603', 'CÓRDOVA', '0906', '09'),
('090604', 'HUAYACUNDO ARMA', '0906', '09'),
('090605', 'LARAMARCA', '0906', '09'),
('090606', 'OCOYO', '0906', '09'),
('090607', 'PILPICHACA', '0906', '09'),
('090608', 'QUERCO', '0906', '09'),
('090609', 'QUITO-ARMA', '0906', '09'),
('090610', 'SAN ANTONIO DE CUSICANCHA', '0906', '09'),
('090611', 'SAN FRANCISCO DE SANGAYAICO', '0906', '09'),
('090612', 'SAN ISIDRO', '0906', '09'),
('090613', 'SANTIAGO DE CHOCORVOS', '0906', '09'),
('090614', 'SANTIAGO DE QUIRAHUARA', '0906', '09'),
('090615', 'SANTO DOMINGO DE CAPILLAS', '0906', '09'),
('090616', 'TAMBO', '0906', '09'),
('090701', 'PAMPAS', '0907', '09'),
('090702', 'ACOSTAMBO', '0907', '09'),
('090703', 'ACRAQUIA', '0907', '09'),
('090704', 'AHUAYCHA', '0907', '09'),
('090705', 'COLCABAMBA', '0907', '09'),
('090706', 'DANIEL HERNÁNDEZ', '0907', '09'),
('090707', 'HUACHOCOLPA', '0907', '09'),
('090709', 'HUARIBAMBA', '0907', '09'),
('090710', 'ÑAHUIMPUQUIO', '0907', '09'),
('090711', 'PAZOS', '0907', '09'),
('090713', 'QUISHUAR', '0907', '09'),
('090714', 'SALCABAMBA', '0907', '09'),
('090715', 'SALCAHUASI', '0907', '09'),
('090716', 'SAN MARCOS DE ROCCHAC', '0907', '09'),
('090717', 'SURCUBAMBA', '0907', '09'),
('090718', 'TINTAY PUNCU', '0907', '09'),
('090719', 'QUICHUAS', '0907', '09'),
('090720', 'ANDAYMARCA', '0907', '09'),
('090721', 'ROBLE', '0907', '09'),
('090722', 'PICHOS', '0907', '09'),
('090723', 'SANTIAGO DE TUCUMA', '0907', '09'),
('100101', 'HUANUCO', '1001', '10'),
('100102', 'AMARILIS', '1001', '10'),
('100103', 'CHINCHAO', '1001', '10'),
('100104', 'CHURUBAMBA', '1001', '10'),
('100105', 'MARGOS', '1001', '10'),
('100106', 'QUISQUI (KICHKI)', '1001', '10'),
('100107', 'SAN FRANCISCO DE CAYRAN', '1001', '10'),
('100108', 'SAN PEDRO DE CHAULAN', '1001', '10'),
('100109', 'SANTA MARÍA DEL VALLE', '1001', '10'),
('100110', 'YARUMAYO', '1001', '10'),
('100111', 'PILLCO MARCA', '1001', '10'),
('100112', 'YACUS', '1001', '10'),
('100113', 'SAN PABLO DE PILLAO', '1001', '10'),
('100201', 'AMBO', '1002', '10'),
('100202', 'CAYNA', '1002', '10'),
('100203', 'COLPAS', '1002', '10'),
('100204', 'CONCHAMARCA', '1002', '10'),
('100205', 'HUACAR', '1002', '10'),
('100206', 'SAN FRANCISCO', '1002', '10'),
('100207', 'SAN RAFAEL', '1002', '10'),
('100208', 'TOMAY KICHWA', '1002', '10'),
('100301', 'LA UNIÓN', '1003', '10'),
('100307', 'CHUQUIS', '1003', '10'),
('100311', 'MARÍAS', '1003', '10'),
('100313', 'PACHAS', '1003', '10'),
('100316', 'QUIVILLA', '1003', '10'),
('100317', 'RIPAN', '1003', '10'),
('100321', 'SHUNQUI', '1003', '10'),
('100322', 'SILLAPATA', '1003', '10'),
('100323', 'YANAS', '1003', '10'),
('100401', 'HUACAYBAMBA', '1004', '10'),
('100402', 'CANCHABAMBA', '1004', '10'),
('100403', 'COCHABAMBA', '1004', '10'),
('100404', 'PINRA', '1004', '10'),
('100501', 'LLATA', '1005', '10'),
('100502', 'ARANCAY', '1005', '10'),
('100503', 'CHAVÍN DE PARIARCA', '1005', '10'),
('100504', 'JACAS GRANDE', '1005', '10'),
('100505', 'JIRCAN', '1005', '10'),
('100506', 'MIRAFLORES', '1005', '10'),
('100507', 'MONZÓN', '1005', '10'),
('100508', 'PUNCHAO', '1005', '10'),
('100509', 'PUÑOS', '1005', '10'),
('100510', 'SINGA', '1005', '10'),
('100511', 'TANTAMAYO', '1005', '10'),
('100601', 'RUPA-RUPA', '1006', '10'),
('100602', 'DANIEL ALOMÍA ROBLES', '1006', '10'),
('100603', 'HERMÍLIO VALDIZAN', '1006', '10'),
('100604', 'JOSÉ CRESPO Y CASTILLO', '1006', '10'),
('100605', 'LUYANDO', '1006', '10'),
('100606', 'MARIANO DAMASO BERAUN', '1006', '10'),
('100607', 'PUCAYACU', '1006', '10'),
('100608', 'CASTILLO GRANDE', '1006', '10'),
('100609', 'PUEBLO NUEVO', '1006', '10'),
('100610', 'SANTO DOMINGO DE ANDA', '1006', '10'),
('100701', 'HUACRACHUCO', '1007', '10'),
('100702', 'CHOLON', '1007', '10'),
('100703', 'SAN BUENAVENTURA', '1007', '10'),
('100704', 'LA MORADA', '1007', '10'),
('100705', 'SANTA ROSA DE ALTO YANAJANCA', '1007', '10'),
('100801', 'PANAO', '1008', '10'),
('100802', 'CHAGLLA', '1008', '10'),
('100803', 'MOLINO', '1008', '10'),
('100804', 'UMARI', '1008', '10'),
('100901', 'PUERTO INCA', '1009', '10'),
('100902', 'CODO DEL POZUZO', '1009', '10'),
('100903', 'HONORIA', '1009', '10'),
('100904', 'TOURNAVISTA', '1009', '10'),
('100905', 'YUYAPICHIS', '1009', '10'),
('101001', 'JESÚS', '1010', '10'),
('101002', 'BAÑOS', '1010', '10'),
('101003', 'JIVIA', '1010', '10'),
('101004', 'QUEROPALCA', '1010', '10'),
('101005', 'RONDOS', '1010', '10'),
('101006', 'SAN FRANCISCO DE ASÍS', '1010', '10'),
('101007', 'SAN MIGUEL DE CAURI', '1010', '10'),
('101101', 'CHAVINILLO', '1011', '10'),
('101102', 'CAHUAC', '1011', '10'),
('101103', 'CHACABAMBA', '1011', '10'),
('101104', 'APARICIO POMARES', '1011', '10'),
('101105', 'JACAS CHICO', '1011', '10'),
('101106', 'OBAS', '1011', '10'),
('101107', 'PAMPAMARCA', '1011', '10'),
('101108', 'CHORAS', '1011', '10'),
('110101', 'ICA', '1101', '11'),
('110102', 'LA TINGUIÑA', '1101', '11'),
('110103', 'LOS AQUIJES', '1101', '11'),
('110104', 'OCUCAJE', '1101', '11'),
('110105', 'PACHACUTEC', '1101', '11'),
('110106', 'PARCONA', '1101', '11'),
('110107', 'PUEBLO NUEVO', '1101', '11'),
('110108', 'SALAS', '1101', '11'),
('110109', 'SAN JOSÉ DE LOS MOLINOS', '1101', '11'),
('110110', 'SAN JUAN BAUTISTA', '1101', '11'),
('110111', 'SANTIAGO', '1101', '11'),
('110112', 'SUBTANJALLA', '1101', '11'),
('110113', 'TATE', '1101', '11'),
('110114', 'YAUCA DEL ROSARIO', '1101', '11'),
('110201', 'CHINCHA ALTA', '1102', '11'),
('110202', 'ALTO LARAN', '1102', '11'),
('110203', 'CHAVIN', '1102', '11'),
('110204', 'CHINCHA BAJA', '1102', '11'),
('110205', 'EL CARMEN', '1102', '11'),
('110206', 'GROCIO PRADO', '1102', '11'),
('110207', 'PUEBLO NUEVO', '1102', '11'),
('110208', 'SAN JUAN DE YANAC', '1102', '11'),
('110209', 'SAN PEDRO DE HUACARPANA', '1102', '11'),
('110210', 'SUNAMPE', '1102', '11'),
('110211', 'TAMBO DE MORA', '1102', '11'),
('110301', 'NASCA', '1103', '11'),
('110302', 'CHANGUILLO', '1103', '11'),
('110303', 'EL INGENIO', '1103', '11'),
('110304', 'MARCONA', '1103', '11'),
('110305', 'VISTA ALEGRE', '1103', '11'),
('110401', 'PALPA', '1104', '11'),
('110402', 'LLIPATA', '1104', '11'),
('110403', 'RÍO GRANDE', '1104', '11'),
('110404', 'SANTA CRUZ', '1104', '11'),
('110405', 'TIBILLO', '1104', '11'),
('110501', 'PISCO', '1105', '11'),
('110502', 'HUANCANO', '1105', '11'),
('110503', 'HUMAY', '1105', '11'),
('110504', 'INDEPENDENCIA', '1105', '11'),
('110505', 'PARACAS', '1105', '11'),
('110506', 'SAN ANDRÉS', '1105', '11'),
('110507', 'SAN CLEMENTE', '1105', '11'),
('110508', 'TUPAC AMARU INCA', '1105', '11'),
('120101', 'HUANCAYO', '1201', '12'),
('120104', 'CARHUACALLANGA', '1201', '12'),
('120105', 'CHACAPAMPA', '1201', '12'),
('120106', 'CHICCHE', '1201', '12'),
('120107', 'CHILCA', '1201', '12'),
('120108', 'CHONGOS ALTO', '1201', '12'),
('120111', 'CHUPURO', '1201', '12'),
('120112', 'COLCA', '1201', '12'),
('120113', 'CULLHUAS', '1201', '12'),
('120114', 'EL TAMBO', '1201', '12'),
('120116', 'HUACRAPUQUIO', '1201', '12'),
('120117', 'HUALHUAS', '1201', '12'),
('120119', 'HUANCAN', '1201', '12'),
('120120', 'HUASICANCHA', '1201', '12'),
('120121', 'HUAYUCACHI', '1201', '12'),
('120122', 'INGENIO', '1201', '12'),
('120124', 'PARIAHUANCA', '1201', '12'),
('120125', 'PILCOMAYO', '1201', '12'),
('120126', 'PUCARA', '1201', '12'),
('120127', 'QUICHUAY', '1201', '12'),
('120128', 'QUILCAS', '1201', '12'),
('120129', 'SAN AGUSTÍN', '1201', '12'),
('120130', 'SAN JERÓNIMO DE TUNAN', '1201', '12'),
('120132', 'SAÑO', '1201', '12'),
('120133', 'SAPALLANGA', '1201', '12'),
('120134', 'SICAYA', '1201', '12'),
('120135', 'SANTO DOMINGO DE ACOBAMBA', '1201', '12'),
('120136', 'VIQUES', '1201', '12'),
('120201', 'CONCEPCIÓN', '1202', '12'),
('120202', 'ACO', '1202', '12'),
('120203', 'ANDAMARCA', '1202', '12'),
('120204', 'CHAMBARA', '1202', '12'),
('120205', 'COCHAS', '1202', '12'),
('120206', 'COMAS', '1202', '12'),
('120207', 'HEROÍNAS TOLEDO', '1202', '12'),
('120208', 'MANZANARES', '1202', '12'),
('120209', 'MARISCAL CASTILLA', '1202', '12'),
('120210', 'MATAHUASI', '1202', '12'),
('120211', 'MITO', '1202', '12'),
('120212', 'NUEVE DE JULIO', '1202', '12'),
('120213', 'ORCOTUNA', '1202', '12'),
('120214', 'SAN JOSÉ DE QUERO', '1202', '12'),
('120215', 'SANTA ROSA DE OCOPA', '1202', '12'),
('120301', 'CHANCHAMAYO', '1203', '12'),
('120302', 'PERENE', '1203', '12'),
('120303', 'PICHANAQUI', '1203', '12'),
('120304', 'SAN LUIS DE SHUARO', '1203', '12'),
('120305', 'SAN RAMÓN', '1203', '12'),
('120306', 'VITOC', '1203', '12'),
('120401', 'JAUJA', '1204', '12'),
('120402', 'ACOLLA', '1204', '12'),
('120403', 'APATA', '1204', '12'),
('120404', 'ATAURA', '1204', '12'),
('120405', 'CANCHAYLLO', '1204', '12'),
('120406', 'CURICACA', '1204', '12'),
('120407', 'EL MANTARO', '1204', '12'),
('120408', 'HUAMALI', '1204', '12'),
('120409', 'HUARIPAMPA', '1204', '12'),
('120410', 'HUERTAS', '1204', '12'),
('120411', 'JANJAILLO', '1204', '12'),
('120412', 'JULCÁN', '1204', '12'),
('120413', 'LEONOR ORDÓÑEZ', '1204', '12'),
('120414', 'LLOCLLAPAMPA', '1204', '12'),
('120415', 'MARCO', '1204', '12'),
('120416', 'MASMA', '1204', '12'),
('120417', 'MASMA CHICCHE', '1204', '12'),
('120418', 'MOLINOS', '1204', '12'),
('120419', 'MONOBAMBA', '1204', '12'),
('120420', 'MUQUI', '1204', '12'),
('120421', 'MUQUIYAUYO', '1204', '12'),
('120422', 'PACA', '1204', '12'),
('120423', 'PACCHA', '1204', '12'),
('120424', 'PANCAN', '1204', '12'),
('120425', 'PARCO', '1204', '12'),
('120426', 'POMACANCHA', '1204', '12'),
('120427', 'RICRAN', '1204', '12'),
('120428', 'SAN LORENZO', '1204', '12'),
('120429', 'SAN PEDRO DE CHUNAN', '1204', '12'),
('120430', 'SAUSA', '1204', '12'),
('120431', 'SINCOS', '1204', '12'),
('120432', 'TUNAN MARCA', '1204', '12'),
('120433', 'YAULI', '1204', '12'),
('120434', 'YAUYOS', '1204', '12'),
('120501', 'JUNIN', '1205', '12'),
('120502', 'CARHUAMAYO', '1205', '12'),
('120503', 'ONDORES', '1205', '12'),
('120504', 'ULCUMAYO', '1205', '12'),
('120601', 'SATIPO', '1206', '12'),
('120602', 'COVIRIALI', '1206', '12'),
('120603', 'LLAYLLA', '1206', '12'),
('120604', 'MAZAMARI', '1206', '12'),
('120605', 'PAMPA HERMOSA', '1206', '12'),
('120606', 'PANGOA', '1206', '12'),
('120607', 'RÍO NEGRO', '1206', '12'),
('120608', 'RÍO TAMBO', '1206', '12'),
('120609', 'VIZCATAN DEL ENE', '1206', '12'),
('120701', 'TARMA', '1207', '12'),
('120702', 'ACOBAMBA', '1207', '12'),
('120703', 'HUARICOLCA', '1207', '12'),
('120704', 'HUASAHUASI', '1207', '12'),
('120705', 'LA UNIÓN', '1207', '12'),
('120706', 'PALCA', '1207', '12'),
('120707', 'PALCAMAYO', '1207', '12'),
('120708', 'SAN PEDRO DE CAJAS', '1207', '12'),
('120709', 'TAPO', '1207', '12'),
('120801', 'LA OROYA', '1208', '12'),
('120802', 'CHACAPALPA', '1208', '12'),
('120803', 'HUAY-HUAY', '1208', '12'),
('120804', 'MARCAPOMACOCHA', '1208', '12'),
('120805', 'MOROCOCHA', '1208', '12'),
('120806', 'PACCHA', '1208', '12'),
('120807', 'SANTA BÁRBARA DE CARHUACAYAN', '1208', '12'),
('120808', 'SANTA ROSA DE SACCO', '1208', '12'),
('120809', 'SUITUCANCHA', '1208', '12'),
('120810', 'YAULI', '1208', '12'),
('120901', 'CHUPACA', '1209', '12'),
('120902', 'AHUAC', '1209', '12'),
('120903', 'CHONGOS BAJO', '1209', '12'),
('120904', 'HUACHAC', '1209', '12'),
('120905', 'HUAMANCACA CHICO', '1209', '12'),
('120906', 'SAN JUAN DE ISCOS', '1209', '12'),
('120907', 'SAN JUAN DE JARPA', '1209', '12'),
('120908', 'TRES DE DICIEMBRE', '1209', '12'),
('120909', 'YANACANCHA', '1209', '12'),
('130101', 'TRUJILLO', '1301', '13'),
('130102', 'EL PORVENIR', '1301', '13'),
('130103', 'FLORENCIA DE MORA', '1301', '13'),
('130104', 'HUANCHACO', '1301', '13'),
('130105', 'LA ESPERANZA', '1301', '13'),
('130106', 'LAREDO', '1301', '13'),
('130107', 'MOCHE', '1301', '13'),
('130108', 'POROTO', '1301', '13'),
('130109', 'SALAVERRY', '1301', '13'),
('130110', 'SIMBAL', '1301', '13'),
('130111', 'VICTOR LARCO HERRERA', '1301', '13'),
('130201', 'ASCOPE', '1302', '13'),
('130202', 'CHICAMA', '1302', '13'),
('130203', 'CHOCOPE', '1302', '13'),
('130204', 'MAGDALENA DE CAO', '1302', '13'),
('130205', 'PAIJAN', '1302', '13'),
('130206', 'RÁZURI', '1302', '13'),
('130207', 'SANTIAGO DE CAO', '1302', '13'),
('130208', 'CASA GRANDE', '1302', '13'),
('130301', 'BOLÍVAR', '1303', '13'),
('130302', 'BAMBAMARCA', '1303', '13'),
('130303', 'CONDORMARCA', '1303', '13'),
('130304', 'LONGOTEA', '1303', '13'),
('130305', 'UCHUMARCA', '1303', '13'),
('130306', 'UCUNCHA', '1303', '13'),
('130401', 'CHEPEN', '1304', '13'),
('130402', 'PACANGA', '1304', '13'),
('130403', 'PUEBLO NUEVO', '1304', '13'),
('130501', 'JULCAN', '1305', '13'),
('130502', 'CALAMARCA', '1305', '13'),
('130503', 'CARABAMBA', '1305', '13'),
('130504', 'HUASO', '1305', '13'),
('130601', 'OTUZCO', '1306', '13'),
('130602', 'AGALLPAMPA', '1306', '13'),
('130604', 'CHARAT', '1306', '13'),
('130605', 'HUARANCHAL', '1306', '13'),
('130606', 'LA CUESTA', '1306', '13'),
('130608', 'MACHE', '1306', '13'),
('130610', 'PARANDAY', '1306', '13'),
('130611', 'SALPO', '1306', '13'),
('130613', 'SINSICAP', '1306', '13'),
('130614', 'USQUIL', '1306', '13'),
('130701', 'SAN PEDRO DE LLOC', '1307', '13'),
('130702', 'GUADALUPE', '1307', '13'),
('130703', 'JEQUETEPEQUE', '1307', '13'),
('130704', 'PACASMAYO', '1307', '13'),
('130705', 'SAN JOSÉ', '1307', '13'),
('130801', 'TAYABAMBA', '1308', '13'),
('130802', 'BULDIBUYO', '1308', '13'),
('130803', 'CHILLIA', '1308', '13'),
('130804', 'HUANCASPATA', '1308', '13'),
('130805', 'HUAYLILLAS', '1308', '13'),
('130806', 'HUAYO', '1308', '13'),
('130807', 'ONGON', '1308', '13'),
('130808', 'PARCOY', '1308', '13'),
('130809', 'PATAZ', '1308', '13'),
('130810', 'PIAS', '1308', '13'),
('130811', 'SANTIAGO DE CHALLAS', '1308', '13'),
('130812', 'TAURIJA', '1308', '13'),
('130813', 'URPAY', '1308', '13'),
('130901', 'HUAMACHUCO', '1309', '13'),
('130902', 'CHUGAY', '1309', '13'),
('130903', 'COCHORCO', '1309', '13'),
('130904', 'CURGOS', '1309', '13'),
('130905', 'MARCABAL', '1309', '13'),
('130906', 'SANAGORAN', '1309', '13'),
('130907', 'SARIN', '1309', '13'),
('130908', 'SARTIMBAMBA', '1309', '13'),
('131001', 'SANTIAGO DE CHUCO', '1310', '13'),
('131002', 'ANGASMARCA', '1310', '13'),
('131003', 'CACHICADAN', '1310', '13'),
('131004', 'MOLLEBAMBA', '1310', '13'),
('131005', 'MOLLEPATA', '1310', '13'),
('131006', 'QUIRUVILCA', '1310', '13'),
('131007', 'SANTA CRUZ DE CHUCA', '1310', '13'),
('131008', 'SITABAMBA', '1310', '13'),
('131101', 'CASCAS', '1311', '13'),
('131102', 'LUCMA', '1311', '13'),
('131103', 'MARMOT', '1311', '13'),
('131104', 'SAYAPULLO', '1311', '13'),
('131201', 'VIRU', '1312', '13'),
('131202', 'CHAO', '1312', '13'),
('131203', 'GUADALUPITO', '1312', '13'),
('140101', 'CHICLAYO', '1401', '14'),
('140102', 'CHONGOYAPE', '1401', '14'),
('140103', 'ETEN', '1401', '14'),
('140104', 'ETEN PUERTO', '1401', '14'),
('140105', 'JOSÉ LEONARDO ORTIZ', '1401', '14'),
('140106', 'LA VICTORIA', '1401', '14'),
('140107', 'LAGUNAS', '1401', '14'),
('140108', 'MONSEFU', '1401', '14'),
('140109', 'NUEVA ARICA', '1401', '14'),
('140110', 'OYOTUN', '1401', '14'),
('140111', 'PICSI', '1401', '14'),
('140112', 'PIMENTEL', '1401', '14'),
('140113', 'REQUE', '1401', '14'),
('140114', 'SANTA ROSA', '1401', '14'),
('140115', 'SAÑA', '1401', '14'),
('140116', 'CAYALTI', '1401', '14'),
('140117', 'PATAPO', '1401', '14'),
('140118', 'POMALCA', '1401', '14'),
('140119', 'PUCALA', '1401', '14'),
('140120', 'TUMAN', '1401', '14'),
('140201', 'FERREÑAFE', '1402', '14'),
('140202', 'CAÑARIS', '1402', '14'),
('140203', 'INCAHUASI', '1402', '14'),
('140204', 'MANUEL ANTONIO MESONES MURO', '1402', '14'),
('140205', 'PITIPO', '1402', '14'),
('140206', 'PUEBLO NUEVO', '1402', '14'),
('140301', 'LAMBAYEQUE', '1403', '14'),
('140302', 'CHOCHOPE', '1403', '14'),
('140303', 'ILLIMO', '1403', '14'),
('140304', 'JAYANCA', '1403', '14'),
('140305', 'MOCHUMI', '1403', '14'),
('140306', 'MORROPE', '1403', '14'),
('140307', 'MOTUPE', '1403', '14'),
('140308', 'OLMOS', '1403', '14'),
('140309', 'PACORA', '1403', '14'),
('140310', 'SALAS', '1403', '14'),
('140311', 'SAN JOSÉ', '1403', '14'),
('140312', 'TUCUME', '1403', '14'),
('150101', 'LIMA', '1501', '15'),
('150102', 'ANCÓN', '1501', '15'),
('150103', 'ATE', '1501', '15'),
('150104', 'BARRANCO', '1501', '15'),
('150105', 'BREÑA', '1501', '15'),
('150106', 'CARABAYLLO', '1501', '15'),
('150107', 'CHACLACAYO', '1501', '15'),
('150108', 'CHORRILLOS', '1501', '15'),
('150109', 'CIENEGUILLA', '1501', '15'),
('150110', 'COMAS', '1501', '15'),
('150111', 'EL AGUSTINO', '1501', '15'),
('150112', 'INDEPENDENCIA', '1501', '15'),
('150113', 'JESÚS MARÍA', '1501', '15'),
('150114', 'LA MOLINA', '1501', '15'),
('150115', 'LA VICTORIA', '1501', '15'),
('150116', 'LINCE', '1501', '15'),
('150117', 'LOS OLIVOS', '1501', '15'),
('150118', 'LURIGANCHO', '1501', '15'),
('150119', 'LURIN', '1501', '15'),
('150120', 'MAGDALENA DEL MAR', '1501', '15'),
('150121', 'PUEBLO LIBRE', '1501', '15'),
('150122', 'MIRAFLORES', '1501', '15'),
('150123', 'PACHACAMAC', '1501', '15'),
('150124', 'PUCUSANA', '1501', '15'),
('150125', 'PUENTE PIEDRA', '1501', '15'),
('150126', 'PUNTA HERMOSA', '1501', '15'),
('150127', 'PUNTA NEGRA', '1501', '15'),
('150128', 'RÍMAC', '1501', '15'),
('150129', 'SAN BARTOLO', '1501', '15'),
('150130', 'SAN BORJA', '1501', '15'),
('150131', 'SAN ISIDRO', '1501', '15'),
('150132', 'SAN JUAN DE LURIGANCHO', '1501', '15'),
('150133', 'SAN JUAN DE MIRAFLORES', '1501', '15'),
('150134', 'SAN LUIS', '1501', '15'),
('150135', 'SAN MARTÍN DE PORRES', '1501', '15'),
('150136', 'SAN MIGUEL', '1501', '15'),
('150137', 'SANTA ANITA', '1501', '15'),
('150138', 'SANTA MARÍA DEL MAR', '1501', '15'),
('150139', 'SANTA ROSA', '1501', '15'),
('150140', 'SANTIAGO DE SURCO', '1501', '15'),
('150141', 'SURQUILLO', '1501', '15'),
('150142', 'VILLA EL SALVADOR', '1501', '15'),
('150143', 'VILLA MARÍA DEL TRIUNFO', '1501', '15'),
('150201', 'BARRANCA', '1502', '15'),
('150202', 'PARAMONGA', '1502', '15'),
('150203', 'PATIVILCA', '1502', '15'),
('150204', 'SUPE', '1502', '15'),
('150205', 'SUPE PUERTO', '1502', '15'),
('150301', 'CAJATAMBO', '1503', '15'),
('150302', 'COPA', '1503', '15'),
('150303', 'GORGOR', '1503', '15'),
('150304', 'HUANCAPON', '1503', '15'),
('150305', 'MANAS', '1503', '15'),
('150401', 'CANTA', '1504', '15'),
('150402', 'ARAHUAY', '1504', '15'),
('150403', 'HUAMANTANGA', '1504', '15'),
('150404', 'HUAROS', '1504', '15'),
('150405', 'LACHAQUI', '1504', '15'),
('150406', 'SAN BUENAVENTURA', '1504', '15'),
('150407', 'SANTA ROSA DE QUIVES', '1504', '15');
INSERT INTO `ubigeo_distrito` (`id`, `nombre_distrito`, `province_id`, `department_id`) VALUES
('150501', 'SAN VICENTE DE CAÑETE', '1505', '15'),
('150502', 'ASIA', '1505', '15'),
('150503', 'CALANGO', '1505', '15'),
('150504', 'CERRO AZUL', '1505', '15'),
('150505', 'CHILCA', '1505', '15'),
('150506', 'COAYLLO', '1505', '15'),
('150507', 'IMPERIAL', '1505', '15'),
('150508', 'LUNAHUANA', '1505', '15'),
('150509', 'MALA', '1505', '15'),
('150510', 'NUEVO IMPERIAL', '1505', '15'),
('150511', 'PACARAN', '1505', '15'),
('150512', 'QUILMANA', '1505', '15'),
('150513', 'SAN ANTONIO', '1505', '15'),
('150514', 'SAN LUIS', '1505', '15'),
('150515', 'SANTA CRUZ DE FLORES', '1505', '15'),
('150516', 'ZÚÑIGA', '1505', '15'),
('150601', 'HUARAL', '1506', '15'),
('150602', 'ATAVILLOS ALTO', '1506', '15'),
('150603', 'ATAVILLOS BAJO', '1506', '15'),
('150604', 'AUCALLAMA', '1506', '15'),
('150605', 'CHANCAY', '1506', '15'),
('150606', 'IHUARI', '1506', '15'),
('150607', 'LAMPIAN', '1506', '15'),
('150608', 'PACARAOS', '1506', '15'),
('150609', 'SAN MIGUEL DE ACOS', '1506', '15'),
('150610', 'SANTA CRUZ DE ANDAMARCA', '1506', '15'),
('150611', 'SUMBILCA', '1506', '15'),
('150612', 'VEINTISIETE DE NOVIEMBRE', '1506', '15'),
('150701', 'MATUCANA', '1507', '15'),
('150702', 'ANTIOQUIA', '1507', '15'),
('150703', 'CALLAHUANCA', '1507', '15'),
('150704', 'CARAMPOMA', '1507', '15'),
('150705', 'CHICLA', '1507', '15'),
('150706', 'CUENCA', '1507', '15'),
('150707', 'HUACHUPAMPA', '1507', '15'),
('150708', 'HUANZA', '1507', '15'),
('150709', 'HUAROCHIRI', '1507', '15'),
('150710', 'LAHUAYTAMBO', '1507', '15'),
('150711', 'LANGA', '1507', '15'),
('150712', 'LARAOS', '1507', '15'),
('150713', 'MARIATANA', '1507', '15'),
('150714', 'RICARDO PALMA', '1507', '15'),
('150715', 'SAN ANDRÉS DE TUPICOCHA', '1507', '15'),
('150716', 'SAN ANTONIO', '1507', '15'),
('150717', 'SAN BARTOLOMÉ', '1507', '15'),
('150718', 'SAN DAMIAN', '1507', '15'),
('150719', 'SAN JUAN DE IRIS', '1507', '15'),
('150720', 'SAN JUAN DE TANTARANCHE', '1507', '15'),
('150721', 'SAN LORENZO DE QUINTI', '1507', '15'),
('150722', 'SAN MATEO', '1507', '15'),
('150723', 'SAN MATEO DE OTAO', '1507', '15'),
('150724', 'SAN PEDRO DE CASTA', '1507', '15'),
('150725', 'SAN PEDRO DE HUANCAYRE', '1507', '15'),
('150726', 'SANGALLAYA', '1507', '15'),
('150727', 'SANTA CRUZ DE COCACHACRA', '1507', '15'),
('150728', 'SANTA EULALIA', '1507', '15'),
('150729', 'SANTIAGO DE ANCHUCAYA', '1507', '15'),
('150730', 'SANTIAGO DE TUNA', '1507', '15'),
('150731', 'SANTO DOMINGO DE LOS OLLEROS', '1507', '15'),
('150732', 'SURCO', '1507', '15'),
('150801', 'HUACHO', '1508', '15'),
('150802', 'AMBAR', '1508', '15'),
('150803', 'CALETA DE CARQUIN', '1508', '15'),
('150804', 'CHECRAS', '1508', '15'),
('150805', 'HUALMAY', '1508', '15'),
('150806', 'HUAURA', '1508', '15'),
('150807', 'LEONCIO PRADO', '1508', '15'),
('150808', 'PACCHO', '1508', '15'),
('150809', 'SANTA LEONOR', '1508', '15'),
('150810', 'SANTA MARÍA', '1508', '15'),
('150811', 'SAYAN', '1508', '15'),
('150812', 'VEGUETA', '1508', '15'),
('150901', 'OYON', '1509', '15'),
('150902', 'ANDAJES', '1509', '15'),
('150903', 'CAUJUL', '1509', '15'),
('150904', 'COCHAMARCA', '1509', '15'),
('150905', 'NAVAN', '1509', '15'),
('150906', 'PACHANGARA', '1509', '15'),
('151001', 'YAUYOS', '1510', '15'),
('151002', 'ALIS', '1510', '15'),
('151003', 'ALLAUCA', '1510', '15'),
('151004', 'AYAVIRI', '1510', '15'),
('151005', 'AZÁNGARO', '1510', '15'),
('151006', 'CACRA', '1510', '15'),
('151007', 'CARANIA', '1510', '15'),
('151008', 'CATAHUASI', '1510', '15'),
('151009', 'CHOCOS', '1510', '15'),
('151010', 'COCHAS', '1510', '15'),
('151011', 'COLONIA', '1510', '15'),
('151012', 'HONGOS', '1510', '15'),
('151013', 'HUAMPARA', '1510', '15'),
('151014', 'HUANCAYA', '1510', '15'),
('151015', 'HUANGASCAR', '1510', '15'),
('151016', 'HUANTAN', '1510', '15'),
('151017', 'HUAÑEC', '1510', '15'),
('151018', 'LARAOS', '1510', '15'),
('151019', 'LINCHA', '1510', '15'),
('151020', 'MADEAN', '1510', '15'),
('151021', 'MIRAFLORES', '1510', '15'),
('151022', 'OMAS', '1510', '15'),
('151023', 'PUTINZA', '1510', '15'),
('151024', 'QUINCHES', '1510', '15'),
('151025', 'QUINOCAY', '1510', '15'),
('151026', 'SAN JOAQUÍN', '1510', '15'),
('151027', 'SAN PEDRO DE PILAS', '1510', '15'),
('151028', 'TANTA', '1510', '15'),
('151029', 'TAURIPAMPA', '1510', '15'),
('151030', 'TOMAS', '1510', '15'),
('151031', 'TUPE', '1510', '15'),
('151032', 'VIÑAC', '1510', '15'),
('151033', 'VITIS', '1510', '15'),
('160101', 'IQUITOS', '1601', '16'),
('160102', 'ALTO NANAY', '1601', '16'),
('160103', 'FERNANDO LORES', '1601', '16'),
('160104', 'INDIANA', '1601', '16'),
('160105', 'LAS AMAZONAS', '1601', '16'),
('160106', 'MAZAN', '1601', '16'),
('160107', 'NAPO', '1601', '16'),
('160108', 'PUNCHANA', '1601', '16'),
('160110', 'TORRES CAUSANA', '1601', '16'),
('160112', 'BELÉN', '1601', '16'),
('160113', 'SAN JUAN BAUTISTA', '1601', '16'),
('160201', 'YURIMAGUAS', '1602', '16'),
('160202', 'BALSAPUERTO', '1602', '16'),
('160205', 'JEBEROS', '1602', '16'),
('160206', 'LAGUNAS', '1602', '16'),
('160210', 'SANTA CRUZ', '1602', '16'),
('160211', 'TENIENTE CESAR LÓPEZ ROJAS', '1602', '16'),
('160301', 'NAUTA', '1603', '16'),
('160302', 'PARINARI', '1603', '16'),
('160303', 'TIGRE', '1603', '16'),
('160304', 'TROMPETEROS', '1603', '16'),
('160305', 'URARINAS', '1603', '16'),
('160401', 'RAMÓN CASTILLA', '1604', '16'),
('160402', 'PEBAS', '1604', '16'),
('160403', 'YAVARI', '1604', '16'),
('160404', 'SAN PABLO', '1604', '16'),
('160501', 'REQUENA', '1605', '16'),
('160502', 'ALTO TAPICHE', '1605', '16'),
('160503', 'CAPELO', '1605', '16'),
('160504', 'EMILIO SAN MARTÍN', '1605', '16'),
('160505', 'MAQUIA', '1605', '16'),
('160506', 'PUINAHUA', '1605', '16'),
('160507', 'SAQUENA', '1605', '16'),
('160508', 'SOPLIN', '1605', '16'),
('160509', 'TAPICHE', '1605', '16'),
('160510', 'JENARO HERRERA', '1605', '16'),
('160511', 'YAQUERANA', '1605', '16'),
('160601', 'CONTAMANA', '1606', '16'),
('160602', 'INAHUAYA', '1606', '16'),
('160603', 'PADRE MÁRQUEZ', '1606', '16'),
('160604', 'PAMPA HERMOSA', '1606', '16'),
('160605', 'SARAYACU', '1606', '16'),
('160606', 'VARGAS GUERRA', '1606', '16'),
('160701', 'BARRANCA', '1607', '16'),
('160702', 'CAHUAPANAS', '1607', '16'),
('160703', 'MANSERICHE', '1607', '16'),
('160704', 'MORONA', '1607', '16'),
('160705', 'PASTAZA', '1607', '16'),
('160706', 'ANDOAS', '1607', '16'),
('160801', 'PUTUMAYO', '1608', '16'),
('160802', 'ROSA PANDURO', '1608', '16'),
('160803', 'TENIENTE MANUEL CLAVERO', '1608', '16'),
('160804', 'YAGUAS', '1608', '16'),
('170101', 'TAMBOPATA', '1701', '17'),
('170102', 'INAMBARI', '1701', '17'),
('170103', 'LAS PIEDRAS', '1701', '17'),
('170104', 'LABERINTO', '1701', '17'),
('170201', 'MANU', '1702', '17'),
('170202', 'FITZCARRALD', '1702', '17'),
('170203', 'MADRE DE DIOS', '1702', '17'),
('170204', 'HUEPETUHE', '1702', '17'),
('170301', 'IÑAPARI', '1703', '17'),
('170302', 'IBERIA', '1703', '17'),
('170303', 'TAHUAMANU', '1703', '17'),
('180101', 'MOQUEGUA', '1801', '18'),
('180102', 'CARUMAS', '1801', '18'),
('180103', 'CUCHUMBAYA', '1801', '18'),
('180104', 'SAMEGUA', '1801', '18'),
('180105', 'SAN CRISTÓBAL', '1801', '18'),
('180106', 'TORATA', '1801', '18'),
('180201', 'OMATE', '1802', '18'),
('180202', 'CHOJATA', '1802', '18'),
('180203', 'COALAQUE', '1802', '18'),
('180204', 'ICHUÑA', '1802', '18'),
('180205', 'LA CAPILLA', '1802', '18'),
('180206', 'LLOQUE', '1802', '18'),
('180207', 'MATALAQUE', '1802', '18'),
('180208', 'PUQUINA', '1802', '18'),
('180209', 'QUINISTAQUILLAS', '1802', '18'),
('180210', 'UBINAS', '1802', '18'),
('180211', 'YUNGA', '1802', '18'),
('180301', 'ILO', '1803', '18'),
('180302', 'EL ALGARROBAL', '1803', '18'),
('180303', 'PACOCHA', '1803', '18'),
('190101', 'CHAUPIMARCA', '1901', '19'),
('190102', 'HUACHON', '1901', '19'),
('190103', 'HUARIACA', '1901', '19'),
('190104', 'HUAYLLAY', '1901', '19'),
('190105', 'NINACACA', '1901', '19'),
('190106', 'PALLANCHACRA', '1901', '19'),
('190107', 'PAUCARTAMBO', '1901', '19'),
('190108', 'SAN FRANCISCO DE ASÍS DE YARUSYACAN', '1901', '19'),
('190109', 'SIMON BOLÍVAR', '1901', '19'),
('190110', 'TICLACAYAN', '1901', '19'),
('190111', 'TINYAHUARCO', '1901', '19'),
('190112', 'VICCO', '1901', '19'),
('190113', 'YANACANCHA', '1901', '19'),
('190201', 'YANAHUANCA', '1902', '19'),
('190202', 'CHACAYAN', '1902', '19'),
('190203', 'GOYLLARISQUIZGA', '1902', '19'),
('190204', 'PAUCAR', '1902', '19'),
('190205', 'SAN PEDRO DE PILLAO', '1902', '19'),
('190206', 'SANTA ANA DE TUSI', '1902', '19'),
('190207', 'TAPUC', '1902', '19'),
('190208', 'VILCABAMBA', '1902', '19'),
('190301', 'OXAPAMPA', '1903', '19'),
('190302', 'CHONTABAMBA', '1903', '19'),
('190303', 'HUANCABAMBA', '1903', '19'),
('190304', 'PALCAZU', '1903', '19'),
('190305', 'POZUZO', '1903', '19'),
('190306', 'PUERTO BERMÚDEZ', '1903', '19'),
('190307', 'VILLA RICA', '1903', '19'),
('190308', 'CONSTITUCIÓN', '1903', '19'),
('200101', 'PIURA', '2001', '20'),
('200104', 'CASTILLA', '2001', '20'),
('200105', 'CATACAOS', '2001', '20'),
('200107', 'CURA MORI', '2001', '20'),
('200108', 'EL TALLAN', '2001', '20'),
('200109', 'LA ARENA', '2001', '20'),
('200110', 'LA UNIÓN', '2001', '20'),
('200111', 'LAS LOMAS', '2001', '20'),
('200114', 'TAMBO GRANDE', '2001', '20'),
('200115', 'VEINTISEIS DE OCTUBRE', '2001', '20'),
('200201', 'AYABACA', '2002', '20'),
('200202', 'FRIAS', '2002', '20'),
('200203', 'JILILI', '2002', '20'),
('200204', 'LAGUNAS', '2002', '20'),
('200205', 'MONTERO', '2002', '20'),
('200206', 'PACAIPAMPA', '2002', '20'),
('200207', 'PAIMAS', '2002', '20'),
('200208', 'SAPILLICA', '2002', '20'),
('200209', 'SICCHEZ', '2002', '20'),
('200210', 'SUYO', '2002', '20'),
('200301', 'HUANCABAMBA', '2003', '20'),
('200302', 'CANCHAQUE', '2003', '20'),
('200303', 'EL CARMEN DE LA FRONTERA', '2003', '20'),
('200304', 'HUARMACA', '2003', '20'),
('200305', 'LALAQUIZ', '2003', '20'),
('200306', 'SAN MIGUEL DE EL FAIQUE', '2003', '20'),
('200307', 'SONDOR', '2003', '20'),
('200308', 'SONDORILLO', '2003', '20'),
('200401', 'CHULUCANAS', '2004', '20'),
('200402', 'BUENOS AIRES', '2004', '20'),
('200403', 'CHALACO', '2004', '20'),
('200404', 'LA MATANZA', '2004', '20'),
('200405', 'MORROPON', '2004', '20'),
('200406', 'SALITRAL', '2004', '20'),
('200407', 'SAN JUAN DE BIGOTE', '2004', '20'),
('200408', 'SANTA CATALINA DE MOSSA', '2004', '20'),
('200409', 'SANTO DOMINGO', '2004', '20'),
('200410', 'YAMANGO', '2004', '20'),
('200501', 'PAITA', '2005', '20'),
('200502', 'AMOTAPE', '2005', '20'),
('200503', 'ARENAL', '2005', '20'),
('200504', 'COLAN', '2005', '20'),
('200505', 'LA HUACA', '2005', '20'),
('200506', 'TAMARINDO', '2005', '20'),
('200507', 'VICHAYAL', '2005', '20'),
('200601', 'SULLANA', '2006', '20'),
('200602', 'BELLAVISTA', '2006', '20'),
('200603', 'IGNACIO ESCUDERO', '2006', '20'),
('200604', 'LANCONES', '2006', '20'),
('200605', 'MARCAVELICA', '2006', '20'),
('200606', 'MIGUEL CHECA', '2006', '20'),
('200607', 'QUERECOTILLO', '2006', '20'),
('200608', 'SALITRAL', '2006', '20'),
('200701', 'PARIÑAS', '2007', '20'),
('200702', 'EL ALTO', '2007', '20'),
('200703', 'LA BREA', '2007', '20'),
('200704', 'LOBITOS', '2007', '20'),
('200705', 'LOS ORGANOS', '2007', '20'),
('200706', 'MANCORA', '2007', '20'),
('200801', 'SECHURA', '2008', '20'),
('200802', 'BELLAVISTA DE LA UNIÓN', '2008', '20'),
('200803', 'BERNAL', '2008', '20'),
('200804', 'CRISTO NOS VALGA', '2008', '20'),
('200805', 'VICE', '2008', '20'),
('200806', 'RINCONADA LLICUAR', '2008', '20'),
('210101', 'PUNO', '2101', '21'),
('210102', 'ACORA', '2101', '21'),
('210103', 'AMANTANI', '2101', '21'),
('210104', 'ATUNCOLLA', '2101', '21'),
('210105', 'CAPACHICA', '2101', '21'),
('210106', 'CHUCUITO', '2101', '21'),
('210107', 'COATA', '2101', '21'),
('210108', 'HUATA', '2101', '21'),
('210109', 'MAÑAZO', '2101', '21'),
('210110', 'PAUCARCOLLA', '2101', '21'),
('210111', 'PICHACANI', '2101', '21'),
('210112', 'PLATERIA', '2101', '21'),
('210113', 'SAN ANTONIO', '2101', '21'),
('210114', 'TIQUILLACA', '2101', '21'),
('210115', 'VILQUE', '2101', '21'),
('210201', 'AZÁNGARO', '2102', '21'),
('210202', 'ACHAYA', '2102', '21'),
('210203', 'ARAPA', '2102', '21'),
('210204', 'ASILLO', '2102', '21'),
('210205', 'CAMINACA', '2102', '21'),
('210206', 'CHUPA', '2102', '21'),
('210207', 'JOSÉ DOMINGO CHOQUEHUANCA', '2102', '21'),
('210208', 'MUÑANI', '2102', '21'),
('210209', 'POTONI', '2102', '21'),
('210210', 'SAMAN', '2102', '21'),
('210211', 'SAN ANTON', '2102', '21'),
('210212', 'SAN JOSÉ', '2102', '21'),
('210213', 'SAN JUAN DE SALINAS', '2102', '21'),
('210214', 'SANTIAGO DE PUPUJA', '2102', '21'),
('210215', 'TIRAPATA', '2102', '21'),
('210301', 'MACUSANI', '2103', '21'),
('210302', 'AJOYANI', '2103', '21'),
('210303', 'AYAPATA', '2103', '21'),
('210304', 'COASA', '2103', '21'),
('210305', 'CORANI', '2103', '21'),
('210306', 'CRUCERO', '2103', '21'),
('210307', 'ITUATA', '2103', '21'),
('210308', 'OLLACHEA', '2103', '21'),
('210309', 'SAN GABAN', '2103', '21'),
('210310', 'USICAYOS', '2103', '21'),
('210401', 'JULI', '2104', '21'),
('210402', 'DESAGUADERO', '2104', '21'),
('210403', 'HUACULLANI', '2104', '21'),
('210404', 'KELLUYO', '2104', '21'),
('210405', 'PISACOMA', '2104', '21'),
('210406', 'POMATA', '2104', '21'),
('210407', 'ZEPITA', '2104', '21'),
('210501', 'ILAVE', '2105', '21'),
('210502', 'CAPAZO', '2105', '21'),
('210503', 'PILCUYO', '2105', '21'),
('210504', 'SANTA ROSA', '2105', '21'),
('210505', 'CONDURIRI', '2105', '21'),
('210601', 'HUANCANE', '2106', '21'),
('210602', 'COJATA', '2106', '21'),
('210603', 'HUATASANI', '2106', '21'),
('210604', 'INCHUPALLA', '2106', '21'),
('210605', 'PUSI', '2106', '21'),
('210606', 'ROSASPATA', '2106', '21'),
('210607', 'TARACO', '2106', '21'),
('210608', 'VILQUE CHICO', '2106', '21'),
('210701', 'LAMPA', '2107', '21'),
('210702', 'CABANILLA', '2107', '21'),
('210703', 'CALAPUJA', '2107', '21'),
('210704', 'NICASIO', '2107', '21'),
('210705', 'OCUVIRI', '2107', '21'),
('210706', 'PALCA', '2107', '21'),
('210707', 'PARATIA', '2107', '21'),
('210708', 'PUCARA', '2107', '21'),
('210709', 'SANTA LUCIA', '2107', '21'),
('210710', 'VILAVILA', '2107', '21'),
('210801', 'AYAVIRI', '2108', '21'),
('210802', 'ANTAUTA', '2108', '21'),
('210803', 'CUPI', '2108', '21'),
('210804', 'LLALLI', '2108', '21'),
('210805', 'MACARI', '2108', '21'),
('210806', 'NUÑOA', '2108', '21'),
('210807', 'ORURILLO', '2108', '21'),
('210808', 'SANTA ROSA', '2108', '21'),
('210809', 'UMACHIRI', '2108', '21'),
('210901', 'MOHO', '2109', '21'),
('210902', 'CONIMA', '2109', '21'),
('210903', 'HUAYRAPATA', '2109', '21'),
('210904', 'TILALI', '2109', '21'),
('211001', 'PUTINA', '2110', '21'),
('211002', 'ANANEA', '2110', '21'),
('211003', 'PEDRO VILCA APAZA', '2110', '21'),
('211004', 'QUILCAPUNCU', '2110', '21'),
('211005', 'SINA', '2110', '21'),
('211101', 'JULIACA', '2111', '21'),
('211102', 'CABANA', '2111', '21'),
('211103', 'CABANILLAS', '2111', '21'),
('211104', 'CARACOTO', '2111', '21'),
('211105', 'SAN MIGUEL', '2111', '21'),
('211201', 'SANDIA', '2112', '21'),
('211202', 'CUYOCUYO', '2112', '21'),
('211203', 'LIMBANI', '2112', '21'),
('211204', 'PATAMBUCO', '2112', '21'),
('211205', 'PHARA', '2112', '21'),
('211206', 'QUIACA', '2112', '21'),
('211207', 'SAN JUAN DEL ORO', '2112', '21'),
('211208', 'YANAHUAYA', '2112', '21'),
('211209', 'ALTO INAMBARI', '2112', '21'),
('211210', 'SAN PEDRO DE PUTINA PUNCO', '2112', '21'),
('211301', 'YUNGUYO', '2113', '21'),
('211302', 'ANAPIA', '2113', '21'),
('211303', 'COPANI', '2113', '21'),
('211304', 'CUTURAPI', '2113', '21'),
('211305', 'OLLARAYA', '2113', '21'),
('211306', 'TINICACHI', '2113', '21'),
('211307', 'UNICACHI', '2113', '21'),
('220101', 'MOYOBAMBA', '2201', '22'),
('220102', 'CALZADA', '2201', '22'),
('220103', 'HABANA', '2201', '22'),
('220104', 'JEPELACIO', '2201', '22'),
('220105', 'SORITOR', '2201', '22'),
('220106', 'YANTALO', '2201', '22'),
('220201', 'BELLAVISTA', '2202', '22'),
('220202', 'ALTO BIAVO', '2202', '22'),
('220203', 'BAJO BIAVO', '2202', '22'),
('220204', 'HUALLAGA', '2202', '22'),
('220205', 'SAN PABLO', '2202', '22'),
('220206', 'SAN RAFAEL', '2202', '22'),
('220301', 'SAN JOSÉ DE SISA', '2203', '22'),
('220302', 'AGUA BLANCA', '2203', '22'),
('220303', 'SAN MARTÍN', '2203', '22'),
('220304', 'SANTA ROSA', '2203', '22'),
('220305', 'SHATOJA', '2203', '22'),
('220401', 'SAPOSOA', '2204', '22'),
('220402', 'ALTO SAPOSOA', '2204', '22'),
('220403', 'EL ESLABÓN', '2204', '22'),
('220404', 'PISCOYACU', '2204', '22'),
('220405', 'SACANCHE', '2204', '22'),
('220406', 'TINGO DE SAPOSOA', '2204', '22'),
('220501', 'LAMAS', '2205', '22'),
('220502', 'ALONSO DE ALVARADO', '2205', '22'),
('220503', 'BARRANQUITA', '2205', '22'),
('220504', 'CAYNARACHI', '2205', '22'),
('220505', 'CUÑUMBUQUI', '2205', '22'),
('220506', 'PINTO RECODO', '2205', '22'),
('220507', 'RUMISAPA', '2205', '22'),
('220508', 'SAN ROQUE DE CUMBAZA', '2205', '22'),
('220509', 'SHANAO', '2205', '22'),
('220510', 'TABALOSOS', '2205', '22'),
('220511', 'ZAPATERO', '2205', '22'),
('220601', 'JUANJUÍ', '2206', '22'),
('220602', 'CAMPANILLA', '2206', '22'),
('220603', 'HUICUNGO', '2206', '22'),
('220604', 'PACHIZA', '2206', '22'),
('220605', 'PAJARILLO', '2206', '22'),
('220701', 'PICOTA', '2207', '22'),
('220702', 'BUENOS AIRES', '2207', '22'),
('220703', 'CASPISAPA', '2207', '22'),
('220704', 'PILLUANA', '2207', '22'),
('220705', 'PUCACACA', '2207', '22'),
('220706', 'SAN CRISTÓBAL', '2207', '22'),
('220707', 'SAN HILARIÓN', '2207', '22'),
('220708', 'SHAMBOYACU', '2207', '22'),
('220709', 'TINGO DE PONASA', '2207', '22'),
('220710', 'TRES UNIDOS', '2207', '22'),
('220801', 'RIOJA', '2208', '22'),
('220802', 'AWAJUN', '2208', '22'),
('220803', 'ELÍAS SOPLIN VARGAS', '2208', '22'),
('220804', 'NUEVA CAJAMARCA', '2208', '22'),
('220805', 'PARDO MIGUEL', '2208', '22'),
('220806', 'POSIC', '2208', '22'),
('220807', 'SAN FERNANDO', '2208', '22'),
('220808', 'YORONGOS', '2208', '22'),
('220809', 'YURACYACU', '2208', '22'),
('220901', 'TARAPOTO', '2209', '22'),
('220902', 'ALBERTO LEVEAU', '2209', '22'),
('220903', 'CACATACHI', '2209', '22'),
('220904', 'CHAZUTA', '2209', '22'),
('220905', 'CHIPURANA', '2209', '22'),
('220906', 'EL PORVENIR', '2209', '22'),
('220907', 'HUIMBAYOC', '2209', '22'),
('220908', 'JUAN GUERRA', '2209', '22'),
('220909', 'LA BANDA DE SHILCAYO', '2209', '22'),
('220910', 'MORALES', '2209', '22'),
('220911', 'PAPAPLAYA', '2209', '22'),
('220912', 'SAN ANTONIO', '2209', '22'),
('220913', 'SAUCE', '2209', '22'),
('220914', 'SHAPAJA', '2209', '22'),
('221001', 'TOCACHE', '2210', '22'),
('221002', 'NUEVO PROGRESO', '2210', '22'),
('221003', 'POLVORA', '2210', '22'),
('221004', 'SHUNTE', '2210', '22'),
('221005', 'UCHIZA', '2210', '22'),
('230101', 'TACNA', '2301', '23'),
('230102', 'ALTO DE LA ALIANZA', '2301', '23'),
('230103', 'CALANA', '2301', '23'),
('230104', 'CIUDAD NUEVA', '2301', '23'),
('230105', 'INCLAN', '2301', '23'),
('230106', 'PACHIA', '2301', '23'),
('230107', 'PALCA', '2301', '23'),
('230108', 'POCOLLAY', '2301', '23'),
('230109', 'SAMA', '2301', '23'),
('230110', 'CORONEL GREGORIO ALBARRACÍN LANCHIPA', '2301', '23'),
('230111', 'LA YARADA LOS PALOS', '2301', '23'),
('230201', 'CANDARAVE', '2302', '23'),
('230202', 'CAIRANI', '2302', '23'),
('230203', 'CAMILACA', '2302', '23'),
('230204', 'CURIBAYA', '2302', '23'),
('230205', 'HUANUARA', '2302', '23'),
('230206', 'QUILAHUANI', '2302', '23'),
('230301', 'LOCUMBA', '2303', '23'),
('230302', 'ILABAYA', '2303', '23'),
('230303', 'ITE', '2303', '23'),
('230401', 'TARATA', '2304', '23'),
('230402', 'HÉROES ALBARRACÍN', '2304', '23'),
('230403', 'ESTIQUE', '2304', '23'),
('230404', 'ESTIQUE-PAMPA', '2304', '23'),
('230405', 'SITAJARA', '2304', '23'),
('230406', 'SUSAPAYA', '2304', '23'),
('230407', 'TARUCACHI', '2304', '23'),
('230408', 'TICACO', '2304', '23'),
('240101', 'TUMBES', '2401', '24'),
('240102', 'CORRALES', '2401', '24'),
('240103', 'LA CRUZ', '2401', '24'),
('240104', 'PAMPAS DE HOSPITAL', '2401', '24'),
('240105', 'SAN JACINTO', '2401', '24'),
('240106', 'SAN JUAN DE LA VIRGEN', '2401', '24'),
('240201', 'ZORRITOS', '2402', '24'),
('240202', 'CASITAS', '2402', '24'),
('240203', 'CANOAS DE PUNTA SAL', '2402', '24'),
('240301', 'ZARUMILLA', '2403', '24'),
('240302', 'AGUAS VERDES', '2403', '24'),
('240303', 'MATAPALO', '2403', '24'),
('240304', 'PAPAYAL', '2403', '24'),
('250101', 'CALLERIA', '2501', '25'),
('250102', 'CAMPOVERDE', '2501', '25'),
('250103', 'IPARIA', '2501', '25'),
('250104', 'MASISEA', '2501', '25'),
('250105', 'YARINACOCHA', '2501', '25'),
('250106', 'NUEVA REQUENA', '2501', '25'),
('250107', 'MANANTAY', '2501', '25'),
('250201', 'RAYMONDI', '2502', '25'),
('250202', 'SEPAHUA', '2502', '25'),
('250203', 'TAHUANIA', '2502', '25'),
('250204', 'YURUA', '2502', '25'),
('250301', 'PADRE ABAD', '2503', '25'),
('250302', 'IRAZOLA', '2503', '25'),
('250303', 'CURIMANA', '2503', '25'),
('250304', 'NESHUYA', '2503', '25'),
('250305', 'ALEXANDER VON HUMBOLDT', '2503', '25'),
('250401', 'PURUS', '2504', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_distrito_siat`
--

CREATE TABLE `ubigeo_distrito_siat` (
  `Id_Distrito` int(11) NOT NULL,
  `Distrito` varchar(50) NOT NULL,
  `id_Provincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_distrito_siat`
--

INSERT INTO `ubigeo_distrito_siat` (`Id_Distrito`, `Distrito`, `id_Provincia`) VALUES
(1, 'PUQUIO', 1),
(2, 'CORACORA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_provincia`
--

CREATE TABLE `ubigeo_provincia` (
  `id` varchar(4) NOT NULL,
  `nombre_provincia` varchar(45) NOT NULL,
  `department_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_provincia`
--

INSERT INTO `ubigeo_provincia` (`id`, `nombre_provincia`, `department_id`) VALUES
('0101', 'CHACHAPOYAS', '01'),
('0102', 'BAGUA', '01'),
('0103', 'BONGARÁ', '01'),
('0104', 'CONDORCANQUI', '01'),
('0105', 'LUYA', '01'),
('0106', 'RODRÍGUEZ DE MENDOZA', '01'),
('0107', 'UTCUBAMBA', '01'),
('0201', 'HUARAZ', '02'),
('0202', 'AIJA', '02'),
('0203', 'ANTONIO RAYMONDI', '02'),
('0204', 'ASUNCIÓN', '02'),
('0205', 'BOLOGNESI', '02'),
('0206', 'CARHUAZ', '02'),
('0207', 'CARLOS FERMÍN FITZCARRALD', '02'),
('0208', 'CASMA', '02'),
('0209', 'CORONGO', '02'),
('0210', 'HUARI', '02'),
('0211', 'HUARMEY', '02'),
('0212', 'HUAYLAS', '02'),
('0213', 'MARISCAL LUZURIAGA', '02'),
('0214', 'OCROS', '02'),
('0215', 'PALLASCA', '02'),
('0216', 'POMABAMBA', '02'),
('0217', 'RECUAY', '02'),
('0218', 'SANTA', '02'),
('0219', 'SIHUAS', '02'),
('0220', 'YUNGAY', '02'),
('0301', 'ABANCAY', '03'),
('0302', 'ANDAHUAYLAS', '03'),
('0303', 'ANTABAMBA', '03'),
('0304', 'AYMARAES', '03'),
('0305', 'COTABAMBAS', '03'),
('0306', 'CHINCHEROS', '03'),
('0307', 'GRAU', '03'),
('0401', 'AREQUIPA', '04'),
('0402', 'CAMANÁ', '04'),
('0403', 'CARAVELÍ', '04'),
('0404', 'CASTILLA', '04'),
('0405', 'CAYLLOMA', '04'),
('0406', 'CONDESUYOS', '04'),
('0407', 'ISLAY', '04'),
('0408', 'LA UNIÒN', '04'),
('0501', 'HUAMANGA', '05'),
('0502', 'CANGALLO', '05'),
('0503', 'HUANCA SANCOS', '05'),
('0504', 'HUANTA', '05'),
('0505', 'LA MAR', '05'),
('0506', 'LUCANAS', '05'),
('0507', 'PARINACOCHAS', '05'),
('0508', 'PÀUCAR DEL SARA SARA', '05'),
('0509', 'SUCRE', '05'),
('0510', 'VÍCTOR FAJARDO', '05'),
('0511', 'VILCAS HUAMÁN', '05'),
('0601', 'CAJAMARCA', '06'),
('0602', 'CAJABAMBA', '06'),
('0603', 'CELENDÍN', '06'),
('0604', 'CHOTA', '06'),
('0605', 'CONTUMAZÁ', '06'),
('0606', 'CUTERVO', '06'),
('0607', 'HUALGAYOC', '06'),
('0608', 'JAÉN', '06'),
('0609', 'SAN IGNACIO', '06'),
('0610', 'SAN MARCOS', '06'),
('0611', 'SAN MIGUEL', '06'),
('0612', 'SAN PABLO', '06'),
('0613', 'SANTA CRUZ', '06'),
('0701', 'PROV. CONST. DEL CALLAO', '07'),
('0801', 'CUSCO', '08'),
('0802', 'ACOMAYO', '08'),
('0803', 'ANTA', '08'),
('0804', 'CALCA', '08'),
('0805', 'CANAS', '08'),
('0806', 'CANCHIS', '08'),
('0807', 'CHUMBIVILCAS', '08'),
('0808', 'ESPINAR', '08'),
('0809', 'LA CONVENCIÓN', '08'),
('0810', 'PARURO', '08'),
('0811', 'PAUCARTAMBO', '08'),
('0812', 'QUISPICANCHI', '08'),
('0813', 'URUBAMBA', '08'),
('0901', 'HUANCAVELICA', '09'),
('0902', 'ACOBAMBA', '09'),
('0903', 'ANGARAES', '09'),
('0904', 'CASTROVIRREYNA', '09'),
('0905', 'CHURCAMPA', '09'),
('0906', 'HUAYTARÁ', '09'),
('0907', 'TAYACAJA', '09'),
('1001', 'HUÁNUCO', '10'),
('1002', 'AMBO', '10'),
('1003', 'DOS DE MAYO', '10'),
('1004', 'HUACAYBAMBA', '10'),
('1005', 'HUAMALÍES', '10'),
('1006', 'LEONCIO PRADO', '10'),
('1007', 'MARAÑÓN', '10'),
('1008', 'PACHITEA', '10'),
('1009', 'PUERTO INCA', '10'),
('1010', 'LAURICOCHA ', '10'),
('1011', 'YAROWILCA ', '10'),
('1101', 'ICA ', '11'),
('1102', 'CHINCHA ', '11'),
('1103', 'NASCA ', '11'),
('1104', 'PALPA ', '11'),
('1105', 'PISCO ', '11'),
('1201', 'HUANCAYO ', '12'),
('1202', 'CONCEPCIÓN ', '12'),
('1203', 'CHANCHAMAYO ', '12'),
('1204', 'JAUJA ', '12'),
('1205', 'JUNÍN ', '12'),
('1206', 'SATIPO ', '12'),
('1207', 'TARMA ', '12'),
('1208', 'YAULI ', '12'),
('1209', 'CHUPACA ', '12'),
('1301', 'TRUJILLO ', '13'),
('1302', 'ASCOPE ', '13'),
('1303', 'BOLÍVAR ', '13'),
('1304', 'CHEPÉN ', '13'),
('1305', 'JULCÁN ', '13'),
('1306', 'OTUZCO ', '13'),
('1307', 'PACASMAYO ', '13'),
('1308', 'PATAZ ', '13'),
('1309', 'SÁNCHEZ CARRIÓN ', '13'),
('1310', 'SANTIAGO DE CHUCO ', '13'),
('1311', 'GRAN CHIMÚ ', '13'),
('1312', 'VIRÚ ', '13'),
('1401', 'CHICLAYO ', '14'),
('1402', 'FERREÑAFE ', '14'),
('1403', 'LAMBAYEQUE ', '14'),
('1501', 'LIMA ', '15'),
('1502', 'BARRANCA ', '15'),
('1503', 'CAJATAMBO ', '15'),
('1504', 'CANTA ', '15'),
('1505', 'CAÑETE ', '15'),
('1506', 'HUARAL ', '15'),
('1507', 'HUAROCHIRÍ ', '15'),
('1508', 'HUAURA ', '15'),
('1509', 'OYÓN ', '15'),
('1510', 'YAUYOS ', '15'),
('1601', 'MAYNAS ', '16'),
('1602', 'ALTO AMAZONAS ', '16'),
('1603', 'LORETO ', '16'),
('1604', 'MARISCAL RAMÓN CASTILLA ', '16'),
('1605', 'REQUENA ', '16'),
('1606', 'UCAYALI ', '16'),
('1607', 'DATEM DEL MARAÑÓN ', '16'),
('1608', 'PUTUMAYO', '16'),
('1701', 'TAMBOPATA ', '17'),
('1702', 'MANU ', '17'),
('1703', 'TAHUAMANU ', '17'),
('1801', 'MARISCAL NIETO ', '18'),
('1802', 'GENERAL SÁNCHEZ CERRO ', '18'),
('1803', 'ILO ', '18'),
('1901', 'PASCO ', '19'),
('1902', 'DANIEL ALCIDES CARRIÓN ', '19'),
('1903', 'OXAPAMPA ', '19'),
('2001', 'PIURA ', '20'),
('2002', 'AYABACA ', '20'),
('2003', 'HUANCABAMBA ', '20'),
('2004', 'MORROPÓN ', '20'),
('2005', 'PAITA ', '20'),
('2006', 'SULLANA ', '20'),
('2007', 'TALARA ', '20'),
('2008', 'SECHURA ', '20'),
('2101', 'PUNO ', '21'),
('2102', 'AZÁNGARO ', '21'),
('2103', 'CARABAYA ', '21'),
('2104', 'CHUCUITO ', '21'),
('2105', 'EL COLLAO ', '21'),
('2106', 'HUANCANÉ ', '21'),
('2107', 'LAMPA ', '21'),
('2108', 'MELGAR ', '21'),
('2109', 'MOHO ', '21'),
('2110', 'SAN ANTONIO DE PUTINA ', '21'),
('2111', 'SAN ROMÁN ', '21'),
('2112', 'SANDIA ', '21'),
('2113', 'YUNGUYO ', '21'),
('2201', 'MOYOBAMBA ', '22'),
('2202', 'BELLAVISTA ', '22'),
('2203', 'EL DORADO ', '22'),
('2204', 'HUALLAGA ', '22'),
('2205', 'LAMAS ', '22'),
('2206', 'MARISCAL CÁCERES ', '22'),
('2207', 'PICOTA ', '22'),
('2208', 'RIOJA ', '22'),
('2209', 'SAN MARTÍN ', '22'),
('2210', 'TOCACHE ', '22'),
('2301', 'TACNA ', '23'),
('2302', 'CANDARAVE ', '23'),
('2303', 'JORGE BASADRE ', '23'),
('2304', 'TARATA ', '23'),
('2401', 'TUMBES ', '24'),
('2402', 'CONTRALMIRANTE VILLAR ', '24'),
('2403', 'ZARUMILLA ', '24'),
('2501', 'CORONEL PORTILLO ', '25'),
('2502', 'ATALAYA ', '25'),
('2503', 'PADRE ABAD ', '25'),
('2504', 'PURÚS', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeo_provincial_siat`
--

CREATE TABLE `ubigeo_provincial_siat` (
  `Id_Provincia` int(11) NOT NULL,
  `Provincia` varchar(50) NOT NULL,
  `Id_Departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubigeo_provincial_siat`
--

INSERT INTO `ubigeo_provincial_siat` (`Id_Provincia`, `Provincia`, `Id_Departamento`) VALUES
(1, 'LUCANAS', 1),
(2, 'PARINACOCHAS', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uit`
--

CREATE TABLE `uit` (
  `Id_UIT` int(11) NOT NULL,
  `UIT` decimal(10,2) NOT NULL,
  `Id_Anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `uit`
--

INSERT INTO `uit` (`Id_UIT`, `UIT`, `Id_Anio`) VALUES
(1, 4950.00, 1),
(2, 4600.00, 2),
(3, 1.00, 3),
(4, 3950.00, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `codigo` char(5) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `activo` enum('s','n') NOT NULL DEFAULT 's'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `codigo`, `descripcion`, `activo`) VALUES
(1, 'BJ', 'BALDE', 'n'),
(2, 'BLL', 'BARRILES', 'n'),
(3, '4A', 'BOBINAS', 'n'),
(4, 'BG', 'BOLSA', 's'),
(5, 'BO', 'BOTELLAS', 's'),
(6, 'BX', 'CAJAS', 'n'),
(7, 'CT', 'CARTONES', 'n'),
(8, 'CMK', 'CENTIMETRO CUADRADO', 'n'),
(9, 'CMQ', 'CENTIMETRO CUBICO', 'n'),
(10, 'CMT', 'CENTIMETRO LINEAL', 'n'),
(11, 'CEN', 'CIENTO DE UNIDADES', 'n'),
(12, 'CY', 'CILINDRO', 'n'),
(13, 'CJ', 'CONOS', 'n'),
(14, 'DZN', 'DOCENA', 'n'),
(15, 'DZP', 'DOCENA POR 10**6', 'n'),
(16, 'BE', 'FARDO', 'n'),
(17, 'GLI', 'GALON INGLES (4,545956L)', 'n'),
(18, 'GRM', 'GRAMO', 'n'),
(19, 'GRO', 'GRUESA', 'n'),
(20, 'HLT', 'HELECTROLITO', 'n'),
(21, 'LEF', 'HOJA', 's'),
(22, 'SET', 'JUEGO', 's'),
(23, 'KGM', 'KILOGRAMO', 'n'),
(24, 'KTM', 'KILOMETRO', 'n'),
(25, 'KWH', 'KILOVATIO HORA', 'n'),
(26, 'KT', 'KIT', 's'),
(27, 'CA', 'LATAS', 's'),
(28, 'LBR', 'LIBRAS', 'n'),
(29, 'LTR', 'LITROS', 's'),
(30, 'MWH', 'MEGAWHAT HORA', 'n'),
(31, 'MTR', 'METRO', 'n'),
(32, 'MTK', 'METRO CUADRADO', 'n'),
(33, 'MTQ', 'METRO CUBICO', 'n'),
(34, 'MGM', 'MILIGRAMOS', 'n'),
(35, 'MLT', 'MILILITRO', 'n'),
(36, 'MMT', 'MILIMETRO', 'n'),
(37, 'MMK', 'MILIMETRO CUADRADO', 'n'),
(38, 'MMQ', 'MILIMETRO CUBICO', 'n'),
(39, 'MLL', 'MILLARES', 'n'),
(40, 'MU', 'MILLON DE UNIDADES', 'n'),
(41, 'ONZ', 'ONZAS', 'n'),
(42, 'PF', 'PALETAS', 'n'),
(43, 'PK', 'PAQUETE', 's'),
(44, 'PR', 'PAR', 'n'),
(45, 'FOT', 'PIES', 'n'),
(46, 'FTK', 'PIES CUADRADOS', 'n'),
(47, 'FTQ', 'PIES CUBICOS', 'n'),
(48, 'C62', 'PIEZAS', 'n'),
(49, 'PG', 'PLACAS', 'n'),
(50, 'ST', 'PLIEGO', 'n'),
(51, 'INH', 'PULGADAS', 'n'),
(52, 'RM', 'RESMA', 'n'),
(53, 'DR', 'TAMBOR', 'n'),
(54, 'STN', 'TONELADA CORTA', 'n'),
(55, 'LTN', 'TONELADA LARGA', 'n'),
(56, 'TNE', 'TONELADAS', 'n'),
(57, 'TU', 'TUBOS', 'n'),
(58, 'NIU', 'UNIDADADES', 's'),
(59, 'ZZ', 'SERVICIOS', 's'),
(60, 'GLL', 'US GALON (3,7843 L)', 'n'),
(61, 'YRD', 'YARDA', 'n'),
(62, 'YDK', 'YARDA CUADRADA', 'n'),
(63, 'P6', 'SIX PACK', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_predio`
--

CREATE TABLE `uso_predio` (
  `Id_Uso_Predio` int(11) NOT NULL,
  `Uso` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `uso_predio`
--

INSERT INTO `uso_predio` (`Id_Uso_Predio`, `Uso`) VALUES
(1, 'CASA HABITACION O VIVENDA'),
(2, 'COMERCIO'),
(3, 'INDUSTRIA'),
(4, 'SERVICIO EDUCATIVO'),
(5, 'HOSPITAL'),
(6, 'SEDE ADMINISTRATIVA'),
(7, 'SERVICIO HOSPEDAJE'),
(8, 'PLAYA ESTACIONAMIENTO'),
(9, 'TEMPLO, CONVENTO, MONASTERIO'),
(10, 'GOBIERNO EXTRANJERO'),
(11, 'COMPAÑIA DE BOMBEROS'),
(12, 'ORGANIZACION SINDICAL'),
(13, 'COMUNIDAD CAMPESINA O NATIVAS'),
(14, 'INSTITUCION PUBLICA GOBIERNO LOCAL'),
(15, 'PARTIDO POLITICO'),
(16, 'TERRENO SIN CONSTRUIR'),
(17, 'COMUNIDAD CAMPESINA'),
(18, 'OTROS'),
(26, 'VIVIENDA - COMERCIO'),
(27, 'OTROS COMERCIOS'),
(28, 'CENTROS EDUCATIVOS'),
(29, 'HOSPITALES'),
(30, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_terreno`
--

CREATE TABLE `uso_terreno` (
  `Id_Uso_Terreno` int(11) NOT NULL,
  `Uso_Terreno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `uso_terreno`
--

INSERT INTO `uso_terreno` (`Id_Uso_Terreno`, `Uso_Terreno`) VALUES
(1, 'AGRICOLA'),
(2, 'GANADERIA'),
(3, 'AVICOLA'),
(4, 'FORESTAL'),
(5, 'AGRO INDUSTRIAL'),
(6, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Nombre` varchar(200) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `DNI` char(8) NOT NULL,
  `Direccion` varchar(250) NOT NULL,
  `Celular` char(9) NOT NULL,
  `Correo` varchar(250) DEFAULT NULL,
  `Clave` varchar(200) NOT NULL,
  `Estado` char(1) NOT NULL,
  `Fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Id_Area` int(11) NOT NULL,
  `Id_Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Nombre`, `Id_Usuario`, `DNI`, `Direccion`, `Celular`, `Correo`, `Clave`, `Estado`, `Fecha_creacion`, `Id_Area`, `Id_Nivel`) VALUES
('Administrador', 1, '12', '23r', '34r', 'fr', 'cEdSbUpzUjJwUnd3Q0hrVjdCa3Rodz09', '1', '2023-08-02 14:23:18', 2, 1),
('fiscalizador', 6, '12345678', 'dfdfgfg', '123456789', 'sds@gmail.com', 'cEdSbUpzUjJwUnd3Q0hrVjdCa3Rodz09', '1', '2023-08-08 16:10:46', 2, 2),
('JHG', 10, '87575758', 'FGDFG', '987654321', 'Administrador@GMAIL.com', 'cEdSbUpzUjJwUnd3Q0hrVjdCa3Rodz09', '1', '2023-08-08 22:55:55', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `perfil` text NOT NULL,
  `foto` text NOT NULL,
  `estado` int(11) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `dni`, `email`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`, `id_empresa`) VALUES
(23, 'Administrador del sistema', 'demo', '$2a$07$usesomesillystringforeu2qgiHIguHwnea3N8ulpb2nPKxB5zmS', '00000000', 'soporte@apifacturacion.com', 'Administrador', 'vistas/img/usuarios/demo/433.jpg', 1, '2023-11-24 13:18:30', '2023-11-24 18:18:30', 1),
(92, 'hancco', 'hancco', '$2a$07$usesomesillystringforeKLCOY0fUIFdfANAvdYlqi0KoiHnrn3G', '12345678', 'hanco@gmail.com', 'Administrador', '', 0, NULL, '2023-11-24 18:13:33', 1),
(93, 'Ronald', 'ronald', '$2a$07$usesomesillystringforeh13SwIG2YuGjH7WNZPTqAnpzOR7aksC', '45454545', 'ronniel_55@hotmail.com', 'Administrador', '', 0, '2023-11-17 12:41:16', '2023-11-24 18:13:35', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_categoria_x_hectarea`
--

CREATE TABLE `valores_categoria_x_hectarea` (
  `Id_valores_categoria_x_hectarea` int(11) NOT NULL,
  `Id_Calidad_Agricola` int(11) NOT NULL,
  `Id_Grupo_Tierra` int(11) NOT NULL,
  `Id_Zona_Rural` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valores_categoria_x_hectarea`
--

INSERT INTO `valores_categoria_x_hectarea` (`Id_valores_categoria_x_hectarea`, `Id_Calidad_Agricola`, `Id_Grupo_Tierra`, `Id_Zona_Rural`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 2, 1, 1),
(6, 2, 2, 1),
(7, 2, 3, 1),
(8, 2, 4, 1),
(9, 3, 1, 1),
(10, 3, 2, 1),
(11, 3, 3, 1),
(12, 3, 4, 1),
(13, 4, 1, 1),
(14, 4, 2, 1),
(15, 4, 3, 1),
(16, 4, 4, 1),
(17, 5, 1, 1),
(18, 5, 2, 1),
(19, 5, 3, 1),
(20, 5, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_edificacion`
--

CREATE TABLE `valores_edificacion` (
  `Id_Valores_Edificacion` int(11) NOT NULL,
  `Id_Anio` int(11) DEFAULT NULL,
  `Id_Categoria` int(11) NOT NULL,
  `Id_Parametro` int(11) DEFAULT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valores_edificacion`
--

INSERT INTO `valores_edificacion` (`Id_Valores_Edificacion`, `Id_Anio`, `Id_Categoria`, `Id_Parametro`, `Monto`, `Estado`) VALUES
(1, 1, 1, 1, 898.59, 1),
(2, 1, 1, 2, 467.23, 1),
(3, 1, 1, 3, 0.00, 0),
(4, 1, 1, 4, 354.66, 1),
(5, 1, 2, 1, 534.59, 1),
(6, 1, 2, 2, 321.22, 1),
(7, 1, 2, 3, 0.00, 0),
(8, 1, 2, 4, 313.84, 1),
(9, 1, 3, 1, 387.87, 1),
(10, 1, 3, 2, 224.78, 1),
(11, 1, 3, 3, 0.00, 0),
(12, 1, 3, 4, 228.98, 1),
(13, 1, 4, 1, 358.26, 1),
(14, 1, 4, 2, 152.16, 1),
(15, 1, 4, 3, 0.00, 0),
(16, 1, 4, 4, 134.31, 1),
(17, 1, 5, 1, 230.09, 1),
(18, 1, 5, 2, 57.16, 1),
(19, 1, 5, 3, 0.00, 0),
(20, 1, 5, 4, 83.93, 1),
(21, 1, 6, 1, 175.38, 1),
(22, 1, 6, 2, 55.82, 1),
(23, 1, 6, 3, 0.00, 0),
(24, 1, 6, 4, 79.34, 1),
(25, 1, 7, 1, 103.33, 1),
(26, 1, 7, 2, 0.00, 1),
(27, 1, 7, 3, 0.00, 0),
(28, 1, 7, 4, 46.74, 1),
(29, 1, 8, 1, 0.00, 1),
(30, 1, 8, 2, 0.00, 1),
(31, 1, 8, 3, 0.00, 0),
(32, 1, 8, 4, 23.37, 1),
(33, 1, 9, 1, 0.00, 1),
(34, 1, 9, 2, 0.00, 1),
(35, 1, 9, 3, 0.00, 0),
(36, 1, 9, 4, 0.00, 1),
(37, 2, 1, 1, 547.10, 1),
(38, 2, 1, 2, 332.29, 1),
(39, 2, 1, 3, 293.45, 1),
(40, 2, 1, 4, 296.91, 1),
(41, 2, 1, 5, 320.02, 1),
(42, 2, 1, 6, 107.99, 1),
(43, 2, 1, 7, 317.38, 1),
(44, 2, 2, 1, 352.73, 1),
(45, 2, 2, 2, 216.79, 1),
(46, 2, 2, 3, 175.88, 1),
(47, 2, 2, 4, 156.50, 1),
(48, 2, 2, 5, 242.47, 1),
(49, 2, 2, 6, 82.11, 1),
(50, 2, 2, 7, 231.73, 1),
(51, 2, 3, 1, 242.81, 1),
(52, 2, 3, 2, 179.11, 1),
(53, 2, 3, 3, 115.76, 1),
(54, 2, 3, 4, 101.15, 1),
(55, 2, 3, 5, 179.87, 1),
(56, 2, 3, 6, 56.96, 1),
(57, 2, 3, 7, 146.19, 1),
(58, 2, 4, 1, 234.80, 1),
(59, 2, 4, 2, 113.68, 1),
(60, 2, 4, 3, 102.12, 1),
(61, 2, 4, 4, 80.60, 1),
(62, 2, 4, 5, 138.01, 1),
(63, 2, 4, 6, 30.39, 1),
(64, 2, 4, 7, 92.35, 1),
(65, 2, 5, 1, 165.30, 1),
(66, 2, 5, 2, 42.38, 1),
(67, 2, 5, 3, 60.42, 1),
(68, 2, 5, 4, 75.81, 1),
(69, 2, 5, 5, 94.95, 1),
(70, 2, 5, 6, 17.87, 1),
(71, 2, 5, 7, 67.07, 1),
(72, 2, 6, 1, 124.49, 1),
(73, 2, 6, 2, 23.31, 1),
(74, 2, 6, 3, 46.72, 1),
(75, 2, 6, 4, 56.91, 1),
(76, 2, 6, 5, 66.93, 1),
(77, 2, 6, 6, 13.31, 1),
(78, 2, 6, 7, 38.37, 1),
(79, 2, 7, 1, 73.35, 1),
(80, 2, 7, 2, 16.02, 1),
(81, 2, 7, 3, 41.24, 1),
(82, 2, 7, 4, 30.74, 1),
(83, 2, 7, 5, 54.88, 1),
(84, 2, 7, 6, 9.15, 1),
(85, 2, 7, 7, 35.59, 1),
(86, 2, 8, 1, 0.00, 1),
(87, 2, 8, 2, 0.00, 1),
(88, 2, 8, 3, 25.80, 1),
(89, 2, 8, 4, 15.37, 1),
(90, 2, 8, 5, 21.95, 1),
(91, 2, 8, 6, 0.00, 1),
(92, 2, 8, 7, 19.22, 1),
(93, 2, 9, 1, 0.00, 1),
(94, 2, 9, 2, 0.00, 1),
(95, 2, 9, 3, 5.16, 1),
(96, 2, 9, 4, 0.00, 1),
(97, 2, 9, 5, 0.00, 1),
(98, 2, 9, 6, 0.00, 1),
(99, 2, 9, 7, 0.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `idemisor` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `idserie` int(11) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `serie_correlativo` varchar(15) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fechahora` datetime DEFAULT NULL,
  `codmoneda` char(3) DEFAULT NULL,
  `tipocambio` float DEFAULT NULL,
  `metodopago` varchar(4) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `igv_op` decimal(11,2) DEFAULT 0.00,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `icbper` decimal(11,2) DEFAULT 0.00,
  `igv` decimal(11,2) DEFAULT NULL,
  `subtotal` decimal(11,2) DEFAULT 0.00,
  `total` decimal(11,2) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `codvendedor` int(11) DEFAULT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `xmlbase64` text DEFAULT NULL,
  `cdrbase64` text DEFAULT NULL,
  `anulado` enum('n','s') NOT NULL DEFAULT 'n',
  `resumen` enum('s','n') DEFAULT 'n',
  `idbaja` int(11) DEFAULT NULL,
  `id_nc` int(11) DEFAULT NULL,
  `id_nd` int(11) DEFAULT NULL,
  `bienesSelva` varchar(4) DEFAULT NULL,
  `serviciosSelva` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `idemisor`, `tipocomp`, `idserie`, `serie`, `correlativo`, `serie_correlativo`, `fecha_emision`, `fechahora`, `codmoneda`, `tipocambio`, `metodopago`, `comentario`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `op_gratuitas`, `igv_op`, `descuento_factor`, `descuento`, `icbper`, `igv`, `subtotal`, `total`, `codcliente`, `codvendedor`, `tipodoc`, `feestado`, `fecodigoerror`, `femensajesunat`, `nombrexml`, `xmlbase64`, `cdrbase64`, `anulado`, `resumen`, `idbaja`, `id_nc`, `id_nd`, `bienesSelva`, `serviciosSelva`) VALUES
(1, 1, '03', 3, 'B001', 1, 'B001-1', '2023-10-23', '2023-10-23 15:13:52', 'PEN', 1, '009', '', 254.24, 0.00, 0.00, 0.00, 0.00, 0.00000, 0.00, 0.00, 45.76, 254.24, 300.00, 11, 23, '1', '1', NULL, NULL, '20601284953-03-B001-1.XML', 'R-20601284953-03-B001-1.XML', 'R-20601284953-03-B001-1.ZIP', 'n', 'n', NULL, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `Id_Zona` int(11) NOT NULL,
  `Nombre_Zona` varchar(20) DEFAULT NULL,
  `Id_Habilitacion_Urbana` int(11) NOT NULL,
  `Id_Distrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`Id_Zona`, `Nombre_Zona`, `Id_Habilitacion_Urbana`, `Id_Distrito`) VALUES
(1, 'CASAYMARCA', 5, 1),
(2, 'ALIAGA', 6, 1),
(3, 'CASAYMARCA', 6, 1),
(4, 'LA VICTORIA', 6, 1),
(5, 'LAZARO QUISPE', 6, 1),
(6, 'LOS PUQUIALES', 6, 1),
(7, 'PROLONGACION JR DOS ', 6, 1),
(8, 'SAN MARTIN ', 6, 1),
(9, 'VISTA ALEGRE', 6, 1),
(10, 'PUEBLO JOVEN MATARA', 10, 1),
(11, 'SANTA FELICITA ', 10, 1),
(12, 'SANTA FILOMENA', 10, 1),
(13, 'SANTA ROSA', 10, 1),
(14, 'MALAYA ', 12, 1),
(15, 'CCAYAO', 18, 1),
(16, 'CCOLLANA', 18, 1),
(17, 'CHAUPI', 18, 1),
(18, 'PICCHCHURI', 18, 1),
(19, 'CERCADO', 25, 1),
(20, 'TOCCTOPAMPA', 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_catastro`
--

CREATE TABLE `zona_catastro` (
  `id_zona_catastro` int(11) NOT NULL,
  `nombre_zona_catastro` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona_catastro`
--

INSERT INTO `zona_catastro` (`id_zona_catastro`, `nombre_zona_catastro`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_rural`
--

CREATE TABLE `zona_rural` (
  `Id_zona_rural` int(11) NOT NULL,
  `nombre_zona` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona_rural`
--

INSERT INTO `zona_rural` (`Id_zona_rural`, `nombre_zona`) VALUES
(1, 'Ccallao'),
(2, 'Ccollana'),
(3, 'Chaupi'),
(4, 'Piccachuri'),
(5, 'Anexo Cliques'),
(6, 'Anexo San Andres');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anio`
--
ALTER TABLE `anio`
  ADD PRIMARY KEY (`Id_Anio`);

--
-- Indices de la tabla `anio_antiguedad`
--
ALTER TABLE `anio_antiguedad`
  ADD PRIMARY KEY (`Id_Anio_Antiguedad`);

--
-- Indices de la tabla `arancel`
--
ALTER TABLE `arancel`
  ADD PRIMARY KEY (`Id_Arancel`),
  ADD KEY `FK_arancel_anio` (`Id_Anio`);

--
-- Indices de la tabla `arancel_rustico`
--
ALTER TABLE `arancel_rustico`
  ADD PRIMARY KEY (`Id_Arancel_Rustico`),
  ADD KEY `FK_arancelRustico_anio` (`Id_Anio`);

--
-- Indices de la tabla `arancel_rustico_hectarea`
--
ALTER TABLE `arancel_rustico_hectarea`
  ADD PRIMARY KEY (`Id_Arancel_Rustico_Hectarea`),
  ADD KEY `FK_arancelRustico_Hectarea` (`Id_Arancel_Rustico`),
  ADD KEY `FK_arancelRustico_valoresCategoriaxhectarea` (`Id_valores_categoria_x_hectarea`);

--
-- Indices de la tabla `arancel_vias`
--
ALTER TABLE `arancel_vias`
  ADD PRIMARY KEY (`Id_Arancel_Vias`),
  ADD KEY `FK_arancelVias_arancel` (`Id_Arancel`),
  ADD KEY `FK_arancelVias_ubicaViasUrbano` (`Id_Ubica_Vias_Urbano`);

--
-- Indices de la tabla `arbitrios`
--
ALTER TABLE `arbitrios`
  ADD PRIMARY KEY (`Id_Arbitrios`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`Id_Area`);

--
-- Indices de la tabla `base_imponible`
--
ALTER TABLE `base_imponible`
  ADD PRIMARY KEY (`Id_Baseimponible`),
  ADD KEY `FK_Contribuyente_Baseimponible` (`Id_Contribuyente`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `calidad_agricola`
--
ALTER TABLE `calidad_agricola`
  ADD PRIMARY KEY (`Id_Calidad_Agricola`);

--
-- Indices de la tabla `catastro`
--
ALTER TABLE `catastro`
  ADD PRIMARY KEY (`Id_Catastro`),
  ADD KEY `Predio_Id_UbicavasUrbano` (`Id_Ubica_Vias_Urbano`);

--
-- Indices de la tabla `catastro_rural`
--
ALTER TABLE `catastro_rural`
  ADD PRIMARY KEY (`Id_Catastro_Rural`),
  ADD KEY `fk_catastroRural_valores_categoria_x_hectarea` (`Id_valores_categoria_x_hectarea`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_Categoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clasificacion_contribuyente`
--
ALTER TABLE `clasificacion_contribuyente`
  ADD PRIMARY KEY (`Id_Clasificacion_Contribuyente`);

--
-- Indices de la tabla `clasificacion_piso`
--
ALTER TABLE `clasificacion_piso`
  ADD PRIMARY KEY (`Id_Clasificacion_Piso`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colindante_denominacion`
--
ALTER TABLE `colindante_denominacion`
  ADD PRIMARY KEY (`Id_Colindante_Denominacion`),
  ADD KEY `fk_colindante_denominacion_denominacion_rural` (`Id_Denominacion_Rural`);

--
-- Indices de la tabla `colindante_propietario`
--
ALTER TABLE `colindante_propietario`
  ADD PRIMARY KEY (`Id_Colindante_Propietario`),
  ADD KEY `fk_colindantepropietarios_propietario` (`Id_Propietario`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_tipcomp` (`tipocomp`) USING BTREE,
  ADD KEY `fk_moneda` (`codmoneda`) USING BTREE,
  ADD KEY `fk_cliente` (`codproveedor`) USING BTREE,
  ADD KEY `fk_emisor` (`idemisor`) USING BTREE,
  ADD KEY `ventas` (`correlativo`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_venta` (`idcompra`) USING BTREE,
  ADD KEY `fk_producto` (`idproducto`) USING BTREE;

--
-- Indices de la tabla `condicion_catastral`
--
ALTER TABLE `condicion_catastral`
  ADD PRIMARY KEY (`Id_Condicion_Catastral`);

--
-- Indices de la tabla `condicion_contribuyente`
--
ALTER TABLE `condicion_contribuyente`
  ADD PRIMARY KEY (`Id_Condicion_Contribuyente`);

--
-- Indices de la tabla `condicion_predio`
--
ALTER TABLE `condicion_predio`
  ADD PRIMARY KEY (`Id_Condicion_Predio`);

--
-- Indices de la tabla `condicion_predio_fiscal`
--
ALTER TABLE `condicion_predio_fiscal`
  ADD PRIMARY KEY (`Id_Condicon_Predio_Fiscal`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`Id_Configuraciones`);

--
-- Indices de la tabla `contribuyente`
--
ALTER TABLE `contribuyente`
  ADD PRIMARY KEY (`Id_Contribuyente`),
  ADD KEY `R_22` (`Id_Ubica_Vias_Urbano`),
  ADD KEY `R_23` (`Id_Tipo_Contribuyente`),
  ADD KEY `R_24` (`Id_Condicion_Predio_Fiscal`),
  ADD KEY `R_25` (`Id_Clasificacion_Contribuyente`),
  ADD KEY `fk_contribuyente_usuario1_idx` (`usuario_Id_Usuario`),
  ADD KEY `fk_id_tipo_documento` (`Id_Tipo_Documento`),
  ADD KEY `fk_contribuyente_condicion_contribuyente` (`Id_Condicion_Contribuyente`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idemisor` (`idemisor`),
  ADD KEY `idserie` (`idserie`);

--
-- Indices de la tabla `cuadra`
--
ALTER TABLE `cuadra`
  ADD PRIMARY KEY (`Id_cuadra`);

--
-- Indices de la tabla `cuotas_vencimiento`
--
ALTER TABLE `cuotas_vencimiento`
  ADD PRIMARY KEY (`Id_Cuotas_Vencimiento`),
  ADD KEY `cuotasvencimiento_anio` (`Id_Anio`);

--
-- Indices de la tabla `cuotas_vencimiento_impuesto`
--
ALTER TABLE `cuotas_vencimiento_impuesto`
  ADD PRIMARY KEY (`Id_Cuotas_Vencimiento_Impuesto`),
  ADD KEY `fk_cuotasvencimientoimpuesto_anio` (`Id_Anio`);

--
-- Indices de la tabla `denominacion_rural`
--
ALTER TABLE `denominacion_rural`
  ADD PRIMARY KEY (`Id_Denominacion_Rural`),
  ADD KEY `fk_denominacionrural_zonarural` (`Id_Zona_Rural`);

--
-- Indices de la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD PRIMARY KEY (`Id_depreciacion`),
  ADD KEY `R_18` (`Id_Material_Piso`),
  ADD KEY `R_19` (`Id_Clasificacion_Piso`),
  ADD KEY `R_20` (`Id_Estado_Conservacion`),
  ADD KEY `fk_depreciacion_anioantiguedad` (`Id_Anio_Antiguedad`);

--
-- Indices de la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`Id_Descuento`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_venta` (`idventa`) USING BTREE,
  ADD KEY `fk_producto` (`idproducto`) USING BTREE;

--
-- Indices de la tabla `detalle_cotizaciones`
--
ALTER TABLE `detalle_cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idventa` (`idventa`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `detalle_eliminar`
--
ALTER TABLE `detalle_eliminar`
  ADD PRIMARY KEY (`Id_Detalle_Eliminar`);

--
-- Indices de la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  ADD PRIMARY KEY (`Id_Detalle_Transferencia`),
  ADD KEY `fk_detalletransferencia_documentoinscripcion` (`Id_Documento_Inscripcion`),
  ADD KEY `fk_detalletransferencia_tipoescritura` (`Id_Tipo_Escritura`) USING BTREE;

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`Id_Direccion`),
  ADD KEY `R_75` (`Id_Tipo_Via`),
  ADD KEY `R_78` (`Id_Zona`),
  ADD KEY `FK_id_nombre_via_direccion_NombreVia` (`Id_Nombre_Via`);

--
-- Indices de la tabla `documento_inscripcion`
--
ALTER TABLE `documento_inscripcion`
  ADD PRIMARY KEY (`Id_Documento_Inscripcion`);

--
-- Indices de la tabla `edificacion_piso`
--
ALTER TABLE `edificacion_piso`
  ADD PRIMARY KEY (`Id_Edificacion_Piso`),
  ADD KEY `fk_valoresedificacion_pisos` (`Id_Valores_Edificacion`),
  ADD KEY `fk_valores_edificacion_pisos` (`Id_Piso`);

--
-- Indices de la tabla `emisor`
--
ALTER TABLE `emisor`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  ADD PRIMARY KEY (`idenvio`) USING BTREE;

--
-- Indices de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  ADD PRIMARY KEY (`iddetalle`) USING BTREE,
  ADD KEY `fk_ideenvio` (`idenvio`) USING BTREE,
  ADD KEY `fk_idventa` (`idventa`) USING BTREE;

--
-- Indices de la tabla `especie_valorada`
--
ALTER TABLE `especie_valorada`
  ADD PRIMARY KEY (`Id_Especie_Valorada`),
  ADD KEY `R_8` (`Id_Area`),
  ADD KEY `R_9` (`Id_Presupuesto`),
  ADD KEY `FK_especievalorada_instrumentogestion` (`Id_Instrumento_Gestion`);

--
-- Indices de la tabla `estado_conservacion`
--
ALTER TABLE `estado_conservacion`
  ADD PRIMARY KEY (`Id_Estado_Conservacion`);

--
-- Indices de la tabla `estado_cuenta_corriente`
--
ALTER TABLE `estado_cuenta_corriente`
  ADD PRIMARY KEY (`Id_Estado_Cuenta_Impuesto`),
  ADD KEY `R_49` (`Id_Predio`),
  ADD KEY `R_50` (`Id_Usuario`) USING BTREE,
  ADD KEY `FK_estadocuentacorriente_descuento` (`Id_Descuento`);

--
-- Indices de la tabla `estado_predio`
--
ALTER TABLE `estado_predio`
  ADD PRIMARY KEY (`Id_Estado_Predio`);

--
-- Indices de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  ADD PRIMARY KEY (`Id_financiamiento`);

--
-- Indices de la tabla `formula_impuesto`
--
ALTER TABLE `formula_impuesto`
  ADD PRIMARY KEY (`Id_Formula_Impuesto`),
  ADD KEY `fk_formula_impuesto_anio` (`Id_Anio`),
  ADD KEY `fk_formula_impuesto_UIT` (`Id_UIT`);

--
-- Indices de la tabla `gastos_emision`
--
ALTER TABLE `gastos_emision`
  ADD PRIMARY KEY (`Id_Gastos_Emision`);

--
-- Indices de la tabla `giro_comercial`
--
ALTER TABLE `giro_comercial`
  ADD PRIMARY KEY (`Id_Giro_Comercial`);

--
-- Indices de la tabla `giro_establecimiento`
--
ALTER TABLE `giro_establecimiento`
  ADD PRIMARY KEY (`Id_Giro_Establecimiento`);

--
-- Indices de la tabla `grupo_tierra`
--
ALTER TABLE `grupo_tierra`
  ADD PRIMARY KEY (`Id_Grupo_Tierra`);

--
-- Indices de la tabla `guia`
--
ALTER TABLE `guia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `guia_detalle`
--
ALTER TABLE `guia_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guia` (`id_guia`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `habilitaciones_urbanas`
--
ALTER TABLE `habilitaciones_urbanas`
  ADD PRIMARY KEY (`Id_Habilitacion_Urbana`);

--
-- Indices de la tabla `inafecto`
--
ALTER TABLE `inafecto`
  ADD PRIMARY KEY (`Id_inafecto`);

--
-- Indices de la tabla `ingresos_tributos`
--
ALTER TABLE `ingresos_tributos`
  ADD PRIMARY KEY (`Id_Ingresos_Tributos`),
  ADD KEY `R_54` (`Id_Estado_Cuenta_Impuesto`),
  ADD KEY `R_63` (`Id_Presupuesto`),
  ADD KEY `R_66` (`Id_financiamiento`),
  ADD KEY `R_67` (`Id_Area`);

--
-- Indices de la tabla `instrumento_gestion`
--
ALTER TABLE `instrumento_gestion`
  ADD PRIMARY KEY (`Id_Instrumento_Gestion`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `lado`
--
ALTER TABLE `lado`
  ADD PRIMARY KEY (`Id_Lado`);

--
-- Indices de la tabla `manzana`
--
ALTER TABLE `manzana`
  ADD PRIMARY KEY (`Id_Manzana`);

--
-- Indices de la tabla `material_piso`
--
ALTER TABLE `material_piso`
  ADD PRIMARY KEY (`Id_Material_Piso`);

--
-- Indices de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `modalidad_transporte`
--
ALTER TABLE `modalidad_transporte`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `motivo_traslado`
--
ALTER TABLE `motivo_traslado`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`Id_Nivel`);

--
-- Indices de la tabla `nombre_arbitrios`
--
ALTER TABLE `nombre_arbitrios`
  ADD PRIMARY KEY (`Id_Nombre_Arbitrio`);

--
-- Indices de la tabla `nombre_via`
--
ALTER TABLE `nombre_via`
  ADD PRIMARY KEY (`Id_Nombre_Via`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_tipcomp` (`tipocomp`) USING BTREE,
  ADD KEY `fk_moneda` (`codmoneda`) USING BTREE,
  ADD KEY `fk_cliente` (`codcliente`) USING BTREE,
  ADD KEY `fk_serie` (`idserie`) USING BTREE,
  ADD KEY `fk_emisor` (`idemisor`) USING BTREE;

--
-- Indices de la tabla `nota_credito_detalle`
--
ALTER TABLE `nota_credito_detalle`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_venta` (`idnc`) USING BTREE,
  ADD KEY `fk_producto` (`idproducto`) USING BTREE;

--
-- Indices de la tabla `nota_debito`
--
ALTER TABLE `nota_debito`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_tipcomp` (`tipocomp`) USING BTREE,
  ADD KEY `fk_moneda` (`codmoneda`) USING BTREE,
  ADD KEY `fk_cliente` (`codcliente`) USING BTREE,
  ADD KEY `fk_serie` (`idserie`) USING BTREE,
  ADD KEY `fk_emisor` (`idemisor`) USING BTREE;

--
-- Indices de la tabla `nota_debito_detalle`
--
ALTER TABLE `nota_debito_detalle`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_venta` (`idnd`) USING BTREE,
  ADD KEY `fk_producto` (`idproducto`) USING BTREE;

--
-- Indices de la tabla `pago_credito`
--
ALTER TABLE `pago_credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `parametro`
--
ALTER TABLE `parametro`
  ADD PRIMARY KEY (`Id_Parametro`);

--
-- Indices de la tabla `parque_distancia`
--
ALTER TABLE `parque_distancia`
  ADD PRIMARY KEY (`Id_Parque_Distancia`);

--
-- Indices de la tabla `pisos`
--
ALTER TABLE `pisos`
  ADD PRIMARY KEY (`Id_Piso`),
  ADD KEY `fk_Estado_Conservacion` (`Id_Estado_Conservacion`),
  ADD KEY `fk_Id_Clasificacion_Piso` (`Id_Clasificacion_Piso`),
  ADD KEY `fk_Id_Material_Piso` (`Id_Material_Piso`),
  ADD KEY `fk_Id_Predio` (`Id_Predio`);

--
-- Indices de la tabla `piso_predio`
--
ALTER TABLE `piso_predio`
  ADD PRIMARY KEY (`Id_Piso_Predio`),
  ADD KEY `fk_pisopredio_piso` (`Id_Piso`),
  ADD KEY `fk_pisopredio_predio` (`Id_Predio`);

--
-- Indices de la tabla `predio`
--
ALTER TABLE `predio`
  ADD PRIMARY KEY (`Id_Predio`),
  ADD KEY `R_27` (`Id_Tipo_Predio`),
  ADD KEY `R_28` (`Id_Uso_Predio`),
  ADD KEY `R_29` (`Id_Giro_Establecimiento`),
  ADD KEY `R_30` (`Id_Estado_Predio`),
  ADD KEY `R_31` (`Id_Regimen_Afecto`),
  ADD KEY `R_32` (`Id_inafecto`),
  ADD KEY `R_33` (`Id_Arbitrios`),
  ADD KEY `R_34` (`Id_Condicion_Predio`),
  ADD KEY `R_35` (`Id_Sesion`),
  ADD KEY `detallePredio_Anio` (`Id_Anio`),
  ADD KEY `predio_catastro` (`Id_Catastro`),
  ADD KEY `fk_predio_uso_terreno` (`Id_Uso_Terreno`),
  ADD KEY `fk_predio_tipoterreno` (`Id_Tipo_Terreno`),
  ADD KEY `fk_predio_colindantedenominacion` (`Id_Colindante_Denominacion`),
  ADD KEY `fk_predio_colindante_propietario` (`Id_Colindante_Propietario`),
  ADD KEY `fk_tabla_predio_catastrorural` (`Id_Catastro_Rural`),
  ADD KEY `fk_predio_denominacionRural` (`Id_Denominacion_Rural`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`Id_Presupuesto`),
  ADD KEY `R_64` (`Id_financiamiento`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD PRIMARY KEY (`Id_Propietario`),
  ADD KEY `propietario_predio` (`Id_Predio`),
  ADD KEY `propietario_contribuyente` (`Id_Contribuyente`),
  ADD KEY `fk_propietario_detalletransferencia` (`Id_Detalle_Transferencia`),
  ADD KEY `fk_propietario_detalleeliminar` (`Id_Detalle_Eliminar`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regimen_afecto`
--
ALTER TABLE `regimen_afecto`
  ADD PRIMARY KEY (`Id_Regimen_Afecto`);

--
-- Indices de la tabla `reporte_financiamiento`
--
ALTER TABLE `reporte_financiamiento`
  ADD PRIMARY KEY (`Id_Reporte_Financiamiento`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`Id_Sesion`),
  ADD KEY `R_5` (`Id_Usuario`);

--
-- Indices de la tabla `situacion_cuadra`
--
ALTER TABLE `situacion_cuadra`
  ADD PRIMARY KEY (`Id_Situacion_Cuadra`);

--
-- Indices de la tabla `tabla_parametrica`
--
ALTER TABLE `tabla_parametrica`
  ADD PRIMARY KEY (`codigo`,`tipo`) USING BTREE;

--
-- Indices de la tabla `tasa_arbitrio`
--
ALTER TABLE `tasa_arbitrio`
  ADD PRIMARY KEY (`Id_Tasa_Arbitrio`),
  ADD KEY `FK_Tasaarbitrio_categoriaarbitrio` (`Id_Arbitrios`),
  ADD KEY `FK_Tasaarbitrio_nombrearbitrio` (`Id_Nombre_Arbitrio`),
  ADD KEY `FK_Tasaarbitrio_anio` (`Id_Anio`);

--
-- Indices de la tabla `tim`
--
ALTER TABLE `tim`
  ADD PRIMARY KEY (`Id_TIM`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`codigo`) USING BTREE;

--
-- Indices de la tabla `tipo_contribuyente`
--
ALTER TABLE `tipo_contribuyente`
  ADD PRIMARY KEY (`Id_Tipo_Contribuyente`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_documento_siat`
--
ALTER TABLE `tipo_documento_siat`
  ADD PRIMARY KEY (`Id_Tipo_Documento`);

--
-- Indices de la tabla `tipo_escritura`
--
ALTER TABLE `tipo_escritura`
  ADD PRIMARY KEY (`Id_Tipo_Escritura`);

--
-- Indices de la tabla `tipo_predio`
--
ALTER TABLE `tipo_predio`
  ADD PRIMARY KEY (`Id_Tipo_Predio`);

--
-- Indices de la tabla `tipo_terreno`
--
ALTER TABLE `tipo_terreno`
  ADD PRIMARY KEY (`Id_Tipo_Terreno`);

--
-- Indices de la tabla `tipo_via`
--
ALTER TABLE `tipo_via`
  ADD PRIMARY KEY (`Id_Tipo_Via`);

--
-- Indices de la tabla `transferencia_predios`
--
ALTER TABLE `transferencia_predios`
  ADD PRIMARY KEY (`Id_Transferencia`),
  ADD KEY `R_37` (`Id_Predio`),
  ADD KEY `R_39` (`Id_Contribuyente`),
  ADD KEY `R_42` (`Id_Sesion`);

--
-- Indices de la tabla `ubica_via_urbano`
--
ALTER TABLE `ubica_via_urbano`
  ADD PRIMARY KEY (`Id_Ubica_Vias_Urbano`),
  ADD KEY `R_76` (`Id_Direccion`),
  ADD KEY `FK_ubicaviaurbano_cuadra` (`Id_Cuadra`),
  ADD KEY `FK_id_ladoUbicaviaurbano_lado` (`Id_Lado`),
  ADD KEY `FK_ubicaviaurbano_condicioncatastral` (`Id_Condicion_Catastral`),
  ADD KEY `FK_ubicaviaurbano_situacionciadra` (`Id_Situacion_Cuadra`),
  ADD KEY `FK_ubicaviaurbano_parquedistancia` (`Id_Parque_Distancia`),
  ADD KEY `FK_ubicaViaUrbano_Manzana` (`Id_Manzana`),
  ADD KEY `FK_ubicaViaUrbano_zonaCatastro` (`Id_Zona_Catastro`);

--
-- Indices de la tabla `ubigeo_departamento`
--
ALTER TABLE `ubigeo_departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubigeo_departamento_siat`
--
ALTER TABLE `ubigeo_departamento_siat`
  ADD PRIMARY KEY (`Id_Departamento`);

--
-- Indices de la tabla `ubigeo_distrito`
--
ALTER TABLE `ubigeo_distrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubigeo_distrito_siat`
--
ALTER TABLE `ubigeo_distrito_siat`
  ADD PRIMARY KEY (`Id_Distrito`),
  ADD KEY `FK_distrito_provincia` (`id_Provincia`);

--
-- Indices de la tabla `ubigeo_provincia`
--
ALTER TABLE `ubigeo_provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubigeo_provincial_siat`
--
ALTER TABLE `ubigeo_provincial_siat`
  ADD PRIMARY KEY (`Id_Provincia`),
  ADD KEY `FK_ubigeoprovincial_departamento` (`Id_Departamento`);

--
-- Indices de la tabla `uit`
--
ALTER TABLE `uit`
  ADD PRIMARY KEY (`Id_UIT`),
  ADD KEY `fk_uit_anio` (`Id_Anio`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `uso_predio`
--
ALTER TABLE `uso_predio`
  ADD PRIMARY KEY (`Id_Uso_Predio`);

--
-- Indices de la tabla `uso_terreno`
--
ALTER TABLE `uso_terreno`
  ADD PRIMARY KEY (`Id_Uso_Terreno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD KEY `R_69` (`Id_Nivel`),
  ADD KEY `R_71` (`Id_Area`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `valores_categoria_x_hectarea`
--
ALTER TABLE `valores_categoria_x_hectarea`
  ADD PRIMARY KEY (`Id_valores_categoria_x_hectarea`),
  ADD KEY `valores_categoria_x_hectarea_grupo_tierra` (`Id_Grupo_Tierra`),
  ADD KEY `valores_categoria_x_hectarea_calidad_agricola` (`Id_Calidad_Agricola`),
  ADD KEY `fk_valorescategoriaxhectarea_zonarural` (`Id_Zona_Rural`);

--
-- Indices de la tabla `valores_edificacion`
--
ALTER TABLE `valores_edificacion`
  ADD PRIMARY KEY (`Id_Valores_Edificacion`),
  ADD KEY `fk_valoresedificacion_anio` (`Id_Anio`),
  ADD KEY `fk_valoresedificacion_categoria` (`Id_Categoria`),
  ADD KEY `fk_valoresedificacion_parametro` (`Id_Parametro`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_tipcomp` (`tipocomp`) USING BTREE,
  ADD KEY `fk_moneda` (`codmoneda`) USING BTREE,
  ADD KEY `fk_cliente` (`codcliente`) USING BTREE,
  ADD KEY `fk_serie` (`idserie`) USING BTREE,
  ADD KEY `fk_emisor` (`idemisor`) USING BTREE,
  ADD KEY `ventas` (`correlativo`),
  ADD KEY `id_nc` (`id_nc`),
  ADD KEY `id_nd` (`id_nd`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`Id_Zona`),
  ADD KEY `FK_zona_HabilitacionUrbana` (`Id_Habilitacion_Urbana`),
  ADD KEY `FK_zona_distrito` (`Id_Distrito`);

--
-- Indices de la tabla `zona_catastro`
--
ALTER TABLE `zona_catastro`
  ADD PRIMARY KEY (`id_zona_catastro`);

--
-- Indices de la tabla `zona_rural`
--
ALTER TABLE `zona_rural`
  ADD PRIMARY KEY (`Id_zona_rural`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anio`
--
ALTER TABLE `anio`
  MODIFY `Id_Anio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2018;

--
-- AUTO_INCREMENT de la tabla `anio_antiguedad`
--
ALTER TABLE `anio_antiguedad`
  MODIFY `Id_Anio_Antiguedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `arancel`
--
ALTER TABLE `arancel`
  MODIFY `Id_Arancel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `arancel_rustico`
--
ALTER TABLE `arancel_rustico`
  MODIFY `Id_Arancel_Rustico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `arancel_rustico_hectarea`
--
ALTER TABLE `arancel_rustico_hectarea`
  MODIFY `Id_Arancel_Rustico_Hectarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `arancel_vias`
--
ALTER TABLE `arancel_vias`
  MODIFY `Id_Arancel_Vias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `arbitrios`
--
ALTER TABLE `arbitrios`
  MODIFY `Id_Arbitrios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `Id_Area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `base_imponible`
--
ALTER TABLE `base_imponible`
  MODIFY `Id_Baseimponible` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calidad_agricola`
--
ALTER TABLE `calidad_agricola`
  MODIFY `Id_Calidad_Agricola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `catastro`
--
ALTER TABLE `catastro`
  MODIFY `Id_Catastro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `catastro_rural`
--
ALTER TABLE `catastro_rural`
  MODIFY `Id_Catastro_Rural` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `Id_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clasificacion_contribuyente`
--
ALTER TABLE `clasificacion_contribuyente`
  MODIFY `Id_Clasificacion_Contribuyente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clasificacion_piso`
--
ALTER TABLE `clasificacion_piso`
  MODIFY `Id_Clasificacion_Piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `colindante_denominacion`
--
ALTER TABLE `colindante_denominacion`
  MODIFY `Id_Colindante_Denominacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `colindante_propietario`
--
ALTER TABLE `colindante_propietario`
  MODIFY `Id_Colindante_Propietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `condicion_catastral`
--
ALTER TABLE `condicion_catastral`
  MODIFY `Id_Condicion_Catastral` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `condicion_contribuyente`
--
ALTER TABLE `condicion_contribuyente`
  MODIFY `Id_Condicion_Contribuyente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `condicion_predio`
--
ALTER TABLE `condicion_predio`
  MODIFY `Id_Condicion_Predio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `condicion_predio_fiscal`
--
ALTER TABLE `condicion_predio_fiscal`
  MODIFY `Id_Condicon_Predio_Fiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `Id_Configuraciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contribuyente`
--
ALTER TABLE `contribuyente`
  MODIFY `Id_Contribuyente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuadra`
--
ALTER TABLE `cuadra`
  MODIFY `Id_cuadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cuotas_vencimiento`
--
ALTER TABLE `cuotas_vencimiento`
  MODIFY `Id_Cuotas_Vencimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuotas_vencimiento_impuesto`
--
ALTER TABLE `cuotas_vencimiento_impuesto`
  MODIFY `Id_Cuotas_Vencimiento_Impuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `denominacion_rural`
--
ALTER TABLE `denominacion_rural`
  MODIFY `Id_Denominacion_Rural` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  MODIFY `Id_depreciacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `descuento`
--
ALTER TABLE `descuento`
  MODIFY `Id_Descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_cotizaciones`
--
ALTER TABLE `detalle_cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_eliminar`
--
ALTER TABLE `detalle_eliminar`
  MODIFY `Id_Detalle_Eliminar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  MODIFY `Id_Detalle_Transferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `Id_Direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `documento_inscripcion`
--
ALTER TABLE `documento_inscripcion`
  MODIFY `Id_Documento_Inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `edificacion_piso`
--
ALTER TABLE `edificacion_piso`
  MODIFY `Id_Edificacion_Piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT de la tabla `emisor`
--
ALTER TABLE `emisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  MODIFY `idenvio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  MODIFY `iddetalle` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especie_valorada`
--
ALTER TABLE `especie_valorada`
  MODIFY `Id_Especie_Valorada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_conservacion`
--
ALTER TABLE `estado_conservacion`
  MODIFY `Id_Estado_Conservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_cuenta_corriente`
--
ALTER TABLE `estado_cuenta_corriente`
  MODIFY `Id_Estado_Cuenta_Impuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1041;

--
-- AUTO_INCREMENT de la tabla `estado_predio`
--
ALTER TABLE `estado_predio`
  MODIFY `Id_Estado_Predio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `financiamiento`
--
ALTER TABLE `financiamiento`
  MODIFY `Id_financiamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `formula_impuesto`
--
ALTER TABLE `formula_impuesto`
  MODIFY `Id_Formula_Impuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `gastos_emision`
--
ALTER TABLE `gastos_emision`
  MODIFY `Id_Gastos_Emision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `giro_comercial`
--
ALTER TABLE `giro_comercial`
  MODIFY `Id_Giro_Comercial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `giro_establecimiento`
--
ALTER TABLE `giro_establecimiento`
  MODIFY `Id_Giro_Establecimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupo_tierra`
--
ALTER TABLE `grupo_tierra`
  MODIFY `Id_Grupo_Tierra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `guia`
--
ALTER TABLE `guia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_detalle`
--
ALTER TABLE `guia_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habilitaciones_urbanas`
--
ALTER TABLE `habilitaciones_urbanas`
  MODIFY `Id_Habilitacion_Urbana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `inafecto`
--
ALTER TABLE `inafecto`
  MODIFY `Id_inafecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ingresos_tributos`
--
ALTER TABLE `ingresos_tributos`
  MODIFY `Id_Ingresos_Tributos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instrumento_gestion`
--
ALTER TABLE `instrumento_gestion`
  MODIFY `Id_Instrumento_Gestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lado`
--
ALTER TABLE `lado`
  MODIFY `Id_Lado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `manzana`
--
ALTER TABLE `manzana`
  MODIFY `Id_Manzana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `material_piso`
--
ALTER TABLE `material_piso`
  MODIFY `Id_Material_Piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `Id_Nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nombre_arbitrios`
--
ALTER TABLE `nombre_arbitrios`
  MODIFY `Id_Nombre_Arbitrio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nombre_via`
--
ALTER TABLE `nombre_via`
  MODIFY `Id_Nombre_Via` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_credito_detalle`
--
ALTER TABLE `nota_credito_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_debito`
--
ALTER TABLE `nota_debito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_debito_detalle`
--
ALTER TABLE `nota_debito_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_credito`
--
ALTER TABLE `pago_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parametro`
--
ALTER TABLE `parametro`
  MODIFY `Id_Parametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `parque_distancia`
--
ALTER TABLE `parque_distancia`
  MODIFY `Id_Parque_Distancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pisos`
--
ALTER TABLE `pisos`
  MODIFY `Id_Piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT de la tabla `piso_predio`
--
ALTER TABLE `piso_predio`
  MODIFY `Id_Piso_Predio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `predio`
--
ALTER TABLE `predio`
  MODIFY `Id_Predio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  MODIFY `Id_Presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `propietario`
--
ALTER TABLE `propietario`
  MODIFY `Id_Propietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `regimen_afecto`
--
ALTER TABLE `regimen_afecto`
  MODIFY `Id_Regimen_Afecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reporte_financiamiento`
--
ALTER TABLE `reporte_financiamiento`
  MODIFY `Id_Reporte_Financiamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `Id_Sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `situacion_cuadra`
--
ALTER TABLE `situacion_cuadra`
  MODIFY `Id_Situacion_Cuadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tasa_arbitrio`
--
ALTER TABLE `tasa_arbitrio`
  MODIFY `Id_Tasa_Arbitrio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tim`
--
ALTER TABLE `tim`
  MODIFY `Id_TIM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `tipo_contribuyente`
--
ALTER TABLE `tipo_contribuyente`
  MODIFY `Id_Tipo_Contribuyente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tipo_documento_siat`
--
ALTER TABLE `tipo_documento_siat`
  MODIFY `Id_Tipo_Documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_escritura`
--
ALTER TABLE `tipo_escritura`
  MODIFY `Id_Tipo_Escritura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipo_predio`
--
ALTER TABLE `tipo_predio`
  MODIFY `Id_Tipo_Predio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `tipo_terreno`
--
ALTER TABLE `tipo_terreno`
  MODIFY `Id_Tipo_Terreno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_via`
--
ALTER TABLE `tipo_via`
  MODIFY `Id_Tipo_Via` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transferencia_predios`
--
ALTER TABLE `transferencia_predios`
  MODIFY `Id_Transferencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubica_via_urbano`
--
ALTER TABLE `ubica_via_urbano`
  MODIFY `Id_Ubica_Vias_Urbano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ubigeo_departamento_siat`
--
ALTER TABLE `ubigeo_departamento_siat`
  MODIFY `Id_Departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubigeo_distrito_siat`
--
ALTER TABLE `ubigeo_distrito_siat`
  MODIFY `Id_Distrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubigeo_provincial_siat`
--
ALTER TABLE `ubigeo_provincial_siat`
  MODIFY `Id_Provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `uit`
--
ALTER TABLE `uit`
  MODIFY `Id_UIT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `uso_predio`
--
ALTER TABLE `uso_predio`
  MODIFY `Id_Uso_Predio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `uso_terreno`
--
ALTER TABLE `uso_terreno`
  MODIFY `Id_Uso_Terreno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `valores_categoria_x_hectarea`
--
ALTER TABLE `valores_categoria_x_hectarea`
  MODIFY `Id_valores_categoria_x_hectarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `valores_edificacion`
--
ALTER TABLE `valores_edificacion`
  MODIFY `Id_Valores_Edificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `Id_Zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `zona_catastro`
--
ALTER TABLE `zona_catastro`
  MODIFY `id_zona_catastro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `zona_rural`
--
ALTER TABLE `zona_rural`
  MODIFY `Id_zona_rural` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arancel`
--
ALTER TABLE `arancel`
  ADD CONSTRAINT `FK_arancel_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `arancel_rustico`
--
ALTER TABLE `arancel_rustico`
  ADD CONSTRAINT `FK_arancelRustico_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `arancel_rustico_hectarea`
--
ALTER TABLE `arancel_rustico_hectarea`
  ADD CONSTRAINT `FK_arancelRustico_Hectarea` FOREIGN KEY (`Id_Arancel_Rustico`) REFERENCES `arancel_rustico` (`Id_Arancel_Rustico`),
  ADD CONSTRAINT `FK_arancelRustico_valoresCategoriaxhectarea` FOREIGN KEY (`Id_valores_categoria_x_hectarea`) REFERENCES `valores_categoria_x_hectarea` (`Id_valores_categoria_x_hectarea`);

--
-- Filtros para la tabla `arancel_vias`
--
ALTER TABLE `arancel_vias`
  ADD CONSTRAINT `FK_arancelVias_arancel` FOREIGN KEY (`Id_Arancel`) REFERENCES `arancel` (`Id_Arancel`),
  ADD CONSTRAINT `FK_arancelVias_ubicaViasUrbano` FOREIGN KEY (`Id_Ubica_Vias_Urbano`) REFERENCES `ubica_via_urbano` (`Id_Ubica_Vias_Urbano`);

--
-- Filtros para la tabla `base_imponible`
--
ALTER TABLE `base_imponible`
  ADD CONSTRAINT `FK_Contribuyente_Baseimponible` FOREIGN KEY (`Id_Contribuyente`) REFERENCES `contribuyente` (`Id_Contribuyente`);

--
-- Filtros para la tabla `catastro`
--
ALTER TABLE `catastro`
  ADD CONSTRAINT `Predio_Id_UbicavasUrbano` FOREIGN KEY (`Id_Ubica_Vias_Urbano`) REFERENCES `ubica_via_urbano` (`Id_Ubica_Vias_Urbano`);

--
-- Filtros para la tabla `catastro_rural`
--
ALTER TABLE `catastro_rural`
  ADD CONSTRAINT `fk_catastroRural_valores_categoria_x_hectarea` FOREIGN KEY (`Id_valores_categoria_x_hectarea`) REFERENCES `valores_categoria_x_hectarea` (`Id_valores_categoria_x_hectarea`);

--
-- Filtros para la tabla `colindante_denominacion`
--
ALTER TABLE `colindante_denominacion`
  ADD CONSTRAINT `fk_colindante_denominacion_denominacion_rural` FOREIGN KEY (`Id_Denominacion_Rural`) REFERENCES `denominacion_rural` (`Id_Denominacion_Rural`);

--
-- Filtros para la tabla `colindante_propietario`
--
ALTER TABLE `colindante_propietario`
  ADD CONSTRAINT `fk_colindantepropietarios_propietario` FOREIGN KEY (`Id_Propietario`) REFERENCES `propietario` (`Id_Propietario`);

--
-- Filtros para la tabla `contribuyente`
--
ALTER TABLE `contribuyente`
  ADD CONSTRAINT `R_22` FOREIGN KEY (`Id_Ubica_Vias_Urbano`) REFERENCES `ubica_via_urbano` (`Id_Ubica_Vias_Urbano`),
  ADD CONSTRAINT `R_23` FOREIGN KEY (`Id_Tipo_Contribuyente`) REFERENCES `tipo_contribuyente` (`Id_Tipo_Contribuyente`),
  ADD CONSTRAINT `R_24` FOREIGN KEY (`Id_Condicion_Predio_Fiscal`) REFERENCES `condicion_predio` (`Id_Condicion_Predio`),
  ADD CONSTRAINT `R_25` FOREIGN KEY (`Id_Clasificacion_Contribuyente`) REFERENCES `clasificacion_contribuyente` (`Id_Clasificacion_Contribuyente`),
  ADD CONSTRAINT `fk_condicion_predio_fiscal` FOREIGN KEY (`Id_Condicion_Predio_Fiscal`) REFERENCES `condicion_predio_fiscal` (`Id_Condicon_Predio_Fiscal`),
  ADD CONSTRAINT `fk_condicion_predio_fiscall` FOREIGN KEY (`Id_Condicion_Predio_Fiscal`) REFERENCES `condicion_predio_fiscal` (`Id_Condicon_Predio_Fiscal`),
  ADD CONSTRAINT `fk_contribuyente_condicion_contribuyente` FOREIGN KEY (`Id_Condicion_Contribuyente`) REFERENCES `condicion_contribuyente` (`Id_Condicion_Contribuyente`),
  ADD CONSTRAINT `fk_contribuyente_usuario1` FOREIGN KEY (`usuario_Id_Usuario`) REFERENCES `usuario` (`Id_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_tipo_documento` FOREIGN KEY (`Id_Tipo_Documento`) REFERENCES `tipo_documento_siat` (`Id_Tipo_Documento`);

--
-- Filtros para la tabla `cuotas_vencimiento`
--
ALTER TABLE `cuotas_vencimiento`
  ADD CONSTRAINT `cuotasvencimiento_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `cuotas_vencimiento_impuesto`
--
ALTER TABLE `cuotas_vencimiento_impuesto`
  ADD CONSTRAINT `fk_cuotasvencimientoimpuesto_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `denominacion_rural`
--
ALTER TABLE `denominacion_rural`
  ADD CONSTRAINT `fk_denominacionrural_zonarural` FOREIGN KEY (`Id_Zona_Rural`) REFERENCES `zona_rural` (`Id_zona_rural`);

--
-- Filtros para la tabla `depreciacion`
--
ALTER TABLE `depreciacion`
  ADD CONSTRAINT `R_18` FOREIGN KEY (`Id_Material_Piso`) REFERENCES `material_piso` (`Id_Material_Piso`),
  ADD CONSTRAINT `R_19` FOREIGN KEY (`Id_Clasificacion_Piso`) REFERENCES `clasificacion_piso` (`Id_Clasificacion_Piso`),
  ADD CONSTRAINT `R_20` FOREIGN KEY (`Id_Estado_Conservacion`) REFERENCES `estado_conservacion` (`Id_Estado_Conservacion`),
  ADD CONSTRAINT `fk_depreciacion_anioantiguedad` FOREIGN KEY (`Id_Anio_Antiguedad`) REFERENCES `anio_antiguedad` (`Id_Anio_Antiguedad`);

--
-- Filtros para la tabla `detalle_transferencia`
--
ALTER TABLE `detalle_transferencia`
  ADD CONSTRAINT `fk_detalletransferencia_documentoinscripcion` FOREIGN KEY (`Id_Documento_Inscripcion`) REFERENCES `documento_inscripcion` (`Id_Documento_Inscripcion`),
  ADD CONSTRAINT `fk_tipoescritura_documentoinscripcion` FOREIGN KEY (`Id_Tipo_Escritura`) REFERENCES `tipo_escritura` (`Id_Tipo_Escritura`);

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `FK_id_nombre_via_direccion_NombreVia` FOREIGN KEY (`Id_Nombre_Via`) REFERENCES `nombre_via` (`Id_Nombre_Via`),
  ADD CONSTRAINT `R_75` FOREIGN KEY (`Id_Tipo_Via`) REFERENCES `tipo_via` (`Id_Tipo_Via`),
  ADD CONSTRAINT `R_78` FOREIGN KEY (`Id_Zona`) REFERENCES `zona` (`Id_Zona`);

--
-- Filtros para la tabla `edificacion_piso`
--
ALTER TABLE `edificacion_piso`
  ADD CONSTRAINT `fk_valores_edificacion_pisos` FOREIGN KEY (`Id_Piso`) REFERENCES `pisos` (`Id_Piso`),
  ADD CONSTRAINT `fk_valoresedificacion_pisos` FOREIGN KEY (`Id_Valores_Edificacion`) REFERENCES `valores_edificacion` (`Id_Valores_Edificacion`);

--
-- Filtros para la tabla `especie_valorada`
--
ALTER TABLE `especie_valorada`
  ADD CONSTRAINT `FK_especievalorada_instrumentogestion` FOREIGN KEY (`Id_Instrumento_Gestion`) REFERENCES `instrumento_gestion` (`Id_Instrumento_Gestion`),
  ADD CONSTRAINT `R_8` FOREIGN KEY (`Id_Area`) REFERENCES `area` (`Id_Area`),
  ADD CONSTRAINT `R_9` FOREIGN KEY (`Id_Presupuesto`) REFERENCES `presupuesto` (`Id_Presupuesto`);

--
-- Filtros para la tabla `estado_cuenta_corriente`
--
ALTER TABLE `estado_cuenta_corriente`
  ADD CONSTRAINT `FK_estadocuentacorriente_descuento` FOREIGN KEY (`Id_Descuento`) REFERENCES `descuento` (`Id_Descuento`),
  ADD CONSTRAINT `R_49` FOREIGN KEY (`Id_Predio`) REFERENCES `predio` (`Id_Predio`),
  ADD CONSTRAINT `estado_cuenta_corriente_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id_Usuario`);

--
-- Filtros para la tabla `formula_impuesto`
--
ALTER TABLE `formula_impuesto`
  ADD CONSTRAINT `fk_formula_impuesto_UIT` FOREIGN KEY (`Id_UIT`) REFERENCES `uit` (`Id_UIT`),
  ADD CONSTRAINT `fk_formula_impuesto_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `ingresos_tributos`
--
ALTER TABLE `ingresos_tributos`
  ADD CONSTRAINT `R_54` FOREIGN KEY (`Id_Estado_Cuenta_Impuesto`) REFERENCES `estado_cuenta_corriente` (`Id_Estado_Cuenta_Impuesto`),
  ADD CONSTRAINT `R_63` FOREIGN KEY (`Id_Presupuesto`) REFERENCES `presupuesto` (`Id_Presupuesto`),
  ADD CONSTRAINT `R_66` FOREIGN KEY (`Id_financiamiento`) REFERENCES `financiamiento` (`Id_financiamiento`),
  ADD CONSTRAINT `R_67` FOREIGN KEY (`Id_Area`) REFERENCES `area` (`Id_Area`);

--
-- Filtros para la tabla `pisos`
--
ALTER TABLE `pisos`
  ADD CONSTRAINT `fk_Estado_Conservacion` FOREIGN KEY (`Id_Estado_Conservacion`) REFERENCES `estado_conservacion` (`Id_Estado_Conservacion`),
  ADD CONSTRAINT `fk_Id_Clasificacion_Piso` FOREIGN KEY (`Id_Clasificacion_Piso`) REFERENCES `clasificacion_piso` (`Id_Clasificacion_Piso`),
  ADD CONSTRAINT `fk_Id_Material_Piso` FOREIGN KEY (`Id_Material_Piso`) REFERENCES `material_piso` (`Id_Material_Piso`),
  ADD CONSTRAINT `fk_Id_Predio` FOREIGN KEY (`Id_Predio`) REFERENCES `predio` (`Id_Predio`);

--
-- Filtros para la tabla `piso_predio`
--
ALTER TABLE `piso_predio`
  ADD CONSTRAINT `fk_pisopredio_piso` FOREIGN KEY (`Id_Piso`) REFERENCES `pisos` (`Id_Piso`),
  ADD CONSTRAINT `fk_pisopredio_predio` FOREIGN KEY (`Id_Predio`) REFERENCES `predio` (`Id_Predio`);

--
-- Filtros para la tabla `predio`
--
ALTER TABLE `predio`
  ADD CONSTRAINT `Predio_detallePredio` FOREIGN KEY (`Id_Catastro`) REFERENCES `catastro` (`Id_Catastro`),
  ADD CONSTRAINT `R_27` FOREIGN KEY (`Id_Tipo_Predio`) REFERENCES `tipo_predio` (`Id_Tipo_Predio`),
  ADD CONSTRAINT `R_28` FOREIGN KEY (`Id_Uso_Predio`) REFERENCES `uso_predio` (`Id_Uso_Predio`),
  ADD CONSTRAINT `R_29` FOREIGN KEY (`Id_Giro_Establecimiento`) REFERENCES `giro_establecimiento` (`Id_Giro_Establecimiento`),
  ADD CONSTRAINT `R_30` FOREIGN KEY (`Id_Estado_Predio`) REFERENCES `estado_predio` (`Id_Estado_Predio`),
  ADD CONSTRAINT `R_31` FOREIGN KEY (`Id_Regimen_Afecto`) REFERENCES `regimen_afecto` (`Id_Regimen_Afecto`),
  ADD CONSTRAINT `R_32` FOREIGN KEY (`Id_inafecto`) REFERENCES `inafecto` (`Id_inafecto`),
  ADD CONSTRAINT `R_33` FOREIGN KEY (`Id_Arbitrios`) REFERENCES `arbitrios` (`Id_Arbitrios`),
  ADD CONSTRAINT `R_34` FOREIGN KEY (`Id_Condicion_Predio`) REFERENCES `condicion_predio` (`Id_Condicion_Predio`),
  ADD CONSTRAINT `R_35` FOREIGN KEY (`Id_Sesion`) REFERENCES `sesion` (`Id_Sesion`),
  ADD CONSTRAINT `detallePredio_Anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`),
  ADD CONSTRAINT `fk_predio_colindante_propietario` FOREIGN KEY (`Id_Colindante_Propietario`) REFERENCES `colindante_propietario` (`Id_Colindante_Propietario`),
  ADD CONSTRAINT `fk_predio_colindantedenominacion` FOREIGN KEY (`Id_Colindante_Denominacion`) REFERENCES `colindante_denominacion` (`Id_Colindante_Denominacion`),
  ADD CONSTRAINT `fk_predio_denominacionRural` FOREIGN KEY (`Id_Denominacion_Rural`) REFERENCES `denominacion_rural` (`Id_Denominacion_Rural`),
  ADD CONSTRAINT `fk_predio_tipoterreno` FOREIGN KEY (`Id_Tipo_Terreno`) REFERENCES `tipo_terreno` (`Id_Tipo_Terreno`),
  ADD CONSTRAINT `fk_predio_uso_terreno` FOREIGN KEY (`Id_Uso_Terreno`) REFERENCES `uso_terreno` (`Id_Uso_Terreno`),
  ADD CONSTRAINT `fk_tabla_predio_catastrorural` FOREIGN KEY (`Id_Catastro_Rural`) REFERENCES `catastro_rural` (`Id_Catastro_Rural`),
  ADD CONSTRAINT `predio_catastro` FOREIGN KEY (`Id_Catastro`) REFERENCES `catastro` (`Id_Catastro`);

--
-- Filtros para la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD CONSTRAINT `R_64` FOREIGN KEY (`Id_financiamiento`) REFERENCES `financiamiento` (`Id_financiamiento`);

--
-- Filtros para la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD CONSTRAINT `fk_propietario_detalleeliminar` FOREIGN KEY (`Id_Detalle_Eliminar`) REFERENCES `detalle_eliminar` (`Id_Detalle_Eliminar`),
  ADD CONSTRAINT `fk_propietario_detalletransferencia` FOREIGN KEY (`Id_Detalle_Transferencia`) REFERENCES `detalle_transferencia` (`Id_Detalle_Transferencia`),
  ADD CONSTRAINT `propietario_contribuyente` FOREIGN KEY (`Id_Contribuyente`) REFERENCES `contribuyente` (`Id_Contribuyente`),
  ADD CONSTRAINT `propietario_predio` FOREIGN KEY (`Id_Predio`) REFERENCES `predio` (`Id_Predio`);

--
-- Filtros para la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `R_5` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id_Usuario`);

--
-- Filtros para la tabla `tasa_arbitrio`
--
ALTER TABLE `tasa_arbitrio`
  ADD CONSTRAINT `FK_Tasaarbitrio_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`),
  ADD CONSTRAINT `FK_Tasaarbitrio_categoriaarbitrio` FOREIGN KEY (`Id_Arbitrios`) REFERENCES `arbitrios` (`Id_Arbitrios`),
  ADD CONSTRAINT `FK_Tasaarbitrio_nombrearbitrio` FOREIGN KEY (`Id_Nombre_Arbitrio`) REFERENCES `nombre_arbitrios` (`Id_Nombre_Arbitrio`);

--
-- Filtros para la tabla `transferencia_predios`
--
ALTER TABLE `transferencia_predios`
  ADD CONSTRAINT `R_37` FOREIGN KEY (`Id_Predio`) REFERENCES `predio` (`Id_Predio`),
  ADD CONSTRAINT `R_39` FOREIGN KEY (`Id_Contribuyente`) REFERENCES `contribuyente` (`Id_Contribuyente`),
  ADD CONSTRAINT `R_42` FOREIGN KEY (`Id_Sesion`) REFERENCES `sesion` (`Id_Sesion`);

--
-- Filtros para la tabla `ubica_via_urbano`
--
ALTER TABLE `ubica_via_urbano`
  ADD CONSTRAINT `FK_id_ladoUbicaviaurbano_lado` FOREIGN KEY (`Id_Lado`) REFERENCES `lado` (`Id_Lado`),
  ADD CONSTRAINT `FK_ubicaViaUrbano_Manzana` FOREIGN KEY (`Id_Manzana`) REFERENCES `manzana` (`Id_Manzana`),
  ADD CONSTRAINT `FK_ubicaViaUrbano_zonaCatastro` FOREIGN KEY (`Id_Zona_Catastro`) REFERENCES `zona_catastro` (`id_zona_catastro`),
  ADD CONSTRAINT `FK_ubicaviaurbano_condicioncatastral` FOREIGN KEY (`Id_Condicion_Catastral`) REFERENCES `condicion_catastral` (`Id_Condicion_Catastral`),
  ADD CONSTRAINT `FK_ubicaviaurbano_cuadra` FOREIGN KEY (`Id_Cuadra`) REFERENCES `cuadra` (`Id_cuadra`),
  ADD CONSTRAINT `FK_ubicaviaurbano_parquedistancia` FOREIGN KEY (`Id_Parque_Distancia`) REFERENCES `parque_distancia` (`Id_Parque_Distancia`),
  ADD CONSTRAINT `FK_ubicaviaurbano_situacionciadra` FOREIGN KEY (`Id_Situacion_Cuadra`) REFERENCES `situacion_cuadra` (`Id_Situacion_Cuadra`),
  ADD CONSTRAINT `R_76` FOREIGN KEY (`Id_Direccion`) REFERENCES `direccion` (`Id_Direccion`);

--
-- Filtros para la tabla `ubigeo_distrito_siat`
--
ALTER TABLE `ubigeo_distrito_siat`
  ADD CONSTRAINT `FK_distrito_provincia` FOREIGN KEY (`id_Provincia`) REFERENCES `ubigeo_provincial_siat` (`Id_Provincia`);

--
-- Filtros para la tabla `ubigeo_provincial_siat`
--
ALTER TABLE `ubigeo_provincial_siat`
  ADD CONSTRAINT `FK_ubigeoprovincial_departamento` FOREIGN KEY (`Id_Departamento`) REFERENCES `ubigeo_departamento_siat` (`Id_Departamento`);

--
-- Filtros para la tabla `uit`
--
ALTER TABLE `uit`
  ADD CONSTRAINT `fk_uit_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `R_69` FOREIGN KEY (`Id_Nivel`) REFERENCES `nivel` (`Id_Nivel`),
  ADD CONSTRAINT `R_71` FOREIGN KEY (`Id_Area`) REFERENCES `area` (`Id_Area`);

--
-- Filtros para la tabla `valores_categoria_x_hectarea`
--
ALTER TABLE `valores_categoria_x_hectarea`
  ADD CONSTRAINT `fk_valorescategoriaxhectarea_zonarural` FOREIGN KEY (`Id_Zona_Rural`) REFERENCES `zona_rural` (`Id_zona_rural`),
  ADD CONSTRAINT `valores_categoria_x_hectarea_calidad_agricola` FOREIGN KEY (`Id_Calidad_Agricola`) REFERENCES `calidad_agricola` (`Id_Calidad_Agricola`),
  ADD CONSTRAINT `valores_categoria_x_hectarea_grupo_tierra` FOREIGN KEY (`Id_Grupo_Tierra`) REFERENCES `grupo_tierra` (`Id_Grupo_Tierra`);

--
-- Filtros para la tabla `valores_edificacion`
--
ALTER TABLE `valores_edificacion`
  ADD CONSTRAINT `fk_valoresedificacion_anio` FOREIGN KEY (`Id_Anio`) REFERENCES `anio` (`Id_Anio`),
  ADD CONSTRAINT `fk_valoresedificacion_categoria` FOREIGN KEY (`Id_Categoria`) REFERENCES `categoria` (`Id_Categoria`),
  ADD CONSTRAINT `fk_valoresedificacion_parametro` FOREIGN KEY (`Id_Parametro`) REFERENCES `parametro` (`Id_Parametro`);

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `FK_zona_HabilitacionUrbana` FOREIGN KEY (`Id_Habilitacion_Urbana`) REFERENCES `habilitaciones_urbanas` (`Id_Habilitacion_Urbana`),
  ADD CONSTRAINT `FK_zona_distrito` FOREIGN KEY (`Id_Distrito`) REFERENCES `ubigeo_distrito_siat` (`Id_Distrito`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

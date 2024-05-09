-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2024 a las 18:58:55
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
-- Base de datos: `lacteos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asunto`
--

CREATE TABLE `asunto` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) DEFAULT 'Sin descripcion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asunto`
--

INSERT INTO `asunto` (`Id`, `nombre`, `descripcion`) VALUES
(1, 'Reclamo', 'Reclamo sobre la calidad del producto'),
(2, 'Información', 'Consulta sobre el estado del pedido'),
(3, 'Pedido', 'Información sobre un pedido'),
(4, 'Contabilidad', 'Información sobre la contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(150) DEFAULT 'sin descripcion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Id`, `nombre`, `descripcion`) VALUES
(1, 'Lácteos', 'Productos derivados de la leche'),
(3, 'Quesos', 'Variedad de quesos de diferentes países'),
(5, 'Yogurt', 'Yogures de leche entera'),
(6, 'Chiquigurt', 'Yogures para los pequeños placeres'),
(7, 'Cereal', 'Cereal'),
(8, 'Gelatina', 'Galatina'),
(9, 'Lonchera', 'Lonchera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `Id` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `mensaje` varchar(200) NOT NULL,
  `calificacion` decimal(3,1) DEFAULT 5.0,
  `tiempo` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`Id`, `fk_producto`, `fk_cliente`, `mensaje`, `calificacion`, `tiempo`) VALUES
(5, 11, 4, 'Un sabor muy rico', 4.5, '2024-05-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `Id` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  `fk_pedido` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`Id`, `fk_cliente`, `fk_producto`, `fk_pedido`, `cantidad`, `valor`) VALUES
(11, 4, 11, 6, 3, 21000),
(12, 4, 12, 6, 1, 2850),
(13, 4, 20, 6, 7, 3000),
(14, 4, 22, 6, 1, 2700),
(15, 4, 29, 6, 1, 12000),
(16, 1, 11, 7, 1, 21000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `Id` int(11) NOT NULL,
  `fk_asunto` int(11) NOT NULL,
  `fk_cliente` int(11) DEFAULT NULL,
  `mensaje` varchar(400) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`Id`, `fk_asunto`, `fk_cliente`, `mensaje`, `titulo`, `nombre`, `empresa`, `telefono`, `correo`, `estado`) VALUES
(1, 2, NULL, 'Como los puedo contactar para un evento de 200 personas', 'titulo', 'jose', '', '4654646', 'jh64@asga.com', 1),
(2, 4, 5, 'lorem asdasdew asdwaasd', 'Consulta de la contabilidad', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `Id` int(11) NOT NULL,
  `fk_pedido` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'Pendiente',
  `tiempo` datetime DEFAULT NULL,
  `total` int(50) NOT NULL,
  `iva` float DEFAULT 0.19
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`Id`, `fk_pedido`, `estado`, `tiempo`, `total`, `iva`) VALUES
(5, 6, 'Pendiente', NULL, 101550, 0.19),
(6, 7, 'Pendiente', NULL, 21000, 0.19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion`
--

CREATE TABLE `identificacion` (
  `Id` int(11) NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `identificacion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `identificacion`
--

INSERT INTO `identificacion` (`Id`, `tipo`, `identificacion`) VALUES
(1, 'CC', 'Cedula ciudadania'),
(2, 'TI', 'Tarjeta de identidad'),
(3, 'CE', 'Cédula de extranjerí'),
(4, 'PA', 'Pasaporte'),
(5, 'PEP', 'Permiso Especial de ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `Id` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT '0',
  `codigo` varchar(100) NOT NULL,
  `tiempo` datetime NOT NULL DEFAULT current_timestamp(),
  `detalles` varchar(150) DEFAULT 'Sin detalles del pedido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`Id`, `estado`, `codigo`, `tiempo`, `detalles`) VALUES
(6, 'Pendiente', '663cfd9f5b4610.18623641', '2024-05-09 11:45:19', 'Sin detalles del pedido'),
(7, 'Pendiente', '663cffe71ef525.04760316', '2024-05-09 11:55:03', 'Sin detalles del pedido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT 'Sin descripcion',
  `precio` int(11) NOT NULL,
  `imagen` varchar(100) DEFAULT 'product_default.png',
  `existencias` int(11) DEFAULT 10,
  `cantidad_contenido` varchar(10) NOT NULL,
  `oferta` bit(1) NOT NULL DEFAULT b'0',
  `descuento` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Id`, `nombre`, `descripcion`, `precio`, `imagen`, `existencias`, `cantidad_contenido`, `oferta`, `descuento`) VALUES
(11, 'Garrafa de yogurt de melocotón', 'Garrafa de yogurt con sabor a melocotón de 4 litros', 21000, '663cf586dee821.00518943.jpeg', 100, '4L', b'0', 0),
(12, 'Yogurt con masmelos', 'Yogurt personal con masmelos', 3000, '663ce63f5f9e48.72676955.jpeg', 100, '130ml', b'1', 0.05),
(15, 'Combo yogurt  masmelos y gomas', 'Combo pague 4 lleve 5 de yogures de masmelos y gomas', 10000, '663ce83ed71ad3.81693946.jpeg', 100, '650ml', b'0', 0),
(16, 'Yogurt con gomas', 'Yogurt personal con gomas', 3000, '663cf5a4a1e7b4.19713390.jpeg', 100, '130ml', b'0', 0),
(17, 'Yogurt con cereal de arroz achocolatado', 'Yogurt personal acompañado con cereal de arroz achocolatado', 4000, '663ce95cd096a7.77272310.jpeg', 100, '170ml', b'1', 0.05),
(18, 'Yogurt con hojuelas de maíz azucaradas', 'Yogurt personal acompañado con cereal de maíz azucaradas ', 4000, '663ce9d37e3a03.73850711.jpeg', 100, '170ml', b'1', 0.05),
(19, 'Yogurt con aritos de maíz frutados', 'Yogurt personal acompañado con aritos de maíz frutados', 4000, '663cea5904db31.66782222.jpeg', 100, '170ml', b'0', 0),
(20, 'Yogurt en bolsa personal de sabor a mora', 'Yogurt personal de mora en bolsa', 3000, '663ceace8d5af8.80455775.jpeg', 100, '150ml', b'0', 0),
(21, 'Yogurt en bolsa personal de sabor a melocotón', 'Yogurt personal en bolsa de melocotón', 3000, '663ceb510a6513.43157001.jpeg', 100, '150ml', b'0', 0),
(22, 'Yogurt en bolsa personal de sabor a guanábana', 'Yogurt personal en bolsa sabor guanábana', 3000, '663cebc6650f78.30782369.jpeg', 100, '150ml', b'1', 0.1),
(23, 'Yogurt en bolsa personal de sabor a fresa', 'Yogurt personal de bolsa con sabor a fresa', 3000, '663cec08997e26.76109934.jpeg', 100, '150ml', b'0', 0),
(24, 'Lonchería', 'Pack surtido de seis yogures personales en bolsa.\r\n', 18000, '663ceca5931765.08921196.jpeg', 100, '900ml', b'1', 0.22),
(25, 'Yogurt garrafa sabor mora', 'Yogurt de garrafa de 4 litros sabor a mora', 21000, '663ced03c56b30.82732337.jpeg', 100, '4L', b'0', 0),
(26, 'Yogurt garrafa sabor a fresa', 'Yogurt de garrafa de 4 litros sabor a fresa', 21000, '663ced4e21fdb4.94811332.jpeg', 100, '4L', b'0', 0),
(27, 'Yogurt garrafa sabor guanábana', 'Yogurt de garrafa de 4 litros sabor a guanábana', 21000, '663ceda0a178b7.80581987.jpeg', 100, '4L', b'1', 0.3),
(28, 'Chiquigurt 12 unidades', 'Pack de 12 chiquigurt surtido', 20000, '663cef1797bf50.97621297.jpeg', 100, '1.2L', b'1', 0.3),
(29, 'Chiquigurt 6 unidades', 'Pack de 6 chiquigurt surtido', 12000, '663ceed40a16d0.89976494.jpeg', 100, '600ml', b'0', 0),
(30, 'Chiquigurt de mora', 'Chiquigurt personal de mora', 2000, '663cef5c3d1ef2.74095722.jpeg', 100, '100ml', b'0', 0),
(31, 'Chiquigurt de melocotón', 'Chiquigurt personal de melocotón', 2000, '663cefc0c689e2.99850983.jpeg', 100, '100ml', b'0', 0),
(32, 'Chiquigurt de fresa', 'Chiquigurt de fresa', 2000, '663ceffd237211.17153446.jpeg', 100, '100ml', b'0', 0),
(33, 'Queso con Bocadillo', 'Paquete de 4 unidades de queso con bocadillo', 6000, '663cf0b7d565f0.67894115.png', 100, '600g', b'0', 0),
(34, 'Bolsa de yogures', 'Pack de 14 yogures personales en bolsa', 20000, '663cf19a9e5da2.14308308.png', 100, '2.1L', b'1', 0.2),
(35, 'Kumis con cereal de 6 unidades', 'Pack de 6 unidades de kumis acompañados con cereal ', 18000, '663cf254d80392.96785271.png', 100, '680ml', b'1', 0.02),
(36, 'Queso molido tipo costeño ', 'Queso molido fresco semigraso duro tipo costeño ', 6000, '663cf2ec0f4f60.66383997.png', 100, '1000g', b'0', 0),
(37, 'Peritas', 'Queso tipo pera dividido en 6 unidades', 12000, '663cf377d28914.79754748.png', 100, '700g', b'0', 0),
(38, 'Combo yogurt con masmelos y gomas paquete de 5 unidades', 'Paquete 5 unidades yogurt masmelos y gomitas', 15000, '663cf411f07118.82596152.png', 100, '650gr', b'1', 0.03),
(39, 'Paquete de 5 unidades de gelatina', 'Pack de 5 gelatinas de sabores surtidos mas 1 de obsequio', 12000, '663cf4b091cfc7.17816855.png', 100, '1k', b'0', 0),
(40, 'Paquete de 5 yogures personales en baso', 'Paquete de 5 yogures de baso personales con sabor variado ', 12500, '663cf5599b2f77.13412273.png', 100, '1L', b'1', 0.05);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `Id` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  `fk_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto_categoria`
--

INSERT INTO `producto_categoria` (`Id`, `fk_producto`, `fk_categoria`) VALUES
(17, 12, 5),
(18, 12, 7),
(19, 15, 5),
(20, 15, 7),
(21, 15, 9),
(30, 17, 5),
(31, 17, 7),
(32, 17, 9),
(33, 18, 5),
(34, 18, 7),
(35, 18, 9),
(36, 19, 5),
(37, 19, 7),
(38, 19, 9),
(39, 20, 5),
(40, 20, 9),
(41, 21, 5),
(42, 21, 9),
(43, 22, 5),
(44, 22, 9),
(45, 23, 5),
(46, 23, 9),
(47, 24, 5),
(48, 24, 9),
(49, 25, 5),
(50, 26, 5),
(51, 27, 5),
(55, 29, 5),
(56, 29, 6),
(57, 29, 9),
(61, 28, 5),
(62, 28, 6),
(63, 28, 9),
(64, 30, 5),
(65, 30, 6),
(66, 30, 9),
(67, 31, 5),
(68, 31, 6),
(69, 31, 9),
(70, 32, 5),
(71, 32, 6),
(72, 32, 9),
(73, 33, 3),
(74, 34, 5),
(75, 34, 9),
(76, 35, 5),
(77, 35, 7),
(78, 36, 3),
(79, 37, 3),
(80, 38, 5),
(81, 38, 7),
(82, 39, 8),
(83, 39, 9),
(84, 40, 5),
(85, 40, 9),
(86, 11, 5),
(87, 16, 5),
(88, 16, 7),
(89, 16, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id`, `nombre`) VALUES
(2, 'Administrador'),
(1, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`Id`, `nombre`) VALUES
(2, 'Persona Jurídica'),
(1, 'Persona Natural');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `movil` varchar(20) NOT NULL,
  `fk_identificacion` int(11) NOT NULL,
  `identificacion` varchar(20) NOT NULL,
  `contrasena` varchar(10) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fk_rol` int(11) NOT NULL DEFAULT 1,
  `fk_tipo_persona` int(11) NOT NULL DEFAULT 1,
  `empresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `nombre`, `email`, `movil`, `fk_identificacion`, `identificacion`, `contrasena`, `direccion`, `fecha_nacimiento`, `fk_rol`, `fk_tipo_persona`, `empresa`) VALUES
(1, 'Juan Pérez', 'juan@example.com', '1234567890', 1, '14589674526', 'password', 'Calle 123', NULL, 1, 1, NULL),
(2, 'María Gómez', 'maria@example.com', '0987654321', 2, '', 'password', 'Avenida 456', NULL, 1, 2, NULL),
(3, 'Carlos López', 'carlos@example.com', '5678901234', 3, '', 'password12', 'Carrera 789', NULL, 1, 1, NULL),
(4, 'Ana Rodríguez', 'ana@example.com', '6789012345', 4, '', 'securepass', 'Diagonal 012', NULL, 2, 2, NULL),
(5, 'Pedro Martínez', 'pedro@example.com', '7890123456', 5, '', 'pass1234', 'Plaza 345', NULL, 2, 1, NULL),
(6, 'Laura Sánchez', 'laura@example.com', '8901234567', 1, '', 'password12', 'Calle 678', NULL, 1, 2, NULL),
(7, 'Diego Ramírez', 'diego@example.com', '9012345678', 1, '', 'dieram2023', 'Avenida 901', NULL, 1, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asunto`
--
ALTER TABLE `asunto`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_comentario_fk_producto` (`fk_producto`),
  ADD KEY `idx_comentario_fk_cliente` (`fk_cliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_compra_fk_cliente` (`fk_cliente`),
  ADD KEY `idx_compra_fk_producto` (`fk_producto`),
  ADD KEY `fk_pedido` (`fk_pedido`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_consulta_fk_asunto` (`fk_asunto`),
  ADD KEY `idx_consulta_fk_cliente` (`fk_cliente`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_factura_fk_pedido` (`fk_pedido`);

--
-- Indices de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD KEY `idx_identificacion_tipo` (`tipo`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_pedido_estado` (`estado`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `idx_producto_existencias` (`existencias`);

--
-- Indices de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_producto_categoria_fk_producto` (`fk_producto`),
  ADD KEY `idx_producto_categoria_fk_categoria` (`fk_categoria`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuario_email` (`email`),
  ADD KEY `idx_usuario_fk_identificacion` (`fk_identificacion`),
  ADD KEY `idx_usuario_fk_rol` (`fk_rol`),
  ADD KEY `idx_usuario_fk_tipo_persona` (`fk_tipo_persona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asunto`
--
ALTER TABLE `asunto`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`fk_cliente`) REFERENCES `usuario` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`fk_cliente`) REFERENCES `usuario` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`fk_pedido`) REFERENCES `pedido` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`fk_asunto`) REFERENCES `asunto` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`fk_cliente`) REFERENCES `usuario` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`fk_pedido`) REFERENCES `pedido` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_identificacion`) REFERENCES `identificacion` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`fk_rol`) REFERENCES `rol` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`fk_tipo_persona`) REFERENCES `tipo` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

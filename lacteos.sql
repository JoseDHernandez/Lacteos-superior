-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2024 a las 04:48:26
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
(3, 'Quesos', 'Variedad de quesos de diferentes países');

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
(1, 1, 1, 'Es un buen yogur', 4.0, '2024-05-06'),
(2, 1, 1, 'Es un buen yogur', 5.0, '2024-05-03'),
(3, 1, 1, 'Es un buen yogur', 5.0, '2024-05-06'),
(4, 1, 1, 'No me gusto mucho su sabor', 2.4, '2024-05-06');

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
(1, 2, NULL, 'sadasdasdasdad', 'titulo', 'jose', '', '4654646', 'jh64@asga.com', 1),
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
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
(1, 'Yogur natural', 'Yogur natural descremado', 500, 'product_default.png', 1000, '100 g', b'0', 0),
(2, 'Queso Mozarella', 'Queso mozzarella italiano', 3000, 'product_default.png', 500, '1 kg', b'0', 0),
(3, 'Mermelada de fresa', 'Mermelada de fresa casera', 7000, 'product_default.png', 300, '250 g', b'1', 0),
(4, 'Yogur de frutas', 'Yogur de frutas variadas', 1500, 'product_default.png', 800, '150 g', b'0', 0),
(5, 'Queso Gouda', 'Queso gouda holandés', 4000, 'product_default.png', 700, '500 g', b'0', 0),
(6, 'Mantequilla con sal', 'Mantequilla con sal añadida', 2500, 'product_default.png', 900, '200 g', b'0', 0.2),
(7, 'Kumis light', 'Kumis light deslactosado', 2000, 'product_default.png', 1200, '200 ml', b'0', 0);

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
(1, 1, 1),
(2, 2, 3),
(4, 4, 1),
(5, 5, 3),
(6, 6, 1),
(7, 7, 1);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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

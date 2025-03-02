-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 22:16:20
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(6, 'Viento'),
(8, 'Percusión'),
(9, 'Cuerda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int(255) NOT NULL,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `categoria_id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) NOT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(4, 9, 'Violin', 'prueba5', 50.00, 5, 'no', '2025-03-02', 'violin_1.jpg'),
(5, 8, 'Bombo', 'prueba5', 10.00, 2, 'no', '2025-03-02', 'bombo_1.jpg'),
(10, 6, 'Flauta', 'flauta de metal', 25.00, 15, 'no', '2025-03-02', 'flauta_1.jpg'),
(11, 9, 'Viola', 'viola de madera', 60.00, 3, 'no', '2025-03-02', 'viola_1.jpg'),
(12, 9, 'Guitarra Española', 'guitarra española', 35.00, 2, 'no', '2025-03-02', 'guitarra_1.jpg'),
(13, 9, 'Guitarra Eléctrica', 'guitarra electrica', 55.00, 7, 'no', '2025-03-02', 'guitarra_2.jpg'),
(14, 8, 'Set de percusión', 'tambores, bombos y platillos', 90.00, 5, 'no', '2025-03-02', 'tambor_1.jpg'),
(15, 8, 'Set de percusión PRO', 'set de percusión profesional ', 160.00, 8, 'no', '2025-03-02', 'tambor_2.jpg'),
(16, 8, 'Set de percusión AMATEUR', 'set de percusión para principiantes', 70.00, 4, 'no', '2025-03-02', 'tambor_3.jpg'),
(17, 6, 'Trompeta', 'trompeta de latón', 20.00, 9, 'no', '2025-03-02', 'trompeta_1.jpg'),
(18, 6, 'Trompeta PRO', 'trompeta de profesional', 50.00, 9, 'no', '2025-03-02', 'trompeta_2.jpg'),
(19, 6, 'Saxofón', 'Saxofón de latón', 90.00, 7, 'no', '2025-03-02', 'saxofon_1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `imagen`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', 'contraseña', 'admin', NULL),
(7, 'Chotos', 'cruz Chotil', 'chotos@gmail.com', '$2y$04$YB7VW0MkqZQZt8nSbxuFOunpmJEKVsRMaRahzJAOOAXi4dxb3MQPe', 'user', NULL),
(10, 'Ambrtosio', 'Cruz Garcia', 'pepefarolaenterprise@gmail.com', '$2y$04$2Tq5XaJJT.68PVV5s..J2uH1TDl/cVUHweEcxMI2qN/1qVwWXuTam', 'user', NULL),
(11, 'Antonio', 'Cruz Garcia', 'acg.purullena@gmail.com', '$2y$04$Tun7aauCjC3AJ1uLW.bYZ.Wv1THBauf/4IrbsXaPLwaPBEM9kRgpm', 'admin', NULL),
(13, 'Pedro', 'Matulos', 'pedros@gmail.com', '$2y$04$RYRF6uWHgAdRyj83x9QwRe86fqNJvl3VrUF7G2PG4xOlXTn8C1F3K', 'user', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_linea_pedido` (`pedido_id`),
  ADD KEY `fk_linea_producto` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_linea_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

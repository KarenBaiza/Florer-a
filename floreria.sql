-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2024 a las 04:17:59
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
-- Base de datos: `floreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arreglos`
--

CREATE TABLE `arreglos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arreglos`
--

INSERT INTO `arreglos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'Rosas en tonos rosas y lilas', 'Rosas en tonos rosas y lilas', 1200.00, 'imag5.jpg'),
(2, 'Rosas elegantes', 'Rosas elegantes', 1000.00, 'ima2.jpeg'),
(3, 'Rosas elegantes', 'Ramo elegante', 600.00, 'ima3.jpeg'),
(4, 'Ramo elegante', 'Ramo de 50 peonias.', 990.00, 'ima4.jpeg'),
(5, 'Ramo elegante', 'Ramo tonos cafés', 600.00, 'ima5.jpeg'),
(6, 'Ramo elegante', 'Ramo elegante', 500.00, 'ima6.jpeg'),
(7, 'Ramo elegante', 'Ramo lindo con variedad de flores.', 1000.00, 'ima3.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fechahora_entrega` datetime NOT NULL,
  `estado` enum('pendiente','aceptado','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `nombre`, `direccion`, `email`, `metodo_pago`, `id_usuario`, `fechahora_entrega`, `estado`) VALUES
(4, 'Prueba Compra', 'Calle 123', 'cecy@gmail.com', 'PayPal', 4, '2024-12-05 10:00:00', 'rechazado'),
(12, 'Cecilia', 'Froylan curz manjarrez', 'cecy@gmail.com', 'Transferencia', 4, '2024-12-06 15:00:00', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `arreglo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_usuario` enum('admin','usuario') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `tipo_usuario`, `email`, `password`) VALUES
(1, 'Administrador', 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70'),
(2, 'Karen Baiza', 'admin', 'baizakaren77@gmail.com', '$2y$10$j4S9r90XCHayiTIQCxlzqe9hGdAF39WLJC11EvZd2r9nxRk94K2Fm'),
(4, 'Cecilia', 'usuario', 'cecy@gmail.com', '$2y$10$2yuNzwmQMH0EsQ4hco2CnOj5Mke8/7hoa3T3yZwz42I4s4f/WLGnq');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arreglos`
--
ALTER TABLE `arreglos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `arreglo_id` (`arreglo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arreglos`
--
ALTER TABLE `arreglos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`arreglo_id`) REFERENCES `arreglos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

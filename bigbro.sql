-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2024 a las 07:36:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bigbro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `detalles` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migraciones`
--

CREATE TABLE `migraciones` (
  `id` int(11) NOT NULL,
  `nombre_migracion` varchar(255) NOT NULL,
  `fecha_ejecucion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre_permiso` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `estado_civil` varchar(50) NOT NULL,
  `telefono_personal` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono_contacto` varchar(15) DEFAULT NULL,
  `hijos` varchar(50) DEFAULT NULL,
  `curso_sucamec` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_nacimiento` date NOT NULL,
  `fecha_ingreso_bb` date NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `unidad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `nombres`, `apellidos`, `dni`, `estado_civil`, `telefono_personal`, `direccion`, `telefono_contacto`, `hijos`, `curso_sucamec`, `fecha_nacimiento`, `fecha_ingreso_bb`, `cargo`, `observaciones`, `foto`, `fecha_creacion`, `fecha_actualizacion`, `activo`, `unidad_id`) VALUES
(1, 'Elvis Enriquee', 'Chacon Pajuelo', '72125367', 'Municipalidad Metropolitana de Lima', '925346522', 'Ca orfebres Mz. F Lote 19', '929621048', 'Ninguno', 'Activo', '2001-08-16', '2020-02-20', 'AVP con arma', 'Ingles Completo', 'Kame house.jpg', '2024-09-15 18:59:04', '2024-09-17 08:01:33', 1, 1),
(2, 'Jose', 'Iglesias Reyes', '8765432', 'Casado', '987654123', 'San Juan de Lurigancho', '987456321', 'Con 5 hijos', 'Inactivo', '1990-09-02', '2023-09-20', 'AVP sin arma', 'Conocimiento de Ingles y Computo Completo', 'image.png', '2024-09-15 19:07:03', '2024-09-17 12:08:06', 1, 3),
(3, 'Armando', 'Torres Julca', '01234567', 'Divorciado', '963852741', 'San Borja', '987412365', 'Tiene 20 hijos', 'Activo', '2000-12-29', '2024-09-15', 'AVP', 'Tiene estudios en ensamblaje', 'foto - copia (2).jpg', '2024-09-15 22:58:47', '2024-09-17 08:12:57', 1, 3),
(4, 'Elsa', 'Rodriguez', '9876541', 'Viuda', '951789321', 'Villa el Salvador', '01789456', '0', 'Activo', '1980-09-05', '2019-07-12', 'Ejecutiva', 'Ninguna', 'Tokito.jpg', '2024-09-16 03:42:49', '2024-09-17 08:07:35', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_actividad`
--

CREATE TABLE `registros_actividad` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `detalles` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_tareas`
--

CREATE TABLE `registros_tareas` (
  `id` int(11) NOT NULL,
  `tarea_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restablecimientos_contrasena`
--

CREATE TABLE `restablecimientos_contrasena` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `token_restablecimiento` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Administrador', 'Rol con acceso completo al sistema', '2024-08-27 06:04:27', '2024-08-27 06:04:27'),
(2, 'Usuario', 'Rol con acceso limitado al sistema', '2024-08-27 06:04:27', '2024-08-27 06:04:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `permiso_id` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `token_sesion` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `nombre_tarea` varchar(100) NOT NULL,
  `descripcion_tarea` text DEFAULT NULL,
  `asignado_a` int(11) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` enum('Pendiente','En Progreso','Completada') DEFAULT 'Pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `ruc_dni` varchar(20) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `rubro` varchar(100) NOT NULL,
  `encargado_seguridad` varchar(100) NOT NULL,
  `telf_encargado` varchar(20) DEFAULT NULL,
  `fijo_encargado` varchar(20) DEFAULT NULL,
  `segundo_contacto` varchar(100) DEFAULT NULL,
  `telf_scontacto` varchar(20) DEFAULT NULL,
  `fijo_scontacto` varchar(20) DEFAULT NULL,
  `puesto_vigilancia` varchar(100) DEFAULT NULL,
  `comisaria` varchar(100) DEFAULT NULL,
  `serenazgo` varchar(100) DEFAULT NULL,
  `bomberos` varchar(100) DEFAULT NULL,
  `samu` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `razon_social`, `ruc_dni`, `direccion`, `rubro`, `encargado_seguridad`, `telf_encargado`, `fijo_encargado`, `segundo_contacto`, `telf_scontacto`, `fijo_scontacto`, `puesto_vigilancia`, `comisaria`, `serenazgo`, `bomberos`, `samu`, `observaciones`, `foto`, `fecha_creacion`, `fecha_actualizacion`, `activo`) VALUES
(1, 'Almacen 1', '123456789', 'Av Los cedros Miraflores', 'Almacenaje', 'Jeancarlo Lazo', '1234567', '1234567', '23468890', '234567890\'', '123456780', '321432123', '23456789', '98765432', '116', '106', 'Prueba', '1390395126.jpg', '2024-09-17 04:10:51', '2024-09-17 05:22:20', 1),
(2, 'Curtis & Co', '2050601215', 'San Juan de Lurigancho', 'Distribcuion', 'Jeancarlo Lazo', '1234567', '1234567', '23468890', '234567890\'', '123456780', '321432123', '23456789', '98765432', '116', '106', 'Observaciones', '1390395126.jpg', '2024-09-17 04:11:02', '2024-09-17 08:10:05', 1),
(3, 'Operaciones BigBro', '10721253673', 'Calle Canebaro', 'Seguridad', 'Jose Orlando', '987654321', '017865432', 'Matias Nieva', '963258741', '01652314', '985123647', '105', '155', '105', '122', 'Observaciones', 'preview-LP-empresas-de-seguridad-lima-verisure-peru.jpg', '2024-09-17 05:04:52', '2024-09-17 05:22:24', 1),
(4, 'Centro de Convernciones Lima', '2050124528', 'Centro Civico', 'Gubernamental', 'Anderson Pacheco', '987654123', '01575789', 'Luis Anders', '987456321', '01652314', '987453210', '105', '128', '122', '107', 'Es parte del Gobierno', 'Centro de convern.jpg', '2024-09-17 05:26:57', '2024-09-17 05:26:57', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `nombre`, `apellido`, `nombre_usuario`, `contrasena`, `correo_electronico`, `telefono`, `rol_id`, `fecha_creacion`, `fecha_actualizacion`, `activo`) VALUES
(1, '87654321', 'Administrador', 'Uno', 'admin', '$2y$10$kfDG5xn82ZEvDG7f40j9dOG1LTbhz.RFdvBCInYtmnWOEAkfzSoRq', 'admin@bigbro.com', '987654321', 1, '2024-08-27 06:04:27', '2024-09-15 23:07:05', 1),
(2, '98765432', 'Usuario', 'Uno', 'user', '$2y$10$XAL4UrGKrrk.o67fX0DvSOnWfF4dSM74ei.2XlgBMD79W0ItLqHMy', 'user@bigbbro.com', '987654320', 2, '2024-09-09 04:10:30', '2024-09-15 19:15:39', 1),
(3, '23456789', 'Administrador', 'Dos', 'admin2', '$2y$10$RFZ4IdSDFcPU.HCdtZYy/eTZboAkhBg2kkhcU/oCiaGnK3VBAu0s2', 'admin2@bigbro.com', '987654322', 1, '2024-09-09 04:20:34', '2024-09-15 19:15:43', 1),
(4, '8765412', 'Usuario', 'Dos', 'user2', '$2y$10$CASRm4xZbA/JyfBQ6nhAt.AndI7OSvjMxLipEv3XQJbEoaOej/AbG', 'user2@bigbro.com', '987654123', 2, '2024-09-11 06:38:54', '2024-09-15 19:15:47', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `migraciones`
--
ALTER TABLE `migraciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personal_unidad` (`unidad_id`);

--
-- Indices de la tabla `registros_actividad`
--
ALTER TABLE `registros_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `registros_tareas`
--
ALTER TABLE `registros_tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarea_id` (`tarea_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `restablecimientos_contrasena`
--
ALTER TABLE `restablecimientos_contrasena`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_restablecimiento` (`token_restablecimiento`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `permiso_id` (`permiso_id`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_sesion` (`token_sesion`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unidad_id` (`unidad_id`),
  ADD KEY `asignado_a` (`asignado_a`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD UNIQUE KEY `dni` (`dni`) USING BTREE,
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migraciones`
--
ALTER TABLE `migraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `registros_actividad`
--
ALTER TABLE `registros_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros_tareas`
--
ALTER TABLE `registros_tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `restablecimientos_contrasena`
--
ALTER TABLE `restablecimientos_contrasena`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_personal_unidad` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`);

--
-- Filtros para la tabla `registros_actividad`
--
ALTER TABLE `registros_actividad`
  ADD CONSTRAINT `registros_actividad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registros_tareas`
--
ALTER TABLE `registros_tareas`
  ADD CONSTRAINT `registros_tareas_ibfk_1` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registros_tareas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `restablecimientos_contrasena`
--
ALTER TABLE `restablecimientos_contrasena`
  ADD CONSTRAINT `restablecimientos_contrasena_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `roles_permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_permisos_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`asignado_a`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

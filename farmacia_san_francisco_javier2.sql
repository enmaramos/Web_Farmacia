-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 00:36:27
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
-- Base de datos: `farmacia_san_francisco_javier2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `IdPedido` int(11) DEFAULT NULL,
  `IdBodega` int(11) NOT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `ID_Bodega` int(11) NOT NULL,
  `Cantidad_Med_Estante` int(11) DEFAULT NULL,
  `Cantidad_Med_Exhibicion` int(11) DEFAULT NULL,
  `Cantidad_Total_Bodega` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre_Categoria` varchar(150) DEFAULT NULL,
  `Descripcion` varchar(150) DEFAULT NULL,
  `estado_categoria` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `Nombre_Categoria`, `Descripcion`, `estado_categoria`) VALUES
(1, 'Antibióticos', 'Medicamentos para tratar infecciones bacterianas', 0),
(2, 'Analgésicos', 'Medicamentos para aliviar el dolor', 1),
(3, 'Antiinflamatorios', 'Medicamentos para reducir la inflamación', 1),
(4, 'Antihistamínicos', 'Medicamentos para tratar alergias', 1),
(5, 'Antidiabéticos', 'Medicamentos para controlar la diabetes', 1),
(6, 'Vitaminas', 'Suplementos vitamínicos para diversas funciones del cuerpo', 1),
(7, 'Antipiréticos', 'Medicamentos para reducir la fiebre', 1),
(8, 'Antidepresivos', 'Medicamentos para tratar trastornos depresivos', 1),
(9, 'Higiene', 'Cuidado del bienestar y la salud de todas las personas.', 1),
(10, 'Radiofármacos', 'Medicamentos que contienen isótopos radiactivos, usados principalmente en procedimientos de diagnóstico por imágenes y tratamientos oncológicos.', 1),
(12, 'Ectoparasiticidas', 'Productos usados para eliminar parásitos externos como piojos, pulgas y garrapatas.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(25) DEFAULT NULL,
  `Apellido` varchar(25) DEFAULT NULL,
  `Genero` enum('Masculino','Femenino') DEFAULT 'Masculino',
  `Direccion` varchar(50) DEFAULT NULL,
  `Telefono` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT current_timestamp(),
  `Cedula` varchar(20) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `Nombre`, `Apellido`, `Genero`, `Direccion`, `Telefono`, `Email`, `Fecha_Nacimiento`, `Fecha_Registro`, `Cedula`, `Estado`) VALUES
(62, 'Juan', 'Perez', 'Masculino', 'Calle 1, No. 23', '12345678', 'juan.perez@email.com', '1985-07-15', '2025-03-31 18:36:54', '001-123625-1010W', 1),
(63, 'Maria', 'Lopez', 'Femenino', 'Calle 2, No. 10', '23456789', 'maria.lopez@email.com', '1990-03-22', '2025-03-31 18:36:54', '001-234567-1020X', 1),
(64, 'Carlos', 'Martinez', 'Masculino', 'Calle 3, No. 34', '34567890', 'carlos.martinez@email.com', '1982-11-10', '2025-03-31 18:36:54', '001-345678-1030Y', 1),
(65, 'Ana', 'Gonzalez', 'Femenino', 'Calle 4, No. 45', '45678901', 'ana.gonzalez@email.com', '1995-05-30', '2025-03-31 18:36:54', '001-456789-1040Z', 1),
(66, 'Luis', 'Rodriguez', 'Masculino', 'Calle 5, No. 50', '56789012', 'luis.rodriguez@email.com', '1988-02-19', '2025-03-31 18:36:54', '001-567890-1050W', 1),
(67, 'Sofia', 'Perez', 'Femenino', 'Calle 6, No. 60', '67890123', 'sofia.perez@email.com', '1993-09-09', '2025-03-31 18:36:54', '001-678901-1060X', 1),
(68, 'Andres', 'Martinez', 'Masculino', 'Calle 7, No. 70', '78901234', 'andres.martinez@email.com', '1980-12-05', '2025-03-31 18:36:54', '001-789012-1070Y', 1),
(69, 'Lucia', 'Hernandez', 'Femenino', 'Calle 8, No. 80', '89012345', 'lucia.hernandez@email.com', '1992-06-18', '2025-03-31 18:36:54', '001-890123-1080Z', 1),
(70, 'Ricardo', 'Lopez', 'Masculino', 'Calle 9, No. 90', '90123456', 'ricardo.lopez@email.com', '1987-01-30', '2025-03-31 18:36:54', '001-901234-1090W', 1),
(71, 'Valentina', 'Garcia', 'Femenino', 'Calle 10, No. 100', '11223344', 'valentina.garcia@email.com', '2000-04-25', '2025-03-31 18:36:54', '001-112233-1100X', 1),
(89, 'Cliente ', 'Aleatorio', 'Masculino', 'Batahola', '00000000', 'Batahola@gmail.com', '2000-04-25', '2025-03-31 00:00:00', '000-000000-0000X', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_venta`
--

CREATE TABLE `detalle_factura_venta` (
  `ID_Detalle_FV` int(11) NOT NULL,
  `ID_FacturaV` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_Unitario` decimal(10,2) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL,
  `ID_Forma_Farmaceutica` int(11) DEFAULT NULL,
  `ID_Dosis` int(11) DEFAULT NULL,
  `ID_Presentacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `ID_FacturaC` int(11) NOT NULL,
  `Descripcion_Compra` varchar(300) DEFAULT NULL,
  `Fecha_Emision` datetime DEFAULT NULL,
  `Estado_Pedido` varchar(100) DEFAULT NULL,
  `Subtotal_Fact_Comp` float DEFAULT NULL,
  `Iva_Fact_Comp` float DEFAULT NULL,
  `Total_Fact_Comp` float DEFAULT NULL,
  `ID_Proveedor` int(11) DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_venta`
--

CREATE TABLE `factura_venta` (
  `ID_FacturaV` int(11) NOT NULL,
  `Numero_Factura` varchar(20) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Metodo_Pago` varchar(50) DEFAULT 'Efectivo',
  `Subtotal` double DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `Monto_Pagado` decimal(10,2) DEFAULT NULL,
  `Cambio` decimal(10,2) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_venta`
--

INSERT INTO `factura_venta` (`ID_FacturaV`, `Numero_Factura`, `Fecha`, `Metodo_Pago`, `Subtotal`, `Total`, `Monto_Pagado`, `Cambio`, `ID_Cliente`, `ID_Usuario`) VALUES
(104, 'N505-0001', '2025-05-16 14:51:10', 'efectivo', 1.4, 1.4, 2.00, 0.00, 89, 5),
(105, 'N505-0002', '2025-05-16 14:52:15', 'efectivo', 40, 40, 50.00, 10.00, 89, 5),
(106, 'N505-0003', '2025-05-16 14:54:03', 'efectivo', 50, 50, 100.00, 50.00, 89, 5),
(107, 'N505-0004', '2025-05-16 14:57:29', 'efectivo', 100, 100, 100.00, 0.00, 89, 5),
(108, 'N505-0021', '2025-05-16 16:03:13', 'efectivo', 50, 50, 100.00, 50.00, 89, 5),
(109, 'N505-0024', '2025-05-16 16:21:43', 'efectivo', 50, 50, 100.00, 50.00, 89, 5),
(110, 'N505-0025', '2025-05-16 16:22:35', 'efectivo', 100, 100, 1000.00, 900.00, 89, 5),
(111, 'N505-0027', '2025-05-16 16:27:55', 'efectivo', 300, 300, 500.00, 200.00, 89, 5),
(112, 'N505-0029', '2025-05-16 16:35:03', 'efectivo', 100, 100, 100.00, 0.00, 89, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_farmaceutica_dosis`
--

CREATE TABLE `forma_farmaceutica_dosis` (
  `ID` int(11) NOT NULL,
  `ID_Forma_Farmaceutica` int(11) NOT NULL,
  `ID_Dosis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `forma_farmaceutica_dosis`
--

INSERT INTO `forma_farmaceutica_dosis` (`ID`, `ID_Forma_Farmaceutica`, `ID_Dosis`) VALUES
(1, 1, 8),
(2, 2, 9),
(3, 6, 8),
(4, 7, 9),
(5, 8, 9),
(6, 9, 8),
(8, 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `ID_Lote` int(11) NOT NULL,
  `Descripcion_Lote` varchar(250) DEFAULT NULL,
  `Estado_Lote` varchar(100) DEFAULT NULL,
  `Cantidad_Lote` int(11) DEFAULT NULL,
  `Fecha_Fabricacion_Lote` datetime DEFAULT NULL,
  `Fecha_Caducidad_Lote` datetime DEFAULT NULL,
  `Fecha_Emision_Lote` datetime DEFAULT NULL,
  `Fecha_Recibido_Lote` datetime DEFAULT NULL,
  `Prec_Unidad_Lote` float DEFAULT NULL,
  `Precio_Total_Lote` float DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  `Stock_Minimo_Lote` int(11) NOT NULL DEFAULT 0,
  `Stock_Maximo_Lote` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`ID_Lote`, `Descripcion_Lote`, `Estado_Lote`, `Cantidad_Lote`, `Fecha_Fabricacion_Lote`, `Fecha_Caducidad_Lote`, `Fecha_Emision_Lote`, `Fecha_Recibido_Lote`, `Prec_Unidad_Lote`, `Precio_Total_Lote`, `ID_Medicamento`, `Stock_Minimo_Lote`, `Stock_Maximo_Lote`) VALUES
(6, 'Lote A Amoxicilina', 'Activo', 1000, '2025-01-10 00:00:00', '2027-01-10 00:00:00', '2025-01-12 00:00:00', '2025-01-14 00:00:00', 5, 5000, 1, 20, 100),
(7, 'Lote A Eritromicina', 'Activo', 1200, '2025-02-10 00:00:00', '2027-02-10 00:00:00', '2025-02-12 00:00:00', '2025-02-14 00:00:00', 6, 7200, 21, 15, 120),
(8, 'Lote A Actimicina Bronquial', 'Activo', 800, '2025-03-10 00:00:00', '2027-03-10 00:00:00', '2025-03-12 00:00:00', '2025-03-14 00:00:00', 12, 9600, 24, 10, 80),
(9, 'Lote A Ibuprofeno', 'Activo', 900, '2025-04-10 00:00:00', '2027-04-10 00:00:00', '2025-04-12 00:00:00', '2025-04-14 00:00:00', 7, 6300, 27, 20, 150),
(10, 'Lote A Acetamenofen', 'Activo', 1000, '2025-05-10 00:00:00', '2027-05-10 00:00:00', '2025-05-12 00:00:00', '2025-05-14 00:00:00', 4, 4000, 28, 10, 100),
(11, 'Lote A Pampers', 'Activo', 500, '2025-01-10 00:00:00', '2027-01-10 00:00:00', '2025-01-12 00:00:00', '2025-01-14 00:00:00', 15, 7500, 30, 10, 20),
(12, 'Lote A Diclofenac Sodico', 'Activo', 700, '2025-06-10 00:00:00', '2027-06-10 00:00:00', '2025-06-12 00:00:00', '2025-06-14 00:00:00', 8, 5600, 33, 10, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotefact`
--

CREATE TABLE `lotefact` (
  `IdLote` int(11) DEFAULT NULL,
  `IdFacturaC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote_presentacion`
--

CREATE TABLE `lote_presentacion` (
  `ID_Lote_Presentacion` int(11) NOT NULL,
  `ID_Lote` int(11) NOT NULL,
  `ID_Presentacion` int(11) NOT NULL,
  `Cantidad_Presentacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote_presentacion`
--

INSERT INTO `lote_presentacion` (`ID_Lote_Presentacion`, `ID_Lote`, `ID_Presentacion`, `Cantidad_Presentacion`) VALUES
(23, 6, 18, 10),
(24, 6, 19, 50),
(25, 6, 20, 100),
(26, 7, 21, 10),
(27, 7, 22, 50),
(28, 7, 23, 100),
(29, 8, 24, 10),
(30, 8, 25, 50),
(31, 8, 26, 100),
(32, 9, 27, 10),
(33, 9, 28, 50),
(34, 9, 29, 100),
(35, 10, 30, 10),
(36, 10, 31, 50),
(37, 10, 32, 100),
(38, 11, 33, 10),
(39, 11, 34, 50),
(40, 11, 35, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `ID_Medicamento` int(11) NOT NULL,
  `Nombre_Medicamento` varchar(30) DEFAULT NULL,
  `LAB_o_MARCA` varchar(100) NOT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Descripcion_Medicamento` varchar(250) DEFAULT NULL,
  `Prescripcion_Medica` varchar(150) DEFAULT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Requiere_Receta` tinyint(1) DEFAULT 0,
  `Id_Proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`ID_Medicamento`, `Nombre_Medicamento`, `LAB_o_MARCA`, `Imagen`, `Descripcion_Medicamento`, `Prescripcion_Medica`, `IdCategoria`, `Estado`, `Requiere_Receta`, `Id_Proveedor`) VALUES
(1, 'Amoxicilina', 'Lab-Ramos', 'amoxicilina.jpg', 'Antibiótico de amplio espectro.', 'No requiere receta', 1, 1, 0, 1),
(21, 'Eritromicina', 'Lab-Ramos', 'eritromicina.jpg', 'Infeccion', 'Alergias', 2, 1, 0, 1),
(24, 'Actimicina Bronquial', 'Bayer', 'ActimicinaBronquial.jpg', 'Para Gripe', 'Gripe o Calentura', 4, 1, 0, 1),
(27, 'Ibuprofeno', 'Bayer', 'Ibuprofeno.jpg', 'Medicamento que se usa para tratar la fiebre, la hinchazón, el dolor y el enrojecimiento', 'En general, los adultos y niños mayores de 12 años pueden tomar el ibuprofeno de venta libre cada 4 a 6 horas', 5, 1, 0, 1),
(28, 'Acetamenofen ', 'Lab-Ramos', 'acetamenofen.jpg', 'Analgésico y antipirético, inhibidor de la síntesis de prostaglandinas periférica y central por acción sobre la ciclooxigenasa.', 'El acetaminofeno se usa para aliviar el dolor leve o moderado de las cefaleas, dolores musculares, períodos menstruales, resfriados, y los dolores de ', 5, 1, 0, 1),
(30, 'Pampers', 'Previal', 'pampers previal.jpg', 'Pañales para abulto', NULL, 8, 1, 0, 1),
(33, 'Diclofenac Sodico', 'COFARCA', 'Diclofenac Sodico.jpg', 'para aliviar el dolor y la inflamación en diversos procesos', 'Tratamiento del dolor agudo moderado a severo', 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_dosis`
--

CREATE TABLE `medicamento_dosis` (
  `ID_Dosis` int(11) NOT NULL,
  `Dosis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_dosis`
--

INSERT INTO `medicamento_dosis` (`ID_Dosis`, `Dosis`) VALUES
(8, '250mg'),
(9, '500mg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_forma_farmaceutica`
--

CREATE TABLE `medicamento_forma_farmaceutica` (
  `ID_Forma_Farmaceutica` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `Forma_Farmaceutica` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_forma_farmaceutica`
--

INSERT INTO `medicamento_forma_farmaceutica` (`ID_Forma_Farmaceutica`, `ID_Medicamento`, `Forma_Farmaceutica`) VALUES
(1, 1, 'tableta'),
(2, 1, 'capsula'),
(3, 30, 'Talla M'),
(5, 30, 'Talla S'),
(6, 21, 'Capsula'),
(7, 27, 'tableta'),
(8, 28, 'tableta'),
(9, 24, 'tableta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_presentacion`
--

CREATE TABLE `medicamento_presentacion` (
  `ID_Presentacion` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `Tipo_Presentacion` varchar(50) NOT NULL,
  `Total_Presentacion` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_presentacion`
--

INSERT INTO `medicamento_presentacion` (`ID_Presentacion`, `ID_Medicamento`, `Tipo_Presentacion`, `Total_Presentacion`, `Precio`) VALUES
(18, 1, 'Caja', 10, 50.00),
(19, 1, 'Sobre', 1, 5.00),
(20, 1, 'Unidad', 1, 0.50),
(21, 21, 'Caja', 10, 60.00),
(22, 21, 'Sobre', 1, 6.00),
(23, 21, 'Unidad', 1, 0.60),
(24, 24, 'Caja', 10, 100.00),
(25, 24, 'Sobre', 1, 12.00),
(26, 24, 'Unidad', 1, 2.00),
(27, 27, 'Caja', 10, 70.00),
(28, 27, 'Sobre', 1, 7.00),
(29, 27, 'Unidad', 1, 0.70),
(30, 28, 'Caja', 10, 40.00),
(31, 28, 'Sobre', 1, 4.00),
(32, 28, 'Unidad', 1, 0.40),
(33, 30, 'Bolsa', 5, 20.00),
(34, 30, 'Unidad', 1, 4.00),
(35, 33, 'Caja', 10, 80.00),
(36, 33, 'Sobre', 1, 8.00),
(37, 33, 'Unidad', 1, 0.80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertalote`
--

CREATE TABLE `ofertalote` (
  `IdProveedor` int(11) DEFAULT NULL,
  `IdLote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_Pedido` int(11) NOT NULL,
  `Descripcion_Pedido` varchar(100) DEFAULT NULL,
  `Fecha_Solicitud` datetime DEFAULT NULL,
  `Fecha_Recibo` datetime DEFAULT NULL,
  `Estado_Pedido` varchar(200) DEFAULT NULL,
  `IdVendedor` int(11) DEFAULT NULL,
  `IdFacturaV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_fact`
--

CREATE TABLE `pedido_fact` (
  `IdPedido` int(11) DEFAULT NULL,
  `IdFacturaC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Laboratorio` varchar(100) DEFAULT NULL,
  `Direccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `RUC` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Proveedor`, `Nombre`, `Laboratorio`, `Direccion`, `Telefono`, `Email`, `RUC`, `Estado`, `Fecha_Registro`) VALUES
(1, 'Derek', 'somoza', 'barrio milagro', '15415151', 'mcadavo@gamail', '3515645', 1, '2025-03-08 19:34:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provped`
--

CREATE TABLE `provped` (
  `IdPedido` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) DEFAULT NULL,
  `Descripcion_Rol` varchar(200) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_Rol`, `Nombre_Rol`, `Descripcion_Rol`, `Estado`) VALUES
(1, 'Administrador', 'Todos los Accesos', 1),
(2, 'Vendedor', 'Acceso limitado a funciones básicas', 1),
(3, 'Bodeguero', 'Acceso limitado a funciones básicas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suministro`
--

CREATE TABLE `suministro` (
  `IdMedicamento` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre_Usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Imagen` text DEFAULT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ID_Vendedor` int(11) DEFAULT NULL,
  `estado_usuario` tinyint(1) DEFAULT 1,
  `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ultimo_Acceso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombre_Usuario`, `Imagen`, `Password`, `ID_Vendedor`, `estado_usuario`, `Fecha_Creacion`, `Ultimo_Acceso`) VALUES
(1, 'Derek Jameson', 'avatar.png', 'Djsomoza31', 1, 1, '2025-03-08 19:22:06', '2025-05-14 23:08:59'),
(5, 'Nestor', NULL, '123456', 2, 1, '2025-03-08 20:08:10', '2025-05-16 20:40:02'),
(21, 'Emmanuel Serrano', 'meliodas.webp', '123456', 28, 1, '2025-03-08 22:49:51', '2025-05-13 19:50:20'),
(22, 'Francisco Perez', NULL, '123456', 29, 1, '2025-03-11 01:08:45', NULL),
(23, 'Gerson Sanchez', NULL, '123456', 33, 1, '2025-03-11 02:24:37', NULL),
(24, 'juanperez', NULL, 'miClave123', 34, 1, '2025-03-12 22:14:24', NULL),
(25, 'Luis Chavez', 'images.PNG', 'Chavez07', 36, 1, '2025-03-12 22:52:57', '2025-05-16 22:34:38'),
(26, 'Marcos Ramos', NULL, '123456', 37, 1, '2025-03-12 23:01:52', NULL),
(29, 'kenny Solis', '449310638_122108766050369563_655787570102137785_n.jpg', '1234567', 44, 1, '2025-03-20 00:24:18', NULL),
(30, 'Franklin Jiron', NULL, '123456', 45, 1, '2025-03-20 01:57:18', NULL),
(33, 'Pedro Serrano', NULL, '123456', 49, 1, '2025-04-14 02:24:46', '2025-05-13 19:58:27'),
(34, 'Mariela Jarquin', NULL, '123456', 50, 1, '2025-04-14 02:37:51', NULL),
(35, 'Andriws Serrano', NULL, '123456', 51, 0, '2025-04-15 03:00:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `ID_Vendedor` int(11) NOT NULL,
  `Nombre` varchar(70) DEFAULT NULL,
  `N_Cedula` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL CHECK (`Sexo` in ('H','M')),
  `Estado` tinyint(1) DEFAULT 1,
  `ID_Rol` int(11) DEFAULT NULL,
  `Apellido` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`ID_Vendedor`, `Nombre`, `N_Cedula`, `Telefono`, `Email`, `Direccion`, `Sexo`, `Estado`, `ID_Rol`, `Apellido`) VALUES
(1, 'Derek Jameson', '001-311001-1085U', '8601-8985', 'Djsomoza@gmail.com', 'Milagro de Dios', 'H', 1, 1, 'Somoza chavarrilla'),
(2, 'Nestor Gabriel', '001-233525-1211V', '1236-5487', 'AguirreCanales@gmail.com', 'Villa el carmen ', 'H', 1, 2, 'Aguirre Canales'),
(28, 'Emmanuel', '001-130901-1010W', '8868-8476', 'mcdavo1309@gmail.com', 'Vi.Venezuela Colegio Hispano Americano 1/2 C.O Casa #1993-94', 'H', 1, 2, 'Serrano Ramos'),
(29, 'Francisco jose', '001-122410-2541P', '1224-5876', 'franciscoperez@gmail.com', 'Masaya', 'H', 1, 2, 'Perez'),
(33, 'Gerson Ezequiel', '025-200504-2055X', '7523-6542', 'gersonsanchez@gmail.com', 'Cuidad Sandino', 'H', 1, 2, 'Sanchez Hernadez'),
(34, 'Juan', '001-220598-0001A', '8888-9999', 'juan@example.com', 'Calle 123, Ciudad X', 'H', 1, 2, 'Pérez'),
(36, 'Luis Eduardo', '001-563290-2045N', '8623-5412', 'LuisChavez@gmail.com', 'Cuidad Sandino', 'H', 1, 1, 'Chavez Mairena'),
(37, 'Marcos Orlando', '001-236292-6451S', '8856-2341', 'MarcoRamos21@gmail.com', 'Managua', 'H', 1, 2, 'Ramos Vado'),
(44, 'kenny Ivania', '001-958612-3526J', '8569-4512', 'kennysolis@gmail.com', 'Cristo Rey', 'M', 1, 2, 'Solis Ampie'),
(45, 'Franklin Randal', '001-365941-5623F', '5623-5412', 'FranklinJiron@gmail.com', 'managua', 'H', 1, 2, 'Jiron'),
(49, 'Pedro Anibal', '001-190571-1254H', '8898-0315', 'PedroSerrano@gamil.com', 'Vi. Venezuela, Colegio Hispano Americano½ C. O', 'H', 1, 3, 'Serrano'),
(50, 'Mariela Carolina', '001-011201-2356M', '5623-1547', 'MariJarquin@gmail.com', 'Vi. Venezuela, Colegio Hispano Americano½ C. O', 'M', 1, 1, 'Jarquin Rodriguez'),
(51, 'Andriws Anibal', '001-235648-7123B', '(+505) 214', 'Andriwsserrano@gmail.com', 'Vi.Venezuela Colegio Hispano Americano 1/2 C.O Casa #1993-94', 'H', 0, 3, 'Serrano Ramos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_medicamento`
--

CREATE TABLE `venta_medicamento` (
  `ID_Medicamento` int(11) DEFAULT NULL,
  `ID_FacturaV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdBodega` (`IdBodega`),
  ADD KEY `fk_almacen_medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`ID_Bodega`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `detalle_factura_venta`
--
ALTER TABLE `detalle_factura_venta`
  ADD PRIMARY KEY (`ID_Detalle_FV`),
  ADD KEY `ID_FacturaV` (`ID_FacturaV`),
  ADD KEY `ID_Medicamento` (`ID_Medicamento`),
  ADD KEY `ID_Forma_Farmaceutica` (`ID_Forma_Farmaceutica`),
  ADD KEY `ID_Dosis` (`ID_Dosis`),
  ADD KEY `ID_Presentacion` (`ID_Presentacion`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`ID_FacturaC`),
  ADD KEY `fk_factura_compra_proveedor` (`ID_Proveedor`),
  ADD KEY `fk_factura_compra_medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD PRIMARY KEY (`ID_FacturaV`),
  ADD UNIQUE KEY `Numero_Factura` (`Numero_Factura`),
  ADD UNIQUE KEY `Numero_Factura_2` (`Numero_Factura`),
  ADD KEY `fk_factura_venta_cliente` (`ID_Cliente`),
  ADD KEY `fk_factura_venta_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `forma_farmaceutica_dosis`
--
ALTER TABLE `forma_farmaceutica_dosis`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Forma_Farmaceutica` (`ID_Forma_Farmaceutica`),
  ADD KEY `ID_Dosis` (`ID_Dosis`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`ID_Lote`),
  ADD KEY `fk_lote_medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `lotefact`
--
ALTER TABLE `lotefact`
  ADD KEY `IdLote` (`IdLote`),
  ADD KEY `IdFacturaC` (`IdFacturaC`);

--
-- Indices de la tabla `lote_presentacion`
--
ALTER TABLE `lote_presentacion`
  ADD PRIMARY KEY (`ID_Lote_Presentacion`),
  ADD KEY `ID_Lote` (`ID_Lote`),
  ADD KEY `ID_Presentacion` (`ID_Presentacion`);

--
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`ID_Medicamento`),
  ADD KEY `IdCategoria` (`IdCategoria`),
  ADD KEY `fk_proveedor` (`Id_Proveedor`);

--
-- Indices de la tabla `medicamento_dosis`
--
ALTER TABLE `medicamento_dosis`
  ADD PRIMARY KEY (`ID_Dosis`);

--
-- Indices de la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  ADD PRIMARY KEY (`ID_Forma_Farmaceutica`),
  ADD KEY `ID_Medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `medicamento_presentacion`
--
ALTER TABLE `medicamento_presentacion`
  ADD PRIMARY KEY (`ID_Presentacion`),
  ADD KEY `ID_Medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `ofertalote`
--
ALTER TABLE `ofertalote`
  ADD KEY `IdProveedor` (`IdProveedor`),
  ADD KEY `IdLote` (`IdLote`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `IdVendedor` (`IdVendedor`),
  ADD KEY `fk_pedido_factura` (`IdFacturaV`);

--
-- Indices de la tabla `pedido_fact`
--
ALTER TABLE `pedido_fact`
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdFacturaC` (`IdFacturaC`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`);

--
-- Indices de la tabla `provped`
--
ALTER TABLE `provped`
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdProveedor` (`IdProveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_Rol`);

--
-- Indices de la tabla `suministro`
--
ALTER TABLE `suministro`
  ADD KEY `IdMedicamento` (`IdMedicamento`),
  ADD KEY `IdProveedor` (`IdProveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  ADD UNIQUE KEY `unique_vendedor` (`ID_Vendedor`),
  ADD KEY `ID_Vendedor` (`ID_Vendedor`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`ID_Vendedor`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `N_Cedula` (`N_Cedula`),
  ADD KEY `fk_rol` (`ID_Rol`);

--
-- Indices de la tabla `venta_medicamento`
--
ALTER TABLE `venta_medicamento`
  ADD KEY `IdMedicamento` (`ID_Medicamento`),
  ADD KEY `fk_venta_medicamento_factura` (`ID_FacturaV`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `detalle_factura_venta`
--
ALTER TABLE `detalle_factura_venta`
  MODIFY `ID_Detalle_FV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `ID_FacturaC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  MODIFY `ID_FacturaV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `forma_farmaceutica_dosis`
--
ALTER TABLE `forma_farmaceutica_dosis`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `ID_Lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `lote_presentacion`
--
ALTER TABLE `lote_presentacion`
  MODIFY `ID_Lote_Presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `ID_Medicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `medicamento_dosis`
--
ALTER TABLE `medicamento_dosis`
  MODIFY `ID_Dosis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  MODIFY `ID_Forma_Farmaceutica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `medicamento_presentacion`
--
ALTER TABLE `medicamento_presentacion`
  MODIFY `ID_Presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `ID_Vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`ID_Pedido`),
  ADD CONSTRAINT `almacen_ibfk_2` FOREIGN KEY (`IdBodega`) REFERENCES `bodega` (`ID_Bodega`),
  ADD CONSTRAINT `fk_almacen_bodega` FOREIGN KEY (`IdBodega`) REFERENCES `bodega` (`ID_Bodega`),
  ADD CONSTRAINT `fk_almacen_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`);

--
-- Filtros para la tabla `detalle_factura_venta`
--
ALTER TABLE `detalle_factura_venta`
  ADD CONSTRAINT `detalle_factura_venta_ibfk_1` FOREIGN KEY (`ID_FacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`),
  ADD CONSTRAINT `detalle_factura_venta_ibfk_2` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  ADD CONSTRAINT `detalle_factura_venta_ibfk_3` FOREIGN KEY (`ID_Forma_Farmaceutica`) REFERENCES `medicamento_forma_farmaceutica` (`ID_Forma_Farmaceutica`),
  ADD CONSTRAINT `detalle_factura_venta_ibfk_4` FOREIGN KEY (`ID_Dosis`) REFERENCES `medicamento_dosis` (`ID_Dosis`),
  ADD CONSTRAINT `detalle_factura_venta_ibfk_5` FOREIGN KEY (`ID_Presentacion`) REFERENCES `medicamento_presentacion` (`ID_Presentacion`);

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `fk_factura_compra_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  ADD CONSTRAINT `fk_factura_compra_proveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

--
-- Filtros para la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD CONSTRAINT `fk_factura_venta_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_venta_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `forma_farmaceutica_dosis`
--
ALTER TABLE `forma_farmaceutica_dosis`
  ADD CONSTRAINT `forma_farmaceutica_dosis_ibfk_1` FOREIGN KEY (`ID_Forma_Farmaceutica`) REFERENCES `medicamento_forma_farmaceutica` (`ID_Forma_Farmaceutica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forma_farmaceutica_dosis_ibfk_2` FOREIGN KEY (`ID_Dosis`) REFERENCES `medicamento_dosis` (`ID_Dosis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`);

--
-- Filtros para la tabla `lotefact`
--
ALTER TABLE `lotefact`
  ADD CONSTRAINT `lotefact_ibfk_1` FOREIGN KEY (`IdLote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lotefact_ibfk_2` FOREIGN KEY (`IdFacturaC`) REFERENCES `factura_compra` (`ID_FacturaC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lote_presentacion`
--
ALTER TABLE `lote_presentacion`
  ADD CONSTRAINT `lote_presentacion_ibfk_1` FOREIGN KEY (`ID_Lote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE,
  ADD CONSTRAINT `lote_presentacion_ibfk_2` FOREIGN KEY (`ID_Presentacion`) REFERENCES `medicamento_presentacion` (`ID_Presentacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`Id_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`ID_Categoria`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  ADD CONSTRAINT `medicamento_forma_farmaceutica_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicamento_presentacion`
--
ALTER TABLE `medicamento_presentacion`
  ADD CONSTRAINT `medicamento_presentacion_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ofertalote`
--
ALTER TABLE `ofertalote`
  ADD CONSTRAINT `ofertalote_ibfk_1` FOREIGN KEY (`IdLote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ofertalote_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_factura` FOREIGN KEY (`IdFacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`);

--
-- Filtros para la tabla `pedido_fact`
--
ALTER TABLE `pedido_fact`
  ADD CONSTRAINT `pedido_fact_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_fact_ibfk_2` FOREIGN KEY (`IdFacturaC`) REFERENCES `factura_compra` (`ID_FacturaC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `provped`
--
ALTER TABLE `provped`
  ADD CONSTRAINT `provped_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `provped_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `suministro`
--
ALTER TABLE `suministro`
  ADD CONSTRAINT `fk_suministro_proveedor` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  ADD CONSTRAINT `suministro_ibfk_1` FOREIGN KEY (`IdMedicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suministro_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_vendedor` FOREIGN KEY (`ID_Vendedor`) REFERENCES `vendedor` (`ID_Vendedor`);

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`);

--
-- Filtros para la tabla `venta_medicamento`
--
ALTER TABLE `venta_medicamento`
  ADD CONSTRAINT `fk_venta_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  ADD CONSTRAINT `fk_venta_medicamento_factura` FOREIGN KEY (`ID_FacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

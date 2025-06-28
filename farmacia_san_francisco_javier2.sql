-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2025 a las 01:13:27
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
  `ID_Almacen` int(11) NOT NULL,
  `ID_Bodega_Origen` int(11) NOT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  `ID_Estanteria_Destino` int(11) NOT NULL,
  `ID_Posicion_Destino` int(11) NOT NULL,
  `Cantidad_Trasladada` int(11) NOT NULL,
  `Fecha_Movimiento` datetime DEFAULT current_timestamp(),
  `Observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `ID_Bodega` int(11) NOT NULL,
  `Cantidad_Total_Bodega` int(11) DEFAULT NULL,
  `Stock_Minimo` int(11) DEFAULT 0,
  `Stock_Maximo` int(11) DEFAULT 0,
  `ID_Posicion` int(11) DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`ID_Bodega`, `Cantidad_Total_Bodega`, `Stock_Minimo`, `Stock_Maximo`, `ID_Posicion`, `ID_Medicamento`) VALUES
(2, 500, 100, 500, 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `ID_Caja` int(11) NOT NULL,
  `Cajero` varchar(100) NOT NULL,
  `Fecha_Hora` datetime NOT NULL,
  `Tipo` enum('apertura','cierre') NOT NULL,
  `Monto_Cordobas` decimal(10,2) DEFAULT NULL,
  `Monto_Dolares` decimal(10,2) DEFAULT NULL,
  `Observaciones` text DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Estado_Cierre` varchar(10) DEFAULT 'cuadra',
  `Diferencia` decimal(10,2) DEFAULT 0.00
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
-- Estructura de tabla para la tabla `detalle_caja`
--

CREATE TABLE `detalle_caja` (
  `ID_Detalle` int(11) NOT NULL,
  `ID_Caja` int(11) DEFAULT NULL,
  `Denominacion` varchar(20) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Moneda` enum('cordoba','dolar') NOT NULL,
  `Tipo` enum('billete','moneda') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `estanteria`
--

CREATE TABLE `estanteria` (
  `ID_Estanteria` int(11) NOT NULL,
  `Nombre_Estanteria` varchar(20) NOT NULL,
  `Cantidad_Filas` int(11) NOT NULL DEFAULT 1,
  `Cantidad_Columnas` int(11) NOT NULL DEFAULT 1,
  `SubFilas` int(11) NOT NULL DEFAULT 1,
  `SubColumnas` int(11) NOT NULL DEFAULT 1,
  `Tipo_Estanteria` enum('Bodega','Sala') NOT NULL DEFAULT 'Sala'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estanteria`
--

INSERT INTO `estanteria` (`ID_Estanteria`, `Nombre_Estanteria`, `Cantidad_Filas`, `Cantidad_Columnas`, `SubFilas`, `SubColumnas`, `Tipo_Estanteria`) VALUES
(2, 'Estante A', 3, 3, 2, 3, 'Sala'),
(3, 'Estante A', 3, 3, 2, 3, 'Bodega'),
(4, 'Estanteria Prueba', 4, 3, 1, 2, 'Sala'),
(6, 'Estanteria Prueba 3', 2, 2, 1, 1, 'Bodega');

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
  `Fecha` datetime DEFAULT current_timestamp(),
  `Metodo_Pago` varchar(50) DEFAULT 'Efectivo',
  `Subtotal` decimal(10,2) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Monto_Pagado` varchar(20) DEFAULT NULL,
  `Cambio` varchar(20) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Caja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `ID_Laboratorio` int(11) NOT NULL,
  `Nombre_Laboratorio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `laboratorio`
--

INSERT INTO `laboratorio` (`ID_Laboratorio`, `Nombre_Laboratorio`) VALUES
(1, 'Ramos');

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
  `Precio_Total_Lote` float DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  `Stock_Minimo_Lote` int(11) NOT NULL DEFAULT 0,
  `Stock_Maximo_Lote` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`ID_Lote`, `Descripcion_Lote`, `Estado_Lote`, `Cantidad_Lote`, `Fecha_Fabricacion_Lote`, `Fecha_Caducidad_Lote`, `Fecha_Emision_Lote`, `Fecha_Recibido_Lote`, `Precio_Total_Lote`, `ID_Medicamento`, `Stock_Minimo_Lote`, `Stock_Maximo_Lote`) VALUES
(4, 'Lote Pracetamol 500mg', 'Activo', 500, '2025-01-01 00:00:00', '2026-01-01 00:00:00', '2025-01-15 00:00:00', '2025-01-16 00:00:00', 300, 5, 50, 500);

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
(8, 4, 9, 10),
(9, 4, 10, 50),
(10, 4, 11, 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `ID_Medicamento` int(11) NOT NULL,
  `Nombre_Medicamento` varchar(30) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Descripcion_Medicamento` varchar(250) DEFAULT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Requiere_Receta` tinyint(1) DEFAULT 0,
  `Id_Proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`ID_Medicamento`, `Nombre_Medicamento`, `Imagen`, `Descripcion_Medicamento`, `IdCategoria`, `Estado`, `Requiere_Receta`, `Id_Proveedor`) VALUES
(5, 'Paracetamol', 'paracetamol.jpg', 'Analgésico y antipirético de uso general', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_dosis`
--

CREATE TABLE `medicamento_dosis` (
  `ID_Dosis` int(11) NOT NULL,
  `Dosis` varchar(50) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_dosis`
--

INSERT INTO `medicamento_dosis` (`ID_Dosis`, `Dosis`, `ID_Medicamento`) VALUES
(5, '500mg', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_estanteria`
--

CREATE TABLE `medicamento_estanteria` (
  `ID_Medicamento_Estanteria` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `ID_Posicion` int(11) NOT NULL,
  `Cantidad_Disponible` int(11) DEFAULT 0,
  `Stock_Minimo` int(11) DEFAULT 0,
  `Stock_Maximo` int(11) DEFAULT 0,
  `Fecha_Actualizacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_estanteria`
--

INSERT INTO `medicamento_estanteria` (`ID_Medicamento_Estanteria`, `ID_Medicamento`, `ID_Posicion`, `Cantidad_Disponible`, `Stock_Minimo`, `Stock_Maximo`, `Fecha_Actualizacion`) VALUES
(2, 5, 2, 5, 1, 5, '2025-06-13 15:24:36');

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
(5, 5, 'Tableta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_laboratorio`
--

CREATE TABLE `medicamento_laboratorio` (
  `ID_Medicamento` int(11) NOT NULL,
  `ID_Laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento_presentacion`
--

CREATE TABLE `medicamento_presentacion` (
  `ID_Presentacion` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `Tipo_Presentacion` varchar(50) NOT NULL,
  `Unidad_Desglose` varchar(50) DEFAULT NULL COMMENT 'Ej: si es Caja → Blíster, si es Blíster → Unidad',
  `Total_Presentacion` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento_presentacion`
--

INSERT INTO `medicamento_presentacion` (`ID_Presentacion`, `ID_Medicamento`, `Tipo_Presentacion`, `Unidad_Desglose`, `Total_Presentacion`, `Precio`) VALUES
(9, 5, 'Caja', 'Blister', 5, 30.00),
(10, 5, 'Blister', 'Unidad', 10, 8.00),
(11, 5, 'Unidad', 'Unidad', 1, 1.00);

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
-- Estructura de tabla para la tabla `posicion_estanteria`
--

CREATE TABLE `posicion_estanteria` (
  `ID_Posicion` int(11) NOT NULL,
  `ID_Estanteria` int(11) NOT NULL,
  `Coordenada_X` int(11) NOT NULL,
  `Coordenada_Y` int(11) NOT NULL,
  `Piso` int(11) NOT NULL DEFAULT 1,
  `SubFila` int(11) DEFAULT 1,
  `SubColumna` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posicion_estanteria`
--

INSERT INTO `posicion_estanteria` (`ID_Posicion`, `ID_Estanteria`, `Coordenada_X`, `Coordenada_Y`, `Piso`, `SubFila`, `SubColumna`) VALUES
(2, 2, 1, 1, 3, 2, 1),
(3, 3, 2, 1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Direccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `RUC` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_Laboratorio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Proveedor`, `Nombre`, `Direccion`, `Telefono`, `Email`, `RUC`, `Estado`, `Fecha_Registro`, `ID_Laboratorio`) VALUES
(1, 'Derek', 'barrio milagro', '(+505) 8868-847', 'mcadavo@gamail', '3515645', 1, '2025-03-08 19:34:50', 1);

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
(5, 'Nestor', 'images.jpg', '123456', 2, 1, '2025-03-08 20:08:10', '2025-06-02 18:44:39'),
(21, 'Emmanuel Serrano', 'meliodas.webp', '123456', 28, 1, '2025-03-08 22:49:51', '2025-05-13 19:50:20'),
(22, 'Francisco Perez', NULL, '123456', 29, 1, '2025-03-11 01:08:45', NULL),
(23, 'Gerson Sanchez', NULL, '123456', 33, 1, '2025-03-11 02:24:37', NULL),
(24, 'juanperez', NULL, 'miClave123', 34, 1, '2025-03-12 22:14:24', NULL),
(25, 'Luis Chavez', 'images.PNG', 'Chavez07', 36, 1, '2025-03-12 22:52:57', '2025-06-28 21:40:05'),
(26, 'Marcos Ramos', NULL, '123456', 37, 1, '2025-03-12 23:01:52', NULL),
(29, 'kenny Solis', '449310638_122108766050369563_655787570102137785_n.jpg', '1234567', 44, 1, '2025-03-20 00:24:18', NULL),
(30, 'Franklin Jiron', NULL, '123456', 45, 1, '2025-03-20 01:57:18', NULL),
(33, 'Pedro Serrano', NULL, '123456', 49, 1, '2025-04-14 02:24:46', '2025-06-28 20:01:47'),
(34, 'Mariela Jarquin', NULL, '123456', 50, 1, '2025-04-14 02:37:51', '2025-05-27 22:15:31'),
(35, 'Andriws Serrano', 'goku.jpg', '123456', 51, 1, '2025-04-15 03:00:47', '2025-05-27 22:16:56'),
(36, '71981712715 87549942164', NULL, '123456', 52, 1, '2025-06-28 14:57:20', NULL);

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
(51, 'Andriws Anibal', '001-235648-7123B', '(+505) 214', 'Andriwsserrano@gmail.com', 'Vi.Venezuela Colegio Hispano Americano 1/2 C.O Casa #1993-94', 'H', 1, 3, 'Serrano Ramos'),
(52, '71981712715', '001-311003-1008E', '7675-5731', 'NESTORAGUIRRE3110@gmail.com', 'NESTOR ABANFI A', 'H', 1, 1, '87549942164');

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
  ADD PRIMARY KEY (`ID_Almacen`),
  ADD KEY `IdBodega` (`ID_Bodega_Origen`),
  ADD KEY `fk_almacen_medicamento` (`ID_Medicamento`),
  ADD KEY `fk_almacen_estanteria` (`ID_Estanteria_Destino`),
  ADD KEY `fk_almacen_posicion` (`ID_Posicion_Destino`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`ID_Bodega`),
  ADD KEY `fk_bodega_posicion` (`ID_Posicion`),
  ADD KEY `fk_bodega_medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`ID_Caja`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

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
-- Indices de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  ADD PRIMARY KEY (`ID_Detalle`),
  ADD KEY `ID_Caja` (`ID_Caja`);

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
-- Indices de la tabla `estanteria`
--
ALTER TABLE `estanteria`
  ADD PRIMARY KEY (`ID_Estanteria`);

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
  ADD KEY `fk_factura_venta_cliente` (`ID_Cliente`),
  ADD KEY `fk_factura_venta_usuario` (`ID_Usuario`),
  ADD KEY `fk_factura_venta_caja` (`ID_Caja`);

--
-- Indices de la tabla `forma_farmaceutica_dosis`
--
ALTER TABLE `forma_farmaceutica_dosis`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Forma_Farmaceutica` (`ID_Forma_Farmaceutica`),
  ADD KEY `ID_Dosis` (`ID_Dosis`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`ID_Laboratorio`);

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
  ADD PRIMARY KEY (`ID_Dosis`),
  ADD KEY `fk_dosis_medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `medicamento_estanteria`
--
ALTER TABLE `medicamento_estanteria`
  ADD PRIMARY KEY (`ID_Medicamento_Estanteria`),
  ADD KEY `ID_Medicamento` (`ID_Medicamento`),
  ADD KEY `ID_Posicion` (`ID_Posicion`);

--
-- Indices de la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  ADD PRIMARY KEY (`ID_Forma_Farmaceutica`),
  ADD KEY `ID_Medicamento` (`ID_Medicamento`);

--
-- Indices de la tabla `medicamento_laboratorio`
--
ALTER TABLE `medicamento_laboratorio`
  ADD PRIMARY KEY (`ID_Medicamento`,`ID_Laboratorio`),
  ADD KEY `ID_Laboratorio` (`ID_Laboratorio`);

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
-- Indices de la tabla `posicion_estanteria`
--
ALTER TABLE `posicion_estanteria`
  ADD PRIMARY KEY (`ID_Posicion`),
  ADD KEY `ID_Estanteria` (`ID_Estanteria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`),
  ADD KEY `fk_proveedor_laboratorio` (`ID_Laboratorio`);

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
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `ID_Almacen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `ID_Bodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `ID_Caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

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
-- AUTO_INCREMENT de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  MODIFY `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `detalle_factura_venta`
--
ALTER TABLE `detalle_factura_venta`
  MODIFY `ID_Detalle_FV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estanteria`
--
ALTER TABLE `estanteria`
  MODIFY `ID_Estanteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `ID_FacturaC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  MODIFY `ID_FacturaV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `forma_farmaceutica_dosis`
--
ALTER TABLE `forma_farmaceutica_dosis`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `ID_Laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `ID_Lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lote_presentacion`
--
ALTER TABLE `lote_presentacion`
  MODIFY `ID_Lote_Presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `ID_Medicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medicamento_dosis`
--
ALTER TABLE `medicamento_dosis`
  MODIFY `ID_Dosis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medicamento_estanteria`
--
ALTER TABLE `medicamento_estanteria`
  MODIFY `ID_Medicamento_Estanteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  MODIFY `ID_Forma_Farmaceutica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medicamento_presentacion`
--
ALTER TABLE `medicamento_presentacion`
  MODIFY `ID_Presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `posicion_estanteria`
--
ALTER TABLE `posicion_estanteria`
  MODIFY `ID_Posicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `ID_Vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_2` FOREIGN KEY (`ID_Bodega_Origen`) REFERENCES `bodega` (`ID_Bodega`),
  ADD CONSTRAINT `fk_almacen_bodega` FOREIGN KEY (`ID_Bodega_Origen`) REFERENCES `bodega` (`ID_Bodega`),
  ADD CONSTRAINT `fk_almacen_estanteria` FOREIGN KEY (`ID_Estanteria_Destino`) REFERENCES `estanteria` (`ID_Estanteria`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_almacen_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  ADD CONSTRAINT `fk_almacen_posicion` FOREIGN KEY (`ID_Posicion_Destino`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `fk_bodega_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bodega_posicion` FOREIGN KEY (`ID_Posicion`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`);

--
-- Filtros para la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  ADD CONSTRAINT `detalle_caja_ibfk_1` FOREIGN KEY (`ID_Caja`) REFERENCES `caja` (`ID_Caja`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_factura_venta_caja` FOREIGN KEY (`ID_Caja`) REFERENCES `caja` (`ID_Caja`) ON DELETE SET NULL ON UPDATE CASCADE,
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
-- Filtros para la tabla `medicamento_dosis`
--
ALTER TABLE `medicamento_dosis`
  ADD CONSTRAINT `fk_dosis_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicamento_estanteria`
--
ALTER TABLE `medicamento_estanteria`
  ADD CONSTRAINT `medicamento_estanteria_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicamento_estanteria_ibfk_2` FOREIGN KEY (`ID_Posicion`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medicamento_forma_farmaceutica`
--
ALTER TABLE `medicamento_forma_farmaceutica`
  ADD CONSTRAINT `medicamento_forma_farmaceutica_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medicamento_laboratorio`
--
ALTER TABLE `medicamento_laboratorio`
  ADD CONSTRAINT `medicamento_laboratorio_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicamento_laboratorio_ibfk_2` FOREIGN KEY (`ID_Laboratorio`) REFERENCES `laboratorio` (`ID_Laboratorio`) ON DELETE CASCADE;

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
-- Filtros para la tabla `posicion_estanteria`
--
ALTER TABLE `posicion_estanteria`
  ADD CONSTRAINT `posicion_estanteria_ibfk_1` FOREIGN KEY (`ID_Estanteria`) REFERENCES `estanteria` (`ID_Estanteria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_laboratorio` FOREIGN KEY (`ID_Laboratorio`) REFERENCES `laboratorio` (`ID_Laboratorio`) ON DELETE SET NULL ON UPDATE CASCADE;

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

-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: farmacia_san_francisco_javier2
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacen`
--

DROP TABLE IF EXISTS `almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `almacen` (
  `ID_Almacen` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Bodega_Origen` int(11) NOT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  `ID_Estanteria_Destino` int(11) NOT NULL,
  `ID_Posicion_Destino` int(11) NOT NULL,
  `Cantidad_Trasladada` int(11) NOT NULL,
  `Fecha_Movimiento` datetime DEFAULT current_timestamp(),
  `Observaciones` text DEFAULT NULL,
  PRIMARY KEY (`ID_Almacen`),
  KEY `IdBodega` (`ID_Bodega_Origen`),
  KEY `fk_almacen_medicamento` (`ID_Medicamento`),
  KEY `fk_almacen_estanteria` (`ID_Estanteria_Destino`),
  KEY `fk_almacen_posicion` (`ID_Posicion_Destino`),
  CONSTRAINT `almacen_ibfk_2` FOREIGN KEY (`ID_Bodega_Origen`) REFERENCES `bodega` (`ID_Bodega`),
  CONSTRAINT `fk_almacen_bodega` FOREIGN KEY (`ID_Bodega_Origen`) REFERENCES `bodega` (`ID_Bodega`),
  CONSTRAINT `fk_almacen_estanteria` FOREIGN KEY (`ID_Estanteria_Destino`) REFERENCES `estanteria` (`ID_Estanteria`) ON DELETE CASCADE,
  CONSTRAINT `fk_almacen_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_almacen_posicion` FOREIGN KEY (`ID_Posicion_Destino`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacen`
--

LOCK TABLES `almacen` WRITE;
/*!40000 ALTER TABLE `almacen` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bodega`
--

DROP TABLE IF EXISTS `bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bodega` (
  `ID_Bodega` int(11) NOT NULL AUTO_INCREMENT,
  `Cantidad_Total_Bodega` int(11) DEFAULT NULL,
  `Stock_Minimo` int(11) DEFAULT 0,
  `Stock_Maximo` int(11) DEFAULT 0,
  `ID_Posicion` int(11) DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Bodega`),
  KEY `fk_bodega_posicion` (`ID_Posicion`),
  KEY `fk_bodega_medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_bodega_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  CONSTRAINT `fk_bodega_posicion` FOREIGN KEY (`ID_Posicion`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bodega`
--

LOCK TABLES `bodega` WRITE;
/*!40000 ALTER TABLE `bodega` DISABLE KEYS */;
INSERT INTO `bodega` VALUES (2,500,100,500,3,5);
/*!40000 ALTER TABLE `bodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caja`
--

DROP TABLE IF EXISTS `caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caja` (
  `ID_Caja` int(11) NOT NULL AUTO_INCREMENT,
  `Cajero` varchar(100) NOT NULL,
  `Fecha_Hora` datetime NOT NULL,
  `Tipo` enum('apertura','cierre') NOT NULL,
  `Monto_Cordobas` decimal(10,2) DEFAULT NULL,
  `Monto_Dolares` decimal(10,2) DEFAULT NULL,
  `Observaciones` text DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Estado_Cierre` varchar(10) DEFAULT 'cuadra',
  `Diferencia` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`ID_Caja`),
  KEY `ID_Usuario` (`ID_Usuario`),
  CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja`
--

LOCK TABLES `caja` WRITE;
/*!40000 ALTER TABLE `caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Categoria` varchar(150) DEFAULT NULL,
  `Descripcion` varchar(150) DEFAULT NULL,
  `estado_categoria` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`ID_Categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Antibióticos','Medicamentos para tratar infecciones bacterianas',0),(2,'Analgésicos','Medicamentos para aliviar el dolor',1),(3,'Antiinflamatorios','Medicamentos para reducir la inflamación',1),(4,'Antihistamínicos','Medicamentos para tratar alergias',1),(5,'Antidiabéticos','Medicamentos para controlar la diabetes',1),(6,'Vitaminas','Suplementos vitamínicos para diversas funciones del cuerpo',1),(7,'Antipiréticos','Medicamentos para reducir la fiebre',1),(8,'Antidepresivos','Medicamentos para tratar trastornos depresivos',1),(9,'Higiene','Cuidado del bienestar y la salud de todas las personas.',1),(10,'Radiofármacos','Medicamentos que contienen isótopos radiactivos, usados principalmente en procedimientos de diagnóstico por imágenes y tratamientos oncológicos.',1),(12,'Ectoparasiticidas','Productos usados para eliminar parásitos externos como piojos, pulgas y garrapatas.',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(25) DEFAULT NULL,
  `Apellido` varchar(25) DEFAULT NULL,
  `Genero` enum('Masculino','Femenino') DEFAULT 'Masculino',
  `Direccion` varchar(50) DEFAULT NULL,
  `Telefono` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Fecha_Registro` datetime DEFAULT current_timestamp(),
  `Cedula` varchar(20) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`ID_Cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (62,'Juan','Perez','Masculino','Calle 1, No. 23','12345678','juan.perez@email.com','1985-07-15','2025-03-31 18:36:54','001-123625-1010W',1),(63,'Maria','Lopez','Femenino','Calle 2, No. 10','23456789','maria.lopez@email.com','1990-03-22','2025-03-31 18:36:54','001-234567-1020X',1),(64,'Carlos','Martinez','Masculino','Calle 3, No. 34','34567890','carlos.martinez@email.com','1982-11-10','2025-03-31 18:36:54','001-345678-1030Y',1),(65,'Ana','Gonzalez','Femenino','Calle 4, No. 45','45678901','ana.gonzalez@email.com','1995-05-30','2025-03-31 18:36:54','001-456789-1040Z',1),(66,'Luis','Rodriguez','Masculino','Calle 5, No. 50','56789012','luis.rodriguez@email.com','1988-02-19','2025-03-31 18:36:54','001-567890-1050W',1),(67,'Sofia','Perez','Femenino','Calle 6, No. 60','67890123','sofia.perez@email.com','1993-09-09','2025-03-31 18:36:54','001-678901-1060X',1),(68,'Andres','Martinez','Masculino','Calle 7, No. 70','78901234','andres.martinez@email.com','1980-12-05','2025-03-31 18:36:54','001-789012-1070Y',1),(69,'Lucia','Hernandez','Femenino','Calle 8, No. 80','89012345','lucia.hernandez@email.com','1992-06-18','2025-03-31 18:36:54','001-890123-1080Z',1),(70,'Ricardo','Lopez','Masculino','Calle 9, No. 90','90123456','ricardo.lopez@email.com','1987-01-30','2025-03-31 18:36:54','001-901234-1090W',1),(71,'Valentina','Garcia','Femenino','Calle 10, No. 100','11223344','valentina.garcia@email.com','2000-04-25','2025-03-31 18:36:54','001-112233-1100X',1),(89,'Cliente ','Aleatorio','Masculino','Batahola','00000000','Batahola@gmail.com','2000-04-25','2025-03-31 00:00:00','000-000000-0000X',1);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_caja`
--

DROP TABLE IF EXISTS `detalle_caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_caja` (
  `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Caja` int(11) DEFAULT NULL,
  `Denominacion` varchar(20) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Moneda` enum('cordoba','dolar') NOT NULL,
  `Tipo` enum('billete','moneda') NOT NULL,
  PRIMARY KEY (`ID_Detalle`),
  KEY `ID_Caja` (`ID_Caja`),
  CONSTRAINT `detalle_caja_ibfk_1` FOREIGN KEY (`ID_Caja`) REFERENCES `caja` (`ID_Caja`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_caja`
--

LOCK TABLES `detalle_caja` WRITE;
/*!40000 ALTER TABLE `detalle_caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_factura_venta`
--

DROP TABLE IF EXISTS `detalle_factura_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_factura_venta` (
  `ID_Detalle_FV` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FacturaV` int(11) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_Unitario` decimal(10,2) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL,
  `ID_Forma_Farmaceutica` int(11) DEFAULT NULL,
  `ID_Dosis` int(11) DEFAULT NULL,
  `ID_Presentacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Detalle_FV`),
  KEY `ID_FacturaV` (`ID_FacturaV`),
  KEY `ID_Medicamento` (`ID_Medicamento`),
  KEY `ID_Forma_Farmaceutica` (`ID_Forma_Farmaceutica`),
  KEY `ID_Dosis` (`ID_Dosis`),
  KEY `ID_Presentacion` (`ID_Presentacion`),
  CONSTRAINT `detalle_factura_venta_ibfk_1` FOREIGN KEY (`ID_FacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`),
  CONSTRAINT `detalle_factura_venta_ibfk_2` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  CONSTRAINT `detalle_factura_venta_ibfk_3` FOREIGN KEY (`ID_Forma_Farmaceutica`) REFERENCES `medicamento_forma_farmaceutica` (`ID_Forma_Farmaceutica`),
  CONSTRAINT `detalle_factura_venta_ibfk_4` FOREIGN KEY (`ID_Dosis`) REFERENCES `medicamento_dosis` (`ID_Dosis`),
  CONSTRAINT `detalle_factura_venta_ibfk_5` FOREIGN KEY (`ID_Presentacion`) REFERENCES `medicamento_presentacion` (`ID_Presentacion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_factura_venta`
--

LOCK TABLES `detalle_factura_venta` WRITE;
/*!40000 ALTER TABLE `detalle_factura_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_factura_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estanteria`
--

DROP TABLE IF EXISTS `estanteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estanteria` (
  `ID_Estanteria` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Estanteria` varchar(20) NOT NULL,
  `Cantidad_Filas` int(11) NOT NULL DEFAULT 1,
  `Cantidad_Columnas` int(11) NOT NULL DEFAULT 1,
  `SubFilas` int(11) NOT NULL DEFAULT 1,
  `SubColumnas` int(11) NOT NULL DEFAULT 1,
  `Tipo_Estanteria` enum('Bodega','Sala') NOT NULL DEFAULT 'Sala',
  PRIMARY KEY (`ID_Estanteria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estanteria`
--

LOCK TABLES `estanteria` WRITE;
/*!40000 ALTER TABLE `estanteria` DISABLE KEYS */;
INSERT INTO `estanteria` VALUES (2,'Estante A',3,3,2,3,'Sala'),(3,'Estante A',3,3,2,3,'Bodega'),(4,'Estanteria Prueba',4,3,1,2,'Sala'),(6,'Estanteria Prueba 3',2,2,1,1,'Bodega');
/*!40000 ALTER TABLE `estanteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_compra`
--

DROP TABLE IF EXISTS `factura_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_compra` (
  `ID_FacturaC` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion_Compra` varchar(300) DEFAULT NULL,
  `Fecha_Emision` datetime DEFAULT NULL,
  `Estado_Pedido` varchar(100) DEFAULT NULL,
  `Subtotal_Fact_Comp` float DEFAULT NULL,
  `Iva_Fact_Comp` float DEFAULT NULL,
  `Total_Fact_Comp` float DEFAULT NULL,
  `ID_Proveedor` int(11) DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_FacturaC`),
  KEY `fk_factura_compra_proveedor` (`ID_Proveedor`),
  KEY `fk_factura_compra_medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_factura_compra_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_factura_compra_proveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_compra`
--

LOCK TABLES `factura_compra` WRITE;
/*!40000 ALTER TABLE `factura_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_venta`
--

DROP TABLE IF EXISTS `factura_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_venta` (
  `ID_FacturaV` int(11) NOT NULL AUTO_INCREMENT,
  `Numero_Factura` varchar(20) NOT NULL,
  `Fecha` datetime DEFAULT current_timestamp(),
  `Metodo_Pago` varchar(50) DEFAULT 'Efectivo',
  `Subtotal` decimal(10,2) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Monto_Pagado` varchar(20) DEFAULT NULL,
  `Cambio` varchar(20) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Caja` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_FacturaV`),
  UNIQUE KEY `Numero_Factura` (`Numero_Factura`),
  KEY `fk_factura_venta_cliente` (`ID_Cliente`),
  KEY `fk_factura_venta_usuario` (`ID_Usuario`),
  KEY `fk_factura_venta_caja` (`ID_Caja`),
  CONSTRAINT `fk_factura_venta_caja` FOREIGN KEY (`ID_Caja`) REFERENCES `caja` (`ID_Caja`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_venta_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_venta_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_venta`
--

LOCK TABLES `factura_venta` WRITE;
/*!40000 ALTER TABLE `factura_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_farmaceutica_dosis`
--

DROP TABLE IF EXISTS `forma_farmaceutica_dosis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forma_farmaceutica_dosis` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Forma_Farmaceutica` int(11) NOT NULL,
  `ID_Dosis` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Forma_Farmaceutica` (`ID_Forma_Farmaceutica`),
  KEY `ID_Dosis` (`ID_Dosis`),
  CONSTRAINT `forma_farmaceutica_dosis_ibfk_1` FOREIGN KEY (`ID_Forma_Farmaceutica`) REFERENCES `medicamento_forma_farmaceutica` (`ID_Forma_Farmaceutica`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `forma_farmaceutica_dosis_ibfk_2` FOREIGN KEY (`ID_Dosis`) REFERENCES `medicamento_dosis` (`ID_Dosis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_farmaceutica_dosis`
--

LOCK TABLES `forma_farmaceutica_dosis` WRITE;
/*!40000 ALTER TABLE `forma_farmaceutica_dosis` DISABLE KEYS */;
INSERT INTO `forma_farmaceutica_dosis` VALUES (5,5,5);
/*!40000 ALTER TABLE `forma_farmaceutica_dosis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laboratorio`
--

DROP TABLE IF EXISTS `laboratorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laboratorio` (
  `ID_Laboratorio` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Laboratorio` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Laboratorio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laboratorio`
--

LOCK TABLES `laboratorio` WRITE;
/*!40000 ALTER TABLE `laboratorio` DISABLE KEYS */;
INSERT INTO `laboratorio` VALUES (1,'Ramos');
/*!40000 ALTER TABLE `laboratorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lote`
--

DROP TABLE IF EXISTS `lote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lote` (
  `ID_Lote` int(11) NOT NULL AUTO_INCREMENT,
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
  `Stock_Maximo_Lote` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID_Lote`),
  KEY `fk_lote_medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_lote_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lote`
--

LOCK TABLES `lote` WRITE;
/*!40000 ALTER TABLE `lote` DISABLE KEYS */;
INSERT INTO `lote` VALUES (4,'Lote Pracetamol 500mg','Activo',500,'2025-01-01 00:00:00','2026-01-01 00:00:00','2025-01-15 00:00:00','2025-01-16 00:00:00',300,5,50,500);
/*!40000 ALTER TABLE `lote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lote_presentacion`
--

DROP TABLE IF EXISTS `lote_presentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lote_presentacion` (
  `ID_Lote_Presentacion` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Lote` int(11) NOT NULL,
  `ID_Presentacion` int(11) NOT NULL,
  `Cantidad_Presentacion` int(11) NOT NULL,
  PRIMARY KEY (`ID_Lote_Presentacion`),
  KEY `ID_Lote` (`ID_Lote`),
  KEY `ID_Presentacion` (`ID_Presentacion`),
  CONSTRAINT `lote_presentacion_ibfk_1` FOREIGN KEY (`ID_Lote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE,
  CONSTRAINT `lote_presentacion_ibfk_2` FOREIGN KEY (`ID_Presentacion`) REFERENCES `medicamento_presentacion` (`ID_Presentacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lote_presentacion`
--

LOCK TABLES `lote_presentacion` WRITE;
/*!40000 ALTER TABLE `lote_presentacion` DISABLE KEYS */;
INSERT INTO `lote_presentacion` VALUES (8,4,9,10),(9,4,10,50),(10,4,11,500);
/*!40000 ALTER TABLE `lote_presentacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lotefact`
--

DROP TABLE IF EXISTS `lotefact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lotefact` (
  `IdLote` int(11) DEFAULT NULL,
  `IdFacturaC` int(11) DEFAULT NULL,
  KEY `IdLote` (`IdLote`),
  KEY `IdFacturaC` (`IdFacturaC`),
  CONSTRAINT `lotefact_ibfk_1` FOREIGN KEY (`IdLote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lotefact_ibfk_2` FOREIGN KEY (`IdFacturaC`) REFERENCES `factura_compra` (`ID_FacturaC`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lotefact`
--

LOCK TABLES `lotefact` WRITE;
/*!40000 ALTER TABLE `lotefact` DISABLE KEYS */;
/*!40000 ALTER TABLE `lotefact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento`
--

DROP TABLE IF EXISTS `medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento` (
  `ID_Medicamento` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Medicamento` varchar(30) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Descripcion_Medicamento` varchar(250) DEFAULT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Requiere_Receta` tinyint(1) DEFAULT 0,
  `Id_Proveedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Medicamento`),
  KEY `IdCategoria` (`IdCategoria`),
  KEY `fk_proveedor` (`Id_Proveedor`),
  CONSTRAINT `fk_proveedor` FOREIGN KEY (`Id_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`ID_Categoria`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento`
--

LOCK TABLES `medicamento` WRITE;
/*!40000 ALTER TABLE `medicamento` DISABLE KEYS */;
INSERT INTO `medicamento` VALUES (5,'Paracetamol','paracetamol.jpg','Analgésico y antipirético de uso general',1,1,0,1);
/*!40000 ALTER TABLE `medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento_dosis`
--

DROP TABLE IF EXISTS `medicamento_dosis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento_dosis` (
  `ID_Dosis` int(11) NOT NULL AUTO_INCREMENT,
  `Dosis` varchar(50) NOT NULL,
  `ID_Medicamento` int(11) NOT NULL,
  PRIMARY KEY (`ID_Dosis`),
  KEY `fk_dosis_medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_dosis_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_dosis`
--

LOCK TABLES `medicamento_dosis` WRITE;
/*!40000 ALTER TABLE `medicamento_dosis` DISABLE KEYS */;
INSERT INTO `medicamento_dosis` VALUES (5,'500mg',5);
/*!40000 ALTER TABLE `medicamento_dosis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento_estanteria`
--

DROP TABLE IF EXISTS `medicamento_estanteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento_estanteria` (
  `ID_Medicamento_Estanteria` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Medicamento` int(11) NOT NULL,
  `ID_Posicion` int(11) NOT NULL,
  `Cantidad_Disponible` int(11) DEFAULT 0,
  `Stock_Minimo` int(11) DEFAULT 0,
  `Stock_Maximo` int(11) DEFAULT 0,
  `Fecha_Actualizacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Medicamento_Estanteria`),
  KEY `ID_Medicamento` (`ID_Medicamento`),
  KEY `ID_Posicion` (`ID_Posicion`),
  CONSTRAINT `medicamento_estanteria_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  CONSTRAINT `medicamento_estanteria_ibfk_2` FOREIGN KEY (`ID_Posicion`) REFERENCES `posicion_estanteria` (`ID_Posicion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_estanteria`
--

LOCK TABLES `medicamento_estanteria` WRITE;
/*!40000 ALTER TABLE `medicamento_estanteria` DISABLE KEYS */;
INSERT INTO `medicamento_estanteria` VALUES (2,5,2,5,1,5,'2025-06-13 15:24:36');
/*!40000 ALTER TABLE `medicamento_estanteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento_forma_farmaceutica`
--

DROP TABLE IF EXISTS `medicamento_forma_farmaceutica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento_forma_farmaceutica` (
  `ID_Forma_Farmaceutica` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Medicamento` int(11) NOT NULL,
  `Forma_Farmaceutica` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Forma_Farmaceutica`),
  KEY `ID_Medicamento` (`ID_Medicamento`),
  CONSTRAINT `medicamento_forma_farmaceutica_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_forma_farmaceutica`
--

LOCK TABLES `medicamento_forma_farmaceutica` WRITE;
/*!40000 ALTER TABLE `medicamento_forma_farmaceutica` DISABLE KEYS */;
INSERT INTO `medicamento_forma_farmaceutica` VALUES (5,5,'Tableta');
/*!40000 ALTER TABLE `medicamento_forma_farmaceutica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento_laboratorio`
--

DROP TABLE IF EXISTS `medicamento_laboratorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento_laboratorio` (
  `ID_Medicamento` int(11) NOT NULL,
  `ID_Laboratorio` int(11) NOT NULL,
  PRIMARY KEY (`ID_Medicamento`,`ID_Laboratorio`),
  KEY `ID_Laboratorio` (`ID_Laboratorio`),
  CONSTRAINT `medicamento_laboratorio_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE,
  CONSTRAINT `medicamento_laboratorio_ibfk_2` FOREIGN KEY (`ID_Laboratorio`) REFERENCES `laboratorio` (`ID_Laboratorio`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_laboratorio`
--

LOCK TABLES `medicamento_laboratorio` WRITE;
/*!40000 ALTER TABLE `medicamento_laboratorio` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicamento_laboratorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento_presentacion`
--

DROP TABLE IF EXISTS `medicamento_presentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento_presentacion` (
  `ID_Presentacion` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Medicamento` int(11) NOT NULL,
  `Tipo_Presentacion` varchar(50) NOT NULL,
  `Unidad_Desglose` varchar(50) DEFAULT NULL COMMENT 'Ej: si es Caja → Blíster, si es Blíster → Unidad',
  `Total_Presentacion` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_Presentacion`),
  KEY `ID_Medicamento` (`ID_Medicamento`),
  CONSTRAINT `medicamento_presentacion_ibfk_1` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento_presentacion`
--

LOCK TABLES `medicamento_presentacion` WRITE;
/*!40000 ALTER TABLE `medicamento_presentacion` DISABLE KEYS */;
INSERT INTO `medicamento_presentacion` VALUES (9,5,'Caja','Blister',5,30.00),(10,5,'Blister','Unidad',10,8.00),(11,5,'Unidad','Unidad',1,1.00);
/*!40000 ALTER TABLE `medicamento_presentacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertalote`
--

DROP TABLE IF EXISTS `ofertalote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertalote` (
  `IdProveedor` int(11) DEFAULT NULL,
  `IdLote` int(11) DEFAULT NULL,
  KEY `IdProveedor` (`IdProveedor`),
  KEY `IdLote` (`IdLote`),
  CONSTRAINT `ofertalote_ibfk_1` FOREIGN KEY (`IdLote`) REFERENCES `lote` (`ID_Lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ofertalote_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertalote`
--

LOCK TABLES `ofertalote` WRITE;
/*!40000 ALTER TABLE `ofertalote` DISABLE KEYS */;
/*!40000 ALTER TABLE `ofertalote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion_Pedido` varchar(100) DEFAULT NULL,
  `Fecha_Solicitud` datetime DEFAULT NULL,
  `Fecha_Recibo` datetime DEFAULT NULL,
  `Estado_Pedido` varchar(200) DEFAULT NULL,
  `IdVendedor` int(11) DEFAULT NULL,
  `IdFacturaV` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Pedido`),
  KEY `IdVendedor` (`IdVendedor`),
  KEY `fk_pedido_factura` (`IdFacturaV`),
  CONSTRAINT `fk_pedido_factura` FOREIGN KEY (`IdFacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_fact`
--

DROP TABLE IF EXISTS `pedido_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_fact` (
  `IdPedido` int(11) DEFAULT NULL,
  `IdFacturaC` int(11) DEFAULT NULL,
  KEY `IdPedido` (`IdPedido`),
  KEY `IdFacturaC` (`IdFacturaC`),
  CONSTRAINT `pedido_fact_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedido_fact_ibfk_2` FOREIGN KEY (`IdFacturaC`) REFERENCES `factura_compra` (`ID_FacturaC`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_fact`
--

LOCK TABLES `pedido_fact` WRITE;
/*!40000 ALTER TABLE `pedido_fact` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posicion_estanteria`
--

DROP TABLE IF EXISTS `posicion_estanteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posicion_estanteria` (
  `ID_Posicion` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Estanteria` int(11) NOT NULL,
  `Coordenada_X` int(11) NOT NULL,
  `Coordenada_Y` int(11) NOT NULL,
  `Piso` int(11) NOT NULL DEFAULT 1,
  `SubFila` int(11) DEFAULT 1,
  `SubColumna` int(11) DEFAULT 1,
  PRIMARY KEY (`ID_Posicion`),
  KEY `ID_Estanteria` (`ID_Estanteria`),
  CONSTRAINT `posicion_estanteria_ibfk_1` FOREIGN KEY (`ID_Estanteria`) REFERENCES `estanteria` (`ID_Estanteria`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posicion_estanteria`
--

LOCK TABLES `posicion_estanteria` WRITE;
/*!40000 ALTER TABLE `posicion_estanteria` DISABLE KEYS */;
INSERT INTO `posicion_estanteria` VALUES (2,2,1,1,3,2,1),(3,3,2,1,1,1,2);
/*!40000 ALTER TABLE `posicion_estanteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) DEFAULT NULL,
  `Direccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `RUC` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_Laboratorio` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Proveedor`),
  KEY `fk_proveedor_laboratorio` (`ID_Laboratorio`),
  CONSTRAINT `fk_proveedor_laboratorio` FOREIGN KEY (`ID_Laboratorio`) REFERENCES `laboratorio` (`ID_Laboratorio`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Derek','barrio milagro','(+505) 8868-847','mcadavo@gamail','3515645',1,'2025-03-08 19:34:50',1);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provped`
--

DROP TABLE IF EXISTS `provped`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provped` (
  `IdPedido` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  KEY `IdPedido` (`IdPedido`),
  KEY `IdProveedor` (`IdProveedor`),
  CONSTRAINT `provped_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`ID_Pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `provped_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provped`
--

LOCK TABLES `provped` WRITE;
/*!40000 ALTER TABLE `provped` DISABLE KEYS */;
/*!40000 ALTER TABLE `provped` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respaldos`
--

DROP TABLE IF EXISTS `respaldos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respaldos` (
  `ID_Respaldo` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Archivo` varchar(255) NOT NULL,
  `Tamano` varchar(50) NOT NULL,
  `Estado` enum('exito','fallido') NOT NULL,
  `Origen` enum('usuario','sistema') NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Respaldo`),
  KEY `fk_respaldos_usuario` (`ID_Usuario`),
  CONSTRAINT `fk_respaldos_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respaldos`
--

LOCK TABLES `respaldos` WRITE;
/*!40000 ALTER TABLE `respaldos` DISABLE KEYS */;
/*!40000 ALTER TABLE `respaldos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `ID_Rol` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Rol` varchar(50) DEFAULT NULL,
  `Descripcion_Rol` varchar(200) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`ID_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','Todos los Accesos',1),(2,'Vendedor','Acceso limitado a funciones básicas',1),(3,'Bodeguero','Acceso limitado a funciones básicas',1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suministro`
--

DROP TABLE IF EXISTS `suministro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suministro` (
  `IdMedicamento` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  KEY `IdMedicamento` (`IdMedicamento`),
  KEY `IdProveedor` (`IdProveedor`),
  CONSTRAINT `fk_suministro_proveedor` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  CONSTRAINT `suministro_ibfk_1` FOREIGN KEY (`IdMedicamento`) REFERENCES `medicamento` (`ID_Medicamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `suministro_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suministro`
--

LOCK TABLES `suministro` WRITE;
/*!40000 ALTER TABLE `suministro` DISABLE KEYS */;
/*!40000 ALTER TABLE `suministro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Imagen` text DEFAULT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ID_Vendedor` int(11) DEFAULT NULL,
  `estado_usuario` tinyint(1) DEFAULT 1,
  `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ultimo_Acceso` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`),
  UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  UNIQUE KEY `unique_vendedor` (`ID_Vendedor`),
  KEY `ID_Vendedor` (`ID_Vendedor`),
  CONSTRAINT `fk_usuarios_vendedor` FOREIGN KEY (`ID_Vendedor`) REFERENCES `vendedor` (`ID_Vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Derek Jameson','avatar.png','Djsomoza31',1,1,'2025-03-08 19:22:06','2025-05-14 23:08:59'),(5,'Nestor','images.jpg','123456',2,1,'2025-03-08 20:08:10','2025-06-02 18:44:39'),(21,'Emmanuel Serrano','meliodas.webp','123456',28,1,'2025-03-08 22:49:51','2025-05-13 19:50:20'),(22,'Francisco Perez',NULL,'123456',29,1,'2025-03-11 01:08:45',NULL),(23,'Gerson Sanchez',NULL,'123456',33,1,'2025-03-11 02:24:37',NULL),(24,'juanperez',NULL,'miClave123',34,1,'2025-03-12 22:14:24',NULL),(25,'Luis Chavez','images.PNG','Chavez07',36,1,'2025-03-12 22:52:57','2025-07-01 18:48:29'),(26,'Marcos Ramos',NULL,'123456',37,1,'2025-03-12 23:01:52',NULL),(29,'kenny Solis','449310638_122108766050369563_655787570102137785_n.jpg','1234567',44,1,'2025-03-20 00:24:18',NULL),(30,'Franklin Jiron',NULL,'123456',45,1,'2025-03-20 01:57:18',NULL),(33,'Pedro Serrano',NULL,'123456',49,1,'2025-04-14 02:24:46','2025-06-28 20:01:47'),(34,'Mariela Jarquin',NULL,'123456',50,1,'2025-04-14 02:37:51','2025-05-27 22:15:31'),(35,'Andriws Serrano','goku.jpg','123456',51,1,'2025-04-15 03:00:47','2025-05-27 22:16:56'),(36,'71981712715 87549942164',NULL,'123456',52,1,'2025-06-28 14:57:20',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedor` (
  `ID_Vendedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(70) DEFAULT NULL,
  `N_Cedula` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL CHECK (`Sexo` in ('H','M')),
  `Estado` tinyint(1) DEFAULT 1,
  `ID_Rol` int(11) DEFAULT NULL,
  `Apellido` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID_Vendedor`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `N_Cedula` (`N_Cedula`),
  KEY `fk_rol` (`ID_Rol`),
  CONSTRAINT `fk_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `roles` (`ID_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedor`
--

LOCK TABLES `vendedor` WRITE;
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
INSERT INTO `vendedor` VALUES (1,'Derek Jameson','001-311001-1085U','8601-8985','Djsomoza@gmail.com','Milagro de Dios','H',1,1,'Somoza chavarrilla'),(2,'Nestor Gabriel','001-233525-1211V','1236-5487','AguirreCanales@gmail.com','Villa el carmen ','H',1,2,'Aguirre Canales'),(28,'Emmanuel','001-130901-1010W','8868-8476','mcdavo1309@gmail.com','Vi.Venezuela Colegio Hispano Americano 1/2 C.O Casa #1993-94','H',1,2,'Serrano Ramos'),(29,'Francisco jose','001-122410-2541P','1224-5876','franciscoperez@gmail.com','Masaya','H',1,2,'Perez'),(33,'Gerson Ezequiel','025-200504-2055X','7523-6542','gersonsanchez@gmail.com','Cuidad Sandino','H',1,2,'Sanchez Hernadez'),(34,'Juan','001-220598-0001A','8888-9999','juan@example.com','Calle 123, Ciudad X','H',1,2,'Pérez'),(36,'Luis Eduardo','001-563290-2045N','8623-5412','LuisChavez@gmail.com','Cuidad Sandino','H',1,1,'Chavez Mairena'),(37,'Marcos Orlando','001-236292-6451S','8856-2341','MarcoRamos21@gmail.com','Managua','H',1,2,'Ramos Vado'),(44,'kenny Ivania','001-958612-3526J','8569-4512','kennysolis@gmail.com','Cristo Rey','M',1,2,'Solis Ampie'),(45,'Franklin Randal','001-365941-5623F','5623-5412','FranklinJiron@gmail.com','managua','H',1,2,'Jiron'),(49,'Pedro Anibal','001-190571-1254H','8898-0315','PedroSerrano@gamil.com','Vi. Venezuela, Colegio Hispano Americano½ C. O','H',1,3,'Serrano'),(50,'Mariela Carolina','001-011201-2356M','5623-1547','MariJarquin@gmail.com','Vi. Venezuela, Colegio Hispano Americano½ C. O','M',1,1,'Jarquin Rodriguez'),(51,'Andriws Anibal','001-235648-7123B','(+505) 214','Andriwsserrano@gmail.com','Vi.Venezuela Colegio Hispano Americano 1/2 C.O Casa #1993-94','H',1,3,'Serrano Ramos'),(52,'71981712715','001-311003-1008E','7675-5731','NESTORAGUIRRE3110@gmail.com','NESTOR ABANFI A','H',1,1,'87549942164');
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_medicamento`
--

DROP TABLE IF EXISTS `venta_medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta_medicamento` (
  `ID_Medicamento` int(11) DEFAULT NULL,
  `ID_FacturaV` int(11) NOT NULL,
  KEY `IdMedicamento` (`ID_Medicamento`),
  KEY `fk_venta_medicamento_factura` (`ID_FacturaV`),
  CONSTRAINT `fk_venta_medicamento` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamento` (`ID_Medicamento`),
  CONSTRAINT `fk_venta_medicamento_factura` FOREIGN KEY (`ID_FacturaV`) REFERENCES `factura_venta` (`ID_FacturaV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_medicamento`
--

LOCK TABLES `venta_medicamento` WRITE;
/*!40000 ALTER TABLE `venta_medicamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_medicamento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-01 14:28:40

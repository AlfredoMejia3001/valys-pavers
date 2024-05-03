use valyspavers;
DROP TABLE IF EXISTS `contenido_facturas`;
DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Cliente` varchar(100) DEFAULT NULL,
  `Fecha_Emision` date DEFAULT NULL,
  `Fecha_Vencimiento` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contenido_facturas` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Factura_ID` int DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio_Unitario` decimal(10,2) DEFAULT NULL,
  `Cantidad` int DEFAULT NULL,
  `Importe` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Factura_ID` (`Factura_ID`),
  CONSTRAINT `contenido_facturas_ibfk_1` FOREIGN KEY (`Factura_ID`) REFERENCES `facturas` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
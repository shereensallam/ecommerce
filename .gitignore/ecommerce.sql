-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 23, 2018 at 09:59 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

DROP TABLE IF EXISTS `buyer`;
CREATE TABLE IF NOT EXISTS `buyer` (
  `BuyerID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`BuyerID`),
  UNIQUE KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;



--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `BuyerID` int(11) NOT NULL,
  `CartID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`CartID`),
  UNIQUE KEY `CartID` (`CartID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `creditcard`
--

DROP TABLE IF EXISTS `creditcard`;
CREATE TABLE IF NOT EXISTS `creditcard` (
  `CreditCardNo` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `CreditCardPIN` varchar(6) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`CreditCardNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` date NOT NULL,
  `TotalCost` float NOT NULL,
  `PaymentMethod` char(5) NOT NULL,
  `BuyerID` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(10) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_cart`
--

DROP TABLE IF EXISTS `product_cart`;
CREATE TABLE IF NOT EXISTS `product_cart` (
  `Quantity` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `CartID` int(11) NOT NULL,
  PRIMARY KEY (`ProductID`,`CartID`),
  KEY `CartID` (`CartID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

DROP TABLE IF EXISTS `product_order`;
CREATE TABLE IF NOT EXISTS `product_order` (
  `Quantity` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `StoreID` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`,`StoreID`),
  KEY `StoreID` (`StoreID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

DROP TABLE IF EXISTS `product_store`;
CREATE TABLE IF NOT EXISTS `product_store` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(255) DEFAULT NULL,
  `StoreID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Price` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`ProductID`),
  UNIQUE KEY `ProductName` (`ProductName`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

DROP TABLE IF EXISTS `seller`;
CREATE TABLE IF NOT EXISTS `seller` (
  `SellerID` int(11) NOT NULL AUTO_INCREMENT,
  `StoreID` int(11) NOT NULL,
  `DateCreated` date NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`SellerID`),
  UNIQUE KEY `StoreID` (`StoreID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
CREATE TABLE IF NOT EXISTS `store` (
  `StoreID` int(11) NOT NULL AUTO_INCREMENT,
  `StoreName` varchar(10) NOT NULL,
  PRIMARY KEY (`StoreID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_category`
--

DROP TABLE IF EXISTS `store_category`;
CREATE TABLE IF NOT EXISTS `store_category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) NOT NULL,
  `StoreID` int(11) NOT NULL,
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `CategoryName` (`CategoryName`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_category`
--

INSERT INTO `store_category` (`CategoryID`, `CategoryName`, `StoreID`) VALUES
(1, 'pets', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(10) NOT NULL,
  `LastName` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `PhoneNo` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `UserName` (`UserName`),
  UNIQUE KEY `PhoneNo` (`PhoneNo`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `product_cart`
--
ALTER TABLE `product_cart`
  ADD CONSTRAINT `product_cart_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `product_cart_ibfk_2` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`);

--
-- Constraints for table `product_order`
--
ALTER TABLE `product_order`
  ADD CONSTRAINT `product_order_ibfk_1` FOREIGN KEY (`StoreID`) REFERENCES `store` (`StoreID`),
  ADD CONSTRAINT `product_order_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `product_order_ibfk_3` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`StoreID`) REFERENCES `store` (`StoreID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

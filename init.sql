SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS `qdvrdb`;

USE `qdvrdb`;

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitorname` varchar(255) NOT NULL,
  `visitormail` varchar(255) NOT NULL,
  `visitororg` varchar(255) NOT NULL,
  `visitorhost` varchar(255) NOT NULL,
  `arrivetime` datetime NOT NULL,
  `departtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_visitorname` (`visitorname`),
  KEY `idx_departtime` (`departtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `present` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

GRANT ALL PRIVILEGES ON qdvrdb.* TO 'qdvr'@'%';

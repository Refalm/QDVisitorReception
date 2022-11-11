SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS `qdvrdb`;

USE `qdvrdb`;

CREATE TABLE `visitor` (`visitorname` varchar(123) NOT NULL, `visitormail` varchar(123) NOT NULL, `visitororg` varchar(123) NOT NULL, `visitorhost` varchar(123) NOT NULL, `arrivetime` datetime NOT NULL, `departtime` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `visitor` ADD UNIQUE KEY `visitorname` (`visitorname`);

CREATE TABLE `employee` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(128) NOT NULL, `present` bit(1) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

GRANT ALL PRIVILEGES ON qdvrdb.* TO qdvr@localhost IDENTIFIED BY "changeme";

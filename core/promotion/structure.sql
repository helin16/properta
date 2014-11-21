-- Setting Up Database
DROP TABLE IF EXISTS `asset`;
CREATE TABLE `asset` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`assetId` varchar(32) NOT NULL DEFAULT '',
	`filename` varchar(100) NOT NULL DEFAULT '',
	`mimeType` varchar(50) NOT NULL DEFAULT '',
	`content` varchar(50) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,UNIQUE INDEX (`assetId`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`content` longtext NOT NULL ,
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`key` varchar(32) NOT NULL DEFAULT '',
	`street` varchar(100) NOT NULL DEFAULT '',
	`city` varchar(20) NOT NULL DEFAULT '',
	`region` varchar(20) NOT NULL DEFAULT '',
	`country` varchar(20) NOT NULL DEFAULT '',
	`postCode` varchar(10) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,INDEX (`city`)
	,INDEX (`region`)
	,INDEX (`country`)
	,INDEX (`postCode`)
	,INDEX (`key`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `property`;
CREATE TABLE `property` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`pKey` varchar(32) NOT NULL DEFAULT '',
	`description` text NOT NULL ,
	`addressId` int(10) unsigned NULL DEFAULT NULL,
	`noOfRooms` int(10) unsigned NOT NULL DEFAULT 0,
	`noOfCars` int(10) unsigned NOT NULL DEFAULT 0,
	`noOfBaths` int(10) unsigned NOT NULL DEFAULT 0,
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`addressId`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,INDEX (`noOfRooms`)
	,INDEX (`noOfCars`)
	,INDEX (`noOfBaths`)
	,UNIQUE INDEX (`pKey`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `propertyrel`;
CREATE TABLE `propertyrel` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`propertyId` int(10) unsigned NOT NULL DEFAULT 0,
	`roleId` int(10) unsigned NOT NULL DEFAULT 0,
	`userAccountId` int(10) unsigned NOT NULL DEFAULT 0,
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`propertyId`)
	,INDEX (`roleId`)
	,INDEX (`userAccountId`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`libraryId` int(10) unsigned NOT NULL DEFAULT 0,
	`transId` varchar(100) NOT NULL DEFAULT '',
	`type` varchar(100) NOT NULL DEFAULT '',
	`entityId` int(10) unsigned NOT NULL DEFAULT 0,
	`entityName` varchar(100) NOT NULL DEFAULT '',
	`funcName` varchar(100) NOT NULL DEFAULT '',
	`msg` LONGTEXT NOT NULL ,
	`comments` varchar(255) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`libraryId`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,INDEX (`transId`)
	,INDEX (`entityId`)
	,INDEX (`entityName`)
	,INDEX (`type`)
	,INDEX (`funcName`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,UNIQUE INDEX (`name`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`key` varchar(32) NOT NULL DEFAULT '',
	`data` longtext NOT NULL ,
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,UNIQUE INDEX (`key`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `systemsettings`;
CREATE TABLE `systemsettings` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`type` varchar(50) NOT NULL DEFAULT '',
	`value` varchar(255) NOT NULL DEFAULT '',
	`description` varchar(100) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,UNIQUE INDEX (`type`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`email` varchar(100) NOT NULL DEFAULT '',
	`password` varchar(40) NOT NULL DEFAULT '',
	`firstName` varchar(50) NOT NULL DEFAULT '',
	`lastName` varchar(50) NOT NULL DEFAULT '',
	`active` bool NOT NULL DEFAULT 1,
	`created` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
	`createdById` int(10) unsigned NOT NULL DEFAULT 0,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updatedById` int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
	,INDEX (`createdById`)
	,INDEX (`updatedById`)
	,INDEX (`password`)
	,INDEX (`firstName`)
	,INDEX (`lastName`)
	,UNIQUE INDEX (`email`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

-- Completed CRUD Setup.
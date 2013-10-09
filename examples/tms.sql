-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 19. Jul 2013 um 21:00
-- Server Version: 5.5.28
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `tms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `backendusers`
--

CREATE TABLE IF NOT EXISTS `backendusers` (
  `dbID_partners` int(11) NOT NULL AUTO_INCREMENT,
  `partnerID` text NOT NULL,
  `partnerName` text NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`dbID_partners`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `backendusers`
--

INSERT INTO `backendusers` (`dbID_partners`, `partnerID`, `partnerName`, `version`) VALUES
(1, '1', 'GeorgOpitz', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `entities`
--

CREATE TABLE IF NOT EXISTS `entities` (
  `dbID` int(11) NOT NULL AUTO_INCREMENT,
  `entityID` text NOT NULL,
  `entityPartnerID` text NOT NULL,
  `entityName` text NOT NULL,
  `entityValue` text NOT NULL,
  `entityRequired` tinyint(1) NOT NULL DEFAULT '0',
  `entityDataType` text NOT NULL,
  `entityActive` tinyint(1) NOT NULL DEFAULT '0',
  `version` text NOT NULL,
  PRIMARY KEY (`dbID`),
  KEY `dbID` (`dbID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Daten für Tabelle `entities`
--

INSERT INTO `entities` (`dbID`, `entityID`, `entityPartnerID`, `entityName`, `entityValue`, `entityRequired`, `entityDataType`, `entityActive`, `version`) VALUES
(72, '20000001', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(73, '20000002', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(74, '20000003', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(75, '20000004', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(76, '20000005', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(77, '20000006', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(78, '20000007', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(79, '20000008', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(80, '20000009', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(81, '20000010', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(82, '20000011', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(83, '20000012', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(84, '20000013', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(85, '20000014', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(86, '20000015', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(87, '20000016', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(88, '20000017', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, 'deprecated'),
(89, '20000018', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, 'deprecated'),
(90, '20000019', '10000001', 'jl13-firstname', 'Simon', 1, 'string', 1, ''),
(91, '20000020', '10000001', 'jl13-lastname', 'Opitz', 1, 'string', 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `entityList`
--

CREATE TABLE IF NOT EXISTS `entityList` (
  `entityListID` int(11) NOT NULL AUTO_INCREMENT,
  `entityItemName` text NOT NULL,
  `entityItemType` text NOT NULL,
  PRIMARY KEY (`entityListID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `entityList`
--

INSERT INTO `entityList` (`entityListID`, `entityItemName`, `entityItemType`) VALUES
(1, 'jl13-firstname', 'string'),
(2, 'jl13-lastname', 'string');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `partner_has_projects`
--

CREATE TABLE IF NOT EXISTS `partner_has_projects` (
  `phpID` int(11) NOT NULL AUTO_INCREMENT,
  `partnerID` text NOT NULL,
  `projectShortcut` text NOT NULL,
  PRIMARY KEY (`phpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `partner_has_projects`
--

INSERT INTO `partner_has_projects` (`phpID`, `partnerID`, `projectShortcut`) VALUES
(1, '10000001', 'jl13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `dbID_projects` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` text NOT NULL,
  `projectShortcut` text NOT NULL,
  `projectOwner` text NOT NULL,
  `projectStart` datetime NOT NULL,
  `projectEnd` datetime NOT NULL,
  `projectActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dbID_projects`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `projects`
--

INSERT INTO `projects` (`dbID_projects`, `projectName`, `projectShortcut`, `projectOwner`, `projectStart`, `projectEnd`, `projectActive`) VALUES
(1, 'JESUSlive Conference 2013', 'jl13', 'GeorgOpitz', '2013-07-19 00:00:00', '2014-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project_has_entities`
--

CREATE TABLE IF NOT EXISTS `project_has_entities` (
  `pheID` int(11) NOT NULL AUTO_INCREMENT,
  `projectShortcut` text NOT NULL,
  `entityName` text NOT NULL,
  PRIMARY KEY (`pheID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `project_has_entities`
--

INSERT INTO `project_has_entities` (`pheID`, `projectShortcut`, `entityName`) VALUES
(1, 'jl13', 'jl13-firstname'),
(2, 'jl13', 'jl13-lastname');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `slider`
--

INSERT INTO `slider` (`id`, `filename`) VALUES
(1, '01_universal.jpg'),
(2, '02_universal.jpg'),
(3, '03_universal.jpg'),
(4, '04_universal.jpg'),
(5, '05_universal.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `upload`
--

INSERT INTO `upload` (`id`, `filename`) VALUES
(1, 'picture1.jpg'),
(2, 'picture2.jpg'),
(3, 'picture3.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

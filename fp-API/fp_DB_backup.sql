-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Décembre 2014 à 10:43
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `fp`
--

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

CREATE TABLE IF NOT EXISTS `friendship` (
  `idFriendship` int(11) NOT NULL AUTO_INCREMENT,
  `idFriend1` int(11) NOT NULL,
  `idFriend2` int(11) NOT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`idFriendship`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `friendship`
--

INSERT INTO `friendship` (`idFriendship`, `idFriend1`, `idFriend2`, `state`) VALUES
(1, 1, 3, ''),
(2, 1, 4, ''),
(3, 3, 4, ''),
(4, 3, 5, ''),
(5, 1, 5, 'pending'),
(6, 1, 7, 'pending'),
(7, 1, 10, 'pending'),
(8, 7, 1, 'pending'),
(9, 1, 11, 'pending'),
(10, 1, 11, 'pending'),
(11, 7, 3, 'pending'),
(12, 7, 4, 'pending'),
(13, 7, 4, 'pending'),
(14, 7, 15, 'pending'),
(15, 27, 3, 'pending'),
(16, 27, 15, 'pending'),
(17, 27, 4, 'pending'),
(18, 7, 24, 'pending'),
(19, 7, 24, 'pending'),
(20, 7, 25, 'pending'),
(21, 7, 26, 'pending'),
(22, 7, 27, 'pending'),
(23, 3, 1, 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `registration_id`, `username`, `password`) VALUES
(1, '', 'Arnaud', 'pouet'),
(2, '', 'Hervé', ''),
(3, 'APA91bEMi2N_BdOEf9VxeCqKuAqaZs_PMeVmman3npn8guclh1Db27_v1cuww1cueW0Y2TgnfUpFUPZ2z9-PHxQ5YMSxW7qnyn0nVpTdsvrKma76Yt9lQNacZ10UgKuYWQxfyrXnowG1WifsHGsyBx3RuPGFzQkTC1gRm2kMlbOjsjUHFFz8hb0', 'Charles', '123'),
(4, 'dazdzafsqsdcxbgezsqdza', 'Pierre', '123'),
(5, 'adzadxxxxxx', 'Robert', ''),
(6, '', 'Paul', ''),
(7, '', 'Coralie', ''),
(8, '', 'François', ''),
(9, '', 'Dede', ''),
(10, '', 'Herbert', '1234'),
(11, '', 'Manu', 'aze'),
(12, '', 'Yolo', 'lad'),
(13, '', 'zqdda', 'aa'),
(15, '', 'aze', 'aa'),
(16, '', 'azez', 'aa'),
(17, '', 'azez1', 'aa'),
(18, '', 'azez2', 'lad'),
(19, '', 'azez3', 'aa'),
(20, '', 'azez4', 'aa'),
(21, '', 'azez54', 'aa'),
(22, '', 'andre', 'aa'),
(23, '', 'axa', 'aaaa'),
(24, '', 'Ernest', '12345'),
(26, '', 'Ernest2', '12345'),
(27, '', 'Ernest4', '12345'),
(28, '', 'Godz', 'pouet'),
(29, '', 'Godzz', 'pouet'),
(30, 'zadz', 'Popolo', 'aaaaaa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

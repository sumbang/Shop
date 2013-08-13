-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 12 Août 2013 à 14:31
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `idcmde` int(11) NOT NULL AUTO_INCREMENT,
  `idpdt` int(11) NOT NULL,
  `qte_cmd` int(11) NOT NULL,
  `idfacture` int(5) NOT NULL,
  PRIMARY KEY (`idcmde`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `idfacture` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idfacture`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prix` int(10) NOT NULL,
  `description` text NOT NULL,
  `qte` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `prix`, `description`, `qte`) VALUES
(1, 'iPhone 5 ', 465000, 'zrjgzg rg zg f zffnzfz g rejgbrgerg ejbzefzerg g kjgbergetg jzrgberg e jergetgethn g eg eth jzrgeth g zjgzrg e bz zr r, jkth, zef z grn jkfbje z zrgrz gzr rgnzr   zgzrbgjzrg  zg jrgr zn grz rjg rgng zrjgb jlgzblfnzf g brege rngbzr', 50),
(2, 'Samsung Galaxy s4', 425000, 'zrjgzg rg zg f zffnzfz g rejgbrgerg ejbzefzerg g kjgbergetg jzrgberg e jergetgethn g eg eth jzrgeth g zjgzrg e bz zr r, jkth, zef z grn jkfbje z zrgrz gzr rgnzr   zgzrbgjzrg  zg jrgr zn grz rjg rgng zrjgb jlgzblfnzf g brege rngbzr', 20),
(3, 'Alcatel One touch Scribe HD', 180000, 'zrjgzg rg zg f zffnzfz g rejgbrgerg ejbzefzerg g kjgbergetg jzrgberg e jergetgethn g eg eth jzrgeth g zjgzrg e bz zr r, jkth, zef z grn jkfbje z zrgrz gzr rgnzr   zgzrbgjzrg  zg jrgr zn grz rjg rgng zrjgb jlgzblfnzf g brege rngbzr', 10),
(4, 'Ordinateur portable', 365000, 'zrjgzg rg zg f zffnzfz g rejgbrgerg ejbzefzerg g kjgbergetg jzrgberg e jergetgethn g eg eth jzrgeth g zjgzrg e bz zr r, jkth, zef z grn jkfbje z zrgrz gzr rgnzr   zgzrbgjzrg  zg jrgr zn grz rjg rgng zrjgb jlgzblfnzf g brege rngbzr', 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

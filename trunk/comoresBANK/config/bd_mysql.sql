-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 03 Septembre 2010 à 18:36
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `pm22db1`
--

-- --------------------------------------------------------

--
-- Structure de la table `account_rights`
--

CREATE TABLE IF NOT EXISTS `account_rights` (
  `id` int(10) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `i18nkey` varchar(100) DEFAULT NULL,
  `id_user` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `account_rights`
--

INSERT INTO `account_rights` (`id`, `label`, `i18nkey`, `id_user`) VALUES
(1, 'USER', NULL, 1),
(2, 'ADMIN', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `account_user`
--

CREATE TABLE IF NOT EXISTS `account_user` (
  `id_user` int(11) DEFAULT NULL,
  `login_user` varchar(50) DEFAULT NULL,
  `email_user` varchar(50) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `last_login` date DEFAULT NULL,
  `cpt_num` varchar(24) DEFAULT NULL,
  `password_user` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `account_user`
--

INSERT INTO `account_user` (`id_user`, `login_user`, `email_user`, `date_creation`, `last_login`, `cpt_num`, `password_user`) VALUES
(1, 'test', NULL, NULL, NULL, '1', '8cb2237d0679ca88db6464eac60da96345513964');

-- --------------------------------------------------------

--
-- Structure de la table `t_cpt`
--

CREATE TABLE IF NOT EXISTS `t_cpt` (
  `cpt_num` varchar(24) DEFAULT NULL,
  `cpt_desc` varchar(24) DEFAULT NULL,
  `cpt_solde` int(10) DEFAULT NULL,
  `cpt_date_solde` date DEFAULT NULL,
  `cpt_holder_prenom` varchar(24) DEFAULT NULL,
  `cpt_holder_nom` varchar(24) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_cpt`
--

INSERT INTO `t_cpt` (`cpt_num`, `cpt_desc`, `cpt_solde`, `cpt_date_solde`, `cpt_holder_prenom`, `cpt_holder_nom`) VALUES
('1', 'test', 400, '2010-09-14', 'Albert ', 'Einstein');

-- --------------------------------------------------------

--
-- Structure de la table `t_trx`
--

CREATE TABLE IF NOT EXISTS `t_trx` (
  `trx_num` varchar(32) DEFAULT NULL,
  `trx_cpt_num` varchar(24) DEFAULT NULL,
  `trx_desc` varchar(255) DEFAULT NULL,
  `trx_date_valeur` date DEFAULT NULL,
  `trx_mnt_debit` int(10) DEFAULT NULL,
  `trx_mnt_credit` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_trx`
--


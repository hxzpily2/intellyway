-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 16 Février 2010 à 09:30
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `bedreamy_amji`
--

-- --------------------------------------------------------

--
-- Structure de la table `amji_cast_request`
--

CREATE TABLE IF NOT EXISTS `amji_cast_request` (
  `idamji_request` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_request`),
  KEY `iduser_idx` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_cast_request`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_cast_response`
--

CREATE TABLE IF NOT EXISTS `amji_cast_response` (
  `idamji_response` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_response`),
  KEY `iduser_idx` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_cast_response`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_contacts`
--

CREATE TABLE IF NOT EXISTS `amji_contacts` (
  `idamji_user` int(11) NOT NULL DEFAULT '0',
  `idamji_invite` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`,`idamji_invite`),
  KEY `amji_contacts_idamji_invite_amji_user_idamji_user` (`idamji_invite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_contacts`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_emoticones`
--

CREATE TABLE IF NOT EXISTS `amji_emoticones` (
  `idamji_emoticones` int(11) NOT NULL AUTO_INCREMENT,
  `racourci` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_emoticones`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_emoticones`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_event`
--

CREATE TABLE IF NOT EXISTS `amji_event` (
  `idamji_event` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `title` text NOT NULL,
  `iduser` int(11) NOT NULL,
  `datedebut` datetime NOT NULL,
  `datefin` datetime NOT NULL,
  `active` tinyint(4) NOT NULL,
  `idtype` int(11) NOT NULL,
  `idpriorite` int(11) NOT NULL,
  `idnotif` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_event`),
  KEY `iduser_idx` (`iduser`),
  KEY `idtype_idx` (`idtype`),
  KEY `idpriorite_idx` (`idpriorite`),
  KEY `idnotif_idx` (`idnotif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_event`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_event_attachment`
--

CREATE TABLE IF NOT EXISTS `amji_event_attachment` (
  `idamji_event` int(11) NOT NULL DEFAULT '0',
  `idamji_file` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_event`,`idamji_file`),
  KEY `amji_event_attachment_idamji_file_amji_file_idamji_file` (`idamji_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_event_attachment`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_event_notification`
--

CREATE TABLE IF NOT EXISTS `amji_event_notification` (
  `idamji_notif` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `periode` int(11) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `notifmail` tinyint(4) NOT NULL,
  `notifsms` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_notif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_event_notification`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_event_user`
--

CREATE TABLE IF NOT EXISTS `amji_event_user` (
  `idamji_user` int(11) NOT NULL DEFAULT '0',
  `idamji_event` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`,`idamji_event`),
  KEY `amji_event_user_idamji_event_amji_event_idamji_event` (`idamji_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_event_user`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_file`
--

CREATE TABLE IF NOT EXISTS `amji_file` (
  `idamji_file` int(11) NOT NULL AUTO_INCREMENT,
  `content` longblob NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_file`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_group`
--

CREATE TABLE IF NOT EXISTS `amji_group` (
  `idamji_group` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `owner` int(11) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_invitation`
--

CREATE TABLE IF NOT EXISTS `amji_invitation` (
  `idamji_user` int(11) NOT NULL DEFAULT '0',
  `idamji_invite` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `accepted` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`,`idamji_invite`),
  KEY `amji_invitation_idamji_invite_amji_user_idamji_user` (`idamji_invite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_invitation`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_priorite`
--

CREATE TABLE IF NOT EXISTS `amji_priorite` (
  `idamji_priorite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_priorite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_priorite`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_priorite_event`
--

CREATE TABLE IF NOT EXISTS `amji_priorite_event` (
  `idamji_priorite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_priorite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_priorite_event`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_request`
--

CREATE TABLE IF NOT EXISTS `amji_request` (
  `idamji_request` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `iduser` int(11) NOT NULL,
  `idpriorite` int(11) NOT NULL,
  `idtype` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_request`),
  KEY `iduser_idx` (`iduser`),
  KEY `idpriorite_idx` (`idpriorite`),
  KEY `idtype_idx` (`idtype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_request`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_request_attachment`
--

CREATE TABLE IF NOT EXISTS `amji_request_attachment` (
  `idamji_file` int(11) NOT NULL DEFAULT '0',
  `idamji_request` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_file`,`idamji_request`),
  KEY `aiai_3` (`idamji_request`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_request_attachment`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_request_group`
--

CREATE TABLE IF NOT EXISTS `amji_request_group` (
  `idamji_request` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `iduser` int(11) NOT NULL,
  `idpriorite` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_request`),
  KEY `iduser_idx` (`iduser`),
  KEY `idpriorite_idx` (`idpriorite`),
  KEY `idgroup_idx` (`idgroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_request_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_response`
--

CREATE TABLE IF NOT EXISTS `amji_response` (
  `idamji_response` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `iduser` int(11) NOT NULL,
  `idrequest` int(11) NOT NULL,
  `idresponse` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_response`),
  KEY `iduser_idx` (`iduser`),
  KEY `idrequest_idx` (`idrequest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_response`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_response_attachment`
--

CREATE TABLE IF NOT EXISTS `amji_response_attachment` (
  `idamji_response` int(11) NOT NULL DEFAULT '0',
  `idamji_file` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_response`,`idamji_file`),
  KEY `amji_response_attachment_idamji_file_amji_file_idamji_file` (`idamji_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_response_attachment`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_response_group`
--

CREATE TABLE IF NOT EXISTS `amji_response_group` (
  `idamji_response` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `iduser` int(11) NOT NULL,
  `idrequest` int(11) NOT NULL,
  `idresponse` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_response`),
  KEY `iduser_idx` (`iduser`),
  KEY `idrequest_idx` (`idrequest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_response_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_response_group_attachment`
--

CREATE TABLE IF NOT EXISTS `amji_response_group_attachment` (
  `idamji_response` int(11) NOT NULL DEFAULT '0',
  `idamji_file` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_response`,`idamji_file`),
  KEY `amji_response_group_attachment_idamji_file_amji_file_idamji_file` (`idamji_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_response_group_attachment`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_statut`
--

CREATE TABLE IF NOT EXISTS `amji_statut` (
  `idamji_statut` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_statut`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_subscribe`
--

CREATE TABLE IF NOT EXISTS `amji_subscribe` (
  `idamji_user` int(11) NOT NULL DEFAULT '0',
  `idamji_type` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`,`idamji_type`),
  KEY `amji_subscribe_idamji_type_amji_type_idamji_type` (`idamji_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_subscribe`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_subscribe_group`
--

CREATE TABLE IF NOT EXISTS `amji_subscribe_group` (
  `idamji_user` int(11) NOT NULL DEFAULT '0',
  `idamji_group` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`,`idamji_group`),
  KEY `amji_subscribe_group_idamji_group_amji_group_idamji_group` (`idamji_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `amji_subscribe_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_type`
--

CREATE TABLE IF NOT EXISTS `amji_type` (
  `idamji_type` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_type`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_type_event`
--

CREATE TABLE IF NOT EXISTS `amji_type_event` (
  `idamji_type` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_type_event`
--


-- --------------------------------------------------------

--
-- Structure de la table `amji_user`
--

CREATE TABLE IF NOT EXISTS `amji_user` (
  `idamji_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `civilite` varchar(5) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `humeur` varchar(100) NOT NULL DEFAULT 'HAPPY',
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adr` varchar(100) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `etudiant` tinyint(4) DEFAULT NULL,
  `ecole` varchar(100) DEFAULT NULL,
  `niveau` varchar(100) DEFAULT NULL,
  `salarie` tinyint(4) DEFAULT NULL,
  `statut` varchar(100) DEFAULT NULL,
  `societe` varchar(100) DEFAULT NULL,
  `image` longblob,
  `idamji_statut` int(11) DEFAULT NULL,
  `thanks` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idamji_user`),
  KEY `idamji_statut_idx` (`idamji_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `amji_user`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `sf_guard_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_group_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group_permission` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sf_guard_group_permission`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `sf_guard_permission`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_remember_key`
--

CREATE TABLE IF NOT EXISTS `sf_guard_remember_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `sf_guard_remember_key`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_user`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL DEFAULT 'sha1',
  `salt` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_super_admin` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `is_active_idx_idx` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `sf_guard_user`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_user_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_group` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `sf_guard_user_group_group_id_sf_guard_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sf_guard_user_group`
--


-- --------------------------------------------------------

--
-- Structure de la table `sf_guard_user_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_permission` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sf_guard_user_permission`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `amji_cast_request`
--
ALTER TABLE `amji_cast_request`
  ADD CONSTRAINT `amji_cast_request_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_cast_response`
--
ALTER TABLE `amji_cast_response`
  ADD CONSTRAINT `amji_cast_response_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_contacts`
--
ALTER TABLE `amji_contacts`
  ADD CONSTRAINT `amji_contacts_idamji_invite_amji_user_idamji_user` FOREIGN KEY (`idamji_invite`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_event`
--
ALTER TABLE `amji_event`
  ADD CONSTRAINT `amji_event_idnotif_amji_event_notification_idamji_notif` FOREIGN KEY (`idnotif`) REFERENCES `amji_event_notification` (`idamji_notif`),
  ADD CONSTRAINT `amji_event_idpriorite_amji_priorite_event_idamji_priorite` FOREIGN KEY (`idpriorite`) REFERENCES `amji_priorite_event` (`idamji_priorite`),
  ADD CONSTRAINT `amji_event_idtype_amji_type_event_idamji_type` FOREIGN KEY (`idtype`) REFERENCES `amji_type_event` (`idamji_type`),
  ADD CONSTRAINT `amji_event_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_event_attachment`
--
ALTER TABLE `amji_event_attachment`
  ADD CONSTRAINT `amji_event_attachment_idamji_event_amji_event_idamji_event` FOREIGN KEY (`idamji_event`) REFERENCES `amji_event` (`idamji_event`),
  ADD CONSTRAINT `amji_event_attachment_idamji_file_amji_file_idamji_file` FOREIGN KEY (`idamji_file`) REFERENCES `amji_file` (`idamji_file`);

--
-- Contraintes pour la table `amji_event_user`
--
ALTER TABLE `amji_event_user`
  ADD CONSTRAINT `amji_event_user_idamji_event_amji_event_idamji_event` FOREIGN KEY (`idamji_event`) REFERENCES `amji_event` (`idamji_event`),
  ADD CONSTRAINT `amji_event_user_idamji_user_amji_user_idamji_user` FOREIGN KEY (`idamji_user`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_invitation`
--
ALTER TABLE `amji_invitation`
  ADD CONSTRAINT `amji_invitation_idamji_invite_amji_user_idamji_user` FOREIGN KEY (`idamji_invite`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_request`
--
ALTER TABLE `amji_request`
  ADD CONSTRAINT `amji_request_idpriorite_amji_priorite_idamji_priorite` FOREIGN KEY (`idpriorite`) REFERENCES `amji_priorite` (`idamji_priorite`),
  ADD CONSTRAINT `amji_request_idtype_amji_type_idamji_type` FOREIGN KEY (`idtype`) REFERENCES `amji_type` (`idamji_type`),
  ADD CONSTRAINT `amji_request_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_request_attachment`
--
ALTER TABLE `amji_request_attachment`
  ADD CONSTRAINT `aiai_3` FOREIGN KEY (`idamji_request`) REFERENCES `amji_request` (`idamji_request`),
  ADD CONSTRAINT `amji_request_attachment_idamji_file_amji_file_idamji_file` FOREIGN KEY (`idamji_file`) REFERENCES `amji_file` (`idamji_file`);

--
-- Contraintes pour la table `amji_request_group`
--
ALTER TABLE `amji_request_group`
  ADD CONSTRAINT `amji_request_group_idgroup_amji_group_idamji_group` FOREIGN KEY (`idgroup`) REFERENCES `amji_group` (`idamji_group`),
  ADD CONSTRAINT `amji_request_group_idpriorite_amji_priorite_idamji_priorite` FOREIGN KEY (`idpriorite`) REFERENCES `amji_priorite` (`idamji_priorite`),
  ADD CONSTRAINT `amji_request_group_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_response`
--
ALTER TABLE `amji_response`
  ADD CONSTRAINT `amji_response_idrequest_amji_request_idamji_request` FOREIGN KEY (`idrequest`) REFERENCES `amji_request` (`idamji_request`),
  ADD CONSTRAINT `amji_response_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_response_attachment`
--
ALTER TABLE `amji_response_attachment`
  ADD CONSTRAINT `aiai_6` FOREIGN KEY (`idamji_response`) REFERENCES `amji_response` (`idamji_response`),
  ADD CONSTRAINT `amji_response_attachment_idamji_file_amji_file_idamji_file` FOREIGN KEY (`idamji_file`) REFERENCES `amji_file` (`idamji_file`);

--
-- Contraintes pour la table `amji_response_group`
--
ALTER TABLE `amji_response_group`
  ADD CONSTRAINT `amji_response_group_idrequest_amji_request_group_idamji_request` FOREIGN KEY (`idrequest`) REFERENCES `amji_request_group` (`idamji_request`),
  ADD CONSTRAINT `amji_response_group_iduser_amji_user_idamji_user` FOREIGN KEY (`iduser`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_response_group_attachment`
--
ALTER TABLE `amji_response_group_attachment`
  ADD CONSTRAINT `aiai_9` FOREIGN KEY (`idamji_response`) REFERENCES `amji_response_group` (`idamji_response`),
  ADD CONSTRAINT `amji_response_group_attachment_idamji_file_amji_file_idamji_file` FOREIGN KEY (`idamji_file`) REFERENCES `amji_file` (`idamji_file`);

--
-- Contraintes pour la table `amji_subscribe`
--
ALTER TABLE `amji_subscribe`
  ADD CONSTRAINT `amji_subscribe_idamji_type_amji_type_idamji_type` FOREIGN KEY (`idamji_type`) REFERENCES `amji_type` (`idamji_type`),
  ADD CONSTRAINT `amji_subscribe_idamji_user_amji_user_idamji_user` FOREIGN KEY (`idamji_user`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_subscribe_group`
--
ALTER TABLE `amji_subscribe_group`
  ADD CONSTRAINT `amji_subscribe_group_idamji_group_amji_group_idamji_group` FOREIGN KEY (`idamji_group`) REFERENCES `amji_group` (`idamji_group`),
  ADD CONSTRAINT `amji_subscribe_group_idamji_user_amji_user_idamji_user` FOREIGN KEY (`idamji_user`) REFERENCES `amji_user` (`idamji_user`);

--
-- Contraintes pour la table `amji_user`
--
ALTER TABLE `amji_user`
  ADD CONSTRAINT `amji_user_idamji_statut_amji_statut_idamji_statut` FOREIGN KEY (`idamji_statut`) REFERENCES `amji_statut` (`idamji_statut`);

--
-- Contraintes pour la table `sf_guard_group_permission`
--
ALTER TABLE `sf_guard_group_permission`
  ADD CONSTRAINT `sf_guard_group_permission_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_group_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sf_guard_remember_key`
--
ALTER TABLE `sf_guard_remember_key`
  ADD CONSTRAINT `sf_guard_remember_key_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sf_guard_user_group`
--
ALTER TABLE `sf_guard_user_group`
  ADD CONSTRAINT `sf_guard_user_group_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_group_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sf_guard_user_permission`
--
ALTER TABLE `sf_guard_user_permission`
  ADD CONSTRAINT `sf_guard_user_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_permission_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

-- phpMyAdmin SQL Dump
-- version 2.6.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Lundi 29 Août 2005 à 16:28
-- Version du serveur: 4.0.24
-- Version de PHP: 4.3.10-15
-- 
-- Base de données: `gescom`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_adresses`
-- 

DROP TABLE IF EXISTS `gescom_adresses`;
CREATE TABLE `gescom_adresses` (
  `adresse_id` mediumint(6) unsigned NOT NULL auto_increment,
  `civilite` enum('M','Mme','Mlle') NOT NULL default 'M',
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `adresse` text NOT NULL,
  `code_postal` varchar(6) NOT NULL default '',
  `ville` varchar(50) NOT NULL default '',
  `pays` varchar(50) NOT NULL default '',
  `telephone` varchar(15) NOT NULL default '',
  `portable` varchar(15) NOT NULL default '',
  `telecopie` varchar(15) NOT NULL default '',
  `client_id` mediumint(6) unsigned NOT NULL default '0',
  `enable` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`adresse_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_articles`
-- 

DROP TABLE IF EXISTS `gescom_articles`;
CREATE TABLE `gescom_articles` (
  `article_id` int(7) unsigned NOT NULL auto_increment,
  `ref_article` varchar(15) NOT NULL default '',
  `code_sous_famille` smallint(4) unsigned NOT NULL default '0',
  `prix_vente_ht` mediumint(6) unsigned NOT NULL default '0',
  `descriptif_article` text NOT NULL,
  `publie_site` enum('N','Y') NOT NULL default 'N',
  `mise_en_veille` enum('N','Y') NOT NULL default 'N',
  `stat_out` enum('N','Y') NOT NULL default 'N',
  `designation` varchar(69) NOT NULL default '',
  `date_creation` int(8) unsigned NOT NULL default '0',
  `date_modif` int(8) unsigned NOT NULL default '0',
  `compte_france` int(10) unsigned NOT NULL default '0',
  `compte_corse` int(10) unsigned NOT NULL default '0',
  `compte_domtom` int(10) unsigned NOT NULL default '0',
  `compte_cee` int(10) unsigned NOT NULL default '0',
  `compte_export` int(10) unsigned NOT NULL default '0',
  `compte_exoneree` int(10) unsigned NOT NULL default '0',
  `compte_parafiscal` smallint(2) unsigned NOT NULL default '0',
  `nouveaute` int(8) unsigned NOT NULL default '0',
  `ccv` varchar(20) NOT NULL default '',
  `stock` int(6) NOT NULL default '0',
  `stock_reserve` mediumint(8) unsigned NOT NULL default '0',
  `stock_commande` int(6) unsigned NOT NULL default '0',
  `readable_stock` enum('N','Y') NOT NULL default 'N',
  `negativ_stock` enum('N','Y') NOT NULL default 'N',
  `PUM` int(8) unsigned NOT NULL default '0',
  `mega_promo` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`article_id`),
  UNIQUE KEY `reference` (`ref_article`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_articles_color`
-- 

DROP TABLE IF EXISTS `gescom_articles_color`;
CREATE TABLE `gescom_articles_color` (
  `color_id` int(8) NOT NULL default '0',
  `article_id` int(8) NOT NULL default '0',
  `enable` enum('N','Y') NOT NULL default 'N'
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_articles_size`
-- 

DROP TABLE IF EXISTS `gescom_articles_size`;
CREATE TABLE `gescom_articles_size` (
  `article_id` int(8) NOT NULL default '0',
  `size_id` int(8) NOT NULL default '0',
  `enable` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`article_id`,`size_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_ban_list`
-- 

DROP TABLE IF EXISTS `gescom_ban_list`;
CREATE TABLE `gescom_ban_list` (
  `ip` varchar(15) NOT NULL default '',
  `date` int(8) NOT NULL default '0',
  `heure` varchar(5) NOT NULL default ''
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_cate_fiscale`
-- 

DROP TABLE IF EXISTS `gescom_cate_fiscale`;
CREATE TABLE `gescom_cate_fiscale` (
  `cate_id` tinyint(1) unsigned NOT NULL auto_increment,
  `categorie` varchar(10) NOT NULL default '',
  `cate_data` varchar(10) NOT NULL default '',
  `compte_collectif_id` tinyint(1) unsigned NOT NULL default '0',
  `expedition` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cate_id`),
  UNIQUE KEY `UNIQUE` (`cate_data`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_client_sessions`
-- 

DROP TABLE IF EXISTS `gescom_client_sessions`;
CREATE TABLE `gescom_client_sessions` (
  `session_id` mediumint(6) unsigned NOT NULL auto_increment,
  `sid` varchar(255) NOT NULL default '',
  `client_id` smallint(4) unsigned NOT NULL default '0',
  `begin_session` time NOT NULL default '00:00:00',
  `last_activ` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`session_id`),
  UNIQUE KEY `sid` (`sid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_clients`
-- 

DROP TABLE IF EXISTS `gescom_clients`;
CREATE TABLE `gescom_clients` (
  `client_id` mediumint(6) unsigned NOT NULL auto_increment,
  `code_client` varchar(20) NOT NULL default '',
  `civilite` enum('M','Mme','Mlle') NOT NULL default 'M',
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `identifiant` varchar(50) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `raison_sociale` varchar(50) NOT NULL default '',
  `adresse` text NOT NULL,
  `code_postal` mediumint(6) NOT NULL default '0',
  `ville` varchar(50) NOT NULL default '',
  `pays` varchar(50) NOT NULL default '',
  `telephone` varchar(15) NOT NULL default '',
  `telecopie` varchar(15) NOT NULL default '',
  `portable` varchar(15) NOT NULL default '',
  `nom_contact` varchar(50) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `nif` varchar(20) NOT NULL default '',
  `naf` varchar(4) NOT NULL default '',
  `siret` varchar(13) NOT NULL default '',
  `representant_id` smallint(4) unsigned NOT NULL default '0',
  `actif` enum('N','Y') NOT NULL default 'N',
  `stat_out` enum('N','Y') NOT NULL default 'N',
  `date_inscription` int(8) NOT NULL default '0',
  `facult1` mediumint(4) unsigned NOT NULL default '0',
  `facult2` mediumint(4) unsigned NOT NULL default '0',
  `facult3` mediumint(4) unsigned NOT NULL default '0',
  `compte_comptable` varchar(20) NOT NULL default '',
  `compte_auxiliaire` varchar(20) NOT NULL default '',
  `cate_fiscale` enum('France','Export','CEE','Exonérée','Corse','DOM TOM') NOT NULL default 'France',
  `ML` enum('N','Y') NOT NULL default 'N',
  `mode_id` smallint(3) unsigned NOT NULL default '0',
  `regl_sur` tinyint(2) unsigned NOT NULL default '0',
  `regl_au` tinyint(2) unsigned NOT NULL default '0',
  `groupement_id` mediumint(4) unsigned NOT NULL default '0',
  `last_ml` int(8) unsigned NOT NULL default '0',
  `prospect` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`client_id`)
) TYPE=MyISAM PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_color`
-- 

DROP TABLE IF EXISTS `gescom_color`;
CREATE TABLE `gescom_color` (
  `color_id` int(8) NOT NULL auto_increment,
  `color` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`color_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_commande_articles`
-- 

DROP TABLE IF EXISTS `gescom_commande_articles`;
CREATE TABLE `gescom_commande_articles` (
  `ligne_id` int(8) unsigned NOT NULL auto_increment,
  `article_id` int(7) unsigned NOT NULL default '0',
  `quantite` smallint(4) NOT NULL default '0',
  `commande_id` int(7) unsigned NOT NULL default '0',
  `size` int(8) NOT NULL default '0',
  `color` int(8) NOT NULL default '0',
  `prix_vente_ht` mediumint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ligne_id`),
  KEY `article_unique` (`article_id`,`commande_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_commandes`
-- 

DROP TABLE IF EXISTS `gescom_commandes`;
CREATE TABLE `gescom_commandes` (
  `commande_id` int(7) unsigned NOT NULL auto_increment,
  `ref_commande` int(7) unsigned NOT NULL default '0',
  `client_id` int(8) unsigned NOT NULL default '0',
  `code_etat` tinyint(2) unsigned NOT NULL default '0',
  `mode_reglement_id` tinyint(2) unsigned NOT NULL default '0',
  `code_livraison` mediumint(4) unsigned NOT NULL default '0',
  `code_facturation` mediumint(4) unsigned NOT NULL default '0',
  `status` enum('Commande','Reliquat','Avoir') NOT NULL default 'Commande',
  `date_commande` int(8) unsigned NOT NULL default '0',
  `date_confirm` int(8) unsigned NOT NULL default '0',
  `date_livraison` int(8) unsigned NOT NULL default '0',
  `date_facturation` int(8) unsigned NOT NULL default '0',
  `date_reglement` int(8) unsigned NOT NULL default '0',
  `date_livraison_voulue` int(8) unsigned NOT NULL default '0',
  `date_livraison_prevue` int(8) unsigned NOT NULL default '0',
  `date_reglement_prevue` int(8) unsigned NOT NULL default '0',
  `adresse_liv` int(8) NOT NULL default '0',
  `adresse_fact` int(8) NOT NULL default '0',
  `expedition` enum('slow','standard','fast') NOT NULL default 'standard',
  `reglement` enum('cb','chq','mandat') NOT NULL default 'cb',
  PRIMARY KEY  (`commande_id`),
  KEY `unique_status` (`ref_commande`,`status`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_comptes_collectifs`
-- 

DROP TABLE IF EXISTS `gescom_comptes_collectifs`;
CREATE TABLE `gescom_comptes_collectifs` (
  `compte_id` tinyint(2) unsigned NOT NULL auto_increment,
  `compte` varchar(10) NOT NULL default '',
  `default` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`compte_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_comptes_parafiscaux`
-- 

DROP TABLE IF EXISTS `gescom_comptes_parafiscaux`;
CREATE TABLE `gescom_comptes_parafiscaux` (
  `compte_id` smallint(2) unsigned NOT NULL auto_increment,
  `compte` varchar(20) NOT NULL default '',
  `apply_on` enum('HT','TTC') NOT NULL default 'HT',
  `tpf` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`compte_id`)
) TYPE=MyISAM COMMENT='Comptes parasfiscaux';

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_comptes_tva`
-- 

DROP TABLE IF EXISTS `gescom_comptes_tva`;
CREATE TABLE `gescom_comptes_tva` (
  `compte_id` smallint(5) unsigned NOT NULL auto_increment,
  `compte` varchar(20) NOT NULL default '0',
  `tva` smallint(4) unsigned NOT NULL default '0',
  `cate_fiscale` enum('France','Corse','DOM TOM','CEE','Export','Exonérée') NOT NULL default 'France',
  `default` enum('N','Y') NOT NULL default 'N',
  `compte_gnl_vente` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`compte_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_conf`
-- 

DROP TABLE IF EXISTS `gescom_conf`;
CREATE TABLE `gescom_conf` (
  `back_site_name` varchar(50) NOT NULL default '',
  `cle` varchar(255) NOT NULL default '',
  `raison_sociale` varchar(255) NOT NULL default '',
  `adresse` text NOT NULL,
  `code_postal` mediumint(6) unsigned NOT NULL default '0',
  `ville` varchar(50) NOT NULL default '',
  `pays` varchar(50) NOT NULL default '',
  `tel` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `rcs` varchar(50) NOT NULL default '',
  `siren` varchar(50) NOT NULL default '',
  `ape` varchar(10) NOT NULL default '0',
  `nif` varchar(50) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `mail` varchar(255) NOT NULL default '',
  `facult1` varchar(50) NOT NULL default '',
  `facult1_editable` enum('N','Y') NOT NULL default 'N',
  `facult2` varchar(50) NOT NULL default '',
  `facult2_editable` enum('N','Y') NOT NULL default 'N',
  `facult3` varchar(50) NOT NULL default '',
  `facult3_editable` enum('N','Y') NOT NULL default 'N',
  `back_accueil` text NOT NULL,
  `code_journal_vente` varchar(10) NOT NULL default '',
  `logo_extention` varchar(4) NOT NULL default '',
  `nb_user_max` tinyint(3) unsigned NOT NULL default '5',
  `module_achat` enum('N','Y') NOT NULL default 'Y',
  `sitename` varchar(100) NOT NULL default '',
  `site_desc` varchar(100) NOT NULL default '',
  `mail_sig` varchar(100) NOT NULL default '',
  `site_color` varchar(10) NOT NULL default '',
  `welcome` text NOT NULL,
  `help` text NOT NULL,
  `securite` text NOT NULL,
  `livraison` text NOT NULL,
  `stores` text NOT NULL,
  `contrat` text NOT NULL,
  `cgv` text NOT NULL,
  `societe` text NOT NULL,
  `conditions` text NOT NULL,
  `colorsize` enum('N','Y') NOT NULL default 'N',
  `enable` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`cle`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_documents`
-- 

DROP TABLE IF EXISTS `gescom_documents`;
CREATE TABLE `gescom_documents` (
  `document_id` mediumint(4) unsigned NOT NULL auto_increment,
  `date` int(8) unsigned NOT NULL default '0',
  `commande_id` mediumint(4) unsigned NOT NULL default '0',
  `type` enum('Recap','ACK','BdC','BL','Facture','Avoir') NOT NULL default 'Recap',
  `exported` enum('N','Y') NOT NULL default 'N',
  `reliquat` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`document_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_expedition`
-- 

DROP TABLE IF EXISTS `gescom_expedition`;
CREATE TABLE `gescom_expedition` (
  `expedition_id` smallint(2) unsigned NOT NULL auto_increment,
  `expedition` varchar(64) NOT NULL default '',
  `slow` mediumint(5) unsigned NOT NULL default '0',
  `standard` mediumint(5) unsigned NOT NULL default '0',
  `fast` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`expedition_id`),
  KEY `expedition` (`expedition`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_facult`
-- 

DROP TABLE IF EXISTS `gescom_facult`;
CREATE TABLE `gescom_facult` (
  `option_id` mediumint(6) unsigned NOT NULL auto_increment,
  `intitule` varchar(50) NOT NULL default '',
  `facult_id` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`option_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_familles`
-- 

DROP TABLE IF EXISTS `gescom_familles`;
CREATE TABLE `gescom_familles` (
  `famille_id` smallint(4) unsigned NOT NULL auto_increment,
  `intitule` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`famille_id`),
  UNIQUE KEY `intitule` (`intitule`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_fournisseur_article`
-- 

DROP TABLE IF EXISTS `gescom_fournisseur_article`;
CREATE TABLE `gescom_fournisseur_article` (
  `fournisseur_id` int(6) unsigned NOT NULL default '0',
  `article_id` int(6) unsigned NOT NULL default '0',
  `prix_ht` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`fournisseur_id`,`article_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_fournisseurs`
-- 

DROP TABLE IF EXISTS `gescom_fournisseurs`;
CREATE TABLE `gescom_fournisseurs` (
  `fournisseur_id` int(6) unsigned NOT NULL auto_increment,
  `code_fournisseur` varchar(63) NOT NULL default '',
  `raison_sociale` varchar(255) NOT NULL default '',
  `adresse` text NOT NULL,
  `code_postal` varchar(6) NOT NULL default '',
  `ville` varchar(63) NOT NULL default '',
  `pays` varchar(63) NOT NULL default '',
  `tel` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `nom_contact` varchar(63) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `nif` varchar(20) NOT NULL default '',
  `naf` varchar(10) NOT NULL default '',
  `siret` varchar(13) NOT NULL default '',
  `cate_fiscale_id` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`fournisseur_id`),
  UNIQUE KEY `code_fournisseur` (`code_fournisseur`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_frais_port`
-- 

DROP TABLE IF EXISTS `gescom_frais_port`;
CREATE TABLE `gescom_frais_port` (
  `frais_id` int(8) NOT NULL auto_increment,
  `code_frais` varchar(25) NOT NULL default '',
  `prix_frais` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`frais_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_groupements`
-- 

DROP TABLE IF EXISTS `gescom_groupements`;
CREATE TABLE `gescom_groupements` (
  `groupement_id` smallint(3) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`groupement_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_ope_stock`
-- 

DROP TABLE IF EXISTS `gescom_ope_stock`;
CREATE TABLE `gescom_ope_stock` (
  `piece_id` mediumint(5) unsigned NOT NULL auto_increment,
  `date` int(8) unsigned NOT NULL default '0',
  `date_arrival` int(8) unsigned NOT NULL default '0',
  `reference` varchar(64) NOT NULL default '',
  `type` enum('E','S') NOT NULL default 'E',
  `fournisseur_id` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`piece_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_ope_stock_article`
-- 

DROP TABLE IF EXISTS `gescom_ope_stock_article`;
CREATE TABLE `gescom_ope_stock_article` (
  `piece_id` mediumint(5) unsigned NOT NULL default '0',
  `article_id` int(6) unsigned NOT NULL default '0',
  `color_id` smallint(4) unsigned NOT NULL default '0',
  `size_id` smallint(4) unsigned NOT NULL default '0',
  `quantite` int(6) unsigned NOT NULL default '0',
  `prix` int(8) unsigned NOT NULL default '0',
  KEY `piece_id` (`piece_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_panier`
-- 

DROP TABLE IF EXISTS `gescom_panier`;
CREATE TABLE `gescom_panier` (
  `panier_id` int(7) unsigned NOT NULL auto_increment,
  `sid` varchar(255) NOT NULL default '',
  `code_livraison` mediumint(4) unsigned NOT NULL default '0',
  `code_facturation` mediumint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`panier_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_panier_articles`
-- 

DROP TABLE IF EXISTS `gescom_panier_articles`;
CREATE TABLE `gescom_panier_articles` (
  `ligne_id` int(8) unsigned NOT NULL auto_increment,
  `article_id` int(7) unsigned NOT NULL default '0',
  `quantite` smallint(4) unsigned NOT NULL default '0',
  `panier_id` int(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ligne_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_prix_spe`
-- 

DROP TABLE IF EXISTS `gescom_prix_spe`;
CREATE TABLE `gescom_prix_spe` (
  `prix_id` int(6) unsigned NOT NULL auto_increment,
  `famille_id` mediumint(4) unsigned NOT NULL default '0',
  `ssfamille_id` mediumint(4) unsigned NOT NULL default '0',
  `article_id` int(6) unsigned NOT NULL default '0',
  `groupement_id` mediumint(4) unsigned NOT NULL default '0',
  `client_id` int(6) unsigned NOT NULL default '0',
  `prix` int(7) unsigned NOT NULL default '0',
  `coef` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`prix_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_reglements`
-- 

DROP TABLE IF EXISTS `gescom_reglements`;
CREATE TABLE `gescom_reglements` (
  `mode_id` smallint(3) unsigned NOT NULL auto_increment,
  `mode` varchar(50) NOT NULL default '',
  `info` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mode_id`)
) TYPE=MyISAM COMMENT='Modes de règlement';

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_representants`
-- 

DROP TABLE IF EXISTS `gescom_representants`;
CREATE TABLE `gescom_representants` (
  `representant_id` smallint(4) unsigned NOT NULL auto_increment,
  `prenom` varchar(50) NOT NULL default '',
  `nom` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`representant_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_size`
-- 

DROP TABLE IF EXISTS `gescom_size`;
CREATE TABLE `gescom_size` (
  `size_id` mediumint(8) NOT NULL auto_increment,
  `size` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`size_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_sous_familles`
-- 

DROP TABLE IF EXISTS `gescom_sous_familles`;
CREATE TABLE `gescom_sous_familles` (
  `code_sous_famille` smallint(4) unsigned NOT NULL auto_increment,
  `designation` varchar(50) NOT NULL default '',
  `famille_id` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`code_sous_famille`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_stat`
-- 

DROP TABLE IF EXISTS `gescom_stat`;
CREATE TABLE `gescom_stat` (
  `stat_id` mediumint(4) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `sql` text NOT NULL,
  PRIMARY KEY  (`stat_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_stock`
-- 

DROP TABLE IF EXISTS `gescom_stock`;
CREATE TABLE `gescom_stock` (
  `article_id` int(7) unsigned NOT NULL default '0',
  `color_id` smallint(4) unsigned NOT NULL default '0',
  `size_id` smallint(4) unsigned NOT NULL default '0',
  `stock` mediumint(6) NOT NULL default '0',
  `stock_reserve` mediumint(6) unsigned NOT NULL default '0',
  `stock_commande` mediumint(6) unsigned NOT NULL default '0',
  `puma` int(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (`article_id`,`color_id`,`size_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_user_sessions`
-- 

DROP TABLE IF EXISTS `gescom_user_sessions`;
CREATE TABLE `gescom_user_sessions` (
  `session_id` mediumint(6) unsigned NOT NULL auto_increment,
  `sid` varchar(255) NOT NULL default '',
  `user_id` smallint(4) unsigned NOT NULL default '0',
  `begin_session` int(10) NOT NULL default '0',
  `last_activ` int(10) NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  UNIQUE KEY `sid` (`sid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Structure de la table `gescom_users`
-- 

DROP TABLE IF EXISTS `gescom_users`;
CREATE TABLE `gescom_users` (
  `user_id` smallint(3) unsigned NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(255) binary NOT NULL default '',
  `last_visit` int(10) unsigned NOT NULL default '0',
  `current_visit` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM;
        
        
-- 
-- Contenu de la table `gescom_cate_fiscale`
-- 

INSERT INTO `gescom_cate_fiscale` VALUES (1, 'France', 'france', 1, 22);
INSERT INTO `gescom_cate_fiscale` VALUES (2, 'Corse', 'corse', 1, 26);
INSERT INTO `gescom_cate_fiscale` VALUES (3, 'DOM TOM', 'domtom', 1, 27);
INSERT INTO `gescom_cate_fiscale` VALUES (4, 'CEE', 'cee', 1, 16);
INSERT INTO `gescom_cate_fiscale` VALUES (5, 'Exonérée', 'exoneree', 1, 18);
INSERT INTO `gescom_cate_fiscale` VALUES (6, 'Export', 'export', 1, 29);

-- 
-- Contenu de la table `gescom_comptes_collectifs`
-- 

INSERT INTO `gescom_comptes_collectifs` VALUES (1, '411000', 'Y');

-- 
-- Contenu de la table `gescom_comptes_tva`
-- 

INSERT INTO `gescom_comptes_tva` VALUES (16, '445711', 0, 'CEE', 'Y', '707019');
INSERT INTO `gescom_comptes_tva` VALUES (18, '445711', 0, 'Exonérée', 'Y', '707019');
INSERT INTO `gescom_comptes_tva` VALUES (22, '445711', 1960, 'France', 'Y', '707019');
INSERT INTO `gescom_comptes_tva` VALUES (29, '445710', 0, 'Export', 'Y', '707090');
INSERT INTO `gescom_comptes_tva` VALUES (26, '445712', 1960, 'Corse', 'Y', '707020');
INSERT INTO `gescom_comptes_tva` VALUES (27, '45711', 0, 'DOM TOM', 'Y', '707019');

-- 
-- Contenu de la table `gescom_conf`
-- 

INSERT INTO `gescom_conf` VALUES (
		'ma_societe', 
		'1', 
		'Ma société', 
		'Mon adresse', 
		99999, 
		'Ma Ville', 
		'Mon Pays', 
		'Mon téléphone', 
		'Mon fax', 
		'MON RCS B 123 456 789 00000', 
		'mon N° SIREN', 
		'APE0', 
		'MON NIF', 
		'http://localhost/html/', 
		'moi@societe.com', 
		'', 
		'N', 
		'', 
		'N', 
		'', 
		'N', 
		'NOUS VOUS SOUHAITONS LA BIENVENUE !', 
		'VTE', 
		'png', 
		5, 
		'Y', 
		'Negossima B2C', 
		'Ma Société', 
		'Cordialement l''equipe d''administration', 
		'vert', 
		'', 
		'',
		'', 
		'', 
		'', 
		'', 
		'', 
		'', 
		'', 
		'Y', 
		'Y');

-- 
-- Contenu de la table `gescom_expedition`
-- 

INSERT INTO `gescom_expedition` VALUES (1, 'France', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (2, 'Corse', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (3, 'DOM-TOM', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (4, 'CEE', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (5, 'Europe hors CEE', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (6, 'USA - Canada', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (7, 'Amérique Latine', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (8, 'Afrique', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (9, 'Asie', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (10, 'Australie', 0, 0, 0);
INSERT INTO `gescom_expedition` VALUES (11, 'Océanie', 0, 0, 0);

-- 
-- Contenu de la table `gescom_users`
-- 

INSERT INTO `gescom_users` VALUES (1, 'altissima', 0x31242e416b6844542f486f6149, 0, 0);
        
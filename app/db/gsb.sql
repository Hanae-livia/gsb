-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 07 Mai 2016 à 11:22
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `bilan`
--

CREATE TABLE IF NOT EXISTS `bilan` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `date_visite` date DEFAULT NULL,
  `date_saisie` date DEFAULT NULL,
  `impact` int(11) DEFAULT NULL,
  `remarque` text,
  `motif` varchar(45) DEFAULT NULL,
  `utilisateur_matricule` int(11) NOT NULL,
  `praticien_numero` int(11) NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `fk_bilan_utilisateur1_idx` (`utilisateur_matricule`),
  KEY `fk_bilan_praticien1_idx` (`praticien_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `composant`
--

CREATE TABLE IF NOT EXISTS `composant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `composant`
--

INSERT INTO `composant` (`id`, `libelle`) VALUES
(1, 'Codéine'),
(2, 'Paracétamol'),
(3, 'Acide acétylsalicylique'),
(4, ' Acide ascorbique'),
(5, 'Adrafinil'),
(6, 'Amoxicilline'),
(7, ' Acide clavulanique'),
(8, 'Bacitracine'),
(9, 'Clarithromycine'),
(10, 'Clomipramine'),
(11, 'Dextropropoxyphène'),
(12, 'Diphénydramine'),
(13, 'Doxylamine'),
(14, 'Erythromycine'),
(15, 'Fosfomycine trométamol'),
(16, 'Josamycine'),
(17, 'Lithium'),
(18, 'Méclozine'),
(19, 'Mirtazapine'),
(20, 'Oxytétracycline'),
(21, 'Lidocaïne'),
(22, 'Paroxétine'),
(23, 'Pyrazinamide'),
(24, 'Sulbutiamine'),
(25, 'Triamcinolone'),
(26, 'Nystatine'),
(27, 'Tyrothricine'),
(28, 'Néomycine'),
(29, 'Tétracaïne');

-- --------------------------------------------------------

--
-- Structure de la table `composition`
--

CREATE TABLE IF NOT EXISTS `composition` (
  `medicament_reference` varchar(45) NOT NULL,
  `composant_id` int(11) NOT NULL,
  `quantite` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`medicament_reference`,`composant_id`),
  KEY `fk_medicament_has_composant_composant1_idx` (`composant_id`),
  KEY `fk_medicament_has_composant_medicament_idx` (`medicament_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `composition`
--

INSERT INTO `composition` (`medicament_reference`, `composant_id`, `quantite`) VALUES
('3MYC7', 5, '2mg'),
('ADIMOL9', 6, '20µg'),
('CLAZER6', 1, '100mg'),
('DOLRIL7', 17, '10mg'),
('PARMOL16', 1, '15µg'),
('PARMOL16', 2, '30µg');

-- --------------------------------------------------------

--
-- Structure de la table `echantillon`
--

CREATE TABLE IF NOT EXISTS `echantillon` (
  `bilan_numero` int(11) NOT NULL,
  `medicament_reference` varchar(45) NOT NULL,
  PRIMARY KEY (`bilan_numero`,`medicament_reference`),
  KEY `fk_bilan_has_medicament_medicament1_idx` (`medicament_reference`),
  KEY `fk_bilan_has_medicament_bilan1_idx` (`bilan_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE IF NOT EXISTS `famille` (
  `code` varchar(3) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `famille`
--

INSERT INTO `famille` (`code`, `libelle`) VALUES
('', 'Corticoïde, antibiotique et antifongique à  usage local'),
('AA', 'Antalgiques en association'),
('AAA', 'Antalgiques antipyrétiques en association'),
('AAC', 'Antidépresseur d''action centrale'),
('AAH', 'Antivertigineux antihistaminique H1'),
('ABA', 'Antibiotique antituberculeux'),
('ABC', 'Antibiotique antiacnéique local'),
('ABP', 'Antibiotique de la famille des béta-lactamines (pénicilline A)'),
('AFC', 'Antibiotique de la famille des cyclines'),
('AFM', 'Antibiotique de la famille des macrolides'),
('AH', 'Antihistaminique H1 local'),
('AIM', 'Antidépresseur imipraminique (tricyclique)'),
('AIN', 'Antidépresseur inhibiteur sélectif de la recapture de la sérotonine'),
('ALO', 'Antibiotique local (ORL)'),
('ANS', 'Antidépresseur IMAO non sélectif'),
('AO', 'Antibiotique ophtalmique'),
('AP', 'Antipsychotique normothymique'),
('AUM', 'Antibiotique urinaire minute'),
('CRT', 'Corticoïde, antibiotique et antifongique à  usage local'),
('HYP', 'Hypnotique antihistaminique'),
('PSA', 'Psychostimulant, antiasthénique');

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE IF NOT EXISTS `medicament` (
  `reference` varchar(45) NOT NULL,
  `famille_code` varchar(3) NOT NULL,
  `nom_commercial` varchar(45) DEFAULT NULL,
  `contre_indications` text,
  `effets_indesirables` text,
  PRIMARY KEY (`reference`),
  KEY `fk_medicament_famille1_idx` (`famille_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `medicament`
--

INSERT INTO `medicament` (`reference`, `famille_code`, `nom_commercial`, `contre_indications`, `effets_indesirables`) VALUES
('3MYC7', 'CRT', 'Trimycine', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants, d''infections de la peau ou de parasitisme non traités, d''acné. Ne pas appliquer sur une plaie, ni sous un pansement occlusif.', 'Ce médicament est un corticoïde à  activité forte ou très forte associé à  un antibiotique et un antifongique, utilisé en application locale dans certaines atteintes cutanées surinfectées.'),
('ADIMOL9', 'ABP', 'Adimol', 'Ce médicament est contre-indiqué en cas d''allergie aux pénicillines ou aux céphalosporines.', 'Ce médicament, plus puissant que les pénicillines simples, est utilisé pour traiter des infections bactériennes spécifiques.'),
('AMOPIL7', 'ABP', 'Amopil', 'Ce médicament est contre-indiqué en cas d''allergie aux pénicillines. Il doit être administré avec prudence en cas d''allergie aux céphalosporines.', 'Ce médicament, plus puissant que les pénicillines simples, est utilisé pour traiter des infections bactériennes spécifiques.'),
('AMOX45', 'ABP', 'Amoxar', 'La prise de ce médicament peut rendre positifs les tests de dépistage du dopage.', 'Ce médicament, plus puissant que les pénicillines simples, est utilisé pour traiter des infections bactériennes spécifiques.'),
('AMOXIG12', 'ABP', 'Amoxi Gé', 'Ce médicament est contre-indiqué en cas d''allergie aux pénicillines. Il doit être administré avec prudence en cas d''allergie aux céphalosporines.', 'Ce médicament, plus puissant que les pénicillines simples, est utilisé pour traiter des infections bactériennes spécifiques.'),
('APATOUX22', 'ALO', 'Apatoux Vitamine C', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants, en cas de phénylcétonurie et chez l''enfant de moins de 6 ans.', 'Ce médicament est utilisé pour traiter les affections de la bouche et de la gorge.'),
('BACTIG10', 'ABC', 'Bactigel', 'Ce médicament est contre-indiqué en cas d''allergie aux antibiotiques de la famille des macrolides ou des lincosanides.', 'Ce médicament est utilisé en application locale pour traiter l''acné et les infections cutanées bactériennes associées.'),
('BACTIV13', 'AFM', 'Bactivil', 'Ce médicament est contre-indiqué en cas d''allergie aux macrolides (dont le chef de file est l''érythromycine).', 'Ce médicament est utilisé pour traiter des infections bactériennes spécifiques.'),
('BITALV', 'AAA', 'Bivalic', 'Ce médicament est contre-indiqué en cas d''allergie aux médicaments de cette famille, d''insuffisance hépatique ou d''insuffisance rénale.', 'Ce médicament est utilisé pour traiter les douleurs d''intensité modérée ou intense.'),
('CARTION6', 'AAA', 'Cartion', 'Ce médicament est contre-indiqué en cas de troubles de la coagulation (tendances aux hémorragies), d''ulcère gastroduodénal, maladies graves du foie.', 'Ce médicament est utilisé dans le traitement symptomatique de la douleur ou de la fièvre.'),
('CLAZER6', 'AFM', 'Clazer', 'Ce médicament est contre-indiqué en cas d''allergie aux macrolides (dont le chef de file est l''érythromycine).', 'Ce médicament est utilisé pour traiter des infections bactériennes spécifiques. Il est également utilisé dans le traitement de l''ulcère gastro-duodénal, en association avec d''autres médicaments.'),
('DEPRIL9', 'AIM', 'Depramil', 'Ce médicament est contre-indiqué en cas de glaucome ou d''adénome de la prostate, d''infarctus récent, ou si vous avez reà§u un traitement par IMAO durant les 2 semaines précédentes ou en cas d''allergie aux antidépresseurs imipraminiques.', 'Ce médicament est utilisé pour traiter les épisodes dépressifs sévères, certaines douleurs rebelles, les troubles obsessionnels compulsifs et certaines énurésies chez l''enfant.'),
('DIRMITAM6', 'AAC', 'Dirmitam', 'La prise de ce produit est contre-indiquée en cas de d''allergie à  l''un des constituants.', 'Ce médicament est utilisé pour traiter les épisodes dépressifs sévères.'),
('DOLRIL7', 'AAA', 'Doloril', 'Ce médicament est contre-indiqué en cas d''allergie au paracétamol ou aux salicylates.', 'Ce médicament est utilisé dans le traitement symptomatique de la douleur ou de la fièvre.'),
('DORNOM8', 'HYP', 'Normador', 'Ce médicament est contre-indiqué en cas de glaucome, de certains troubles urinaires (rétention urinaire) et chez l''enfant de moins de 15 ans.', 'Ce médicament est utilisé pour traiter l''insomnie chez l''adulte.'),
('EQUILARX6', 'AAH', 'Equilar', 'Ce médicament ne doit pas être utilisé en cas d''allergie au produit, en cas de glaucome ou de rétention urinaire.', 'Ce médicament est utilisé pour traiter les vertiges et pour prévenir le mal des transports.'),
('EVILR7', 'PSA', 'Eveillor', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants.', 'Ce médicament est utilisé pour traiter les troubles de la vigilance et certains symptomes neurologiques chez le sujet agé.'),
('INSXT5', 'AH', 'Insectil', 'Ce médicament est contre-indiqué en cas d''allergie aux antihistaminiques.', 'Ce médicament est utilisé en application locale sur les piqûres d''insecte et l''urticaire.'),
('JOVAI8', 'AFM', 'Jovenil', 'Ce médicament est contre-indiqué en cas d''allergie aux macrolides (dont le chef de file est l''érythromycine).', 'Ce médicament est utilisé pour traiter des infections bactériennes spécifiques.'),
('LIDOXY23', 'AFC', 'Lidoxytracine', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants. Il ne doit pas être associé aux rétinoïdes.', 'Ce médicament est utilisé en injection intramusculaire pour traiter certaines infections spécifiques.'),
('LITHOR12', 'AP', 'Lithorine', 'Ce médicament ne doit pas être utilisé si vous êtes allergique au lithium. Avant de prendre ce traitement, signalez à  votre médecin traitant si vous souffrez d''insuffisance rénale, ou si vous avez un régime sans sel.', 'Ce médicament est indiqué dans la prévention des psychoses maniaco-dépressives ou pour traiter les états maniaques.'),
('PARMOL16', 'AA', 'Parmocodeine', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants, chez l''enfant de moins de 15 Kg, en cas d''insuffisance hépatique ou respiratoire, d''asthme, de phénylcétonurie et chez la femme qui allaite.', 'Ce médicament est utilisé pour le traitement des douleurs lorsque des antalgiques simples ne sont pas assez efficaces.'),
('PHYSOI8', 'PSA', 'Physicor', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants.', 'Ce médicament est utilisé pour traiter les baisses d''activité physique ou psychique, souvent dans un contexte de dépression.'),
('PIRIZ8', 'ABA', 'Pirizan', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants, d''insuffisance rénale ou hépatique, d''hyperuricémie ou de porphyrie.', 'Ce médicament est utilisé, en association à  d''autres antibiotiques, pour traiter la tuberculose.'),
('POMDI20', 'AO', 'Pomadine', 'Ce médicament est utilisé pour traiter les infections oculaires de la surface de l''oeil.', 'Ce médicament est utilisé pour traiter les infections oculaires de la surface de l''oeil.'),
('TROXT21', 'AIN', 'Troxadet', 'Ce médicament est contre-indiqué en cas d''allergie au produit.', 'Ce médicament est utilisé pour traiter la dépression et les troubles obsessionnels compulsifs. Il peut également être utilisé en prévention des crises de panique avec ou sans agoraphobie.'),
('TXISOL22', 'ALO', 'Touxisol Vitamine C', 'Ce médicament est contre-indiqué en cas d''allergie à  l''un des constituants et chez l''enfant de moins de 6 ans.', 'Ce médicament est utilisé pour traiter les affections de la bouche et de la gorge.'),
('URIEG6', 'AUM', 'Uriregul', 'La prise de ce médicament est contre-indiquée en cas d''allergie à  l''un des constituants et d''insuffisance rénale.', 'Ce médicament est utilisé pour traiter les infections urinaires simples chez la femme de moins de 65 ans.');

-- --------------------------------------------------------

--
-- Structure de la table `praticien`
--

CREATE TABLE IF NOT EXISTS `praticien` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `adresse` text,
  `cp` int(5) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `coef_notoriete` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `specialite_id` int(11) NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `fk_praticien_type1_idx` (`type_id`),
  KEY `fk_praticien_specialite1_idx` (`specialite_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `praticien`
--

INSERT INTO `praticien` (`numero`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `coef_notoriete`, `type_id`, `specialite_id`) VALUES
(1, 'Mérriaud', 'Sébastien', '1 rue Notre Dame', 31400, 'Toulouse', 5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit_presente`
--

CREATE TABLE IF NOT EXISTS `produit_presente` (
  `bilan_numero` int(11) NOT NULL,
  `medicament_reference` varchar(45) NOT NULL,
  PRIMARY KEY (`bilan_numero`,`medicament_reference`),
  KEY `fk_bilan_has_medicament1_medicament1_idx` (`medicament_reference`),
  KEY `fk_bilan_has_medicament1_bilan1_idx` (`bilan_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE IF NOT EXISTS `specialite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `specialite`
--

INSERT INTO `specialite` (`id`, `libelle`) VALUES
(1, 'Médecine générale'),
(2, 'Chirurgie générale'),
(3, 'Cancérologie, oncologie médicale'),
(4, 'Chirurgie orthopédique et traumatologie'),
(5, 'Chirurgie plastique reconstructrice et esthétique'),
(6, 'Nutrition'),
(7, 'Dermatologie'),
(8, 'Gastro-entérologie et hépatologie'),
(9, 'Gynécologie-obstétrique'),
(10, 'Médecine et biologie du sport '),
(11, 'Médecine du travail'),
(12, 'Médecine nucléaire'),
(13, 'Néphrologie'),
(14, 'Neurochirurgie'),
(15, 'Ophtalmologie'),
(16, 'Pédiatrie maladies des enfants'),
(17, 'Pneumologie'),
(18, 'Psychiatrie'),
(19, 'Rhumatologie'),
(20, 'Stomatologie');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id`, `libelle`) VALUES
(1, 'Médecin de ville'),
(2, 'Médecin Hospitalier'),
(3, 'Personnel de santé'),
(4, 'Pharmacien Hospitalier'),
(5, 'Pharmacien Officine');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `matricule` int(11) NOT NULL AUTO_INCREMENT,
  `statut` varchar(45) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `adresse` text,
  `cp` int(11) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `date_embauche` date DEFAULT NULL,
  `identifiant` varchar(45) NOT NULL,
  `mot_de_passe` varchar(45) NOT NULL,
  PRIMARY KEY (`matricule`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=122017 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`matricule`, `statut`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `date_embauche`, `identifiant`, `mot_de_passe`) VALUES
(112016, 'Webmaster', 'Tardy', 'Mélanie', '20 rue Johannes Kepler', 31700, 'Blagnac', '2016-05-04', 'tardym', '5920670906ce2fe368169efaf406de4e6471c9b2'),
(122016, 'Webmaster', 'Lefebvre', 'Jérôme', '5 rue des George Brassens', 31800, 'Tournefeuille', '2016-05-04', 'lefebvrej', '818095e21916b248993d7a8a20b2f583a366ea65');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bilan`
--
ALTER TABLE `bilan`
  ADD CONSTRAINT `fk_bilan_praticien1` FOREIGN KEY (`praticien_numero`) REFERENCES `praticien` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bilan_utilisateur1` FOREIGN KEY (`utilisateur_matricule`) REFERENCES `utilisateur` (`matricule`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `composition`
--
ALTER TABLE `composition`
  ADD CONSTRAINT `fk_medicament_has_composant_composant1` FOREIGN KEY (`composant_id`) REFERENCES `composant` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medicament_has_composant_medicament` FOREIGN KEY (`medicament_reference`) REFERENCES `medicament` (`reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `echantillon`
--
ALTER TABLE `echantillon`
  ADD CONSTRAINT `fk_bilan_has_medicament_bilan1` FOREIGN KEY (`bilan_numero`) REFERENCES `bilan` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bilan_has_medicament_medicament1` FOREIGN KEY (`medicament_reference`) REFERENCES `medicament` (`reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `fk_medicament_famille1` FOREIGN KEY (`famille_code`) REFERENCES `famille` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `praticien`
--
ALTER TABLE `praticien`
  ADD CONSTRAINT `fk_praticien_specialite1` FOREIGN KEY (`specialite_id`) REFERENCES `specialite` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_praticien_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `produit_presente`
--
ALTER TABLE `produit_presente`
  ADD CONSTRAINT `fk_bilan_has_medicament1_bilan1` FOREIGN KEY (`bilan_numero`) REFERENCES `bilan` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bilan_has_medicament1_medicament1` FOREIGN KEY (`medicament_reference`) REFERENCES `medicament` (`reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

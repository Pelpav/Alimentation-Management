-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 24 juin 2024 à 17:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `alimentation`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `identifiant_admin` varchar(200) NOT NULL,
  `nom_admin` varchar(200) NOT NULL,
  `email_admin` varchar(200) NOT NULL,
  `motdepasse_admin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`identifiant_admin`, `nom_admin`, `email_admin`, `motdepasse_admin`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'System Admina', 'admin@mail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `identifiant_client` varchar(200) NOT NULL,
  `nom_client` varchar(200) DEFAULT NULL,
  `numero_client` varchar(200) DEFAULT NULL,
  `email_client` varchar(200) DEFAULT NULL,
  `motdepasse_client` varchar(200) DEFAULT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`identifiant_client`, `nom_client`, `numero_client`, `email_client`, `motdepasse_client`, `creee_le`) VALUES
('1c34861e619f', 'Christian Pavlov Elom NOUBOUKPO', '63198446', 'elpav2022@gmail.com', '1f82ea75c5cc526729e2d581aeb3aeccfef4407e', '2024-06-24 13:30:47.144193'),
('35135b319ce3', 'Christine Moore', '7412569698', 'Client@mail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2022-09-12 10:14:03.079533'),
('client_667994021be7a', 'Momo', NULL, NULL, NULL, '2024-06-24 17:42:58.000000');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `identifiant_commande` varchar(200) NOT NULL,
  `code_commande` varchar(200) NOT NULL,
  `identifiant_client` varchar(200) DEFAULT NULL,
  `statut_commande` varchar(200) NOT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`identifiant_commande`, `code_commande`, `identifiant_client`, `statut_commande`, `creee_le`) VALUES
('cmd_66795bee84fff', 'CODE_66795BEE8516B', '35135b319ce3', '', '2024-06-24 12:01:17.262276'),
('cmd_66795d707a699', 'CODE_66795D707A762', '35135b319ce3', '', '2024-06-24 12:01:20.145853'),
('cmd_66795e1b05770', 'CODE_66795E1B059EF', '35135b319ce3', '', '2024-06-24 12:01:21.818356'),
('cmd_6679602df2aaa', 'CODE_6679602DF2CF7', '35135b319ce3', 'Payé', '2024-06-24 12:45:36.396818'),
('cmd_66796ec8e91c9', 'CODE_66796EC8E930A', '35135b319ce3', 'Payé', '2024-06-24 13:24:38.752828'),
('cmd_6679748d0bca9', 'CODE_6679748D0BDF5', '35135b319ce3', 'Payé', '2024-06-24 13:29:27.441128'),
('cmd_6679766d7c8b4', 'CODE_6679766D7CA4C', '35135b319ce3', '', '2024-06-24 13:36:45.510641'),
('cmd_667976908bcad', 'CODE_667976908BEF7', '1c34861e619f', 'Payé', '2024-06-24 13:44:37.299196'),
('cmd_667979d2b09ed', 'CODE_667979D2B0C45', '1c34861e619f', '', '2024-06-24 13:51:14.724927'),
('cmd_667979e77e9d1', 'CODE_667979E77EBD7', '1c34861e619f', '', '2024-06-24 13:51:35.519194'),
('cmd_6679834c118f8', 'CODE_6679834C11A4C', '1c34861e619f', '', '2024-06-24 14:31:40.072345'),
('cmd_66798805ae96e', 'CODE_66798805AEA53', '1c34861e619f', 'Payé', '2024-06-24 15:01:34.526034'),
('cmd_667994022b0d9', 'CODE_667994022B180', 'client_667994021be7a', '', '2024-06-24 15:42:58.176550');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

CREATE TABLE `commande_produit` (
  `identifiant_commande` varchar(200) NOT NULL,
  `identifiant_produit` varchar(200) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `commande_produit`
--

INSERT INTO `commande_produit` (`identifiant_commande`, `identifiant_produit`, `quantite`) VALUES
('cmd_66795bee84fff', '0108ca1033', 10),
('cmd_66795bee84fff', 'beea389cb0', 10),
('cmd_66795d707a699', '0108ca1033', 65),
('cmd_66795e1b05770', '18f306f39b', 55),
('cmd_6679602df2aaa', '0108ca1033', 10),
('cmd_6679602df2aaa', '756859270c', 10),
('cmd_6679602df2aaa', 'a58ef940db', 10),
('cmd_66796ec8e91c9', '0108ca1033', 10),
('cmd_66796ec8e91c9', '18f306f39b', 10),
('cmd_6679748d0bca9', '0108ca1033', 5),
('cmd_6679766d7c8b4', '0108ca1033', 2),
('cmd_6679766d7c8b4', 'beea389cb0', 5),
('cmd_667976908bcad', '18f306f39b', 5),
('cmd_667976908bcad', '28c5934b1f', 5),
('cmd_667976908bcad', '3228dee80a', 10),
('cmd_667979d2b09ed', '28c5934b1f', 2),
('cmd_667979d2b09ed', '3228dee80a', 5),
('cmd_667979e77e9d1', '28c5934b1f', 5),
('cmd_667979e77e9d1', '3228dee80a', 1),
('cmd_6679834c118f8', '0108ca1033', 50),
('cmd_66798805ae96e', '0108ca1033', 200),
('cmd_667994022b0d9', '0108ca1033', 100);

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

CREATE TABLE `employee` (
  `identifiant_employee` int(20) NOT NULL,
  `nom_employee` varchar(200) NOT NULL,
  `numero_employee` varchar(200) NOT NULL,
  `email_employee` varchar(200) NOT NULL,
  `motdepasse_employee` varchar(200) NOT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`identifiant_employee`, `nom_employee`, `numero_employee`, `email_employee`, `motdepasse_employee`, `creee_le`) VALUES
(2, 'Caissier James', 'QEUY-9042', 'cashier@mail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2022-09-12 10:13:37.930915');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `pay_id` varchar(200) NOT NULL,
  `code_paiements` varchar(200) NOT NULL,
  `code_commande` varchar(200) NOT NULL,
  `identifiant_client` varchar(200) DEFAULT NULL,
  `montant_paiements` varchar(200) NOT NULL,
  `methode_paiements` varchar(200) NOT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`pay_id`, `code_paiements`, `code_commande`, `identifiant_client`, `montant_paiements`, `methode_paiements`, `creee_le`) VALUES
('8a19ba', 'L3J7GTYNUD', 'cmd_66796ec8e91c9', '35135b319ce3', '20500', 'Cash', '2024-06-24 15:24:38.000000'),
('915813', 'J8ZSXTBWI3', 'cmd_66798805ae96e', '1c34861e619f', '230000', 'Cash', '2024-06-24 17:01:34.000000'),
('c434ab', '6FDNTLUEJ3', 'cmd_6679748d0bca9', '35135b319ce3', '5750', 'Cash', '2024-06-24 15:29:27.000000'),
('c49ebd', 'YFL4OMSVW8', 'cmd_667976908bcad', '1c34861e619f', '20500', 'Cash', '2024-06-24 15:44:37.000000'),
('db2a7a', 'P5UT2AHB6O', 'cmd_6679602df2aaa', '35135b319ce3', '121500', 'Cash', '2024-06-24 14:45:36.000000');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `identifiant_produit` varchar(200) NOT NULL,
  `code_produit` varchar(200) NOT NULL,
  `nom_produit` varchar(200) NOT NULL,
  `stock_produit` int(11) NOT NULL DEFAULT 0,
  `image_produit` varchar(200) NOT NULL,
  `description_produit` longtext NOT NULL,
  `prix_produit` varchar(200) NOT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`identifiant_produit`, `code_produit`, `nom_produit`, `stock_produit`, `image_produit`, `description_produit`, `prix_produit`, `creee_le`) VALUES
('0108ca1033', 'QJYI-6357', 'Farine Fluide – Belle France', 133, 'image_2024-05-09_132606548.png', 'C’est quoi de la farine fluide ?\r\nComme son nom l’indique, la farine fluide est particulièrement facile à travailler car elle fait beaucoup moins de grumeaux que la farine classique. On peut s’en servir pour de nombreux usages : C’est la farine idéale pour toutes les pâtes liquides telles que la pâte à crêpes, à gaufres ou à beignets.\r\nFine et pure, idéale pour les crêpes, les gaufres et les sauces.\r\nLa farine Fluide est idéale pour toutes vos préparations liquides.\r\nElle se mélange plus facilement qu’une farine de blé classique, pour des recettes garanties sans grumeaux.', '1150', '2024-06-24 15:42:58.283390'),
('18f306f39b', 'TIBL-0287', 'Goya Chick Peas Garbazos 439G', 5, 'image_2024-05-09_132334267.png', 'Préparation :\r\nRincer, chauffer et servir, plats cuisinés, prêts à manger.\r\nConservation :\r\nAprès ouverture, réfrigérer le contenu dans un contenant en verre ou en plastique.\r\nPlus d’information\r\nNOM DU PRODUIT	Pois chiches Goya, pois chiches – 15,5 oz\r\nNOMBRE DE COLIS	1\r\nTAILLE ÉTENDUE	15,5 onces (439 g)\r\nPRÉFÉRENCE D’INGRÉDIENTS	Coeur sain', '900', '2024-06-24 13:37:20.674653'),
('28c5934b1f', 'INCK-0925', 'La Baleine Etui Carton Sel Fin Iodé 500g', 8, 'image_2024-05-09_131330723.png', 'Présentation produit : La Baleine Etui Carton Sel Fin Iodé 500gr\r\nDescription du produit Etui carton contenant 500gr de sel de mer fin iodé. Le sel de mer provient de l’évaporation naturelle de l’eau de mer dans les marais salants, sous l’effet conjugué du soleil et du vent. Ingrédients Ingrédients : Iodure de sodium, Ferronitrile de sodium Voir l’ensemble des Description du produit\r\n\r\nDescription du produit Etui carton contenant 500gr de sel de mer fin iodé. Le sel de mer provient de l’évaporation naturelle de l’eau de mer dans les marais salants, sous l’effet conjugué du soleil et du vent. Ingrédients Ingrédients : Iodure de sodium, Ferronitrile de sodium Voir l’ensemble des Description du produit\r\n\r\nINFORMATIONS GÉNÉRALES SUR LE PRODUIT\r\nNom du produit	La Baleine Etui Carton Sel Fin Iodé 500 g 500 g\r\nCatégorie	SEL & POIVRE\r\nINFORMATIONS PRODUIT\r\nMarque	La Baleine\r\nPoids en g	0 g', '1000', '2024-06-24 13:51:35.669998'),
('3228dee80a', 'SBDP-9283', 'Soupe au poulet instantané – Boow Noodle', 4, 'image_2024-05-09_131207659.png', 'Ce produit combine une soupe au poulet de style coréen et la soupe au poulet et nouilles classique américaine a été combiné pour faire une soupe de nouilles délicieuse, savoureuse et pratique. Ce produit est un aliment réconfortant que vous pouvez déguster à tout moment.\r\n\r\nNotre gamme Bowl Noodle est meilleure que jamais! Chez Nongshim, nous savons que le secret pour des nouilles plus savoureuses est de cuire à feu vif. C’est pourquoi nos nouveaux bols recyclables sont si incroyables! Ils vous permettent d’utiliser les températures chaudes du micro-ondes pour cuire de meilleures nouilles, contrairement à nos anciens bols en mousse de polystyrène. Et parce que notre nouvelle formule est faite avec moins de sodium et sans BPA ajouté, notre nouvelle génération de nouilles bol plaira à coup sûr à tout le monde!\r\n\r\nGoût clair et profond de bouillon, nouilles bol de ragoût de poulet\r\nCombiné au goût du ragoût de poulet traditionnel coréen et de la soupe au poulet et aux nouilles préférée des Américains, le bol de poulet au ragoût de nouilles vous donnera le goût profond du bouillon de poulet ainsi que le traditionnel chaud et épicé de la Corée.\r\n\r\n\r\n\r\nMicro-ondable\r\nrapide et facile\r\nRamyun est plus délicieux et plus simple tout droit sorti du micro-ondes!\r\n\r\n\r\n0g de gras trans\r\nVoir la valeur nutritive\r\nNongshim ramyun contient 0 gramme de gras trans et de gras saturés.\r\n\r\n\r\nAucun BPA ajouté\r\npour votre santé\r\nNos produits sont fabriqués sans BPA ajouté pour satisfaire la demande populaire de produits plus sains.\r\n\r\nMicro-ondes (1000W)\r\n\r\nOuvrez le couvercle à moitié.\r\nAjouter la base de soupe.\r\n\r\n2. Versez de l’\r\neau à température ambiante jusqu’à la ligne intérieure\r\n\r\n\r\n3. Cuire au micro-ondes pendant 3 min. Laisser refroidir le produit au micro-ondes pendant 1 min. bien mélanger et servir\r\n\r\n\r\nOuvrez le couvercle à moitié. ajouter la base de soupe.\r\nVersez de l’eau chaude jusqu’à la ligne intérieure.\r\nFermez le couvercle pendant 3 minutes. bien mélanger et servir', '1100', '2024-06-24 13:51:35.807555'),
('3401d54e8c', 'YJLH-4612', 'm&m’s', 10, 'image_2024-05-09_132419807.png', 'Ingrédients : chocolat  (sucre, chocolat alcalisé, chocolat, beurre de cacao, graisse laitière, lait écrémé, lécithine de soja), sucre, sirop de maïs, huile de palmiste hydrogéné, chocolat alcalisé, lait écrémé, amidon de maïs, contient moins de 1% de : graisse laitière, lactose, dextrine, sel, colorant E133-E110-E129*-E102, agent d’enrobage E903, arôme artificiel, chocolat, émulsifiant E414. * Peut avoir des effets indésirables sur l’activité et l’attention chez l’enfant.\r\n\r\nFabriqué par : MARS WRIGLEY CONFECTIONERY US LLC\r\n\r\nDéclaration nutritionnelle (pour 100g) : énergie 475Kcal, matières grasses 20g (dont acides gras saturés 12.5g), glucides 72.5g (dont sucres 62.5g), protéines 2.5g, sel 250mg.', '750', '2024-06-24 15:34:52.389777'),
('51ee69b757', 'BJCU-5746', 'Huile d’olive extra vierge – Belle France', 20, 'image_2024-05-09_132239324.png', 'RICHE EN OMÉGA 9 ET EN ANTIOXYDANTS, L’HUILE D’OLIVE AIDE À PRÉVENIR DE NOMBREUSES MALADIES CARDIOVASCULAIRES ET INFLAMMATOIRES. COMPOSITION, CALORIES, QUANTITÉ PAR JOUR ET TOUR DE SES BIENFAITS POUR LA SANTÉ AVEC CAROLINE SEGUIN, DIÉTÉTICIENNE-NUTRITIONNISTE.\r\nL’huile d’olive est une huile végétale obtenue en pressant des olives. Ce produit phare de la cuisine méditerranéenne est très riche en oméga 9, un acide gras qui a un rôle protecteur contre les maladies cardiovasculaires (infarctus, AVC, diabète de type 2…), les maladies inflammatoires et certains cancers lorsqu’il est associé à une alimentation équilibrée et à la pratique d’une activité physique régulière. Quels sont ses autres bienfaits pour la santé ? De quoi est-elle composée ? Combien en manger par jour ? Quelle est la meilleure et comment choisir un produit de qualité ? Découverte.\r\n\r\nQuelle est la composition de l’huile d’olive ?\r\nComme toutes les huiles végétales, l’huile d’olive contient des acides gras : saturés, poly-insaturés (oméga 6 et 3) et mono-insaturés (oméga 9). Les teneurs en acides gras diffèrent en fonction de la qualité de l’huile d’olive et son mode de pressage. En moyenne, l’huile d’olive contient :\r\n\r\n75% d’oméga 9\r\n15% d’acides gras saturés (à savoir que l’on retrouve les acides gras saturés dans les produits d’origine animale : viande, beurre, lait, fromages…)\r\n9% d’oméga 6\r\n1% d’oméga 3\r\nL’huile d’olive est également riche en antioxydants, particulièrement en vitamine E, polyphénols, carotène…', '4200', '2024-05-09 13:23:11.673770'),
('5bef12d551', 'LUVR-1759', 'COOKIES CHOCO NOUGAT GOUT NOISETTE BELLE FRANCE 200G', 20, 'image_2024-05-09_132503766.png', 'Le biscuit de la marque BELLE FRANCE, un cookie au nougat? avec des éclats de chocolat noir disponible en paquet de 200g contenant 6 sachets de 2 cookies.\r\n\r\nListe des ingrédients:\r\n\r\nfarine de blé, pépites de chocolat* 30%(sucre*,pâte de cacao », beurre de cacao*), sucre de canne* roux,huile de tournesol*, beurre, oeufs, poudre de cacao maigre* 2%, poudre à lever carbonates d’ammonium, poudre de lait écrémé, arôme naturel, sel de Guérande, fibres d’acacia », arôme naturel de vanille Ingrédients issus de l’Agriculture Biologique Traces éventuelles de soja, arachide et fruits à coque', '1600', '2024-05-09 13:25:21.817076'),
('5f5cb6c274', 'HWFA-7964', 'Oxi Clean – 4.58 kg', 20, 'image_2024-05-09_132728862.png', 'Ne vous contentez pas de nettoyer vos vêtements et votre maison, procurez-vous le détachant polyvalent Oxi Clean. Le détachant polyvalent n°1 aux États-Unis élimine les taches tenaces de votre linge et partout dans votre maison. Avec plus de 101 façons d’utiliser, sa formule concentrée vous offre désormais 252 charges de puissance de lavage avec une meilleure élimination des taches avec 99 % de détachants actifs, des couleurs plus vives et des blancs plus blancs sans chlore.', '18000', '2024-05-09 13:27:45.722559'),
('6019a2f104', 'UJZE-5496', 'Belle France – Puree Nature 375g', 20, 'image_2024-05-09_131436834.png', ' Elles sont soigneusement lavées, épluchées puis cuites à la vapeur. Elles sont ensuite écrasées en purée, dont on extrait l’eau pour la réduire en flocons.\r\nListe des ingrédients:\r\nPommes de terre déshydratées 99%, émulsifiant E471, stabilisant : E450i, colorant : E100, antioxydants : E300 et extrait de romarin, acidifiant : E330.\r\nTraces éventuelles : Lait, Sulftes', '1000', '2024-05-09 13:14:57.045159'),
('6af917ccdf', 'HMXG-1428', 'B.F Filets de sardines à l’huile d’olive vierge extra', 20, 'image_2024-05-09_131558639.png', 'Faites-vous du bien avec ces filets de sardines à l’huile d’olive vierge extra bio.\r\n\r\n\r\n\r\nNUTRIMENT	QUANTITÉ	VNR\r\nEnergie	232 Kcal / 970 Kj	11.6 %\r\nProtéines	22 g	44 %\r\nLipides	16 g	22.9 %\r\ndont AG Saturés	3.5 g	17.5 %\r\nGlucides	0 g	–\r\ndont Sucres	0 g	–\r\nSel	0.85 g	14.2 %\r\nApports pour 100 g / ml, exprimés également en % des Valeurs Nutritionnelles de Référence (VNR)', '1300', '2024-05-09 13:16:17.881199'),
('756859270c', 'FXQW-5041', 'Tire-lait manuel, Transparent – Philips AVENT SCF330/30', 20, 'image_2024-05-09_133046674.png', 'Position de pompage plus confortable grâce à une conception unique.\r\nLe coussin de massage doux et texturé aide à stimuler l’écoulement du lait\r\nLa conception compacte et légère du corps de la pompe facilite la prise en main et la position sur votre sein\r\nCompatible avec d’autres produits d’alimentation Philips Avent, tels que les biberons naturels et anti-coliques et les récipients de stockage du lait maternel\r\nSans BPA\r\n\r\nDu fabricant\r\nPhilips, Philips Avent, Philips Baby, Avent, produits pour bébé, meilleurs produits pour bébé, meilleure marque pour bébé\r\nPhilips, Philips Avent, Philips Baby, Avent, produits pour bébé, meilleurs produits pour bébé, meilleure marque pour bébé\r\nPhilips, Avent, Philips Avent, Avant, meilleure marque pour bébés, marque n° 1 pour bébés, meilleure marque de puériculture, confortable\r\nEn tant que marque Mother & Childcare recommandée par les mamans du monde entier, Philips Avent est fière de proposer des produits innovants pour bébés. Depuis plus de trente ans, nous travaillons main dans la main avec des professionnels de la santé, des cliniciens et des mamans sur une gamme complète, allant de l’allaitement au biberon, en passant par les sucettes et les gobelets pour tout-petits. Philips Avent est là pour vous aider à créer un bon départ pour un bébé heureux !\r\n\r\nPlus de confort, plus de lait\r\nConfort cliniquement prouvé\r\nLe tire-lait manuel Philips Avent est idéal pour les déplacements. Nous savons que lorsque vous êtes à l’aise et détendue, votre lait coule plus facilement. Ce tire-lait est conçu pour le confort : asseyez-vous confortablement sans avoir besoin de vous pencher en avant et laissez notre coussin de massage doux stimuler doucement votre débit de lait. Conception légère et compacte pour une maman occupée. Facile à nettoyer et à assembler.\r\n\r\n*Basé sur l’enquête de satisfaction en ligne GemSeek de décembre 2015 menée auprès de plus de 9 000 utilisatrices de marques et de produits de puériculture.\r\n\r\ntire-lait électrique, produits pour bébés, meilleurs produits pour bébés, meilleure marque pour bébés, produits pour nouveau-nés, confort\r\ntire-lait électrique, produits pour bébés, meilleurs produits pour bébés, meilleure marque pour bébés, produits pour nouveau-nés, confortables\r\ntire-lait électrique, produits pour bébés, meilleurs produits pour bébés, meilleure marque pour bébés, produits pour nouveau-nés, confort\r\ntire-lait électrique, produits pour bébés, meilleurs produits pour bébés, meilleure marque pour bébés, produits pour nouveau-nés, confort\r\nCoussin de massage doux\r\nNos tire-lait ont été conçus pour votre confort. La texture douce et veloutée des coussins de massage est chaude et confortable contre votre peau, ce qui peut aider à stimuler la montée de lait. Et le coussin, avec ses pétales massants, est conçu pour imiter l’action de succion de votre bébé, ce qui peut aider à la descente de lait.\r\n\r\nConception légère et compacte\r\nLa conception légère et compacte signifie que vous pouvez facilement exprimer à la maison ou l’emporter avec vous pour exprimer en déplacement.\r\n\r\nFacile à utiliser et à nettoyer\r\nCe tire-lait a été conçu avec seulement quelques pièces, qui sont intuitives à assembler et faciles à nettoyer. Juste une autre façon de rendre la vie un peu plus facile.\r\n\r\nLivré avec notre bouteille Natural\r\nLa large tétine en forme de sein permet de combiner facilement l’allaitement au sein et au biberon. La forme et la sensation de la tétine imitent le sein, ce qui facilite la transition de l’allaitement au biberon.\r\n\r\ntire-lait électrique, produits pour bébés, meilleurs produits pour bébés, meilleure marque pour bébés, produits pour nouveau-nés, confort\r\nExpress en position de détente\r\nGrâce à la conception unique de ce tire-lait, vous n’avez pas besoin de vous pencher en avant pour exprimer votre lait. Votre lait s’écoulera directement dans le biberon, même lorsque vous êtes assis bien droit. Cela signifie que vous pouvez vous asseoir plus confortablement et vous sentir plus détendu, ce qui est prouvé pour aider votre lait à couler.', '7500', '2024-05-09 13:31:09.488780'),
('a58ef940db', 'PNMX-4156', 'Tide Simply Refreshing Breeze, 31 Fl Oz', 15, 'image_2024-05-09_132800847.png', 'Dur sur les odeurs, facile sur votre portefeuille\r\n2x la puissance du détergent à lessive au bicarbonate de soude*\r\nNettoie les tissus en un seul lavage sans prétraitement requis\r\n\r\nLe détergent à lessive liquide Tide Simply Clean and Fresh a 2X la puissance du bicarbonate de soude* pour cibler les odeurs tenaces en profondeur dans les fibres de vos vêtements. Il est maintenant plus concentré pour offrir plus de détachage et de fraîcheur et moins d’eau*. Du détergent n°1 aux États-Unis**, pour couvrir vos nombreux besoins de lessive.\r\n\r\nMesurez vos charges avec bouchon. Pour les brassées moyennes, remplissez jusqu’à la barre 1. Pour les grosses brassées, remplissez jusqu’à la barre 3. Pour les brassées HE pleines, remplissez jusqu’à la barre 5. Ajoutez les vêtements, versez dans le distributeur, démarrez la laveuse.\r\n\r\n* vs formule précédente\r\n** basé sur les ventes\r\nDur sur les odeurs, facile sur votre portefeuille\r\n2x la puissance du détergent à lessive au bicarbonate de soude*\r\nNettoie les tissus en un seul lavage sans prétraitement requis\r\nAvec une formule plus concentrée, vous obtenez plus d’agents de nettoyage et moins d’eau dans chaque goutte. *vs. formule précédente\r\nFonctionne dans les charges de linge pour les machines à laver HE et non HE', '3500', '2024-06-24 13:36:45.827611'),
('beea389cb0', 'FBGN-9547', 'Easy On Starch 567g', 15, 'image_2024-05-09_132846781.png', 'Vous n’avez pas besoin de renoncer à l’apparence nette des nettoyeurs professionnels si vous repassez à la maison. Utilisez EASY-ON Speed Starch pour faciliter et accélérer le repassage et obtenir un look professionnel impeccable. Essayez EASY-ON Double Starch pour les tissus plus épais comme les cols et poignets de chemise, le lin et le denim.', '2000', '2024-06-24 13:36:45.827611'),
('f92e65bbef', 'RVYH-2908', 'Alsa Levure chimique', 15, 'image_2024-05-09_131518627.png', '8 sachets de 11 g\r\n\r\nDepuis 1897, l’emblématique « sachet rose » est le partenaire indispensable pour faire lever tous vos gâteaux, vos pâtes à beignets et autres gourmandises !', '500', '2024-06-24 13:36:45.827611');

-- --------------------------------------------------------

--
-- Structure de la table `rpos_pass_resets`
--

CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `creee_le` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`identifiant_admin`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`identifiant_client`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`identifiant_commande`),
  ADD KEY `identifiant_client` (`identifiant_client`);

--
-- Index pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD PRIMARY KEY (`identifiant_commande`,`identifiant_produit`),
  ADD KEY `identifiant_produit` (`identifiant_produit`);

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`identifiant_employee`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `code_commande` (`code_commande`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`identifiant_produit`);

--
-- Index pour la table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `identifiant_employee` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`identifiant_client`) REFERENCES `clients` (`identifiant_client`);

--
-- Contraintes pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD CONSTRAINT `commande_produit_ibfk_1` FOREIGN KEY (`identifiant_commande`) REFERENCES `commandes` (`identifiant_commande`),
  ADD CONSTRAINT `commande_produit_ibfk_2` FOREIGN KEY (`identifiant_produit`) REFERENCES `produits` (`identifiant_produit`);

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`code_commande`) REFERENCES `commandes` (`identifiant_commande`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

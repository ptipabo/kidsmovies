-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 13 sep. 2020 à 14:21
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kidsmovies`
--
CREATE DATABASE IF NOT EXISTS `kidsmovies` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kidsmovies`;

-- --------------------------------------------------------

--
-- Structure de la table `characters`
--

CREATE TABLE `characters` (
  `char_id` int(10) UNSIGNED NOT NULL,
  `char_movie` int(10) UNSIGNED NOT NULL,
  `char_name` varchar(255) NOT NULL,
  `char_img` varchar(255) NOT NULL,
  `char_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `characters`
--

INSERT INTO `characters` (`char_id`, `char_movie`, `char_name`, `char_img`, `char_desc`) VALUES
(1, 1, 'Flash McQueen', 'cars_flash.jpg', 'Flash McQueen est une jeune voiture de course de type NASCAR conçue pour être rapide.'),
(2, 1, 'Martin', 'cars_martin.jpg', 'Martin est le meilleur ami de Flash McQueen.'),
(3, 3, 'Elsa', 'la_reine_des_neiges_elsa.jpg', 'Elsa est la reine du royaume d\'Arendelle, elle semble parfaite en tout point mais cache un terrible secret : elle possède la capacité de contrôler la neige et la glace!'),
(4, 4, 'Tilt', '1001pattes_tilt.jpg', 'Tilt est une fourmi à l\'esprit un peu trop créatif. Il reçoit l’ordre d’arrêter ses inventions censées améliorer la productivité et de faire comme tout le monde. Il est soutenu par Couette, pour qui il a une grande affection...'),
(5, 4, 'Couette', '1001pattes_couette.jpg', 'Le princesse Couette est la fille cadette de La Reine fourmi de la colonie des fourmis. Sa sœur aînée, Atta, est l\'héritière du trône. Couette est au départ la seule amie et partisane de Tilt. Elle est membre des Fourmis scouts, un groupe similaire à une troupe de scouts. Comme sa sœur et sa mère, elle a des ailes, mais elles ne sont pas encore complètement développées en raison de son âge.'),
(6, 9, 'Toby', 'basil_detective_prive_toby.jpg', 'Toby est le chien du célèbre détective Sherlock Holmes, qui vit juste au-dessus de Basil au 221 Baker Street. La souris fait régulièrement appel au basset pour l\'aider à résoudre des enquêtes, en raison de l\'excellence de son flair.'),
(7, 1, 'Sally', 'cars_sally.jpg', 'Sally Carrera, plus connue simplement en tant que Sally, est l\'avocate de la petite ville de Radiator Springs ainsi que la conjointe du célèbre bolide Flash McQueen.'),
(8, 1, 'Doc Hudson', 'cars_dochudson.jpg', 'Doc Hudson, également connu en tant que Fabuleux Hudson Hornet, est un ancien coureur automobile devenu le médecin et le juge de la petite ville de Radiator Springs.');

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(10) UNSIGNED NOT NULL,
  `movie_img` varchar(255) NOT NULL,
  `movie_title` varchar(255) NOT NULL,
  `movie_story` text NOT NULL,
  `movie_suite` int(10) UNSIGNED NOT NULL,
  `movie_date` year(4) NOT NULL,
  `movie_length` int(10) UNSIGNED NOT NULL,
  `movie_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_img`, `movie_title`, `movie_story`, `movie_suite`, `movie_date`, `movie_length`, `movie_url`) VALUES
(1, 'Cars 1.jpg', 'Cars', 'Flash McQueen, splendide voiture de course promise au succès, doit participer à la prestigieuse Piston Cup. À cause d\'une déviation, Flash atterrit dans la petite ville de Radiator Springs, sur la Route 66. Il va alors rencontrer Sally, une élégante Porsche 2002, Doc Hudson, une Hudson Hornet 1951 au passé mystérieux, et Martin, une dépanneuse rouillée mais à qui on peut faire confiance.', 2, 2006, 117, 'cars'),
(2, 'Toy story 1.jpg', 'Toy Story', '', 1, 1995, 95, 'toy-story'),
(3, 'La reine des neiges 1.jpg', 'La reine des neiges', '', 3, 2013, 109, 'la-reine-des-neiges'),
(4, '1001 pattes.jpg', '1001 pattes', 'Tilt, fourmi quelque peu tête en l\'air, détruit par inadvertance la récolte de la saison. La fourmilière est dans tous ses états. En effet cette bévue va rendre fou de rage le Borgne, méchant insecte qui chaque été fait main basse sur une partie de la récolte avec sa bande de sauterelles racketteuses. Tilt décide de quitter l\'île pour recruter des mercenaires capables de chasser le Borgne.', 4, 1998, 95, '1001-pattes'),
(5, 'Aladdin.jpg', 'Aladdin', '', 5, 1992, 128, 'aladdin'),
(6, 'Alice au pays des merveilles.jpg', 'Alice au pays des merveilles', '', 6, 1951, 75, 'alice-au-pays-des-merveilles'),
(7, 'Atlantide l\'empire perdu.jpg', 'Atlantide l\'empire perdu', '', 7, 2001, 96, 'atlantide-l-empire-perdu'),
(8, 'Bambi.jpg', 'Bambi', '', 8, 1942, 70, 'bambi'),
(9, 'Basil détective privé.jpg', 'Basil détective privé', '', 9, 1986, 74, 'basil-detective-prive'),
(10, 'Bernard et Bianca 1.jpg', 'Les aventures de Bernard et Bianca', '', 10, 1977, 77, 'les-aventures-de-bernard-et-bianca'),
(11, 'Bernard et Bianca 2.jpg', 'Bernard et Bianca au pays des kangourous', '', 10, 1990, 113, 'bernard-et-banca-au-pays-des-kangourous'),
(12, 'Blanche-Neige et les sept nains.jpg', 'Blanche-Neige et les sept nains', '', 11, 1937, 83, 'blanche-neige-et-les-sept-nains'),
(13, 'Cars 2.jpg', 'Cars 2', 'Flash McQueen, la star des circuits automobiles, et son fidèle compagnon Martin la dépanneuse reprennent la route pour courir le tout premier Grand Prix Mondial, qui sacrera la voiture la plus rapide du monde ! Mais la route est pleine d\'imprévus, de déviations et de surprises, surtout lorsque Martin se retrouve entraîné dans une affaire d\'espionnage international !', 2, 2011, 106, 'cars-2'),
(14, 'Cars 3.jpg', 'Cars 3', 'Surpris par la nouvelle génération de voitures de course ultrarapides, le légendaire Flash McQueen est soudainement évincé du sport qu\'il aime tant. Afin de revenir dans le coup, il demande l\'aide de Cruz Ramirez, une jeune technicienne de course enthousiaste qui a son propre plan pour remporter la victoire, et prend quelques détours inattendus en cours de route.', 2, 2017, 102, 'cars-3'),
(15, 'Cendrillon.jpg', 'Cendrillon', '', 12, 1950, 74, 'cendrillon'),
(16, 'Coco.jpg', 'Coco', '', 13, 2017, 105, 'coco'),
(17, 'Dumbo.jpg', 'Dumbo', '', 14, 1941, 64, 'dumbo'),
(18, 'En avant.jpg', 'En avant', '', 15, 2020, 103, 'en-avant'),
(19, 'Fantasia 2000.jpg', 'Fantasia 2000', '', 21, 1999, 75, 'fantasia-2000'),
(20, 'Fantasia.jpg', 'Fantasia', '', 21, 1940, 125, 'fantasia'),
(21, 'Frère des ours.jpg', 'Frère des ours', '', 16, 2003, 85, 'frere-des-ours'),
(22, 'Hercule.jpg', 'Hercule', '', 17, 1997, 89, 'hercule'),
(23, 'Kuzco.jpg', 'Kuzco', 'Kuzco est un jeune empereur inca très égoïste et capricieux. Pour ses dix-huit ans, il décide de raser un village afin de se faire construire une résidence, « Kuzcotopia ». Il décide par la même occasion de renvoyer sa conseillère Yzma mais celle-ci, avide de pouvoir, ne veut pas en rester là. Elle invite donc Kuzco à un dîner, afin de l\'empoisonner et de prendre sa place à la tête de l\'empire inca. Mais tout ne se passe pas comme prévu : Kuzco se retrouve transformé en lama.', 18, 2000, 75, 'kuzco'),
(24, 'La belle au bois dormant.jpg', 'La belle au bois dormant', '', 19, 1959, 75, 'la-belle-au-bois-dormant'),
(25, 'La belle et la bête.jpg', 'La belle et la bête', '', 20, 1991, 87, 'la-belle-et-la-bete'),
(26, 'La belle et le clochard.jpg', 'La belle et le clochard', '', 22, 1955, 75, 'la-belle-et-le-clochard'),
(27, 'La petite sirène.jpg', 'La petite sirène', '', 23, 1989, 83, 'la-petite-sirene'),
(28, 'La planète au trésor.jpg', 'La planète au trésor', '', 24, 2002, 95, 'la-planete-au-tresor'),
(29, 'La princesse et la grenouille.jpg', 'La princesse et la grenouille', '', 25, 2009, 97, 'la-princesse-et-la-grenouille'),
(30, 'La reine des neiges 2.jpg', 'La reine des neiges 2', '', 3, 2019, 103, 'la-reine-des-neiges-2'),
(31, 'L\'age de glace 1.jpg', 'L\'age de glace', '', 26, 2002, 85, 'l-age-de-glace'),
(32, 'L\'age de glace 2.jpg', 'L\'age de glace 2', '', 26, 2006, 91, 'l-age-de-glace-2'),
(33, 'L\'age de glace 3.jpg', 'L\'age de glace 3', '', 26, 2009, 94, 'l-age-de-glace-3'),
(34, 'L\'age de glace 4.jpg', 'L\'age de glace 4', '', 26, 2012, 88, 'l-age-de-glace-4'),
(35, 'L\'age de glace 5.jpg', 'L\'age de glace 5', '', 26, 2016, 94, 'l-age-de-glace-5'),
(36, 'Là-haut.jpg', 'Là-haut', '', 27, 2009, 96, 'la-haut'),
(37, 'Le bossu de notre-dame.jpg', 'Le bossu de Notre-Dame', '', 28, 1996, 87, 'le-bossu-de-notre-dame'),
(38, 'Le livre de la jungle 1.jpg', 'Le livre de la jungle', '', 29, 1967, 78, 'le-livre-de-la-jungle'),
(39, 'Le livre de la jungle 2.jpg', 'Le livre de la jungle 2', '', 29, 2003, 72, 'le-livre-de-la-jungle-2'),
(40, 'Le monde de Dory.jpg', 'Le monde de Dory', '', 30, 2016, 97, 'le-monde-de-dory'),
(41, 'Le monde de Némo.jpg', 'Le monde de Némo', '', 30, 2003, 101, 'le-monde-de-nemo'),
(42, 'Le roi lion 1.jpg', 'Le roi lion', '', 31, 1994, 89, 'le-roi-lion'),
(43, 'Le roi lion 2.jpg', 'Le roi lion 2', '', 31, 1998, 78, 'le-roi-lion-2'),
(44, 'Le roi lion 3.jpg', 'Le roi lion 3', '', 31, 2004, 73, 'le-roi-lion-3'),
(45, 'Le voyage d\'Arlo.jpg', 'Le voyage d\'Arlo', '', 32, 2015, 94, 'le-voyage-d-arlo'),
(46, 'Les 101 dalmatiens.jpg', 'Les 101 dalmatiens', '', 33, 1961, 79, 'les-101-dalmatiens'),
(47, 'Les aristochats.jpg', 'Les aristochats', '', 34, 1970, 78, 'les-aristochats'),
(48, 'Les indestructibles 1.jpg', 'Les indestructibles', '', 35, 2004, 115, 'les-indestructibles'),
(49, 'Les indestructibles 2.jpg', 'Les indestructibles 2', '', 35, 2018, 118, 'les-indestructibles-2'),
(50, 'Les mondes de Ralph 1.jpg', 'Les mondes de Ralph', '', 36, 2012, 108, 'les-mondes-de-ralph'),
(51, 'Les mondes de Ralph 2.jpg', 'Les mondes de Ralph 2', '', 36, 2018, 112, 'les-mondes-de-ralph-2'),
(52, 'L\'étrange Noël de Monsieur Jack.jpg', 'L\'étrange Noël de Monsieur Jack', '', 37, 1993, 76, 'l-etrange-noel-de-monsieur-jack'),
(53, 'Lilo et Stitch.jpg', 'Lilo et Stitch', '', 38, 2002, 85, 'lilo-et-stitch'),
(54, 'Mary Poppins.jpg', 'Mary Poppins', '', 39, 1964, 139, 'mary-poppins'),
(55, 'Merlin l\'enchanteur.jpg', 'Merlin l\'enchanteur', '', 40, 1963, 79, 'merlin-l-enchanteur'),
(56, 'Monstres et compagnie.jpg', 'Monstres et compagnie', '', 41, 2001, 92, 'monstres-et-compagnie'),
(57, 'Monstres Academy.jpg', 'Monstres Academy', '', 41, 2013, 102, 'monstres-academy'),
(58, 'Mulan.jpg', 'Mulan', '', 42, 1998, 88, 'mulan'),
(59, 'Oliver et compagnie.jpg', 'Oliver et compagnie', '', 43, 1988, 73, 'oliver-et-compagnie'),
(60, 'Peter Pan.jpg', 'Peter Pan', '', 44, 1953, 76, 'peter-pan'),
(61, 'Pinocchio.jpg', 'Pinocchio', '', 45, 1940, 88, 'pinocchio'),
(62, 'Planes 1.jpg', 'Planes', '', 46, 2013, 92, 'planes'),
(63, 'Planes 2.jpg', 'Planes 2', '', 46, 2014, 83, 'planes-2'),
(64, 'Pocahontas.jpg', 'Pocahontas', '', 47, 1995, 81, 'pocahontas'),
(65, 'Raiponce.jpg', 'Raiponce', '', 48, 2010, 100, 'raiponce'),
(66, 'Ratatouille.jpg', 'Ratatouille', '', 49, 2007, 111, 'ratatouille'),
(67, 'Rebelle.jpg', 'Rebelle', '', 50, 2012, 93, 'rebelle'),
(68, 'Robin des bois.jpg', 'Robin des bois', '', 51, 1973, 83, 'robin-des-bois'),
(69, 'Rox et Rouky.jpg', 'Rox et Rouky', '', 52, 1981, 83, 'rox-et-rouky'),
(70, 'Spirit l\'étalon des plaines.jpg', 'Spirit l\'étalon des plaines', '', 53, 2002, 84, 'spirit-l-etalon-des-plaines'),
(71, 'Taram et le chaudron magique.jpg', 'Taram et le chaudron magique', '', 54, 1985, 80, 'taram-et-le-chaudron-magique'),
(72, 'Tarzan.jpg', 'Tarzan', '', 55, 1999, 88, 'tarzan'),
(73, 'Toy Story 2.jpg', 'Toy Story 2', '', 1, 1999, 93, 'toy-story-2'),
(74, 'Toy Story 3.jpg', 'Toy Story 3', '', 1, 2010, 103, 'toy-story-3'),
(75, 'Toy Story 4.jpg', 'Toy Story 4', '', 1, 2019, 100, 'toy-story-4'),
(76, 'Vaiana.jpg', 'Vaiana', '', 56, 2016, 107, 'vaiana'),
(77, 'Vice-versa.jpg', 'Vice-versa', '', 57, 2015, 94, 'vice-versa'),
(78, 'Volt.jpg', 'Volt', '', 58, 2008, 96, 'volt'),
(79, 'Wall-E.jpg', 'Wall-E', '', 59, 2008, 98, 'wall-e');

-- --------------------------------------------------------

--
-- Structure de la table `moviesuite`
--

CREATE TABLE `moviesuite` (
  `suite_id` int(10) UNSIGNED NOT NULL,
  `suite_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `moviesuite`
--

INSERT INTO `moviesuite` (`suite_id`, `suite_title`) VALUES
(1, 'Toy Story'),
(2, 'Cars'),
(3, 'La reine des neiges'),
(4, '1001 pattes'),
(5, 'Aladdin'),
(6, 'Alice au payx des merveilles'),
(7, 'Atlantide l\'empire perdu'),
(8, 'Bambi'),
(9, 'Basil détective privé'),
(10, 'Bernard et Bianca'),
(11, 'Blanche-Neige et les sept nains'),
(12, 'Cendrillon'),
(13, 'Coco'),
(14, 'Dumbo'),
(15, 'En avant'),
(16, 'Frère des ours'),
(17, 'Hercule'),
(18, 'Kuzco'),
(19, 'La belle au bois dormant'),
(20, 'La belle et la bête'),
(21, 'Fantasia'),
(22, 'La belle et le Clochard'),
(23, 'La petite sirène'),
(24, 'La planète au trésor'),
(25, 'La princesse et la grenouille'),
(26, 'L\'âge de glace'),
(27, 'Là-haut'),
(28, 'Le bossu de Notre-Dame'),
(29, 'Le livre de la jungle'),
(30, 'Le monde Nemo'),
(31, 'Le roi lion'),
(32, 'Le voyage d\'Arlo'),
(33, 'Les 101 dalmatiens'),
(34, 'Les aristochats'),
(35, 'Les indestructibles'),
(36, 'Les mondes de Ralph'),
(37, 'L\'étrange Noël de Monsieur Jack'),
(38, 'Lilo et Stitch'),
(39, 'Mary Poppins'),
(40, 'Merlin l\'enchanteur'),
(41, 'Monstres et compagnie'),
(42, 'Mulan'),
(43, 'Oliver et compagnie'),
(44, 'Peter Pan'),
(45, 'Pinocchio'),
(46, 'Planes'),
(47, 'Pocahontas'),
(48, 'Raiponce'),
(49, 'Ratatouille'),
(50, 'Rebelle'),
(51, 'Robin des bois'),
(52, 'Rox et Rouky'),
(53, 'Spirit l\'étalon des plaines'),
(54, 'Taram et le chaudron magique'),
(55, 'Tarzan'),
(56, 'Vaiana'),
(57, 'Vice-versa'),
(58, 'Volt'),
(59, 'Wall-E');

-- --------------------------------------------------------

--
-- Structure de la table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(10) UNSIGNED NOT NULL,
  `song_movie` int(10) UNSIGNED NOT NULL,
  `song_title` varchar(255) NOT NULL,
  `song_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `songs`
--

INSERT INTO `songs` (`song_id`, `song_movie`, `song_title`, `song_video`) VALUES
(1, 1, 'Real gone', 'https://www.youtube.com/embed/WxptxCewdBo'),
(2, 76, 'Pour les hommes', 'https://www.youtube.com/embed/Vuq_D7gFm_A'),
(3, 76, 'Bling-bling', 'https://www.youtube.com/embed/bNMMpmpZBDY'),
(4, 2, 'Je suis ton ami', 'https://www.youtube.com/embed/81dWdeDjfC4'),
(5, 76, 'Le bleu lumière', 'https://www.youtube.com/embed/cDuwyrnVN4M'),
(6, 76, 'Notre terre', 'https://www.youtube.com/embed/IVSeUmQMWR8'),
(7, 76, 'L\'explorateur', 'https://www.youtube.com/embed/3WA34hxlejg'),
(8, 76, 'Je suis Vaiana', 'https://www.youtube.com/embed/rSaQd4j0PGs'),
(9, 76, 'Te Fiti', 'https://www.youtube.com/embed/K8pIF8EXnyA'),
(10, 1, 'Life is a highway', 'https://www.youtube.com/embed/jURRsAMGuZk'),
(11, 1, 'Our town', 'https://www.youtube.com/embed/fbHbRipzRgE'),
(12, 1, 'Doc racing', 'https://www.youtube.com/embed/_ef17Xhnzxw'),
(13, 2, 'Jamais plus je ne volerai', 'https://www.youtube.com/embed/gU9NdeOkRIc'),
(14, 2, 'Etrange bizarre', 'https://www.youtube.com/embed/pT4YklQA7gM'),
(15, 58, 'Comme un homme', 'https://www.youtube.com/embed/E-p6l9nioNI'),
(16, 58, 'Réflexion', 'https://www.youtube.com/embed/KQd0ifv1yqc'),
(17, 58, 'Une fille à aimer', 'https://www.youtube.com/embed/aQPTXmUJumg'),
(18, 25, 'Histoire éternelle', 'https://www.youtube.com/embed/8oHJbu3LUJg'),
(19, 25, 'Belle', 'https://www.youtube.com/embed/Vm7gj9vqBjY'),
(20, 25, 'Gaston', 'https://www.youtube.com/embed/WeAWPIU5D_k'),
(21, 25, 'C\'est la fête', 'https://www.youtube.com/embed/Xq3W-J7CZdk'),
(22, 25, 'Prologue', 'https://www.youtube.com/embed/m-fsxPmddXE'),
(23, 58, 'Honneur à tous', 'https://www.youtube.com/embed/bt65rqrVjO4'),
(24, 5, 'Je suis ton meilleur ami', 'https://www.youtube.com/embed/N6ykVehoaeI'),
(25, 5, 'Prince Ali', 'https://www.youtube.com/embed/H1Fv67HKdkQ'),
(26, 65, 'Où est la vraie vie?', 'https://www.youtube.com/embed/KoFOaB9c8eI'),
(27, 65, 'J\'ai un rêve', 'https://www.youtube.com/embed/_L8HUELtXBE'),
(28, 65, 'Je veux y croire', 'https://www.youtube.com/embed/uf-9J5fooFE'),
(29, 5, 'Je vole', 'https://www.youtube.com/embed/-SaJz9eBUEk'),
(30, 5, 'Nuits d\'Arabie', 'https://www.youtube.com/embed/4y779NcKrLo'),
(31, 5, 'Prince Ali (version Jafar)', 'https://www.youtube.com/embed/jNrzHPR-ckY'),
(32, 29, 'Humain pour la vie', 'https://www.youtube.com/embed/DjXp0O6XAH4'),
(33, 29, 'Creuser encore et encore', 'https://www.youtube.com/embed/oC7sOoyW1IY'),
(34, 3, 'Nul n\'est parfait', 'https://www.youtube.com/embed/GDL7g0VA448'),
(35, 3, 'Libérée, délivrée', 'https://www.youtube.com/embed/wQP9XZc2Y_c'),
(36, 3, 'Je voudrais un bonhomme de neige', 'https://www.youtube.com/embed/3QAXFudxqRM'),
(37, 3, 'Le renouveau', 'https://www.youtube.com/embed/xsqptzTAO4A'),
(38, 3, 'En été', 'https://www.youtube.com/embed/xBPay2i_emc'),
(39, 3, 'Le coeur de glace', 'https://www.youtube.com/embed/itGKy_jLdEw'),
(40, 16, 'Un Poco Loco', 'https://www.youtube.com/embed/yg8116aeD7E'),
(41, 16, 'La Llorona', 'https://www.youtube.com/embed/hAYUQ1ltJj0'),
(42, 16, 'Proud Corazón', 'https://www.youtube.com/embed/sLkDCF_EbqI'),
(43, 16, 'Ne m\'oublie pas', 'https://www.youtube.com/embed/NnDHlxuy9u0'),
(44, 30, 'Je te cherche', 'https://www.youtube.com/embed/yfLQtedCh80'),
(45, 30, 'Dans un autre monde', 'https://www.youtube.com/embed/AJ5SbhJKxu0'),
(46, 30, 'Quand je serai plus grand', 'https://www.youtube.com/embed/34nnVqswt4c'),
(47, 30, 'Point d\'avenir sans nous', 'https://www.youtube.com/embed/p7hn-PFjBHc'),
(48, 56, 'Intro', 'https://www.youtube.com/embed/qWNIM_Gx9aU'),
(49, 56, 'Si je ne t\'avais pas', 'https://www.youtube.com/embed/SPGejWoACXU'),
(50, 17, 'Mon tout petit', 'https://www.youtube.com/embed/izwiy9nya9s'),
(51, 17, 'Quand je vois voler un éléphant', 'https://www.youtube.com/embed/vyD_YbWB_JY'),
(52, 24, 'J\'en ai rêvé', 'https://www.youtube.com/embed/qZivBdFJLk8'),
(53, 24, 'Je voudrais', 'https://www.youtube.com/embed/AGdjHnBgnIU'),
(54, 24, 'J\'en ai rêvé (final)', 'https://www.youtube.com/embed/GPVSBSsuLKY'),
(55, 35, 'My superstar', 'https://www.youtube.com/embed/3DV7HkLNtjk'),
(56, 35, 'Figaro', 'https://www.youtube.com/embed/bWX08RnzReI'),
(57, 34, 'Capitaine Gutt', 'https://www.youtube.com/embed/nog0dU67VfY'),
(58, 34, 'We are family', 'https://www.youtube.com/embed/j8pyXAY_CAs'),
(59, 27, 'Sous l\'océan', 'https://www.youtube.com/embed/4iQETIfbzvk'),
(60, 27, 'Partir là-bas', 'https://www.youtube.com/embed/_5KRPBFIboU'),
(61, 27, 'Pour toi et moi', 'https://www.youtube.com/embed/A50ABApvWdU'),
(62, 27, 'Pauvre âme en perdition', 'https://www.youtube.com/embed/RQGQDcz-jWI'),
(63, 27, 'Les 6 filles du roi Triton', 'https://www.youtube.com/embed/arFFg11l7vw');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`char_id`);

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Index pour la table `moviesuite`
--
ALTER TABLE `moviesuite`
  ADD PRIMARY KEY (`suite_id`);

--
-- Index pour la table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `characters`
--
ALTER TABLE `characters`
  MODIFY `char_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `moviesuite`
--
ALTER TABLE `moviesuite`
  MODIFY `suite_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

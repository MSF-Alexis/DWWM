DROP DATABASE IF EXISTS mini_reseau_social;

CREATE DATABASE mini_reseau_social
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mini_reseau_social;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(150) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Syntaxe pour insérer une ligne
INSERT INTO users (username, email, PASSWORD) VALUES ('tibone', 'tibtib76@hotmail.fr', '$2y$10$KEWDQUGrhOJlrp8opunTz.VwrsUB2Rn9FWLKdUS.pFWS1gyF/ckp.');


-- Syntaxe pour faire de l'insertion multiple depuis une execution INSERT
INSERT INTO users (username, email, PASSWORD) VALUES 
	('alex-l', 'alexis.l.msg@gmail.com', '$2y$10$941AoVHhR/wGZdI5aSdb6.WjJdKrC9g47fuwjXZe1TiQ3R/nrdEEa'),
	('miguel', 'migoumac@yahoo.com', '$2y$10$x.Sysj/rJCzFJyg9CKZTEOftlGDaXwkTiYly.0o30tSSwcGYLMfmq'),
	('maya-labeille', 'mireille-danse@msn.fr', '$2y$10$wUCQTkZzmWjW9isQVVB.E.GpU.C4c1vA2QFhTN9OOXwF78vJZlO4C'),
	('louis-sanson', 'hein-quoi@gmail.com', '$2y$10$wUCQTkZzmWjW9isQVVB.E.GpU.C4c1vA2QFhTN9OOXwF78vJZlO4C');

DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
	content VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_users_id_post FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT posts (user_id, content) VALUES
	(2, 'Le dernier film cars est un pure banger'),
	(3, 'Je regarde un dessin anime d\'abeilles c\'est super !'),
	(1, 'Encore et encore du PHP toujours du PHP'),
	(4, 'Invaincu sur mario kart et vous ? ');


DROP table IF EXISTS groups;
CREATE TABLE groups (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(127) NOT NULL,
    description VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO groups (name, description) VALUES
    ('Amoureux des oiseaux', "Ici grand fan d'oiseaux"),
    ("Les foufous du volants", "Ici on adore le vélo"),
    ("Les foufooteux", "Pro du handball"),
    ("MCF", "Mega chuper fien");

DROP table IF EXISTS group_user;
CREATE TABLE group_user (
    group_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_id_group_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_groups_id_group_user FOREIGN KEY (group_id) REFERENCES groups(id),
    CONSTRAINT uq_group_id_user_id_group_user UNIQUE(group_id, user_id)
);

INSERT INTO
    group_user (group_id, user_id)
VALUES
    (1, 1),
    (1, 2),
    (2, 3),
    (3, 2),
    (1, 4);

ALTER TABLE users ADD COLUMN verified_at TIMESTAMP;
ALTER TABLE users ADD COLUMN is_banned BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE users ADD COLUMN age TINYINT NOT NULL;

UPDATE users SET age = 14, verified_at = CURRENT_TIMESTAMP WHERE ID = 1;
UPDATE users SET age = 90, verified_at = DATE_SUB(NOW(), INTERVAL 30 DAY) WHERE ID = 2;
UPDATE users SET age = 34, verified_at = DATE_ADD(NOW(), INTERVAL 5 DAY) WHERE ID = 3;
UPDATE users SET age = 18, verified_at = DATE_SUB(NOW(), INTERVAL 1 HOUR) WHERE ID = 4;
UPDATE users SET age = 112, verified_at = DATE_SUB(NOW(), INTERVAL 10 YEAR) WHERE ID = 5;

INSERT INTO users (username, email, password, age, verified_at, is_banned, created_at) VALUES
('sophie_m', 'sophie.m@example.com', '$2y$10$KEWDQUGrhOJlrp8opunTz.VwrsUB2Rn9FWLKdUS.pFWS1gyF/ckp.', 25, DATE_SUB(NOW(), INTERVAL 30 DAY), 0, DATE_SUB(NOW(), INTERVAL 30 DAY)),
('julien_p', 'julien.p@example.com', '$2y$10$941AoVHhR/wGZdI5aSdb6.WjJdKrC9g47fuwjXZe1TiQ3R/nrdEEa', 30, DATE_SUB(NOW(), INTERVAL 1 YEAR), 1, DATE_SUB(NOW(), INTERVAL 1 YEAR)),
('marine_l', 'marine.l@example.com', '$2y$10$x.Sysj/rJCzFJyg9CKZTEOftlGDaXwkTiYly.0o30tSSwcGYLMfmq', 22, DATE_SUB(NOW(), INTERVAL 3 MONTH), 0, DATE_SUB(NOW(), INTERVAL 3 MONTH)),
('thomas_b', 'thomas.b@example.com', '$2y$10$wUCQTkZzmWjW9isQVVB.E.GpU.C4c1vA2QFhTN9OOXwF78vJZlO4C', 28, DATE_SUB(NOW(), INTERVAL 352 DAY), 0, DATE_SUB(NOW(), INTERVAL 352 DAY)),
('laura_d', 'laura.d@example.com', '$2y$10$KEWDQUGrhOJlrp8opunTz.VwrsUB2Rn9FWLKdUS.pFWS1gyF/ckp.', 24, DATE_SUB(NOW(), INTERVAL 95 DAY), 1, DATE_SUB(NOW(), INTERVAL 95 DAY)),
('antoine_v', 'antoine.v@example.com', '$2y$10$941AoVHhR/wGZdI5aSdb6.WjJdKrC9g47fuwjXZe1TiQ3R/nrdEEa', 31, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY), 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('elodie_k', 'elodie.k@example.com', '$2y$10$x.Sysj/rJCzFJyg9CKZTEOftlGDaXwkTiYly.0o30tSSwcGYLMfmq', 27, NULL, 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('nicolas_r', 'nicolas.r@example.com', '$2y$10$wUCQTkZzmWjW9isQVVB.E.GpU.C4c1vA2QFhTN9OOXwF78vJZlO4C', 29, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY), 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('amelie_t', 'amelie.t@example.com', '$2y$10$KEWDQUGrhOJlrp8opunTz.VwrsUB2Rn9FWLKdUS.pFWS1gyF/ckp.', 23, NULL, 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('pierre_l', 'pierre.l@example.com', '$2y$10$941AoVHhR/wGZdI5aSdb6.WjJdKrC9g47fuwjXZe1TiQ3R/nrdEEa', 26, NULL, 1, NOW()),
('claire_m', 'claire.m@example.com', '$2y$10$x.Sysj/rJCzFJyg9CKZTEOftlGDaXwkTiYly.0o30tSSwcGYLMfmq', 32, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY), 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('quentin_g', 'quentin.g@example.com', '$2y$10$wUCQTkZzmWjW9isQVVB.E.GpU.C4c1vA2QFhTN9OOXwF78vJZlO4C', 33, NULL, 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('lucie_b', 'lucie.b@example.com', '$2y$10$KEWDQUGrhOJlrp8opunTz.VwrsUB2Rn9FWLKdUS.pFWS1gyF/ckp.', 20, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY), 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('romain_f', 'romain.f@example.com', '$2y$10$941AoVHhR/wGZdI5aSdb6.WjJdKrC9g47fuwjXZe1TiQ3R/nrdEEa', 35, NULL, 0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY)),
('jessica_p', 'jessica.p@example.com', '$2y$10$x.Sysj/rJCzFJyg9CKZTEOftlGDaXwkTiYly.0o30tSSwcGYLMfmq', 21, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY), 1, DATE_SUB(NOW(), INTERVAL FLOOR(RAND()*364) DAY));


INSERT INTO groups (name, description) VALUES
('Les voyageurs', 'Pour ceux qui aiment découvrir le monde'),
('Geeks unis', 'Communauté pour les passionnés de technologie'),
('Food addicts', 'Partagez vos meilleures recettes'),
('Fitness motivation', 'Pour rester en forme ensemble'),
('Photographes amateurs', 'Partagez vos plus belles photos'),
('Lecteurs assidus', 'Club de lecture et recommandations'),
('Cinéphiles', 'Discussion sur les films et séries'),
('Musiciens en herbe', 'Pour les amateurs de musique'),
('Jardiniers urbains', 'Conseils pour cultiver en ville'),
('Économiseurs malins', 'Astuces pour économiser au quotidien');

INSERT INTO posts (user_id, content) VALUES
(1, 'Je prépare mon prochain voyage, des suggestions ?'),
(1, 'Quelqu un connaît de bonnes adresses à Tokyo ?'),
(1, 'Juste partagé quelques photos de mon dernier voyage !'),
(1, 'Besoin de conseils pour voyager léger.'),
(1, 'Mon top 5 des destinations à visiter absolument.'),
(1, 'Quel est votre pays préféré et pourquoi ?'),
(1, 'Partagez vos meilleures astuces voyage !'),
(1, 'Comment économiser sur les billets d avion ?'),
(1, 'Voyager seul ou à plusieurs ? Vos expériences.'),
(1, 'Découvert un petit café adorable à Paris aujourd hui.'),
(2, 'Nouvelle mise à jour de mon OS préféré !'),
(2, 'Quel langage de programmation apprendre en 2023 ?'),
(2, 'J ai enfin réparé mon PC tout seul !'),
(2, 'Les meilleures extensions VS Code selon moi.'),
(2, 'Pourquoi j ai choisi Linux comme OS principal.'),
(2, 'Tutoriel: comment créer son propre bot Discord.'),
(2, 'Les certifications IT qui valent vraiment le coup.'),
(2, 'Mon setup de travail idéal pour coder.'),
(2, 'Comparatif entre les derniers smartphones.'),
(2, 'Comment sécuriser ses données en ligne ?'),
(3, 'Nouvelle recette testée aujourd hui, un délice !'),
(3, 'Quel est votre plat préféré à préparer ?'),
(3, 'Je cherche des idées de repas équilibrés pour la semaine.'),
(3, 'Mon gâteau au chocolat est toujours un succès !'),
(3, 'Des bons restaurants végétariens à recommander ?'),
(3, 'J ai découvert une épicerie bio géniale près de chez moi.'),
(3, 'Cuisiner pour ses amis, mon activité préférée.'),
(3, 'Quelqu un a déjà testé les box de cuisine ?'),
(3, 'Mes astuces pour ne pas gaspiller la nourriture.'),
(3, 'Le secret d une bonne pâte à pizza selon moi.'),
(4, 'Séance de sport intense ce matin !'),
(4, 'Comment rester motivé pour faire du sport régulièrement ?'),
(4, 'Mon programme d entraînement de la semaine.'),
(4, 'Les bienfaits du yoga que j ai découverts récemment.'),
(4, 'Quel est votre exercice préféré ?'),
(4, 'Conseils pour bien s étirer après le sport.'),
(4, 'J ai couru mon premier 10km ce week-end !'),
(4, 'Sport en salle ou en extérieur ?'),
(4, 'Mon avis sur les dernières chaussures de running.'),
(4, 'Objectif : 3 séances de sport par semaine.'),
(5, 'Quel objectif photo vous motive en ce moment ?'),
(5, 'Partage de mes dernières photos de paysage.'),
(5, 'Le matériel photo qui a changé ma pratique.'),
(5, 'Photos en noir et blanc vs couleur ?'),
(5, 'Comment améliorer ses portraits ?'),
(5, 'Mon spot photo préféré dans la ville.'),
(5, 'Astuces pour la photo de rue.'),
(5, 'Quel logiciel de retouche utilisez-vous ?'),
(5, 'La meilleure lumière pour photographier selon moi.'),
(5, 'Défi photo : un cliché par jour pendant un mois.'),
(6, 'Dernier livre lu : une vraie pépite !'),
(6, 'Club de lecture du mois prochain : qui participe ?'),
(6, 'Bibliothèque ou librairie ? Où achetez-vous vos livres ?'),
(6, 'Mes 5 auteurs préférés de tous les temps.'),
(6, 'Lecture du soir vs lecture du matin ?'),
(6, 'Roman policier ou science-fiction ?'),
(6, 'Je cherche des recommandations de livres historiques.'),
(6, 'Relire un livre ou toujours découvrir de nouvelles œuvres ?'),
(6, 'Mon coin lecture idéal à la maison.'),
(6, 'Les livres qui m ont marqué cette année.'),
(7, 'Dernier film vu : coup de cœur !'),
(7, 'Quelle est la meilleure série selon vous ?'),
(7, 'Cinéma en salle ou plateformes de streaming ?'),
(7, 'Acteurs/actrices qui méritent plus de reconnaissance.'),
(7, 'Film culte que je n ai toujours pas vu...'),
(7, 'Scène de cinéma la plus mémorable pour moi.'),
(7, 'Festival de Cannes : vos films favoris cette année ?'),
(7, 'Documentaires à ne pas manquer actuellement.'),
(7, 'Le film qui m a fait pleurer comme jamais.'),
(7, 'Marathon ciné prévu ce week-end !'),
(8, 'Nouvel instrument que j apprends : la guitare basse !'),
(8, 'Quel est votre morceau préféré à jouer ?'),
(8, 'Groupes locaux à découvrir absolument.'),
(8, 'Cours de musique en ligne : mon expérience.'),
(8, 'Mes artistes qui m inspirent quotidiennement.'),
(8, 'Concert inoubliable : partagez vos expériences !'),
(8, 'Comment trouver la motivation pour s entraîner ?'),
(8, 'Enregistrement maison vs studio pro ?'),
(8, 'Playlist de travail idéale selon moi.'),
(8, 'Le pouvoir de la musique sur l humeur.'),
(9, 'Premières tomates de mon balcon !'),
(9, 'Comment bien entretenir ses plantes d intérieur ?'),
(9, 'Mon petit potager urbain prend forme.'),
(9, 'Plantes qui résistent à tout (même à moi !)'),
(9, 'Astuces pour économiser l eau au jardin.'),
(9, 'Le compostage en appartement, c est possible !'),
(9, 'Mes outils de jardinage indispensables.'),
(9, 'Quelles fleurs planter pour les abeilles ?'),
(9, 'Problème de parasites sur mes plantes... solutions ?'),
(9, 'Le jardinage comme thérapie.'),
(10, 'Nouvelle astuce pour économiser 50€ par mois !'),
(10, 'Comment gérer son budget alimentation ?'),
(10, 'Les applications qui m aident à économiser.'),
(10, 'Acheter d occasion : mes bonnes affaires.'),
(10, 'Épargne : quelle stratégie adopter ?'),
(10, 'Les pièges à éviter pour les jeunes adultes.'),
(10, 'Comparatif des banques en ligne.'),
(10, 'Investir petit budget : par où commencer ?'),
(10, 'Mes objectifs financiers pour cette année.'),
(10, 'Comment dire non aux dépenses inutiles ?'),
(11, 'Mon voyage en Italie : les incontournables !'),
(11, 'Conseils pour voyager avec un petit budget.'),
(11, 'La valise idéale pour 1 semaine de vacances.'),
(11, 'Rencontres inoubliables lors de mes voyages.'),
(11, 'Faut-il tout planifier ou se laisser porter ?'),
(11, 'Mes pires galères en voyage... et ce que j en ai appris.'),
(11, 'Les applications indispensables pour voyager.'),
(11, 'Voyager seul en tant que femme : mon expérience.'),
(11, 'Destinations hors des sentiers battus à recommander.'),
(11, 'Comment immortaliser ses voyages autrement ?'),
(12, 'Mon nouveau setup geek est enfin au point !'),
(12, 'Les gadgets tech dont je ne peux plus me passer.'),
(12, 'Comparatif : quel smartphone choisir en 2023 ?'),
(12, 'Protéger sa vie privée en ligne : mes outils.'),
(12, 'Les jeux vidéo qui valent le détour cette année.'),
(12, 'Télétravail : comment bien s équiper ?'),
(12, 'Mon avis sur les dernières sorties tech.'),
(12, 'Les réseaux sociaux alternatifs à découvrir.'),
(12, 'Comment j ai automatisé ma maison petit à petit.'),
(12, 'Les formations en ligne pour apprendre la tech.'),
(13, 'Partage de mes dernières créations artistiques !'),
(13, 'Quel est votre médium artistique préféré ?'),
(13, 'Où trouver l inspiration quand on en manque ?'),
(13, 'Dessin digital vs traditionnel : vos préférences ?'),
(13, 'Les artistes locaux à suivre absolument.'),
(13, 'Comment développer son style artistique ?'),
(13, 'Mon processus créatif de A à Z.'),
(13, 'Les erreurs communes quand on débute en art.'),
(13, 'Exposition d art à ne pas manquer ce mois-ci.'),
(13, 'L art comme moyen d expression personnel.'),
(14, 'Mes conseils pour bien démarrer la journée.'),
(14, 'Comment garder une attitude positive au quotidien ?'),
(14, 'Les livres qui ont changé ma vision des choses.'),
(14, 'Méditation : mon expérience après 3 mois.'),
(14, 'Le pouvoir des petites habitudes positives.'),
(14, 'Comment gérer son stress efficacement ?'),
(14, 'Mon rituel du soir pour mieux dormir.'),
(14, 'Les personnes qui m inspirent au quotidien.'),
(14, 'Développement personnel : par où commencer ?'),
(14, 'Prendre du temps pour soi : pourquoi c est essentiel.'),
(15, 'Nouvelle recette healthy testée et approuvée !'),
(15, 'Comment équilibrer travail et vie perso ?'),
(15, 'Mes must-have pour une routine matinale parfaite.'),
(15, 'Les bienfaits du journaling que j ai découverts.'),
(15, 'Conseils pour rester productif sans s épuiser.'),
(15, 'Mon défi sans réseaux sociaux pendant 1 semaine.'),
(15, 'Les podcasts qui m accompagnent quotidiennement.'),
(15, 'Trouver sa passion : comment j ai procédé.'),
(15, 'Les petites joies simples qui changent tout.'),
(15, 'Comment créer des routines qui nous ressemblent ?');


INSERT INTO group_user (group_id, user_id) VALUES
(1, 3), (1, 5), (1, 7), (1, 9),
(2, 2), (2, 4), (2, 6), (2, 8), (2, 10),
(3, 1), (3, 10), (3, 15),
(4, 3), (4, 6), (4, 9), (4, 12), (4, 14),
(5, 4), (5, 7), (5, 8), (5, 11), (5, 13),
(6, 1), (6, 6), (6, 11), (6, 14), (6, 15),
(7, 2), (7, 5), (7, 8), (7, 10), (7, 13),
(8, 3), (8, 7), (8, 9), (8, 12), (8, 15),
(9, 4), (9, 6), (9, 10), (9, 11), (9, 14),
(10, 1), (10, 5), (10, 7), (10, 9), (10, 13);
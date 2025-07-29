-- Création de la base
CREATE DATABASE IF NOT EXISTS social_network;
USE social_network;

-- Table users
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    hash_password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table posts
DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table comments
DROP TABLE IF EXISTS comments;social_networkcomments
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de test
INSERT INTO users (username, hash_password, email) VALUES
('alice', '$2y$10$...', 'alice@example.com'),
('bob', '$2y$10$...', 'bob@example.com'),
('charlie', '$2y$10$...', 'charlie@example.com'),
('david', '$2y$10$...', 'david@example.com'),
('emma', '$2y$10$...', 'emma@example.com'),
('frank', '$2y$10$...', 'frank@example.com'),
('grace', '$2y$10$...', 'grace@example.com'),
('henry', '$2y$10$...', 'henry@example.com');

INSERT INTO posts (user_id, content) VALUES
(1, 'Bonjour à tous !'),
(1, 'Comment ça va ?'),
(2, 'Premier post de Bob !'),
(2, 'Un beau jour d''été'),
(3, 'Mon nouveau projet'),
(4, 'Recette de cuisine du jour'),
(1, 'Mes vacances à la montagne'),
(5, 'Conseils pour apprendre PHP'),
(2, 'Critique de film récent'),
(3, 'Astuces jardinage'),
(1, 'Lecture du moment : Dune'),
(4, 'Nouvelle acquisition tech'),
(5, 'Réflexion sur l''IA');


INSERT INTO comments (post_id, user_id, content) VALUES
(1, 2, 'Salut Alice !'),
(1, 3, 'Bienvenue sur le réseau'),
(2, 2, 'Ça va et toi ?'),
(3, 1, 'Bienvenue Bob !'),
(2, 3, 'Très intéressant !'),
(4, 2, 'Magnifiques photos'),
(5, 1, 'Merci pour ces conseils'),
(3, 5, 'J''essaierai cette recette'),
(1, 4, 'Tout à fait d''accord'),
(6, 1, 'Je l''ai vu aussi, génial !'),
(7, 2, 'Ça marche vraiment ?'),
(8, 3, 'Un classique !'),
(9, 4, 'Quel modèle exactement ?'),
(10, 5, 'L''IA va tout changer'),
(4, 3, 'Quelle station ?'),
(5, 4, 'PHP 8.3 est sorti'),
(2, 1, 'Continue comme ça !'),
(7, 5, 'Testé et approuvé'),
(9, 2, 'J''hésite à acheter le même');

-- Index pour les performances
CREATE INDEX idx_posts_user ON posts(user_id);
CREATE INDEX idx_comments_post ON comments(post_id);
CREATE INDEX idx_comments_user ON comments(user_id);
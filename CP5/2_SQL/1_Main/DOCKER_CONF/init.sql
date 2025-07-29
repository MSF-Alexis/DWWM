-- Création de la base de données
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des produits
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des commandes
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des lignes de commande
CREATE TABLE IF NOT EXISTS order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des données initiales

-- Utilisateurs
INSERT INTO users (username, email, password_hash) VALUES
('jdupont', 'jean.dupont@example.com', '$2y$10$N7B7eG5JvW1eLq1kQ9Zr0uJf7KQZJ9Xl3dYb6WYc5RvJ1XrV2YhL6'), -- motdepasse123
('mleclerc', 'marie.leclerc@example.com', '$2y$10$V/Ka5YJvW1eLq1kQ9Zr0uJf7KQZJ9Xl3dYb6WYc5RvJ1XrV2YhL6'), -- securepass456
('admin', 'admin@boutique.com', '$2y$10$XcR7eG5JvW1eLq1kQ9Zr0uJf7KQZJ9Xl3dYb6WYc5RvJ1XrV2YhL6'); -- admin123

-- Produits
INSERT INTO products (name, description, price, stock_quantity) VALUES
('Smartphone X', 'Écran 6.5", 128GB, Double caméra', 699.99, 50),
('Casque Audio Pro', 'Réduction de bruit, Bluetooth', 249.99, 30),
('Montre Connectée', 'Suivi santé, étanche 50m', 179.50, 25),
('Chargeur Sans Fil', 'Charge rapide 15W', 39.99, 100),
('Écran 27" 4K', 'Rétroéclairage LED, HDMI/DP', 329.00, 15);

-- Commandes
INSERT INTO orders (user_id, total_amount, status) VALUES
(1, 949.98, 'delivered'),
(2, 429.49, 'shipped'),
(1, 179.50, 'pending');

-- Lignes de commande
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 699.99), -- Commande 1: 1 smartphone
(1, 2, 1, 249.99), -- Commande 1: + 1 casque
(2, 3, 2, 179.50), -- Commande 2: 2 montres
(3, 3, 1, 179.50); -- Commande 3: 1 montre
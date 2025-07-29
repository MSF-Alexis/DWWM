-- === COUNT ===
-- Compte le nombre d'utilisateurs total dans la bdd
SELECT COUNT(*) FROM users;

-- Compte le nombre d'utilisateurs non banni
SELECT COUNT(*) FROM users WHERE is_banned = FALSE;

-- === SUM ===

-- SUM permet de faire la somme de l'âge de tous les utilisateurs de la BDD
SELECT SUM(age) FROM users;

-- Si on utilise la fonction COUNT vu précédemment on peut calculer l'âge moyen de nos utilisateurs
SELECT SUM(age)/COUNT(id) FROM users;

-- === AVG ===
SELECT AVG(age) FROM users;

-- === MIN, MAX === 
SELECT MIN(age), MAX(age) FROM users;

-- === GROUP BY ===
-- Calcule le nombre de post par utilisateur
SELECT user_id, COUNT(*) FROM posts GROUP BY user_id;

SELECT user_id, COUNT(*) FROM group_user GROUP BY user_id;
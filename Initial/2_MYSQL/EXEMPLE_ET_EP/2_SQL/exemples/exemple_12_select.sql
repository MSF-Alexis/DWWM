-- Toutes les colonnes de toutes les données
SELECT * FROM users; 

-- On veut le user name et l'email de chaque utilisateurs
SELECT username, email FROM users;

-- On veut l'id, le user name et la date de création de chaque utilisateurs
SELECT id, username, created_at FROM users;

-- On veut l'id, le username et la date de création de l'utilisateur qui a un username égale à 'miguel'
SELECT id, username, created_at FROM users WHERE username = 'miguel';

-- On veut l'id, le username et la date de création de l'utilisateur qui a l'id 3
SELECT id, username, created_at FROM users WHERE id = 3;

-- On récupère :
--  - id
--  - le username
--  - le mail
--  - la date de création du compte
--  - l'état de son banissement
-- des utilisateurs bannis
SELECT id, username, email, created_at, is_banned FROM users WHERE is_banned != FALSE;

-- On récupère : 
--  - id
--  - le username
--  - l'âge
--  - la date de création du compte
-- des utilisateurs âgés d'au moins 21 ans.
SELECT id, username, age, created_at FROM users WHERE age > 20;

-- On récupère :
-- - id
-- - le username
-- - l'âge
-- - la date de création du compte 
-- des utilisateurs mineures
SELECT id, username, age, created_at FROM users WHERE age < 18;


-- On récupère :
-- - id
-- - le username
-- - l'email
-- - la date de création du compte
-- des utilisateurs dont l'email commence par un a
SELECT id, username, email, created_at FROM users WHERE email LIKE 'a%';
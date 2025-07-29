-- On récupère tout
-- Des utilisateurs bannis et âgés d'au moins 18 ans
SELECT * FROM users WHERE is_banned = FALSE AND age > 17;

-- On récupère tout
-- Des utilisateurs majeurs, non bannis, avec un compte créé il y a au moins 3 mois.
SELECT * FROM users WHERE age > 17 AND is_banned = FALSE AND created_at < DATE_SUB(NOW(), INTERVAL 3 MONTH);
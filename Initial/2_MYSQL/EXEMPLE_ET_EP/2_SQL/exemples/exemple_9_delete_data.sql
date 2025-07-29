-- Cas n°1 : Dangereux
DELETE FROM users;

-- Cas n°2 : Mieux , mais génère toujours une erreur, pourquoi ?
DELETE FROM users 
WHERE email = 'mireille-danse@msn.fr';


-- Cas n°3 : Encore mieux, car on cible par identifiant mais toujours une potentielle erreur.
DELETE FROM users
WHERE id = 42;

-- Cas n°4 : 
-- Explication LIKE permet d'itentifier un schéma de texte
-- conséquence on va supprimer tout les user avec un email finissant par @msn.fr
DELETE FROM users
WHERE email LIKE '%@msn.fr';


-- Cas concret de suppression
-- On supprime tout les utilisateurs qui n'ont pas modifié leurs profil depuis un an au moins
DELETE FROM users
WHERE users.updated_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);



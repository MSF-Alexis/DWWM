-- Supprime tout les posts rédigés par l'utilisateur id = 4
DELETE FROM posts WHERE user_id = 4;
-- Enlève l'utilisateur id =  4 de chaque groupe auquel il s'était inscrit
DELETE FROM group_post WHERE user_id = 4;
-- Suppression de l'utilisateur id = 4
DELETE FROM users WHERE id = 4;



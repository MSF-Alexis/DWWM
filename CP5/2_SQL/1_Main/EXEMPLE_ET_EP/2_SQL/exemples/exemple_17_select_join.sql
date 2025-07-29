-- Chaque ligne de résultat affichera 
-- - le username
-- - la date de publication du post
-- - le contenu du post
SELECT users.username, posts.created_at, posts.content
 FROM users
 INNER JOIN posts ON posts.user_id = users.id;

-- Chaque ligne de résultat affichera 
-- - le username
-- - la date de publication du post (potentiellement NULL)
-- - le contenu du post (pontiellement NULL)
SELECT users.username, posts.created_at, posts.content
 FROM users
 LEFT JOIN posts ON posts.user_id = users.id;

-- Chaque ligne de résultat affichera
-- - le username
-- - le nom du groupe rejoint par l'utilisateur
SELECT users.username, groups.name FROM users
INNER JOIN group_user ON users.id = group_user.user_id
INNER JOIN groups ON groups.id = group_user.group_id;
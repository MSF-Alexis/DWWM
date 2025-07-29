-- On récupère tout
-- Des posts dont le contenu possède la chaîne de caractères jeu ou dont le contenu possède la chaîne de caractères mario.
SELECT * FROM posts WHERE content LIKE '%jeu%' OR content LIKE '%mario%';
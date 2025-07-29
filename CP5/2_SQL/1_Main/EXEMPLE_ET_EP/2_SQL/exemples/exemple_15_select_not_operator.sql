-- On récupère tout
-- Des utilisateurs dont le username contient un a
SELECT * FROM users WHERE username LIKE '%a%';

-- On récupère tout
-- Des utilisateurs dont le username ne contient pas un a
SELECT * FROM users WHERE NOT username LIKE '%a%';



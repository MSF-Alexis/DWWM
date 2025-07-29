-- Cas n°1 :  Que se passe t'il ici ? 
UPDATE users SET email = 'exemple-casse-modification@exemple.org';
-- Cas n°2 : Bien
UPDATE users SET email = 'super-exemple@modification.fr' WHERE id = 1;
-- Cas n°3 : Mieux
UPDATE users SET email = 'encore-meilleur@modif-exemple.com', updated_at = CURRENT_TIMESTAMP WHERE id = 2;

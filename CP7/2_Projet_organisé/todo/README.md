# Projet To-Do List (structure minimale)

## Installation
1. Importer `data/schema.sql` dans MySQL.
2. Vérifier les identifiants dans `config/db.php`.
3. Lancer : `php -S localhost:8000 -t public`.

## Structure
- `public/` : interface et contrôleur.
- `includes/` : logique métier (CRUD).
- `config/` : connexion PDO.
- `data/` : scripts SQL.

## Base pédagogique
Chaque donnée suit le funnel **Récupération → Sanitizing → Validation → DB** avant stockage.

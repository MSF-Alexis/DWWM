# Règles passage ERD => MPD 


### 🔹 Étape 1 : De l'ERD au MCD (Modèle Conceptuel de Données)

1. **Entités → Concepts métier**
Chaque entité de l'ERD devient une **entité-concept** dans le MCD, représentant un objet métier clé (ex: `Client`, `Commande`)[^5].
2. **Attributs → Propriétés descriptives**
Les caractéristiques des entités deviennent des **attributs** dans le MCD (ex: `Nom_Client`, `Date_Commande`)[^5][^4].
3. **Relations → Associations sémantiques**
Les liens entre entités sont formalisés en **relations** avec cardinalités (ex: `1-N`, `N-N`). Chaque relation porte un verbe explicite (ex: "Passer" entre `Client` et `Commande`)[^6][^5].

---

### 🔹 Étape 2 : Du MCD au MLD (Modèle Logique de Données)

4. **Entités → Tables**
Chaque entité du MCD génère une **table** dans le MLD. Son identifiant devient **clé primaire** (PK)[^1][^4].
5. **Relations 1-N → Clés étrangères**
Pour une relation `1-N`, la PK de l'entité côté `N` devient **clé étrangère** (FK) dans la table côté `1`[^1].
*Exemple* : Une relation `Département (1) - Employé (N)` ajoute `ID_Département` (FK) dans la table `Employé`.
6. **Relations N-N → Tables d'association**
Une relation `N-N` crée une **nouvelle table** avec :
    - Les PK des deux entités comme FK
    - Les attributs de la relation
    - Une PK composée des deux FK[^1][^4].
7. **Relations 0.1-N → FK nullable**
Si la cardinalité minimale est `0`, la FK est **nullable** (non obligatoire)[^1].
8. **Héritage → Tables liées**
Une spécialisation (ex: `Personne → Employé`) génère :
    - Une table pour l'entité générique (`Personne`)
    - Des tables pour les sous-entités (`Employé`), liées par FK à la table générique[^1].

---

### 🔹 Étape 3 : Du MLD au MPD (Modèle Physique de Données)

9. **Adaptation au SGBD cible**
Chaque table du MLD est implémentée avec :
    - Des **types de données spécifiques** (ex: `VARCHAR(50)` au lieu de "texte")[^4].
    - Des **contraintes techniques** (NOT NULL, UNIQUE, CHECK)[^2][^4].
10. **Optimisation des performances**
Ajout d'**index** sur les colonnes fréquemment interrogées et définition de **stratégies de stockage** (partitionnement, compression)[^3][^4].
11. **Gestion des dépendances**
Création explicite des **clés étrangères** avec règles de `ON DELETE/UPDATE` (CASCADE, SET NULL)[^2][^4].
12. **Intégration des spécificités SGBD**
Utilisation de fonctionnalités avancées du SGBD (ex: moteurs de stockage dans MySQL, schémas dans PostgreSQL)[^3][^4].

---

### 🔹 Récapitulatif des transformations

| Étape | Entrée | Sortie | Règles clés |
| :-- | :-- | :-- | :-- |
| **ERD → MCD** | Entités/Relations | Concepts métier | Extraction sémantique des objets et liens[^5] |
| **MCD → MLD** | Concepts | Tables/Relations | Règles 4 à 8 (création de tables, FK, gestion des cardinalités)[^1][^4] |
| **MLD → MPD** | Tables logiques | Schéma physique | Règles 9 à 12 (optimisation SGBD, index, contraintes techniques)[^2][^3][^4] |

> **Note méthodologique** : Ce processus assure une traçabilité complète des objets métier jusqu'à l'implémentation technique, tout en découplant les préoccupations métier (MCD) des contraintes d'implémentation (MPD)[^2][^4]. Les outils comme SAP PowerDesigner ou IS Designer automatisent ces transformations via des opérations de "scaffolding"[^6][^3].

<div style="text-align: center">⁂</div>

[^1]: https://www.9raytifclick.com/cours/merise-mld/

[^2]: https://www.smartmodel.ch/home/comment/MLDR-MPDR

[^3]: https://www.urbanisation-si.com/vous-cherchez-des-outils-pour-gerer-le-mapping-entre-les-objets-metiers-et-une-base-de-donnees-relationnelle-generer-les-scripts-sql-et-produire-du-code-a-partir-de-vos-modeles-metiers-obeo-isd-s1-ep5

[^4]: https://www.solidpepper.com/blog/modele-physique-de-donnees-mpd-definition-enjeux-exemple

[^5]: https://www.cartelis.com/data-engineering/modele-conceptuel-de-donnees-mcd-definition-fonctionnement/

[^6]: https://help.sap.com/docs/SAP_POWERDESIGNER/856348b84a7c479489d5172a630f014d/c7c33cbe6e1b101487c2bf53c936d24f.html?locale=fr-FR

[^7]: https://help.sap.com/doc/0bd76ef18ee64301a040f58ee25aa511/16.6.1/fr-FR/modelisation_donnees.pdf

[^8]: http://bliaudet.free.fr/IMG/pdf/modelisation-BDR-P2-relation-un-plusieurs.pdf

[^9]: https://www.youtube.com/watch?v=gLCk3V09U6w

[^10]: https://provencher.csscotesud.gouv.qc.ca/wp-content/uploads/sites/8/2024/10/Normes-regles-de-passage-24-25.pdf


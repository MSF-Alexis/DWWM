# Exercices - Contraintes SQL
## FOREIGN KEY

### Objectif
==Comprendre l'utilisation de FOREIGN KEY==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de gestion de bibliothèque|[👉](#1.1)|
|1.2|Plateforme e-learning|[👉](#1.2)|
|1.3|Application de gestion de projets|[👉](#1.3)|
|1.4|Système de facturation|[👉](#1.4)|
|1.5|Gestion hospitalière|[👉](#1.5)|
|1.6|Plateforme de réservation de voyages|[👉](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** Créez deux tables liées pour une bibliothèque :

**Table auteurs :**
|Nom|Type|
|---|----|
|id|int (PRIMARY KEY)|
|nom|varchar|
|prenom|varchar|
|nationalite|varchar|

**Table livres :**
|Nom|Type|
|---|----|
|id|int (PRIMARY KEY)|
|titre|varchar|
|isbn|varchar|
|auteur_id|int|
|annee_publication|int|

> **b.** Ajouter une contrainte FOREIGN KEY pour lier auteur_id dans la table livres vers la table auteurs.
> **c.** Testez votre script SQL.
> **Bonus** : Que se passe-t-il si on fait cela ?
```sql
INSERT INTO livres (id, titre, isbn, auteur_id, annee_publication) 
VALUES (1, 'Le Mystère', '978-123456789', 999, 2023);
```
---
<a id="1.2"></a>

### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre plateforme e-learning doit organiser les cours par catégories. Chaque cours appartient obligatoirement à une catégorie existante (Développement, Marketing, Design, etc.). Nous devons pouvoir lister tous les cours d'une catégorie et empêcher qu'un cours soit assigné à une catégorie inexistante.*

**Tables nécessaires :** categories (id, nom, description) et cours (id, titre, duree, prix, categorie_id)

> **b.** Modifier votre script de création de tables pour y ajouter la contrainte FOREIGN KEY appropriée.
> **c.** Testez votre script SQL.

>**Question de réflexion** : Pourquoi utiliser FOREIGN KEY plutôt que simplement stocker le nom de la catégorie dans la table cours ? Quels avantages apporte cette approche relationnelle ?
---
<a id="1.3"></a>

### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre outil de gestion de projets doit associer chaque tâche à un projet existant et à un employé responsable. Il est impératif qu'une tâche ne puisse pas être créée sans projet parent, ni assignée à un employé qui n'existe pas dans notre base.*

**Tables nécessaires :** projets (id, nom, budget), employes (id, nom, email), taches (id, nom, description, projet_id, employe_id, statut)

> **b.** Modifier votre script de création de tables pour y ajouter les contraintes FOREIGN KEY appropriées.
> **c.** Testez votre script SQL.
---
<a id="1.4"></a>

### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de tables ci-dessous, générer un script d'édition SQL qui altère la table pour y ajouter une contrainte FOREIGN KEY :

**Contexte :** *"Dans notre système de facturation, chaque facture doit obligatoirement être liée à un client existant. Nous devons empêcher la création de factures pour des clients inexistants."*

```sql
CREATE TABLE clients (
    id INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20)
);

CREATE TABLE factures (
    id INT PRIMARY KEY,
    numero_facture VARCHAR(20) NOT NULL,
    client_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_emission DATE NOT NULL,
    statut VARCHAR(20) DEFAULT 'EN_ATTENTE'
);
```
> **b.** Testez votre script SQL.
---
<a id="1.5"></a>

### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de tables ci-dessous, générer un script d'édition SQL qui altère la table pour y ajouter une contrainte FOREIGN KEY :

**Contexte :** *"Dans notre système hospitalier, chaque consultation doit être rattachée à un médecin et un patient existants. L'intégrité référentielle est cruciale pour le suivi médical et la traçabilité des soins."*

```sql
CREATE TABLE medecins (
    id INT PRIMARY KEY,
    nom VARCHAR(80) NOT NULL,
    specialite VARCHAR(50) NOT NULL,
    numero_ordre VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE patients (
    id INT PRIMARY KEY,
    nom VARCHAR(80) NOT NULL,
    prenom VARCHAR(80) NOT NULL,
    numero_securite_sociale VARCHAR(15) NOT NULL UNIQUE,
    date_naissance DATE NOT NULL
);

CREATE TABLE consultations (
    id INT PRIMARY KEY,
    medecin_id INT NOT NULL,
    patient_id INT NOT NULL,
    date_consultation DATETIME NOT NULL,
    motif TEXT,
    diagnostic TEXT
);
```
> **b.** Testez votre script SQL.
---
<a id="1.6"></a>

### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de tables ci-dessous, générer un script d'édition SQL qui altère la table pour y ajouter des contraintes FOREIGN KEY :

**Contexte :** *"Notre plateforme de réservation de voyages doit s'assurer que chaque réservation est liée à un client existant et à un vol disponible. La cohérence des données est essentielle pour éviter les erreurs de réservation."*

CRM :
: Customer Relationship Management - Système de gestion de la relation client utilisé pour centraliser les informations clients.

```sql
CREATE TABLE clients_voyage (
    id INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    passeport VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE vols (
    id INT PRIMARY KEY,
    numero_vol VARCHAR(10) NOT NULL UNIQUE,
    destination VARCHAR(100) NOT NULL,
    date_depart DATETIME NOT NULL,
    prix DECIMAL(8,2) NOT NULL
);

CREATE TABLE reservations_voyage (
    id INT PRIMARY KEY,
    client_id INT NOT NULL,
    vol_id INT NOT NULL,
    date_reservation DATETIME DEFAULT NOW(),
    statut VARCHAR(20) DEFAULT 'CONFIRMEE',
    siege VARCHAR(5)
);
```
> **b.** Testez votre script SQL.

> **Question bonus** : Dans le contexte des réservations de voyage, que se passerait-il si on supprimait un vol ayant des réservations associées ? Comment pourrait-on gérer cette situation avec les options ON DELETE ?
# Exercices - Contraintes SQL
## UNIQUE

### Objectif
==Comprendre l'utilisation de UNIQUE==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de gestion d'employés|[👉](#1.1)|
|1.2|Plateforme de réservation d'événements|[👉](#1.2)|
|1.3|Gestion d'inventaire d'une librairie|[👉](#1.3)|
|1.4|Système de billetterie de cinéma|[👉](#1.4)|
|1.5|Application de réseaux sociaux|[👉](#1.5)|
|1.6|Base de données véhicules|[👉](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** Créez une table employés avec les attributs suivants :

|Nom|Type|
|---|----|
|id|int|
|nom|varchar|
|prenom|varchar|
|email|varchar|
|numero_badge|varchar|

> **b.** Ajouter une contrainte UNIQUE sur l'attribut email (chaque employé doit avoir un email unique).
> **c.** Testez votre script SQL.
> **Bonus** : Que se passe-t-il si on fait cela ?
```sql
INSERT INTO employes (id, nom, prenom, email, numero_badge) 
VALUES (1, 'Dupont', 'Jean', 'jean.dupont@entreprise.com', 'EMP001');
INSERT INTO employes (id, nom, prenom, email, numero_badge) 
VALUES (2, 'Martin', 'Marie', 'jean.dupont@entreprise.com', 'EMP002');
```
---
<a id="1.2"></a>

### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Je gère une plateforme de réservation d'événements. Chaque événement doit avoir un code unique pour éviter les confusions lors des réservations. J'ai besoin de stocker : un identifiant, le nom de l'événement, le code événement, la date, et le lieu.*

> **b.** Modifier votre script de création de table pour y ajouter la contrainte UNIQUE appropriée.
> **c.** Testez votre script SQL.

>**Question de réflexion** : Pourquoi utiliser un code événement unique plutôt que simplement l'identifiant ? Quels avantages cela apporte-t-il ?
---
<a id="1.3"></a>

### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Pour ma librairie, je dois gérer un inventaire où chaque livre est identifié par son ISBN. Même si j'ai plusieurs exemplaires du même livre, l'ISBN doit rester unique dans ma base. Je stocke : identifiant, titre, auteur, ISBN, prix, stock disponible.*

> **b.** Modifier votre script de création de table pour y ajouter la contrainte UNIQUE appropriée.
> **c.** Testez votre script SQL.
---
<a id="1.4"></a>

### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une contrainte UNIQUE :

**Contexte :** *"Dans notre cinéma, chaque séance doit avoir un numéro de billet unique pour éviter les doubles réservations. Le numéro de billet suit un format spécifique (ex: CINE-2024-001)."*

```sql
CREATE TABLE seances (
    id INT PRIMARY KEY,
    film VARCHAR(255) NOT NULL,
    salle VARCHAR(10) NOT NULL,
    heure_debut TIME NOT NULL,
    numero_billet VARCHAR(20) NOT NULL
);
```
> **b.** Testez votre script SQL.
---
<a id="1.5"></a>

### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une contrainte UNIQUE :

**Contexte :** *"Sur notre plateforme sociale, chaque utilisateur doit avoir un nom d'utilisateur unique. Deux personnes ne peuvent pas avoir le même nom d'utilisateur même si leurs autres informations diffèrent."*

```sql
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL,
    nom_complet VARCHAR(100) NOT NULL,
    date_inscription DATE NOT NULL,
    bio TEXT
);
```
> **b.** Testez votre script SQL.
---
<a id="1.6"></a>

### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une contrainte UNIQUE :

**Contexte :** *"Dans notre base de données de véhicules, chaque voiture doit avoir une plaque d'immatriculation unique. Il est impossible d'avoir deux véhicules avec la même plaque dans notre système."*

VIN :
: Vehicle Identification Number - Numéro d'identification unique attribué à chaque véhicule automobile lors de sa fabrication.

```sql
CREATE TABLE vehicules (
    id INT PRIMARY KEY,
    marque VARCHAR(50) NOT NULL,
    modele VARCHAR(50) NOT NULL,
    plaque_immatriculation VARCHAR(15) NOT NULL,
    vin VARCHAR(17) NOT NULL,
    annee INT
);
```
> **b.** Testez votre script SQL.

> **Question bonus** : Dans ce cas, quels sont les deux champs qui pourraient avoir une contrainte UNIQUE ? Justifiez votre réponse.
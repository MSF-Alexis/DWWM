# Exercices - Contraintes SQL
## DEFAULT

### Objectif
==Comprendre l'utilisation de DEFAULT==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de commandes e-commerce|[👉](#1.1)|
|1.2|Gestion de comptes bancaires|[👉](#1.2)|
|1.3|Plateforme de gestion de tickets support|[👉](#1.3)|
|1.4|Application de réservation hôtelière|[👉](#1.4)|
|1.5|Système de gestion d'inventaire|[👉](#1.5)|
|1.6|Base de données de formations|[👉](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** Créez une table commandes avec les attributs suivants :

|Nom|Type|
|---|----|
|id|int|
|numero_commande|varchar|
|client_id|int|
|statut|varchar|
|date_creation|datetime|
|montant_total|decimal|

> **b.** Ajouter des contraintes DEFAULT appropriées : le statut doit être "EN_ATTENTE" par défaut et la date_creation doit être la date/heure actuelle.
> **c.** Testez votre script SQL.
> **Bonus** : Que se passe-t-il si on fait cela ?
```sql
INSERT INTO commandes (numero_commande, client_id, montant_total) 
VALUES ('CMD001', 123, 89.99);
SELECT * FROM commandes;
```
---
<a id="1.2"></a>

### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre banque souhaite automatiser l'ouverture de comptes. Chaque nouveau compte doit démarrer avec un solde de 0€, être actif par défaut, et avoir une date d'ouverture automatiquement renseignée. Les informations nécessaires sont : identifiant, numéro de compte, nom du titulaire, solde, statut du compte, date d'ouverture.*

> **b.** Modifier votre script de création de table pour y ajouter les contraintes DEFAULT appropriées.
> **c.** Testez votre script SQL.

>**Question de réflexion** : Pourquoi utiliser DEFAULT plutôt que de forcer la saisie manuelle de ces valeurs ? Quels avantages cela apporte-t-il en termes d'intégrité des données ?
---
<a id="1.3"></a>

### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre service support doit traiter des tickets clients. Chaque nouveau ticket doit automatiquement avoir la priorité "NORMALE", le statut "OUVERT", et être horodaté au moment de sa création. Je stocke : identifiant, titre du ticket, description, priorité, statut, date de création, assigné à.*

> **b.** Modifier votre script de création de table pour y ajouter les contraintes DEFAULT appropriées.
> **c.** Testez votre script SQL.
---
<a id="1.4"></a>

### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes DEFAULT :

**Contexte :** *"Dans notre hôtel, chaque réservation doit automatiquement avoir le statut 'CONFIRMEE' et le nombre d'adultes par défaut à 1 si non précisé. La date de réservation doit être automatiquement renseignée."*

```sql
CREATE TABLE reservations (
    id INT PRIMARY KEY,
    nom_client VARCHAR(100) NOT NULL,
    numero_chambre VARCHAR(10) NOT NULL,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    nombre_adultes INT,
    statut VARCHAR(20),
    date_reservation DATETIME
);
```
> **b.** Testez votre script SQL.
---
<a id="1.5"></a>

### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes DEFAULT :

**Contexte :** *"Dans notre gestion d'inventaire, tout nouveau produit doit avoir un stock minimum de 0, être disponible par défaut, et avoir sa date d'ajout automatiquement renseignée au moment de l'insertion."*

```sql
CREATE TABLE produits (
    id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    reference VARCHAR(50) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock_actuel INT,
    disponible BOOLEAN,
    date_ajout DATETIME
);
```
> **b.** Testez votre script SQL.
---
<a id="1.6"></a>

### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes DEFAULT :

**Contexte :** *"Notre centre de formation enregistre les inscriptions. Chaque participant doit avoir un statut 'INSCRIT' par défaut, être marqué comme actif, et avoir sa date d'inscription automatiquement renseignée. Le niveau de satisfaction démarre à 0."*

LMS :
: Learning Management System - Système de gestion de l'apprentissage utilisé pour organiser et suivre les formations.

```sql
CREATE TABLE participants (
    id INT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    formation_id INT NOT NULL,
    statut_inscription VARCHAR(20),
    actif BOOLEAN,
    date_inscription DATETIME,
    niveau_satisfaction INT
);
```
> **b.** Testez votre script SQL.

> **Question bonus** : Dans quels cas les valeurs DEFAULT peuvent-elles poser des problèmes ? Comment s'assurer que les valeurs par défaut restent cohérentes avec l'évolution métier ?
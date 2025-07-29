# Exercices - Contraintes SQL
## CHECK

### Objectif
==Comprendre l'utilisation de CHECK==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de gestion des employés|[👉](#1.1)|
|1.2|Plateforme de vente en ligne|[👉](#1.2)|
|1.3|Application de réservation de salles|[👉](#1.3)|
|1.4|Système de notation étudiante|[👉](#1.4)|
|1.5|Gestion de comptes clients|[👉](#1.5)|
|1.6|Base de données médicale|[👉](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** Créez une table employes avec les attributs suivants :

|Nom|Type|
|---|----|
|id|int|
|nom|varchar|
|prenom|varchar|
|age|int|
|salaire|decimal|
|departement|varchar|

> **b.** Ajouter des contraintes CHECK pour valider que l'âge est compris entre 16 et 70 ans, et que le salaire est supérieur à 0.
> **c.** Testez votre script SQL.
> **Bonus** : Que se passe-t-il si on fait cela ?
```sql
INSERT INTO employes (id, nom, prenom, age, salaire, departement) 
VALUES (1, 'Dupont', 'Jean', 15, 2500.00, 'IT');
INSERT INTO employes (id, nom, prenom, age, salaire, departement) 
VALUES (2, 'Martin', 'Sophie', 35, -1000.00, 'RH');
```
---
<a id="1.2"></a>

### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre boutique en ligne doit s'assurer que les produits ont des données cohérentes. Le prix doit être positif, la quantité en stock ne peut pas être négative, et la note moyenne des avis doit être comprise entre 1 et 5. Les informations stockées sont : identifiant, nom du produit, prix, stock, note moyenne.*

> **b.** Modifier votre script de création de table pour y ajouter les contraintes CHECK appropriées.
> **c.** Testez votre script SQL.

>**Question de réflexion** : Pourquoi est-il important de valider ces données au niveau de la base de données plutôt que seulement dans l'application ? Quels risques cela évite-t-il ?
---
<a id="1.3"></a>

### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre système de réservation de salles doit garantir que les créneaux horaires sont valides. Les heures de début et fin doivent être comprises entre 8h et 22h. La capacité maximale de la salle ne peut pas dépasser 500 personnes. Je stocke : identifiant, nom de la salle, heure_debut, heure_fin, capacite_max.*

> **b.** Modifier votre script de création de table pour y ajouter les contraintes CHECK appropriées.
> **c.** Testez votre script SQL.
---
<a id="1.4"></a>

### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes CHECK :

**Contexte :** *"Dans notre système de notation, les notes doivent être comprises entre 0 et 20, et le coefficient doit être positif et ne pas dépasser 5. Nous devons garantir l'intégrité de ces données académiques."*

```sql
CREATE TABLE notes (
    id INT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    matiere VARCHAR(50) NOT NULL,
    note DECIMAL(4,2),
    coefficient INT,
    date_evaluation DATE NOT NULL
);
```
> **b.** Testez votre script SQL.
---
<a id="1.5"></a>

### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes CHECK :

**Contexte :** *"Pour nos comptes clients, le solde ne peut pas être inférieur à -5000€ (découvert autorisé limité), et le taux d'intérêt doit être compris entre 0% et 15%. Ces limites sont imposées par notre politique commerciale."*

```sql
CREATE TABLE comptes_clients (
    id INT PRIMARY KEY,
    numero_compte VARCHAR(20) NOT NULL,
    nom_titulaire VARCHAR(100) NOT NULL,
    solde DECIMAL(12,2),
    taux_interet DECIMAL(5,2),
    date_ouverture DATE NOT NULL
);
```
> **b.** Testez votre script SQL.
---
<a id="1.6"></a>

### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter des contraintes CHECK :

**Contexte :** *"Dans notre base médicale, la tension artérielle systolique doit être comprise entre 80 et 250 mmHg, la tension diastolique entre 50 et 150 mmHg, et la fréquence cardiaque entre 40 et 200 bpm. Ces valeurs correspondent aux limites physiologiques acceptables."*

IMC :
: Indice de Masse Corporelle - Mesure permettant d'estimer la corpulence d'une personne en fonction de sa taille et de son poids.

```sql
CREATE TABLE donnees_medicales (
    id INT PRIMARY KEY,
    patient_id INT NOT NULL,
    tension_systolique INT,
    tension_diastolique INT,
    frequence_cardiaque INT,
    poids DECIMAL(5,2),
    date_mesure DATE NOT NULL
);
```
> **b.** Testez votre script SQL.

> **Question bonus** : Dans le contexte médical, quelles pourraient être les conséquences d'une donnée erronée non détectée par les contraintes CHECK ? Comment équilibrer validation stricte et flexibilité opérationnelle ?
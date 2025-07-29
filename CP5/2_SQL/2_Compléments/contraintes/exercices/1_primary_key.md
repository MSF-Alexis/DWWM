# Exercices - Contraintes SQL
## PRIMARY KEY

### Objectif
==Commprendre l'utilisation de PRIMARY KEY==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Création d'une table utilisateurs standard|[👉](#1.1)|
|1.2|Création d'un projet club tenis de table|[👉](#1.2)|
|1.3|Gestionnaire de places de parking|[👉](#1.3)|
|1.4|Création d'une table des régions de France|[👉](#1.4)|
|1.5|E-boutique|[👉](#1.5)|
|1.6|Création de table films|[👉](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** Créez une table utilisateurs avec les attributs suivants :

|Nom|Type|
|---|----|
|id|int|
|username|varchar|
|email|varchar|
|password|varchar|

> **b.** Ajouter une contrainte PRIMARY KEY (ou clé primaire) sur l'attribut concerné.
> **c.** Testez votre script SQL.
> **Bonus** : Que se passe-t-il si on fait cela ?
```sql
INSERT INTO utilisateurs (id, username, email, password) 
VALUES (1, 'john', 'john@email.com', 'pass123');
INSERT INTO utilisateurs (id, username, email, password) 
VALUES (1, 'jane', 'jane@email.com', 'pass456');
```
---
<a id="1.2"></a>


### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*J'ai un site pour mon club de tennis de table, j'aimerais y renseigner mes adhérents, pour chaque adhérent j'aimerais avoir les informations suivantes : numéro de license, nom, prenom, numéro de téléphone, date du dernier paiement.*

> **b.** Modifier votre script de création de table pour y ajouter la contrainte de clé primaire.
> **c.** Testez votre script SQL.

>**Question de réflexion** : Que se passe-t-il si un adhérent change de numéro de licence ? Le numéro de licence est-il vraiment l'identifiant le plus approprié ?
---
<a id="1.3"></a>


### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*J'ai besoin d'un site qui va gérer mes locations de places de parking, chaque place doit possèder un identifiant en text (ex : A-03), un élément qui indique si la place est louée ou non, l'adresse de la place.*

> **b.** Modifier votre script de création de table pour y ajouter la contrainte de clé primaire.
> **c.** Testez votre script SQL.
---
<a id="1.4"></a>


### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une clé primaire :
> **==Traduction== : surface_area → superficie (km²)**

```sql
CREATE TABLE regions (
    region_number INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    surface_area INT,
);
```
> **b.** Testez votre script SQL.
---
<a id="1.5"></a>


### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une clé primaire :
> **Traduction :**
> - ==products → produits==
> - ==price → prix==
> - ==weight → poids==

```sql
CREATE TABLE products (
    name VARCHAR(255) NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    weight DECIMAL(6, 2) NOT NULL,
    reference VARCHAR(127) NOT NULL,
);
```
> **b.** Testez votre script SQL.
---
<a id="1.6"></a>


### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter une clé primaire :
> **Traduction :**
> - ==movies → films==

EIDR :
: The Entertainment Identifier Registry, or EIDR, is a global unique identifier system for a broad array of audiovisual objects, including motion pictures, television, and radio programs. [^1]


```sql
CREATE TABLE movies (
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255),
    eidr VARCHAR(255) NOT NULL,
);
```
> **b.** Testez votre script SQL.

[^1]: https://en.wikipedia.org/wiki/EIDR
# Exercices - Contraintes SQL
## NOT NULL

### Objectif
==Commprendre l'utilisation de NOT NULL==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Gestion de rendez-vous médicale|[▶️](#1.1)|
|1.2|Magasin de sport|[▶️](#1.2)|
|1.3|Agence de voyage|[▶️](#1.3)|
|1.4|École de musique|[▶️](#1.4)|
|1.5|Sytème de réservation - voyage|[▶️](#1.5)|
|1.6|Application contact|[▶️](#1.6)|

<a id="1.1"></a>

### Exercice 1.1 
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Pour notre système de prise de rendez-vous, il est indispensable que chaque fiche patient contienne son nom complet et une date de consultation précise. Le motif de la visite et le médecin attribué seront saisis ultérieurement par le secrétariat si nécessaire.*

> **b.** Testez votre script SQL.
---
<a id="1.2"></a>


### Exercice 1.2
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Notre gestion des stocks exige que tout nouveau produit enregistré dispose d’une référence unique et d’une description claire. Le prix de vente et la marque pourront être ajoutés lors de la mise en rayon par l’équipe logistique.*

> **b.** Testez votre script SQL.

---
<a id="1.3"></a>


### Exercice 1.3
###### [Retour au sommaire](#sommaire)
> **a.** À partir du besoin utilisateur suivant, fournissez un script SQL répondant au besoin de l'utilisateur :

*Dans notre base clients, les réservations doivent impérativement indiquer le nom du voyageur et son numéro de passeport. Les options de restauration et les commentaires spéciaux restent modifiables jusqu’à 48h avant le départ.*

> **b.** Testez votre script SQL.
---
<a id="1.4"></a>


### Exercice 1.4
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter la ou les contraintes **NOT NULL** nécessaires :

**Context :** *"L'inscription d'un nouvel élève dans notre école de musique doit systématiquement mentionner son identité complète et l'instrument choisi. La validation de son niveau musical et l'affectation d'un professeur interviendront après l'audition."*
```sql
CREATE TABLE Eleve (
    id INT PRIMARY KEY,
    prenom_nom VARCHAR(80),
    instrument_principal VARCHAR(40),
    niveau_actuel VARCHAR(30),
    professeur VARCHAR(80)
);
```
---
<a id="1.5"></a>


### Exercice 1.5
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter la ou les contraintes **NOT NULL** nécessaires :

**Context :** *"Toute réservation confirmée chez notre agence exige la fourniture du nom du voyageur et de son numéro de passeport. Les préférences culinaires et demandes particulières pourront être précisées ultérieurement."*
```sql
CREATE TABLE Reservation (
    id INT PRIMARY KEY,
    voyageur VARCHAR(100),
    numero_passeport VARCHAR(20),
    options_restauration VARCHAR(50),
    commentaires TEXT
);
```

> **b.** Testez votre script SQL.
---
<a id="1.6"></a>


### Exercice 1.6
###### [Retour au sommaire](#sommaire)
> **a.** À partir du script SQL de création de table ci-dessous, générer un script d'édition SQL qui altère la table afin d'y ajouter la ou les contraintes **NOT NULL** nécessaires :

**Context :** *"Pour notre liste de contacts, chaque nouvelle personne doit avoir un nom et un numéro de téléphone. L'adresse email et la date d'anniversaire peuvent être ajoutées plus tard si on les connaît."*
```sql
CREATE TABLE Contact (
    id INT PRIMARY KEY,
    nom_complet VARCHAR(80),
    telephone VARCHAR(20),
    email VARCHAR(50),
    anniversaire DATE
);
```

> **b.** Testez votre script SQL.
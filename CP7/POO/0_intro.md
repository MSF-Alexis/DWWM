# 0 - Programmation Orientée Objet (POO) en PHP - Module Débutant Complet

| **Élément** | **Détails** |
| :-- | :-- |
| **Titre** | Découvrir la POO : Classes, Attributs et Constructeur |
| **Compétence RNCP** | BC02.7 - Développer des composants métier côté serveur |
| **Niveau** | **Débutant complet** |
| **Durée** | 3h guidées + exercices |
| **Prérequis** | Variables PHP, fonctions de base |

## Objectif immédiat

À la fin de ce module, vous saurez **créer une classe simple**, comprendre ce que sont les **attributs** et utiliser un **constructeur** pour initialiser vos objets.

## 1. D'abord : Qu'est-ce qu'une classe ? (Le plan de construction)

### Analogie pour débuter

Imaginez que vous voulez construire des maisons. Avant de construire, vous avez besoin d'un **plan architectural**. Ce plan décrit :

- Combien de pièces
- Où sont les fenêtres
- La couleur des murs

En PHP, une **classe** est exactement comme ce plan : elle décrit comment sera construite votre "maison numérique".

### Exemple concret : la classe Humain

```php
<?php
class Humain {
    // Ici on décrit les "caractéristiques" d'un humain
    public string $prenom;
    public string $nom;
    public int $age;
}
```

**Décomposons ligne par ligne :**

1. `<?php` : on démarre le code PHP
2. `class Humain {` : on dit "je vais créer le plan d'un Humain"
3. Les lignes suivantes décrivent les **attributs** (on va expliquer juste après)
4. `}` : on ferme la classe

### Point important pour débuter

**UNE CLASSE = UN PLAN**. Elle ne crée rien encore, elle décrit juste comment sera construit l'objet.

## 2. Comprendre les attributs (Les caractéristiques de l'objet)

### Qu'est-ce qu'un attribut ?

Un **attribut** est une **caractéristique** que possédera chaque objet créé à partir de la classe.

Dans notre exemple :

- `$prenom` : le prénom de la personne
- `$nom` : le nom de famille
- `$age` : l'âge en années


### Décortiquons la syntaxe

```php
public string $prenom;
```

- `public` : mot-clé qui dit "cette information peut être lue de partout" (on reviendra dessus)
- `string` : type de donnée = texte/chaîne de caractères
- `$prenom` : le nom de l'attribut (toujours avec \$ en PHP)


### Exercice guidé 1

Créez une classe `Voiture` avec ces attributs :

- marque (texte)
- couleur (texte)
- nombrePortes (nombre entier)

**Solution :**

```php
<?php
class Voiture {
    public string $marque;
    public string $couleur;
    public int $nombrePortes;
}
```


## 3. Le constructeur : donner vie à vos objets

### Problème à résoudre

Avec notre classe `Humain` actuelle, si on essaie de créer une personne :

```php
$personne = new Humain();
echo $personne->prenom; // VIDE ! Pas de valeur
```

Les attributs sont vides car on ne les a pas remplis.

### Solution : le constructeur

Le **constructeur** est une fonction spéciale qui s'exécute **automatiquement** quand on crée un objet. Elle sert à "remplir" les attributs avec des valeurs initiales.

### Syntaxe du constructeur

```php
<?php
class Humain {
    public string $prenom;
    public string $nom;
    public int $age;

    public function __construct(string $prenomChoisi, string $nomChoisi, int $ageChoisi)
    {
        $this->prenom = $prenomChoisi;
        $this->nom = $nomChoisi;
        $this->age = $ageChoisi;
    }
}
```


### Décomposition détaillée

**1. La signature du constructeur :**

```php
public function __construct(string $prenomChoisi, string $nomChoisi, int $ageChoisi)
```

- `public` : accessible de partout
- `function` : on déclare une fonction
- `__construct` : nom spécial reconnu par PHP (avec 2 underscores)
- Entre parenthèses : les **paramètres** qu'on devra fournir pour créer l'objet

**2. Le corps du constructeur :**

```php
$this->prenom = $prenomChoisi;
```

- `$this` : mot-clé PHP qui désigne "l'objet en cours de création"
- `->` : opérateur fléché pour accéder aux attributs de l'objet
- `prenom` : nom de l'attribut (sans le \$)
- `= $prenomChoisi` : on assigne la valeur reçue en paramètre


### Analogie pour comprendre \$this

Imaginez que vous construisez plusieurs maisons à partir du même plan :

- `$this` = "la maison que je suis en train de construire maintenant"
- `$this->prenom` = "écris le prénom sur LA maison en cours"


## 4. Utiliser votre classe avec le constructeur

### Créer des objets

```php
// Créer une première personne
$alice = new Humain("Alice", "Dupont", 28);

// Créer une deuxième personne
$bob = new Humain("Bob", "Martin", 35);

// Afficher les informations
echo $alice->prenom; // Affiche : Alice
echo $bob->age;      // Affiche : 35
```


### Explication pas à pas

1. `new Humain("Alice", "Dupont", 28)` :
    - `new` : mot-clé pour créer un nouvel objet
    - `Humain` : nom de la classe à utiliser
    - Les paramètres sont transmis au constructeur
2. `$alice->prenom` :
    - `$alice` : l'objet créé
    - `->` : pour accéder à l'attribut
    - `prenom` : nom de l'attribut

### Exercice guidé 2

Complétez la classe Voiture avec un constructeur :

```php
<?php
class Voiture {
    public string $marque;
    public string $couleur;
    public int $nombrePortes;

    // Ajoutez le constructeur ici
}

// Créez une voiture rouge Peugeot à 5 portes
```


## 5. Erreurs courantes de débutant

### Erreur 1 : Oublier le \$ devant le nom de classe

```php
//  FAUX
$personne = new humain();

//  CORRECT
$personne = new Humain();
```


### Erreur 2 : Confondre attribut et paramètre dans le constructeur

```php
//  FAUX : $this->$prenomChoisi
$this->$prenomChoisi = $prenomChoisi; 

//  CORRECT
$this->prenom = $prenomChoisi;
```


### Erreur 3 : Oublier \$this

```php
//  FAUX
prenom = $prenomChoisi;

//  CORRECT  
$this->prenom = $prenomChoisi;
```


## 6. Résumé des concepts essentiels

| Concept | Définition simple | Exemple |
| :-- | :-- | :-- |
| **Classe** | Plan de construction pour créer des objets | `class Humain` |
| **Attribut** | Caractéristique que possède l'objet | `public string $prenom;` |
| **Constructeur** | Fonction qui remplit les attributs à la création | `__construct()` |
| **\$this** | Fait référence à l'objet en cours | `$this->prenom` |
| **new** | Mot-clé pour créer un objet | `new Humain()` |

## 7. Exercice de validation

Créez une classe `Livre` avec :

- Attributs : titre (string), auteur (string), nombrePages (int)
- Constructeur qui initialise ces 3 attributs
- Créez 2 livres différents et affichez leurs informations



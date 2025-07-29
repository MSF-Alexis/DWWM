# 1 – Les méthodes en PHP : les actions de vos objets

| Élément | Détails |
| :-- | :-- |
| **Titre** | Comprendre et créer des méthodes : faire agir vos objets |
| **Bloc RNCP ciblé** | BC02 – Développer des composants métier côté serveur |
| **Niveau** | Débutant |
| **Durée estimée** | 2 h cours guidé + 1 h exercices |
| **Prérequis** | Savoir créer une classe, des attributs, un constructeur |
| **Objectifs SMART** | 1) Définir ce qu'est une méthode et la différencier d'un attribut. 2) Écrire une méthode simple qui agit sur les attributs. 3) Créer une classe complète avec attributs ET méthodes fonctionnelles. |

## Sommaire

1. Rappel : où nous en sommes
2. Qu'est-ce qu'une méthode ? (Les actions de l'objet)
Exercice 1
3. Créer votre première méthode simple
Exercice 2
4. Méthodes avec paramètres
Exercice 3
5. Méthodes qui retournent une valeur
Exercice 4
6. Atelier guidé : une classe complète
7. Erreurs courantes
8. Résumé des concepts essentiels

## 1. Rappel : où nous en sommes

Jusqu'à maintenant, nous avons appris à créer des "boîtes" (classes) qui peuvent **stocker des informations** (attributs). Mais ces boîtes ne savent encore **rien faire**.

```php
class Voiture {
    public string $marque;
    public string $couleur;
    public bool $estDemarree = false;

    public function __construct(string $marque, string $couleur) {
        $this->marque = $marque;
        $this->couleur = $couleur;
    }
}
```

Notre voiture peut mémoriser sa marque et sa couleur, mais elle ne peut pas démarrer, rouler, ou s'arrêter. C'est là que les **méthodes** deviennent indispensables.

## 2. Qu'est-ce qu'une méthode ?

**Définition simple**
Une méthode est une **action** que votre objet sait accomplir. C'est comme un bouton sur votre télécommande : chaque bouton (méthode) fait quelque chose de précis.

**Analogie pour bien comprendre**
Votre voiture (l'objet) a des caractéristiques (marque, couleur) mais aussi des **capacités** :

- Elle peut démarrer
- Elle peut rouler
- Elle peut s'arrêter
- Elle peut klaxonner

Chaque capacité = une méthode.

**Différence avec les attributs**


| Concept | Rôle | Exemple |
| :-- | :-- | :-- |
| **Attribut** | Stocke une information | `$couleur = "rouge"` |
| **Méthode** | Fait une action | `demarrer()` |

### Exercice 1

Regardez cette liste et classez chaque élément en **attribut** ou **méthode** pour une classe `Telephone` :

- numero
- sonner
- marque
- envoyer un SMS
- taille écran
- éteindre

## 3. Créer votre première méthode simple

**Syntaxe de base**

```php
class Voiture {
    public bool $estDemarree = false;

    public function demarrer() {
        $this->estDemarree = true;
        echo "La voiture démarre !";
    }
}
```

**Décomposition pas à pas**

1. `public function` : on déclare une méthode accessible partout
2. `demarrer()` : nom de la méthode (toujours avec des parenthèses)
3. `{` : début du code de la méthode
4. `$this->estDemarree = true;` : modifie l'attribut de l'objet
5. `}` : fin de la méthode

**Comment utiliser cette méthode**

```php
$maVoiture = new Voiture("Peugeot", "bleue");
echo $maVoiture->estDemarree;  // Affiche : false (pas encore démarrée)

$maVoiture->demarrer();        // Exécute la méthode
echo $maVoiture->estDemarree;  // Affiche : true (maintenant démarrée)
```

**Points importants pour débuter**

- Une méthode se **déclare** dans la classe avec `function`
- Une méthode s'**utilise** sur l'objet avec `->nomMethode()`
- À l'intérieur d'une méthode, on accède aux attributs avec `$this->`


### Exercice 2

Ajoutez une méthode `arreter()` à la classe Voiture qui :

- Met `$estDemarree` à `false`
- Affiche "La voiture s'arrête"

**Solution :**

```php
public function arreter() {
    $this->estDemarree = false;
    echo "La voiture s'arrête";
}
```


## 4. Méthodes avec paramètres

Parfois, votre méthode a besoin d'informations pour fonctionner.

**Exemple : klaxonner un certain nombre de fois**

```php
class Voiture {
    public function klaxonner(int $nombreFois) {
        for ($i = 0; $i < $nombreFois; $i++) {
            echo "BIP ! ";
        }
    }
}
```

**Utilisation**

```php
$maVoiture = new Voiture("Renault", "verte");
$maVoiture->klaxonner(3);  // Affiche : BIP ! BIP ! BIP !
```

**Méthode avec plusieurs paramètres**

```php
class Voiture {
    public function rouler(int $vitesse, int $duree) {
        echo "Je roule à " . $vitesse . " km/h pendant " . $duree . " minutes.";
    }
}

// Utilisation
$maVoiture->rouler(90, 15);  // "Je roule à 90 km/h pendant 15 minutes."
```


### Exercice 3

Créez une méthode `faireLePlein()` qui prend en paramètre le nombre de litres d'essence et affiche "Plein de X litres effectué".

**Solution :**

```php
public function faireLePlein(int $litres) {
    echo "Plein de " . $litres . " litres effectué";
}
```


## 5. Méthodes qui retournent une valeur

Jusqu'ici, nos méthodes ne faisaient qu'afficher du texte. Mais souvent, on veut qu'une méthode **calcule** quelque chose et nous **donne le résultat**.

**Exemple : calculer le prix d'un trajet**

```php
class Voiture {
    public float $consommation = 7.5;  // litres aux 100 km

    public function calculerPrixTrajet(int $distance, float $prixEssence): float {
        $litresNecessaires = ($distance / 100) * $this->consommation;
        $prix = $litresNecessaires * $prixEssence;
        return $prix;
    }
}
```

**Nouveautés dans cette méthode**

1. `: float` après les parenthèses = la méthode retourne un nombre décimal
2. `return $prix;` = renvoie le résultat au lieu de l'afficher
3. On peut **utiliser** ce résultat dans notre code

**Utilisation**

```php
$maVoiture = new Voiture("Toyota", "grise");
$cout = $maVoiture->calculerPrixTrajet(200, 1.45);
echo "Le trajet coûtera " . $cout . " euros.";
```

**Méthode simple qui retourne sans calcul**

```php
class Personne {
    public string $nom;
    public int $age;

    public function sePresenter(): string {
        return "Je m'appelle " . $this->nom . " et j'ai " . $this->age . " ans.";
    }
}

// Utilisation
$alice = new Personne("Alice", 25);
$presentation = $alice->sePresenter();
echo $presentation;  // "Je m'appelle Alice et j'ai 25 ans."
```


### Exercice 4

Créez une classe `Rectangle` avec :

- Attributs : `largeur` et `hauteur`
- Constructeur pour initialiser ces attributs
- Méthode `calculerSurface()` qui retourne largeur × hauteur

**Solution :**

```php
class Rectangle {
    public float $largeur;
    public float $hauteur;

    public function __construct(float $largeur, float $hauteur) {
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    public function calculerSurface(): float {
        return $this->largeur * $this->hauteur;
    }
}

// Test
$rect = new Rectangle(5.0, 3.0);
echo $rect->calculerSurface();  // 15
```


## 6. Atelier guidé : une classe complète

**Contexte professionnel**
Créons une classe `CompteBancaire` pour une application de banque en ligne (compétence BC02.7 - Développer des composants métier côté serveur).

**Cahier des charges**

- Stocker le numéro de compte et le solde
- Permettre de faire des dépôts
- Permettre de faire des retraits (avec vérification du solde)
- Afficher les informations du compte

**Étape 1 : Structure de base**

```php
class CompteBancaire {
    public string $numeroCompte;
    public float $solde;

    public function __construct(string $numeroCompte, float $soldeInitial = 0) {
        $this->numeroCompte = $numeroCompte;
        $this->solde = $soldeInitial;
    }
}
```

**Étape 2 : Méthode pour déposer**

```php
public function deposer(float $montant): bool {
    if ($montant > 0) {
        $this->solde += $montant;
        echo "Dépôt de " . $montant . " euros effectué.";
        return true;
    } else {
        echo "Erreur : montant invalide.";
        return false;
    }
}
```

**Étape 3 : Méthode pour retirer**

```php
public function retirer(float $montant): bool {
    if ($montant > 0 && $montant <= $this->solde) {
        $this->solde -= $montant;
        echo "Retrait de " . $montant . " euros effectué.";
        return true;
    } else {
        echo "Erreur : montant invalide ou solde insuffisant.";
        return false;
    }
}
```

**Étape 4 : Méthode d'information**

```php
public function afficherSolde(): void {
    echo "Compte " . $this->numeroCompte . " : " . $this->solde . " euros.";
}
```

**Classe complète**

```php
class CompteBancaire {
    public string $numeroCompte;
    public float $solde;

    public function __construct(string $numeroCompte, float $soldeInitial = 0) {
        $this->numeroCompte = $numeroCompte;
        $this->solde = $soldeInitial;
    }

    public function deposer(float $montant): bool {
        if ($montant > 0) {
            $this->solde += $montant;
            echo "Dépôt de " . $montant . " euros effectué.";
            return true;
        } else {
            echo "Erreur : montant invalide.";
            return false;
        }
    }

    public function retirer(float $montant): bool {
        if ($montant > 0 && $montant <= $this->solde) {
            $this->solde -= $montant;
            echo "Retrait de " . $montant . " euros effectué.";
            return true;
        } else {
            echo "Erreur : montant invalide ou solde insuffisant.";
            return false;
        }
    }

    public function afficherSolde(): void {
        echo "Compte " . $this->numeroCompte . " : " . $this->solde . " euros.";
    }
}
```

**Test de la classe**

```php
$monCompte = new CompteBancaire("FR12345", 100);
$monCompte->afficherSolde();  // Compte FR12345 : 100 euros.
$monCompte->deposer(50);      // Dépôt de 50 euros effectué.
$monCompte->retirer(30);      // Retrait de 30 euros effectué.
$monCompte->afficherSolde();  // Compte FR12345 : 120 euros.
```


## 7. Erreurs courantes

### Erreur 1 : Oublier les parenthèses

```php
//  FAUX
$voiture->demarrer;

//  CORRECT
$voiture->demarrer();
```


### Erreur 2 : Confondre attribut et méthode

```php
//  FAUX : essayer d'appeler un attribut comme une méthode
$voiture->couleur();

//  CORRECT : accéder à un attribut
$voiture->couleur;
```


### Erreur 3 : Oublier \$this dans la méthode

```php
//  FAUX
public function demarrer() {
    estDemarree = true;  // Variable inconnue
}

//  CORRECT
public function demarrer() {
    $this->estDemarree = true;
}
```


### Erreur 4 : Mauvais type de retour

```php
//  FAUX : annoncer un retour mais ne rien retourner
public function calculer(): float {
    echo "Résultat";  // Pas de return
}

//  CORRECT
public function calculer(): float {
    return 42.5;
}
```


## 8. Résumé des concepts essentiels

| Concept | Définition simple | Syntaxe | Exemple |
| :-- | :-- | :-- | :-- |
| **Méthode simple** | Action sans paramètre | `public function nom() { }` | `demarrer()` |
| **Méthode avec paramètre** | Action qui a besoin d'infos | `public function nom($param) { }` | `rouler($vitesse)` |
| **Méthode avec retour** | Action qui calcule et donne un résultat | `public function nom(): type { return $valeur; }` | `calculerSurface(): float` |
| **Appel de méthode** | Demander à l'objet de faire l'action | `$objet->nomMethode()` | `$voiture->demarrer()` |

**Points clés à retenir :**

1. **Attribut** = information stockée | **Méthode** = action réalisée
2. Dans une méthode, toujours utiliser `$this->` pour accéder aux attributs
3. Les parenthèses `()` sont obligatoires pour appeler une méthode
4. `return` renvoie une valeur, `echo` affiche à l'écran
5. Une méthode peut modifier les attributs de l'objet

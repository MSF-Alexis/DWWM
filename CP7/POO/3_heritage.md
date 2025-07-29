# 3 – L’héritage en PHP : factoriser, réutiliser et spécialiser vos classes

| Élément | Détails |
| :-- | :-- |
| **Titre** | L’héritage : factoriser, réutiliser et spécialiser |
| **Bloc RNCP ciblé** | BC02 – Développer des composants métier côté serveur |
| **Niveau** | Débutant |
| **Durée estimée** | 2 h cours guidé + 1 h exercices |
| **Prérequis** | Classes, attributs, constructeur, méthodes, encapsulation |
| **Objectifs SMART** | 1) Définir parent/enfant et le mot-clé `extends`. 2) Créer une sous-classe qui hérite. 3) Redéfinir (surcharger) une méthode. 4) Utiliser `parent::` pour réemployer du code. |

## Sommaire

1. Rappel : d’où part-on ?
2. Pourquoi l’héritage ?
3. Vocabulaire essentiel
4. Déclaration d’une classe héritée (`extends`)
5. Héritage simple : partage d’attributs et de méthodes
6. Surcharge (override) et `parent::`
7. Visibilité et hiérarchie
8. Limites \& bonnes pratiques
9. Exercice applicatif A : hiérarchie `Animal`
10. Exercice applicatif B : calcul de salaire
11. Mini-projet : « Gestion de flotte de véhicules »
12. Erreurs courantes
13. Synthèse des points clés

## 1. Rappel : d’où part-on ?

Vous savez déjà :

- Créer une **classe** avec des **attributs** et un **constructeur** (module 0).
- Ajouter des **méthodes** pour animer l’objet (module 1).
- **Protéger** l’état interne grâce à l’encapsulation (module 2.1).

L’étape naturelle suivante : éviter la duplication en **faisant hériter** vos classes.

## 2. Pourquoi l’héritage ?

Sans héritage, les classes `Chien` et `Chat` dupliqueraient le même attribut `$nom` et la même méthode `seDeplacer()`. Hériter d’une classe `Animal` :

- **Factorise** le code commun (principe DRY).
- **Spécialise** chaque sous-classe (aboyer, miauler).
- **Facilite** la maintenance : changer le comportement du parent profite à tous les enfants.


### Métaphore « Poupées gigognes »

Chaque poupée reprend la forme de la poupée mère et ajoute sa décoration : vos sous-classes réutilisent la base et la complètent.

## 3. Vocabulaire essentiel

| Terme | Définition | Exemple |
| :-- | :-- | :-- |
| **Classe parent** | Classe qui transmet ses membres | `Animal` |
| **Classe enfant** | Classe qui hérite du parent | `Chien extends Animal` |
| **Héritage** | Mécanisme de transmission | mot-clé `extends` |
| **Surcharge** | Redéfinir une méthode héritée | `parler()` dans `Chat` |
| **`parent::`** | Appel d’un membre du parent | `parent::__construct()` |

## 4. Déclaration d’une classe héritée (`extends`)

```php
class Animal {
    public string $nom;

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    public function seDeplacer(): void {
        echo $this->nom . " se déplace.\n";
    }
}

// Chien hérite de Animal
class Chien extends Animal {
    public function aboyer(): void {
        echo $this->nom . " : Wouf !\n";
    }
}

$rex = new Chien("Rex");
$rex->seDeplacer(); // hérité
$rex->aboyer();     // spécifique
```

**À retenir** : le mot-clé `extends` établit la relation parent → enfant.

## 5. Héritage simple : partage d’attributs et de méthodes

La classe `Chien` n’a déclaré que `aboyer()`, pourtant elle dispose déjà de `$nom`, `__construct()` et `seDeplacer()` grâce à l’héritage. Aucune copie-coller nécessaire.

## 6. Surcharge (override) et `parent::`

### 6.1 Redéfinir une méthode

```php
class Animal {
    public function parler(): void {
        echo "Son indéfini.\n";
    }
}

class Chat extends Animal {
    public function parler(): void {      // surcharge
        echo "Miaou !\n";
    }
}
```


### 6.2 Réutiliser le code parent

```php
class Logger {
    public function log(string $msg): void {
        echo "[LOG] " . $msg . "\n";
    }
}

class FileLogger extends Logger {
    public function log(string $msg): void {
        parent::log($msg);               // conserve la trace écran
        // … puis écrit dans un fichier
    }
}
```


## 7. Visibilité et hiérarchie

| Niveau | Visible dehors | Visible dans l’enfant | Exemple |
| :-- | :-- | :-- | :-- |
| `public` | Oui | Oui | `seDeplacer()` |
| `protected` | Non | Oui | `$age` partagé |
| `private` | Non | Non | `$secret` interne |

`protected` équilibre sécurité et réutilisabilité : parfait pour les attributs destinés aux sous-classes.

## 8. Limites \& bonnes pratiques

- **Pas d’héritage multiple** : une classe ne peut avoir qu’un seul parent.
- Préférer **composition** si la relation « est-un » n’est pas évidente.
- Ne jamais appeler un attribut `private` du parent : utiliser un getter ou passer en `protected` avec prudence.


## 9. Exercice applicatif A – Hiérarchie `Animal`

1. Créez `Animal` avec attribut `$nom` et méthode `parler()` affichant « ?? ».
2. Créez `Chat` et `Chien` qui héritent d’`Animal` et surchargent `parler()` (« Miaou », « Wouf »).
3. Instanciez un tableau mixte de chats et chiens puis bouclez pour appeler `parler()`.
4. Vérifiez qu’aucune duplication de code n’existe.

## 10. Exercice applicatif B – Calcul de salaire

1. Classe `Employe` : attributs `nom`, `salaireBase`, méthode `calculerSalaire()` (retourne base).
2. Sous-classe `Developpeur` : bonus technique fixe de 200 €.
3. Sous-classe `Manager` : bonus 10% du salaire + prime d’équipe passée au constructeur.
4. Affichez les salaires de plusieurs employés dans un tableau.

## 11. Mini-projet – Gestion de flotte de véhicules

### Contexte professionnel

Une société de location gère voitures, motos et camions. Vous devez construire une hiérarchie propre pour préparer le futur module de polymorphisme.

### Cahier des charges

| Entité | Spécificités | Méthodes requises |
| :-- | :-- | :-- |
| `Vehicule` (parent) | `$marque`, `$modele`, `$kilometrage` | `demarrer()`, `afficherInfos()` |
| `Voiture` | `$nombrePortes` | `ouvrirCoffre()` |
| `Moto` | `$cylindree` | `faireWheelie()` |
| `Camion` | `$capaciteTonnes` | `charger(float $t)` vérifie la charge max |

### Étapes conseillées

1. Implémentez `Vehicule` : constructeur initialise les 3 attributs, méthode `demarrer()` générique.
2. Créez chaque sous-classe : ajoutez l’attribut spécifique + méthode propre.
3. Surchargez `afficherInfos()` pour compléter les informations.
4. Écrivez un script de test :
    - Créez un tableau de 5 véhicules mélangés.
    - Bouclez pour appeler `demarrer()` puis `afficherInfos()`.
5. **Livrables** : code source + capture d’écran de l’exécution.

### Critères d’évaluation (Kirkpatrick niveau 2)

- Zéro duplication d’attributs entre enfants.
- Utilisation correcte de `extends`, `parent::__construct()` et `protected`.
- Résultat fonctionnel affiché sans erreur.


## 12. Erreurs courantes

| Erreur | Cause | Correction |
| :-- | :-- | :-- |
| Oublier `extends` | Deux classes identiques au lieu d’une hiérarchie | `class Chien extends Animal` |
| Ne pas appeler le constructeur parent | Attributs non initialisés | `parent::__construct($nom)` |
| Surcharger avec une signature différente | Types ou nb de paramètres incompatibles | Garder la même signature |
| Vouloir plusieurs parents | PHP ne gère pas l’héritage multiple | Passer par interfaces ou composition |

## 13. Synthèse des points clés

| Concept | Rôle | Syntaxe | Exemple |
| :-- | :-- | :-- | :-- |
| **Héritage** | Transmettre attributs \& méthodes | `extends` | `class Moto extends Vehicule` |
| **Surcharge** | Redéfinir une méthode héritée | même signature | `parler()` dans `Chat` |
| **`parent::`** | Réutiliser le code parent | `parent::methode()` | `parent::__construct()` |
| **Visibilité** | Contrôler l’accès dans la hiérarchie | `protected` utile | `$this->kilometrage` |

*Note : Dans la programmation orientée objet (POO), le polymorphisme fait référence à la capacité d’un objet à prendre plus d’une forme.*


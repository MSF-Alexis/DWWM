# 4 – Le polymorphisme en PHP : un code flexible, évolutif **et sûr**

Le polymorphisme est le quatrième pilier de la programmation orientée objet : après avoir maîtrisé la création de classes, l’encapsulation et l’héritage, vous allez apprendre à **substituer** des objets les uns aux autres pour obtenir un code réellement extensible et orienté métier. À la fin de ce module, vous saurez utiliser des références de type parent (ou interface) qui, au moment de l’exécution, appelleront la bonne implémentation enfant sans que vous ayez à écrire la moindre condition.



| Élément | Détails |
| :-- | :-- |
| **Titre** | Le polymorphisme : appeler le bon code, au bon moment |
| **Bloc RNCP ciblé** | BC02 – Développer des composants métier côté serveur |
| **Niveau** | Débutant |
| **Durée estimée** | 2 h cours guidé + 1 h exercices |
| **Prérequis** | Modules 0 à 3 réussis (classes, méthodes, encapsulation, héritage) |
| **Objectifs SMART** | 1) Définir le polymorphisme (liaison dynamique). 2) Manipuler un tableau d’objets hétérogènes partageant le même contrat. 3) Respecter le Liskov Substitution Principle (sans rupture de signature). 4) Simplifier la maintenance grâce au polymorphisme. |

## Sommaire

1. Rappel des acquis
2. Le polymorphisme : définition et analogies
3. Préparer le terrain : facteur commun (héritage **ou** interface)
4. Zoom débutant : la classe **abstract** (non instanciable)
5. Liaison dynamique : l’appel automatique de la bonne méthode
6. Avantages concrets côté métier
7. Quiz flash \#1
8. Exercice A : bestiaire parlant
9. Exercice B : système de notifications multicanal
10. Mini-projet : facturation multi-moyens de paiement
11. Bonnes pratiques et erreurs courantes
12. Quiz flash \#2 (corrections \#1 + \#2)
13. Synthèse visuelle : polymorphisme en 1 slide ASCII
14. Prochaine étape : interfaces \& injection de dépendances

## 1. Rappel des acquis

| Pilier POO | Compétence couverte | Module précédent | Importance pour aujourd’hui |
| :-- | :-- | :-- | :-- |
| Encapsulation | Protéger l’état interne | 2_visibilite_et_encapsulation.md | Garantit que chaque objet reste cohérent |
| Héritage | Factoriser \& spécialiser | 3_heritage_et_polymorphisme.md | Crée la hiérarchie commune nécessaire au polymorphisme |
| Polymorphisme | Substituer les objets | **Module 4 (actuel)** | Confère souplesse et évolutivité |

Grâce au module 3, vous savez déjà déclarer une classe parent et plusieurs enfants qui héritent d’attributs et de méthodes. Le polymorphisme exploite cette hiérarchie pour vous libérer des `if/else` et offrir un code auto-adaptatif.

## 2. Le polymorphisme : définition et analogies

### 2.1 Définition courte

Le polymorphisme est la **capacité d’une référence de type parent (ou interface) à contenir n’importe lequel de ses enfants et à déclencher, à l’exécution, la version enfant appropriée d’une méthode partagée**.

### 2.2 Métaphore « Prise universelle »

Votre chargeur de téléphone fonctionne dans plusieurs pays grâce à un adaptateur : peu importe le type de prise, vous branchez le même chargeur et l’électricité s’adapte. De la même façon, une variable typée `Animal` peut référencer un `Chat`, un `Chien` ou un `Perroquet` ; le code appelant est identique, mais le comportement concret diffère.

### 2.3 Illustration express

```php
$animaux = [
    new Chien("Rex"),
    new Chat("Mia"),
    new Perroquet("Coco"),
];

foreach ($animaux as $animal) {
    $animal->parler(); // Wouf, Miaou ou Coco ! selon l’objet réel
}
```

Un **seul** appel déclenche trois sons différents : c’est la *liaison dynamique*.

## 3. Préparer le terrain : facteur commun (héritage **ou** interface)

| Option | Quand l’utiliser ? | Syntaxe clé | Exemple |
| :-- | :-- | :-- | :-- |
| **Héritage** | Vous avez déjà une classe générique contenant code partagé | `extends` | `class Chat extends Animal` |
| **Interface** | Vous n’avez qu’un contrat (pas d’implémentation) ou besoin d’héritage multiple | `implements` | `class Perroquet implements Parlable` |

Dans ce module débutant, nous utiliserons surtout l’héritage ; les interfaces arriveront au module 5.

## 4. Zoom débutant : la classe **abstract** (non instanciable)

### 4.1 Pourquoi une classe abstraite ?

Certains concepts n’ont pas de sens concrets : on **ne crée jamais** un « Animal » générique ni un « Paiement » sans préciser le moyen. Une classe **abstract** sert de base (attributs + méthodes communes) **sans** permettre l’instanciation directe.

### 4.2 Règles clés

- Mot-clé `abstract` devant `class` : la classe **ne peut pas** être construite avec `new`.
- Peut déclarer des **méthodes abstraites** (sans corps) que chaque enfant **doit** surcharger.
- Favorise la **factorisation** du code et impose un **contrat minimal**.


### 4.3 Exemple pédagogique

```php
abstract class Animal {
    protected string $nom;

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    // Méthode abstraite : pas de corps ici
    abstract public function parler(): void;

    // Méthode concrète partagée
    public function seDeplacer(): void {
        echo $this->nom . " se déplace.\n";
    }
}

// Sous-classe concrète
class Chat extends Animal {
    public function parler(): void {      // obligation de surcharger
        echo "Miaou !\n";
    }
}

$felix = new Chat("Félix");
$felix->parler();       // Miaou !
$felix->seDeplacer();   // Félix se déplace.
```

> Essayer `new Animal("Bob")` génère : `Error : Cannot instantiate abstract class Animal`, prouvant que la classe abstraite n’est qu’un **modèle**, jamais un objet.

## 5. Liaison dynamique : l’appel automatique de la bonne méthode

### 5.1 Exemple guidé

```php
abstract class Vehicule {
    protected string $marque;
    public function __construct(string $marque) { $this->marque = $marque; }
    abstract public function demarrer(): void;     // contrat commun
}

class Voiture extends Vehicule {
    public function demarrer(): void { echo "$this->marque démarre avec une clé.\n"; }
}

class Moto extends Vehicule {
    public function demarrer(): void { echo "$this->marque démarre avec un bouton.\n"; }
}

$flotte = [ new Voiture("Peugeot"), new Moto("Yamaha") ];

foreach ($flotte as $v) { $v->demarrer(); }
```

**Sortie :**

```
Peugeot démarre avec une clé.
Yamaha démarre avec un bouton.
```

Un seul appel `$v->demarrer()` suffit : PHP repère le type réel à l’exécution et sélectionne la bonne implémentation.

### 5.2 Liaison statique VS dynamique

- **Statique** : choix du code à la compilation (e.g., surcharge de méthodes en C++).
- **Dynamique** : choix du code à l’exécution (PHP, Java) → flexibilité maximale.


## 6. Avantages concrets côté métier

| Avantage | Impact | Explication simple |
| :-- | :-- | :-- |
| **Réduction du code conditionnel** | Moins de `if/else` | Pas besoin de tester le type manuellement |
| **Évolutivité** | Ajout d’une sous-classe sans toucher au code client | La boucle `foreach` reste inchangée |
| **Testabilité** | Un seul *mock* basé sur le type parent | Simplifie les tests unitaires |
| **Maintenance** | Localisation des changements | Modifier la sous-classe n’impacte pas l’appelant |

## 7. Quiz flash \#1

1. Qu’est-ce qui se passe si une sous-classe ne redéfinit **pas** une méthode `abstract` ?
2. Vrai ou faux : on peut instancier une classe abstraite.
3. Pourquoi le polymorphisme réduit-il le nombre de structures `switch` ?

*(Réponses en section 12.)*

## 8. Exercice A – Bestiaire parlant

### Consignes

1. Reprenez la hiérarchie `Animal`, `Chat`, `Chien` du module 3.
2. Convertissez `Animal` en classe **abstract** et rendez `parler()` abstraite.
3. Ajoutez `Perroquet` qui dit « Coco ! ».
4. Placez plusieurs animaux dans un tableau et bouclez pour appeler `parler()`.
5. Vérifiez qu’aucun doublon de code n’existe, qu’aucun `if/else` n’est présent.

### Critères de réussite

- Aucune instanciation directe d’`Animal`.
- Chaque sous-classe possède **exactement** sa propre version de `parler()`.
- La sortie affiche les sons dans l’ordre des objets créés.


## 9. Exercice B – Système de notifications multicanal

### Contexte

Une application doit envoyer des alertes par **e-mail** et **SMS** sans changer de code quand un nouveau canal (ex. Push) sera ajouté.

### Étapes guidées

| \# | Action | Indice |
| :-- | :-- | :-- |
| 1 | Déclarez `abstract class Notification` avec méthode `envoyer(string $msg): void`. | Utilisez le mot-clé `abstract` devant la méthode |
| 2 | Créez `EmailNotification` et `SmsNotification` qui héritent et implémentent `envoyer()`. | `mail()` ou simple `echo` simulant l’envoi |
| 3 | Écrivez `function notifier(array $canaux, string $msg)` qui boucle et appelle `envoyer()`. | Tape‐hint le paramètre : `Notification $c` |
| 4 | Testez avec un tableau mixte et démontrez qu’aucun `if/else` n’est nécessaire. | Ajoutez un 3ᵉ canal facultatif |

## 10. Mini-projet – Facturation multi-moyens de paiement

### 10.1 Contexte métier

La boutique en ligne « Coder-Shop » ambitionne d’accepter **carte bancaire**, **Paypal** et **bons cadeaux**. Le contrôleur de commande doit appeler **une unique méthode** sans connaître le moyen de paiement choisi.

### 10.2 Cahier des charges

| Entité | Rôle | Méthodes obligatoires |
| :-- | :-- | :-- |
| `Paiement` (abstraite) | Contrat commun | `payer(float $montant): bool` |
| `CarteBancaire` | Débit de carte | Vérifier le CVV dans `payer()` |
| `Paypal` | API externe | Simuler un token OAuth dans `payer()` |
| `BonCadeau` | Débit d’un solde interne | Refuser paiement si solde insuffisant |

### 10.3 Étapes conseillées

1. Créez `abstract class Paiement` et marquez `payer()` abstraite.
2. Implémentez chaque sous-classe avec validations propres.
3. Écrivez `function processOrder(Paiement $moyen, float $total)` qui appelle `payer()`.
4. Testez trois commandes différentes ; démontrez que `processOrder()` reste identique.

## 11. Bonnes pratiques et erreurs courantes

| Erreur | Problème | Solution |
| :-- | :-- | :-- |
| Instancier une classe abstraite | `Error : Cannot instantiate abstract class` | Créer une sous-classe concrète |
| Oublier de surcharger une méthode abstraite | Fatal error à l’inclusion | Implémenter toutes les méthodes requises |
| Mélanger logique métier et `echo` dans la sous-classe | Couplage fort, difficile à tester | Retourner un booléen ou lever une exception |
| Utiliser `instanceof` partout | Anti-pattern qui casse l’ouverture / extension | Se reposer sur le polymorphisme |

## 12. Quiz flash \#2 – Corrections

| \# | Question | Réponse |
| :-- | :-- | :-- |
| 1 | Sous-classe qui n’implémente pas une méthode abstraite ? | PHP déclenche `Fatal error : Class X contains 1 abstract method and must therefore be declared abstract or implement the remaining methods`. |
| 2 | Peut-on instancier une classe abstraite ? | **Faux.** Toute tentative lève une erreur d’instanciation. |
| 3 | Pourquoi moins de `switch` ? | Parce que la décision de la méthode est déléguée à PHP ; un seul appel polymorphe suffit. |

## 13. Synthèse visuelle : polymorphisme en 1 slide ASCII

```
           +-------------------------+
           |        Paiement         |  <-- Classe abstraite
           +------------+------------+
                        |
   +--------------------+--------------------+
   |                    |                    |
+--v----+         +-----v-----+        +-----v-----+
|  CB   |         |  Paypal   |        | BonCadeau |
+-------+         +-----------+        +-----------+
payer() concreto   payer() API          payer() solde
```


## 14. Prochaine étape : interfaces \& injection de dépendances

Vous connaissez maintenant le polymorphisme via l’héritage et les classes abstraites. Le module 5 étendra la notion avec **les interfaces**, ouvrant la voie à l’injection de dépendances et aux architectures orientées contrat (SOLID). Continuez vos exercices, consolidez vos acquis et préparez-vous à écrire un code encore plus modulaire !



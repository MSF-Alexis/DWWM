# Exercices PHP/HTML - Structures de base

## Objectifs
Ces exercices permettent de :
- Maîtriser les boucles pour générer du contenu HTML répétitif
- Utiliser les conditions pour créer des affichages dynamiques
- Comprendre la séparation entre logique PHP et présentation HTML
- Acquérir les bonnes pratiques d'imbrication du code

---

## Partie 1 : Boucles simples

### Exercice 1 - Liste de courses
1. Créez un tableau PHP contenant 5 articles à acheter
2. Générez une liste HTML non ordonnée (ul/li) affichant tous les articles
3. Utilisez une boucle foreach avec la syntaxe alternative (endforeach)

### Exercice 2 - Emploi du temps
1. Préparez un tableau avec les jours de la semaine
2. Créez un tableau HTML (table/tr/td) affichant chaque jour
3. Ajoutez une classe CSS "weekend" pour samedi et dimanche
```php
$emploi_du_temps = [
    'Lundi'    => ['08h-10h' => 'Mathématiques', '10h-12h' => 'Physique', '14h-16h' => 'Histoire'],
    'Mardi'    => ['09h-11h' => 'Chimie', '11h-13h' => 'Sport', '15h-17h' => 'Langues'],
    'Mercredi' => ['08h-12h' => 'Travaux pratiques', '13h-15h' => 'Projet'],
    'Jeudi'    => ['10h-12h' => 'Philosophie', '14h-18h' => 'Laboratoire'],
    'Vendredi' => ['09h-11h' => 'Géographie', '11h-13h' => 'Musique'],
    'Samedi'   => [], // Weekend - pas de cours
    'Dimanche' => []  // Weekend - pas de cours
];
```
---

## Partie 2 : Conditions pratiques

### Exercice 3 - Notification utilisateur
1. Créez une variable "nouveau_message" (true/false)
2. Affichez une alerte "Nouveau message!" si true
3. Affichez "Pas de nouveaux messages" si false
4. Utilisez la syntaxe if/endif

### Exercice 4 - Promotion produit
1. Définissez une variable "prix" et une "promotion_en_cours"
2. Affichez le prix barré en rouge si promotion
3. Affichez le prix normal en vert sinon

---

## Partie 3 : Combinaison boucles/conditions

### Exercice 5 - Liste d'étudiants
1. Créez un tableau d'étudiants avec nom et moyenne
2. Générez une liste affichant :
   - "Admis" en vert si moyenne ≥ 10
   - "Recalé" en rouge si moyenne < 10
```php
$etudiants = [
    ["nom" => "Jean Dupont", "moyenne" => 14.5],
    ["nom" => "Marie Martin", "moyenne" => 9.8],
    ["nom" => "Pierre Lambert", "moyenne" => 12.0],
    ["nom" => "Sophie Moreau", "moyenne" => 17.2],
    ["nom" => "Thomas Roux", "moyenne" => 8.3],
    ["nom" => "Laura Petit", "moyenne" => 15.7],
    ["nom" => "Nicolas Girard", "moyenne" => 11.4],
    ["nom" => "Emma Lefevre", "moyenne" => 6.9],
    ["nom" => "Lucas Morel", "moyenne" => 13.1],
    ["nom" => "Chloé Sanches", "moyenne" => 18.6],
    ["nom" => "Antoine Muller", "moyenne" => 7.5],
    ["nom" => "Camille Dufour", "moyenne" => 16.8],
    ["nom" => "Hugo Laurent", "moyenne" => 10.2],
    ["nom" => "Zoé Vincent", "moyenne" => 14.9],
    ["nom" => "Maxime Bertrand", "moyenne" => 5.4]
];
```

### Exercice 6 - Inventaire magasin
1. Préparez un tableau de produits avec stock disponible
2. Affichez Un message cohérent par palier de stock (ex : faible stock, en stock , etc...)
3. Ajoutez un icône différent pour chaque cas (voir exemple svg)
```php
$inventaire = [
    ["produit" => "T-shirt coton", "stock" => 42, "quantite" => 15],
    ["produit" => "Jean slim", "stock" => 15, "quantite" => 0],
    ["produit" => "Chaussures de sport", "stock" => 8, "quantite" => -3],
    ["produit" => "Veste en cuir", "stock" => 0, "quantite" => 181152],
    ["produit" => "Casquette", "stock" => 23, "quantite" => 365],
    ["produit" => "Pull en laine", "stock" => 0, "quantite" => 1],
    ["produit" => "Ceinture", "stock" => 17, "quantite" => 1561],
    ["produit" => "Robe d'été", "stock" => 12, "quantite" => 29849],
    ["produit" => "Manteau d'hiver", "stock" => 5, "quantite" => 9],
    ["produit" => "Short", "stock" => 0, "quantite" => 44],
    ["produit" => "Baskets", "stock" => 11, "quantite" => 550],
    ["produit" => "Chemise", "stock" => 28, "quantite" => 123],
    ["produit" => "Echarpe", "stock" => 0, "quantite" => 1469],
    ["produit" => "Gants", "stock" => 9, "quantite" => 363],
    ["produit" => "Chaussettes", "stock" => 56, "quantite" => -400]
];
```
```html
<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
<path d="M21.9844 10C21.9473 8.68893 21.8226 7.85305 21.4026 7.13974C20.8052 6.12523 19.7294 5.56066 17.5777 4.43152L15.5777 3.38197C13.8221 2.46066 12.9443 2 12 2C11.0557 2 10.1779 2.46066 8.42229 3.38197L6.42229 4.43152C4.27063 5.56066 3.19479 6.12523 2.5974 7.13974C2 8.15425 2 9.41667 2 11.9415V12.0585C2 14.5833 2 15.8458 2.5974 16.8603C3.19479 17.8748 4.27063 18.4393 6.42229 19.5685L8.42229 20.618C10.1779 21.5393 11.0557 22 12 22C12.9443 22 13.8221 21.5393 15.5777 20.618L17.5777 19.5685C19.7294 18.4393 20.8052 17.8748 21.4026 16.8603C21.8226 16.1469 21.9473 15.3111 21.9844 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M21 7.5L17 9.5M12 12L3 7.5M12 12V21.5M12 12C12 12 14.7426 10.6287 16.5 9.75C16.6953 9.65237 17 9.5 17 9.5M17 9.5V13M17 9.5L7.5 4.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
</svg>
<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
<path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#0F0F0F"/>
</svg>
```


---

## Conseils pratiques
1. Gardez la logique PHP en haut du fichier
2. Structurez proprement le HTML généré
3. Testez avec différentes valeurs
4. Vérifiez la validité du HTML produit
5. Commentez votre code pour mieux comprendre

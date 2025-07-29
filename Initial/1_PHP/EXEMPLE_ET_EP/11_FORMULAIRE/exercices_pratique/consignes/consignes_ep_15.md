# Exercices sur les Formulaires PHP - Niveau Débutant à Intermédiaire

## Objectifs
- Maîtriser la récupération de données via GET/POST
- Apprendre à sécuriser les données (sanitizing)
- Valider les formats de données
- Construire un formulaire complet

---

### Partie 1 : Formulaires GET Basiques

#### Exercice 1.1 - Formulaire de recherche
1. Créez un formulaire en GET avec :
   - Un champ "recherche" (name="q")
   - Un bouton submit
2. Dans traitement.php :
   - Récupérez et affichez la recherche
   - Affichez "Aucune recherche" si vide

#### Exercice 1.2 - Calcul simple
1. Faites un formulaire GET avec :
   - Un nombre (name="nombre")
   - Un select (name="operation") avec options *2 et /2
2. Affichez le résultat du calcul

---

### Partie 2 : Formulaires POST Simples

#### Exercice 2.1 - Contact basique
1. Créez un formulaire POST avec :
   - Nom (text)
   - Email (email)
   - Message (textarea)
2. Affichez les données reçues dans traitement.php

#### Exercice 2.2 - Profil utilisateur
1. Faites un formulaire POST pour créer un profil :
   - Pseudo (text, max 20 caractères)
   - Age (number)
   - Ville (text)
2. Affichez un résumé stylisé (ne perder pas de temps ici faites simple)

---

### Partie 3 : Sécurité Basique (Sanitizing)

#### Exercice 3.1 - Protection XSS
1. Reprenez l'exercice 2.1
2. Appliquez htmlspecialchars() sur tous les champs avant affichage

#### Exercice 3.2 - Nettoyage de texte
1. Ajoutez un champ "biographie" (textarea)
2. Utilisez strip_tags() pour supprimer le HTML
3. Conservez les sauts de ligne (nl2br)

---

### Partie 4 : Validation des Données

#### Exercice 4.1 - Email valide
1. Dans l'exercice 2.1, vérifiez que l'email est valide avec filter_var()
2. Affichez un message d'erreur si invalide

#### Exercice 4.2 - Contrôle d'âge
1. Pour le champ age :
   - Vérifiez que c'est un nombre avec is_numeric()
   - Contrôlez que l'âge est entre 18 et 120
2. Bloquez l'envoi si invalide

---

### Partie 5 : Formulaire Complet

#### Exercice 5 - Inscription sécurisée
Créez un formulaire POST avec traitement qui doit :
1. Contenir ces champs :
   - pseudo (max 30 caractères)
   - email 
   - mot_de_passe (type password)
   - confirmation_mot_de_passe
   - date_naissance (date)
2. Valider que :
   - Le pseudo fait au minimum 5 caractères
   - L'email est valide
   - Les mots de passe correspondent
   - Vérifier que l'utilisateur est majeur
3. Nettoyer toutes les entrées
4. Afficher un récapitulatif sécurisé

---

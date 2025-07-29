# TD Conception BDD : Système de Réservation de Salles

## **📝 Cahier des Charges (Client : Ville de Rouen)**  
**Contexte :**  
La mairie de Rouen souhaite une application pour gérer la réservation des salles communales.  

## **🎯 Objectifs du TD**  
Concevoir le schéma de base de données en appliquant :  
- Conventions de nommage  
- Relations 1-N et N-N  
- Gestion des contraintes métier  
- Bonnes pratiques de modélisation  

---

### 📌 **Étape 1 : Identifier les Entités**  
Listez les tables principales avec leurs champs (sans relations) :  

1. **Bâtiments**  
   - Adresse [obligatoire]  
   - Nombre d'étages [obligatoire]  
   - Accessibilité PMR [obligatoire, défaut : FALSE]  

2. **Salles**  
   - Nom [obligatoire, unique]  
   - Capacité [obligatoire]  
   - Équipements [texte libre]  
   - Date de dernière maintenance [optionnel]  

3. **Utilisateurs**  
   - Email [obligatoire, unique]  
   - Nom complet [obligatoire]  
   - Type (admin/user/moderator) [obligatoire]  
   - Date d'inscription [auto-générée]  

4. **Réservations**  
   - Date/heure de début [obligatoire]  
   - Durée (en minutes) [obligatoire]  
   - Statut (confirmé/en attente/annulé) [obligatoire]  
   - Motif [optionnel]  

> **Consigne supplémentaire** : Ajoutez les champs que vous considérez comme nécessaire

---

### 📌 **Étape 2 : Définir les Relations**  
Analysez les interactions :  

1. Un bâtiment contient ______ salle(s)  
2. Une salle a ______ réservation(s)  
3. Un utilisateur effectue ______ réservation(s)  

> **Questions** :  
> - Quelle table doit contenir la clé étrangère pour la relation bâtiment-salle ?  

---

### 📌 **Étape 3 : Schématiser**  
Créez un diagramme avec :  
1. Tables + colonnes (types SQL appropriés)  
2. Relations (cardinalités et flèches explicites)  
3. Contraintes (NOT NULL, UNIQUE)  

**Outils conseillés :**  
[DrawSQL](https://drawsql.app/)

---

### **Critères de Réussite**  
- ✅ Nommage cohérent (`snake_case`, anglais)  
- ✅ Relations correctement typées (1-N vs N-N)  
- ✅ Gestion des horaires et conflits de réservation  
- ✅ Absence de redondance de données  

---

## **📤 Livrables Attendus**  
- Diagramme relationnel complet (format image/PDF)  
- Légende expliquant les choix de modélisation  

# TD Modélisation BDD : Système de Réservation de Salles

## **📝 Cahier des Charges (Client : Ville de Rouen)**
**Contexte :**  
La mairie de Rouen souhaite une application pour gérer la réservation des salles communales.  
---

## **🎯 Objectifs du TD**
1. Modéliser la base de données  
2. Peupler avec des données réalistes  
3. Écrire des requêtes analytiques  

---

## **📌 Étape 1 : Modélisation**
### **Tables à créer**
- En reprenant le schéma créée lors du **TD Conception BDD : Système de Réservation de Salles**, modélisez les tables
dans votre base de données nouvellement créée.

### **Consignes**
- Créez une base de données UTF-8 nommé **bdd-communal-rooms-booking** (en français base de données de réservations de salle communautaire)
- Utilisez des clés primaires
- Utilisez des clés étrangères pour les relations  
- Prévoyez des valeurs par défaut pour les champs pertinents  

---

## **📌 Étape 2 : Peuplement**
### **Données minimales à insérer**
> #### **Note** : Tous éléments non renseigné sont à remplir avec les valeurs de votre choix
1. **Bâtiments**  
   - Mairie (5 étages)  
   - Centre culturel (2 étage)  
   - Musée des beaux arts (2 étages)
   - Kindarena (1 étage) 
2. **Salles** 
   - Salle des fêtes (120 pers, bâtiment 1)  
   - Salle polyvalente (50 pers, bâtiment 2)
   - Salle 1645A (15 pers, bâtiment 3)
   - Salle 1645B (15 pers, bâtiment 3)
   - Salle 1645C (15 pers, bâtiment 3)
   - Salle principale (800 pers, bâtiment 4)
3. **Utilisateurs**  
   - 1 administrateur  
   - 7 utilisateurs normaux  
4. **Réservations**  
   - 6 réservations confirmées  
   - 2 demande en attente
   - exemple :
   ```
   | room_id  | user_id        | Début            | Durée | Statut      |
   |----------|----------------|------------------|-------|-------------|
   | 1        | 2              | 2023-11-01 14:00 | 120   | confirmé    |
   | 2        | 2              | 2023-11-02 09:00 | 60    | en attente  |
   ```

### **Méthodologie**  
1. Insérez d'abord les bâtiments  
2. Puis les salles (en référençant les bâtiments)  
3. Enfin les réservations  

---

## **📌 Étape 3 : Requêtes**
### **Niveau 1 - Sélections**  
1. Lister toutes les salles de plus de 50 places  
   *Critère : utiliser un opérateur de comparaison*  

2. Afficher les réservations des 7 derniers jours  
   *Indice : fonction de date*  

### **Niveau 2 - Agrégats**  
3. Nombre de réservations par salle (afficher nom salle)  
   *Méthode : GROUP BY + COUNT*  

4. Capacité moyenne des salles par bâtiment  
   *Astuce : jointure + AVG*  

### **Niveau 3 - Jointures**  
5. Salle la plus réservée 
6. Salles jamais réservées  
   *Clé : LEFT JOIN + IS NULL*  

---

## **✅ Validation**  
1. Essayez de supprimer un bâtiment avec des salles → Que se passe-t-il ?  
2. Testez l'insertion d'une réservation avec une salle inexistante  

### Critères de Réussite
- ✅ Nommage cohérent (`snake_case`, anglais)
- ✅ Respecter les normes de nommage vu dans le support
- ✅ Relations correctement typées
- ✅ Absence de redondance

---

## **📤 Livrables Attendus**  
1. Script SQL complet (création + insertion + requêtes)  
2. Capture des résultats des 6 requêtes principales  


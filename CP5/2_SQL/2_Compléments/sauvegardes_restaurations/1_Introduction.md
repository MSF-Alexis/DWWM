
## Module 1 – Introduction à la sauvegarde et restauration sous MariaDB

### Objectifs pédagogiques

- Comprendre les enjeux de la sauvegarde et de la restauration en environnement de développement web.
- Identifier les risques liés à la perte de données et l’importance de la résilience informatique.
- Découvrir les bonnes pratiques pour sécuriser et planifier les sauvegardes dans un contexte professionnel.


### 1. Pourquoi sauvegarder une base de données ?

#### Enjeux principaux

- **Prévenir la perte de données** : pannes matérielles, erreurs humaines, attaques malveillantes.
- **Assurer la continuité de service** : minimiser les interruptions et garantir la disponibilité des applications web.
- **Respecter la réglementation** : conformité RGPD, exigences légales sur la conservation des données.
- **Faciliter la reprise après incident** : restaurer rapidement un service après un problème.


#### Exemples de situations à risque

- Suppression accidentelle de tables ou de bases.
- Corruption de fichiers suite à un crash serveur.
- Infection par un ransomware ou attaque externe.


### 2. Les risques en cas d’absence de sauvegarde

| Risque | Conséquence possible |
| :-- | :-- |
| Panne matérielle | Perte totale des données |
| Erreur de manipulation | Suppression ou modification irréversible |
| Cyberattaque (ransomware, etc.) | Chiffrement ou vol de données |
| Corruption logique (bug, etc.) | Incohérence ou perte partielle |

### 3. Définitions clés

- **Sauvegarde (backup)** : copie des données à un instant T, stockée séparément du système principal.
- **Restauration (restore)** : opération permettant de remettre les données dans leur état sauvegardé.
- **RTO (Recovery Time Objective)** : durée maximale acceptable pour restaurer un service après incident.
- **RPO (Recovery Point Objective)** : quantité maximale de données (en temps) pouvant être perdue après un incident.


### 4. Bonnes pratiques de sauvegarde

- **Planifier la fréquence** des sauvegardes selon le contexte (quotidien, hebdomadaire, etc.).
- **Stocker les sauvegardes sur un support externe** (autre serveur, cloud, disque amovible).
- **Vérifier régulièrement l’intégrité** des sauvegardes (tests de restauration).
- **Automatiser les procédures** pour éviter les oublis.
- **Sécuriser l’accès** aux fichiers de sauvegarde (droits, chiffrement).
- **Documenter les procédures** pour garantir la reproductibilité.


### 5. Quiz interactif (exemples de questions)

1. Pourquoi la sauvegarde est-elle indispensable dans le développement web ?
2. Quelles sont les conséquences d’une attaque ransomware sur une base non sauvegardée ?
3. Que signifient les acronymes RTO et RPO ?
4. Citez deux bonnes pratiques pour sécuriser ses sauvegardes.

### 6. Ressources complémentaires

- Extraits de la documentation officielle MariaDB sur la sauvegarde/restauration.
- Guides ANSSI sur la sécurité des bases de données.
- Fiches mémo : checklists des étapes de sauvegarde et restauration.


### 7. Synthèse et points d’attention

- La sauvegarde n’est pas une option, mais une nécessité pour tout projet professionnel.
- La restauration doit être testée régulièrement pour garantir l’efficacité du plan de sauvegarde.
- Toute procédure doit être adaptée au contexte réel de l’entreprise et documentée pour être transférable.

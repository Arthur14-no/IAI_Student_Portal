# IAI_Student_Portal

Projet PHP de gestions des etudaints de IAI.

## Fonctionnalités actuelles (v1-push, v2-PDO)
- Ajouter un etudiant
- afficher la lieste des admis et echoues
- **Dashboard dynamique :** Total, Admis, Échoués, Taux de réussite, Moyenne générale
- **CRUD complet :** Ajout étudiant en base MySQL avec PDO
- **Gestion Filières :** G.L (Génie Logiciel), S.R (Réseaux), S.E (Systèmes Embarqués)
- **Recherche instantanée :** Par Nom / Prénom
- **Listes intelligentes :** Page Admis / Échoués séparées
- **Tri :** Par mentions et moyennes (2>1)
- **Modèle POO :** Classe `Etudiant` avec `match()` PHP 8 pour le calcul de mention (Excellent, Très Bien, Bien, Assez Bien, Échec)

## Technologies:
- PHP/Mysql (PDO)
- Composer
- MVC fait maison (Controllers / Models / Views / config/Database.php)
- HTML / CSS (des codes generer pour la v2)
- Git / GitHub

## Installation
1. Cloner le dépôt : `git clone https://github.com/Arthur14-no/IAI_Student_Portal.git`
2. Placer dans `C:/wamp64/www/IAI_Student_Portal`
3. Importer la BD `iai_portal.sql` dans phpMyAdmin
4. Configurer `src/config/Database.php`
5. Lancer avec Wamp : `localhost/IAI_Student_Portal/`


--------
--------  
--------  
--------  
--------

By @A14-###_ DRAKATORZE #/# Arthur14-no.
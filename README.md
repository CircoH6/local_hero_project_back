 Local_Heroes_Project

Local Heroes est une API permettant aux utilisateurs d’ajouter, noter et recommander des prestataires locaux.
Le projet utilise Laravel 12, MySQL et Laravel Passport pour gérer l’authentification API.

---
Fonctionnalités principales

* Inscription et connexion des utilisateurs via API (Laravel Passport).
* Ajout, consultation, modification et suppression de prestataires.
* Système d’avis avec note (1 à 5) et commentaire.
* Recalcul automatique de la note moyenne du prestataire.
* Gestion des recommandations.
* Sécurisation de toutes les routes (sauf register et login) via middleware auth:api.

---

Installation du projet

1. Cloner le dépôt :

git clone https://github.com/TON_GITHUB/local-heroes-backend.git
cd local-heroes-backend

2. Installer les dépendances :

composer install

3. Copier le fichier d’environnement :

cp .env.example .env

4. Configurer MySQL dans .env :

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=local_heroes_db
DB_USERNAME=root
DB_PASSWORD=

5. Générer la clé de l’application :

php artisan key:generate

6. Installer Passport :

php artisan passport:install

7. Lancer les migrations :

php artisan migrate

8. Démarrer le serveur local :

php artisan serve

---
Authentification (API Token)

L’API utilise Laravel Passport.
Pour accéder aux endpoints protégés :

1. Appeler /api/login
2. Récupérer le access_token
3. L’ajouter dans Postman dans le header :

Authorization: Bearer VOTRE_TOKEN

---

Routes de l’API

### Authentification

* POST /api/register → inscription utilisateur
* POST /api/login → connexion et obtention du token

### Prestataires

* GET /api/prestataires/index
* POST /api/prestataires/store
* GET /api/prestataires/show/{id}
* PUT /api/prestataires/update/{id}
* DELETE /api/prestataires/destroy/{id}

### Avis

* GET /api/avis/index
* POST /api/avis/store/{id} (id = id du prestataire)
* GET /api/avis/show/{id}
* DELETE /api/avis/destroy/{id}

### Recommandations

* GET /api/recommandations/index
* POST /api/recommandations/store
* DELETE /api/recommandations/destroy/{id}

Tous ces endpoints nécessitent un token sauf register & login.

---

Utilisation avec Postman (simple)

1. Faire un **POST** sur /api/register pour créer un utilisateur.
2. Faire un **POST** sur /api/login pour obtenir un token.
3. Mettre ce token dans les Headers :

Authorization: Bearer VOTRE_TOKEN

4. Tester toutes les autres routes librement.

---

Notes importantes

* Seul l’utilisateur ayant créé un prestataire peut le modifier ou le supprimer.
* Même principe pour les avis.
* La note moyenne se met automatiquement à jour après chaque nouvel avis.
* L’API est entièrement RESTful et structurée pour être utilisée par un front-end comme Vue.js.

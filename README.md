# Local_Heroes_Project

**Local Heroes** est une plateforme qui permet aux utilisateurs de noter et recommander des artisans locaux. Les artisans (prestataires) sont ajoutés uniquement par les utilisateurs. Chaque utilisateur peut laisser un avis et une note après avoir ajouté un prestataire.

---

## 🚀 Fonctionnalités

* Authentification utilisateur (register / login) via API avec Laravel Passport
* CRUD pour les **prestataires** : ajouter, consulter, modifier, supprimer
* CRUD pour les **avis** : ajouter un avis et une note, consulter, supprimer
* Gestion des **recommandations** des prestataires
* Calcul automatique de la **note moyenne** des prestataires

---

## 🛠 Technologies utilisées

* **Backend** : Laravel 12
* **Base de données** : MySQL
* **Authentification API** : Laravel Passport

---

## 📦 Installation

1. Cloner le projet :

git clone https://github.com/TON_USERNAME/local-heroes-backend.git
cd local-heroes-backend

2. Installer les dépendances Composer :

composer install

3. Copier le fichier .env :

cp .env.example .env

4. Configurer les variables de la base de données dans .env :

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=local_heroes_db
DB_USERNAME=root
DB_PASSWORD=

5. Générer la clé d’application :

php artisan key:generate

6. Installer Laravel Passport :

php artisan passport:install

7. Lancer les migrations :

php artisan migrate

8. Démarrer le serveur local :

php artisan serve

---

## 📡 Routes API principales

### Authentification

| Route       | Méthode | Description                 |
| ----------- | ------- | --------------------------- |
| /register   | POST    | Créer un compte utilisateur |
| /login      | POST    | Se connecter                |

### Prestataires

| Route                        | Méthode | Description                  |
| ---------------------------- | ------- | ---------------------------- |
| /prestataires/index          | GET     | Lister tous les prestataires |
| /prestataires/store          | POST    | Ajouter un prestataire       |
| /prestataires/show/{id}      | GET     | Voir un prestataire          |
| /prestataires/update/{id}    | PUT     | Mettre à jour un prestataire |
| /prestataires/destroy/{id}   | DELETE  | Supprimer un prestataire     |

### Avis

| Route                | Méthode | Description                         |
| -------------------- | ------- | ----------------------------------- |
| /avis/index          | GET     | Lister tous les avis                |
| /avis/store/{id}     | POST    | Ajouter un avis pour un prestataire |
| /avis/show/{id}      | GET     | Voir un avis spécifique             |
| /avis/destroy/{id}   | DELETE  | Supprimer un avis                   |

### Recommandations

| Route                           | Méthode | Description                  |
| ------------------------------- | ------- | ---------------------------- |
| /recommandations/index          | GET     | Lister les recommandations   |
| /recommandations/store          | POST    | Ajouter une recommandation   |
| /recommandations/destroy/{id}   | DELETE  | Supprimer une recommandation |

> ⚠️ Toutes les routes sauf /register et /login nécessitent un token Bearer valide.

---

## 🔑 Authentification avec Postman

1. Créer un compte (/register)
2. Se connecter (/login) → récupérer le access_token
3. Ajouter un header Authorization: Bearer <access_token> sur toutes les autres requêtes

---

## 💡 Notes

* Les avis mettent automatiquement à jour la note moyenne du prestataire.
* Les utilisateurs ne peuvent modifier ou supprimer que les prestataires et avis qu’ils ont créés.

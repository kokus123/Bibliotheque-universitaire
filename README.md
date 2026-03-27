# 📚 BIBLIOGES — Bibliothèque Universitaire

<p align="center">
  <img src="public/images/logo.jpg" width="120" alt="Biblioges Logo">
</p>

<p align="center">
  <strong>Système de gestion de bibliothèque universitaire</strong><br>
  Développé avec Laravel 12 · SQLite · Bootstrap Icons
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/SQLite-003B57?style=flat&logo=sqlite&logoColor=white" alt="SQLite">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat" alt="License">
</p>

---

## 📖 Présentation

**BIBLIOGES** est une application web de gestion de bibliothèque universitaire permettant de gérer les livres, les emprunts, les retours et les notifications de retard. Elle offre une interface moderne avec support du mode sombre.

---

## ✨ Fonctionnalités

- 📚 **Catalogue de livres** — Ajout, modification, suppression et recherche de livres
- 🔄 **Gestion des emprunts** — Enregistrement et suivi des emprunts en temps réel
- ✅ **Retours** — Validation des retours avec mise à jour automatique des stocks
- 🔔 **Notifications de retard** — Envoi automatique de notifications aux étudiants en retard
- 👥 **Gestion des utilisateurs** — Trois rôles : Admin, Bibliothécaire, Étudiant
- 🌙 **Dark / Light mode** — Thème mémorisé dans le navigateur
- 📊 **Tableau de bord** — Statistiques en temps réel

---

## 🔑 Rôles et permissions

| Action | Étudiant | Bibliothécaire | Admin |
|--------|:--------:|:--------------:|:-----:|
| Voir le catalogue | ✅ | ✅ | ✅ |
| Voir ses emprunts | ✅ | ✅ | ✅ |
| Ajouter/modifier un livre | ❌ | ✅ | ✅ |
| Enregistrer un emprunt | ❌ | ✅ | ✅ |
| Valider un retour | ❌ | ✅ | ✅ |
| Gérer les utilisateurs | ❌ | ✅ | ✅ |
| Envoyer notifications retard | ❌ | ✅ | ✅ |

---

## 🚀 Installation

### Prérequis
- PHP >= 8.2
- Composer
- Node.js & NPM

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/votre-username/biblioges.git
cd biblioges

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances Node
npm install && npm run build

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
DB_CONNECTION=sqlite

# 6. Créer le fichier SQLite
touch database/database.sqlite

# 7. Lancer les migrations et seeders
php artisan migrate --seed

# 8. Créer le lien symbolique pour les images
php artisan storage:link

# 9. Démarrer le serveur
php artisan serve
```

Ouvre **http://localhost:8000** dans ton navigateur.

---

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Administrateur | admin@bibliotheque.cm | password |
| Bibliothécaire | jean@bibliotheque.cm | password |
| Étudiant | alice@univ.cm | password |
| Étudiant | paul@univ.cm | password |

---

## 🛠️ Stack technique

| Technologie | Usage |
|------------|-------|
| Laravel 12 | Framework PHP |
| SQLite | Base de données |
| Laravel Breeze | Authentification |
| Bootstrap Icons | Icônes |
| Google Fonts | Typographie (Cormorant + Inter) |
| Vite | Compilation des assets |

---

## 📁 Structure du projet

```
app/
├── Http/Controllers/
│   ├── BookController.php
│   ├── BorrowController.php
│   ├── UserController.php
│   └── DashboardController.php
├── Models/
│   ├── Book.php
│   ├── Borrow.php
│   └── User.php
└── Notifications/
    └── RetardNotification.php

database/
├── migrations/
└── seeders/
    └── DatabaseSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── books/
├── borrows/
└── users/
```

---

## 📋 Routes principales

```
GET    /                          → Catalogue public
GET    /dashboard                 → Tableau de bord
GET    /books                     → Liste des livres
POST   /books                     → Créer un livre
GET    /books/{id}                → Détail d'un livre
PUT    /books/{id}                → Modifier un livre
DELETE /books/{id}                → Supprimer un livre
GET    /borrows                   → Liste des emprunts
POST   /borrows                   → Nouvel emprunt
PATCH  /borrows/{id}/retourner    → Retourner un livre
POST   /borrows/notifications-retard → Envoyer notifications
GET    /users                     → Liste des utilisateurs
```

---

## 👨‍💻 Auteur

 KOOKO CHARLES MIGUEL GL3B

---

## 📄 Licence

Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).

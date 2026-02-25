# Instructions d'installation et déploiement

Application Laravel professionnelle avec authentification, rôles (admin/utilisateur), CRUD complet et tableau de bord administrateur.

## Prérequis

- PHP 8.2+
- Composer
- MySQL 8.0+ (ou MariaDB)
- Extension PHP : pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo

## Installation

### 1. Cloner / copier le projet

```bash
cd c:\Users\hammouchi\OneDrive\Desktop\pr
```

### 2. Dépendances PHP

```bash
composer install
```

### 3. Configuration environnement

```bash
copy .env.example .env
php artisan key:generate
```

Éditer `.env` et configurer la base de données MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
APP_URL=http://localhost:8000
```

### 4. Base de données

Créer la base MySQL (ex. via phpMyAdmin ou ligne de commande) :

```sql
CREATE DATABASE nom_de_votre_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Puis exécuter les migrations :

```bash
php artisan migrate
```

### 5. Données de test (optionnel)

```bash
php artisan db:seed
```

Cela crée notamment :
- **Admin** : email `admin@example.com` / mot de passe `password`
- **Utilisateur** : email `user@example.com` / mot de passe `password`
- Catégories, produits et services de démonstration

### 6. Lien symbolique pour les uploads

Pour que les images uploadées (catégories, produits, services) soient accessibles :

```bash
php artisan storage:link
```

### 7. Lancer le serveur de développement

```bash
php artisan serve
```

Ouvrir dans le navigateur : **http://localhost:8000**

- **Page d'accueil** : contenu public (catégories, produits à la une, services).
- **Connexion** : `/login` — après connexion, un admin est redirigé vers `/admin`.
- **Inscription** : `/register`.
- **Réinitialisation mot de passe** : `/forgot-password` (nécessite une configuration mail dans `.env` pour l’envoi des emails).

## Déploiement en production

1. **Environnement**
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL` = l’URL réelle du site

2. **Optimisations**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Sécurité**
   - Changer les mots de passe des comptes de test.
   - Utiliser HTTPS.
   - Vérifier les permissions des dossiers (`storage`, `bootstrap/cache` en écriture).

4. **Emails (réinitialisation mot de passe)**  
   Configurer `MAIL_*` dans `.env` (SMTP, Mailgun, etc.) pour que les liens de réinitialisation soient envoyés.

## Structure des rôles

- **user** : accès au site et à son compte.
- **admin** : accès au tableau de bord `/admin`, gestion des utilisateurs, catégories, produits et services.

## Routes principales

| Route           | Description                |
|----------------|----------------------------|
| `/`            | Accueil                    |
| `/login`       | Connexion                  |
| `/register`    | Inscription                |
| `/admin`       | Tableau de bord admin      |
| `/admin/users` | Gestion utilisateurs       |
| `/admin/categories` | Gestion catégories  |
| `/admin/products`   | Gestion produits    |
| `/admin/services`   | Gestion services    |

## Dépannage

- **Erreur 500** : vérifier `storage/logs/laravel.log`, permissions `storage` et `bootstrap/cache`.
- **Images non affichées** : exécuter `php artisan storage:link`.
- **CSRF token mismatch** : vider le cache navigateur / cookies ou vérifier `SESSION_DOMAIN` et `APP_URL`.

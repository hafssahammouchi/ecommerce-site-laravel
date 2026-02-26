# Déployer Laravel sur Render (Docker + base de données)

Ce projet est prêt pour un déploiement sur [Render](https://render.com) en **Web Service Docker** avec une base de données.

---

## 1. Prérequis

- Un dépôt GitHub contenant ce projet (voir section 6 pour pousser le code).
- Un compte Render.

---

## 2. Créer la base de données sur Render

1. Sur [Render Dashboard](https://dashboard.render.com) → **New +** → **PostgreSQL** (ou **MySQL** si disponible dans votre plan).
2. Donnez un nom au service (ex. `glowbeauty-db`).
3. Une fois créée, Render affiche les informations de connexion :
   - **Internal Database URL** (ou host, port, database, user, password).
   - Notez-les pour la section 4.

> **Remarque :** Le Dockerfile inclut `pdo_mysql` et `pdo_pgsql`. Vous pouvez utiliser soit une base **MySQL** (ex. add-on ou externe), soit la base **PostgreSQL** native Render en mettant `DB_CONNECTION=pgsql` et les variables `DB_*` fournies par Render.

---

## 3. Créer le Web Service sur Render

1. **New +** → **Web Service**.
2. Connectez votre dépôt GitHub et sélectionnez le dépôt de ce projet.
3. Configurez :
   - **Name :** par ex. `glowbeauty` ou `ecommerce-laravel`.
   - **Region :** celui de votre choix.
   - **Branch :** `main` (ou la branche à déployer).
   - **Runtime :** **Docker**.
   - Render détecte le `Dockerfile` à la racine.
4. Ne cliquez pas encore sur **Create Web Service** : ajoutez d’abord les variables d’environnement (étape 4).

---

## 4. Variables d’environnement (.env sur Render)

Dans le Web Service → onglet **Environment**, ajoutez les variables suivantes.  
Elles remplacent le fichier `.env` en production.

### Obligatoires

| Variable      | Valeur / comment obtenir |
|---------------|---------------------------|
| `APP_KEY`     | Générer avec : `php artisan key:generate --show` (voir section 5). |
| `APP_ENV`     | `production` |
| `APP_DEBUG`   | `false` |
| `APP_URL`     | L’URL du site après déploiement, ex. `https://votre-service.onrender.com` (sans slash final). |

### Base de données (MySQL ou PostgreSQL)

Renseignez les valeurs fournies par Render pour votre base (host, port, database, user, password) :

| Variable        | Exemple / description |
|-----------------|------------------------|
| `DB_CONNECTION` | `mysql` ou `pgsql` (PostgreSQL natif Render). |
| `DB_HOST`       | Host fourni par Render (souvent un hostname interne). |
| `DB_PORT`       | `3306` (MySQL) ou `5432` (PostgreSQL). |
| `DB_DATABASE`   | Nom de la base. |
| `DB_USERNAME`   | Utilisateur de la base. |
| `DB_PASSWORD`   | Mot de passe de la base. |

### Optionnel (recommandé en prod)

| Variable           | Valeur recommandée |
|--------------------|--------------------|
| `LOG_CHANNEL`      | `stderr` |
| `SESSION_DRIVER`   | `database` (ou `file` si pas de table sessions). |
| `CACHE_STORE`      | `database` ou `file` |
| `QUEUE_CONNECTION` | `database` ou `sync` |

Une fois toutes les variables renseignées, enregistrez puis cliquez sur **Create Web Service**.

---

## 5. Générer `APP_KEY`

Sur votre machine, dans le dossier du projet :

```powershell
cd "C:\Users\hammouchi\OneDrive\Desktop\pr"
php artisan key:generate --show
```

Copiez la sortie (ex. `base64:xxxx...`) et collez-la dans la variable **APP_KEY** sur Render (section 4).

---

## 6. Pousser le projet sur GitHub

Si le projet n’est pas encore sur GitHub :

```powershell
cd "C:\Users\hammouchi\OneDrive\Desktop\pr"

# Initialiser Git si ce n’est pas déjà fait
git init

# Ajouter le dépôt distant (remplacez par l’URL de VOTRE dépôt)
git remote add origin https://github.com/VOTRE_UTILISATEUR/VOTRE_REPO.git

# Ajouter tous les fichiers, committer, pousser
git add .
git commit -m "Laravel ready for Render with DB"
git branch -M main
git push -u origin main
```

Si le dépôt existe déjà et que vous avez seulement ajouté le Dockerfile et la doc :

```powershell
git add .
git commit -m "Laravel ready for Render with DB"
git push origin main
```

---

## 7. Déploiement

- Dès que vous avez créé le Web Service avec les variables (étape 4), Render lance un **build** puis un **deploy**.
- Le **Dockerfile** :
  - installe PHP 8.2, Apache, les extensions `pdo`, `pdo_mysql`, `zip`, active `mod_rewrite`,
  - copie l’app dans `/var/www/html`, racine web = `public`,
  - exécute `composer install --no-dev`,
  - au démarrage du container : migrations, `config:cache`, puis Apache qui écoute sur la variable **PORT** fournie par Render.

Une fois le déploiement vert, votre site est accessible à l’URL du service (ex. `https://votre-service.onrender.com`). Vous pouvez tester **connexion, inscription, commandes et GPS** avec votre client.

---

## 8. Résumé des fichiers ajoutés pour Render

| Fichier | Rôle |
|---------|------|
| `Dockerfile` | Image PHP 8.2 + Apache, extensions, Composer, racine `public`. |
| `docker/000-default.conf` | Vhost Apache (DocumentRoot = `public`, AllowOverride). |
| `docker/render-entrypoint.sh` | Démarrage : écoute sur `PORT`, migrations, cache, Apache. |
| `.dockerignore` | Exclut `.git`, `node_modules`, `.env`, etc. du build. |
| `RENDER.md` | Ce guide. |

---

## 9. Mettre à jour `.env` en local (optionnel)

Pour faire pointer votre `.env` local vers la base Render (tests, debug), vous pouvez copier les mêmes variables que sur Render :

- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`  
avec les valeurs **externes** (External Database URL / host) si vous vous connectez depuis votre PC.  
En production, le Web Service utilise l’**Internal** URL pour parler à la base sur le même réseau Render.
